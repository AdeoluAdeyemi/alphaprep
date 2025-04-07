<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\View\View;
use App\Models\Backend\Exam;
use Illuminate\Http\Request;
use App\Models\Backend\Provider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ImageController;
use App\Http\Requests\ExamRequest;
use Illuminate\Support\Facades\Request as FRequest;
use Illuminate\Database\UniqueConstraintViolationException;

class ExamController extends Controller
{
    // Show all exams
    public function index()
    {
        return Inertia::render('Backend/Examinations/Index',[
            'filters' => FRequest::only(['search']),
            'exams' => Exam::with('Provider:name')
                // ->query()
                ->when(FRequest::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->where('version', 'like', "%{$search}%")
                        ->where('slug', 'like', "%{$search}%");
                })
                // ->latest()
                ->orderBy('name', 'asc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($exam) => [
                    'id' => $exam->id,
                    'name' => $exam->name,
                    'description' => $exam->description,
                    'slug' =>  $exam->slug,
                    'year' =>  $exam->year,
                    'logo' =>  $exam->logo,
                    'version' =>  $exam->version,
                    'duration' =>  $exam->duration,
                    'timer' =>  $exam->timer,
                    'provider' =>  $exam->provider->name, //->get()->map->only('name'),
                ]),
        ]);
    }

    // Show form to create a question
    public function create()
    {
        return Inertia::render('Backend/Examinations/Create', [
            'providers' => Provider::query()
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn ($provider) => [
                'id' => $provider->id,
                'name' => $provider->name,
                'description' => $provider->description,
            ]),
            'csrf_token' => csrf_token(),
        ]);
    }

    // Store a new question
    public function store(ExamRequest $request)
    {
        // Create Question

        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        // Call ImageController uploadImage function to upload image to server repository.
        $filePath = (new ImageController)->uploadImage($request, 'logo');

        try {
            // Create Examination
            $exam = Exam::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'logo' => $filePath,
                'slug' => strtolower($request->input('slug')),
                'version' => $request->input('version'),
                'duration' => $request->input('duration'),
                'timer' => $request->input('timer'),
                'year' => $request->input('year'),
                'provider_id' => $request->input('provider_id'),
                'pass_mark' => $request->input('pass_mark'),
            ]);
        } catch (UniqueConstraintViolationException $exception) {
            return back()->withError('Examination slug \''. $request->input('slug') . '\' already exist, enter a different slug')->withInput();
        }

        $exam->products()->create([
            'price' => $request->input('price'),
            'price_usd' => $request->input('price_usd'),
            'price_gbp' => $request->input('price_gbp'),
            'exam_id' => $exam->id,
        ]);

        return to_route('admin.exams.index')->with('success', 'Examination created.');
    }

    // Show form to edit a question
    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);

        return Inertia::render('Backend/Examinations/Edit', [
            'exam' => [
                'id' => $exam->id,
                'name' => $exam->name,
                'description' => $exam->description,
                'logo' => $exam->logo,
                'slug' => $exam->slug,
                'version' => $exam->version,
                'duration' => $exam->duration,
                'timer' => $exam->timer,
                'year' => $exam->year,
                'pass_mark' => $exam->pass_mark,
                'price' => $exam->products[0]->price,
                'price_usd' => $exam->products[0]->price_usd,
                'price_gbp' => $exam->products[0]->price_gbp,
            ],
            'provider' => $exam->provider()->get()->map->only('id','name'),
            'csrf_token' => csrf_token(),
        ]);

    }

    // Update question
    public function update(Exam $exam, ExamRequest $request)
    {
        $this->authorize('update', $exam);

        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        if ($request->hasFile('logo')) {
            // Call ImageController uploadImage function to upload image to server repository.
            $filePath = (new ImageController)->uploadImage($request, 'logo');
        }

        try {
            // Update Examination
            $exam->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'logo' => $request->hasFile('logo') ? $filePath : $request->input('logo'),
                'slug' => strtolower($request->input('slug')),
                'version' => $request->input('version'),
                'duration' => $request->input('duration'),
                'timer' => $request->input('timer'),
                'year' => $request->input('year'),
                'pass_mark' => $request->input('pass_mark'),
            ]);
        } catch (UniqueConstraintViolationException $exception) {
            return back()->withError('Examination slug \''. $request->input('slug') . '\' already exist, enter a different slug')->withInput();
        }

        $exam->products()->update([
            'price' => $request->input('price'),
            'price_usd' => $request->input('price_usd'),
            'price_gbp' => $request->input('price_gbp'),
            'exam_id' => $exam->id,
        ]);

        return redirect(route('admin.exams.index'))->with('success', 'Examination updated.');
    }

    // Delete a question
    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);

        if ($exam->questions()->exists()) {
            return back()
                ->withError('A question is linked to this examination. You must first delete the question!')
                ->withInput();
        }
        else {
            $exam->delete();
        }

        return redirect(route('admin.exams.index'));
    }
}
