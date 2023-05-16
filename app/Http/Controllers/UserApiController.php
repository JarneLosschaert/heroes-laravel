<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Users\Services\UserService;

class UserApiController extends Controller
{
    private $_service;  

    public function __construct(UserService $service)
    {
        $this->_service = $service;
    }

    public function getToken($request) {
        $token = $request->header('Authorization');
        return str_replace('Bearer ', '', $token);
    }

    public function update(Request $request)
    {
        $token = $this->getToken($request);
        $data = $request->all();
        $this->_service->update($token, $data);
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }
        return response()->noContent();
    }
}
