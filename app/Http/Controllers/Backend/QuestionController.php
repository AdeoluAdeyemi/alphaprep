<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Backend\Exam;
use App\Models\Backend\Provider;
use App\Models\Backend\Option;
use App\Models\Backend\Question;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FRequest;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Backend/Questions/Index',[
            'filters' => FRequest::only(['search']),
            'questions' => Question::with('Options','Exam')
                // ->query()
                ->when(FRequest::input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->orderBy('title', 'asc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($question) => [
                    'id' => $question->id,
                    'title' => $question->title,
                    'question_type' => $question->question_type,
                    'option_type' =>  $question->option_type,
                    'position' =>  $question->position,
                    'exam_id' =>  $question->exam_id,
                    'exam_name' => $question->exam()->get()->map->only('name'),
                    'options' => $question->options[0]->options,
                    'correct_answer' => $question->options[0]->correct_answer,
                    'explanation' => $question->options[0]->explanation,
                ]) ?? null,
        ]);
    }


    public function generator()
    {
        return Inertia::render('Backend/Questions/Generator');
    }

    public function create()
    {
        return Inertia::render('Backend/Questions/Create', [
            'exams' => Exam::with('Provider')
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn ($exam) => [
                'id' => $exam->id,
                'name' => $exam->name,
                'slug' => $exam->slug,
            ]),
            'csrf_token' => csrf_token(),
        ]);
    }

    public function store(QuestionRequest $request)
    {
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        // Create Question
        $question = Question::create([
            'id' => $request->id,
            'title' => $request->title,
            'question_type' => $request->question_type,
            'position' => $request->position,
            'code_snippet' => $request->code_snippet,
            'exam_id' => $request->exam_id,
        ]);

        // Create options
        $question->options()->create([
            'id' => $request->option_id,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
        ]);

        // Update options optionlist
        $question->options()->update([
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
        ]);

        return to_route('admin.questions.index')->with('success', 'Question created.');
    }

    public function edit(Question $question)
    {
        return Inertia::render('Backend/Questions/Edit', [
            'exam' => $question->exam()->get()->map->only('id','name', 'slug'),
            'question' => [
                'id' => $question->id,
                'title' => $question->title,
                'question_type' => $question->question_type,
                'code_snippet' => $question->code_snippet,
                'position' => $question->position,
            ],
            'option' => $question->options()->get()->map->only('id','options', 'correct_answer','explanation'),
        ]);
    }

    public function update(Question $question, QuestionRequest $request)
    {

        $this->authorize('update', $question);

        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        // Update question fields
        $question->update([
            'title' => $request->title,
            'question_type' => $request->question_type,
            'position' => $request->position,
            'code_snippet' => $request->code_snippet,
        ]);

        $question->options()->update([
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
        ]);

        return to_route('admin.questions.index')->with('success', 'Question updated.');
    }

    public function destroy(Question $question)
    {
        // Authorize to delete
        $this->authorize('delete', $question);

        if ($question->options()->exists()) {
            return back()
                ->withError('An option is linked to this question. You must first delete the option!')
                ->withInput();
        }
        else {
            $question->delete();
        }
        return Redirect::back()->with('success', 'Question deleted.');

    }

}
