<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\App;
use App\Claim;
use App\Chapter;
use Config;
use Session;
use Settings;

class AdminController extends Controller
{
    use HelperTrait;
    
    private $breadcrumbs = [];
    private $data = [];

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function getIndex()
    {
        return redirect('/admin/seo');
    }

    public function getSeo()
    {
        $this->breadcrumbs = ['seo' => 'SEO'];
        $this->data['metas'] = $this->metas;
        $this->data['seo'] = Settings::getSeoTags();
        return $this->showView('seo');
    }

    public function getClaims(Request $request)
    {
        $this->breadcrumbs = ['claims' => 'Заявки с сайта'];
        if ($request->has('id')) {
            $this->data['claim'] = Claim::find($request->input('id'));
            if (!$this->data['claim']) {
                Session::flash('message','Такой заявки не существует');
                return redirect('/admin/claims');
            } else {
                $this->breadcrumbs['claims/?id='.$this->data['claim']->id] = 'Сообщение от '.$this->data['claim']->created_at->format('d.m.Y');
                return $this->showView('claim');
            }
        } else {
            $this->data['claims'] = Claim::orderBy('id','desc')->paginate(20);
            return $this->showView('claims');
        }
    }

    public function getChapters(Request $request, $slug=null)
    {
        $this->breadcrumbs = ['chapters' => 'Разделы лендинга'];
        if ($slug && $slug == 'add') {
            $this->breadcrumbs['chapters/add'] = 'Добавление раздела';
            return $this->showView('chapter');
        } elseif ($request->has('id')) {
            $this->validate($request, ['id' => 'required|integer|exists:chapters']);
            $this->data['chapter'] = Chapter::find($request->input('id'));
            $this->breadcrumbs['chapters/?id='.$this->data['chapter']->id] = $this->data['chapter']->name;
            return $this->showView('chapter');
        } else {
            $this->data['chapters'] = Chapter::all();
            return $this->showView('chapters');
        }
    }
    
    public function getSettings()
    {
        $this->breadcrumbs = ['settings' => 'Настройки'];
        return $this->showView('settings');
    }

    public function postSeo(Request $request)
    {
        $this->validate($request, [
            'title' => 'max:255',
            'meta_description' => 'max:4000',
            'meta_keywords' => 'max:4000',
            'meta_twitter_card' => 'max:255',
            'meta_twitter_size' => 'max:255',
            'meta_twitter_creator' => 'max:255',
            'meta_og_url' => 'max:255',
            'meta_og_type' => 'max:255',
            'meta_og_title' => 'max:255',
            'meta_og_description' => 'max:4000',
            'meta_og_image' => 'max:255',
            'meta_robots' => 'max:255',
            'meta_googlebot' => 'max:255',
            'meta_google_site_verification' => 'max:255',
        ]);
        Settings::saveSeoTags($request);
        $this->saveCompleteMessage();
        return redirect('/admin/seo');
    }

    public function postChapter(Request $request)
    {
        $validationArr = [
            'second_image' => $this->validationImage,
            'name' => 'required|min:3|max:50|unique:chapters,name',
            'content' => 'required|max:3000',
            'image_part' => 'required|integer|min:10|max:70'
        ];

        $fields = $this->processingFields($request, ['on_menu','active'], ['main_image','second_image']);
        
        if ($request->has('id')) {
            $validationArr['name'] .= ','.$request->input('id');
            $this->validate($request, $validationArr);
            $chapter = Chapter::find($request->input('id'));
            $fields = array_merge(
                $fields,
                $this->processingImage($request, $chapter, 'main_image', 'images/slides', 'slide'.$chapter->id),
                $this->processingImage($request, $chapter, 'second_image', 'images/slides', 'slide'.$chapter->id.'_add')
            );
        } else {
            $validationArr['main_image'] = 'required|'.$this->validationImage;
            $this->validate($request, $validationArr);
            $fields['main_image'] = '';
            $chapter = Chapter::create($fields);
            $fields = array_merge(
                $this->processingImage($request, $chapter, 'main_image', 'images/slides', 'slide'.$chapter->id),
                $this->processingImage($request, $chapter, 'second_image', 'images/slides', 'slide'.$chapter->id.'_add')
            );
        }
        $chapter->update($fields);
        $this->saveCompleteMessage();
        return redirect('/admin/chapters?id='.$chapter->id);
    }

    public function postSettings(Request $request)
    {
        $this->validate($request, [
            'main_phone_prefix' => 'required|size:3',
            'main_phone' => 'required|size:9',
            'main_email' => 'required|email',
        ]);
        Settings::saveSettings($this->processingFields($request));
        $this->saveCompleteMessage();
        return redirect('/admin/settings');
    }
    
    public function postDeleteClaim(Request $request)
    {
        return $this->deleteSomething($request, new Claim());
    }

    public function postDeleteChapter(Request $request)
    {
        return $this->deleteSomething($request, new Chapter());
    }
    
    private function deleteSomething(Request $request, Model $model)
    {
        $this->validate($request, ['id' => 'required|integer|exists:'.$model->getTable()]);
        $table = $model->find($request->input('id'));
        if (isset($table->main_image)) $this->unlinkFile($model, 'main_image', 'images/slides');
        if (isset($table->second_image) && $table->second_image) $this->unlinkFile($model, 'second_image', 'images/slides');
        $table->delete();
        return response()->json(['success' => true]);
    }

    private function processingFields(Request $request, $checkboxFields = null, $ignoreFields = null, $timeFields = null, $colorFields = null)
    {
        $exceptFields = ['_token','id'];
        if ($ignoreFields) {
            if (is_array($ignoreFields)) $exceptFields = array_merge($exceptFields, $ignoreFields);
            else $exceptFields[] = $ignoreFields;
        }

//        $exceptFields = array_merge($exceptFields, $this->ignoringFields);
        $fields = $request->except($exceptFields);

        if ($checkboxFields) {
            if (is_array($checkboxFields)) {
                foreach ($checkboxFields as $field) {
                    $fields[$field] = isset($fields[$field]) && $fields[$field] == 'on' ? 1 : 0;
                }
            } else {
                $fields[$checkboxFields] = isset($fields[$checkboxFields]) && $fields[$checkboxFields] == 'on' ? 1 : 0;
            }
        }

        if ($timeFields) {
            if (is_array($colorFields)) {
                foreach ($colorFields as $field) {
                    $fields[$field] = strtotime($this->convertTime($fields[$field]));
                }
            } else {
                $fields[$timeFields] = strtotime($this->convertTime($fields[$timeFields]));
            }
        }

        if ($colorFields) {
            if (is_array($colorFields)) {
                foreach ($colorFields as $field) {
                    $fields[$field] = $this->convertColor($fields[$field]);
                }
            } else {
                $fields[$colorFields] = $this->convertColor($fields[$colorFields]);
            }
        }
        return $fields;
    }

    private function processingImage(Request $request, Model $model, $field, $path, $prefix)
    {
        $imageFields = [];
        if ($request->hasFile($field)) {
            $this->unlinkFile($model, $field, $path);
            $imageName = $this->makeImageName($request, $prefix, $field);
            $request->file($field)->move(base_path('public/'.$path.'/'),$imageName);
            $imageFields[$field] = $imageName;
        }
        return $imageFields;
    }

    private function unlinkFile($table, $file, $path)
    {
        $fullPath = base_path('public'.'/'.$path.'/'.$table[$file]);
        if (isset($table[$file]) && $table[$file] && file_exists($fullPath)) unlink($fullPath);
    }

    private function makeImageName(Request $request, $prefix, $field)
    {
        return $prefix.'.'.$request->file($field)->getClientOriginalExtension();
    }

    private function convertColor($color)
    {
        if (preg_match('/^(hsv\(\d+\, \d+\%\, \d+\%\))$/',$color)) {
            $hsv = explode(',',str_replace(['hsv','(',')','%',' '],'',$color));
            $color = $this->fGetRGB($hsv[0],$hsv[1],$hsv[2]);
        }
        return $color;
    }

    private function fGetRGB($iH, $iS, $iV)
    {
        if($iH < 0)   $iH = 0;   // Hue:
        if($iH > 360) $iH = 360; //   0-360
        if($iS < 0)   $iS = 0;   // Saturation:
        if($iS > 100) $iS = 100; //   0-100
        if($iV < 0)   $iV = 0;   // Lightness:
        if($iV > 100) $iV = 100; //   0-100
        $dS = $iS/100.0; // Saturation: 0.0-1.0
        $dV = $iV/100.0; // Lightness:  0.0-1.0
        $dC = $dV*$dS;   // Chroma:     0.0-1.0
        $dH = $iH/60.0;  // H-Prime:    0.0-6.0
        $dT = $dH;       // Temp variable
        while($dT >= 2.0) $dT -= 2.0; // php modulus does not work with float
        $dX = $dC*(1-abs($dT-1));     // as used in the Wikipedia link
        switch(floor($dH)) {
            case 0:
                $dR = $dC; $dG = $dX; $dB = 0.0; break;
            case 1:
                $dR = $dX; $dG = $dC; $dB = 0.0; break;
            case 2:
                $dR = 0.0; $dG = $dC; $dB = $dX; break;
            case 3:
                $dR = 0.0; $dG = $dX; $dB = $dC; break;
            case 4:
                $dR = $dX; $dG = 0.0; $dB = $dC; break;
            case 5:
                $dR = $dC; $dG = 0.0; $dB = $dX; break;
            default:
                $dR = 0.0; $dG = 0.0; $dB = 0.0; break;
        }
        $dM  = $dV - $dC;
        $dR += $dM; $dG += $dM; $dB += $dM;
        $dR *= 255; $dG *= 255; $dB *= 255;
        return 'rgb('.round($dR).', '.round($dG).', '.round($dB).')';
    }

    private function convertTime($time)
    {
        $time = explode('/', $time);
        return $time[1].'/'.$time[0].'/'.$time[2];
    }

    private function saveCompleteMessage()
    {
        Session::flash('message','Сохранение произведено');
    }

    public function showView($view)
    {
        $chapters = Chapter::all();
        $submenu = [];
        foreach ($chapters as $chapter) {
            $submenu[] = ['href' => '?id='.$chapter->id, 'name' => $chapter->name];
        }
        
        return view('admin.'.$view, [
            'breadcrumbs' => $this->breadcrumbs,
            'data' => $this->data,
            'menus' => [
                ['href' => 'seo', 'name' => 'SEO', 'icon' => 'icon-price-tags'],
                ['href' => 'claims', 'name' => 'Заявки', 'icon' => 'icon-megaphone'],
                ['href' => 'chapters', 'name' => 'Разделы', 'icon' => 'icon-files-empty2', 'submenu' => $submenu],
                ['href' => 'settings', 'name' => 'Настройки', 'icon' => 'icon-gear'],
            ]
        ]);
    }
}
