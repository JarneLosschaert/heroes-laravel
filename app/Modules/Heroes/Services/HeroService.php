<?php

namespace App\Modules\Heroes\Services;

use App\Models\Hero;
use App\Models\HeroLanguage;
use App\Modules\Core\Services\Service;
use App\Modules\Core\Services\ServiceLanguages;
use App\Modules\Users\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class HeroService extends ServiceLanguages
{
    protected $_rules = [
        "name" => "required",
        "description" => "required",
        "power-level" => "required|min:1|max:100",
        "birthday" => "required",
        "race" => "required",
        "image" => "required"
    ];

    protected $_rulesTranslations = [
        "language" => "required|string|min:2|max:2"
    ];

    public function __construct(Hero $model)
    {
        parent::__construct($model);
    }

    public function findId($token)
    {
        $user = Auth::setToken($token)->user();
        if ($user) {
            return $user["id"];
        } else {
            return ["errors" => $this->getErrors()];
        }
    }

    public function all($pages = 8)
    {
        $data = $this->_model
            ->with("translations")
            ->paginate($pages);

        return $this->presentAllWithTranslations($data->toArray());
    }

    public function favorites($token, $pages = 8)
    {
        $id = $this->findId($token);
        $user = User::find($id);
        $favorites = $user["favoriteHeroes"];
        if (!$favorites) {
            $favorites = [];
        }
        $data = $this->_model
            ->whereIn("id", $favorites)
            ->with("translations")
            ->paginate($pages);

        return $this->presentAllWithTranslations($data->toArray());
    }

    public function list($language, $pages = 8, $name = "", $minPowerLevel = 0, $maxPowerLevel = 100)
    {
        $data =  $this->_model->with(
            ["translations" => function ($query) use ($language) {
                if ($language)
                    return $query->where("language", $language);
            }]
        );

        $data = $data->where("name", "like", "%$name%")
            ->where("power-level", ">=", $minPowerLevel)
            ->where("power-level", "<=", $maxPowerLevel);

        $data = $data
            ->paginate($pages)
            ->withQueryString();
        $data = $this->presentListWithTranslations($data->toArray());

        return $data;
    }

    public function find($language, $id)
    {
        $data = $this->_model->with(
            ["translations" => function ($query) use ($language) {
                if ($language)
                    return $query->where("language", $language);
            }]
        )
            ->find($id);
        $data = $this->presentFindWithTranslation($data->toArray());

        return $data;
    }

    public function create($data)
    {
        $this->validate($data);
        if ($this->hasErrors()) {
            return ["errors" => $this->getErrors()];
        }
        $hero = $this->_model->create($data);
        HeroLanguage::create([
            "hero_id" => $hero->id,
            "language" => "en",
            "description" => $data["description"],
            "race" => $data["race"]
        ]);
        HeroLanguage::create([
            "hero_id" => $hero->id,
            "language" => "nl",
            "description" => $data["description"],
            "race" => $data["race"]
        ]);
        return $hero;
    }

    public function update($id, $data)
    {
        $this->validate($data);
        if ($this->hasErrors()) {
            return ["errors" => $this->getErrors()];
        }
        $hero = $this->_model->find($id);
        $hero->update($data);
        $heroLanguage = HeroLanguage::where("hero_id", $id)
            ->where("language", app()->getLocale())
            ->first();
        if ($heroLanguage != null) {
            $heroLanguage->update($data);
        } else {
            HeroLanguage::create([
                "hero_id" => $hero->id,
                "language" => app()->getLocale(),
                "description" => $data["description"],
                "race" => $data["race"]
            ]);
        }
        return $hero;
    }

    public function delete($id)
    {
        $hero = $this->_model->find($id);
        HeroLanguage::where("hero_id", $id)->delete();
        $hero->delete();
    }
}
