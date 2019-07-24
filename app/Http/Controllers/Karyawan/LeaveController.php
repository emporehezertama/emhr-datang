<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CutiKaryawan;
use App\User;
use App\Models\SettingApprovalLeaveItem;
use App\Models\SettingApprovalLeave;
use App\Models\HistoryApprovalLeave;

class LeaveController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $params['data'] = CutiKaryawan::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.leave.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();
        $params['karyawan_backup'] = User::whereIn('access_id', [1,2])->get();

        return view('karyawan.leave.create')->with($params);
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
        $checkApproval = \Auth::user()->approvalLeave->level1;
        if($checkApproval == null)
        {
            return redirect()->route('karyawan.leave.index')->with('message-error', 'Setting approval not define yet. Please contact your admin !');
        }else{
            $data                   = new CutiKaryawan();
            $data->user_id          = \Auth::user()->id;
            $data->jenis_cuti       = $request->jenis_cuti;
            $data->tanggal_cuti_start= date('Y-m-d' , strtotime($request->tanggal_cuti_start));
            $data->tanggal_cuti_end = date('Y-m-d' , strtotime($request->tanggal_cuti_end));
            $data->keperluan        = $request->keperluan;
            $data->backup_user_id   = $request->backup_user_id;
            $data->status           = 1;

            $data->jam_pulang_cepat    = $request->jam_pulang_cepat;
            $data->jam_datang_terlambat= $request->jam_datang_terlambat;
            $data->total_cuti           = $request->total_cuti;
            $data->temp_kuota               = $request->temp_kuota;
            $data->temp_cuti_terpakai       = $request->temp_cuti_terpakai;
            $data->temp_sisa_cuti           = $request->temp_sisa_cuti;
            $data->save();
            
            $params['data']     = $data;
            $position = \Auth::user()->structure_organization_custom_id;
            $settingApproval = \Auth::user()->approvalLeave->id; //idnya
            $settingApprovalItem = \Auth::user()->approvalLeave->level1->structure_organization_custom_id;//cek setting_approval_leave_id = settingApproval_id dan level 1 dan ambil structure_organization_custom_id trus cek tabel user yang posisinya dan kirim email => outputnya structure_organization_custom_id

            //tambah data ke history
            $historyApproval    = \Auth::user()->approvalLeave->items;
            foreach ($historyApproval as $key => $value) {
                # code...
                $history = new HistoryApprovalLeave();
                $history->cuti_karyawan_id = $data->id;
                $history->setting_approval_level_id = $value->setting_approval_level_id;
                $history->structure_organization_custom_id = $value->structure_organization_custom_id;
                $history->save();
            }
            $historyApprov = HistoryApprovalLeave::where('cuti_karyawan_id',$data->id)->get();

            $userApproval = user_approval_custom($settingApprovalItem);

            foreach ($userApproval as $key => $value) { 
                
                if($value->email == "") continue;
                
                $params['data']     = $data;
                $params['value']    = $historyApprov;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $value->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Leave/Permit and currently waiting your approval.</p>';

               \Mail::send('email.leave-approval-custom', $params,
                    function($message) use($data, $value) {
                    $message->from('emporeht@gmail.com');
                    $message->to($value->email);
                    $message->subject(get_setting('mail_name').' - Submission of Leave / Permit');
                }); 
            }
            return redirect()->route('karyawan.leave.index')->with('message-success', 'Data saved successfully !');
        }

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
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();
        $params['karyawan_backup'] = User::whereIn('access_id', [1,2])->get();
        $params['data']     = CutiKaryawan::where('id', $id)->first();

        return view('karyawan.leave.edit')->with($params);
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
}
