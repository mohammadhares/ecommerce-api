<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
        /**
     * Display a listing of the Contacts.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = Product::query();

        if ($search_query) {
            $query->where('name', 'like', '%' . $search_query . '%')
                ->orWhere('description', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response($result, 200);
    }

    /**
     * Store a newly created Product in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $file = $request->file('image');
        $name = "uploads/products/" . time() . '' . $file->getClientOriginalName();
        $file->move("uploads/products/", $name);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->base_price = $request->base_price;
        $product->quantity = $request->quantity;
        $product->discount = $request->discount;
        $product->is_available = $request->is_available;
        $product->image = $name;
        $product->save();
        return response($product, 201);
    }

    /**
     * Display the specified Product.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return response($product, 200);
    }

    /**
     * Update the specified Product in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        if ($request->file('image')) {
            $file = $request->file('image');
            $name = "uploads/products/" . time() . '' . $file->getClientOriginalName();
            $file->move("uploads/products/", $name);
        } else {
            $name = $product->image;
        }

        $product = Product::findOrFail($id);
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->base_price = $request->base_price;
        $product->quantity = $request->quantity;
        $product->discount = $request->discount;
        $product->is_available = $request->is_available;
        $product->image = $name;
        $product->save();
        return response($product, 200);
    }

    /**
     * Remove the specified Product from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response('product ' . $id . ' deleted sucessfully.', 200);
    }
}
