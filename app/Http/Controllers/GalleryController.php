<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\GalleryStoreRequest;
use App\Http\Requests\Product\GalleryUpdateRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
        /**
     * Display a listing of the Gallery.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $product_id = $request->input('product_id');

        if(!$product_id){
            return response()->json(['message' => 'Product ID is required'], 400);
        }

        $query = Gallery::query();
        $query->where('product_id', $product_id);
        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created Gallery in storage.
     */
    public function store(GalleryStoreRequest $request)
    {
        $file = $request->file('image');
        $name = "uploads/gallery/" . time() . '' . $file->getClientOriginalName();
        $file->move("uploads/gallery/", $name);

        $gallery = new Gallery();
        $gallery->product_id = $request->product_id;
        $gallery->image = $name;
        $gallery->save();
        return response()->json($gallery, 201);
    }

    /**
     * Display the specified Gallery.
     */
    public function show(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json($gallery, 200);
    }

    /**
     * Update the specified Gallery in storage.
     */
    public function update(GalleryUpdateRequest $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($request->file('image')) {
            $file = $request->file('image');
            $name = "uploads/gallery/" . time() . '' . $file->getClientOriginalName();
            $file->move("uploads/gallery/", $name);
        } else {
            $name = $gallery->image;
        }

        $gallery = Gallery::findOrFail($id);
        $gallery->product_id = $request->product_id;
        $gallery->image = $name;
        $gallery->save();
        return response()->json($gallery, 200);
    }

    /**
     * Remove the specified Gallery from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        return response()->json('gallery ' . $id . ' deleted sucessfully.', 200);
    }
}
