<?php

namespace App\Http\Controllers;

use App\Models\CrmModule;
use App\Models\Users;
use Illuminate\Http\Request;

class CrmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function insertModule(Request $request) 
    {
        $data                   = new CrmModule();
        $data->project_id       = $request->get('project_id');
        $data->project_name     = $request->get('project_name');
        $data->client_name      = $request->get('client_name');
        $data->crm_product_id   = $request->get('crm_product_id');
        if($request->get('limit_user') > 0){
            $data->limit_user       = $request->get('limit_user');
        }
        $data->modul_name       = $request->get('modul_name');
        $data->save();
        return response()->json(['status' => "success", "project_name" => $data->project_name], 201);
    }

    public function insertUser(Request $request) 
    {
        $data                   = new Users();
        $data->nik              = $request->get('user_name');
        $data->password         = $request->get('password');
        $data->access_id        = 3; //login superadmin untuk client area
        $data->project_id       = $request->get('project_id');
        $data->save();
        return response()->json(['status' => "success"], 201);
    }

    public function updateModule(Request $request)
    {
        //delete dulu data dri crm module yang sudah ada kemudian nanti insert yang baru
        CrmModule()::where('project_id',$request->get('project_id'))->delete();

        $data                   = new CrmModule();
        $data->project_id       = $request->get('project_id');
        $data->project_name     = $request->get('project_name');
        $data->client_name      = $request->get('client_name');
        //$data->user_name        = $request->get('user_name');
        //$data->password         = $request->get('password');
        $data->crm_product_id   = $request->get('crm_product_id');
        if($request->get('limit_user') > 0){
            $data->limit_user       = $request->get('limit_user');
        }
        $data->modul_name       = $request->get('modul_name');
        $data->save();

        return response()->json(['status' => "success", "project_name" => $data->project_name], 201);
    }
}
