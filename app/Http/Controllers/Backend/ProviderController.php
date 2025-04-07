<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Ramsey\Uuid\Uuid;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\ProviderRequest;
use App\Models\Backend\Category;
use App\Models\Backend\Provider;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Request as FRequest;
use Illuminate\Database\UniqueConstraintViolationException;

class ProviderController extends Controller
{
    public function index()
    {
        return Inertia::render('Backend/Providers/Index',[
            'filters' => FRequest::only(['search']),
            'providers' => Provider::with('Category')
                // ->query()
                ->when(FRequest::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                // ->latest()
                ->orderBy('name', 'asc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($provider) => [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'description' => $provider->description,
                    'logo' => env('AZURE_BLOB_PATH').$provider->logo, //$provider->logo,
                    'slug' => $provider->slug,
                    'status' => $provider->status,
                    'featured' => $provider->featured,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Backend/Providers/Create', [
            'categories' => Category::query()
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ]),
        ]);
    }

    public function store(ProviderRequest $request)
    {
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        // Call ImageController uploadImage function to upload image to server repository.
        $filePath = (new ImageController)->uploadImage($request, 'logo');

        try {
            // Create Provider
            Provider::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'logo' => $filePath,
                'slug' => strtolower($request->input('slug')),
                'status' => $request->input('status'),
                'featured' => $request->input('featured'),
                'url' => $request->input('url'),
                'category_id' => $request->input('category_id'),
            ]);
        } catch (UniqueConstraintViolationException $exception) {
            //return back()->withError($exception->errorInfo[2])->withInput();
            return back()->withError('Provider slug \''. $request->input('slug') . '\' already exist, enter a different slug')->withInput();
        }

        return to_route('admin.providers.index')->with('success', 'Provider created.');

    }

    public function edit(Provider $provider)
    {

        return Inertia::render('Backend/Providers/Edit', [
            'provider' => [
                'id' => $provider->id,
                'name' => $provider->name,
                'slug' => strtolower($provider->slug),
                'description' => $provider->description,
                'logo' => $provider->logo,
                'url' => $provider->url,
                'slug' => $provider->slug,
                'status' => $provider->status,
                'featured' => $provider->featured,
            ],
            'category' => $provider->category()->get()->map->only('id','name','description'),

        ]);
    }


    public function update(Provider $provider, ProviderRequest $request)
    {
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        if ($request->hasFile('logo')) {
            // Call ImageController uploadImage function to upload image to server repository.
            $filePath = (new ImageController)->uploadImage($request, 'logo');
        }

        $this->authorize('update', $provider);

        $provider->update(
            [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'logo' => $request->hasFile('logo') ? $filePath : $request->input('logo'),
                'slug' => strtolower($request->input('slug')),
                'status' => $request->input('status'),
                'featured' => $request->input('featured'),
                'url' => $request->input('url'),
            ]
        );

        return to_route('admin.providers.index')->with('success', 'Provider updated.');
    }

    public function destroy(Provider $provider)
    {
        // Authorize to delete
        $this->authorize('delete', $provider);

        if ($provider->exams()->exists()) {
            return back()
                ->withError('An examination is linked to this provider. You must first delete the examination!')
                ->withInput();
        }
        else {
            $provider->delete();
        }

        return Redirect::back()->with('success', 'Provider deleted.');
    }
}
