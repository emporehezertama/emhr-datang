<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalReimbursement;
use App\Models\MedicalReimbursementForm;
use App\Models\HistoryApprovalMedical;

class ApprovalMedicalCustomController extends Controller
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
        $params['data'] = cek_medical_approval();
       
        return view('administrator.approval-medical-custom.index')->with($params);
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
        $params['data']         = MedicalReimbursement::where('id', $id)->first();
        $params['history'] = HistoryApprovalMedical::where('medical_reimbursement_id',$id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        return view('administrator.approval-medical-custom.detail')->with($params);
    }

    public function proses(Request $request)
    {   
        if(isset($request->nominal_approve))
        {
            foreach($request->nominal_approve as $k => $item)
            {
                $i = MedicalReimbursementForm::where('id', $k)->first();
                if($i)
                {
                    $i->nominal_approve    = preg_replace('/[^0-9]/', '', $item);
                    $i->save();
                }
            }
        }
        
        $data = MedicalReimbursement::where('id', $request->id)->first();
        $status                         = $request->status;

        $historyApprov      = HistoryApprovalMedical::where('medical_reimbursement_id',$data->id)->get();
        $params['data']     = $data;
        $params['value']    = $historyApprov;

        $history =  HistoryApprovalMedical::where('medical_reimbursement_id',$request->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        $medicalHistory = $data->historyApproval;
        $trukturlast = $medicalHistory->last();

        if($request->status == 0)
        {
            $status = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Medical Reimbursement <strong style="color: red;">REJECTED</strong>.</p>';
            // send email
            \Mail::send('email.medical-approval-custom', $params,
                function($message) use($data,$historyApprov) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Medical Reimbursement');
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
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Medical Reimbursement <strong style="color: green;">APPROVED</strong>.</p>';

                    \Mail::send('email.medical-approval-custom', $params,
                        function($message) use($data,$historyApprov) {
                            $message->from('emporeht@gmail.com');
                            $message->to($data->user->email);
                            $message->subject('Empore - Medical Reimbursement');
                        });  
                        $history->approval_id    = \Auth::user()->id;
                        $history->is_approved    = 1;
                        $history->date_approved  = date('Y-m-d H:i:s');
                        $history->note           = $request->noteApproval;
                        $history->save();
                } else{
                    $status = 1;
                    $userLevelNext = $history->setting_approval_level_id +1;
                    $userDataNext = HistoryApprovalMedical::where('medical_reimbursement_id',$history->medical_reimbursement_id)->where('setting_approval_level_id', $userLevelNext)->first();
                    $userStructure = $userDataNext["structure_organization_custom_id"];
                    $userApproval = user_approval_custom($userStructure);

                   // dd($userDataNext, $userStructure, $userApproval);Medical Reimbursement

                    foreach ($userApproval as $key => $items) { 
                        if($items->email == "") continue;
                            $params['text']     = '<p><strong>Dear Sir/Madam '. $items->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Medical Reimbursement and currently waiting your approval.</p>';

                            \Mail::send('email.medical-approval-custom', $params,
                                function($message) use($data, $historyApprov,$items) {
                                $message->from('emporeht@gmail.com');
                                $message->to($items->email);
                                $message->subject('Empore - Medical Reimbursement');
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

        return redirect()->route('administrator.approval.medical-custom.index')->with('message-success', 'Form Medical Reimbursement Successfully Processed !');
    }
}
