<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExitInterview;
use App\Models\ExitInterviewAssets;
use App\Models\Asset;
use App\Models\AssetTracking;
use App\User;

class ApprovalExitClearanceCustomController extends Controller
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
        $approval = \App\Models\SettingApprovalClearance::where('user_id', \Auth::user()->id)->first();
        //if(!$approval) return [];
        if($approval)
        {
            $params['data'] = ExitInterview::where('status','<',3)->orderBy('id', 'DESC')->get();
           /* $count = ExitInterviewAssets::where('exit_interview_id',$params['data']['id'])->where(function($table)
                    {
                        $table->where('approval_check','<',1)->orWhereNull('approval_check');  
                    })->get();
            $params['check']      = count($count);
            */
        } else
        {
            $params['data'] = [];
        }
        return view('karyawan.approval-clearance-custom.index')->with($params);
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

    public function detail($id)
    {
        $count = ExitInterviewAssets::where('exit_interview_id', $id)->where(function($table){
          $table->where('approval_check','<',1)
          ->orWhereNull('approval_check');  
        })->get();

        $params['data']      = ExitInterviewAssets::where('exit_interview_id', $id)->get();
        $params['check']      = count($count);

        return view('karyawan.approval-clearance-custom.detail')->with($params);
    }
    public function proses(Request $request)
    {  
       if($request->asset != null)
        {
            foreach($request->asset as $key => $item)
            {
                $dataAset = ExitInterviewAssets::where('id', $request->asset[$key])->first();
                $dataAset->approval_check  = isset($request->approval_check[$key]) ? 1 : 0;
                $dataAset->catatan         = $request->catatan[$key];
                
                if($dataAset->approval_check == 1)
                {
                    $dataAset->approval_id     = \Auth::user()->id;
                    $dataAset->date_approved   = date('Y-m-d H:i:s');

                    $aset = Asset::where('id',$dataAset->asset_id)->first();
                    $aset->user_id = \Auth::user()->id;
                    $aset->handover_date = date('Y-m-d H:i:s');
                    $aset->assign_to  = 'Office Inventory/Idle';
                    $aset->save();

                    $tracking                   = new AssetTracking();
                    $tracking->asset_number     = $aset->asset_number; 
                    $tracking->asset_name       = $aset->asset_name;
                    $tracking->asset_type_id    = $aset->asset_type_id;
                    $tracking->asset_sn         = $aset->asset_sn;
                    $tracking->purchase_date    = date('Y-m-d', strtotime($aset->purchase_date));
                    $tracking->asset_condition  = $aset->asset_condition;
                    $tracking->assign_to        = $aset->assign_to;
                    $tracking->user_id          = $aset->user_id;
                    $tracking->asset_id         = $aset->id;
                    $tracking->status_mobil         = $aset->status_mobil;
                    $tracking->remark               = $aset->remark;
                    $tracking->save();
                }
                $dataAset->save();
            }
        }

        $approval = \App\Models\SettingApprovalClearance::where('user_id', \Auth::user()->id)->first();
        if($approval)
        {
            $params['data'] = ExitInterview::where('status','<',3)->orderBy('id', 'DESC')->get();
          
        } else
        {
            $params['data'] = [];
        }
        return redirect()->route('karyawan.approval.clearance-custom.index')->with('message-success', 'Exit Clearance succesfully process')->with($params);
    }
}
