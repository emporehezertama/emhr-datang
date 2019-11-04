<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CutiKaryawan;
use App\User;

class CutiController extends Controller 
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
        $params['data'] = CutiKaryawan::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.cuti.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();
        $params['karyawan_backup'] = User::whereIn('access_id', [1,2])->get();

        return view('karyawan.cuti.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();
        $params['karyawan_backup'] = User::whereIn('access_id', [1,2])->get();
        $params['data']     = CutiKaryawan::where('id', $id)->first();

        return view('karyawan.cuti.edit')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = CutiKaryawan::where('id', $id)->first();
        $data->delete();

        return redirect()->route('karyawan.cuti.index')->with('message-sucess', 'Data successfully deleted');
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new CutiKaryawan();
        $data->user_id          = \Auth::user()->id;
        $data->jenis_cuti       = $request->jenis_cuti;
        $data->tanggal_cuti_start= date('Y-m-d' , strtotime($request->tanggal_cuti_start));
        $data->tanggal_cuti_end = date('Y-m-d' , strtotime($request->tanggal_cuti_end));
        $data->keperluan        = $request->keperluan;
        $data->backup_user_id   = $request->backup_user_id;
        $data->status           = 1;
        $data->is_personalia_id = 0;
        $data->approved_atasan_id     = $request->atasan_user_id;

        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            if(empty($request->atasan_user_id))
            {
                $data->is_approved_atasan = 1;
            }
        }

        $data->jam_pulang_cepat    = $request->jam_pulang_cepat;
        $data->jam_datang_terlambat= $request->jam_datang_terlambat;
        $data->total_cuti       = $request->total_cuti;
        $data->approve_direktur_id = get_direktur(\Auth::user()->id)->id;
        $atasan = \App\User::where('id', $request->atasan_user_id)->first();
        $data->temp_kuota               = $request->temp_kuota;
        $data->temp_cuti_terpakai       = $request->temp_cuti_terpakai;
        $data->temp_sisa_cuti           = $request->temp_sisa_cuti;
        $data->save();
/*
        $params['data']     = $data;
        $params['text']     = '<p><strong>Dear Dear Sir/Madam '. $data->atasan->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Leave/Permit and currently waiting your approval.</p>';

        \Mail::send('email.cuti-approval', $params,
            function($message) use($data) {
                $message->from('emporeht@gmail.com');
                $message->to($data->atasan->email);
                $message->subject('Empore - Submission of Leave / Permit');
            }
        );
*/
         $params['data']     = $data;
        if($request->atasan_user_id != null) {
            $params['text']     = '<p><strong> Dear Sir/Madam '. $data->atasan->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Leave/Permit and currently waiting your approval.</p>';

            \Mail::send('email.cuti-approval', $params,
            function($message) use($data) {
                $message->from('emporeht@gmail.com');
                $message->to($data->atasan->email);
                $message->subject('Empore - Submission of Leave / Permit');
            }
            );
        } elseif($request->atasan_user_id == null){
            $params['text']     = '<p><strong> Dear Sir/Madam '. $data->direktur->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Leave/Permit and currently waiting your approval.</p>';

            \Mail::send('email.cuti-approval', $params,
            function($message) use($data) {
                $message->from('emporeht@gmail.com');
                $message->to($data->direktur->email);
                $message->subject('Empore - Submission of Leave / Permit');
            }
            );
        }


        return redirect()->route('karyawan.cuti.index')->with('message-success', 'Data saved successfully !');
    }
}
