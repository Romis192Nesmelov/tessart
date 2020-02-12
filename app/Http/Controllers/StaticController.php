<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Chapter;
use Settings;
use Session;
use Config;

class StaticController extends Controller
{
    use HelperTrait;
    
    public function index()
    {
        $data = Chapter::where('active',1)->get();
        return view('home', [
            'data' => $data,
            'metas' => $this->metas,
            'seo' => Settings::getSeoTags()]
        );
    }
}
