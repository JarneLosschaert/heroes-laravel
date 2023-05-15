<?php
namespace App\Modules\Users\Services;

use App\Models\User;
use App\Modules\Core\Services\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    private array $credentailRules = [
        'email' => 'required|string|email',
        'password' => 'required|string',
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
        $data['password'] = Hash::make($data['password']);
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

    public function registerUser($data) {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'favoriteHeroes' => ''
        ];
        $this->validate($data, $rules);
        if ($this->hasErrors()) {
            return ["errors" => $this->getErrors()];
        }   
        $data['password'] = Hash::make($data['password']);
        $user = $this->_model->create($data);
        return $user;
    }

    function login($data) : ?string {
        $validator = Validator::make($data->all(), $this->credentailRules);
        if ($validator->fails()) return null;
    
        $credentials = $data->only('email', 'password');
        $token = auth()->attempt($credentials);
        return $token;
    }     
}