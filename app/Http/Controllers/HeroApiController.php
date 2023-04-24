<?php

namespace App\Http\Controllers;

use App\Modules\Heroes\Services\HeroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HeroApiController extends Controller
{
    private $_service;

    public function __construct(HeroService $service)
    {
        $this->_service = $service;
    }

    public function all(Request $request)
    {
        // $locale = App::getLocale();
        // $language = $request->input("lang", $locale);
        // if ($language != $locale)
        //     App::setLocale($language);

        $pages = $request->get("pages", 10);
        return $this->_service->all($pages);
        //Weet niet of dit werkt met de pages
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
        $hero->dis=$request->dis;

        
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
