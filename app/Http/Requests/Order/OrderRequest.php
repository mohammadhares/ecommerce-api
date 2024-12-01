<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
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
            'customer_id' => 'sometimes|integer',
            'cart_id' => 'sometimes|integer',
            'address_id' => 'sometimes|integer',
            'total_amount' => 'sometimes|numeric',
            'delivery_date' => 'sometimes|date',
            'delivery_time' => 'sometimes',
            'delivery_fee' => 'sometimes|numeric',
            'status' => 'sometimes|string',
            'payment_status' => 'sometimes|string',
        ];
    }

     // display error messages
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response()->json($validator->errors(), 422));
     }
}
