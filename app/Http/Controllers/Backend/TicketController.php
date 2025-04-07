<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Category;

class TicketController extends Controller
{
    //
    public function create()
    {
        return Inertia::render('Frontend/Support/Tickets/Create',
        [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'csrf_token' => csrf_token()
        ]);
    }

    public function index()
    {
        return Inertia::render('Frontend/Support/Tickets/Index');
    }

    public function store(TicketRequest $request)
    {
        Log::info($request);
        
        /** @var User */
        $user = Auth::user();

        $ticket = $user->tickets()->create($request->validated());

        $category = Category::first();
        $label = Label::first();

        $ticket->attachCategories($category);
        $ticket->attachLabels($label);

        // or you can create the categories & the tickets directly by:
        // $ticket->categories()->create(...);
        // $ticket->labels()->create(...);

        return redirect(route('tickets.show', $ticket->uuid))
                ->with('success', __('Your Ticket Was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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

    public function createCategory()
    {
        // If you create a category/categories seperated from the ticket and wants to
        // associate it to a ticket, you may do the following.
        $category = Category::create('Name of category');

        $ticket = Ticket::findOrFail('ticket_name_here');

        $category->tickets()->attach($ticket);

        // or maybe
        $category->tickets()->detach($ticket);
    }
}
