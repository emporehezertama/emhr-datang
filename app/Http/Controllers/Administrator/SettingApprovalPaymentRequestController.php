<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingApprovalLeave;
use App\Models\SettingApprovalPaymentRequestItem;
use App\Models\SettingApprovalLevel;
use App\AjaxController;

class SettingApprovalPaymentRequestController extends Controller
{
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
            $params['data']  = SettingApprovalLeave::orderBy('setting_approval_leave.id', 'DESC')->join('structure_organization_custom','structure_organization_custom.id','=','setting_approval_leave.structure_organization_custom_id')->join('users','users.id','=','structure_organization_custom.user_created')->where('users.project_id', $user->project_id)->select('setting_approval_leave.*')->get();
        }else{
            $params['data']  = SettingApprovalLeave::orderBy('id', 'DESC')->get();
        }
        return view('administrator.setting-approvalPaymentRequest.index')->with($params);
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

    public function indexItem($id)
    {
        //
        $params['data'] = SettingApprovalLeave::where('id', $id)->first();
        $params['dataItem'] = SettingApprovalPaymentRequestItem::where('setting_approval_leave_id', $id)->orderBy('setting_approval_level_id')->get();
        return view('administrator.setting-approvalPaymentRequest.indexItem')->with($params);
    }

    public function createItem($id)
    {
        $params['data'] = SettingApprovalLeave::where('id', $id)->first();
        $params['structure'] = getStructureName();
        $params['level'] = SettingApprovalLevel::all();

        return view('administrator.setting-approvalPaymentRequest.createItem')->with($params);
    }

    public function storeItem(Request $request)
    {
        //cek data udah ada belum level segitu
        $checkdata = SettingApprovalPaymentRequestItem::where('setting_approval_leave_id', $request->setting_approval_leave_id)->where('setting_approval_level_id', $request->setting_approval_level_id)->first();
        $checkDataStruktur = SettingApprovalPaymentRequestItem::where('setting_approval_leave_id', $request->setting_approval_leave_id)->where('structure_organization_custom_id', $request->structure_organization_custom_id)->first();
        //
        if ($request->structure_organization_custom_id == NULL) {
            # code...
            return redirect()
                ->back()
                ->withInput()
                ->withErrors("Approval position is incomplete!");

        }else if($request->setting_approval_level_id == NULL){
            return redirect()
                ->back()
                ->withInput()
                ->withErrors("Approval level is incomplete!");
        }
        else{


            if(isset($checkDataStruktur) || isset($checkdata))
            {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors("Data already exists");

            }else
            {
                $data       = new SettingApprovalPaymentRequestItem();
                $data->setting_approval_leave_id  = $request->setting_approval_leave_id;
                $data->setting_approval_level_id  = $request->setting_approval_level_id;
                $data->structure_organization_custom_id  = $request->structure_organization_custom_id;
                $data->description = $request->description;
                $data->save();

                return redirect()->route('administrator.setting-approvalPaymentRequest.indexItem', $request->setting_approval_leave_id)->with('message-success', 'Data successfully saved!');
            }
        }
        
       
    }

    public function editItem($id)
    {
        //
        $params['data'] = SettingApprovalPaymentRequestItem::where('id', $id)->first();
        $params['structure'] = getStructureName();
        $params['level'] = SettingApprovalLevel::all();


        return view('administrator.setting-approvalPaymentRequest.editItem')->with($params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateItem(Request $request, $id)
    {
        // check data
        $data                       = SettingApprovalPaymentRequestItem::where('id', $id)->first();
        //$checkdata = SettingApprovalPaymentRequestItem::where('setting_approval_leave_id', $request->setting_approval_leave_id)->where('setting_approval_level_id', $request->setting_approval_level_id)->first();
        $checkDataStruktur = SettingApprovalPaymentRequestItem::where('setting_approval_leave_id', $request->setting_approval_leave_id)->where('structure_organization_custom_id', $request->structure_organization_custom_id)->first();

        /*if($request->setting_approval_level_id == NULL)
        {
            return redirect()->route('administrator.setting-approvalPaymentRequest.indexItem', $request->setting_approval_leave_id)->with('message-error', 'Approval level is incomplete!');
        }else*/
        if ($request->structure_organization_custom_id == NULL) {
            # code...
            return redirect()
                ->back()
                ->withInput()
                ->withErrors("Approval position is incomplete!");
        }else
        {
            if(isset($checkDataStruktur))
            {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors("Approval level is incomplete!");

                /*if($checkDataStruktur->setting_approval_level_id != $request->setting_approval_level_id)
                {
                    //$data->setting_approval_level_id  = $request->setting_approval_level_id;
                    $data->structure_organization_custom_id  = $request->structure_organization_custom_id;
                    $data->description     = $request->description;
                    $data->save();
                    return redirect()->route('administrator.setting-approvalPaymentRequest.indexItem', $data->setting_approval_leave_id)->with('message-success', 'Data successfully saved');
                } else
                {
                    return redirect()->route('administrator.setting-approvalPaymentRequest.indexItem', $data->setting_approval_leave_id)->with('message-error', 'Data already exists!');
                } 
                */           
            } /*elseif(isset($checkdata))
            {
                if($checkdata->structure_organization_custom_id != $request->structure_organization_custom_id){
                    $data->structure_organization_custom_id  = $request->structure_organization_custom_id;
                    $data->description     = $request->description;
                    $data->save();
                    return redirect()->route('administrator.setting-approvalPaymentRequest.indexItem', $data->setting_approval_leave_id)->with('message-success', 'Data successfully saved');
                } else{
                    return redirect()->route('administrator.setting-approvalPaymentRequest.indexItem', $data->setting_approval_leave_id)->with('message-error', 'Data already exists!');
                }
                
            }*/else
            {
                 //$data->setting_approval_level_id  = $request->setting_approval_level_id;
                 $data->structure_organization_custom_id  = $request->structure_organization_custom_id;
                 $data->description     = $request->description;
                 $data->save();

                return redirect()->route('administrator.setting-approvalPaymentRequest.indexItem', $data->setting_approval_leave_id)->with('message-success', 'Data successfully saved');
            }
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyItem($id)
    {
        //
        $data = SettingApprovalPaymentRequestItem::where('id', $id)->first();
        $id = $data->setting_approval_leave_id;
        $data->delete();

        return redirect()->route('administrator.setting-approvalPaymentRequest.indexItem',$id)->with('message-sucess', 'Data successfully deleted');
    }

}
