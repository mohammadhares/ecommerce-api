<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the Payments.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = Payment::query();

        if ($search_query) {
            $query->where('payment_method', 'like', '%' . $search_query . '%')
                  ->orWhere('amount', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response($result, 200);
    }

    /**
     * Store a newly created Payment in storage.
     */
    public function store(PaymentRequest $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|integer',
            'payment_card_id' => 'required|integer',
            'payment_method' => 'required|string|max:50',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        $payment = Payment::create($validatedData);
        return response($payment, 201);
    }

    /**
     * Display the specified Payment.
     */
    public function show(string $id)
    {
        $payment = Payment::findOrFail($id);
        return response($payment, 200);
    }

    /**
     * Update the specified Payment in storage.
     */
    public function update(PaymentRequest $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        $validatedData = $request->validate([
            'order_id' => 'sometimes|integer',
            'payment_card_id' => 'sometimes|integer',
            'payment_method' => 'sometimes|string|max:50',
            'amount' => 'sometimes|numeric',
            'payment_date' => 'sometimes|date',
        ]);

        $payment->update($validatedData);
        return response($payment, 200);
    }

    /**
     * Remove the specified Payment from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return response('Payment ' . $id . ' deleted successfully.', 200);
    }
}
