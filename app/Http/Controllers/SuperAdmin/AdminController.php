<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\CrmModule;
use App\Models\CrmModuleAdmin;

class AdminController extends Controller
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
            $data = User::where('access_id', 1)->where('project_id', $user->project_id);
        }else{
            $data = User::where('access_id', 1);
        }
        
        $params['data'] = $data->orderBy('id', 'DESC')->paginate(50);

        return view('superadmin.admin.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['data'] = CrmModule::orderBy('id', 'ASC')->where('project_id',$user->project_id)->get();
        } else {
            $params['data'] = [];
        }
        return view('superadmin.admin.create')->with($params);
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
        $projectId = \Auth::user()->project_id;

        if($request->admin_id > 0)
        {
            $data = User::where('id',$request->admin_id)->first();
        } else{
            $getOtherUser = User::where('nik', $request->nik)->first();            
            if($getOtherUser)
            {
                return redirect()->route('superadmin.admin.index')->with('message-error', 'NIK / User Login already exists !');
            }else{
                $data                       = new User();
            }
        }
        $data->name                 = strtoupper($request->name);
        $data->nik                  = $request->nik;
        $data->email                = $request->email;
        $data->password             = bcrypt($request->password);
        $data->mobile_1             = $request->mobile_1;
        $data->access_id            = 1;
        if(!empty($projectId))
        {
            $data->project_id = $projectId;
        }

        $data->save();
        foreach ($request->product_id as $key => $value) {
            $val = isset($value) ? 1 : 0;
            if($val == 1){
            # code...
                $product = new CrmModuleAdmin();
                $product->user_id  = $data->id;
                $product->product_id  = $request->product_id[$key];
                $product->save();
            }
        }

        return redirect()->route('superadmin.admin.index')->with('message-success', 'Data saved successfully');
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
        $params['data']         = User::where('id', $id)->first();

        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['module'] = CrmModule::orderBy('id', 'ASC')->where('project_id',$user->project_id)->get();
            $params['moduleAdmin'] = CrmModuleAdmin::orderBy('id', 'ASC')->where('user_id',$id)->get();
        } else {
            $params['module'] = [];
            $params['moduleAdmin'] = [];
        }
        return view('superadmin.admin.edit')->with($params);
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
        $user = \Auth::user();

        $dataUser               = User::where('id', $id)->first();

        if($request->password != $dataUser->password)
        {
            if(!empty($request->password))
            {
                $this->validate($request,[
                    'confirm'      => 'same:password',
                ]);
                $dataUser->password             = bcrypt($request->password);
            }
        }
        $dataUser->email        = $request->email;
        $dataUser->mobile_1     = $request->mobile_1;
        $dataUser->save();

        if($request->product_id != null) {
            CrmModuleAdmin::whereNotIn('product_id',$request->product_id)->where('user_id',$id)->delete();
            foreach ($request->product_id as $key => $value) {

                $product = CrmModuleAdmin::where('product_id',$value)->where('user_id',$id)->first();
                if(!$product)
                {
                    $product = new CrmModuleAdmin();
                    $product->user_id  = $id;
                    $product->product_id  = $request->product_id[$key];
                    $product->save();
                }
            }
        } else{
            CrmModuleAdmin::where('user_id',$id)->delete();
        }
        

        return redirect()->route('superadmin.admin.index')->with('message-sucess', 'Data successfully saved');
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
        $data = User::where('id', $id)->first();
        $data->delete();

        return redirect()->route('superadmin.admin.index')->with('message-sucess', 'Data successfully deleted');
    }

    public function changeStatus($id)
    {
        $data = User::where('id', $id)->first();
        $data->access_id = 2;
        $data->save();

        return redirect()->route('superadmin.admin.index')->with('message-sucess', 'Data successfully saved');
    }

}
