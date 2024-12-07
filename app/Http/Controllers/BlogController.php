<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
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

        $query = Blog::query();

        if ($search_query) {
            $query->where('title', 'like', '%' . $search_query . '%')
                ->orWhere('subtitle', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created Contact in storage.
     */
    public function store(BlogStoreRequest $request)
    {
        $file = $request->file('image');
        $name = "uploads/blog/" . time() . '' . $file->getClientOriginalName();
        $file->move("uploads/blog/", $name);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->subtitle = $request->subtitle;
        $blog->content = $request->content;
        $blog->image = $name;
        $blog->save();
        return response()->json($blog, 201);
    }

    /**
     * Display the specified Blog.
     */
    public function show(string $id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog, 200);
    }

    /**
     * Update the specified Blog in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($request->file('image')) {
            $file = $request->file('image');
            $name = "uploads/blog/" . time() . '' . $file->getClientOriginalName();
            $file->move("uploads/blog/", $name);
        } else {
            $name = $blog->image;
        }

        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->subtitle = $request->subtitle;
        $blog->content = $request->content;
        $blog->image = $name;
        $blog->save();
        return response()->json($blog, 200);
    }

    /**
     * Remove the specified Contact from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json('blog ' . $id . ' deleted sucessfully.', 200);
    }
}
