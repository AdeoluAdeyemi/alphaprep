<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return Auth::check();
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'string', 'max:36'],
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string'],
            'title' => ['required', 'string'],
            'message' => ['required', 'string'],
            'file' => ['nullable',File::types(['pdf', 'image'])
                                    ->min(1024)
                                    ->max(2*1024)
                      ], // $this->hasFile('file') && $this->file('file')->isValid()
            'priority' => ['required', 'string'],
            'category' => ['required', 'integer'],
        ];
    }
}
