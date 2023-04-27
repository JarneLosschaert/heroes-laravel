<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'power-level',
        'skills',
        'birthday',
        'race',
        'image'
    ];

    protected $casts = [
        'skills' => 'array'
    ];

    public function translations(){
        return $this->hasMany(HeroLanguage::class, "hero_id", "id");
    }
}
