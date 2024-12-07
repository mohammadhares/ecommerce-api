<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\PaymendCardRequest;
use App\Models\PaymentCard;
use Illuminate\Http\Request;

class PaymentCardController extends Controller
{
    /**
     * Display a listing of the Payment Cards.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = PaymentCard::query();

        if ($search_query) {
            $query->where('company', 'like', '%' . $search_query . '%')
                ->orWhere('card_owner', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created Payment Card in storage.
     */
    public function store(PaymendCardRequest $request)
    {
        $card = new PaymentCard();
        $card->company = $request->company;
        $card->card_number = $request->card_number;
        $card->card_owner = $request->card_owner;
        $card->expire_date = $request->expire_date;
        $card->save();
        return response()->json($card, 201);
    }

    /**
     * Display the specified Payment Card.
     */
    public function show(string $id)
    {
        $card = PaymentCard::findOrFail($id);
        return response()->json($card, 200);
    }

    /**
     * Update the specified Payment Card in storage.
     */
    public function update(PaymendCardRequest $request, string $id)
    {
        $card = PaymentCard::findOrFail($id);
        $card->update($request->all());
        return response()->json($card, 200);
    }

    /**
     * Remove the specified Payment Card from storage.
     */
    public function destroy(string $id)
    {
        $card = PaymentCard::findOrFail($id);
        $card->delete();
        return response()->json('payment card ' . $id . ' deleted sucessfully.', 200);
    }
}
