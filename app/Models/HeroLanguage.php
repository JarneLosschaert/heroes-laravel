<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroLanguage extends Model
{
    use HasFactory;
    protected $table = "heroes_language";

    protected $fillable = [
        'hero_id',
        'language',
        'description',
        'race',
    ];

    public function hero() {
        return $this->belongsTo(Hero::class, "hero_id", "id");
    }
}
