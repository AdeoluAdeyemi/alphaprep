<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Exam;
use App\Models\Backend\Question;
use App\Models\Backend\Option;
use App\Models\Frontend\ExamSession;
use App\Models\Frontend\ExamResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class OldExamController extends Controller
{
    // Get all questions, show one question at a time
    public function index(Request $request)
    {
        // Get current page number
        $page = '';

        if ($request->has('page')) {
            $page = $request->query('page');
        }
        else{
            $page = 1;
        }

        $exam_id ='';
        if ($request->has('exam_id')){
            $exam_id = $request->query('exam_id');
        }
        else{
            $exam_id='8c2f4440-d284-4452-a84c-51503f968bfd';
        }

        return view('frontend.exams.practice-exam', [
            'currentPage' => $page,
            'pageCount' => Question::where('exam_id',$exam_id)->with('Options','Exam')->count(),
            'questions' => Question::where('exam_id',$exam_id)->orderBy('position', 'asc')->with('Options','Exam')->paginate(1),
            'check_answer_result' => (Session::has('check_answer_result') ? Session::get('check_answer_result') : null),
            'explanation' => (Session::has('explanation') ? Session::get('explanation') : null),
            'correct_answer' => (Session::has('correct_answer') ? Session::get('correct_answer') : null),
            'chosen_answer' => (Session::has('chosen_answer') ? Session::get('chosen_answer') : null),
        ]);
    }

    public function showQuestions(Request $request)
    {
        return view('frontend.exams.questions');

    }
    // Function responsible for starting an exam.
    public function getQuestions()
    {
        Log::info('I was called');

        $exam_id='8c2f4440-d284-4452-a84c-51503f968bfd';

        //$questions = Question::where('',$request->input(''))->get();
        $questions = Question::where('exam_id',$exam_id)->orderBy('position', 'asc')->with('Options','Exam')->get();

        Log::info(response()->json($questions));

        //return response()->json($questions);
        return $questions;
    }

    // Function for index view
    public function create(): View
    {
        return view('frontend.exams.index');
    }

    public function show(Question $question, Request $request) //:View
    {
        //return $question;
        return Option::with('Question')->paginate(1);
    }

    public function submitAnswer(Request $request):RedirectResponse
    {
        $question = $request->id;
        $chosen_answer = $request->chosen_answer;
        $currentPage = $request->currentPage;
        $nextPage = $currentPage + 1;
        $correct_answer = $request->correct_answer;

        if($request->currentPage == 1) // If this is the first question
        {
            // Create a new session record in the exam_sessions table, and return record id

            // Instantiate the Exam model using the exam id. Retrieve the Exam record from the database
            // $exam = Exam::find('650ab0fe-002f-4347-9eeb-37ac609cd612');

            // Save the record to the database
            $exam_session = ExamSession::create([
                'id' => Uuid::uuid4()->toString(),
                'exam_id' => '8c2f4440-d284-4452-a84c-51503f968bfd',
                'user_id' => $request->user()->id,
                'status' => 'incomplete',
                'mode' => 'practice'
            ]);

            // Put Exam_Session id into session as a current_exam
            Session::put('current_exam', $exam_session->id);

            // Create a new session variable, and pass the record id to it as an array
            Session::put($exam_session->id, [
                $question => [
                    'question_id' => $question,
                    'chosen_answer' => $chosen_answer,
                    'correct_answer' => $correct_answer,
                    'is_correct_answer' => ($chosen_answer == $correct_answer)? 'yes' : 'no'
                ]
            ]);

            // Retrieve the session variable, and save it as a record in the exam_response table.
        }
        elseif($request->currentPage == $request->pageCount){ // If this is the last question

            // Update it
            // Retrieve the exam_session from sessions
            // Update the exam_session in the exam_response table
            // Delete the session variable from session
        }
        else{

            if(Session::has('current_exam')){
                $exam_session = Session::get('current_exam');
            }
            else{
                // Update the session variable, with the new question submission
                $exam_session = ExamSession::where('exam_id','8c2f4440-d284-4452-a84c-51503f968bfd')->get();
                $exam_session = $exam_session[0]->id;
            }

            // Check if the session variable 'exam_session_id' exists
            if (Session::has($exam_session)) {
                // If the session variable exists, retrieve the current value
                $examSessionData = Session::get($exam_session);
            } else {
                // If the session variable doesn't exist, initialize an empty array
                $examSessionData = [];
            }

            // Add the new item to the array
            $examSessionData[$question] = [
                'question_id' => $question,
                'chosen_answer' => $chosen_answer,
                'correct_answer' => $correct_answer,
                'is_correct_answer' => ($chosen_answer == $correct_answer) ? 'yes' : 'no'
            ];

            // Update the 'exam_session_id' session variable with the modified array
            session()->put($exam_session, $examSessionData);

            // Move to the next question

        }

        Session::put('check_answer_result', ($chosen_answer == $correct_answer)? 'correct' : 'incorrect');
        Session::put('explanation', $request->explanation);
        Session::put('correct_answer', $request->correct_answer);
        Session::put('chosen_answer', $request->chosen_answer);
        Session::save();

        return redirect('exams/questions?page='.$currentPage);

    }

    public function finishPractice(Request $request):View
    {
        // Check if the session variable 'current_exam' exists
        if (Session::has('current_exam')) {
            // If the session variable exists, retrieve the current value
            $currentExam = Session::get('current_exam');
        }

        // Check if the session variable 'current_exam' exists
        if (Session::has($currentExam)) {
            // If the session variable exists, retrieve the current value
            $examResponseDetails = Session::get($currentExam);
            //print_r($examResponseDetails);

            $score = 0;
            $totalQuestions = count($examResponseDetails);

            foreach($examResponseDetails as $questionId => $questionResponse)
            {
                $score += ($questionResponse['is_correct_answer'] == 'yes') ? 1 : 0;
            }

            // End ExamSession
            $examSession = ExamSession::find($currentExam);
            $examSession->completion_time = Carbon::now();
            $examSession->status = 'completed';
            $examSession->save();

            // Put Exam_Session array into ExamResponse table
            // Save the record to the database
            // $exam_session = new ExamResponse([
            //     'id' => Uuid::uuid4()->toString(),
            //     'question_answer' => $examResponseDetails
            // ]);
            // Save exam_session record in ExamResponse table
            //$exam_types->exams()->save($exam);

            // print_r($currentExam);
            // print_r($examResponseDetails);

            // Convert the array to a JSON string
            $questionAnswerJson = json_encode($examResponseDetails);

            ExamResponse::create([
                'id' => Uuid::uuid4()->toString(),
                'exam_session_id' => $currentExam,
                'question_answer' => $questionAnswerJson
            ]);

            // print_r($exam_response);


            print_r('Total Score: '.$score.'/'.$totalQuestions);
        }

        return view('frontend.exams.result');
    }

    function checkAnswer($chosen_answer, $correct_answer)
    {
        // Check if answer is correct

        // If correct show the correct answer alert
        if($chosen_answer == $correct_answer){
            return true;
        }
        else{
            return false;
        }
        // Else show the incorrect answer alert and explanation
    }
}
