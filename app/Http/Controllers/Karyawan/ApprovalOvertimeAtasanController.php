<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OvertimeSheet;

class ApprovalOvertimeAtasanController extends Controller
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
        $params['data'] = OvertimeSheet::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-overtime-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $data                           = OvertimeSheet::where('id', $request->id)->first();
        $data->is_approved_atasan       = $request->status;
        $data->date_approved_atasan     = date('Y-m-d H:i:s');
        
        // Jika status ditolak 
        if($request->status == 0)
        {
            $data->status = 3;

            $params['data']     = $data;
            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $data->user->name .'</strong>,</p> <p>  Pengajuan Overtime anda <strong style="color: red;">DITOLAK</strong>.</p>';

            \Mail::send('email.overtime-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Pengajuan Overtime');
                }
            );
        }
        else
        {
            $params['data']     = $data;
            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $data->direktur->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' mengajukan Overtime butuh persetujuan Anda.</p>';

            \Mail::send('email.overtime-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->direktur->email);
                    $message->subject('Empore - Pengajuan Overtime');
                }
            );
        }

        $data->save();

        return redirect()->route('karyawan.approval.overtime-atasan.index')->with('messages-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = OvertimeSheet::where('id', $id)->first();

        return view('karyawan.approval-overtime-atasan.detail')->with($params);
    }
}
