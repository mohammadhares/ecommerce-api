<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CartRequest extends FormRequest
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
     * Get the validation rules that apply to the request. ['customer_id', 'product_id', 'quantity', 'total_price', 'status'];
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'total_price' => 'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
