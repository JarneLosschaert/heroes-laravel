<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Users\Services\UserService;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    private $_service;

    public function __construct(UserService $service)
    {
        $this->_service = $service;
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $user = $this->_service->registerUser($data);
        if (!$user) {
            return Response::json(['error' => 'Failed to register user.'], 400);
        }
        return response()->noContent();
    }

    public function login(Request $request)
    {
        $token = $this->_service->login($request);
        if (!$token) {
            return Response::json(['error' => 'Invalid credentials.'], 401);
        }
        return response([
            "status" => "success",
            "userName" => $request->user()['name'],
            "authorisation" => [
                'token' => $token,
                'type' => "bearer"
            ]
        ], 200);
    }
}
