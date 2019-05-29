<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetTracking;

class LandingPageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function page1()
    {
        $params = [];

        return view('landing-page/2019-05-28');
    }

    /**
     * Store page 1
     * @return void
     */
    public function storePage1(Request $request)
    {
        
    }
}
