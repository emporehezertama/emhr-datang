<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OvertimeSheet;
use App\Models\OvertimeSheetForm;
use App\User;
use App\Models\HistoryApprovalOvertime;
use App\Models\LiburNasional;
use App\Models\CutiBersama;


class ApprovalOvertimeCustomController extends Controller
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
        
        $params['data'] = cek_overtime_approval();

        return view('administrator.approval-overtime-custom.index')->with($params);
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
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']         = OvertimeSheet::where('id', $id)->first();
        $params['history'] = HistoryApprovalOvertime::where('overtime_sheet_id',$id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        return view('administrator.approval-overtime-custom.detail')->with($params);
    }

    public function proses(Request $request)
    {

        $data = OvertimeSheet::where('id', $request->id)->first();

        foreach($request->id_overtime_form as $key => $item)
        {
            $form = \App\Models\OvertimeSheetForm::where('id', $request->id_overtime_form[$key])->first();
            $form->pre_awal_approved          = $request->pre_awal_approved[$key];
            $form->pre_akhir_approved         = $request->pre_akhir_approved[$key];
            $form->pre_total_approved         = $request->pre_total_approved[$key];
            $form->save();
        }
        
        $historyApprov      = HistoryApprovalOvertime::where('overtime_sheet_id',$data->id)->get();
        $params['data']     = $data;
        $params['value']    = $historyApprov;

        $history =  HistoryApprovalOvertime::where('overtime_sheet_id',$request->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        $overtimeHistory = $data->historyApproval;
        $trukturlast = $overtimeHistory->last();

        if($request->status == 0)
        {
            $status = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Overtime <strong style="color: red;">REJECTED</strong>.</p>';
            // send email
            \Mail::send('email.overtime-approval-custom', $params,
                function($message) use($data,$historyApprov) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject(get_setting('mail_name').' - Overtime Sheet');
                }
            ); 
            $history->approval_id    = \Auth::user()->id;
            $history->is_approved    = 0;
            $history->date_approved  = date('Y-m-d H:i:s');
            $history->note           = $request->noteApproval;
            $history->save();

        }else 
        {
            if($trukturlast->structure_organization_custom_id == \Auth::user()->structure_organization_custom_id)
                {
                    $status = 2;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Overtime <strong style="color: green;">APPROVED</strong>.</p>';

                    \Mail::send('email.overtime-approval-custom', $params,
                        function($message) use($data,$historyApprov) {
                            $message->from('emporeht@gmail.com');
                            $message->to($data->user->email);
                            $message->subject(get_setting('mail_name').' - Overtime Sheet');
                        });  
                        $history->approval_id    = \Auth::user()->id;
                        $history->is_approved    = 1;
                        $history->date_approved  = date('Y-m-d H:i:s');
                        $history->note           = $request->noteApproval;
                        $history->save();
                } else{
                    $status = 1;
                    $userLevelNext = $history->setting_approval_level_id +1;
                    $userDataNext = HistoryApprovalOvertime::where('overtime_sheet_id',$history->overtime_sheet_id)->where('setting_approval_level_id', $userLevelNext)->first();
                    $userStructure = $userDataNext["structure_organization_custom_id"];
                    $userApproval = user_approval_custom($userStructure);

                   // dd($userDataNext, $userStructure, $userApproval);

                    foreach ($userApproval as $key => $items) { 
                        if($items->email == "") continue;
                            $params['text']     = '<p><strong>Dear Sir/Madam '. $items->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Overtime and currently waiting your approval.</p>';

                            \Mail::send('email.overtime-approval-custom', $params,
                                function($message) use($data, $historyApprov,$items) {
                                $message->from('emporeht@gmail.com');
                                $message->to($items->email);
                                $message->subject(get_setting('mail_name').' - Overtime Sheet');
                            }); 
                    }
                    $history->approval_id    = \Auth::user()->id;
                    $history->is_approved    = 1;
                    $history->date_approved  = date('Y-m-d H:i:s');
                    $history->note           = $request->noteApproval;
                    $history->save();
                }
        }
        $data->status = $status;
        $data->save();

        return redirect()->route('administrator.approval.overtime-custom.index')->with('message-success', 'Form Overtime Successfully Processed !');

    }
    //claim
    public function claim($id)
    {   
        $params['data']         = OvertimeSheet::where('id', $id)->first();
        $params['history'] = HistoryApprovalOvertime::where('overtime_sheet_id',$id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        return view('administrator.approval-overtime-custom.claim')->with($params);
    }

    public function chekDateOVertime(Request $date)
    {
        $cuti_bersama   = CutiBersama::all();
        $libur_nasional = LiburNasional::all();
        $user_ts = strtotime($date);
        $result;

        foreach ($cuti_bersama as $key => $value_cuti) {
            # code...
            $start_ts = strtotime($value_cuti->dari_tanggal);
            $end_ts = strtotime($value_cuti->sampai_tanggal);
            if(($user_ts >= $start_ts) && ($user_ts <= $end_ts))
                $result = true;
            else
                $result = false;
        }
        foreach ($libur_nasional as $key => $value_libur) {
            # code...
            if($user_ts == $value_libur->tanggal)
                $result = true;
            else
                $result = false;
        }

        return $result;
    }

    //prosesClaim
    public function prosesClaim (Request $request)
    {
        $data = OvertimeSheet::where('id', $request->id)->first();

        foreach($request->id_overtime_form as $key => $item)
        {
            $form = \App\Models\OvertimeSheetForm::where('id', $request->id_overtime_form[$key])->first();
            $form->awal_approved                 = $request->awal_approved[$key];
            $form->akhir_approved                = $request->akhir_approved[$key];
            $form->total_lembur_approved         = $request->total_lembur_approved[$key];
            $form->overtime_calculate            = $request->overtime_calculate[$key];
            $form->save();
        }
        
        $historyApprov      = HistoryApprovalOvertime::where('overtime_sheet_id',$data->id)->get();
        $params['data']     = $data;
        $params['value']    = $historyApprov;

        $history =  HistoryApprovalOvertime::where('overtime_sheet_id',$request->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        $overtimeHistory = $data->historyApproval;
        $trukturlast = $overtimeHistory->last();

        if($request->status == 0)
        {
            $status_claim = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Claim of Overtime <strong style="color: red;">REJECTED</strong>.</p>';
            // send email
            \Mail::send('email.overtime-approval-custom', $params,
                function($message) use($data,$historyApprov) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject(get_setting('mail_name').' - Overtime Sheet');
                }
            ); 
            $history->approval_id_claim    = \Auth::user()->id;
            $history->is_approved_claim    = 0;
            $history->date_approved_claim  = date('Y-m-d H:i:s');
            $history->note_claim           = $request->note_claim;
            $history->save();

        }else 
        {
            if($trukturlast->structure_organization_custom_id == \Auth::user()->structure_organization_custom_id)
                {
                    $status_claim = 2;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Claim of Overtime <strong style="color: green;">APPROVED</strong>.</p>';

                    \Mail::send('email.overtime-approval-custom', $params,
                        function($message) use($data,$historyApprov) {
                            $message->from('emporeht@gmail.com');
                            $message->to($data->user->email);
                            $message->subject(get_setting('mail_name').' - Overtime Sheet');
                        });  
                        $history->approval_id_claim    = \Auth::user()->id;
                        $history->is_approved_claim    = 1;
                        $history->date_approved_claim  = date('Y-m-d H:i:s');
                        $history->note_claim           = $request->note_claim;
                        $history->save();
                } else{
                    $status_claim = 1;
                    $userLevelNext = $history->setting_approval_level_id +1;
                    $userDataNext = HistoryApprovalOvertime::where('overtime_sheet_id',$history->overtime_sheet_id)->where('setting_approval_level_id', $userLevelNext)->first();
                    $userStructure = $userDataNext["structure_organization_custom_id"];
                    $userApproval = user_approval_custom($userStructure);

                   // dd($userDataNext, $userStructure, $userApproval);

                    foreach ($userApproval as $key => $items) { 
                        if($items->email == "") continue;
                            $params['text']     = '<p><strong>Dear Sir/Madam '. $items->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Claim of Overtime and currently waiting your approval.</p>';

                            \Mail::send('email.overtime-approval-custom', $params,
                                function($message) use($data, $historyApprov,$items) {
                                $message->from('emporeht@gmail.com');
                                $message->to($items->email);
                                $message->subject(get_setting('mail_name').' - Overtime Sheet');
                            }); 
                    }
                    $history->approval_id_claim    = \Auth::user()->id;
                    $history->is_approved_claim    = 1;
                    $history->date_approved_claim  = date('Y-m-d H:i:s');
                    $history->note_claim           = $request->note_claim;
                    $history->save();
                }
        }
        $data->status_claim = $status_claim;
        $data->save();

        return redirect()->route('administrator.approval.overtime-custom.index')->with('message-success', 'Form Overtime Successfully Processed !');
    }
}
