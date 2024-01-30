<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\StorePostRequest;
use App\Models\Post;
use App\Models\PostPhoto;
use App\Services\PostService\StorePostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            "posts"=> $posts
        ]);
    }
    public function approved()
    {
        $posts = Post::with('worker:id,name')->where('status', 'approved')->get();
        return response()->json([
            'approved posts'=> $posts
        ]);
    }
    public function store(StorePostRequest $request)
    {
        return (new StorePostService())->store($request);
    }
}
