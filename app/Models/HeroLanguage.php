<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroLanguage extends Model
{
    use HasFactory;
    protected $table = "heroes_language";

    public function country() {
        return $this->belongsTo(Hero::class, "hero_id", "id");
    }
}
