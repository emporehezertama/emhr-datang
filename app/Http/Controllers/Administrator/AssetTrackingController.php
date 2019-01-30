<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetTrackingController extends Controller
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
        $data   = \App\AssetTracking::orderBy('id', 'DESC');
    
        if(isset($_GET['asset_type_id']))
        {
            if(!empty($_GET['asset_type_id']))
            {
                $data = $data->where('asset_type_id', $_GET['asset_type_id']);
            }

            if(!empty($_GET['asset_condition']))
            {
                $data = $data->where('asset_condition', $_GET['asset_condition']);
            }

            if(!empty($_GET['assign_to']))
            {
                $data = $data->where('assign_to', $_GET['assign_to']);
            }
        }

        $params['data'] = $data->get();

        return view('administrator.asset-tracking.index')->with($params);
    }
}
