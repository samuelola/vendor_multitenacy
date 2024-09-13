<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'name'=> 'required',
           'price' => 'required',
           'image' => 'required|image|mimes:jpeg,jpg,png,svg,jfif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'image.max' => 'The Image should not be more than 2MB',
        ];
    }
}
