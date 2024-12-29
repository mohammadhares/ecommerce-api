<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the Orders.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');
        $customer_id = $request->input('customer_id');



        $query = Order::query();
        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }
        $query->with([
            'customer',
            'cart',
            'address',
            'payments'
        ]);

        if ($search_query) {
            $query->where('status', 'like', '%' . $search_query . '%')
                  ->orWhere('payment_status', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created Order in storage.
     */
    public function store(OrderRequest $request)
    {
        $order = Order::create($request->all());
        return response()->json($order, 201);
    }

    /**
     * Display the specified Order.
     */
    public function show(string $id)
    {
        $order = Order::with([
            'customer',
            'cart',
            'address',
            'payments'
        ])->findOrFail($id);
        return response()->json($order, 200);
    }

    /**
     * Update the specified Order in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json($order, 200);
    }

    /**
     * Remove the specified Order from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json('Order ' . $id . ' deleted successfully.', 200);
    }
}
