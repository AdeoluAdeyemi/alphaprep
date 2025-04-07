<?php

namespace App\Http\Controllers\Frontend;


use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;
use App\Http\Services\JiraServiceDeskIntegration;


class ContactController extends Controller
{
    //
    public function create()
    {
        return Inertia::render('Frontend/Support/Tickets/Create',
        [
            'name' => null,
            'email' => null,
            'csrf_token' => csrf_token(),
            'ticket_categories' => Category::all(),
            'ticket_id' => null,
            'user_type' => 'guest_user'
        ]);
    }


    public function store(TicketRequest $request)
    {
        if (!$request->has('user_type')){
            Auth::check();
        }

        $ticket_category = $request->category;

        // Store ticket as an anonymous user.
        $user = User::findOrFail('9c69dd01-9b76-4f73-94e8-97be47907c9f');

        Log::info($user);

        $ticket = $user->tickets()->create($request->except(['name', 'email', 'file', 'category']));

        $category = Category::findOrFail($ticket_category)->first();
        //$label = Label::first();

        $ticket->attachCategories($category);
        //$ticket->attachLabels($label);

        // Check if user is a customer on Jira
        // GET /rest/servicedeskapi/servicedesk/{serviceDeskId}/customer?email=


        // If user is not a customer,
        // Create customer
        $createJiraCustomer = (new JiraServiceDeskIntegration)->createJiraCustomer(json_encode(['name' => $request->input('name'), 'email' => $request->input('email')]));

        if ($createJiraCustomer == false)
        {
            return back()->with('error','An error occurred! Error creating user on ticketing system.');
        }


        // Add to ServiceDesk
        $addJiraCustomerToSD = (new JiraServiceDeskIntegration)->addJiraCustomerToServiceDesk(json_encode(['name' => $request->input('name'), 'email' => $request->input('email')]), $createJiraCustomer);


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

        // return to_route('contact.edit', $ticket->id)
        //         ->with('success', __('Your Ticket Was created successfully.'));


        // return to_route('contact.viewTicket', $ticket->id);

        return to_route('contact.edit', [$ticket->id, 'guest_user'])
                ->with('success', __('Your Ticket Was created successfully.'));

        // return Inertia::render('Frontend/Support/Ticket/Edit',[
        //     'message' => 'Your ticket has been successfully created. An email has been sent to your address with the ticket information. If you would like to view this ticket now you can do so.',
        //     'status' => 'successful',
        //     'ticket_id' => $ticket->id,
        //     'user_type' => 'guest_user'
        // ]);

        // return back()->with([
        //     'ticket_id' => $ticket->id,
        //     'user_type' => 'guest_user'
        // ]);


    }

    public function edit(Request $request, string $ticket_id, string $user_type)
    {
        Log::info('I got here Edit Contact');
        Log::info($request);
        Log::info($ticket_id);
        Log::info($user_type);

        $ticket = Ticket::findOrFail($ticket_id);

        // if ($request->isMethod('GET') && $user_type == 'guest_user') { // User is an anonymous user  $user->id = '9c69dd01-9b76-4f73-94e8-97be47907c9f'
        //     $ticket = Ticket::findOrFail();
        // }
        // else {
        //     // Do nothing
        // }

        return Inertia::render('Frontend/Support/Tickets/Edit', [
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'message' => $ticket->message,
                'priority' => $ticket->priority,
                'status' => $ticket->status,
                'created_at' => $ticket->created_at,
                'created_at' => $ticket->created_at,
                'created_at' => $ticket->created_at,
                'jira_issue_id' => $ticket->jira_issue_id,
                'jira_issue_key' => $ticket->jira_issue_key,
            ],
            'csrf_token' => csrf_token(),
            'name' => null,
            'email' => null,
            'category' =>  $ticket->categories()->get()->pluck('name','slug')->first(),
            'messages' =>  $ticket->messages()->orderBy('updated_at', 'desc')->get()->map(fn ($message,) => [
                'message' => $message->message,
                'created_at' => $message->created_at,
            ]),
            'jira_issue_id' => $ticket->jira_issue_id,
            'jira_issue_key' => $ticket->jira_issue_key,
            'user_type' => $user_type
        ]);
    }

    //(new TicketController)->method($user->id)

    public function update(Request $request, string $ticket)
    {
        Log::info($request);
        Log::info($ticket);
        $ticketModel = Ticket::findOrFail($ticket);

        (new TicketController)->update($ticketModel, $request);
    }

    public function viewTicket(Request $request, Ticket $ticket)
    {
        return Inertia::render('Frontend/Support/Ticket/View',[
            'message' => 'Your ticket has been successfully created. An email has been sent to your address with the ticket information. If you would like to view this ticket now you can do so.',
            'status' => 'successful',
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'message' => $ticket->message,
                'priority' => $ticket->priority,
                'status' => $ticket->status,
                'created_at' => $ticket->created_at,
                'created_at' => $ticket->created_at,
                'created_at' => $ticket->created_at,
                'jira_issue_id' => $ticket->jira_issue_id,
                'jira_issue_key' => $ticket->jira_issue_key,
            ],
            'csrf_token' => csrf_token(),
            // 'name' => Auth::user()->name,
            // 'email' => Auth::user()->email,
            'category' =>  $ticket->categories()->get()->pluck('name','slug')->first(),
            'messages' =>  $ticket->messages()->orderBy('updated_at', 'desc')->get()->map(fn ($message,) => [
                'message' => $message->message,
                'created_at' => $message->created_at,
            ]),
            'jira_issue_id' => $ticket->jira_issue_id,
            'jira_issue_key' => $ticket->jira_issue_key,
        ]);
    }
}

