<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Modules\Heroes\Services\HeroService;
use Illuminate\Http\Request;

class HeroApiController extends Controller
{
    private $_service;

    public function __construct(HeroService $service)
    {
        $this->_service = $service;
    }

    public function all(Request $request)
    {
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
        $hero = $this->_service->create($data);
        
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }
        
        return ["data" => $hero];
    }

}
