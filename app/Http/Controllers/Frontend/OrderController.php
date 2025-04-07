<?php

namespace App\Http\Controllers\Frontend;


use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Frontend\Exam;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Polyfill\Intl\Icu\NumberFormatter;
use App\Notifications\OrderConfirmationNotification;


class OrderController extends Controller
{
    public function index()
    {
        return Product::with('Exams:id,name')->get();
        // return Inertia::render('Frontend/Products/Index', [
        //     'products' => Product::with('exams:id,name')->get(),
        // ]);
    }


    public function cart(Request $request){
        $v = 'en-GB';

        // currency ISO code if exist
        // $currency_iso = NumberFormatter::create(
        //     $v,NumberFormatter::CURRENCY)
        //         ->getTextAttribute(NumberFormatter::CURRENCY_CODE);

        // if no currency ISO code -> 'XXX' is returned,  $currency_iso => ''
        //$currency_iso = ( $currency_iso == 'XXX') ? '' : $currency_iso;

        // currency symbol if exist
        // $currency_symbol = new NumberFormatter( $v, NumberFormatter::DECIMAL );
        // $symbol = $currency_symbol->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

        // if no symbol -> '¤' is returned,  $symbol => ''
        //$symbol = ( $symbol == '¤' ) ? '' : $symbol;
        return Inertia::render('Frontend/Order/Cart', [
            'name' => Auth::user()->name ?? null,
            'email' => Auth::user()->email ?? null,
            'address' => Auth::user()->name ?? null,
            'city' => Auth::user()->city ?? null,
            'state' => Auth::user()->state ?? null,
            'zip_code' => Auth::user()->zip_code ?? null,
            'country' => Auth::user()->country ?? null,

            //'currency_iso' => $currency_iso,
            //'currency_symbol' => $symbol
        ]);
    }


    public function checkout(Request $request){

        // Validate Request.
        Log::info($request);

        if(isset($_COOKIE['current_transaction_id']) || Cookie::has('current_transaction_id'))
        {

            if(Cookie::get('current_transaction_id') != null && Session::has(Cookie::get('current_transaction_id'))){ // Get the current transaction session variable from Session.
                // Delete any existing session variable.
                //Session::remove($request->input('payment_reference'));
                unset($_SESSION[Cookie::get('current_transaction_id')]);
            }

            // Delete any existing exam transaction cookie.
            //Cookie::forget('current_transaction_id');
            //Cookie::queue('current_transaction_id', null, time() - 3600);
            setcookie("current_transaction_id", null, time()-3600, '/');

        }


        try {
            // Add the item to the order.
            $order = Order::firstOrCreate(
                [
                    'transaction_id' => $request->input('payment_reference'),
                ],
                [
                    'user_id' => $request->user()->id,
                    'transaction_id' => $request->input('payment_reference'),
                    'total' => $request->input('amount'),
                    'status' => 'pending' // incomplete payment, cancelled
                ]
            );
            Log::info('order is:');
            Log::info($order->id);

            Log::info('I successfully created an order');

            Log::info('Payment request is: ');
            Log::info($request->input('payment_reference'));

            // Create a cookie variable to hold transaction id
            //Cookie::queue('current_transaction_id', $request->input('payment_reference'), 60);
            setcookie("current_transaction_id", $request->input('payment_reference'), time()+3600);
            //$_COOKIE['current_transaction_id'] = $request->input('payment_reference');


            Log::info(Cookie::get('current_transaction_id'));

            // Create the session array variable to hold the transaciton data.
            //Session::put($request->input('payment_reference'), null);

            foreach (json_decode($request->input('cart'), true) as $item)
            {
                Log::info('Cart item');
                Log::info($item);

                // Add the item's name, and description to a session array variable, exam id, and user id
                // Store the array as the transaction ID

                Session::push($request->input('payment_reference'), [
                    'exam_name' => $item['name'],
                    'exam_description' => $item['description'],
                    'exam_id' => $item['id'],
                    'user_id' => $request->user()->id,
                ]);

                Log::info(Session::get($request->input('payment_reference')));

                $order->products()
                    ->attach($item['id'],['quantity' => $item['quantity']]);
                    //->attach($order->id,['quantity' => $item['quantity']]);
            }

            Log::info('I got here after creating order products');
        } catch (\Exception $e) {
            //throw $th;
            return to_route('order.cart')->with('error','There was a problem processing your payment. Please try again!'. $e->getMessage());

        }

        return Inertia::render('Frontend/Order/Checkout',
        [
            'customer_data' => $request
        ]);
    }

    public function pay(Request $request)
    {
        // Add Validation Here.
        Log::info('I got into the Pay method');

        $user=auth()->user();

        Log::info('User \'s details');
        Log::info($user);
        Log::info($user->id);

        Log::info('User \'s details from request');
        Log::info($request->user());

        Log::info('Request Details');
        Log::info($request);

        $line_items = [];

        foreach (json_decode($request->input('cart'), true) as $item)
        {
            // Get Stripe Price ID

            $exam = Exam::where('slug', $item['slug'])->get();
            Log::info($exam);
            Log::info('Exam Stripe ID');;



            $line_items_item =array(
                "price"=>$item['stripe_price_id'],
                "quantity"=>$item['quantity']
            );

            Log::info('Cart line item on Pay');
            Log::info($line_items_item);

            array_push($line_items, $line_items_item);
        }

        try {

            $stripe = new \Stripe\StripeClient(config('app.stripeSecretKey'));
            header('Content-Type: application/json');

            $stx_ref = $request->input('payment_reference');

            $checkout_session = $stripe->checkout->sessions->create([
                'ui_mode' => 'embedded',
                'line_items' => [
                    $line_items
                ],
                'mode' => 'payment',
                'return_url' => route('order.summary').'?stx_ref='.$stx_ref.'&session_id={CHECKOUT_SESSION_ID}',
                'automatic_tax' => [
                    'enabled' => true,
                ],
            ]);

            Log::info('Checkout Session is');

            Log::info($checkout_session);

            echo json_encode(array('clientSecret' => $checkout_session->client_secret));

        } catch (\Exception $e) {
            return to_route('order.cart')->with('error','There was a problem processing your payment.');
        }
    }

    public function summary(Request $request){
        Log::info($request);
        Log::info($request->has('tx_ref'));
        Log::info($request->has('tx_ref'));
        Log::info($request->has('stx_ref'));

        // Once payment is completed, send notification
        // Fetch the exam details for use in the notification.
        // remove the transaction id session variable.

        $current_transaction_id_cookie = null; // Variable to hold cookie
        $current_transaction = null;

        if(isset($_COOKIE['current_transaction_id']) || Cookie::has('current_transaction_id'))
        {
            $current_transaction_id_cookie = Cookie::get('current_transaction_id');
            //$userName = request()->cookie('user_name');
            //$current_transaction_id_cookie = $_COOKIE['current_transaction_id'];
        }

        if(Session::has($current_transaction_id_cookie)){ // Get the current transaction session variable from Session.
            $current_transaction = Session::get($current_transaction_id_cookie);
        }

        Log::info('Current Trans is: ');
        Log::info($current_transaction);

        // Check if payment is successful // Flutterwave transaction callback
        if($request->has('tx_ref') && $request->has('status') && $request->has('transaction_id')){

            $response = json_decode($this->startFlwSession($request->input('transaction_id')), true);
            Log::info($response);

            $order_amount = Order::where('transaction_id', $response['data']['tx_ref'])->get()->map->only('total')[0]['total'];
            Log::info($order_amount);

            Log::info('Transaction status');
            Log::info($response['data']['status']);
            Log::info($request->input('status'));
            Log::info($request->input('status'));
            Log::info($order_amount);


            if (
                $response['data']['status'] == "successful" &&
                $request->input('status')  == "successful"
               ) //  && $response['data']['amount'] == $order_amount - Condition removed because test account won't allow above N2000
                {
                    Log::info('I got here to update order status');

                // Update the order payment status
                $order = Order::where('transaction_id', $response['data']['tx_ref']);

                $order->update(['status' => 'completed']);

                Log::info('Order is : ');
                Log::info($order->get());
                Log::info($order->get()->pluck('id')->first());


                $user = Auth::user();
                $user->notify(new OrderConfirmationNotification($order->get()->pluck('id')->first())); //  $current_transaction['exam_name']

                // remove the session variable
                Session::remove($current_transaction_id_cookie);

                // Redirect the user or display a view with the payment result
                return Inertia::render('Frontend/Order/Summary', [
                    'status' => $request->input('status'),
                    'customer_email' => $request->input('customer.email'),
                    'message' => 'Payment successful!'
                ]);
            }
            else {
                // Update the order payment status
                $order = Order::where('transaction_id', $response['data']['tx_ref'])->update(['status' => $response['status']]);

                // If payment fails, still remove the transaction variable from the session.

                // remove the session variable
                Session::remove($current_transaction_id_cookie);

                // Redirect the user or display a view with the payment result
                return Inertia::render('Frontend/Order/Summary', [
                    'status' => $request->input('status'),
                    'customer_email' => $request->input('customer.email'),
                    'message' => 'Payment failed, please try again'
                ]);
                //return to_route('order.cart')->withError('Payment failed, please try again');
            }
        }
        else { // Stripe transaction callback.
            $stripe = new \Stripe\StripeClient(config('app.stripeSecretKey'));
            header('Content-Type: application/json');

            try {

                $session = $stripe->checkout->sessions->retrieve($request->session_id);

                Log::info('Session Status is: ');
                Log::info($session->status);
                if ($session->status != 'complete') {
                    // Handle failed or incomplete payment
                    Log::info($session);
                    $order = Order::where('transaction_id', $request->input('stx_ref'))->update(['status' => 'completed']);

                    // remove the session variable
                    Session::remove($current_transaction_id_cookie);

                    //return to_route('order.cart')->with('error','Payment failed, please try again');
                    return Inertia::render('Frontend/Order/Summary', [
                        'status' => $session->status,
                        'message' => 'Payment failed, please try again'
                    ]);
                }
                else {
                // Handle successful payment
                    Log::info('I got here before storing the order');
                    Log::info('Stripe Tx Reference');
                    Log::info($request->input('stx_ref'));

                    Log::info($session);
                    $order = Order::where('transaction_id', $request->input('stx_ref'))->update(['status' => 'completed']);

                    Log::info('Order is: ');
                    Log::info($order);

                    Log::info('I got here after completing payment and order');

                    Log::info('Current Trans is: ');
                    Log::info($current_transaction);

                    Log::info('Session Transaction details');

                    // $request->input('stx_ref')
                   // Log::info($current_transaction[0][0]['exam_name']);
                    Log::info($order->id);

                    $user = Auth::user();
                    $user->notify(new OrderConfirmationNotification($order->id));

                    // remove the session variable
                    Session::remove($current_transaction_id_cookie);

                    // Redirect the user or display a view with the payment result
                    return Inertia::render('Frontend/Order/Summary', [
                        'status' => $session->status,
                        //'customer_email' => $session->customer_details->email,
                        'message' => 'Payment successful!'
                    ]);

                }

            } catch (\Exception $e) {
                return to_route('order.cart')->withError('There was a problem processing your payment.');
            }
        }


    }

    public function startFlwSession($tx_id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$tx_id}/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array (
                "Content-Type: application/json",
                "Authorization: Bearer " . config('app.flwSecretKey')
            )
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

}
