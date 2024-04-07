<?php

namespace App\Http\Controllers;

use App\Filters\PostFilter;
use App\Http\Requests\Posts\StorePostRequest;
use App\Models\Post;
use App\Models\PostPhoto;
use App\Services\PostService\StorePostService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
        $posts = QueryBuilder::for(Post::class)
                    ->allowedFilters((new PostFilter)->filter())
                    ->with('worker:id,name')
                    ->where('status', 'approved')
                    ->get(['id', 'content', 'price', 'worker_id']);

        // $posts = Post::with('worker:id,name')->get();
        return response()->json([
            'approved posts'=> $posts
        ]);
    }
    public function store(StorePostRequest $request)
    {
        return (new StorePostService())->store($request);
    }
}
