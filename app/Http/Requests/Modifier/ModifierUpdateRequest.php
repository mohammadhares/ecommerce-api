<?php

namespace App\Http\Requests\Modifier;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ModifierUpdateRequest extends FormRequest
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
            'product_id' => 'required',
            'name' => 'required',
            'description' => 'required|string',
            'price' => 'required',
            'type' => 'required|string',
        ];
    }

     // display error messages
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response()->json($validator->errors(), 422));
     }
}
