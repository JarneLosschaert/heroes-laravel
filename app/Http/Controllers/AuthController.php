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
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }
        return response([
            "status" => "success"
        ], 200)->withCookie('token',$token,
            config('jwt.ttl'),
            '/',
            null,
            true,
            true,
            false,
            "None"
        );
        
        
    }
}