<?php

namespace App\Http\Controllers;

use App\Http\Requests\Modifier\ModifierStoreRequest;
use App\Http\Requests\Modifier\ModifierUpdateRequest;
use App\Models\Modifier;
use Illuminate\Http\Request;

class ModifierController extends Controller
{
      /**
     * Display a listing of the Modifiers.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = Modifier::query();

        if ($search_query) {
            $query->where('name', 'like', '%' . $search_query . '%')
                ->orWhere('description', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created Modifier in storage.
     */
    public function store(ModifierStoreRequest $request)
    {
        $file = $request->file('image');
        $name = "uploads/products/" . time() . '' . $file->getClientOriginalName();
        $file->move("uploads/products/", $name);

        $modifier = new Modifier();
        $modifier->product_id = $request->product_id;
        $modifier->name = $request->name;
        $modifier->description = $request->description;
        $modifier->price = $request->price;
        $modifier->type = $request->type;
        $modifier->image = $name;
        $modifier->save();
        return response()->json($modifier, 201);
    }

    /**
     * Display the specified Modifier.
     */
    public function show(string $id)
    {
        $modifier = Modifier::findOrFail($id);
        return response()->json($modifier, 200);
    }

    /**
     * Update the specified Modifier in storage.
     */
    public function update(ModifierUpdateRequest $request, string $id)
    {
        $modifier = Modifier::findOrFail($id);
        if ($request->file('image')) {
            $file = $request->file('image');
            $name = "uploads/modifier/" . time() . '' . $file->getClientOriginalName();
            $file->move("uploads/modifier/", $name);
        } else {
            $name = $modifier->image;
        }

        $modifier->product_id = $request->product_id;
        $modifier->name = $request->name;
        $modifier->description = $request->description;
        $modifier->price = $request->price;
        $modifier->type = $request->type;
        $modifier->image = $name;
        $modifier->save();
        return response()->json($modifier, 200);
    }

    /**
     * Remove the specified Modifier from storage.
     */
    public function destroy(string $id)
    {
        $modifier = Modifier::findOrFail($id);
        $modifier->delete();
        return response()->json('modifier ' . $id . ' deleted sucessfully.', 200);
    }
}
