<?php

namespace App\Http\Controllers\Frontend;

use Jira;
use Exception;
use App\Models\User;
use Inertia\Inertia;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use App\Http\Services\JiraServiceDeskIntegration;
use Illuminate\Support\Facades\Request as FRequest;

class TicketController extends Controller
{

    // private string $jira_auth;
    // private $headers = [];

    //
    public function create()
    {
        return Inertia::render('Frontend/Support/Tickets/Create',
        [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'csrf_token' => csrf_token(),
            'ticket_categories' => Category::all()
        ]);
    }

    public function index()
    {
        return Inertia::render('Frontend/Support/Tickets/Index', [
            'filters' => FRequest::only(['search']),
            'tickets' => Ticket::where('user_id', Auth::user()->id)
                ->orderBy('updated_at', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($ticket) => [
                    'id' => $ticket->id,
                    'title' => $ticket->title,
                    'status' => $ticket->status,
                    'priority' =>  $ticket->priority,
                    'category' =>  $ticket->categories()->get()->pluck('name','slug')->first(),
                    'last_update' =>  $ticket->updated_at,
                ]) ?? null,
        ]);
    }

    public function store(TicketRequest $request)
    {
        /** @var User */
        $user = Auth::user();

        $ticket_category = $request->category;

        $ticket = $user->tickets()->create($request->except(['name', 'email', 'file', 'category']));

        $category = Category::findOrFail($ticket_category)->first();
        //$label = Label::first();

        $ticket->attachCategories($category);
        //$ticket->attachLabels($label);

        // Check if user is a customer on Jira
        // GET /rest/servicedeskapi/servicedesk/{serviceDeskId}/customer?email=


        // If user is not a customer,
        // Create customer
        $createJiraCustomer = (new JiraServiceDeskIntegration)->createJiraCustomer($user);

        if ($createJiraCustomer == false)
        {
            return back()->with('error','An error occurred! Error creating user on ticketing system.');
        }


        // Add to ServiceDesk
        $addJiraCustomerToSD = (new JiraServiceDeskIntegration)->addJiraCustomerToServiceDesk($user, $createJiraCustomer);

        if ($addJiraCustomerToSD == false)
        {
            return back()->with('error','An error occurred! Error adding user on ticketing system.');
        }


        // Create a Jira Ticket
        $jiraTicket = (new JiraServiceDeskIntegration)->createJiraTicket($request->title, $request->message, $request->priority);

        if ($jiraTicket === 'failed')
        {
            return back()->with('error','Ticket Creation Failed. Try again!');
        }

        $ticket->update([
            'jira_issue_id' => $jiraTicket[0],
            'jira_issue_key' => $jiraTicket[1],
        ]);

        return to_route('myaccount.tickets.edit', $ticket->id)
                ->with('success', __('Your Ticket Was created successfully.'));
    }

    public function edit(Ticket $ticket)
    {
        return Inertia::render('Frontend/Support/Tickets/Edit', [
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'message' => $ticket->message,
                'priority' => $ticket->priority,
                'status' => $ticket->status,
                'created_at' => $ticket->created_at,
                'updated_at' => $ticket->updated_at,
                'jira_issue_id' => $ticket->jira_issue_id,
                'jira_issue_key' => $ticket->jira_issue_key,
            ],
            'csrf_token' => csrf_token(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'category' =>  $ticket->categories()->get()->pluck('name','slug')->first(),
            'messages' =>  $ticket->messages()->orderBy('updated_at', 'desc')->get()->map(fn ($message,) => [
                'message' => $message->message,
                'created_at' => $message->created_at,
            ]),
            'jira_issue_id' => $ticket->jira_issue_id,
            'jira_issue_key' => $ticket->jira_issue_key,
        ]);
    }

    public function update(Ticket $ticket, Request $request)
    {
        // Authorize to update
        //$this->authorize('update', $ticket);

        if (!$request->has('user_type')){
            Auth::check();
        }

        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        //$validatedData = $ticket->validated();

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1500'],
        ]);

        Log::info($request);

        if ($request->has('user_type')){

            //Fetch model for anonymous user
            $anonymousUser = User::findOrFail('9c69dd01-9b76-4f73-94e8-97be47907c9f');

            // Add new message on an existing ticket
            $ticket->messageAsUser($anonymousUser, $request->message);

        }
        else{
            // Add new message on an existing ticket
            $ticket->message($request->message);
        }


        // Add comment to Jira Ticket
        $addCommentToJira = (new JiraServiceDeskIntegration)->AddCommentToJiraTicket(strip_tags($request->message), $ticket->jira_issue_key);

        if ($addCommentToJira == false)
        {
            return back()->with('error','An error occurred! Error adding comment on ticketing system.');
        }

        // $ticket->update($validatedData);

        return back()->with('success','Ticket Updated Successfully');
    }

    public function createLabel()
    {
        // If you create a label seperated from the ticket and wants to
        // associate it to a ticket, you may do the following.
        $label = Label::create('Name of label');

        $ticket = Ticket::findOrFail('ticket_name_here');

        $label->tickets()->attach($ticket);

        // or maybe
        $label->tickets()->detach($ticket);
    }

    public function testIntegration()
    {
        // //dd($client);

        // $result = $client->issues()->search();

        // dd($client->issues()->get(id: 'EX-18', query: [...]));

        // echo $result['issues'][19]['key']; // KEY-1000


        // Set up Jira Service Desk API request parameters
        $jira_api_token = config('app.jiraKey');
        $jira_url = config('app.jiraUrl');


        echo $jira_url;
        print_r('<br/>');
        print_r('<br/>');
        print_r('<br/>');
        print_r('<br/>');

        $jira_customer_id = config('app.jiraCustomerId'); // ID of the Jira Service Desk customer who should be added to the request
        $serviceDeskId = 2; // ID of the Jira Service Desk project


        // Create Jira authorization header
        $jira_auth = base64_encode("hello@hostvision.ng:".$jira_api_token);

        echo $jira_auth;

        $params = [
            'projectKey' => 'EX',
            'requestTypeId' => 8,
            'serviceDeskId' => 2
        ];

        //  /rest/servicedeskapi/servicedesk
        // /rest/servicedeskapi/request
        // /rest/servicedeskapi/servicedesk/{serviceDeskId}
        // /rest/servicedeskapi/servicedesk/{serviceDeskId}/customer
        // /rest/servicedeskapi/request/{issueIdOrKey}/comment
        // /rest/servicedeskapi/request/{issueIdOrKey}/comment
        // /rest/servicedeskapi/customer

        // Construct Jira Service Desk API request payload
        $payload = [
            'serviceDeskId' => $params['serviceDeskId'],
            'requestTypeId' => $params['requestTypeId'],
            'requestFieldValues' => [
                'summary' => 'Test From Laravel',//$title,
                'description' => 'Test Message',//$message
            ]
            //'requestParticipants' => [['id' => $jira_customer_id]]
        ];

        // Send Jira Service Desk API request to create new customer request
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $jira_auth
        ];

        $client = new Client(); // ['base_uri' => $jira_url]

        ///rest/servicedeskapi/request
        //$client->
        $response = $client->post($jira_url, [
            'headers' => $headers,
            'body' => json_encode($payload)
        ]); // https://hostvisionng.atlassian.net/rest/servicedeskapi/request

        if ($response->getStatusCode() == 201) {
            echo 'success'. PHP_EOL;
        } else {
            echo 'failed' . PHP_EOL;
        }

    }

    // public function initJiraRequest()
    // {
    //     // Send Jira Service Desk API request to create new customer request
    //     $jira_api_token = config('app.jiraKey');

    //     // Create Jira authorization header
    //     $this->jira_auth = base64_encode("hello@hostvision.ng:".$jira_api_token);

    //     // Create header
    //     $this->headers = [
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json',
    //         'Authorization' => 'Basic ' . $this->jira_auth
    //     ];
    // }

    // public function createJiraTicket($title, $message, $priority) //
    // {
    //     $this->initJiraRequest();

    //     $jira_url = config('app.jiraUrl');

    //     // Define the request parameters
    //     $params = [
    //         'projectKey' => 'EX',
    //         'requestTypeId' => 8,
    //         'serviceDeskId' => 2
    //     ];

    //     // Construct Jira Service Desk API request payload
    //     $payload = [
    //         'serviceDeskId' => $params['serviceDeskId'],
    //         'requestTypeId' => $params['requestTypeId'],
    //         'requestFieldValues' => [
    //             'summary' => $title,
    //             'description' => strip_tags($message)
    //         ]
    //         //'requestParticipants' => [['id' => $jira_customer_id]]
    //     ];

    //     try {
    //         // Basic authentication...
    //         $response = Http::withHeaders($this->headers)->post($jira_url.'/rest/servicedeskapi/request', $payload);

    //         //return [$response->json()['issueId'], $response->json()['issueKey']];

    //         return $response->status() >= 200 && $response->status() < 300 ? [$response->json()['issueId'], $response->json()['issueKey']] : 'failed';

    //         // Throw an exception if a client or server error occurred...
    //         //return $response->throw();

    //         // Determine if the status code is >= 200 and < 300...
    //         //return $response->successful();

    //         // Determine if the status code is >= 400...
    //         //return $response->failed();

    //     } catch (Exception $exception) {
    //         return $exception;
    //     }
    // }

    // public function createJiraCustomer($user)
    // {
    //     // POST /rest/servicedeskapi/customer - Create customer
    //     $this->initJiraRequest();

    //     $jira_url = config('app.jiraUrl');

    //     // Construct Jira Service Desk API request payload
    //     $payload = [
    //         'email' => $user->email,
    //         'fullName' => $user->name,
    //     ];

    //     try {
    //         // Basic authentication...
    //         $response = Http::withHeaders($this->headers)->post($jira_url.'/rest/servicedeskapi/customer', $payload);

    //         return $response->status() >= 200 && $response->status() < 300 ? $response->json()['key'] : false;


    //     } catch (Exception $exception) {
    //         return $exception;
    //     }
    // }

    // public function addJiraCustomerToServiceDesk($user, $username)
    // {

    //     // POST /rest/servicedeskapi/servicedesk/{serviceDeskId}/customer - Add to ServiceDesk
    //     $this->initJiraRequest();

    //     $jira_url = config('app.jiraUrl');

    //     // Define the request parameters
    //     $params = [
    //         'requestTypeId' => 8,
    //     ];

    //     // Construct Jira Service Desk API request payload
    //     $payload = [
    //         'usernames' => [ $username ]
    //     ];

    //     try {
    //         // Basic authentication...
    //         $response = Http::withHeaders($this->headers)->post($jira_url.'/rest/servicedeskapi/servicedesk/'.$params['serviceDeskId'] .'/customer', $payload);

    //         return $response->status() >= 200 && $response->status() < 300 ? $response->json()['size'] : false;


    //     } catch (Exception $exception) {
    //         return $exception;
    //     }
    // }

    // public function AddCommentToJiraTicket($comment, $ticket_id)
    // {
    //     // POST /rest/servicedeskapi/request/{issueIdOrKey}/comment
    //     $this->initJiraRequest();

    //     $jira_url = config('app.jiraUrl');

    //     // Construct Jira Service Desk API request payload
    //     $payload = [
    //         'body' => $comment,
    //         'public' => true,
    //     ];

    //     try {
    //         // Basic authentication...
    //         $response = Http::withHeaders($this->headers)->post($jira_url.'/rest/servicedeskapi/request/'.$ticket_id.'/comment', $payload);

    //         return $response->status() >= 200 && $response->status() < 300 ? $response->json()['author']['active'] : false;


    //     } catch (Exception $exception) {
    //         return $exception;
    //     }

    // }

    public function updateTicketComment(Request $request)
    {
        $latestComment = (new JiraServiceDeskIntegration)->getTicketComment($request);

        // Fetch ticket collection
        $ticket = Ticket::where('jira_issue_key', $latestComment['issue_key'])->get();

        //Update ticket message
        $ticket->message($latestComment['comment']);
        // Who is the author of the comment/new message?
    }

    public function updateTicketStatus(Request $request)
    {
        $currentStatus = (new JiraServiceDeskIntegration)->getTicketStatus($request);

        // Fetch ticket collection
        $ticket = Ticket::where('jira_issue_key', $currentStatus['issue_key'])->get();

        //Update ticket status
        $ticket->update([
            'status' => $currentStatus['status'],
            'is_resolved' => ($currentStatus == 5) ? 1 : 0
        ]);
    }
}
