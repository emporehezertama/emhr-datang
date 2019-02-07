<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CutiKaryawan;

class ApprovalCutiAtasanController extends Controller
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
        $params['data'] = CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-cuti-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $cuti                           = CutiKaryawan::where('id', $request->id)->first();
        $cuti->is_approved_atasan       = $request->status;
        $cuti->catatan_atasan           = $request->noted;
        $cuti->date_approved_atasan     = date('Y-m-d H:i:s');

        $params['data']     = $cuti;

        if($request->status == 0)
        {
            $cuti->status = 3 ;

            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $cuti->user->name .'</strong>,</p> <p>  Pengajuan Cuti / Ijin anda <strong style="color: red;">DITOLAK</strong>.</p>';

            \Mail::send('email.cuti-approval', $params,
                function($message) use($cuti) {
                    $message->from('emporeht@gmail.com');
                    $message->to($cuti->karyawan->email);
                    $message->subject('Empore - Pengajuan Cuti / Izin');
                }
            );
        }
        else
        {
            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $cuti->direktur->name .'</strong>,</p> <p> '. $cuti->user->name .'  / '.  $cuti->user->nik .' mengajukan Cuti / Ijin butuh persetujuan Anda.</p>';

            \Mail::send('email.cuti-approval', $params,
                function($message) use($cuti) {
                    $message->from('emporeht@gmail.com');
                    $message->to($cuti->direktur->email);
                    $message->subject('Empore - Pengajuan Cuti / Izin');
                }
            );
        }

        $cuti->save();

        return redirect()->route('karyawan.approval.cuti-atasan.index')->with('message-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = CutiKaryawan::where('id', $id)->first();

        return view('karyawan.approval-cuti-atasan.detail')->with($params);
    }
}
