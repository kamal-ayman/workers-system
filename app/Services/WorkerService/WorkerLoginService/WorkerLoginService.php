<?php
namespace App\Services\WorkerService\WorkerLoginService;
use App\Models\Worker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Validator;

class WorkerLoginService {
    protected $model;
    public function __construct() {
        $this->model = new Worker;
    }
    function validation($request) {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $validator;
    }
    function isValidDate($data) {
        if (!$token = auth()->guard('worker')->attempt($data->validated())) {
            return response()->json(['message' => 'invalid data!'], 401);
        }
        return $token;
    }
    function getStatus($email) {
        $worker =  $this->model->whereEmail($email)->first();
        $status = $worker->status;
        return $status;
    }
    function isVerified($email) {
        $worker =  $this->model->whereEmail($email)->first();
        $verified_at = $worker->verified_at;
        return $verified_at;
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('worker')->factory()->getTTL() * 60,
            'user' => auth()->guard('worker')->user()
        ]);
    }
    function login($request) {
        $data = $this->validation($request);
        $token = $this->isValidDate($data);
        $isVerified = $this->isVerified($request->email);
        $status = $this->getStatus($request->email);
        if ($isVerified == null) {
            return response()->json(["message"=> "your account is not verified "], 422);
        }
        if (!$status) {
            return response()->json(['message'=> 'your account is pending'], 422);
        }
        return $this->createNewToken($token);
    }
}
