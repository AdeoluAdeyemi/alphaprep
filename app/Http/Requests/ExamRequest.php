<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1500'],
            'logo' => ($this->exists('IsPreviousLogoRemoved') == false) ? ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg','max:2048'] : ($this->hasFile('logo') && $this->file('logo')->isValid() ? ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg','max:2048'] : ['nullable', 'string', 'max:255']),
            'slug' => ['required', 'string', 'max:255'],
            'version' => ['nullable', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'max:255'],
            'timer' => ['required', 'integer', 'max:1'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:2050'],
            'price' => ['required', 'integer'],
            'pass_mark' => ['required', 'integer'],
            'price_usd' => ['required', 'integer'],
            'price_gbp' => ['required', 'integer'],
        ];
    }
}
