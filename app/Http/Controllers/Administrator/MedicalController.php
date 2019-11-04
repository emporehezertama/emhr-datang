<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalReimbursement;
use App\Models\MedicalReimbursementForm;
use App\User;

class MedicalController extends Controller
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
        $data = MedicalReimbursement::select('medical_reimbursement.*')->orderBy('id', 'DESC')->join('users','users.id','=','medical_reimbursement.user_id');

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

        return view('administrator.medical.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();

        return view('administrator.medical.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = MedicalReimbursement::where('id', $id)->first();;
        $params['form'] = MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();

        return view('administrator.medical.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = MedicalReimbursement::where('id', $id)->first();
        $data->user_id      = $request->user_id;
        $data->tanggal_pengajuan = $request->tanggal_pengajuan;
        $data->status       = 1;  
        $data->save();

        MedicalReimbursementForm::where('medical_reimbursement_id', $id)->delete();

        foreach($request->tanggal_kwitansi as $key => $item)
        {   
            $form                           = new MedicalReimbursementForm();
            $form->medical_reimbursement_id = $data->id;
            $form->tanggal_kwitansi         = $request->tanggal_kwitansi[$key];
            $form->user_family_id              = $request->user_family_id[$key];
            $form->jenis_klaim              = $request->jenis_klaim[$key];
            $form->jumlah                   = $request->jumlah[$key];
            $form->save();
        }

        return redirect()->route('administrator.medical.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = MedicalReimbursement::where('id', $id)->first();
        $data->delete();

        MedicalReimbursementForm::where('medical_reimbursement_id', $id)->delete();

        return redirect()->route('administrator.medical.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data               = new MedicalReimbursement();
        $data->user_id      = $request->user_id;
        $data->tanggal_pengajuan = $request->tanggal_pengajuan;
        $data->status       = 1;  
        $data->save();

        foreach($request->tanggal_kwitansi as $key => $item)
        {   
            $form                           = new MedicalReimbursementForm();
            $form->medical_reimbursement_id = $data->id;
            $form->tanggal_kwitansi         = $request->tanggal_kwitansi[$key];
            $form->user_family_id              = $request->user_family_id[$key];
            $form->jenis_klaim              = $request->jenis_klaim[$key];
            $form->jumlah                   = $request->jumlah[$key];
            $form->save();
        }

        return redirect()->route('administrator.medical.index')->with('message-success', 'Data berhasil disimpan !');
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
            foreach($item->form as $type => $form)
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
            $params[$no]['TGL PENGAJUAN']    = date('d F Y', strtotime($item->tanggal_pengajuan));

            $total=0;
            $total_klaim    = 0;
            $total_approve  = 0;
            foreach($item->form as $type => $form)
            {   
                $type = $type+1;
                $params[$no]['TGL KUITANSI '.$type]     = $form->tanggal_kwitansi;
                if($item->user->id == $form->user_family_id)
                {
                    $hubungan = 'Saya Sendiri';
                }
                else
                {
                    $hubungan = $f->UserFamily->nama;
                }

                $params[$no]['HUBUNGAN '.$type]         = $hubungan;

                if($item->user->id == $form->user_family_id)
                {
                    $nama_pasien =  isset($form->user_family->name) ? $form->user_family->name : '';
                }
                else
                {
                    $nama_pasien = isset($form->UserFamily->nama) ? $form->UserFamily->nama : '';
                }

                $params[$no]['NAMA PASIEN '.$type]      = $nama_pasien;
                $params[$no]['JENIS KLAIM '.$type]      = jenis_claim_medical($form->jenis_klaim);
                $params[$no]['JUMLAH '.$type]           = $form->jumlah;
                $total++;       
                $total_klaim    += $form->jumlah;
                $total_approve  += $form->nominal_approve;
            }
            if($total ==0 ) $total++;
            for($v=$total; $v < max($total_loop_header); $v++)
            {
                $params[$no]['TGL KUITANSI '.($v+1)]    = "-";
                $params[$no]['HUBUNGAN '.($v+1)]        = "-";
                $params[$no]['NAMA PASIEN '.($v+1)]     = "-";
                $params[$no]['JENIS KLAIM '.($v+1)]     = "-";
                $params[$no]['JUMLAH '.($v+1)]          = "-";
            }
            $params[$no]['TOTAL KLAIM']      = $total_klaim;
            $params[$no]['TOTAL YG DISETUJUI']= $total_approve;
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

        return \Excel::create('Report-Medical-Reimbursement-Karyawan',  function($excel) use($params, $styleHeader){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
            $excel->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($styleHeader);
        })->download('xls');
    }
}