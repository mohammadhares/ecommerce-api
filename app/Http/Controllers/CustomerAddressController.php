<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerAddressRequest;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the Customer Address.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = CustomerAddress::query();

        if ($search_query) {
            $query->where('email', 'like', '%' . $search_query . '%')
                ->orWhere('address_line', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response($result, 200);
    }

    /**
     * Store a newly created Customer Address in storage.
     */
    public function store(CustomerAddressRequest $request)
    {
        $address = new CustomerAddress();
        $address->customer_id = $request->customer_id;
        $address->address_line = $request->address_line;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip_code = $request->zip_code;
        $address->country = $request->country;
        $address->save();
        return response($address, 201);
    }

    /**
     * Display the specified Customer Address.
     */
    public function show(string $id)
    {
        $address = CustomerAddress::findOrFail($id);
        return response($address, 200);
    }

    /**
     * Update the specified Customer Address in storage.
     */
    public function update(CustomerAddressRequest $request, string $id)
    {
        $address = CustomerAddress::findOrFail($id);
        $address->customer_id = $request->customer_id;
        $address->address_line = $request->address_line;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip_code = $request->zip_code;
        $address->country = $request->country;
        $address->save();
        return response($address, 200);
    }

    /**
     * Remove the specified Customer Address from storage.
     */
    public function destroy(string $id)
    {
        $address = CustomerAddress::findOrFail($id);
        $address->delete();
        return response('customer address ' . $id . ' deleted sucessfully.', 200);
    }
}
