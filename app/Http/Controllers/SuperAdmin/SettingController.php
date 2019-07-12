<?php

namespace App\Http\Controllers\SuperAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ScheduleBackup;


use Storage;
class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $user = \Auth::user();
        //dd($user);
        
        if($user->project_id != NULL)
        {
            $params['data'] = Setting::orderBy('id', 'DESC')->where('project_id',$user->project_id)->get();
        }else{
            $params['data'] = Setting::orderBy('id', 'DESC')->get();
        }
        return view('superadmin.setting.index')->with($params);
    }
    
    public function save(Request $request)
    {
        $user = \Auth::user();
        if($request->setting)
        {
            foreach($request->setting as $key => $value)
            {
                if($user->project_id != NULL)
                {
                    $setting = Setting::where('key', $key)->where('project_id',$user->project_id)->first();
                }else{
                    $setting = Setting::where('key', $key)->first();
                }
                if(!$setting)
                {
                    $setting = new Setting();
                    $setting->key = $key;
                }
                $setting->user_created = $user->id;
                $setting->project_id = $user->project_id;
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

            if($user->project_id != NULL)
            {
                $setting = Setting::where('key', 'logo')->where('project_id',$user->project_id)->first();
            } else{
                $setting = Setting::where('key', 'logo')->first();
            }
            if(!$setting)
            {
                $setting = new Setting();
                $setting->key = 'logo';
            }
            $setting->user_created = $user->id;
            $setting->project_id = $user->project_id;
            $setting->value = '/upload/setting/' . $fileName;
            $setting->save();
        }

        if ($request->hasFile('favicon'))
        {
            $file = $request->file('favicon');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/upload/setting');
            $file->move($destinationPath, $fileName);

            if($user->project_id != NULL)
            {
                $setting = Setting::where('key', 'favicon')->where('project_id',$user->project_id)->first();
            } else{
                $setting = Setting::where('key', 'favicon')->first();
            }
            
            if(!$setting)
            {
                $setting = new Setting();
                $setting->key = 'favicon';
            }
            $setting->user_created = $user->id;
            $setting->project_id = $user->project_id;
            $setting->value = '/upload/setting/' . $fileName;
            $setting->save();
        }

        if ($request->hasFile('logo_footer'))
        {
            $file = $request->file('logo_footer');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/upload/setting');
            $file->move($destinationPath, $fileName);

            if($user->project_id != NULL)
            {
                $setting = Setting::where('key', 'logo_footer')->where('project_id',$user->project_id)->first();
            }else{
                $setting = Setting::where('key', 'logo_footer')->first();
            }
            
            if(!$setting)
            {
                $setting = new Setting();
                $setting->key = 'logo_footer';
            }
            $setting->user_created = $user->id;
            $setting->project_id = $user->project_id;
            $setting->value = '/upload/setting/' . $fileName;
            $setting->save();
        }

        return redirect()->route('superadmin.setting.general')->with('message-success', 'Setting saved');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Setting Email
     * @return view
     */
    public function email()
    {
        return view('superadmin.setting.email');
    }
    
    /**
     * Email Save
     * @param  Request $request
     * @return void
     */
    public function emailSave(Request $request)
    {
         $user = \Auth::user();

        if($request->setting)
        {
            foreach($request->setting as $key => $value)
            {
                if($user->project_id != NULL)
                {
                    $setting = Setting::where('key', $key)->where('project_id',$user->project_id)->first();
                }else{
                    $setting = Setting::where('key', $key)->first();
                }

                if(!$setting)
                {
                    $setting = new Setting();
                    $setting->key = $key;
                }
                $setting->user_created = $user->id;
                $setting->project_id = $user->project_id;
                $setting->value = $value;
                $setting->save();
            }
        }

        return redirect()->route('superadmin.setting.email')->with('message-success', 'Setting saved');
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
        
        return redirect()->route('superadmin.setting.email')->with('message-success', 'Email successfully send');
    }

    /**
     * Setting Backup
     * @return view
     */
    public function backup()
    {

        $params['data'] = Storage::allFiles(env('APP_NAME'));
        
        return view('superadmin.setting.backup')->with($params);
    }

    /**
     * Backup Delete
     * @param  Request $request
     * @return void
     */
    public function backupDelete(Request $request)
    {
        $file = storage_path() .'/app/'. $request->file;
        #unlink($file);
        $result = Storage::delete( $request->file );

        return redirect()->route('superadmin.setting.backup')->with('message-success','Files deleted.');
    }

    /**
     * Backup Delete
     * @param  Request $request
     * @return void
     */
    public function backupGet(Request $request)
    {
        return Storage::download( $request->file );
    }

    /**
     * Backup Save
     * @param  Request $request
     * @return redirect     
     */
    public function backupSave(Request $request)
    {
        $user = \Auth::user();

        if($request->setting)
        {
            foreach($request->setting as $key => $value)
            {
                if($user->project_id != NULL)
                {
                    $setting = Setting::where('key', $key)->where('project_id',$user->project_id)->first();
                }else{
                    $setting = Setting::where('key', $key)->first();
                }
                
                if(!$setting)
                {
                    $setting = new Setting();
                    $setting->key = $key;
                }
                $setting->user_created = $user->id;
                $setting->project_id   = $user->project_id;
                $setting->value = $value;
                $setting->save();
            }
        }

        return redirect()->route('superadmin.setting.backup')->with('message-success', 'Setting saved');
    }

    public function storeBackupSchedule(Request $request)
    {
        $user = \Auth::user();

        $data               = new ScheduleBackup();
        $data->backup_type  = $request->backup_type;
        $data->time         = $request->time;
        $data->recurring    = $request->recurring;
        $data->date         = $request->date;
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
            $data->project_id   = $user->project_id;
        }
        $data->save();

        return redirect()->route('superadmin.setting.backup')->with('message-success', 'Setting saved');
    }
    
     public function deleteBackupSchedule($id)
    {
        $data = ScheduleBackup::where('id', $id)->first();
        $data->delete();

        return redirect()->route('superadmin.setting.backup')->with('message-success', 'Setting delete');
    }
}
