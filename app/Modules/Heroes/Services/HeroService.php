<?php
namespace App\Modules\Heroes\Services;

use App\Models\Hero;
use App\Models\HeroLanguage;
use App\Modules\Core\Services\Service;
use App\Modules\Core\Services\ServiceLanguages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class HeroService extends ServiceLanguages
{
    protected $_rules = [
        "id" => "",
        "name" => "required",
        "description" => "required",
        "power-level" => "required|min:1|max:10",
        "birthday" => "",
        "race" => "",
        "gender" => "",
        "image" => ""
    ];

    protected $_rulesTranslations = [
        "language" => "required|string|min:2|max:2"
    ];

    public function __construct(Hero $model)
    {
        parent::__construct($model);
    }

    public function all($pages = 10)
    {
        $data = $this->_model
            ->with("translations")
            ->paginate($pages);
        
        return $this->presentAllWithTranslations($data->toArray());
    }

    public function list($language, $pages = 10)
    {
        $data =  $this->_model->with(
            ["translations" => function ($query) use ($language) {
                if ($language)
                    return $query->where("language", $language);
            }]
        )
            ->paginate($pages)
            ->withQueryString();
        $data = $this->presentListWithTranslations($data->toArray());
        return $data;
    }

    public function find($id)
    {
        $data = $this->_model
            ->with("translations")
            ->find($id);

        $data = $this->presentFindWithTranslations($data->toArray());

        return ["data" => $data];
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
            "language" => app()->getLocale(),
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
