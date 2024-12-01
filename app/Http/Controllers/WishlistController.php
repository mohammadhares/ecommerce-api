<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the wishlists.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');

        $query = WishList::query();
        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response($result, 200);
    }

    /**
     * Store a newly created wishlist in storage.
     */
    public function store(WishList $request)
    {
        $wishlist = WishList::create($request->all());
        return response($wishlist, 201);
    }

    /**
     * Display the specified wishlist.
     */
    public function show(string $id)
    {
        $wishlist = WishList::findOrFail($id);
        return response($wishlist, 200);
    }

    /**
     * Remove the specified wishlist from storage.
     */
    public function destroy(string $id)
    {
        $wishlist = WishList::findOrFail($id);
        $wishlist->delete();
        return response('WishList ' . $id . ' deleted successfully.', 200);
    }
}
