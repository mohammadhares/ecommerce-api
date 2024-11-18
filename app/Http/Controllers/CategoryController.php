<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the Categories.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = Category::query();

        if ($search_query) {
            $query->where('name', 'like', '%' . $search_query . '%')
                ->orWhere('description', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response($result, 200);
    }

    /**
     * Store a newly created Category in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return response($category, 201);
    }

    /**
     * Display the specified Category.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return response($category, 200);
    }

    /**
     * Update the specified Category in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response($category, 200);
    }

    /**
     * Remove the specified Category from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response('category ' . $id . ' deleted sucessfully.', 200);
    }
}
