<?php
namespace App\Services\WorkerService\WorkerLoginService;
use App\Models\Worker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Validator;

class WorkerRegisterService {
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
    function store($data) {
        $worker = $this->model->create($data);
        return $worker->email;
    }
    protected function generateToken($email) {
        $token = substr(md5(rand(0, 9).$email.time()), 0, 32);
        $this->model->verification_token = $token;
        $worker = $this->model->save();
        return $worker;
    }
    function sendEmail($request) {}
    function register($request) {
        $data = $this->validation($request);
        $email = $this->store($data);
        $token = $this->generateToken($email);
        $this->sendEmail($request);
        return response()->json([
            "message"=> "account has been created successfully, check your email!",
        ]);
    }
}
