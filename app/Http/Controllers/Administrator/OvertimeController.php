<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OvertimeSheet;
use App\Models\OvertimeSheetForm;
use App\User;

class OvertimeController extends Controller
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
        $data = OvertimeSheet::select('overtime_sheet.*')->orderBy('id', 'DESC')->join('users', 'users.id', '=', 'overtime_sheet.user_id');

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

        $params['data'] = $data->get();

        return view('administrator.overtime.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['karyawan'] = User::where('access_id', 2)->get();

        return view('administrator.overtime.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = OvertimeSheet::where('id', $id)->first();

        return view('administrator.overtime.edit')->with($params);
    }

    /**
     * [batal description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function batal(Request $request)
    {   
        $data       = OvertimeSheet::where('id', $request->id)->first();
        $data->status = 4;
        $data->note_pembatalan = $request->note;
        $data->save(); 

        return redirect()->route('administrator.overtime.index')->with('message-success', 'Overtime Berhasil dibatalkan');
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = OvertimeSheet::where('id', $id)->first();
        $data->save();

        return redirect()->route('administrator.overtime.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = OvertimeSheet::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.overtima.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data               = new OvertimeSheet();
        $data->user_id      = $request->user_id;
        $data->status       = 1;  
        $data->save();

        foreach($request->form as $key => $item)
        {   
            $form               = new OvertimeSheetForm();
            $form->description  = $request->description[$key];
            $form->awal         = $request->awal[$key];
            $form->akhir        = $request->akhir[$key];
            $form->employee_id  = $request->employee_id[$key];
            $form->spv_id       = $request->spv_id;
            $form->manager_id   = $request->manager_id;
            $form->save();
        }

        return redirect()->route('administrator.overtime.index')->with('message-success', 'Data berhasil disimpan !');
    }

    /**
     * [downloadExlce description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloadExcel($data)
    {
        $params = [];

        $total_loop_header = [];
        foreach($data as $no =>  $item)
        {
            $total = 0;
            foreach($item->overtime_form as $type => $form)
            {
                $total++;
            }
            $total_loop_header[] = $total;
        }

        foreach($data as $no =>  $item)
        {
            $params[$no]['NO']               = $no+1;
            $params[$no]['NIK']              = $item->user->nik;
            $params[$no]['NAMA KARYAWAN']    = $item->user->name;
            $params[$no]['POSITION']         = empore_jabatan($item->user_id);
            
            $total=0;
            foreach($item->overtime_form as $type => $form)
            {   
                $type = $type+1;   
                $params[$no]['TGL PENGAJUAN '.$type]    = $form->tanggal;
                $params[$no]['DESCRIPTION '.$type]      = $form->description;
                $params[$no]['JAM AWAL '.$type]         = $form->awal;
                $params[$no]['JAM AKHIR '.$type]        = $form->akhir;
                $params[$no]['TOTAL LEMBUR '.$type]     = $form->total_lembur;
                $params[$no]['TGL APPROVAL '.$type]     = $form->total_approval;
                $total++;       
            }
            if($total ==0 ) $total++;
            for($v=$total; $v < max($total_loop_header); $v++)
            {
                $params[$no]['TGL PENGAJUAN '.($v+1)]     = '-';
                $params[$no]['DESCRIPTION '.($v+1)]       = '-';
                $params[$no]['JAM AWAL '.($v+1)]          = '-';
                $params[$no]['JAM AKHIR '.($v+1)]         = '-';
                $params[$no]['TOTAL LEMBUR '.($v+1)]      = '-';
                $params[$no]['TGL APPROVAL '.($v+1)]      = '-';
            }
            $params[$no]['TGL APPROVAL']     = $item->approve_direktur_date !== NULL ? date('d F Y', strtotime($item->approve_direktur_date)) : '';
            $params[$no]['SUPERVISOR']       = isset($item->direktur->name) ? $item->direktur->name : "";
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

        return \Excel::create('Report-Overtime-Sheet-Karyawan',  function($excel) use($params, $styleHeader){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
            $excel->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($styleHeader);
        })->download('xls');
    }
}