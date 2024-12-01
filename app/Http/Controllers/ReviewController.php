<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the Reviews.
     */
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = Review::query();

        if ($search_query) {
            $query->where('comment', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response($result, 200);
    }

    /**
     * Store a newly created Review in storage.
     */
    public function store(ReviewRequest $request)
    {
        $review = Review::create($request->all());
        return response($review, 201);
    }

    /**
     * Display the specified Review.
     */
    public function show(string $id)
    {
        $review = Review::findOrFail($id);
        return response($review, 200);
    }

    /**
     * Update the specified Review in storage.
     */
    public function update(ReviewRequest $request, string $id)
    {
        $review = Review::findOrFail($id);
        $review->update($request->all());
        return response($review, 200);
    }

    /**
     * Remove the specified Review from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response('Review ' . $id . ' deleted successfully.', 200);
    }
}
