<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::guard('api')->user();
        return $user ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer|exists:categories,id', // Must exist in the categories table
            'name' => 'required|string|max:255', // Maximum length of 255 characters
            'description' => 'required|string|max:1000', // Maximum length of 1000 characters
            'base_price' => 'required|numeric|min:0', // Must be a number greater than or equal to 0
            'quantity' => 'required|integer|min:1', // Must be an integer greater than or equal to 1
            'discount' => 'nullable|numeric|min:0|max:100', // Must be a number between 0 and 100
            'is_available' => 'required|boolean', // Must be a boolean (true/false or 1/0)
        ];
    }

     // display error messages
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response()->json($validator->errors(), 422));
     }
}
