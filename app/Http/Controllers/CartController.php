<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the Cart.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = Cart::query();

        if ($search_query) {
            $query->where('quantity', 'like', '%' . $search_query . '%')
                ->orWhere('status', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created Cart in storage.
     */
    public function store(CartRequest $request)
    {
        $cart = new Cart();
        $cart->customer_id = $request->customer_id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->total_price = $request->total_price;
        $cart->status = 'PENDING';
        $cart->save();
        return response()->json($cart, 201);
    }

    /**
     * Display the specified Cart.
     */
    public function show(string $id)
    {
        $cart = Cart::findOrFail($id);
        return response()->json($cart, 200);
    }

    /**
     * Update the specified Cart  in storage.
     */
    public function update(CartRequest $request, string $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->customer_id = $request->customer_id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->total_price = $request->total_price;
        $cart->status = 'PENDING';
        $cart->save();
        return response()->json($cart, 200);
    }

    /**
     * Remove the specified Cart  from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return response()->json('cart ' . $id . ' deleted sucessfully.', 200);
    }
}
