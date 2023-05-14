<?php

namespace App\Http\Controllers;

use App\Modules\Heroes\Services\HeroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class HeroApiController extends Controller
{
    private $_service;

    public function __construct(HeroService $service)
    {
        $this->_service = $service;
    }

    public function all(Request $request)
    {
        $pages = $request->get("pages", 8);

        return $this->_service->all($pages);
    }

    public function list(Request $request){
        
        $pages = $request->get("pages", 8);
        $language = $request->get("language", app()->getLocale());
    
        return $this->_service->list($language, $pages);
    }

    public function find($id, Request $request)
    {
        $language = $request->get("language", app()->getLocale());
        $data = $this->_service->find($language, $id);

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

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $hero = $this->_service->update($id, $data);
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }
        return ["data" => $hero];
    }

    public function delete($id)
    {
        $this->_service->delete($id);
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }
        return ["data" => "Hero deleted"];
    }
}
