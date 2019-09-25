<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\CrmModule;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        #$this->middleware('auth');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['data'] = CrmModule::orderBy('id', 'ASC')->where('project_id',$user->project_id)->get();
            $ch = curl_init();
            $data   = ['project_id'=>$user->project_id];
            //$url = 'http://192.168.112.122:8001/get-modul-crm';
            //$url = 'http://192.168.112.91:1020/get-modul-crm';
            $url = 'http://api.local:1020/get-modul-crm';
            //$url = 'http://api.em-hr.co.id/get-modul-crm';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                
            $html = curl_exec($ch);

            if (curl_errno($ch)) 
            {
                print curl_error($ch);
            }
            curl_close($ch);
            $result = json_decode($html);
            $params['product'] = $result->product;
            $params['project'] = $result->project;
        }  
        //return $params;
        //kirim ke API project_id
        //outputnya : project_type, lisence_number, expired_date, list product
        return view('superadmin.dashboard')->with($params); 
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
     * [updateProfile description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateProfile(Request $request)
    {
        $user = User::where('id', \Auth::user()->id)->first();
        
        if($user)
        {   
            // cek nik 
            if($user->nik != $request->nik)
            {
                $getOtherUser = User::where('id', \Auth::user()->id)->where('nik', $request->nik)->first();
                if($getOtherUser)
                {
                    return redirect()->route('superadmin.profile')->with('message-error', 'NIK / User Login already exists !');
                }
                else
                {
                    $user->nik = $request->nik;
                }
            }

            if($user->email != $request->email) $user->email = $request->email;

            $user->save();

            return redirect()->route('superadmin.profile')->with('message-success', 'Profile data saved successfully !');
        } 
    }

    /**
     * [setting description]
     * @return [type] [description]
     */
    public function setting()
    {
        return view('superadmin.setting');
    }

    /**
     * [structure description]
     * @return [type] [description]
     */
    public function structure()
    {
        $params['directorate'] = Directorate::all();

        return view('superadmin.structure')->with($params);
    }

    /**
     * [profile description]
     * @return [type] [description]
     */
    public function profile()
    {
        $params['data'] = \Auth::user();
        
        return view('superadmin.profile')->with($params);
    }

    public function updateModul(Request $request)
    {
        //dd($request->project_product_id);

        $projectId = \Auth::user()->project_id;

        if($request->project_product_id != null) {
            CrmModule::whereNotIn('crm_product_id',$request->project_product_id)->where('project_id',$projectId)->delete();
            foreach ($request->project_product_id as $key => $value) {
                $product = CrmModule::where('crm_product_id',$value)->where('project_id',$projectId)->first();
                if(!$product)
                {
                    $product = new CrmModule();
                    $product->project_id  = $projectId;
                    $product->crm_product_id  = $request->project_product_id[$key];
                }
                if(isset($request->limit_user[$key])){
                    $product->limit_user      = $request->limit_user[$key];
                }
                    $product->save();
            }
        } else{
            CrmModule::where('project_id',$projectId)->delete();
        }

            //kirim ke API dan update ke database CRM --> crm_project_id dan crm_product_id
            $dataSend = CrmModule::where('project_id', $projectId)->get();
            if(count($dataSend) > 0)
            {
                $params = 'crm_product_id=';
                foreach ($dataSend as $k => $i) 
                {
                    $params                 .= ($k >= 1 ? ',' : ''). $i->crm_product_id;
                    $crm_project_id         = $i->project_id;
                    $limit_user             ='';
                    if($i->crm_product_id == 3)
                    {
                        $limit_user = $i->limit_user;
                    } 
                }
                $params .= '&crm_project_id='. $crm_project_id;
                $params .= '&limit_user='. $limit_user;
            }else{
                $params = 'crm_product_id=';
                $params .= '&crm_project_id='. $projectId;
                $params .= '&limit_user=';
            }
            
            $ch = curl_init();
            //$url = 'http://192.168.112.122:8001/update-modul-crm';
            $url = 'http://api.em-hr.co.id/update-modul-crm';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

            $html = curl_exec($ch);
            if (curl_errno($ch)) 
            {
                print curl_error($ch);
            }
            curl_close($ch);

        return redirect()->route('superadmin.dashboard')->with('message-sucess', 'Data successfully saved');
    }
    
}
