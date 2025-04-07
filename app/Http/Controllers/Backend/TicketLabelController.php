<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TicketLabelRequest;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use App\Http\Requests\TicketCategoryRequest;
use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Support\Facades\Request as FRequest;

class TicketLabelController extends Controller
{
    //
    public function create()
    {
        return Inertia::render('Backend/Tickets/Labels/Create',[]);
    }

    public function index()
    {
        $search = request('search');

        Log::info(Label::when(FRequest::input(['search']), function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString()
        ->through(fn ($label) => [
            'id' => $label->id,
            'name' => $label->name,
        ]));

        return Inertia::render('Backend/Tickets/Labels/Index',[
            'filters' => FRequest::only(['search']),
            'ticket_labels' => Label::when(FRequest::input(['search']), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($label) => [
                    'id' => $label->id,
                    'name' => $label->name,
                ]) ?? null,
        ]);
    }

    public function store(TicketLabelRequest $request)
    {
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        
        $validatedData = $request->validated();

        Label::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'))
        ]);

        return to_route('admin.tickets.labels.index')->with('success','Ticket Label Created Successfully');

        Log::info($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $ticket_label)
    {
        return Inertia::render('Backend/Tickets/Labels/Edit', [
            'ticket_category' => [
                'id' => $ticket_label->id,
                'name' => $ticket_label->name,
                'slug' => $ticket_label->slug
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Label $ticket_label, TicketLabelRequest $request)
    {
        // Authorize to update
        $this->authorize('update', $ticket_label);

        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $ticket_label->validated();

        $ticket_label->update($validatedData);

        return to_route('admin.tickets.labels.index')->with('status','Ticket Label Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $ticket_label)
    {
        // Authorize to delete
        $this->authorize('delete', $ticket_label);

        $ticketLabel = Label::find($ticket_label);
        $ticketLabel->delete();
        return redirect()->back()->with('success', 'Ticket Label Deleted Successfully');
    }
}
