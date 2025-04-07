<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\View\View;
use App\Models\Backend\Exam;
use Illuminate\Http\Request;
use App\Models\Backend\Provider;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class SearchController extends Controller
{
    //
    public function index(Request $request)
    {
        // Validate User response and ensure it is less than 255 characters
        $validated = $request->validate([
            'exam' => 'required|string|max:255',
            'component' => 'nullable|string|max:255',
        ]);

        $query = '';
        $component = '';

        // Accept search query from query string and search form.
        if ($request->isMethod('get')) {
            $query = $request->query('exam');
        //    $component = $request->query('component') ?? null;
        }
        else{
            $query = $request->input('exam');
        //    $component = $request->input('component') ?? null;
        }

        $exams = Exam::where('name', 'like', "%{$query}%")
                        ->with('Provider')
                        ->orderBy('name', 'asc')
                        ->get()
                        ->map(fn ($exam) => [
                            'id' => $exam->id,
                            'name' => $exam->name,
                            'slug' => $exam->slug,
                            'provider' => $exam->provider->name
                        ]); //->map->only('id','name', 'slug');

        // //search($query)->take(10)->get()->map->only('id','name', 'slug');

        // if ($component == 'Home'){
        //     return Inertia::render('Home',[
        //         //'canLogin' => Route::has('login'),
        //         //'canRegister' => Route::has('register'),
        //         'laravelVersion' => Application::VERSION,
        //         'phpVersion' => PHP_VERSION,
        //         'exams' => $exams,
        //         'providers' => Provider::where('status', 1)
        //             ->where('featured', 1)
        //             ->with('Exams')
        //             ->orderBy('created_at', 'desc')
        //             ->get()
        //             ->map(fn ($provider,) => [
        //                 'name' => $provider->name,
        //                 'slug' => $provider->slug,
        //                 'exams' => $provider->exams()->get()->map(fn ($exam,) => [
        //                         'id' => $exam->id,
        //                         'name' => $exam->name,
        //                         'slug' => $exam->slug,
        //                         'description' => $exam->description,
        //                         'logo' => $exam->logo,
        //                         'price' => $exam->products[0]->price,
        //                         'stripe_price_id' => $exam->products[0]->stripe_price_id,
        //                         'flutter_price_id ' => $exam->products[0]->flutter_price_id,
        //                         'paystack_price_id  ' => $exam->products[0]->paystack_price_id,
        //                         'price_usd' => $exam->products[0]->price_usd,
        //                         'price_gbp' => $exam->products[0]->price_gbp
        //                 ]), //->only('id','name','description','logo','slug','price'),
        //             ]),
        //         ]
        //     );
        // }
        // else{
        //     return Inertia::render($component,[
        //         'exams' => $exams,
        //         ]
        //     );
        // }

        return Inertia::render('Home',[
            //'canLogin' => Route::has('login'),
            //'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'exams' => $exams,
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
            ]
        );
    }
}
