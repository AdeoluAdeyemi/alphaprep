<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Backend\Provider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;


class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(Request $request)
    {

                // // make a purchase
                // $user = User::firstOrCreate(
                // [
                //     'email' => 'adeolu.ooa@gmail.com'
                // ],
                // [
                //     'password' => Hash::make(Str::random(12)),
                //     'name' => 'Enitan Adeyemi',
                //     'address' => 'Test',
                //     'city' => 'Test',
                //     'state' => 'Test',
                //     'zip_code' => '123456',
                //     //'country' => 'Test',
                // ]
                // );

                // Log::info('User \'s details');
                // Log::info($user);
                // Log::info($user->id);


        return Inertia::render('Home',[
            'providers' => Provider::where('status', 1)
                ->where('featured', 1)
                ->with('Exams')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($provider,) => [
                    'name' => $provider->name,
                    'slug' => $provider->slug,
                    'exams' => $provider->exams()->get()->map(fn ($exam,) => [
                            'id' => $exam->id,
                            'name' => $exam->name,
                            'slug' => $exam->slug,
                            'description' => $exam->description,
                            'logo' => $exam->logo,
                            'price' => $exam->products[0]->price,
                            'stripe_price_id' => $exam->products[0]->stripe_price_id,
                            'flutter_price_id ' => $exam->products[0]->flutter_price_id,
                            'paystack_price_id  ' => $exam->products[0]->paystack_price_id,
                            'price_usd' => $exam->products[0]->price_usd,
                            'price_gbp' => $exam->products[0]->price_gbp
                    ]), //->only('id','name','description','logo','slug','price'),
                ]),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    // public function home()
    // {
    //     return Inertia::render('Homepage', [
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //     ]);
    // }
}
