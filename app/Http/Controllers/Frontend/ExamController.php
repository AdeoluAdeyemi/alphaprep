<?php

namespace App\Http\Controllers\Frontend;

use DateTime;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\Frontend\Exam;
use Carbon\Traits\Difference;
use Illuminate\Support\Carbon;
use App\Models\Backend\Provider;
use App\Models\Backend\Question;
use App\Http\Services\Cryptography;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Frontend\ExamSession;
use App\Models\Frontend\ExamResponse;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\FrontendExamRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request as FRequest;

class ExamController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Frontend/Examination/Index', [
            'filters' => FRequest::only(['search']),
            'providers' => Provider::query()
                ->when(FRequest::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->where('slug', 'like', "%{$search}%");
                })
                ->orderBy('name', 'asc')
                ->get()
                ->map(fn ($provider) => [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'description' => $provider->description,
                    'slug' => $provider->slug,
                    'examCount' => sizeof($provider->exams()->get())
                ]),
            // 'exams' => sizeof(Question::where('exam_id',$exam_id)->orderBy('position', 'asc')->get()),
        ]);
    }

    public function start(string $provider, string $slug, Request $request)
    {
        //echo xdebug_info();
        Log::info('Start Method');
        Log::info($request);

        $request->has('page');

        $exams = Exam::where('slug', $slug)->firstOrFail();
        $exam_id = $exams->id;

        $exam_name = $exams->name;

        $incomplete_duration = null;
        $incomplete_selectedOptions = null;


        $exam_session = null;
        $questionCount = sizeof(Question::where('exam_id',$exam_id)->orderBy('position', 'asc')->get());

        $exam_mode = null;

        // Continue to create a session if request is well formatted. If exam mode is set, and has more than 1 question.
        if(($request->has('examMode') && $request->has('question_count')) && !($request->question_count <= 0)){ // || $questionCount <= 0

            // Set exam_mode
            $exam_mode = $request->has('examMode');

            // Create a session in the DB if the exam mode is timed.
            if ($request->examMode != 'practice'){

                // If there is no unfinished exam session for an exam in the exam_sessions table,
                // create a new session record, and return record id
                $ExamSession = ExamSession::firstOrCreate(
                    ['exam_id' => $exam_id, 'user_id' => $request->user()->id, 'status' => 0],
                    ['id' => Uuid::uuid4()->toString(), 'exam_id' => $exam_id, 'user_id' => $request->user()->id, 'status' => 0, 'mode' => $request->examMode]
                );

                $exam_session = $ExamSession->id;

                // Check if the exam was paused
                // if($exam_session->incomplete_duration != null)
                // {
                //     $incomplete_duration = $exam_session->incomplete_duration;
                // }

                // Store the current exam and details into Session.
                Session::put('current_exam_data', [
                    'exam_mode' => $request->examMode,
                    'exam_id' => $exam_id,
                    'exam_session_id' => $exam_session,
                ]);
            }
        }
        else if($request->has('page')){ // Use this logic if page is called from the pagination.

            Log::info('I got here for a next page');
            Log::info($request);

            // Check if the exam mode is timed.
            if ($exam_mode == 'timed' && $exam_mode != null){

                if(Session::has('current_exam_data')){ // Get the current exam from Session.
                    $current_exam = Session::get('current_exam_data');

                    if($current_exam['exam_id'] == $exam_id){ // Check and confirm it is the same exam.
                        $exam_mode = $current_exam['exam_mode'];
                    }

                    $exam_session = $current_exam['exam_session_id'];
                }
            }
            else{
                $exam_mode = 'practice';
            }
        }
        else{
            // Continue paused exam
            $ExamSession = null;

            if ($request->has('sessionId') && $request->input('sessionId') != null){
                $ExamSession = ExamSession::findOrFail($request->input('sessionId'));
                $exam_session = ($ExamSession) ? $request->input('sessionId') : $ExamSession->id;
                $exam_mode = 'timed';

                Log::info('Has Incomplete Duration?');

                Log::info($ExamSession);

                // Check if the exam was paused
                if($ExamSession->incomplete_duration != null)
                {
                    $incomplete_duration = $ExamSession->incomplete_duration;
                    Log::info('Incomplete SelectedOption');
                    //dd($ExamSession->exam_response()->get()->pluck('question_answer')->first());
                    $incomplete_selectedOptions = $ExamSession->exam_response()->get()->pluck('question_answer')->first();

                }

                // Store the current exam and details into Session.
                Session::put('current_exam_data', [
                    'exam_mode' => $exam_mode,
                    'exam_id' => $exam_id,
                    'exam_session_id' => $exam_session,
                ]);
            }
            else{
                // No questions loaded.
                return Inertia::render('Frontend/Examination/TakeExamination',[
                    'questions' => null,
                ]);
            }

        }


        return Inertia::render('Frontend/Examination/TakeExamination',[
            'questions' => Question::where('exam_id',$exam_id)
                ->with('Options','Exam')
                ->orderBy('position', 'asc')
                ->paginate(1)
                ->through(fn ($question) => [
                    'id' => $question->id,
                    'code_snippet' => $question->code_snippet,
                    'title' => (new Cryptography)->encryptText($question->title), // $utf8Title = base64_encode($encryptedTitle);
                    'options' => [
                        'correct_answer' => $question->options[0]->correct_answer,
                        'explanation' => $question->options[0]->explanation,
                        'options' => $question->options[0]->options,
                    ],
                    'duration' => $question->exam->duration,
                    'timer' => $question->exam->timer,
                ]),
                'examMode' => $request->examMode ?? $exam_mode,
                'exam_session_id' => $exam_session,
                'exam_name' => $request->name ?? $exam_name,
                'exam_id' => $exam_id,
                'provider' => $provider,
                'exam_slug' => $slug,
                'question_count' => $request->question_count ?? $questionCount,
                'incomplete_duration' => $incomplete_duration ?? null,
                'incomplete_selectedOptions' => $incomplete_selectedOptions ?? null
        ]);
    }


    public function pause (string $session_id, Request $request): JsonResponse
    {
        Log::info('Pause Exam Response');
        Log::info($request);

        Log::info($session_id);

        // If there is no uncompleted exam response for an exam in the exam_responses table,
        // create a new exam response record, otherwise update the exam_responses record
        $examResponse = ExamResponse::updateOrCreate(
            ['exam_session_id' => $session_id],
            ['id' => Uuid::uuid4()->toString(), 'question_answer' => $request->examResponse, 'total_score' => 0, 'question_count' => 0] // total_score & question_count are 0 because exam isn't completed.
        );


        // Log::info('Exam Response recently created?');
        // Log::info($examResponse->wasRecentlyCreated);

        // if (!$examResponse->wasRecentlyCreated) {
        //     // ExamResponse just created in the database; it didn't exist before.
        //     // Do nothing!
        // } else {
        //     // ExamResponse already existed and was pulled from database.
        //     $examResponse->update([
        //         'question_answer' => $request->examResponse,
        //     ]);
        // }

        Log::info($examResponse);

        $exam_session = ExamSession::findOrFail($session_id);

        $updateDuration = $exam_session->update([
            'incomplete_duration' => $request->duration
        ]);

        $exam_response = $examResponse->id;

        if($exam_response && $updateDuration){
            return response()->json(['status' => 'saved']);
        }
        else {
            return response()->json(['status' => 'unsaved']);
        }


    }


    public function provider(String $provider)
    {
        $provider_id = Provider::where('slug', $provider)->firstOrFail()->id;

        return Inertia::render('Frontend/Examination/Provider',[
            'exams' => Exam::where('provider_id',$provider_id)
                ->with('Provider')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($exam) => [
                    'name' => $exam->name,
                    'slug' => $exam->slug,
                    'description' => $exam->description,
                    // 'duration' => $exam->duration,
                    // 'timer' => $exam->timer,
                    // 'version' => $exam->version,
                    'logo' => $exam->logo,
                    'year' => $exam->year,
                ]),
            'provider' => Provider::where('id', $provider_id)->get()->map->only('id', 'name', 'slug','description')[0],
        ]);
    }

    public function details(String $provider, String $slug)
    {

        $exam_id = Exam::where('slug', $slug)->firstOrFail(); //->id ?? null;
        $exam_id = $exam_id->id;

        return Inertia::render('Frontend/Examination/Details',[
            'exams' => Exam::where('slug',$slug)
                ->with('Provider', 'Products')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($exam) => [
                    'name' => $exam->name,
                    'slug' => $exam->slug,
                    'description' => $exam->description,
                    'duration' => $exam->duration,
                    'timer' => $exam->timer,
                    'version' => $exam->version,
                    'logo' => $exam->logo,
                    'provider' => (strtolower($provider)) ? $provider : strtolower($exam->provider->name),
                    //'price' => $exam->products()->get()->map->only('price')
                    'price' => $exam->products[0]->price,
                    'price_usd' => $exam->products[0]->price_usd,
                    'price_gbp' => $exam->products[0]->price_gbp
                ]),
            'questions' => sizeof(Question::where('exam_id',$exam_id)->orderBy('position', 'asc')->get()),
        ]);
    }

    public function finish(FrontendExamRequest $request, String $provider, String $slug, String $exam_session_id)
    {
        $exam = Exam::where('slug', $slug)->firstOrFail();
        $exam_id = $exam['id'];
        $exam_name = $exam['name'];
        $exam_pass_mark = $exam['pass_mark'];

        //Exam Session start time, completed time variable
        $exam_start_end_time = null;

        // ExamSession in Cookie.
        $cookie_exam_session_id = null;

        // Exam Response from DB
        $examResponse = null;

        // Check if the request is a POST
        if ($request->isMethod('post'))
        {
            // Retrieve the validated input data...
            //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
            $validatedData = $request->validated();

            $examResponse = ExamResponse::firstOrCreate(
                ['exam_session_id' => $exam_session_id],
                ['id' => Uuid::uuid4()->toString(), 'question_answer' => $request->question_answer, 'total_score' => $request->total_score,'question_count' => $request->question_count]
            );

            // Exam is complete, update the total_score and question_count
            if($examResponse->question_answer != null || $examResponse->question_answer != '')
            {
                $examResponse->update([
                    'total_score' => $request->total_score,
                    'question_count' => $request->question_count,
                ]);
            }

            // Update ExamSession and end exam.
            $examResponse->exam_session()->update([
                'completion_time' => Carbon::now(),
                'status' => 1,
                'incomplete_duration' => null
            ]);

            // Fetch Exam Session start time, completed time
            //$exam_start_end_time = $examResponse->exam_session()->get()->map->only('created_at','completion_time');
            $exam_start_end_time = ExamSession::findOrFail($exam_session_id, array('created_at','completion_time'))->toArray();
        }
        else
        {
            // Check if exam_session_id is set, if set do not fetch exam response from DB,
            // use LocalStorage examResponse Object instead
            if(isset($_COOKIE['current_exam_session_id']) || isset($exam_session_id)) {
                // If the exam_session_ids are the same then the exam the user is
                // trying to review is the exam she just completed.
                if(isset($_COOKIE['current_exam_session_id']) && ($_COOKIE['current_exam_session_id'] == $exam_session_id)) //$request->exam_session_id ??
                {
                    $cookie_exam_session_id = $_COOKIE['current_exam_session_id'];

                    // Fetch Exam Session start time, completed time
                    $exam_start_end_time = ExamSession::findOrFail($cookie_exam_session_id, array('created_at','completion_time'))->toArray();
                }
                else
                {
                    // Fetch Exam Session start time, completed time
                    $exam_start_end_time = ExamSession::findOrFail($exam_session_id, array('created_at','completion_time'))->toArray();
                }

                $examResponse = ExamResponse::where('exam_session_id', $exam_session_id)->get();
            }
        }

        $start_time = $exam_start_end_time['created_at'];
        $end_time = $exam_start_end_time['completion_time'];
        $duration = $this->getDuration($start_time, $end_time);

        return Inertia::render('Frontend/Examination/Finish', [
            'exam_name' => $request->exam_name ?? $exam_name,
            'exam_id' => $request->exam_id ?? $exam_id,
            //'exam_session_id' => $request->exam_session_id,
            // If cookie exam session is set. Return cookie_exam_session_id as props
            'exam_session_id' => $cookie_exam_session_id ?? $request->exam_session_id ?? $exam_session_id, //($cookie_exam_session_id) ? $cookie_exam_session_id : (($examResponse[0]->exam_session_id) ? $examResponse[0]->exam_session_id : ($exam_session_id ? $exam_session_id : $request->exam_session_id)),
            // If exam response is set. Return exam_response as props
            'exam_response' => $request->question_answer ?? $examResponse[0]->question_answer,
            'exam_slug' => $request->exam_slug ?? $slug,
            'provider_slug' => $request->provider_slug ?? $provider,
            'start_time' => $start_time,
            'duration' => $duration,
            //'form_data' => $request->question_answer ?? $examResponse[0]->question_answer,
            'total_score' => $request->total_score ?? $examResponse[0]->total_score,
            'question_count' => $request->question_count ?? $examResponse[0]->question_count,
            'pass_mark' => $exam_pass_mark
        ]);
    }

    public function review(Request $request, String $provider, String $slug, String $exam_session_id)
    {
        $method = $request->method();

        $exam = Exam::where('slug', $slug)->firstOrFail();
        $exam_id = $exam['id'];
        $exam_name = $exam['name'];

        $exam_response_details = '';

        $ExamSession = ExamSession::where('id',$exam_session_id)
            ->with('Exam', 'Exam_Response')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($session) => [
                'exam_details' => [
                    'exam_name' =>  $session->exam()->get()->map->only('name')[0]['name'],
                    'duration' =>  $this->getDuration($session->created_at, $session->completion_time), //$session->exam()->get()->map->only('duration')[0]['duration'],
                    'start_time' =>  $session->exam()->get()->map->only('created_at')[0]['created_at'],
                    'exam_id' =>  $session->exam()->get()->map->only('id')[0]['id'],
                    'exam_slug' => $slug,
                    'provider_slug' => $provider,
                    'exam_session_id' =>  $exam_session_id,
                    'exam_response' => $session->exam_response()->get()->map->only('question_answer')[0]['question_answer'],
                    //'pc_score' => (($session->exam_response()->get()->map->only('total_score')[0]/$session->exam_response()->get()->map->only('question_count')[0]) * 100),
                    //'mark' => $session->exam_response()->get()->map->only('total_score')[0].'/'.$session->exam_response()->get()->map->only('question_count')[0]
                ],
                'questions' => $session->questions()->get()//$session->through('exam')->has('questions') //$
                ->map(fn ($question,) => [
                    'id' => $question->id,
                    'title' => (new Cryptography)->encryptText($question->title),
                    'options' => [
                        'explanation' => $question->options[0]->explanation,
                        'options' => $question->options[0]->options,
                    ],
                ]),
            ]);

        // Check if the request is a GET
        if ($request->isMethod('get'))
        {
            // If there is no unfinished exam session for an exam in the exam_sessions table,
            // create a new session record, and return record id

            return Inertia::render('Frontend/Examination/Review', $ExamSession[0]);
        }
        else{

            return Inertia::render('Frontend/Examination/Review', [
                'exam_details' => $request->exam_details,
                'questions' => Question::where('exam_id',$exam_id)
                ->orderBy('created_at', 'desc')
                ->get()//$session->through('exam')->has('questions') //$
                ->map(fn ($question) => [
                    'id' => $question->id,
                    'title' => (new Cryptography)->encryptText($question->title),
                    'options' => [
                        'explanation' => $question->options[0]->explanation,
                        'options' => $question->options[0]->options,
                    ],
                ]),
            ]);
        }
    }


    public function template(){

        return Inertia::render('Frontend/Examination/Template');
    }

    //
    public function preview(String $provider, String $slug)
    {
        Log::info('Provider and slug are : '.$provider. ' '.$slug);

        $exam_id = Exam::where('slug', $slug)->get()->firstOrFail()->id;

        return Inertia::render('Frontend/Examination/Preview',[
            'exam' => Exam::where('slug',$slug)
                ->with('Provider')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($exam,) => [
                    'name' => $exam->name,
                    'slug' => $exam->slug,
                    'duration' => $exam->duration,
                    'timer' => $exam->timer,
                    'provider' => (strtolower($provider)) ? $provider : strtolower($exam->provider->name)
                ]),
            'questions' => sizeof(Question::where('exam_id',$exam_id)->orderBy('position', 'asc')->get()),
        ]);
    }

    // Calculate Exam Duration
    public function getDuration(String $startTime, String $endTime)
    {
        $start_time = new DateTime($startTime); // start time
        $end_time = new DateTime($endTime); // end time

        // Difference between start time and end time
        $interval = $start_time->diff($end_time);

        $hour = (int)$interval->format('%H');
        $minute = (int)$interval->format('%i');
        $second = (int)$interval->format('%s');

        $duration = '';

        // Hour is less than 1
        if ($hour > 0 && $hour == 1) {
            $duration .= $hour.' hour ';
        }

        // Hour is greater than 1 add (s) to hours
        if ($hour > 0 && $hour >1){
            $duration .= $hour.' hours ';
        }

        // Minute is less than 1 use minute
        if ($minute > 0 && $minute == 1){
            $duration .= $minute.' minute ';
        }

        // Minutes is greater than 1 add (s) to minutes
        if ($minute > 0 && $minute > 1){
            $duration .= $minute.' minutes ';
        }

        // Second is less than 1 use second
        if ($second > 0 && $second == 1){
            $duration .= $second.' seconds';
        }

        // Second is greater than 1 add (s) to seconds
        if ($second > 0 && $second > 1){
            $duration .= $second.' seconds';
        }

        return $duration;
    }
}
