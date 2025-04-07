<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
    return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'string', 'max:36'],
            'title' => ['required', 'string', 'max:1500'],
            'question_type' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'integer', 'max:100'],
            'code_snippet' => ['nullable', 'string'],
            'exam_id' => ['required', 'string', 'max:36'],
            'option_id' => ['required', 'string', 'max:36'],
            'correct_answer' => ['required', 'string'],
            'explanation' => ['required', 'string'],
            'options' => ['required', 'array', 'min:4'],
        ];
    }
}
