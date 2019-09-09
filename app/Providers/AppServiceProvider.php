<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if(get_setting('app_debug') == 'false')
        {
            \Config::set('app.debug', false );    
        }
        else
        {
            \Config::set('app.debug', true );    
        }

        if(!empty(get_setting('backup_mail')))
        {
            \Config::set('backup.notifications.mail.to', get_setting('backup_mail'));
        }

        \Config::set('mail.driver', get_setting('mail_driver'));
        \Config::set('mail.host', get_setting('mail_host'));
        \Config::set('mail.port', get_setting('mail_port'));
        \Config::set('mail.from', ['address' => get_setting('mail_address'), 'name' => get_setting('mail_name') ]);
        \Config::set('mail.username', get_setting('mail_username'));
        \Config::set('mail.password', get_setting('mail_password'));
        \Config::set('mail.encryption', get_setting('mail_encryption'));

        // find setting URL
        if(isset($_GET['layout_karyawan']))
        {
            //$setting = \App\Models\Setting::where('key', 'layout_karyawan')->first();
            $auth = \Auth::user();
            if($auth)
            {
                if($auth->project_id != NULL)
                {
                    $setting = \App\Models\Setting::where('key', 'layout_karyawan')->where('project_id',$auth->project_id)->first();
                } else{
                    $setting = \App\Models\Setting::where('key', 'layout_karyawan')->first();
                }
            }else{
                $setting = \App\Models\Setting::where('key', 'layout_karyawan')->first();
            }

            if(!$setting)
            {
                $setting = new \App\Models\Setting();
                $setting->key = 'layout_karyawan';
                if($auth->project_id != NULL)
                {
                    $setting->project_id = $auth->project_id;
                }
            }

            $setting->value = $_GET['layout_karyawan'];
            $setting->save();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path('Helper/DashboardHelper.php');
        require_once app_path('Helper/SettingHelper.php');
        require_once app_path('Helper/AttendanceHelper.php');
        require_once app_path('Helper/AsiaHelper.php');
        require_once app_path('Helper/EmporeHelper.php');
        require_once app_path('Helper/GeneralHelper.php');
        require_once app_path('Helper/ApprovalHelper.php');
        require_once app_path('Helper/StructureHelper.php');
        require_once app_path('Helper/PayrollHelper.php');
        require_once app_path('Helper/ModuleHelper.php');
    }
}
