<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Storage;

class SettingController extends Controller
{   
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['data'] = Setting::orderBy('id', 'DESC')->get();

        return view('administrator.setting.index')->with($params);
    }

    /**
     * Setting Email
     * @return view
     */
    public function email()
    {
        return view('administrator.setting.email');
    }
    
    /**
     * Email Save
     * @param  Request $request
     * @return void
     */
    public function emailSave(Request $request)
    {
        if($request->setting)
        {
            foreach($request->setting as $key => $value)
            {
                $setting = Setting::where('key', $key)->first();
                if(!$setting)
                {
                    $setting = new Setting();
                    $setting->key = $key;
                }
                $setting->value = $value;
                $setting->save();
            }
        }

        return redirect()->route('administrator.setting.email')->with('message-success', 'Setting saved');
    }

    /**
     * Email Test Send
     * @param  Request $request
     */
    public function emailTestSend(Request $request)
    {
        \Mail::send('email.blank', ['data' => $request->test_message],
            function($message) use($request) {
                //$message->from(get_setting('mail_address'), 'Testing Message');
                $message->from('ramdoni@empore.co.id', 'Testing Message');
                $message->to($request->to);
                $message->subject($request->subject);
            }
        );
        
        return redirect()->route('administrator.setting.email')->with('message-success', 'Email berhasil dikirim');
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function save(Request $request)
    {
        if($request->setting)
        {
            foreach($request->setting as $key => $value)
            {
                $setting = Setting::where('key', $key)->first();
                if(!$setting)
                {
                    $setting = new Setting();
                    $setting->key = $key;
                }
                $setting->value = $value;
                $setting->save();
            }
        }

        if ($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/upload/setting');
            $file->move($destinationPath, $fileName);

            $setting = Setting::where('key', 'logo')->first();
            if(!$setting)
            {
                $setting = new Setting();
                $setting->key = 'logo';
            }
            $setting->value = '/upload/setting/' . $fileName;
            $setting->save();
        }

        if ($request->hasFile('favicon'))
        {
            $file = $request->file('favicon');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/upload/setting');
            $file->move($destinationPath, $fileName);

            $setting = Setting::where('key', 'favicon')->first();
            if(!$setting)
            {
                $setting = new Setting();
                $setting->key = 'favicon';
            }
            $setting->value = '/upload/setting/' . $fileName;
            $setting->save();
        }

        if ($request->hasFile('logo_footer'))
        {
            $file = $request->file('logo_footer');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/upload/setting');
            $file->move($destinationPath, $fileName);

            $setting = Setting::where('key', 'logo_footer')->first();
            if(!$setting)
            {
                $setting = new Setting();
                $setting->key = 'logo_footer';
            }
            $setting->value = '/upload/setting/' . $fileName;
            $setting->save();
        }

        return redirect()->route('administrator.setting.general')->with('message-success', 'Setting saved');
    }

    /**
     * Setting Backup
     * @return view
     */
    public function backup()
    {
        $params['files'] = Storage::allFiles(env('APP_NAME'));

        return view('administrator.setting.backup')->with($params);
    }

    /**
     * Backup Save
     * @param  Request $request
     * @return redirect     
     */
    public function backupSave(Request $request)
    {
        if($request->setting)
        {
            foreach($request->setting as $key => $value)
            {
                $setting = Setting::where('key', $key)->first();
                if(!$setting)
                {
                    $setting = new Setting();
                    $setting->key = $key;
                }
                $setting->value = $value;
                $setting->save();
            }
        }

        return redirect()->route('administrator.setting.backup')->with('message-success', 'Setting saved');
    }
}