<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

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
}
