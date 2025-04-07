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
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;


class FeedbackController extends Controller
{
    /**
     * Display the Feedback page.
     */
    public function index(Request $request)
    {
        return Inertia::render('Backend/Feedback/Index',[]);
    }

    public function create ()
    {
        return Inertia::render('Frontend/Feedback/Create',[]);
    }

    public function store (FeedbackRequest $request)
    {
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        Log::info($request);
        //Users details
        $user = User::find($request->user()->id);

        Log::info($user);
        // Create Feedback
        // $user->feedbacks()->create(
        //     $validatedData
        // );

        $feedback = Feedback::create([
            'id' => $request->input('id'),
            'details'=> $request->input('details'),
            'feedback' => $request->input('feedback'),
            'rating' => $request->input('rating'),
            'origin' => $request->input('origin'),
            'user_id' => $request->user()->id,
        ]);

        Log::info($feedback);

        // return Inertia::render('Frontend/Feedback/Create',[
        //     'response' =
        // ]);

        return back()->with('success', 'Feedback received!');

    }

    public function edit ()
    {

    }
}

