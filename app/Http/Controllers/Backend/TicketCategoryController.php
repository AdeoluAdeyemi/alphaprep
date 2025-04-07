<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Auth;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use App\Http\Requests\TicketCategoryRequest;
use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Support\Facades\Request as FRequest;

class TicketCategoryController extends Controller
{
    //
    public function create()
    {
        return Inertia::render('Backend/Tickets/Categories/Create', []);
    }

    public function index()
    {
        $search = request('search');

        return Inertia::render('Backend/Tickets/Categories/Index',[
            'filters' => FRequest::only(['search']),
            'ticket_categories' => Category::when(FRequest::input(['search']), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                ]) ?? null,
        ]);
    }

    public function store(TicketCategoryRequest $request)
    {
        Log::info($request);
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        
        $validatedData = $request->validated();

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'))
        ]);

        return to_route('admin.tickets.categories.index')->with('success','Ticket Category  Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $ticket_category)
    {
        return Inertia::render('Backend/Tickets/Categories/Edit', [
            'ticket_category' => [
                'id' => $ticket_category->id,
                'name' => $ticket_category->name
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $ticket_category, TicketCategoryRequest $request)
    {
        // Authorize to update
        $this->authorize('update', $ticket_category);

        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $ticket_category->validated();

        $ticket_category->update($validatedData);

        return to_route('admin.tickets.categories.index')->with('status','Ticket Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $ticket_category, string $id)
    {
        // Authorize to delete
        $this->authorize('delete', $ticket_category);

        $ticketCategory = Category::find($ticket_category);
        $ticketCategory->delete();
        return redirect()->back()->with('success', 'Ticket Category Deleted Successfully');
    }
}
