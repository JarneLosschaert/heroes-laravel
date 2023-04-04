<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserApiController extends Controller
{
    private $_service;

    public function __construct(UserService $service)
    {
        $this->_service = $service;
    }

    public function all(Request $request){  
        
        return $this->_service->all;
    }

    public function find($id)
    {
        $data = $this->_service->find($id);
        return ["data" => $data];
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $user = $this->_service->create($data);
        $user->dis=$request->dis;

        
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }
        
        return ["data" => $user];
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = $this->_service->update($id, $data);
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }
        return ["data" => $user];
    }

    // patch moet nog
}
