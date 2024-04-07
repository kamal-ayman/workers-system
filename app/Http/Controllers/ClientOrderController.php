<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Interfaces\CrudRepoInterface;
use App\Models\ClientOrder;
use Illuminate\Http\Request;

class ClientOrderController extends Controller
{
    protected $crudRepo;
    public function __construct(CrudRepoInterface $crudRepo) {
        $this->crudRepo = $crudRepo;
    }
    public function addOrder(ClientOrderRequest $request) {
        return $this->crudRepo->store($request);
    }
    public function workerOrder() {
        $orders = ClientOrder::with('post', 'client')->whereStatus("pending")->whereHas('post', function($query) {
            $query->where('worker_id', auth()->guard('worker')->id());
        })->get();
        return response()->json([
            "orders"=> $orders
        ]);
    }
    public function updateOrder($id, Request $request) {
        $order = ClientOrder::findOrFail($id);
        $order->setAttribute('status', $request->status)->save();
        return response()->json([
            'message'=> 'updated successfully!'
        ]);
    }

}
