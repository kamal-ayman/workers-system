<?php
use App\Http\Controllers\{ClientController, WorkerController, AdminController};
use App\Http\Controllers\AdminDashboard\AdminNotificationController;
use App\Http\Controllers\AdminDashboard\PostStatusController;
use App\Http\Controllers\ClientOrderController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::controller(AdminController::class)->prefix('admin')->group(function ($router) {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
    });

    Route::controller(WorkerController::class)->prefix('worker')->group(function ($router) {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
        Route::get('/verify/{token}', 'verify');
    });

    Route::controller(ClientController::class)->prefix('client')->group(function ($router) {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
    });
});
Route::middleware('auth:worker')->get('worker/orders/pending', [ClientOrderController::class, 'workerOrder']);

Route::get('/unauthorized', function () {
    return response()->json([
        'message'=> 'Unauthorized'
        ], 401);
})->name('login');


Route::controller(PostController::class)->prefix('worker/post')->group(function () {
    Route::post('/add','store')->middleware('auth:worker');
    Route::get('/index','index')->middleware('auth:admin');
    Route::get('/approved','approved');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::controller(PostStatusController::class)->prefix('post')->group(function () {
        Route::post('/status','changeStatus');
    });
});

Route::controller(AdminNotificationController::class)
    ->middleware('auth:admin')
    ->prefix('admin/notificaion')
    ->group(function ($router) {
        Route::get('/get-all','indexAll');
        Route::get('/get-read-all','indexAllRead');
        Route::get('/get-unread-all','indexAllUnread');

        Route::put('/update-read-all','updateMarkAllAsRead');
        Route::put('/update-unread-all','updateMarkAllAsUnRead');

        Route::put('/mark-as-read/{id}','markAsRead');
        Route::put('/mark-as-unread/{id}','markAsUnRead');

        Route::delete('/delete-all','deleteAll');
        Route::delete('/delete/{id}','delete');
});

Route::prefix('client')->group(function () {
    Route::controller(ClientOrderController::class)->prefix('order')->group(function () {
        Route::post('/request','addOrder')->middleware('auth:client');
    });
});

