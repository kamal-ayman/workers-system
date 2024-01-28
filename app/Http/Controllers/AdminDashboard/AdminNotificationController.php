<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminNotificationController extends Controller
{

    public function markAsRead($id) {
        DB::table('notifications')
              ->where('id', $id)
              ->update(['read_at' => now()]);
        return response()->json([
            "message"=> "mark As Read seccussfully!"
        ]);
    }
    public function markAsUnRead($id) {
        DB::table('notifications')
              ->where('id', $id)
              ->update(['read_at' => null]);
        return response()->json([
            "message"=> "mark As UnRead seccussfully!"
        ]);
    }
    public function delete($id) {
        DB::table('notifications')
              ->where('id', $id)
              ->delete();
        return response()->json([
            "message"=> "deleted seccussfully!"
        ]);
    }
    function indexAll() {
        // auth()->id()
        $admin = Admin::find(auth()->id());
        return response()->json([
            "message"=> $admin->notifications
        ]);
    }
    function indexAllUnread() {
        // auth()->id()
        $admin = Admin::find(auth()->id());
        return response()->json([
            "message"=> $admin->unreadNotifications
        ]);
    }
    function indexAllRead() {
        // auth()->id()
        $admin = Admin::find(auth()->id());
        return response()->json([
            "message"=> $admin->readNotifications
        ]);
    }
    function updateMarkAllAsRead() {
        $admin = Admin::find(auth()->id());
        foreach ($admin->notifications as $notification) {
            $notification->markAsRead();
        }        return response()->json([
            "message"=> "Marked all as read successfully!",
        ]);
    }
    // function updateMarkAllAsUnRead() {
    //     $admin_id = Admin::find(2)->id();
    //     return $admin_id;
    //     DB::table('notifications')
    //         ->where('notifiable_id', $admin_id)
    //         ->delete();

    //     // foreach ($admin->notifications as $notification) {
    //     //     $notification->();
    //     // }
    //     return response()->json([
    //         "message"=> "Marked all as read successfully!",
    //     ]);
    // }
    function delelteAll() {
        $admin = Admin::find(1);
        $admin->notifications()->delete();
        return response()->json([
            "message"=> "Deleted All successfully!",
        ]);
    }
}
