<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $table = 'heroes';

    protected $fillable = [
        'name',
        'description',
        'power_level',
        'skills',
        'birthday',
        'race',
        'image'
    ];

    protected $casts = [
        'skills' => 'array'
    ];
}
