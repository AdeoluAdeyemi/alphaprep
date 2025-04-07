<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Facades\Request as FRequest;

class InvoiceController extends Controller
{
    public function show (Request $request)
    {

        Log::info('I got here - Invoices page');

        $client = new Party([
            'name'          => 'Roosevelt Lloyd',
            'phone'         => '(520) 318-9486',
            'custom_fields' => [
                'note'        => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);

        // $address = $request->user()->address. '<br>'
        //             .$request->user()->city. '<br>'
        //             .$request->user()->state. '<br>'
        //             .$request->user()->country. '<br>'
        //             .$request->user()->zip_code;

        //$address = implode("<br>", $address);

        $customer = new Party([
            'name'          => $request->user()->name,
            'address'       => $request->user()->address. ' '.$request->user()->city. ' '.$request->user()->state. ' '.$request->user()->country. ' '.$request->user()->zip_code,
            //'address'       => $address,
            // 'address'       => implode("<br>", [
            //     $request->user()->address,
            //     $request->user()->city,
            //     $request->user()->state,
            //     $request->user()->country,
            //     $request->user()->zip_code,
            // ]),
                        //'code'          => '#22663214',
            'custom_fields' => [
                'order number' => '#'.$request->input('order_id') ?? '#654321',
            ],
        ]);

        $items = [
            InvoiceItem::make('Exam Practice')
                ->description($request->input('description'))
                ->pricePerUnit($request->input('price'))
                ->quantity($request->input('quantity'))
                ->discount($request->input('discount'))
        ];

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('receipt')
            ->series('EXAMDUCTUS_')
            // ability to include translated invoice status
            // in case it was paid
            ->status(($request->input('status') == 'paid') ? __('invoices::invoice.paid'): __('invoices::invoice.unpaid'))
            ->sequence($request->input('order_id') ?? 667)
            ->serialNumberFormat('{SERIES}_{SEQUENCE}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3)) // $request->input('order_date')
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol(($request->user()->currency == 'GBP') ? '£' : (($request->user()->currency == 'NGN') ? '₦' : '$')) // $request->input('currency_symbol')
            ->currencyCode($request->user()->currency)
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }

    public function index()
    {
        return Inertia::render('Frontend/Invoices/Index',[
            'filters' => FRequest::only(['search']),
            // 'invoices' => Invoices::select('exams.id', 'exams.name', 'exams.slug', 'exams.description', 'exams.year', 'exams.logo', 'exams.timer', 'providers.slug as provider_name', 'order_result.total as price', 'order_result.status as status', 'order_result.id as order_id', 'order_result.created_at as order_date', 'order_result.updated_at as transaction_date')
            //     ->join('providers', 'exams.provider_id', '=', 'providers.id')
            //     ->join(DB::raw(
            //                 '(SELECT order_product.product_id, orders.id, orders.status, orders.user_id, orders.total, orders.created_at, orders.updated_at
            //                     FROM orders
            //                     INNER JOIN order_product ON order_product.order_id = orders.id
            //                     WHERE orders.status IN ("completed", "success") AND orders.user_id = "9baaf2f2-52a5-4c93-9606-cec5135a5cbf"
            //                 ) AS order_result'
            //             ), function ($join) {
            //                 $join->on('order_result.product_id', '=', 'exams.id'); //ON dt.product_id = exams.id
            //             })
            //     ->when(FRequest::input('search'), function ($query, $search) {
            //         $query->where('exams.name', 'like', "%{$search}%");
            //     })
            //     ->paginate(10),

            'invoices' => Order::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->through(fn ($order) => [
                        'id' =>  $order->id,
                        'date' =>  $order->created_at,
                        'due_date' =>  $order->created_at,
                        'total' =>  $order->total,
                        'status' => $order->status,
                ]),
        ]);
    }
}
