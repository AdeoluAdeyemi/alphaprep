<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
// use App\Models\Frontend\Exam;
use App\Models\Order;
use Ramsey\Uuid\Uuid;
use App\Models\Backend\Exam;
use Illuminate\Http\Request;
use App\Models\Backend\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Cryptography;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Frontend\ExamSession;
use Illuminate\Support\Facades\Auth;
use App\Models\Frontend\ExamResponse;
use Illuminate\Database\Query\JoinClause;
use Coderflex\LaravelTicket\Models\Ticket;
use App\Http\Controllers\Frontend\ExamController;
use Illuminate\Support\Facades\Request as FRequest;

class MyAccountController extends Controller
{
    //
    public function dashboard()
    {
        $user = Auth::user()->id;
        $exam_purchased = $this->getExamPurchased($user, 0);

        //print_r($exam_purchased);

        return Inertia::render('Frontend/MyAccount/Dashboard',[

            'exams_purchased' => 5,
            'exams_practiced' => 3,
            'invoices' =>  3,
            'tickets' =>  sizeof(Ticket::where('user_id', $user)->get()),
            'exam_purchased' =>  $exam_purchased,
            'exam_practised' =>  sizeof(ExamSession::where('user_id', $user)->get())
            // Retrieve all categories in the database
            // //Exam::find($request->exam_id)
            // 'questions' => Question::where('exam_id','1b726589-f72e-4114-88cb-2a41463d94cb')
            // ->orderBy('created_at', 'desc')
            //     ->with('Exam','Options')
            //     ->paginate(1),
            // 'questions' => Question::where('exam_id','8c2f4440-d284-4452-a84c-51503f968bfd')->orderBy('position', 'asc')->with('Options','Exam')->paginate(1),
        ]);
    }

    //
    public function purchased(Request $request)
    {
        $user = Auth::user()->id;
        $exam_purchased = $this->getExamPurchased($user, 10);

        return Inertia::render('Frontend/MyAccount/ExamPurchased',[
            'filters' => FRequest::only(['search']),
            // 'exams' => Exam::select('exams.id', 'exams.name', 'exams.slug', 'exams.description', 'exams.year', 'exams.logo', 'exams.timer', 'providers.slug as provider_name', 'order_result.total as price', 'order_result.status as status', 'order_result.id as order_id', 'order_result.created_at as order_date', 'order_result.updated_at as transaction_date')
            //     ->join('providers', 'exams.provider_id', '=', 'providers.id')
            //     ->join(DB::raw(
            //                 '(SELECT order_product.product_id, orders.id, orders.status, orders.user_id, orders.total, orders.created_at, orders.updated_at
            //                     FROM orders
            //                     INNER JOIN order_product ON order_product.order_id = orders.id
            //                     WHERE orders.status IN ("completed", "success") AND orders.user_id = "9baaf2f2-52a5-4c93-9606-cec5135a5cbf"
            //                 ) AS order_result'
            //             ), function ($join) {
            //                 $join->on('order_result.product_id', '=', 'exams.id'); //ON dt.product_id = exams.id
            //             })
            //     ->when(FRequest::input('search'), function ($query, $search) {
            //         $query->where('exams.name', 'like', "%{$search}%");
            //     })
            //     ->paginate(10)
            'exams' => $exam_purchased
        ]);
    }

    //
    public function practiced(Request $request)
    {
        return Inertia::render('Frontend/MyAccount/ExamPracticed',[
            'exam_sessions' => ExamSession::where('user_id', $request->user()->id)
                ->with('Exam','Exam_Response')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($session) => [
                    'exam_details' => [
                        'exam_name' =>  $session->exam()->get()->pluck('name')->first(),
                        'duration' =>  $session->completion_time != null ? (new ExamController)->getDuration($session->created_at, $session->completion_time) : null,
                        'start_time' =>  $session->created_at,
                        'exam_id' =>  $session->exam_id,
                        'exam_slug' => $session->exam()->get()->pluck('slug')->first(),
                        'provider_slug' => $session->provider()->get()->pluck('slug')->first(),
                        'exam_session_id' => $session->id,
                        'exam_response' => $session->exam_response()->get()->pluck('question_answer')->first(),
                        'total_score' => $session->exam_response()->get()->pluck('total_score')->first(),
                        'question_count' => $session->exam_response()->get()->pluck('question_count')->first(),
                        'status' => $session->status == 0 ? 'incomplete' : 'complete',
                        'pass_mark' => $session->exam()->get()->pluck('pass_mark')->first()
                    ],
                ]),
        ]);
    }

    public function getExamPurchased(string $user, int $pagination)
    {
        $exams = Exam::select('exams.id', 'exams.name', 'exams.slug', 'exams.description', 'exams.year', 'exams.logo', 'exams.timer', 'providers.slug as provider_name', 'order_result.total as price', 'order_result.status as status', 'order_result.id as order_id', 'order_result.created_at as order_date', 'order_result.updated_at as transaction_date')
                ->join('providers', 'exams.provider_id', '=', 'providers.id')
                ->join(DB::raw(
                            '(SELECT order_product.product_id, orders.id, orders.status, orders.user_id, orders.total, orders.created_at, orders.updated_at
                                FROM orders
                                INNER JOIN order_product ON order_product.order_id = orders.id
                                WHERE orders.status IN ("completed", "success") AND orders.user_id = "'.$user .'"
                            ) AS order_result'
                        ), function ($join) {
                            $join->on('order_result.product_id', '=', 'exams.id'); //ON dt.product_id = exams.id
                        })
                ->when(FRequest::input('search'), function ($query, $search) {
                    $query->where('exams.name', 'like', "%{$search}%");
                })->paginate(($pagination > 0 ) ? $pagination : 0);

        return $exams;
    }

}
