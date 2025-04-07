<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function oochat(Request $request)
    {
        // Send OpenAI API request to create new request
        $openaiApiKey = config('app.openaiApiKey');

        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer '. $openaiApiKey,
            ],
            'json' => [
                'prompt' => $request->input('userMessage'),
                'max_tokens' => 150,
            ],
        ]);

        Log::info($response);

        $data = json_decode($response->getBody(), true);

        Log::info($data);

        return response()->json(['message' => $data['choices'][0]['text']]);
    }

    // public function chat(Request $request)
    // {
    //     Log::info('I got in here');

    //     Log::info('Users message is');

    //     Log::info($request->input('userMessage'));
    //     // Send OpenAI API request to create new request
    //     $openaiApiKey = config('app.openaiApiKey');

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'Authorization' => 'Bearer ' . $openaiApiKey
    //     ])
    //         ->post('https://api.openai.com/v1/chat/completions', [
    //             'model' => 'gpt-4', //gpt-3.5-turbo
    //             'messages' => [
    //                 [
    //                     'role' => 'user',
    //                     'content' => $request->input('userMessage')
    //                 ]
    //             ],
    //             'temperature' => 0,
    //             'max_tokens' => 2048,
    //             'n' => 1
    //         ])->body();


    //     Log::info($response);

    //     return response()->json([
    //         'message' => json_decode($response)->choices[0]->message->content,
    //     ]);
    // }

    public function chat(Request $request)
    {
        // Log the incoming request
        Log::info('I got in here');
        Log::info('Users message is');
        Log::info($request->input('userMessage'));

        // Retrieve or initialize the conversation history from the session
        $conversationHistory = $request->session()->get('conversationHistory', []);

        // Append the user's new message to the conversation history
        $conversationHistory[] = [
            'role' => 'user',
            'content' => $request->input('userMessage')
        ];

        // Send the conversation history to OpenAI
        $openaiApiKey = config('app.openaiApiKey');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $openaiApiKey
        ])
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4', // or 'gpt-3.5-turbo'
                'messages' => $conversationHistory, // Send the entire conversation history
                'temperature' => 0,
                'max_tokens' => 2048,
                'n' => 1
            ])->body();

        // Decode the response
        $responseData = json_decode($response, true);

        // Append the assistant's response to the conversation history
        $conversationHistory[] = [
            'role' => 'assistant',
            'content' => $responseData['choices'][0]['message']['content']
        ];

        // Save the updated conversation history back to the session
        $request->session()->put('conversationHistory', $conversationHistory);

        // Log the response
        Log::info($responseData);

        // Return the assistant's response
        return response()->json([
            'message' => $responseData['choices'][0]['message']['content'],
        ]);
    }
    public function chatDeepSeekAI(Request $request)
    {
        Log::info('I got in here');

        Log::info('Users message is');

        Log::info($request->input('userMessage'));
        // Send OpenAI API request to create new request
        $deepSeekApiKey = config('app.deepSeekApiKey');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $deepSeekApiKey
        ])
            ->post('https://api.deepseek.com/chat/completions', [
                'model' => 'deepseek-chat', //deepseek-reasoner
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $request->input('userMessage')
                    ]
                ],
                'stream' => false
            ])->body();


        Log::info($response);

        return response()->json([
            'message' => json_decode($response)->choices[0]->message->content,
        ]);
    }
}
