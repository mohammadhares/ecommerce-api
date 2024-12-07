<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
      /**
     * Display a listing of the Customer.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = Customer::query();

        if ($search_query) {
            $query->where('name', 'like', '%' . $search_query . '%')
                ->orWhere('email', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created Customer in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        $file = $request->file('image');
        $name = "uploads/customer/" . time() . '' . $file->getClientOriginalName();
        $file->move("uploads/customer/", $name);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->bio = $request->bio;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->image = $name;
        $customer->save();
        return response()->json($customer, 201);
    }

    /**
     * Display the specified Customer.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer, 200);
    }

    /**
     * Update the specified Customer in storage.
     */
    public function update(CustomerUpdateRequest $request, string $id)
    {
        $customer = Customer::findOrFail($id);
        if ($request->file('image')) {
            $file = $request->file('image');
            $name = "uploads/customer/" . time() . '' . $file->getClientOriginalName();
            $file->move("uploads/customer/", $name);
        } else {
            $name = $customer->image;
        }

        $customer->name = $request->name;
        $customer->bio = $request->bio;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->image = $name;
        $customer->save();
        return response()->json($customer, 200);
    }

    /**
     * Remove the specified Customer from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json('customer ' . $id . ' deleted sucessfully.', 200);
    }
}
