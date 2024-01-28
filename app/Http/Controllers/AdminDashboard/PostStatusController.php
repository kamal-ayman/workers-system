<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\PostStatusRequest;
use App\Models\Post;
use App\Models\Worker;
use App\Notifications\AdminPostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostStatusController extends Controller
{
    public function changeStatus(PostStatusRequest $request) {
        $post = Post::find($request->post_id);
        $post->status = $request->status;
        $post->rejected_reason = $request->rejected_reason;
        $post->save();
        Notification::send($post->worker, new AdminPostNotification($post->worker, $post));
        return response()->json([
            "message" => "$post->status successfully!",
        ]);

        // ->update([
        //     "status"=> $request->status,
        //     "reqjected_reason" => $request->reqjected_reason,
        // ]);
    }
    public function approve($postId) {
        $post = Post::find($postId);
        $post->status = "approved";
        $post->save();
        return response()->json([
            "message" => "approved successfully!",
        ]);
    }
}
