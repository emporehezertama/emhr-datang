<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Training;

class ApprovalTrainingAtasanController extends Controller
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
        $params['data']         = Training::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();
        $params['data_biaya']   = Training::where('approved_atasan_id', \Auth::user()->id)->where('is_approve_atasan_actual_bill', 0)->where('status_actual_bill', 2)->get();

        return view('karyawan.approval-training-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $training                           = Training::where('id', $request->id)->first();
        $training->is_approved_atasan       = $request->status;
        $training->date_approved_atasan     = date('Y-m-d H:i:s');

        if($request->status == 1)
        {
            $params['data']     = $training;
            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $training->direktur->name .'</strong>,</p> <p> '. $training->user->name .'  / '.  $training->user->nik .' mengajukan Training dan Perjalanan Dinas butuh persetujuan Anda.</p>';

            \Mail::send('email.training-approval', $params,
                function($message) use($training) {
                    $message->from('emporeht@gmail.com');
                    $message->to($training->direktur->email);
                    $message->subject('Empore - Pengajuan Training dan Perjalanan Dinas');
                }
            );
        }
        else
        {
            $training->status = 3;
            $params['data']     = $training;
            $params['text']     = '<p> Training dan Perjalanan Dinas anda di <label style="color: red;"><b>Tolak</b></label>.</p>';

            \Mail::send('email.training-approval', $params,
                function($message) use($training) {
                    $message->from('emporeht@gmail.com');
                    $message->to($training->user->email);
                    $message->subject('Empore - Pengajuan Training dan Perjalanan Dinas');
                }
            );
        }

        $training->save();   

        return redirect()->route('karyawan.approval.training-atasan.index')->with('message-success', 'Form Training Berhasil diproses !');
    }

    /**
     * [prosesBiaya description]
     * @return [type] [description]
     */
    public function prosesBiaya(Request $request)
    {
        $data = Training::where('id', $request->id)->first();
 
        $data->transportasi_ticket_disetujui    = $request->transportasi_ticket_disetujui;
        $data->transportasi_ticket_catatan      = $request->transportasi_ticket_catatan;
        $data->transportasi_taxi_disetujui      = $request->transportasi_taxi_disetujui;
        $data->transportasi_taxi_catatan        = $request->transportasi_taxi_catatan;
        $data->transportasi_gasoline_disetujui  = $request->transportasi_gasoline_disetujui;
        $data->transportasi_gasoline_catatan    = $request->transportasi_gasoline_catatan;
        $data->transportasi_tol_disetujui       = $request->transportasi_tol_disetujui;
        $data->transportasi_tol_catatan         = $request->transportasi_tol_catatan;
        $data->transportasi_parkir_disetujui    = $request->transportasi_parkir_disetujui;
        $data->transportasi_parkir_catatan      = $request->transportasi_parkir_catatan;
        $data->uang_hotel_nominal_disetujui     = $request->uang_hotel_nominal_disetujui;
        $data->uang_hotel_catatan               = $request->uang_hotel_catatan;
        $data->uang_makan_nominal_disetujui     = $request->uang_makan_nominal_disetujui;
        $data->uang_makan_catatan               = $request->uang_makan_catatan;
        $data->uang_harian_nominal_disetujui    = $request->uang_harian_nominal_disetujui;
        $data->uang_harian_catatan              = $request->uang_harian_catatan;
        $data->uang_pesawat_nominal_disetujui   = $request->pesawat_nominal_disetujui;
        $data->uang_pesawat_catatan             = $request->uang_pesawat_catatan;
        $data->uang_biaya_lainnya1_nominal_disetujui = $request->uang_biaya_lainnya1_nominal_disetujui;
        $data->uang_biaya_lainnya1_catatan      = $request->uang_biaya_lainnya1_catatan;
        $data->uang_biaya_lainnya2_nominal_disetujui = $request->uang_biaya_lainnya2_nominal_disetujui;
        $data->uang_biaya_lainnya2_catatan      = $request->uang_biaya_lainnya2_catatan;
        
        $data->sub_total_1_disetujui            = $request->sub_total_1_disetujui;
        $data->sub_total_2_disetujui            = $request->sub_total_2_disetujui;
        $data->sub_total_3_disetujui            = $request->sub_total_3_disetujui;

        if($request->status_actual_bill == 1)
        {
            $data->is_approve_atasan_actual_bill = 1;
        }
        else
        {
            $data->is_approve_atasan_actual_bill = 0;
            $data->status_actual_bill = 4; // reject
        }
        
        $data->save();

        return redirect()->route('karyawan.approval.training-atasan.index')->with('message-success', 'Form Actual Bill berhasil di proses');
    }

    /**
     * [biaya description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function biaya($id)
    {
        $params['data'] = Training::where('id', $id)->first();

        return view('karyawan.approval-training-atasan.biaya')->with($params);
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = Training::where('id', $id)->first();

        return view('karyawan.approval-training-atasan.detail')->with($params);
    }
}
