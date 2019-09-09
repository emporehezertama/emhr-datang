<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OvertimeSheet;
use App\Models\SettingApproval;

class ApprovalOvertimeController extends Controller
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
        $params['data'] = OvertimeSheet::where('approve_direktur_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-overtime.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $overtime = OvertimeSheet::where('id', $request->id)->first();
        $overtime->approve_direktur = $request->status;
        $overtime->approve_direktur_date = date('Y-m-d H:i:s');
        
        if($request->status ==0)
        {
            $status = 3;      
        }
        else
        {
            $status = 2;
        }
        $overtime->status = $status;
        $overtime->save();

        if($overtime->status == 2 || $overtime->status == 3)
        {
            $params['data']     = $overtime;
            
            if($overtime->status == 2)
                $params['text']     = '<p><strong>Dear Bapak/Ibu '. $overtime->user->name .'</strong>,</p> <p>  Pengajuan Overtime anda <strong style="color: green;">DISETUJUI</strong>.</p>';
            else
                $params['text']     = '<p><strong>Dear Bapak/Ibu '. $overtime->user->name .'</strong>,</p> <p>  Pengajuan Overtime anda <strong style="color: red;">DITOLAK</strong>.</p>';

            \Mail::send('email.overtime-approval', $params,
                function($message) use($overtime) {
                    $message->from('emporeht@gmail.com');
                    $message->to($overtime->user->email);
                    $message->subject('Empore - Pengajuan Overtime');
                }
            );
        }

        return redirect()->route('karyawan.approval.overtime.index')->with('messages-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']         = OvertimeSheet::where('id', $id)->first();
        $params['approval']     = SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','overtime')->first();

        return view('karyawan.approval-overtime.detail')->with($params);
    }
}
