<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetTracking;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = [];
        return view('home');
    }

    /**
     * [acceptAsset description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function acceptAsset($id)
    {
        $data                   = Asset::where('id', $id)->first();
        $data->handover_date    = date('Y-m-d H:i:s');
        $data->status           = 1;
        $data->save();
        
        // Update Asset Tracking
        $tracking = AssetTracking::whereNull('handover_date')->where('asset_id', $id)->first();
        if($tracking)
        {
            $tracking->handover_date = $data->handover_date;
            $tracking->save();
        }

        return view('accept-asset');
    }
}
