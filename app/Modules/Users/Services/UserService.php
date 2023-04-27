<?php
namespace App\Modules\Users\Services;

use App\Models\User;
use App\Modules\Core\Services\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class UserService extends Service
{
    protected $_rules = [
        "id" => "",
        "firstName" => "required",
        "lastName" => "required",
        "email" => "required",
        "password" => "required",
        "favoriteHeroes" => ""
    ];

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function all()
    {
        return $this->_model->all();
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
        $user = $this->_model->create($data);
        return $user;
    }

    public function update($id, $data)
    {
        $this->validate($data);
        if ($this->hasErrors()) {
            return ["errors" => $this->getErrors()];
        }
        $user = $this->_model->find($id);
        $user = $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->_model->find($id);
        $user->delete();
        return $user;
    }
}