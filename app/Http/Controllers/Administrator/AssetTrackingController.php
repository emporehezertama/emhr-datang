<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AssetTracking;

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
         $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data   = AssetTracking::orderBy('asset_tracking.id', 'DESC')->join('users','users.id','=','asset_tracking.user_id')->where('users.project_id', $user->project_id)->select('asset_tracking.*');
        }else {
           $data   = AssetTracking::orderBy('id', 'DESC');
        }

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
