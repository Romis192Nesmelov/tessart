<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'main_image',
        'second_image',
        'name',
        'content',
        'image_part',
        'on_menu',
        'active'
    ];

    public $timestamps = false;
}