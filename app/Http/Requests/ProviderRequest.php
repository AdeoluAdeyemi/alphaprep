<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => ($this->exists('IsPreviousLogoRemoved') == false) ? ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg','max:2048'] : ($this->hasFile('logo') && $this->file('logo')->isValid() ? ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg','max:2048'] : ['nullable', 'string', 'max:255']),
            'slug' => 'required|string|max:20',
            'status' => 'required|boolean|max:1',
            'featured' => 'required|boolean|max:1',
            'url' => 'required|string|max:100',
            'category_id' => ($this->exists('hasNewCategory') == true && $this->input('hasNewCategory') == false) ? 'nullable|uuid|max:36' : 'required|uuid|max:36',
        ];
    }
}
