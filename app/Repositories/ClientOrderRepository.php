<?php

namespace App\Repositories;
use App\Interfaces\CrudRepoInterface;
use App\Models\ClientOrder;
use Dotenv\Repository\RepositoryInterface;

class ClientOrderRepository implements CrudRepoInterface
{
    function store($request) {
        $clientId = auth()->guard('client')->id();
        $isOrderExists = ClientOrder::where('client_id', $clientId)
                            ->where('post_id', $request->post_id)->exists();
        if ($isOrderExists) {
            return response()->json([
                'message'=> 'duplicated order!',
            ], 406);
        }
        $data = $request->all();
        $data['client_id'] = auth()->guard('client')->id();
        $order = ClientOrder::create($data);
        return response()->json([
            'message'=> 'success',
        ]);
    }
}
