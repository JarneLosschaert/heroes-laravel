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

    public function getToken($request) {
        $token = $request->header('Authorization');

        return str_replace('Bearer ', '', $token);
    }

    public function all(Request $request)
    {
        $pages = $request->get("pages", 8);

        return $this->_service->all($pages);
    }

    public function favorites(Request $request)
    {
        $pages = $request->get("pages", 8);
        $token = $this->getToken($request);
        $data = $this->_service->favorites($token, $pages);

        return ["data" => $data];
    }

    public function list(Request $request){
        
        $pages = $request->get("pages", 8);
        $language = $request->get("language", app()->getLocale());
        $name = $request->get("name", "");
        $minPowerLevel = $request->get("minPowerLevel", 0);
        $maxPowerLevel = $request->get("maxPowerLevel", 100);
        $data = $this->_service->list($language, $pages, $name, $minPowerLevel, $maxPowerLevel);

        return ["data" => $data];
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
        $this->_service->create($data);
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }
        
        return response()->noContent();
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->_service->update($id, $data);
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }

        return response()->noContent();
    }

    public function delete($id)
    {
        $this->_service->delete($id);
        if ($this->_service->hasErrors()) {
            return ["errors" => $this->_service->getErrors()];
        }

        return response()->noContent();
    }
}
