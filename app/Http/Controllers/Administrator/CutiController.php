<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CutiKaryawan;
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
        $data = CutiKaryawan::select('cuti_karyawan.*')->join('users', 'users.id','=','cuti_karyawan.user_id')->orderBy('id', 'DESC');
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

        return view('administrator.cuti.index')->with($params);
    }

    /**
     * [downloadExlce description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloadExcel($data)
    {
        $params = [];

        foreach($data as $no =>  $item)
        {
            $params[$no]['NO']               = $no+1;
            $params[$no]['NIK']              = $item->user->nik;
            $params[$no]['NAMA KARYAWAN']    = $item->user->name;
            $params[$no]['POSITION']         = empore_jabatan($item->user_id);
            $params[$no]['TGL CUTI/IJIN AWAL']= date('d F Y', strtotime($item->tanggal_cuti_start));
            $params[$no]['TGL CUTI/IJIN AKHIR']=date('d F Y', strtotime($item->tanggal_cuti_end));
            $params[$no]['JENIS CUTI / IJIN']= isset($item->cuti->jenis_cuti) ? $item->cuti->jenis_cuti : '';
            $params[$no]['LAMA CUTI / IJIN'] = $item->total_cuti;
            $params[$no]['KEPERLUAN']        = $item->keperluan;
            $params[$no]['SISA CUTI']        = get_cuti_user($item->jenis_cuti, $item->user_id, 'sisa_cuti'); //$item->user->cuti->sisa_cuti;

            $status = '';
            if($item->is_approved_atasan == ""){
                $status = 'Waiting Approval Atasan';
            }
            else
            {
                if($item->approve_direktur == "" and $item->is_approved_atasan == 1 and $item->status != 4)
                {
                    $status = 'Waiting Approval Direktur';
                }
                if($item->approve_direktur == 1)
                {
                    $status = 'Approved';
                }
            }
            if($item->status == 4)
            {
                $status = 'Canceled';
            }
            if($item->status == 3)
            {
                $status = 'Reject';
            }

            $params[$no]['STATUS']           = $status;
            $params[$no]['TGL SUBMIT']       = date('d F Y', strtotime($item->created_at));
            $params[$no]['TGL APPROVAL']     = date('d F Y', strtotime($item->approve_direktur_date));
            $params[$no]['SUPERVISOR']       = $item->direktur->name;
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

        return \Excel::create('Report-Cuti-Karyawan',  function($excel) use($params, $styleHeader){

              $excel->sheet('mysheet',  function($sheet) use($params){

                $sheet->fromArray($params);
                
              });

            $excel->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($styleHeader);

        })->download('xls');
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['karyawan'] = User::where('access_id', 2)->get();

        return view('administrator.cuti.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['karyawan'] = User::where('access_id', 2)->get();
        $params['data']     = CutiKaryawan::where('id', $id)->first();

        return view('administrator.cuti.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data               = CutiKaryawan::where('id', $id)->first();
        $data->user_id          = $request->user_id;
        $data->jenis_cuti       = $request->jenis_cuti;
        $data->tanggal_cuti_start= $request->tanggal_cuti_start;
        $data->tanggal_cuti_end = $request->tanggal_cuti_end;
        $data->keperluan        = $request->keperluan;
        $data->backup_user_id   = $request->backup_user_id;
        $data->status           = 1; 
        $data->save();

        return redirect()->route('administrator.cuti.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [batal description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function batal(Request $request)
    {   
        $data       = CutiKaryawan::where('id', $request->id)->first();
        $data->status = 4;
        $data->note_pembatalan = $request->note;
        $data->save(); 

        return redirect()->route('administrator.cuti.index')->with('message-success', 'Cuti Berhasil dibatalkan');
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $data = CutiKaryawan::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.cuti.index')->with('message-sucess', 'Data berhasi di hapus');
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

        return redirect()->route('administrator.cuti.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new CutiKaryawan();
        $data->user_id          = $request->user_id;
        $data->jenis_cuti       = $request->jenis_cuti;
        $data->tanggal_cuti_start= $request->tanggal_cuti_start;
        $data->tanggal_cuti_end = $request->tanggal_cuti_end;
        $data->keperluan        = $request->keperluan;
        $data->backup_user_id   = $request->backup_user_id;
        $data->status           = 1; 
        $data->save();

        return redirect()->route('administrator.cuti.index')->with('message-success', 'Data berhasil disimpan !');
    }

    /**
     * [proses description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function proses($id)
    {   
        $params['data'] = \App\CutiKaryawan::where('id', $id)->first();

        return view('administrator.cuti.proses')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitProses(Request $request)
    {
        $status = new \App\StatusApproval;
        $status->approval_user_id       = \Auth::user()->id;
        $status->jenis_form             = 'cuti';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->noted                  = $request->noted;
        $status->save();    

        $cuti = \App\CutiKaryawan::where('id', $request->id)->first();
        $cuti->approve_direktur         = $request->status;
        $cuti->approve_direktur_noted   = $request->noted;
        $cuti->approve_direktur_date    = date('Y-m-d H:i:s');
        
        if($request->status == 0)
        {
            $status = 3;

            // send email atasan
            $objDemo = new \stdClass();
            $objDemo->content = '<p>Dear '. $cuti->user->name .'</p><p> Pengajuan Cuti anda ditolak.</p>' ;    
            
        }else{
            $status = 2;
            // send email atasan
            $objDemo = new \stdClass();
            $objDemo->content = '<p>Dear '. $cuti->user->name .'</p><p> Pengajuan Cuti anda disetujui.</p>' ; 

            $user_cuti = \App\UserCuti::where('user_id', $cuti->user_id)->where('cuti_id', $cuti->jenis_cuti)->first();
            
            if(empty($user_cuti))
            {
                $temp = \App\Cuti::where('id', $cuti->jenis_cuti)->first();

                if($temp)
                { 
                    $user_cuti                  = new \App\UserCuti();
                    $user_cuti->kuota           = $temp->kuota;
                    $user_cuti->user_id         = $cuti->user_id;
                    $user_cuti->cuti_id         = $cuti->jenis_cuti;
                    $user_cuti->cuti_terpakai   = $cuti->total_cuti;
                    $user_cuti->sisa_cuti       = $temp->kuota - $cuti->total_cuti;
                    $user_cuti->save();
                }
            }
            else
            {
               // jika cuti maka kurangi kuota
                if(strpos($user_cuti->cuti->jenis_cuti, 'Cuti') !== false)
                {
                    // kurangi cuti tahunan user jika sudah di approved
                    $user_cuti->cuti_terpakai   = $user_cuti->cuti_terpakai + $cuti->total_cuti;
                    $user_cuti->sisa_cuti       = $user_cuti->kuota - $user_cuti->cuti_terpakai;
                    $user_cuti->save();
                }
            }
        }
        
        //\Mail::to($overtime->user->)->send(new \App\Mail\GeneralMail($objDemo));
       // \Mail::to('doni.enginer@gmail.com')->send(new \App\Mail\GeneralMail($objDemo));

        $cuti->status = $status;
        $cuti->is_approved_personalia = 1;
        $cuti->is_personalia_id = \Auth::user()->id;
        $cuti->save();

        return redirect()->route('administrator.cuti.index')->with('messages-success', 'Form Cuti Berhasil diproses !');
    }
}
