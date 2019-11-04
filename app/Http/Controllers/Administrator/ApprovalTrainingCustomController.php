<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\HistoryApprovalTraining;
use App\Models\TrainingTransportationType; 
use App\Models\TrainingTransportation; 
use App\Models\TrainingAllowance; 
use App\Models\TrainingDaily; 
use App\Models\TrainingOther; 

class ApprovalTrainingCustomController extends Controller
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
        //dd(cek_training_approval());
        $params['data'] = cek_training_approval();
        return view('administrator.approval-training-custom.index')->with($params);
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
        $params['data']         = Training::where('id', $id)->first();
        $params['history'] = HistoryApprovalTraining::where('training_id',$id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        return view('administrator.approval-training-custom.detail')->with($params);
    }

    public function proses(Request $request)
    {

        $data = Training::where('id', $request->id)->first();
        
        $historyApprov      = HistoryApprovalTraining::where('training_id',$data->id)->get();
        $params['data']     = $data;
        $params['value']    = $historyApprov;

        $history =  HistoryApprovalTraining::where('training_id',$request->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        $trainingHistory = $data->historyApproval;
        $trukturlast = $trainingHistory->last();

        if($request->status == 0)
        {
            $status = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Business Trip / Training <strong style="color: red;">REJECTED</strong>.</p>';
            // send email
            \Mail::send('email.training-approval-custom', $params,
                function($message) use($data,$historyApprov) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject(get_setting('mail_name').' - Business Trip / Training');
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
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Business Trip / Training <strong style="color: green;">APPROVED</strong>.</p>';

                    \Mail::send('email.training-approval-custom', $params,
                        function($message) use($data,$historyApprov) {
                            $message->from('emporeht@gmail.com');
                            $message->to($data->user->email);
                            $message->subject(get_setting('mail_name').' - Business Trip / Training');
                        });  
                        $history->approval_id    = \Auth::user()->id;
                        $history->is_approved    = 1;
                        $history->date_approved  = date('Y-m-d H:i:s');
                        $history->note           = $request->noteApproval;
                        $history->save();
                } else{
                    $status = 1;
                    $userLevelNext = $history->setting_approval_level_id +1;
                    $userDataNext = HistoryApprovalTraining::where('training_id',$history->training_id)->where('setting_approval_level_id', $userLevelNext)->first();
                    $userStructure = $userDataNext["structure_organization_custom_id"];
                    $userApproval = user_approval_custom($userStructure);

                   // dd($userDataNext, $userStructure, $userApproval);

                    foreach ($userApproval as $key => $items) { 
                        if($items->email == "") continue;
                            $params['text']     = '<p><strong>Dear Sir/Madam '. $items->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Business Trip / Training and currently waiting your approval.</p>';

                            \Mail::send('email.training-approval-custom', $params,
                                function($message) use($data, $historyApprov,$items) {
                                $message->from('emporeht@gmail.com');
                                $message->to($items->email);
                                $message->subject(get_setting('mail_name').' - Business Trip / Training');
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

        return redirect()->route('administrator.approval.training-custom.index')->with('message-success', 'Form Business Trip / Training Successfully Processed !');

    }
    //claim
    public function claim($id)
    {   
        $params['data']         = Training::where('id', $id)->first();
        $params['history'] = HistoryApprovalTraining::where('training_id',$id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        return view('administrator.approval-training-custom.biaya')->with($params);
    }
    public function prosesClaim(Request $request)
    {
        $data = Training::where('id', $request->id)->first();
        
        if($request->id_acomodation != null)
        {
            foreach($request->id_acomodation as $key => $item)
            {
                $acomodation = \App\Models\TrainingTransportation::where('id', $request->id_acomodation[$key])->first();
                $acomodation->nominal_approved              = preg_replace('/[^0-9]/', '', $request->nominalAcomodation_approved[$key]);
                $acomodation->save();
            }
        }
        if($request->id_allowance != null)
        {
            foreach($request->id_allowance as $key => $item)
            {
                $allowance = \App\Models\TrainingAllowance::where('id', $request->id_allowance[$key])->first();
                $allowance->morning_approved              = preg_replace('/[^0-9]/', '', $request->morning_approved[$key]);
                $allowance->afternoon_approved            = preg_replace('/[^0-9]/', '', $request->afternoon_approved[$key]);
                $allowance->evening_approved              = preg_replace('/[^0-9]/', '', $request->evening_approved[$key]);
                $allowance->save();
            }
        }
        if($request->id_daily != null)
        {
            foreach($request->id_daily as $key => $item)
            {
                $daily = \App\Models\TrainingDaily::where('id', $request->id_daily[$key])->first();
                $daily->daily_approved              = preg_replace('/[^0-9]/', '', $request->nominalDaily_approved[$key]);
                $daily->save();
            }
        }
        if($request->id_other != null)
        {
            foreach($request->id_other as $key => $item)
            {
                $other = \App\Models\TrainingOther::where('id', $request->id_other[$key])->first();
                $other->nominal_approved              = preg_replace('/[^0-9]/', '', $request->nominalOther_approved[$key]);
                $other->save();
            }
        }
        
        $historyApprov      = HistoryApprovalTraining::where('training_id',$data->id)->get();
        $params['data']     = $data;
        $params['value']    = $historyApprov;

        $history =  HistoryApprovalTraining::where('training_id',$request->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        $trainingHistory = $data->historyApproval;
        $trukturlast = $trainingHistory->last();

        if($request->status_actual_bill == 0)
        {
            $status_actual_bill = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Claim of Business Trip /Training <strong style="color: red;">REJECTED</strong>.</p>';
            // send email
            \Mail::send('email.training-approval-custom', $params,
                function($message) use($data,$historyApprov) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject(get_setting('mail_name').' - Business Trip /Training');
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
                    $status_actual_bill = 2;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Business Trip /Training <strong style="color: green;">APPROVED</strong>.</p>';

                    \Mail::send('email.training-approval-custom', $params,
                        function($message) use($data,$historyApprov) {
                            $message->from('emporeht@gmail.com');
                            $message->to($data->user->email);
                            $message->subject(get_setting('mail_name').' - Business Trip /Training');
                        });  
                        $history->approval_id_claim    = \Auth::user()->id;
                        $history->is_approved_claim    = 1;
                        $history->date_approved_claim  = date('Y-m-d H:i:s');
                        $history->note_claim           = $request->note_claim;
                        $history->save();
                } else{
                    $status_actual_bill = 1;
                    $userLevelNext = $history->setting_approval_level_id +1;
                    $userDataNext = HistoryApprovalTraining::where('training_id',$history->training_id)->where('setting_approval_level_id', $userLevelNext)->first();
                    $userStructure = $userDataNext["structure_organization_custom_id"];
                    $userApproval = user_approval_custom($userStructure);

                   // dd($userDataNext, $userStructure, $userApproval);

                    foreach ($userApproval as $key => $items) { 
                        if($items->email == "") continue;
                            $params['text']     = '<p><strong>Dear Sir/Madam '. $items->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Claim of Business Trip /Training and currently waiting your approval.</p>';

                            \Mail::send('email.training-approval-custom', $params,
                                function($message) use($data, $historyApprov,$items) {
                                $message->from('emporeht@gmail.com');
                                $message->to($items->email);
                                $message->subject(get_setting('mail_name').' - Business Trip /Training');
                            }); 
                    }
                    $history->approval_id_claim    = \Auth::user()->id;
                    $history->is_approved_claim    = 1;
                    $history->date_approved_claim  = date('Y-m-d H:i:s');
                    $history->note_claim           = $request->note_claim;
                    $history->save();
                }
        }
        $data->sub_total_1_disetujui = $request->sub_total_1_disetujui;
        $data->sub_total_2_disetujui = $request->sub_total_2_disetujui;
        $data->sub_total_3_disetujui = $request->sub_total_3_disetujui;
        $data->sub_total_4_disetujui = $request->sub_total_4_disetujui;

        $data->status_actual_bill = $status_actual_bill;
        $data->save();

        return redirect()->route('administrator.approval.training-custom.index')->with('message-success', 'Form Business Trip/Training Successfully Processed !');

    }
}
