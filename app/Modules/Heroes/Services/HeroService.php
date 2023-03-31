<?php
namespace App\Modules\Heroes\Services;

use App\Models\Hero;
use App\Modules\Core\Services\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class HeroService extends Service
{
    protected $_rules = [
        "id" => "required",
        "name" => "required",
        "description" => "required",
        "power_level" => "required|min:1|max:10",
        "skills" => "required",
        "birthday" => "",
        "race" => "",
        "gender" => "",
        "image" => ""
    ];

    public function __construct(Hero $model)
    {
        parent::__construct($model);
    }

    public function all($pages = 10)
    {
        return $this->_model->paginate($pages);
    }

    public function find($id)
    {
        return ["data" => $this->_model->find($id)];
    }

    public function create($data)
    {
        $this->validate($data);
        if ($this->hasErrors()) {
            return ["errors" => $this->getErrors()];
        }
        $hero = $this->_model->create($data);
        return $hero;
    }

    public function update($id, $data)
    {
        $this->validate($data);
        if ($this->hasErrors()) {
            return ["errors" => $this->getErrors()];
        }
        $hero = $this->_model->find($id);
        $hero = $hero->update($data);
        return $hero;
    }
}
