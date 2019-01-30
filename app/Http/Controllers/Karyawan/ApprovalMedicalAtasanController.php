<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalMedicalAtasanController extends Controller
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
        $params['data'] = \App\MedicalReimbursement::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();
 
        return view('karyawan.approval-medical-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $data = \App\MedicalReimbursement::where('id', $request->id)->first();
        
        $data->is_approved_atasan = $request->status;
        $params['data'] = $data;
        
        if($request->status == 0)
        {
            $data->status = 3 ;

            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $data->user->name .'</strong>,</p> <p>  Pengajuan Medical Reimbursement anda <strong style="color: red;">DITOLAK</strong>.</p>';

            \Mail::send('email.medical-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Pengajuan Medical Reimbursement');
                }
            );
        }
        else
        {
            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $data->direktur->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' mengajukan Medical Reimbursement butuh persetujuan Anda.</p>';

            \Mail::send('email.medical-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->direktur->email);
                    $message->subject('Empore - Pengajuan Medical Reimbursement');
                }
            );
        }

        $data->date_approved_atasan = date('Y-m-d H:i:s');
        $data->save();

        foreach($request->nominal_approve as $id => $val)
        {
            $form                       = \App\MedicalReimbursementForm::where('id', $id)->first();
            $form->nominal_approve      = str_replace(',', '', $val);
            $form->save();
        }

        return redirect()->route('karyawan.approval.medical-atasan.index')->with('message-success', 'Form Medical Reimbursement Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = \App\MedicalReimbursement::where('id', $id)->first();

        return view('karyawan.approval-medical-atasan.detail')->with($params);
    }
}
