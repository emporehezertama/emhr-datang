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
        //
        //Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path('Helper/AsiaHelper.php');
        require_once app_path('Helper/EmporeHelper.php');
        require_once app_path('Helper/GeneralHelper.php');
        require_once app_path('Helper/ApprovalHelper.php');
    }
}
