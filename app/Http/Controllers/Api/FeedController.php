<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Feed;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FeedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $qb = Feed::with(['category']);
        $categoryId = intval($request->input('categoryId'));
        if ($categoryId > 0) {
            $qb = $qb->where('category_id', $categoryId);
        }
        $feeds = $qb->orderBy('created_at', 'desc')->paginate(12);

        return response()->json(['feeds' => $feeds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'description' => 'required|string',
            'link' => 'required|active_url',
            'published_at' => 'required|date',
        ]);
        if (!$request->has('category')) {
            throw new BadRequestHttpException("Missing category");
        }
        $category = $request->get('category');
        if (!array_key_exists('id', $category) || $category['id'] < 0){
            throw new BadRequestHttpException("Invalid category");
        }
        $category = Category::findOrFail($category['id']);


        $feed = new \App\Feed();
        $feed->title = $validatedData['title'];
        $feed->content = $validatedData['content'];
        $feed->description = $validatedData['description'];
        $feed->link = $validatedData['link'];
        $feed->published_at = $validatedData['published_at'];
        $feed->category()->associate($category);
        $feed->save();

        return response()->json($feed, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Feed::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $feed = Feed::findOrFail($id);
        $feed->update($request->all());

        return $feed;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feed = Feed::findOrFail($id);
        $feed->delete();
        return $feed;
    }
}
