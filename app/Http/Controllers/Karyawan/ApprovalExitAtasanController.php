<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExitInterview;
use App\Models\ExitClearanceDocument;
use App\Models\ExitClearanceInventoryHrd;
use App\Models\ExitClearanceInventoryGa;
use App\Models\ExitInterviewAssets;
use App\Models\ExitClearanceInventoryIt;

class ApprovalExitAtasanController extends Controller
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
        $params['data'] = ExitInterview::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-exit-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $exit                           = ExitInterview::where('id', $request->id)->first();

        if($request->action == 'proses')
        {
            $exit->is_approved_atasan       = $request->status;
            $exit->noted_atasan             = $request->noted_atasan;
            $exit->date_approved_atasan     = date('Y-m-d H:i:s');

            $params['data']     = $exit;
            
            if($request->status == 1)
            {
                $params['text']     = '<p><strong>Dear Bapak/Ibu '. $exit->direktur->name .'</strong>,</p> <p> '. $exit->user->name .'  / '.  $exit->user->nik .' mengajukan Exit & Asset Clearance butuh persetujuan Anda.</p>';   
            }
            else
            {
                $params['text']     = '<p><strong>Dear Bapak/Ibu '. $exit->user->name .'</strong>,</p> <p> Pengajuan Exit & Asset Clearance Anda <strong style="color: red;">DITOLAK</strong>.</p>';
            }

            \Mail::send('email.exit-approval', $params,
                function($message) use($exit) {
                    $message->from('emporeht@gmail.com');
                    $message->to($exit->direktur->email);
                    $message->subject('Empore - Pengajuan Exit & Asset Clearance');
                }
            );
        }

        $exit->save();    

        if(isset($request->check_dokument))
        {
            foreach($request->check_dokument as $k => $item)
            {
                if(!empty($item))
                {
                    $doc = ExitClearanceDocument::where('id', $k)->first();

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
                    $doc = ExitClearanceInventoryHrd::where('id', $k)->first();
                    
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
                    $doc = ExitClearanceInventoryGa::where('id', $k)->first();
                    
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
                $asset          = ExitInterviewAssets::where('id', $item)->first();
                $asset->status  = $request->check_asset[$item];
                $asset->catatan = $request->catatan_asset[$item];
                $asset->save();
            }
        }

        return redirect()->route('karyawan.approval.exit-atasan.index')->with('messages-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']                                 = ExitInterview::where('id', $id)->first();
        $params['list_exit_clearance_document']         = ExitClearanceDocument::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_hrd'] = ExitClearanceInventoryHrd::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_ga']  = ExitClearanceInventoryGa::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_it']  = ExitClearanceInventoryIt::where('exit_interview_id', $id)->get();

        return view('karyawan.approval-exit-atasan.detail')->with($params);
    }
}
