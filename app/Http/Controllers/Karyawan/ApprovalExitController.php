<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalExitController extends Controller
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
        $params['data'] = \App\ExitInterview::where('approve_direktur_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-exit.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {   
        $exit                           = \App\ExitInterview::where('id', $request->id)->first();    
        $exit->approve_direktur         = $request->status;;
        $exit->approve_direktur_date    = date('Y-m-d H:i:s');

        $params['data']     = $exit;
        if($request->action == 'proses')
        {
            if($request->status == 1)
            {
                $exit->status = 2;
                
                $params['text']     = '<p><strong>Dear Bapak/Ibu '. $exit->user->name .'</strong>,</p> <p> Pengajuan Exit & Asset Clearance Anda <strong style="color: green;">DISETUJUI</strong>.</p>';
            }
            else
            {
                $exit->status = 3;

                $params['text']     = '<p><strong>Dear Bapak/Ibu '. $exit->user->name .'</strong>,</p> <p> Pengajuan Exit & Asset Clearance Anda <strong style="color: red;">DITOLAK</strong>.</p>';
            }
        }

        \Mail::send('email.exit-approval', $params,
            function($message) use($exit) {
                $message->from('emporeht@gmail.com');
                $message->to($exit->user->email);
                $message->subject('Empore - Pengajuan Exit & Asset Clearance');
            }
        );

        $exit->save();    

        if(isset($request->check_dokument))
        {
            foreach($request->check_dokument as $k => $item)
            {
                if(!empty($item))
                {
                    $doc = \App\ExitClearanceDocument::where('id', $k)->first();

                    if($doc->hrd_checked == 0)
                    {
                        $doc->hrd_check_date = date('Y-m-d H:i:s');                        
                    } 

                    $doc->hrd_checked = 1;
                    $doc->hrd_note = $request->check_document_catatan[$k];
                    $doc->save();
                }
            }
        }

        if(isset($request->check_inventory_hrd))
        {
            foreach($request->check_inventory_hrd as $k => $item)
            {
                if(!empty($item))
                {
                    $doc = \App\ExitClearanceInventoryHrd::where('id', $k)->first();
                    
                    if($doc->hrd_checked == 0)
                    {
                        $doc->hrd_check_date = date('Y-m-d H:i:s');                        
                    } 

                    $doc->hrd_checked = 1;
                    $doc->hrd_note = $request->check_inventory_hrd_catatan[$k];
                    $doc->save();
                }
            }
        }

        if(isset($request->check_inventory_ga))
        {
            foreach($request->check_inventory_ga as $k => $item)
            {
                if(!empty($item))
                {
                    $doc = \App\ExitClearanceInventoryGa::where('id', $k)->first();
                    
                    if($doc->ga_checked == 0)
                    {
                        $doc->ga_check_date = date('Y-m-d H:i:s');                        
                    } 

                    $doc->ga_checked = 1;
                    $doc->ga_note = $request->check_inventory_ga_catatan[$k];
                    $doc->save();
                }
            }
        }

        if(isset($request->asset))
        {
            foreach($request->asset as $item)
            {
                $asset          = \App\ExitInterviewAssets::where('id', $item)->first();
                $asset->status  = $request->check_asset[$item];
                $asset->catatan = $request->catatan_asset[$item];
                $asset->save();

                // change status asset
                $asset  = \App\Asset::where('id', $asset->asset_id)->first();
                if($asset)
                {
                    $asset->assign_to = 'Office Inventory/idle';
                    $asset->save();
                }
            } 
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
        $params['data'] = \App\ExitInterview::where('id', $id)->first();
        $params['approval'] = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','exit_clearance')->first();

        $params['list_exit_clearance_document'] = \App\ExitClearanceDocument::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_hrd'] = \App\ExitClearanceInventoryHrd::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_ga'] = \App\ExitClearanceInventoryGa::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_it'] = \App\ExitClearanceInventoryIt::where('exit_interview_id', $id)->get();

        return view('karyawan.approval-exit.detail')->with($params);
    }
}
