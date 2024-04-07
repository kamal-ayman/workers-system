<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkerProfileController extends Controller
{
    public function userProfile() {
        return response()->json(auth()->guard('worker')->user());
    }
}
