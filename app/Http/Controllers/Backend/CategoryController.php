<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Exam;
use App\Models\Backend\Provider;
use App\Models\Backend\Category;
use App\Models\User;
// use Ramsey\Uuid\Uuid;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Request as FRequest;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Backend/Categories/Index',[
            'filters' => FRequest::only(['search']),
            'categories' => Category::query()
                ->when(FRequest::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                // ->latest()
                ->orderBy('name', 'asc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description
                ]) ?? null
        ]);
    }

    public function create()
    {
        return Inertia::render('Backend/Categories/Create');
    }

    public function store(CategoryRequest $request)
    {
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        //Users details
        $user = User::find(FRequest::user()->id);

        // Create Category
        $user->categories()->create(
            $validatedData
        );

        return to_route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Backend/Categories/Edit',[
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
            ],
        ]);
    }


    // Update question
    public function update(Category $category, CategoryRequest $request)
    {
        $this->authorize('update', $category);

        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        $category->update(
            [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]
        );

        return redirect(route('admin.categories.index'))->with('success', 'Examination updated.');
    }

    // Delete a category

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        if ($category->provider()->exists()) {
            return back()
                ->withError('A provider is linked to this category. You must first delete the provider!')
                ->withInput();
        }
        else {
            $category->delete();
        }

        return redirect(route('admin.categories.index'));
    }
}
