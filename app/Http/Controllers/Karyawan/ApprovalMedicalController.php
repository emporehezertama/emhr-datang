<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalReimbursement;
use App\Models\MedicalReimbursementForm;
use App\Models\SettingApproval;

class ApprovalMedicalController extends Controller
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
        // cek jenis user
       
        $params['data'] = MedicalReimbursement::where('approve_direktur_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-medical.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $data = MedicalReimbursement::where('id', $request->id)->first();        
        $data->approve_direktur = $request->status;
        $data->approve_direktur_date = date('Y-m-d H:i:s');

        $params['data'] = $data;

        // Jika approve
        if($request->status == 1)
        {
            $data->status =2;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p> Submission of your Medical Reimbursement <strong style="color: green;">APPROVED</strong>.</p>';

            \Mail::send('email.medical-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Medical Reimbursement');
                }
            );
        }
        else // jika reject
        {
            $data->status = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p> Submission of your Medical Reimbursement <strong style="color: red;">REJECTED</strong>.</p>';

            \Mail::send('email.medical-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Medical Reimbursement');
                }
            );
        }   

        $data->save();

        foreach($request->nominal_approve as $id => $val)
        {
            $form                       = MedicalReimbursementForm::where('id', $id)->first();
            $form->nominal_approve      = str_replace(',', '', $val);
            $form->save();
        }

        return redirect()->route('karyawan.approval.medical.index')->with('message-success', 'Form Medical Reimbursement successfully process !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']         = MedicalReimbursement::where('id', $id)->first();
        $params['approval']     = SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','medical')->first();

        return view('karyawan.approval-medical.detail')->with($params);
    }
}
