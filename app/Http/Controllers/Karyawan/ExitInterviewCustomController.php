<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExitInterview;
use App\Models\ExitClearanceDocument;
use App\Models\ExitClearanceInventoryHrd;
use App\Models\ExitClearanceInventoryGa;
use App\Models\ExitClearanceInventoryIt;
use App\Models\ExitInterviewAssets;
use App\Models\HistoryApprovalExit;
use App\Models\SettingApprovalClearance;
use App\User;


class ExitInterviewCustomController extends Controller
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
        $params['data'] = ExitInterview::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.exit-interview-custom.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('karyawan.exit-interview-custom.create');
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
        $checkApproval = \Auth::user()->approvalLeave;
        if($checkApproval == null)
        {
            return redirect()->route('karyawan.exit-custom.index')->with('message-error', 'Setting approval not define yet. Please contact your admin !');
        }else {
            $checkApproval = $checkApproval->level1Exit;
            if($checkApproval == null){
                return redirect()->route('karyawan.exit-custom.index')->with('message-error', 'Setting approval is not defined yet. Please contact your admin !');
            }
            $data       = new ExitInterview();
        $data->status               = 1;
        $data->user_id              = \Auth::user()->id;
        $data->resign_date          = date('Y-m-d', strtotime($request->resign_date));
        $data->last_work_date       = date('Y-m-d', strtotime($request->last_work_date));

        $data->exit_interview_reason = $request->exit_interview_reason;
        $data->other_reason = $request->other_reason;

        $data->hal_berkesan             = $request->hal_berkesan;
        $data->hal_tidak_berkesan       = $request->hal_tidak_berkesan;
        $data->masukan                  = $request->masukan;
        $data->kegiatan_setelah_resign  = $request->kegiatan_setelah_resign;
        $data->tujuan_perusahaan_baru   = $request->tujuan_perusahaan_baru;
        $data->jenis_bidang_usaha       = $request->jenis_bidang_usaha;
        $data->save();

        // INVENTARIS
        $dataAsset      = \Auth::user()->assets;
        if(isset($dataAsset))
        {
            foreach($dataAsset as $key => $item)
            {
                $new                        = new ExitInterviewAssets();
                $new->asset_id              = $item->id;
                $new->exit_interview_id     = $data->id;
                $new->save();
            }
        }

        $params['data']     = $data;
        $position = \Auth::user()->structure_organization_custom_id;
        $settingApproval = \Auth::user()->approvalLeave->id; //idnya
        $settingApprovalItem = \Auth::user()->approvalLeave->level1Exit->structure_organization_custom_id;

            $historyApproval    = \Auth::user()->approvalLeave->itemsExit;
            foreach ($historyApproval as $key => $value) {
                # code...
                $history = new HistoryApprovalExit();
                $history->exit_interview_id = $data->id;
                $history->setting_approval_level_id = $value->setting_approval_level_id;
                $history->structure_organization_custom_id = $value->structure_organization_custom_id;
                $history->save();
            }
            $historyApprov = HistoryApprovalExit::where('exit_interview_id',$data->id)->get();

            $userApproval = user_approval_custom($settingApprovalItem);
            foreach ($userApproval as $key => $value) {

                if($value->email == "") continue;

                $params['data']     = $data;
                $params['value']    = $historyApprov;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $value->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Exit Interview and currently waiting your approval.</p>';
               \Mail::send('email.exit-approval-custom', $params,
                    function($message) use($data, $value) {
                    $message->from('emporeht@gmail.com');
                    $message->to($value->email);
                    $message->subject(get_setting('mail_name').' - Exit Interview');
                });
            }
            return redirect()->route('karyawan.exit-custom.index')->with('message-success', 'Exit Interview succesfully process');

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
        $params['data']                             = ExitInterview::where('id', $id)->first();
    
        return view('karyawan.exit-interview-custom.detail')->with($params);
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

    public function clearance($id)
    {
        $params['data']      = ExitInterviewAssets::where('exit_interview_id', $id)->get(); 
        return view('karyawan.exit-interview-custom.clearance')->with($params);
    }

    public function prosesclearance(Request $request)
    {
        if($request->asset != null)
        {
            $user = \Auth::user();
            foreach($request->asset as $key => $item)
            {
                $dataAset = ExitInterviewAssets::where('id', $request->asset[$key])->first();
            //  $dataAset->user_check  = isset($request->user_check[$key]) ? 1 : 0;
                $dataAset->catatan     = $request->catatan[$key];
                $dataAset->save();
            }
            $data = ExitInterview::where('id',$dataAset->exit_interview_id)->first();

            if($user->project_id != NULL)
            {
                $clearanceApproval = SettingApprovalClearance::join('users', 'users.id','=', 'setting_approval_clearance.user_created')->where('users.project_id', $user->project_id)->select('setting_approval_clearance.*')->get();
            }else{
                $clearanceApproval = SettingApprovalClearance::all();
            }

            foreach ($clearanceApproval as $key => $value) 
            {

                if($value->user->email == "") continue;
                $params['data']     = $data;
                $params['text']     = '<p><strong>Dear Sir/Madam '. $value->user->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Exit Clearance and currently waiting your approval.</p>';
                   \Mail::send('email.clearance-approval-custom', $params,
                        function($message) use($data,$value) {
                        $message->from('emporeht@gmail.com');
                        $message->to($value->user->email);
                        $message->subject(get_setting('mail_name').' - Exit Clearance');
                    }); 
            }
        }
        return redirect()->route('karyawan.exit-custom.index')->with('message-success', 'Exit Clearance succesfully process');
    }


}
