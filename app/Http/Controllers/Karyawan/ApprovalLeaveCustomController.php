<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CutiKaryawan;
use App\Models\UserCuti;
use App\Models\Cuti;
use App\Helper\GeneralHelper;
use App\Models\HistoryApprovalLeave;
use App\Models\SettingApprovalLeave;
use App\Models\SettingApprovalLeaveItem;
use App\Models\SettingApprovalLevel;

class ApprovalLeaveCustomController extends Controller
{
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
        $params['datas'] = cek_leave_approval();
       
        return view('karyawan.approval-leave-custom.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

     public function detail($id)
    {   
        $params['datas'] = CutiKaryawan::where('id', $id)->first();
        $params['history'] = HistoryApprovalLeave::where('cuti_karyawan_id', $params['datas']->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        return view('karyawan.approval-leave-custom.detail')->with($params);
    }

    public function proses(Request $request)
    {
        $cuti = CutiKaryawan::where('id', $request->id)->first();
        $leaveHistory = $cuti->historyApproval;
        $trukturlast = $leaveHistory->last();

        $cuti->status = $request->status;
        $historyApprov = HistoryApprovalLeave::where('cuti_karyawan_id',$cuti->id)->get();
    
        $params['data']     = $cuti;
        $params['value']    = $historyApprov;
        
        $history =  HistoryApprovalLeave::where('cuti_karyawan_id',$request->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

    
        if($request->status == 0)
        {
            $status = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $cuti->user->name .'</strong>,</p> <p>  Submission of your Leave / Permit <strong style="color: red;">REJECTED</strong>.</p>';
            // send email
            \Mail::send('email.leave-approval-custom', $params,
                function($message) use($cuti,$historyApprov) {
                    $message->from('emporeht@gmail.com');
                    $message->to($cuti->karyawan->email);
                    $message->subject(get_setting('mail_name').' - Submission of Leave / Permit');
                }
            ); 
            $history->approval_id    = \Auth::user()->id;
            $history->is_approved    = 0;
            $history->date_approved  = date('Y-m-d H:i:s');
            $history->note           = $request->note;
            $history->save();

        }else 
        {
            if($trukturlast->structure_organization_custom_id == \Auth::user()->structure_organization_custom_id)
                {
                    $status = 2;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $cuti->user->name .'</strong>,</p> <p>  Submission of your Leave / Permit <strong style="color: green;">APPROVED</strong>.</p>';

                    \Mail::send('email.leave-approval-custom', $params,
                        function($message) use($cuti,$historyApprov) {
                            $message->from('emporeht@gmail.com');
                            $message->to($cuti->karyawan->email);
                            $message->subject(get_setting('mail_name').' - Submission of Leave / Permit');
                        });  

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
                        }else {
                            $user_cuti->cuti_terpakai   = $user_cuti->cuti_terpakai + $cuti->total_cuti;
                            $user_cuti->sisa_cuti       = $user_cuti->kuota - $user_cuti->cuti_terpakai;
                            $user_cuti->save();
                            /*
                           // jika cuti maka kurangi kuota
                            if(strpos($user_cuti->cuti->jenis_cuti, 'Cuti') !== false)
                            {
                                // kurangi cuti tahunan user jika sudah di approved
                                $user_cuti->cuti_terpakai   = $user_cuti->cuti_terpakai + $cuti->total_cuti;
                                $user_cuti->sisa_cuti       = $user_cuti->kuota - $user_cuti->cuti_terpakai;
                                $user_cuti->save();
                            }
                            */
                        }
                        $cuti->temp_sisa_cuti           = $cuti->temp_sisa_cuti - $cuti->total_cuti;
                        $cuti->temp_cuti_terpakai       = $cuti->total_cuti + $cuti->temp_cuti_terpakai;

                        //$history = HistoryApprovalLeave::where('id', $value->id)->first();
                        $history->approval_id    = \Auth::user()->id;
                        $history->is_approved    = 1;
                        $history->date_approved  = date('Y-m-d H:i:s');
                        $history->note           = $request->note;
                        $history->save();
                } else{
                    $status = 1;
                    $userLevelNext = $history->setting_approval_level_id +1;
                    $userDataNext = HistoryApprovalLeave::where('cuti_karyawan_id',$history->cuti_karyawan_id)->where('setting_approval_level_id', $userLevelNext)->first();
                    $userStructure = $userDataNext["structure_organization_custom_id"];
                    $userApproval = user_approval_custom($userStructure);

                   // dd($userDataNext, $userStructure, $userApproval);

                    foreach ($userApproval as $key => $items) { 
                        if($items->email == "") continue;
                            $params['text']     = '<p><strong>Dear Sir/Madam '. $items->name .'</strong>,</p> <p> '. $cuti->user->name .'  / '.  $cuti->user->nik .' applied for Leave/Permit and currently waiting your approval.</p>';

                            \Mail::send('email.leave-approval-custom', $params,
                                function($message) use($cuti, $historyApprov,$items) {
                                $message->from('emporeht@gmail.com');
                                $message->to($items->email);
                                $message->subject(get_setting('mail_name').' - Submission of Leave / Permit');
                            }); 
                    }
                    $history->approval_id    = \Auth::user()->id;
                    $history->is_approved    = 1;
                    $history->date_approved  = date('Y-m-d H:i:s');
                    $history->note           = $request->note;
                    $history->save();
                }

            /*foreach ($leaveHistory as $key => $value) {
                
            }
            */
        }

        $cuti->status = $status;
        $cuti->save();

        //$params['datas'] = cek_leave_approval();
         return redirect()->route('karyawan.approval.leave-custom.index')->with('messages-success', 'Leave Form Successfully processed !');
    }

}
