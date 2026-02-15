<?php

namespace App\Http\Controllers;

use App\Chapter;
use Settings;
//use Htmldom;

trait HelperTrait
{
    public $validationPhone = 'required|regex:/^((\+)?(\d)(\s)?(\()?[0-9]{3}(\))?(\s)?([0-9]{3})(\-)?([0-9]{2})(\-)?([0-9]{2}))$/';
    public $validationImage = 'image|min:5|max:5000';
    public $validationCoordinates = 'required|regex:/^(\d{2}\.\d{6})$/';
    public $validationDate = 'required|regex:/^((\d){2}\/(\d){2}\/(\d){4})$/';
    public $validationFloat = 'regex:/^\d+(\.\d+)$/';
    public $validationBackground = 'image|min:30|max:2000';
    public $validationTAParams = 'required|integer|min:50|max:2000';
    public $metas = [
        'meta_description' => ['name' => 'description', 'property' => false],
        'meta_keywords' => ['name' => 'keywords', 'property' => false],
        'meta_twitter_card' => ['name' => 'twitter:card', 'property' => false],
        'meta_twitter_size' => ['name' => 'twitter:size', 'property' => false],
        'meta_twitter_creator' => ['name' => 'twitter:creator', 'property' => false],
        'meta_og_url' => ['name' => false, 'property' => 'og:url'],
        'meta_og_type' => ['name' => false, 'property' => 'og:type'],
        'meta_og_title' => ['name' => false, 'property' => 'og:title'],
        'meta_og_description' => ['name' => false, 'property' => 'og:description'],
        'meta_og_image' => ['name' => false, 'property' => 'og:image'],
        'meta_robots' => ['name' => 'robots', 'property' => false],
        'meta_googlebot' => ['name' => 'googlebot', 'property' => false],
        'meta_google_site_verification' => ['name' => 'robots', 'property' => false],
    ];
    public $slidesPath = '/images/slides/';

    public function clearPhone($phone)
    {
        return str_replace(['(',')','-',' '],'',$phone);
    }
    
    public function subStr($string, $length)
    {
        return mb_strlen($string, 'UTF-8') > $length ? mb_substr($string, 0, $length).'…' : $string;
    }

    public function showView($view)
    {
        $this->data['seo'] = Settings::getSeoTags();
        $mainMenu = Chapter::where('active',1)->get();

        return view($view, [
            'mainMenu' => $mainMenu,
            'data' => $this->data,
            'metas' => $this->metas
        ]);
    }
}