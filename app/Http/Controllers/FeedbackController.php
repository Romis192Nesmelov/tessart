<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Claim;
use Config;
use Session;
use Settings;

class FeedbackController extends Controller
{
    use HelperTrait;

    public function feedback(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => $this->validationPhone,
            'request' => 'required|min:5|max:500',
            'i_agree' => 'required|accepted'
        ]);
        $fields = $this->processingFields($request);
        Claim::create($fields);
        $this->sendMessage('request', $fields);
        return response()->json(['success' => true, 'message' => trans('content.thanks_for_your_message')]);
    }

    private function sendMessage($template, $creds, $pathToFile=null)
    {
        Mail::send('emails.'.$template, ['creds' => $creds], function($message) use ($pathToFile) {
            $message->subject('Сообщение с сайта Tessart.ru');
            $message->from(Config::get('app.mail_to'), 'tessart.ru');
            $message->to((string)Settings::getMainSettings()->main_email);
            if ($pathToFile) $message->attach($pathToFile);
        });
    }

    private function processingFields(Request $request)
    {
        $exceptFields = ['_token', 'i_agree'];
        $fields = $request->except($exceptFields);
        return $fields;
    }
}
