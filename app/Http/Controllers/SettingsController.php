<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    use HelperTrait;
    
    private $settings;

    public function __construct()
    {
        $this->settings = simplexml_load_file(env('SETTINGS_XML'));
    }

    // Seo
    public function getSeoTags()
    {
        $tags = ['title' => ''];
        if ($this->settings->seo->title) $tags['title'] = (string)$this->settings->seo->title;
        foreach ($this->metas as $meta => $params) {
            $tags[$meta] = (string)$this->settings->seo->$meta;
        }
        return $tags;
    }

    // Settings
    public function getMainSettings()
    {
        return $this->settings->main_settings;
    }
    
    public function saveSeoTags(Request $request)
    {
        if ($request->has('title')) $this->settings->seo->title = $request->input('title');
        foreach ($this->metas as $meta => $params) {
            $this->settings->seo->$meta = $request->input($meta);
        }
        $this->save();
    }

    public function saveSettings($fields)
    {
        foreach ($fields as $field => $value) {
            $this->settings->main_settings[$field] = $value;
        }
        $this->save();
    }

    private function save()
    {
        $this->settings->asXML(Config::get('app.settings_xml'));
    }
}
