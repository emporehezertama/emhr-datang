<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OvertimeSheet;
use App\Models\OvertimeSheetForm;
use App\User;
use App\Models\HistoryApprovalOvertime;
use App\Models\AbsensiItem;


class OvertimeCustomController extends Controller
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
        $params['data'] = OvertimeSheet::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.overtime-custom.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $params['karyawan'] = User::where('access_id', \Auth::user()->id)->get();

        return view('karyawan.overtime-custom.create')->with($params);
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
        $data                       = new OvertimeSheet();
        $data->user_id              = \Auth::user()->id;
        $data->status               = 1;  
        $data->save();

        foreach($request->tanggal as $key => $item)
        {   
            $form               = new OvertimeSheetForm();
            $form->overtime_sheet_id= $data->id;
            $form->description  = $request->description[$key];
            $form->awal         = $request->awal[$key];
            $form->akhir        = $request->akhir[$key];
            $form->total_lembur = $request->total_lembur[$key];
            $form->tanggal      = $request->tanggal[$key];
           // $form->overtime_calculate      = $request->overtime_calculated[$key];
            
            $form->save();
        }

        $params['data']     = $data;
        $position = \Auth::user()->structure_organization_custom_id;
        $settingApproval = \Auth::user()->approvalLeave->id; //idnya
        $settingApprovalItem = \Auth::user()->approvalLeave->level1Overtime->structure_organization_custom_id;

        $historyApproval    = \Auth::user()->approvalLeave->itemsOvertime;
        foreach ($historyApproval as $key => $value) {
            # code...
            $history = new HistoryApprovalOvertime();
            $history->overtime_sheet_id = $data->id;
            $history->setting_approval_level_id = $value->setting_approval_level_id;
            $history->structure_organization_custom_id = $value->structure_organization_custom_id;
            $history->save();
        }
        $historyApprov = HistoryApprovalOvertime::where('overtime_sheet_id',$data->id)->get();

        $userApproval = user_approval_custom($settingApprovalItem);
        foreach ($userApproval as $key => $value) { 
            
            if($value->email == "") continue;
            
            $params['data']     = $data;
            $params['value']    = $historyApprov;
                $params['text']     = '<p><strong>Dear Sir/Madam '. $value->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Overtime and currently waiting your approval.</p>';

           \Mail::send('email.overtime-approval-custom', $params,
                function($message) use($data, $value) {
                $message->from('emporeht@gmail.com');
                $message->to($value->email);
                $message->subject('Empore - Overtime Sheet');
            }); 
        }

        return redirect()->route('karyawan.overtime-custom.index')->with('message-success', 'Data successfully saved!');
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
        $params['data'] = OvertimeSheet::where('id', $id)->first();

        return view('karyawan.overtime-custom.edit')->with($params);
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

    public function claim($id)
    {
        //
        $params['data'] = OvertimeSheet::where('id', $id)->first();

        //$over = OvertimeSheet::select('overtime_sheet.*')->join('overtime_sheet_form', 'overtime_sheet.id','=','overtime_sheet_form.overtime_sheet_id')->join('absensi_item', 'absensi_item.date','=','overtime_sheet_form.tanggal')->join('absensi_item','absensi_item.user_id','=','overtime_sheet.user_id')->where('overtime_sheet.id',$id)->get();

       // dd($over);

        return view('karyawan.overtime-custom.claim')->with($params);
    }

    public function prosesclaim(Request $request)
    {
        $data = OvertimeSheet::where('id', $request->id)->first();
        $data->status_claim               = 1;
        $data->date_claim                 = date('Y-m-d H:i:s'); 

        foreach($request->id_overtime_form as $key => $item)
        {
            if($item == "" )
            {
                $form = new \App\Models\OvertimeSheetForm;
                $form->overtime_sheet_id= $data->id;
                $form->description  = $request->description[$key];
                $form->tanggal      = $request->tanggal[$key];
            }else{
                $form = \App\Models\OvertimeSheetForm::where('id', $request->id_overtime_form[$key])->first();
            }
            $form->awal_claim                 = $request->awal_claim[$key];
            $form->akhir_claim                = $request->akhir_claim[$key];
            $form->total_lembur_claim         = $request->total_lembur_claim[$key];
            $form->save();
        }

        $params['data']     = $data;
        $historyApprov = HistoryApprovalOvertime::where('overtime_sheet_id',$data->id)->get();
        $settingApprovalItem = HistoryApprovalOvertime::where('overtime_sheet_id',$data->id)->where('setting_approval_level_id',1)->first();

        $userApproval = user_approval_custom($settingApprovalItem);
        foreach ($userApproval as $key => $value) { 
            if($value->email == "") continue;
            $params['data']     = $data;
            $params['value']    = $historyApprov;
                $params['text']     = '<p><strong>Dear Sir/Madam '. $value->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Claim of Overtime and currently waiting your approval.</p>';

           \Mail::send('email.overtime-approval-custom', $params,
                function($message) use($data, $value) {
                $message->from('emporeht@gmail.com');
                $message->to($value->email);
                $message->subject('Empore - Overtime Sheet');
            }); 
        }
        $data->save();
        return redirect()->route('karyawan.overtime-custom.index')->with('message-success', 'Data successfully saved!');
    }
}
