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

    public function all(Request $request){  
        
        $pages = $request->get("pages", 10);
        return $this->_service->all($pages);
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

    public function delete($id)
    {
        $user = $this->_service->delete($id);
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }
        return ["data" => $user];
    }
}
