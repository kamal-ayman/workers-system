<?php

namespace App\Services\PostService;

use App\Models\Admin;
use App\Models\Post;
use App\Models\PostPhoto;
use App\Notifications\AdminPostNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class StorePostService {
    protected $post;
    public function __construct() {
        $this->post = new Post();
    }
    public function adminPercent($price) {
        $discount = $price * 0.05;
        $price -= $discount;
        return $price;
    }
    public function storePost($request) {
        $data = $request->except('photos');
        $data['worker_id'] = auth()->guard('worker')->id();
        $data['price'] = $this->adminPercent($data['price']);
        $post = Post::create($data);
        return $post;
    }
    public function storePostPhotos($request, $postId) {
        foreach ($request->file('photos') as $photo) {
            $postPhoto = new PostPhoto();
            $postPhoto->post_id = $postId;
            $postPhoto->photo = $photo->store('photos/posts');
            $postPhoto->save();
        }
    }
    public function sendAdminNotification($post) {
        $admins = Admin::get();
        Notification::send($admins, new AdminPostNotification(auth()->guard('worker')->user(), $post));
    }
    public function store($request)
    {
        try {
            DB::beginTransaction();
            $post = $this->storePost($request);
            if ($request->hasFile('photos')) {
                $this->storePostPhotos($request, $post->id);
            }
            $this->sendAdminNotification($post);
            DB::commit();
            return response()->json(['message'=> 'post has been created successfully!', 'priceAfterDiscout' => $post->price],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message'=> $e->getMessage()],500);
        }
    }
}
