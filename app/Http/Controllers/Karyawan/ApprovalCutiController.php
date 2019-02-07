<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CutiKaryawan;
use App\Models\StatusApproval;
use App\Models\UserCuti;
use App\Models\Cuti;

class ApprovalCutiController extends Controller
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
        $params['data'] = CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)
                                                ->orderBy('id', 'DESC')
                                                ->get();

        return view('karyawan.approval-cuti.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $status = new StatusApproval;
        $status->approval_user_id       = \Auth::user()->id;
        $status->jenis_form             = 'cuti';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->noted                  = $request->noted;
        $status->save();    

        $cuti = CutiKaryawan::where('id', $request->id)->first();
        $cuti->approve_direktur         = $request->status;
        $cuti->approve_direktur_noted   = $request->noted;
        $cuti->approve_direktur_date    = date('Y-m-d H:i:s');
        
        $params['data']     = $cuti;

        if($request->status == 0)
        {
            $status = 3;
            
            $params['atasan']   = $cuti->atasan;
            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $cuti->user->name .'</strong>,</p> <p>  Pengajuan Cuti / Ijin anda <strong style="color: red;">DITOLAK</strong>.</p>';
            // send email
            \Mail::send('email.cuti-approval', $params,
                function($message) use($cuti) {
                    $message->from('emporeht@gmail.com');
                    $message->to($cuti->karyawan->email);
                    $message->subject('Empore - Pengajuan Cuti / Izin');
                }
            );   
        }else{
            $status = 2;

            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $cuti->user->name .'</strong>,</p> <p>  Pengajuan Cuti / Ijin anda <strong style="color: green;">DISETUJUI</strong>.</p>';
            // send email
            \Mail::send('email.cuti-approval', $params,
                function($message) use($cuti) {
                    $message->from('emporeht@gmail.com');
                    $message->to($cuti->karyawan->email);
                    $message->subject('Empore - Pengajuan Cuti / Izin');
                }
            );  

            $user_cuti = UserCuti::where('user_id', $cuti->user_id)->where('cuti_id', $cuti->jenis_cuti)->first();

            if(empty($user_cuti))
            {
                $temp = Cuti::where('id', $cuti->jenis_cuti)->first();

                if($temp)
                { 
                    $user_cuti                  = new UserCuti();
                    $user_cuti->kuota           = $temp->kuota;
                    $user_cuti->user_id         = $cuti->user_id;
                    $user_cuti->cuti_id         = $cuti->jenis_cuti;
                    $user_cuti->cuti_terpakai   = $cuti->total_cuti;
                    $user_cuti->sisa_cuti       = $temp->kuota - $cuti->total_cuti;
                    $user_cuti->save();
                }
            }
            else
            {
               // jika cuti maka kurangi kuota
                if(strpos($user_cuti->cuti->jenis_cuti, 'Cuti') !== false)
                {
                    // kurangi cuti tahunan user jika sudah di approved
                    $user_cuti->cuti_terpakai   = $user_cuti->cuti_terpakai + $cuti->total_cuti;
                    $user_cuti->sisa_cuti       = $user_cuti->kuota - $user_cuti->cuti_terpakai;
                    $user_cuti->save();
                }
            }
        }

        $cuti->status = $status;
        $cuti->is_personalia_id = \Auth::user()->id;
        $cuti->save();

        return redirect()->route('karyawan.approval.cuti.index')->with('messages-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = CutiKaryawan::where('id', $id)->first();

        return view('karyawan.approval-cuti.detail')->with($params);
    }
}
