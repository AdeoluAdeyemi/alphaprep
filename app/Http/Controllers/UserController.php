<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function index()
    {
        // return view('backend.users.index',[
        //     'users' => User::get()
        // ]);

        return Inertia::render('Users/Index', [
            'users' => User::get()
        ]);
    }

    public function pay(Request $request)
    {

        // Add Validation Here.


        //$user=auth()->user();
        //$request->user()->createOrGetStripeCustomer();

        // make a purchase
        $user = User::firstOrCreate(
            [
                'email' => $request->input('email')
            ],
            [
                'password' => Hash::make(Str::random(12)),
                'name' => $request->input('first_name'). ' '. $request->input('last_name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('zip_code'),
                'country' => $request->input('country')
            ]
            );

            Log::info('User \'s details');
            Log::info($user);
            Log::info($user->id);

            Log::info('User \'s details from request');
            Log::info($request->user());

            Log::info('Request Details');
            Log::info($request);
            Log::info($request->input('automatic_payment_methods[enabled]'));
            Log::info($request->input('automatic_payment_methods[allow_redirects]'));


            try {
                $payment = $request->user()->charge( //$user->charge(
                    $request->input('amount'),
                    $request->input('payment_method_id'),
                    [
                        'confirmation_method' => 'manual',
                        //'return_url' => route('order.summary'), // "http://localhost/summary",
                        //'automatic_payment_methods[enabled]' => $request->input('automatic_payment_methods[enabled]'),
                        //'automatic_payment_methods[allow_redirects]' => $request->input('automatic_payment_methods[allow_redirects]')
                    ]
                );



                $payment = $payment->asStripePaymentIntent();

                Log::info('Details of Payment Intent');
                Log::info($payment);

                Log::info('I got here after completing payment');

                // Check if payment is successful

                if($payment->status == 'succeeded')
                {
                    // Handle successful payment

                    Log::info('I got here before storing the order');
                    $order = $request->user()->orders()
                        ->create([
                            'transaction_id' => $payment->charges->data[0]->id,
                            'total' => $payment->charges->data[0]->amount
                        ]);

                        Log::info('I successfully created an order');

                    foreach (json_decode($request->input('cart'), true) as $item)
                    {
                        $order->products()
                            ->attach($item['id'],['quantity' => $item['quantity']]);
                    }

                    Log::info('I got here after creating order products');

                    $order->load('products');

                    Log::info('I got here after completing payment and order');

                }
                else{
                    // Handle failed or incomplete payment
                    // Catch block would throw the error
                }

                // Redirect the user or display a view with the payment result


                //return $order;
                // return Inertia::render('Frontend/Order/Summary', [
                //     'orders' => $order
                // ]);
            }
            catch(\Exception $e){ //TODO: Handle all possible statuses of the payment failure response. Statuses are 'succeeded', 'requires_action', 'processing', and 'requires_payment_method'

                //return response()->json(['message' => $e->getMessage()], 500);
                return back()->withError('There was a problem processing your payment. \n' . $e->getMessage());
            }
    }
}
