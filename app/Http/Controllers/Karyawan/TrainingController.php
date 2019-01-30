<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Training;
use App\User;

class TrainingController extends Controller
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
        $params['data'] = Training::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.training.index')->with($params);
    }

    /**
     * [detailAll description]
     * @return [type] [description]
     */
    public function detailAll($id)
    {
        $params['data'] = \App\Training::where('id', $id)->first(); 

        $data = $params['data'];

        $params['total_transportasi_nominal'] = $data->transportasi_ticket + $data->transportasi_taxi + $data->transportasi_gasoline + $data->transportasi_tol + $data->transportasi_parkir;

        $params['total_hotel_nominal'] = $data->uang_hotel_nominal + $data->uang_makan_nominal + $data->uang_harian_nominal + $data->uang_pesawat_nominal;
        $params['total_hotel_qty']  = $data->uang_hotel_qty + $data->uang_makan_qty + $data->uang_harian_qty + $data->uang_pesawat_qty;
        
        $params['total_lainnya'] = $data->uang_biaya_lainnya1 + $data->uang_biaya_lainnya2; 
        $params['total_hotel_nominal_dan_qty'] = ($data->uang_hotel_nominal * $data->uang_hotel_qty) + ($data->uang_makan_nominal * $data->uang_makan_qty) + ($data->uang_harian_nominal * $data->uang_harian_qty) + ($data->uang_pesawat_nominal * $data->uang_pesawat_qty) ;

        return view('karyawan.training.detail-all')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('karyawan.training.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = Training::where('id', $id)->first();

        return view('karyawan.training.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = Training::where('id', $id)->first();
        $data->save();

        return redirect()->route('karyawan.training.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Training::where('id', $id)->first();
        $data->delete();

        return redirect()->route('karyawan.training.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [detailTraining description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detailTraining($id)
    {   
        $params['data'] = \App\Training::where('id', $id)->first();

        return view('karyawan.training.detail-training')->with($params);
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function biaya($id)
    {
        $params['data']             = \App\Training::where('id', $id)->first();
        //$params['plafond_dinas']    = plafond_perjalanan_dinas( (\Auth::user()->organisasiposition->name == 'Head' ? 'Supervisor' : \Auth::user()->organisasiposition->name));

        return view('karyawan.training.biaya')->with($params);
    }   

    /**
     * [submitBiaya description]
     * @return [type] [description]
     */
    public function submitBiaya(Request $request)
    {
        $data = \App\Training::where('id', $request->id)->first();
        $data->transportasi_ticket = $request->transportasi_ticket;
        $data->transportasi_taxi = $request->transportasi_taxi;
        $data->transportasi_gasoline = $request->transportasi_gasoline;
        $data->transportasi_tol = $request->transportasi_tol;
        $data->transportasi_parkir = $request->transportasi_parkir;
        
        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            $data->is_approved_atasan = 1;
        }

        if (request()->hasFile('transportasi_ticket_file'))
        {
            $file = $request->file('transportasi_ticket_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_ticket_file = $fileName;
        }
        
        if (request()->hasFile('transportasi_taxi_file'))
        {
            $file = $request->file('transportasi_taxi_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_taxi_file = $fileName;
        }

        $data->transportasi_gasoline    = $request->transportasi_gasoline;
        if (request()->hasFile('transportasi_gasoline_file'))
        {
            $file = $request->file('transportasi_gasoline_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_gasoline_file = $fileName;
        }

        $data->transportasi_tol    = $request->transportasi_tol;
        if (request()->hasFile('transportasi_tol_file'))
        {
            $file = $request->file('transportasi_tol_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_tol_file = $fileName;
        }

        $data->transportasi_parkir    = $request->transportasi_parkir;
        if (request()->hasFile('transportasi_parkir_file'))
        {
            $file = $request->file('transportasi_parkir_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_parkir_file = $fileName;
        }

        $data->uang_hotel_plafond    = $request->uang_hotel_plafond;
        $data->uang_hotel_nominal    = $request->uang_hotel_nominal;
        $data->uang_hotel_qty    = $request->uang_hotel_qty;

        if (request()->hasFile('uang_hotel_file'))
        {
            $file = $request->file('uang_hotel_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->uang_hotel_file = $fileName;
        }

        $data->uang_makan_plafond    = $request->uang_makan_plafond;
        $data->uang_makan_nominal    = $request->uang_makan_nominal;
        $data->uang_makan_qty        = $request->uang_makan_qty;

        if (request()->hasFile('uang_makan_file'))
        {
            $file = $request->file('uang_makan_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->uang_makan_file = $fileName;
        }

        $data->uang_harian_plafond    = $request->uang_harian_plafond;
        $data->uang_harian_nominal    = $request->uang_harian_nominal;
        $data->uang_harian_qty    = $request->uang_harian_qty;

        if (request()->hasFile('uang_harian_file'))
        {
            $file = $request->file('uang_harian_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->uang_harian_file = $fileName;
        }

        $data->uang_pesawat_plafond    = $request->uang_pesawat_plafond;
        $data->uang_pesawat_nominal    = $request->uang_pesawat_nominal;
        $data->uang_pesawat_qty    = $request->uang_pesawat_qty;

        if (request()->hasFile('uang_pesawat_file'))
        {
            $file = $request->file('uang_pesawat_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->uang_pesawat_file = $fileName;
        }

        $data->uang_biaya_lainnya1    = $request->uang_biaya_lainnya1;
        $data->uang_biaya_lainnya1_nominal    = $request->uang_biaya_lainnya1_nominal;
        
        if (request()->hasFile('uang_biaya_lainnya1_file'))
        {
            $file = $request->file('uang_biaya_lainnya1_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->uang_biaya_lainnya1_file = $fileName;
        }

        $data->uang_biaya_lainnya2    = $request->uang_biaya_lainnya2;
        $data->uang_biaya_lainnya2_nominal    = $request->uang_biaya_lainnya2_nominal;
        
        if (request()->hasFile('uang_biaya_lainnya2_file'))
        {
            $file = $request->file('uang_biaya_lainnya2_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->uang_biaya_lainnya2_file = $fileName;
        }

        $data->status_actual_bill = $request->status_actual_bill;
        $data->sub_total_1 = $request->sub_total_1;
        $data->sub_total_2 = $request->sub_total_2;
        $data->sub_total_3 = $request->sub_total_3;
        $data->noted_bill = $request->noted_bill;
        $data->date_submit_actual_bill = date('Y-m-d');
        $data->save();

        return redirect()->route('karyawan.training.index')->with('message-success', 'Actual bill berhasil diproses ');
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                           = new Training();
        $data->user_id                  = \Auth::user()->id;
        // Form Kegiatan
        $data->jenis_training           = $request->jenis_training;
        $data->cabang_id                = $request->cabang_id;
        $data->lokasi_kegiatan          = $request->lokasi_kegiatan;
        $data->tempat_tujuan            = $request->tempat_tujuan;
        $data->topik_kegiatan           = $request->topik_kegiatan;
        $data->tanggal_kegiatan_start   = $request->tanggal_kegiatan_start;
        $data->tanggal_kegiatan_end     = $request->tanggal_kegiatan_end;
        $data->pengambilan_uang_muka    = $request->pengambilan_uang_muka;
        $data->tanggal_pengajuan        = $request->tanggal_pengajuan;
        $data->tanggal_penyelesaian     = $request->tanggal_penyelesaian;
        $data->approved_atasan_id       = $request->approved_atasan_id;

        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            $data->is_approved_atasan = 1;
        }

        // Form Perjalanan Menggunakan Pesawat
        $data->pesawat_perjalanan       = $request->pesawat_perjalanan;
        $data->tanggal_berangkat        = $request->tanggal_berangkat;
        $data->waktu_berangkat          = $request->waktu_berangkat;
        $data->tanggal_pulang           = $request->tanggal_pulang;
        $data->waktu_pulang             = $request->waktu_pulang;
        $data->pesawat_rute_dari        = $request->pesawat_rute_dari;
        $data->pesawat_rute_tujuan      = $request->pesawat_rute_tujuan;
        $data->pesawat_kelas            = $request->pesawat_kelas;
        $data->pesawat_maskapai         = $request->pesawat_maskapai;
        $data->status                   = 1;
        $data->others                   = $request->others;
        $data->pergi_bersama            = $request->pergi_bersama;
        $data->note                     = $request->note;
        $data->approve_direktur_id      = get_direktur(\Auth::user()->id)->id; 
        $data->save();

        $params['data']     = $data;
        $params['text']     = '<p><strong>Dear Bapak/Ibu '. $data->atasan->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' mengajukan Training dan Perjalanan Dinas butuh persetujuan Anda.</p>';

        \Mail::send('email.training-approval', $params,
            function($message) use($data) {
                $message->from('emporeht@gmail.com');
                $message->to($data->atasan->email);
                $message->subject('Empore - Pengajuan Training dan Perjalanan Dinas');
            }
        );

        return redirect()->route('karyawan.training.index')->with('message-success', 'Payment Request berhasil di proses');
    }
}
