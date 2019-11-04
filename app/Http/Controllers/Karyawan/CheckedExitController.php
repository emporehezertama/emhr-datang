<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingApproval;
use App\Models\ExitInterview;
use App\Models\StatusApproval;
use App\Models\ExitClearanceDocument;
use App\Models\ExitClearanceInventoryHrd;
use App\Models\ExitClearanceInventoryGa;
use App\Models\ExitClearanceInventoryIt;

class CheckedExitController extends Controller
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

        // cek jenis user
        $approval = SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','exit_clearance')->first();
        $params['data'] = [];

        if($approval)
        {
            if($approval->nama_approval =='HRD')
            {
                $params['data'] = ExitInterview::where('status', 1)->where('is_approved_atasan', 1)->where('is_approved_hrd', 0)->orderBy('id', 'DESC')->get();
            }

            if($approval->nama_approval =='GA')
            {
                $params['data'] = ExitInterview::where('status', 1)->where('is_approved_atasan', 1)->where('is_approved_ga', 0)->orderBy('id', 'DESC')->get();
            }

            if($approval->nama_approval =='IT')
            {
                $params['data'] = ExitInterview::where('status', 1)->where('is_approved_atasan', 1)->where('is_approved_it', 0)->orderBy('id', 'DESC')->get();
            }
        }

        return view('karyawan.approval-exit.index')->with($params);
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
        $status->jenis_form             = 'exit';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->noted                  = $request->noted;

        $approval = SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','exit')->first();
        
        $exit = ExitInterview::where('id', $request->id)->first();        
        if($approval)
        {
            if($approval->nama_approval =='HR Manager')
            {
                $exit->is_approved_hr_manager = 1;
            }

            if($approval->nama_approval =='HR GM')
            {
                $exit->is_approved_hr_gm = 1;
            }

            if($approval->nama_approval =='HR Director')
            {
                $exit->is_approved_hr_director = 1;
            }   
        }
        $exit->save();    

        $exit = ExitInterview::where('id', $request->id)->first();
        if($exit->is_approved_hr_manager ==1 and $exit->is_approved_hr_gm ==1 and $exit->is_approved_hr_director == 1)
        {
            // cek semua approval
            $status = StatusApproval::where('jenis_form', 'exit')
                                            ->where('foreign_id', $request->id)
                                            ->where('status', 0)
                                            ->count();

            $exit = ExitInterview::where('id', $request->id)->first();
            if($status >=1)
            {
                $status = 3;

                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $exit->user->name .'</p><p> Pengajuan Exit Interview dan Exit Clearance anda ditolak.</p>' ;
            }
            else
            {
                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $exit->user->name .'</p><p> Pengajuan Exit Interview dan Exit Clearance anda disetujui.</p>' ;

                $status = 2;
            }

            //\Mail::to('doni.enginer@gmail.com')->send(new \App\Mail\GeneralMail($objDemo));

            $exit->status = $status;
            $exit->save();
        }

        return redirect()->route('karyawan.approval.exit.index')->with('message-success', 'Form Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']         = ExitInterview::where('id', $id)->first();
        $params['approval']     = SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','exit_clearance')->first();
        $params['list_exit_clearance_document']         = ExitClearanceDocument::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_hrd'] = ExitClearanceInventoryHrd::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_ga']  = ExitClearanceInventoryGa::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_it']  = ExitClearanceInventoryIt::where('exit_interview_id', $id)->get();

        return view('karyawan.approval-exit.detail')->with($params);
    }
}
