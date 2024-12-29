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
        $payment_card_id = $request->input('payment_card_id');

        if (!$payment_card_id) {
            return response()->json(['message' => 'Payment Card ID is required'], 400);
        }

        $query = Payment::query();
        $query->where('payment_card_id', $payment_card_id);
        $query->with([
            'order',
            'paymentCard'
        ]);

        if ($search_query) {
            $query->where('payment_method', 'like', '%' . $search_query . '%')
                ->orWhere('amount', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created Payment in storage.
     */
    public function store(PaymentRequest $request)
    {
        $payment = Payment::create($request->all());
        return response()->json($payment, 201);
    }

    /**
     * Display the specified Payment.
     */
    public function show(string $id)
    {
        $payment = Payment::with([
            'order',
            'paymentCard'
        ])->findOrFail($id);
        return response()->json($payment, 200);
    }

    /**
     * Update the specified Payment in storage.
     */
    public function update(PaymentRequest $request, string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        return response()->json($payment, 200);
    }

    /**
     * Remove the specified Payment from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return response()->json('Payment ' . $id . ' deleted successfully.', 200);
    }
}
