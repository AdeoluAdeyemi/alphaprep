<?php

namespace App\Http\Services;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class JiraServiceDeskIntegration
{
    private string $jira_auth;
    private $headers = [];

    public function initJiraRequest()
    {
        // Send Jira Service Desk API request to create new customer request
        $jira_api_token = config('app.jiraKey');

        // Create Jira authorization header
        $this->jira_auth = base64_encode("hello@hostvision.ng:".$jira_api_token);

        // Create header
        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $this->jira_auth
        ];
    }

    public function createJiraTicket($title, $message, $priority) //
    {
        $this->initJiraRequest();

        $jira_url = config('app.jiraUrl');

        // Define the request parameters
        $params = [
            'projectKey' => 'EX',
            'requestTypeId' => 8,
            'serviceDeskId' => 2
        ];

        // Construct Jira Service Desk API request payload
        $payload = [
            'serviceDeskId' => $params['serviceDeskId'],
            'requestTypeId' => $params['requestTypeId'],
            'requestFieldValues' => [
                'summary' => $title,
                'description' => strip_tags($message)
            ]
            //'requestParticipants' => [['id' => $jira_customer_id]]
        ];

        try {
            // Basic authentication...
            $response = Http::withHeaders($this->headers)->post($jira_url.'/rest/servicedeskapi/request', $payload);

            //return [$response->json()['issueId'], $response->json()['issueKey']];

            return $response->status() >= 200 && $response->status() < 300 ? [$response->json()['issueId'], $response->json()['issueKey']] : 'failed';


        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createJiraCustomer($user)
    {
        // POST /rest/servicedeskapi/customer - Create customer
        $this->initJiraRequest();

        $jira_url = config('app.jiraUrl');
        Log::info('I got here 99');
        Log::info($user);

        if (gettype($user) == 'string'){
            $user = json_decode($user);
        }

        // Construct Jira Service Desk API request payload
        $payload = [
            'email' => $user->email,
            'fullName' => $user->name,
        ];

        try {
            // Basic authentication...
            $response = Http::withHeaders($this->headers)->post($jira_url.'/rest/servicedeskapi/customer', $payload);

            return $response->status() >= 200 && $response->status() < 300 ? $response->json()['key'] : false;


        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function addJiraCustomerToServiceDesk($user, $username)
    {

        // POST /rest/servicedeskapi/servicedesk/{serviceDeskId}/customer - Add to ServiceDesk
        $this->initJiraRequest();

        $jira_url = config('app.jiraUrl');

        // Define the request parameters
        $params = [
            'requestTypeId' => 8,
        ];

        // Construct Jira Service Desk API request payload
        $payload = [
            'usernames' => [ $username ]
        ];

        try {
            // Basic authentication...
            $response = Http::withHeaders($this->headers)->post($jira_url.'/rest/servicedeskapi/servicedesk/'.$params['serviceDeskId'] .'/customer', $payload);

            return $response->status() >= 200 && $response->status() < 300 ? $response->json()['size'] : false;


        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function AddCommentToJiraTicket($comment, $ticket_id)
    {
        // POST /rest/servicedeskapi/request/{issueIdOrKey}/comment
        $this->initJiraRequest();

        $jira_url = config('app.jiraUrl');

        // Construct Jira Service Desk API request payload
        $payload = [
            'body' => $comment,
            'public' => true,
        ];

        try {
            // Basic authentication...
            $response = Http::withHeaders($this->headers)->post($jira_url.'/rest/servicedeskapi/request/'.$ticket_id.'/comment', $payload);

            return $response->status() >= 200 && $response->status() < 300 ? $response->json()['author']['active'] : false;


        } catch (Exception $exception) {
            return $exception;
        }

    }

    public function getTicketStatus(Request $request) // Validate request
    {
        $status = '';
        $issue_key = '';
        $date = '';

        if($request->isMethod('POST'))
        {
            $status = $request->status;
            $issue_key = $request->issue_key;
            $date = $request->date;
        }
        else {
            return 'Invalid request error';
        }

        return [$status, $issue_key, $date];
    }


    public function getTicketComment(Request $request) // Validate request
    {
        $comment = '';
        $issue_key = '';
        $date = '';
        $author = '';

        if($request->isMethod('POST'))
        {
            $comment = $request->comment;
            $issue_key = $request->issue_key;
            $date = $request->date;
            $author = $request->author;
        }
        else {
            return 'Invalid request error';
        }

        return [$comment, $author, $issue_key, $date];
    }
}
