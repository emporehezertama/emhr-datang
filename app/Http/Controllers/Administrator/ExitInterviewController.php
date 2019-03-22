<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExitInterview;
use App\Models\ExitClearanceDocument;
use App\Models\ExitClearanceInventoryHrd;
use App\Models\ExitClearanceInventoryGa;
use App\Models\ExitClearanceInventoryIt;

class ExitInterviewController extends Controller
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
        $data = ExitInterview::orderBy('id', 'DESC')->select('exit_interview.*')->join('users', 'users.id', '=', 'exit_interview.user_id');

        if(request())
        {
            if(!empty(request()->employee_status))
            {
                $data = $data->where('users.organisasi_status', request()->employee_status);
            }

            if(!empty(request()->jabatan))
            {   
                if(request()->jabatan == 'Direktur')
                {
                    $data = $data->whereNull('users.empore_organisasi_staff_id')->whereNull('users.empore_organisasi_manager_id')->where('users.empore_organisasi_direktur', '<>', '');
                }

                if(request()->jabatan == 'Manager')
                {
                    $data = $data->whereNull('users.empore_organisasi_staff_id')->where('users.empore_organisasi_manager_id', '<>', '');
                }

                if(request()->jabatan == 'Staff')
                {
                    $data = $data->where('users.empore_organisasi_staff_id', '<>', '');
                }
            }

            if(request()->action == 'download')
            {
                $this->downloadExcel($data->get());
            }
        }

        $params['data'] = $data->paginate(50);

        return view('administrator.exit-interview.index')->with($params);
    }

    /**
     * [downloadExcel description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function downloadExcel($data)
    {
        $params = [];

        foreach($data as $item)
        {
            if($item->assets)
            {
                foreach($item->assets as $no => $i)
                {
                    $params[$no]['NO']                  = $no+1;
                    $params[$no]['ASSET NUMBER']        = $i->asset->asset_number;
                    $params[$no]['ASSET NAME']          = $i->asset->asset_name;
                    $params[$no]['ASSET TYPE']          = (isset($i->asset->asset_type->name) ? $i->asset->asset_type->name : '');
                    $params[$no]['PURCHASE DATE']       = $i->asset->purchase_date;
                    $params[$no]['REMARK']              = $i->asset->remark;
                    $params[$no]['RENTAL DATE']         = $i->asset->rental_date;
                    $params[$no]['ASSET CONDITION']     = $i->asset->asset_condition;
                    $params[$no]['ASSIGN TO']           = $i->asset->assign_to;
                    $params[$no]['EMPLOYEE/PIC NAME']   = (isset($i->asset->user->name) ? $i->asset->user->name : '');
                    $params[$no]['HANDOVER DATE']       = $i->asset->handover_date;
                    $params[$no]['STATUS']              = status_asset($i->status);
                }
            }
        }

        $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            ''
        ];

        return \Excel::create('Report-Exit-and-Asset-Clearance',  function($excel) use($params, $styleHeader){

              $excel->sheet('mysheet',  function($sheet) use($params){

                $sheet->fromArray($params);
                
              });

            $excel->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($styleHeader);

        })->download('xls');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {
        $params['data'] = ExitInterview::where('id', $id)->first();

        $approval = new \stdClass;
        $approval->nama_approval = 'HRD';
        $approval->user_id = \Auth::user()->id;
        $params['approval'] = $approval;

        $params['list_exit_clearance_document']             = ExitClearanceDocument::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_hrd']     = ExitClearanceInventoryHrd::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_ga']      = ExitClearanceInventoryGa::where('exit_interview_id', $id)->get();
        $params['list_exit_clearance_inventory_to_it']      = ExitClearanceInventoryIt::where('exit_interview_id', $id)->get();

        return view('administrator.exit-interview.detail')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
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

        $exit = ExitInterview::where('id', $request->id)->first();

        if($exit)
        {
            $exit->is_approved_hrd = $request->is_approved_hrd;
            
            if($request->proses == 1)
            {
                if($request->is_approved_hrd == 1)
                {
                    $exit->status = 2;   
                }
                else
                {
                    $exit->status = 3;   
                }
            }

            $exit->save();
        }

        return redirect()->route('administrator.exit-interview.index')->with('message-success', 'Form Exit Exit Interview & Exit Clearance Berhasil di update');
    }
}
