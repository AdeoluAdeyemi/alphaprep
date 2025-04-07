<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontendExamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')){
            return [
                //'id' => ['required', 'string', 'max:36'],
                'exam_session_id' => ['required', 'string', 'max:36'],
                'question_answer' => ['required', 'array'],
                'total_score' => ['required', 'integer', 'min:0'],
                'question_count' => ['required', 'integer', 'min:0'],
            ];
        }
        else {
            return [
                //'id' => ['required', 'string', 'max:36'],
                'exam_session_id' => ['nullable', 'string', 'max:36'],
                'question_answer' => ['nullable', 'array'],
                'total_score' => ['nullable', 'integer', 'min:0'],
                'question_count' => ['nullable', 'integer', 'min:0'],
            ];
        }
    }
}
