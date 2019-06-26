<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Department;
use App\Models\Provinsi;
use App\Models\UserEducation;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Division;
use App\Models\Section;
use App\Models\Payroll;
use App\Models\PayrollNet;
use App\Models\PayrollGross;
use App\Models\UserTemp;
use App\Models\Bank;
use App\Models\UserCuti;
use App\Models\UserEducationTemp;
use App\Models\UserFamilyTemp;
use App\Models\UserFamily;
use App\Models\EmporeOrganisasiDirektur;
use App\Models\EmporeOrganisasiManager;
use App\Models\EmporeOrganisasiStaff;
use App\Models\Cabang;
use App\Models\UserInventarisMobil;
use App\Models\UserInventaris;
use App\Models\StructureOrganizationCustom;
use App\Models\RequestPaySlip;
use App\Models\RequestPaySlipItem;
use App\Models\Cuti;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiPosition;
use PHPExcel_Worksheet_Drawing;

class KaryawanController extends Controller
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
        $params['structure'] = getStructureName();
        
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data = User::where('access_id', 2)->where('project_id', $user->project_id);
            $params['division'] = OrganisasiDivision::join('users','users.id','=','organisasi_division.user_created')->where('users.project_id', $user->project_id)->select('organisasi_division.*')->get();
            $params['position'] = OrganisasiPosition::join('users','users.id','=','organisasi_position.user_created')->where('users.project_id', $user->project_id)->select('organisasi_position.*')->get();
            $notDefinePos = User::where('access_id', 2)->whereNull('structure_organization_custom_id')->where('users.project_id', $user->project_id)->get();
        } else
        {
            $data = User::where('access_id', 2);
            $params['division'] = OrganisasiDivision::all();
            $params['position'] = OrganisasiPosition::all();
            $notDefinePos = User::where('access_id', 2)->whereNull('structure_organization_custom_id')->get();
        }

        $params['countPos'] = count($notDefinePos);
        if(isset($_GET["position"]) and $_GET["position"] ==1)
        {
             $data = $data->whereNull('structure_organization_custom_id');
        }
        if(request())
        {
            if(!empty(request()->name))
            {
                $data = $data->where(function($table){
                    $table->where('users.name', 'LIKE', '%'. request()->name .'%')
                            ->orWhere('users.nik', 'LIKE', '%'. request()->name .'%');
                });
            }

            if(!empty(request()->employee_status))
            {
                $data = $data->where('users.organisasi_status', request()->employee_status);
            }

            if((!empty(request()->division_id)) and (empty(request()->position_id))) 
            {   
                $data = $data->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_division_id',request()->division_id);
            }
            if((!empty(request()->position_id)) and (empty(request()->division_id)))
            {   
                $data = $data->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_position_id',request()->position_id);
            }
            if((!empty(request()->position_id)) and (!empty(request()->division_id)))
            {
                $data = $data->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_position_id',request()->position_id)->where('structure_organization_custom.organisasi_division_id',request()->division_id);
            }

            if(request()->action == 'download')
            {
                $this->downloadExcel($data->get());
            }
        }

        $params['data'] = $data->orderBy('id', 'DESC')->paginate(50);

        return view('administrator.karyawan.index')->with($params);
    }

    /**
     * [printPayslip description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function printPayslip($id)
    {
        $params['data'] = Payroll::where('user_id', $id)->first();

        $view =  view('administrator.karyawan.print-payslip')->with($params);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    public function printPayslipNet($id)
    {
        $params['data'] = PayrollNet::where('user_id', $id)->first();

        $view =  view('administrator.karyawan.print-payslipnet')->with($params);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    public function printPayslipGross($id)
    {
        $params['data'] = PayrollGross::where('user_id', $id)->first();

        $view =  view('administrator.karyawan.print-payslipgross')->with($params);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    /**
     * [uploadDokumentFile description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function uploadDokumentFile(Request $request)
    {
        $data   = User::where('id', $request->user_id)->first();

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-kontrak/'. $data->id);
            $file->move($destinationPath, $fileName);

            $data->generate_kontrak_file = $fileName;
        }

        $data->save();

        return redirect()->route('administrator.karyawan.index')->with('message-success', 'Document uploaded successfully');
    }

    /**
     * [gengerateFileKontrak description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function generateDocumentFile(Request $request)
    {
        // Update profile users
        $user               = User::where('id', $request->user_id)->first();
        $user->join_date    = $request->join_date;
        $user->end_date     = $request->end_date;
        $user->organisasi_status = $request->organisasi_status;
        $user->save();

        $params['data'] = User::where('id', $request->user_id)->first();

        if($request->organisasi_status == 'Contract' || $request->organisasi_status=="")
            $view = view('administrator.karyawan.dokumen-kontrak')->with($params);
        else
            $view = view('administrator.karyawan.dokumen-permanent')->with($params);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    /**
     * [printProfile description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function printProfile($id)
    {
        $params['data'] = User::where('id', $id)->first();

        $view = view('administrator.karyawan.print')->with($params);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    /**
     * [importAll description]
     * @return [type] [description]
     */
    public function importAll()
    {
        $temp = UserTemp::all();
        
        $userLogin = \Auth::user();

        if($userLogin->project_id != NULL)
        {
            $countUpdate=0;
            $countNew = 0;
            foreach($temp as $item)
            {
                $cekuserTemp = User::where('nik', $item->nik)->first();
                if($cekuserTemp) {
                    $countUpdate = $countUpdate+1;
                }else{
                    $countNew = $countNew+1;
                }
            }

            $module = \App\Models\CrmModule::where('project_id', $userLogin->project_id)->where('crm_product_id', 3)->first();
            $User = \App\User::where('project_id', $userLogin->project_id)->where('access_id',2)->count();

            if($countNew > (($module->limit_user)-$User)){
                UserTemp::truncate();
                UserEducationTemp::truncate();
                UserFamilyTemp::truncate();

                return redirect()->route('administrator.karyawan.index')->with('message-error', 'You can not import user anymore. You have reached the limit!');
            }
        }

        foreach($temp as $item)
        {
            $cekuser = User::where('nik', $item->nik)->first();

            if($cekuser) {
                $user  = $cekuser;
            }
            else
            {
                $user               = new User();
                $user->nik          = $item->nik;
                $user->password         = bcrypt('password'); // set default password
            }

            $user->name         = empty($item->name) ? $user->name : $item->name;
            $user->join_date    = empty($item->join_date) ? $user->join_date : $item->join_date;
            $user->jenis_kelamin= empty($item->gender) ? $user->jenis_kelamin : $item->gender;
            $user->employee_number= empty($item->employee_number) ? $user->employee_number : $item->employee_number;
            $user->absensi_number= empty($item->absensi_number) ? $user->absensi_number : $item->absensi_number;
            $user->marital_status   = empty($item->marital_status) ? $user->marital_status : $item->marital_status;
            $user->agama        = empty($item->agama) ? $user->agama : $item->agama;
            $user->bpjs_number= empty($item->bpjs_number) ? $user->bpjs_number : $item->bpjs_number;
            $user->jamsostek_number= empty($item->jamsostek_number) ? $user->jamsostek_number : $item->jamsostek_number;
            $user->tempat_lahir     = empty($item->place_of_birth) ? $user->tempat_lahir : $item->place_of_birth ;
            $user->tanggal_lahir    = empty($item->date_of_birth) ? $user->tanggal_lahir : $item->date_of_birth ;
            $user->id_address       = empty($item->id_address) ? $user->id_address : $item->id_address;
            $user->provinsi_id      = empty($item->provinsi_id) ? $user->provinsi_id : $item->provinsi_id;
            $user->kabupaten_id     = empty($item->kabupaten_id) ? $user->kabupaten_id : $item->kabupaten_id;
            $user->kecamatan_id     = empty($item->kecamatan_id) ? $user->kecamatan_id : $item->kecamatan_id;
            $user->kelurahan_id     = empty($item->kelurahan_id) ? $user->kelurahan_id : $item->kelurahan_id;
            $user->id_zip_code      = empty($item->id_zip_code) ? $user->id_zip_code : $item->id_zip_code;
            $user->current_address  = empty($item->current_address) ? $user->current_address : $item->current_address;  
            $user->provinsi_current  = empty($item->provinsi_current) ? $user->provinsi_current : $item->provinsi_current;
            $user->kabupaten_current  = empty($item->kabupaten_current) ? $user->kabupaten_current : $item->kabupaten_current;
            $user->kecamatan_current  = empty($item->kecamatan_current) ? $user->kecamatan_current : $item->kecamatan_current;
            $user->kelurahan_current  = empty($item->kelurahan_current) ? $user->kelurahan_current : $item->kelurahan_current;
            $user->current_zip_code  = empty($item->current_zip_code) ? $user->current_zip_code : $item->current_zip_code;

            $user->telepon          = empty($item->telp) ? $user->telepon : $item->telp;
            $user->mobile_1         = empty($item->mobile_1) ? $user->mobile_1 : $item->mobile_1;
            $user->mobile_2         = empty($item->mobile_2) ? $user->mobile_2 : $item->mobile_2;
            $user->access_id        = 2;
            #$user->status           = 1;
            $user->blood_type       = empty($item->blood_type) ? $user->blood_type : $item->blood_type;
            $user->ktp_number       = empty($item->ktp_number) ? $user->ktp_number : $item->ktp_number;
            $user->passport_number  = empty($item->passport_number) ? $user->passport_number : $item->passport_number;
            $user->kk_number        = empty($item->kk_number) ? $user->kk_number : $item->kk_number;
            $user->npwp_number      = empty($item->npwp_number) ? $user->npwp_number : $item->npwp_number;
            $user->ext              = empty($item->ext) ? $user->ext : $item->ext;

            if($item->email != "-") $user->email            = $item->email;

            // find bank
            $bank  = Bank::where('name', 'LIKE', '%'. $item->bank_1 .'%')->first();
            if($bank) $user->bank_id = $bank->id;
            $user->nama_rekening        = $item->bank_account_name_1;
            $user->nomor_rekening       = $item->bank_account_number;

            //$user->sisa_cuti            = $item->cuti_sisa_cuti;
            //$user->cuti_yang_terpakai   = $item->cuti_terpakai;
            //$user->length_of_service    = $item->cuti_length_of_service;
            //$user->cuti_status          = $item->cuti_status;
            //$user->cuti_2018            = $item->cuti_cuti_2018;
            $user->organisasi_status    = empty($item->organisasi_status) ? $user->organisasi_status : $item->organisasi_status ;
            /*
            $user->cabang_id            = empty($item->organisasi_branch) ? $user->cabang_id : $item->organisasi_branch;
            $user->branch_type          = strtoupper(empty($item->organisasi_ho_or_branch) ? $user->branch_type : $item->organisasi_ho_or_branch);
            $user->organisasi_status    = empty($item->organisasi_status) ? $user->organisasi_status : $item->organisasi_status ;

            if(!empty($item->empore_organisasi_direktur))
            {
                $user->empore_organisasi_direktur   = $item->empore_organisasi_direktur;
            }

            if(!empty($item->empore_organisasi_manager_id))
            {
                $user->empore_organisasi_manager_id = $item->empore_organisasi_manager_id;
            }

            if(!empty($item->empore_organisasi_staff_id))
            {
                $user->empore_organisasi_staff_id   = $item->empore_organisasi_staff_id;
            }
            */
            $projectId = \Auth::user()->project_id;
            if(!empty($projectId))
            {
                $user->project_id = $projectId;
            }
            $user->save();

            //add user cuti sesuai master cuti
            $masterCuti = Cuti::where('jenis_cuti','Leave')->get();
            foreach ($masterCuti as $key => $value) {
                # code...
                $userCuti = UserCuti::where('user_id',$user->id)->where('cuti_id',$value->id)->first();
                if(!$userCuti)
                {
                    $c = new UserCuti();
                    $c->user_id     = $user->id;
                    $c->cuti_id     = $value->id;
                    $c->kuota       = $value->kuota;
                    $c->sisa_cuti   = $value->kuota;
                    $c->save();
                }
            }
            /*
            if(!empty($item->cuti_cuti_2018) || !empty($item->cuti_terpakai) || !empty($item->cuti_sisa_cuti))
            {
                // cek exist cuti
                $c = UserCuti::where('user_id', $user->id)->where('cuti_id', 1)->first();
                if(!$c)
                {
                    // insert data cuti
                    $c = new UserCuti();
                    $c->user_id     = $user->id;
                }

                $c->cuti_id     = 1;
                if(!empty($item->cuti_status))
                {
                    $c->status      = $item->cuti_status;
                }

                if(!empty($item->cuti_cuti_2018))
                {
                    $c->kuota       = $item->cuti_cuti_2018;
                }

                if(!empty($item->cuti_terpakai))
                {
                    $c->cuti_terpakai= $item->cuti_terpakai;
                }

                if(!empty($item->cuti_sisa_cuti))
                {
                    $c->sisa_cuti   = $item->cuti_sisa_cuti;
                }

                if(!empty($item->cuti_length_of_service))
                {
                    $c->length_of_service= $item->cuti_length_of_service;
                }

                $c->save();
            }
            */


            // EDUCATION
            foreach(UserEducationTemp::where('user_temp_id', $item->id)->get() as $edu)
            {
                if($edu->pendidikan == "") continue;

                // cek pendidikan
                $education = UserEducation::where('user_id', $user->id)->where('pendidikan', $edu->pendidikan)->first();

                if(empty($education))
                {
                    $education                  = new UserEducation();
                    $education->user_id         = $user->id;
                }

                $education->pendidikan      = !empty($edu->pendidikan) ? $edu->pendidikan : $education->pendidikan;
                $education->tahun_awal      = !empty($edu->tahun_awal) ? $edu->tahun_awal : $education->tahun_awal;
                $education->tahun_akhir     = !empty($edu->tahun_akhir) ? $edu->tahun_akhir : $education->tahun_akhir;
                $education->fakultas        = !empty($edu->fakultas) ? $edu->fakultas : $education->fakultas;
                $education->jurusan         = !empty($edu->jurusan) ? $edu->jurusan : $education->jurusan;
                $education->nilai           = !empty($edu->nilai) ? $edu->nilai : $education->nilai;
                $education->kota            = !empty($edu->kota) ? $edu->kota : $education->kota;
                $education->certificate     = !empty($edu->certificate) ? $edu->certificate : $education->certificate;
                $education->note            = !empty($edu->note) ? $edu->note : $education->note;
                $education->save();
            }

            // FAMILY
            foreach(UserFamilyTemp::where('user_temp_id', $item->id)->get() as $fa)
            {
                if($fa->nama == "") continue;

                $family     = UserFamily::where('user_id', $user->id)->where('hubungan', $fa->hubungan)->first();

                if(empty($family))
                {
                    $family                 = new UserFamily();
                    $family->user_id        = $user->id;
                }

                $family->nama           = !empty($fa->nama) ? $fa->nama : $family->nama;
                $family->hubungan       = !empty($fa->hubungan) ? $fa->hubungan : $family->hubungan;
                $family->tempat_lahir   = !empty($fa->tempat_lahir) ? $fa->tempat_lahir : $family->tempat_lahir;
                $family->tanggal_lahir  = !empty($fa->tanggal_lahir) ? $fa->tanggal_lahir : $family->tanggal_lahir;
                $family->jenjang_pendidikan= !empty($fa->jenjang_pendidikan) ? $fa->jenjang_pendidikan : $family->jenjang_pendidikan;
                $family->pekerjaan      = !empty($fa->pekerjaan) ? $fa->pekerjaan : $family->pekerjaan;
                $family->save();
            }
        }

        // delete all table temp
        UserTemp::truncate();
        UserEducationTemp::truncate();
        UserFamilyTemp::truncate();

        return redirect()->route('administrator.karyawan.index')->with('message-success', 'Employee data successfully imported');
    }

    /**
     * [import description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function importData(Request $request)
    {
        if($request->hasFile('file'))
        {
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }

            // delete all table temp
            UserTemp::truncate();
            UserEducationTemp::truncate();
            UserFamilyTemp::truncate();

            foreach($rows as $key => $item)
            {
                if($key >= 3)
                {
                    $user = new UserTemp();

                    /**
                     * FIND USER
                     *
                     */
                    $find_user = User::where('nik', $item[2])->first();
                    if($find_user)
                    {
                        $user->user_id = $find_user->id;
                    }

                    $user->employee_number  = $item[0];
                    $user->absensi_number   = $item[1];
                    $user->nik              = $item[2];
                    $user->name             = strtoupper($item[3]);
                    if(!empty($item[4])){
                       $user->join_date        = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[4]);
                    }

                    if($item[5] == 'Male' || $item[5] == 'male' || $item[5] == 'Laki-laki' || $item[5]=='laki-laki' || strtoupper($item[5]) == 'PRIA')
                    {
                        $user->gender           = 'Male';
                    }

                    if($item[5] == 'Female' || $item[5] == 'female' || $item[5] == 'Perempuan' || $item[5] == 'perempuan' || strtoupper($item[5]) == 'WANITA')
                    {
                        $user->gender           = 'Female';
                    }

                    $agama = $item[7];

                    if(strtoupper($agama)=='ISLAM'){
                      $agama = 'Muslim';
                    }

                    $user->marital_status   = $item[6];
                    $user->agama            = $agama;
                    $user->ktp_number       = $item[8];
                    $user->passport_number  = $item[9];
                    $user->kk_number        = $item[10];
                    $user->npwp_number      = $item[11];
                    $user->bpjs_number      = $item[12];
                    $user->jamsostek_number = $item[13];
                    $user->place_of_birth   = strtoupper($item[14]);
                    
                    if(!empty($item[15])){
                       $user->date_of_birth    = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[15]);
                    }

                    $user->id_address       = strtoupper($item[16]);

                    //provinsi
                    $provinsi = Provinsi::where('nama','LIKE',$item[17])->first();
                    if(isset($provinsi)){
                        $user->provinsi_id          = $provinsi->id_prov;
                    }
                    //kabupaten
                    $kabupaten = Kabupaten::where('nama','LIKE',$item[18])->first();
                    if(isset($kabupaten)){
                        $user->kabupaten_id          = $kabupaten->id_kab;
                    }
                    //kecamatan
                    $kecamatan = Kecamatan::where('nama','LIKE',$item[19])->first();
                    if(isset($kecamatan)){
                        $user->kecamatan_id          = $kecamatan->id_kec;
                    }
                    //kelurahan
                    $kelurahan = Kelurahan::where('nama','LIKE',$item[20])->first();
                    if(isset($kelurahan)){
                        $user->kelurahan_id          = $kelurahan->id_kel;
                    }

                    $user->id_zip_code      = $item[21];
                    $user->current_address  = strtoupper($item[22]);

                    //provinsi
                    $provinsiCurrent = Provinsi::where('nama','LIKE',$item[23])->first();
                    if(isset($provinsiCurrent)){
                        $user->provinsi_current          = $provinsi->id_prov;
                    }
                    //kabupaten
                    $kabupatenCurrent = Kabupaten::where('nama','LIKE',$item[24])->first();
                    if(isset($kabupatenCurrent)){
                        $user->kabupaten_current          = $kabupaten->id_kab;
                    }
                    //kecamatan
                    $kecamatanCurrent = Kecamatan::where('nama','LIKE',$item[25])->first();
                    if(isset($kecamatanCurrent)){
                        $user->kecamatan_current          = $kecamatan->id_kec;
                    }
                    //kelurahan
                    $kelurahanCurrent = Kelurahan::where('nama','LIKE',$item[26])->first();
                    if(isset($kelurahanCurrent)){
                        $user->kelurahan_current          = $kelurahan->id_kel;
                    }

                    $user->current_zip_code      = $item[27];

                    $user->telp             = $item[28];
                    $user->ext              = $item[29];
                    $user->mobile_1         = $item[30];
                    $user->mobile_2         = $item[31];
                    $user->email            = $item[32];
                    $user->blood_type       = $item[33];
                    $user->bank_1           = $item[34];
                    $user->bank_account_name_1= $item[35];
                    $user->bank_account_number= $item[36];

                    /*
                    if(!empty($item[37]))
                    {
                        $direktur = EmporeOrganisasiDirektur::where('name', 'LIKE', '%'. $item[37] .'%')->first();
                        if(!$direktur)
                        {
                            $direktur = new \EmporeOrganisasiDirektur();
                            $direktur->name =  $item[37];
                            $direktur->save();
                        }

                        $user->empore_organisasi_direktur = $direktur->id;

                        if(!empty($item[38]))
                        {
                            $manager = EmporeOrganisasiManager::where('name', 'LIKE', '%'. $item[38] .'%')->where('empore_organisasi_direktur_id', $direktur->id)->first();
                            if(!$manager)
                            {
                                $manager = new EmporeOrganisasiManager();
                                $manager->empore_organisasi_direktur_id = $direktur->id;
                                $manager->name =  $item[38];
                                $manager->save();
                            }

                            $user->empore_organisasi_manager_id = $manager->id;
                        }

                        if(!empty($item[39]))
                        {
                            $staff = EmporeOrganisasiStaff::where('name', 'LIKE', $item[39])->first();
                            if(!$staff)
                            {
                                $staff = new EmporeOrganisasiStaff();
                                $staff->name =  $item[39];
                                $staff->save();
                            }

                            $user->empore_organisasi_staff_id = $staff->id;
                        }
                    }

                    $cabang = Cabang::where('name', 'LIKE', '%'. strtoupper($item[40]) .'%')->first();
                    if($cabang)
                    {
                        $user->organisasi_branch    = $cabang->id;
                    }
                    else
                    {
                        $cabang = new \App\Cabang();
                        $cabang->name = $item[40];
                        $cabang->save();

                        $user->organisasi_branch    = $cabang->id;
                    }
                    */
                    //$user->organisasi_ho_or_branch= $item[41];
                    $user->organisasi_status    = $item[37];
                    //$user->cuti_length_of_service = $item[38];
                    //$user->cuti_cuti_2018       = $item[39];
                    //$user->cuti_terpakai        = $item[40];
                    //$user->cuti_sisa_cuti       = $item[41];
                    $user->save();

                     // SD
                    if(!empty($item[38])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "SD";
                        $education->tahun_awal      = $item[38];
                        $education->tahun_akhir     = $item[39];
                        $education->fakultas        = strtoupper($item[40]);
                        $education->kota            = strtoupper($item[41]); // CITY
                        $education->jurusan         = strtoupper($item[42]); // MAJOR
                        $education->nilai           = $item[43]; // GPA
                        $education->certificate     = $item[44];
                        $education->note            = strtoupper($item[45]);
                        $education->save();
                    }

                     // SMP
                    if(!empty($item[46])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "SMP";
                        $education->tahun_awal      = $item[46];
                        $education->tahun_akhir     = $item[47];
                        $education->fakultas        = strtoupper($item[48]);
                        $education->kota            = strtoupper($item[49]); // CITY
                        $education->jurusan         = strtoupper($item[50]); // MAJOR
                        $education->nilai           = $item[51]; // GPA
                        $education->certificate     = $item[52];
                        $education->note            = strtoupper($item[53]);
                        $education->save();
                    }

                    // SMA/SMK
                    if(!empty($item[54])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "SMA/SMK";
                        $education->tahun_awal      = $item[54];
                        $education->tahun_akhir     = $item[55];
                        $education->fakultas        = strtoupper($item[56]);
                        $education->kota            = strtoupper($item[57]); // CITY
                        $education->jurusan         = strtoupper($item[58]); // MAJOR
                        $education->nilai           = $item[59]; // GPA
                        $education->certificate     = $item[60];
                        $education->note            = strtoupper($item[61]);
                        $education->save();
                    }

                    // D1
                    if(!empty($item[62])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "D1";
                        $education->tahun_awal      = $item[62];
                        $education->tahun_akhir     = $item[63];
                        $education->fakultas        = strtoupper($item[64]);
                        $education->kota            = strtoupper($item[65]); // CITY
                        $education->jurusan         = strtoupper($item[66]); // MAJOR
                        $education->nilai           = $item[67]; // GPA
                        $education->certificate     = $item[68];
                        $education->note            = strtoupper($item[69]);
                        $education->save();
                    }

                    // D2
                    if(!empty($item[70])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "D2";
                        $education->tahun_awal      = $item[70];
                        $education->tahun_akhir     = $item[71];
                        $education->fakultas        = strtoupper($item[72]);
                        $education->kota            = strtoupper($item[73]); // CITY
                        $education->jurusan         = strtoupper($item[74]); // MAJOR
                        $education->nilai           = $item[75]; // GPA
                        $education->certificate     = $item[76];
                        $education->note            = strtoupper($item[77]);
                        $education->save();
                    }

                    // D3
                    if(!empty($item[78])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "D3";
                        $education->tahun_awal      = $item[78];
                        $education->tahun_akhir     = $item[79];
                        $education->fakultas        = strtoupper($item[80]);
                        $education->kota            = strtoupper($item[81]); // CITY
                        $education->jurusan         = strtoupper($item[82]); // MAJOR
                        $education->nilai           = $item[83]; // GPA
                        $education->certificate     = $item[84];
                        $education->note            = strtoupper($item[85]);
                        $education->save();
                    }

                    // S1
                    if(!empty($item[86])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "S1";
                        $education->tahun_awal      = $item[86];
                        $education->tahun_akhir     = $item[87];
                        $education->fakultas        = strtoupper($item[88]);
                        $education->kota            = strtoupper($item[89]); // CITY
                        $education->jurusan         = strtoupper($item[90]); // MAJOR
                        $education->nilai           = $item[91]; // GPA
                        $education->certificate     = $item[92];
                        $education->note            = strtoupper($item[93]);
                        $education->save();
                    }

                    // S2
                    if(!empty($item[94])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "S2";
                        $education->tahun_awal      = $item[94];
                        $education->tahun_akhir     = $item[95];
                        $education->fakultas        = strtoupper($item[96]);
                        $education->kota            = strtoupper($item[97]); // CITY
                        $education->jurusan         = strtoupper($item[98]); // MAJOR
                        $education->nilai           = $item[99]; // GPA
                        $education->certificate     = $item[100];
                        $education->note            = strtoupper($item[101]);
                        $education->save();
                    }

                    // S3
                    if(!empty($item[102])){
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "S3";
                        $education->tahun_awal      = $item[102];
                        $education->tahun_akhir     = $item[103];
                        $education->fakultas        = strtoupper($item[104]);
                        $education->kota            = strtoupper($item[105]); // CITY
                        $education->jurusan         = strtoupper($item[106]); // MAJOR
                        $education->nilai           = $item[107]; // GPA
                        $education->certificate     = $item[108];
                        $education->note            = strtoupper($item[109]);
                        $education->save();
                    }
                   
                   //AYAH
                    if(!empty($item[110]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Ayah Kandung";
                        $family->nama               = strtoupper($item[110]);
                        $family->gender             = ($item[111]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[112]);
                        if(!empty($item[113])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[113]);
                        }

                        $family->jenjang_pendidikan = strtoupper($item[114]);
                        $family->pekerjaan          = strtoupper($item[115]);
                        $family->save();
                    }

                    //IBU
                    if(!empty($item[116]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Ibu Kandung";
                        $family->nama               = strtoupper($item[116]);
                        $family->gender             = ($item[117]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[118]);
                        
                        if(!empty($item[119])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[119]);
                        }
                        $family->jenjang_pendidikan = strtoupper($item[120]);
                        $family->pekerjaan          = strtoupper($item[121]);
                        $family->save();
                    }

                    //ISTRI
                    if(!empty($item[122]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Istri";
                        $family->nama               = strtoupper($item[122]);
                        $family->gender             = ($item[123]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[124]);
                        
                         if(!empty($item[125])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[125]);
                        }
                        $family->jenjang_pendidikan = strtoupper($item[126]);
                        $family->pekerjaan          = strtoupper($item[127]);
                        $family->save();
                    }

                    //SUAMI
                    if(!empty($item[128]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Suami";
                        $family->nama               = strtoupper($item[128]);
                        $family->gender             = ($item[129]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[130]);
                        
                        if(!empty($item[131])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[131]);
                        }
                        $family->jenjang_pendidikan = strtoupper($item[132]);
                        $family->pekerjaan          = strtoupper($item[133]);
                        $family->save();
                    }

                    //Anak 1
                    if(!empty($item[134]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 1";
                        $family->nama               = strtoupper($item[134]);
                        $family->gender             = ($item[135]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[136]);
                        
                        if(!empty($item[137])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[137]);
                        }
                        $family->jenjang_pendidikan = strtoupper($item[138]);
                        $family->pekerjaan          = strtoupper($item[139]);
                        $family->save();
                    }

                    //Anak 2
                    if(!empty($item[140]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 2";
                        $family->nama               = strtoupper($item[140]);
                        $family->gender             = ($item[141]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[142]);
                        
                        if(!empty($item[143])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[143]);
                        }
                        $family->jenjang_pendidikan = strtoupper($item[144]);
                        $family->pekerjaan          = strtoupper($item[145]);
                        $family->save();
                    }

                     //Anak 3
                    if(!empty($item[146]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 3";
                        $family->nama               = strtoupper($item[146]);
                        $family->gender             = ($item[147]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[148]);
                        
                        if(!empty($item[149])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[149]);
                        }
                        $family->jenjang_pendidikan = strtoupper($item[150]);
                        $family->pekerjaan          = strtoupper($item[151]);
                        $family->save();
                    }


                    //Anak 4
                    if(!empty($item[152]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 4";
                        $family->nama               = strtoupper($item[152]);
                        $family->gender             = ($item[153]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[154]);
                        
                        if(!empty($item[155])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[155]);
                        }
                        $family->jenjang_pendidikan = strtoupper($item[156]);
                        $family->pekerjaan          = strtoupper($item[157]);
                        $family->save();
                    }

                    //Anak 5
                    if(!empty($item[158]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 5";
                        $family->nama               = strtoupper($item[158]);
                        $family->gender             = ($item[159]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[160]);
                        
                        if(!empty($item[161])){
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[161]);
                        }
                        $family->jenjang_pendidikan = strtoupper($item[162]);
                        $family->pekerjaan          = strtoupper($item[163]);
                        $family->save();
                    }   
                }
            }

            return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Data successfully imported');
        }
    }

    /**
     * [previewImport description]
     * @return [type] [description]
     */
    public function previewImport()
    {
        $params['data'] = UserTemp::all();

        return view('administrator.karyawan.preview-import')->with($params);
    }

    /**
     * [deleteDependent description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteDependent($id)
    {
        $data = UserFamily::where('id', $id)->first();
        $id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Dependent Data Successfully deleted !');
    }
    /**
     * [deleteInvetarisMobil description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteInvetarisMobil($id)
    {
        $data = UserInventarisMobil::where('id', $id)->first();
        $id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Invetaris Data Successfully deleted !');
    }

    /**
     * [deleteInvetaris description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteInvetaris($id)
    {
        $data = UserInventaris::where('id', $id)->first();
        $id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Invetaris Data Successfully deleted !');
    }

    /**
     * [deleteEducation description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteEducation($id)
    {
        $data = UserEducation::where('id', $id)->first();
        $id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Educatuin data was successfully deleted !');
    }

    /**
     * [deleteTemp description]
     * @return [type] [description]
     */
    public function deleteTemp($id)
    {
        $data = UserTemp::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Temporary Data was successfully deleted');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = User::where('id', $id)->first();
        $params['department']       = Department::where('division_id', $params['data']['division_id'])->get();
        $params['provinces']        = Provinsi::all();
        $params['dependent']        = UserFamily::where('user_id', $id)->first();
        $params['education']        = UserEducation::where('user_id', $id)->first();
        $params['kabupaten']        = Kabupaten::where('id_prov', $params['data']['provinsi_id'])->get();
        $params['kecamatan']        = Kecamatan::where('id_kab', $params['data']['kabupaten_id'])->get();
        $params['kelurahan']        = Kelurahan::where('id_kec', $params['data']['kecamatan_id'])->get();
        $params['division']         = Division::all();
        $params['section']          = Section::where('division_id', $params['data']['division_id'])->get();
        $params['payroll']          = Payroll::where('user_id', $id)->first();
        $params['list_manager']     = EmporeOrganisasiManager::where('empore_organisasi_direktur_id', $params['data']['empore_organisasi_direktur'])->get();
        $params['list_staff']       = EmporeOrganisasiStaff::where('empore_organisasi_manager_id', $params['data']['empore_organisasi_manager_id'])->get();
        $params['structure']    = getStructureName();

        return view('administrator.karyawan.edit')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        $params['department']   = Department::all();
        $params['provinces']    = Provinsi::all();
        $params['division']     = Division::all();
        $params['department']   = Department::all();
        $params['section']      = Section::all();
        $params['structure']    = getStructureName();

        return view('administrator.karyawan.create')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = User::where('id', $id)->first();

        if($request->password != $data->password)
        {
            if(!empty($request->password))
            {
                $this->validate($request,[
                    'confirmation'      => 'same:password',
                ]);

                $data->password             = bcrypt($request->password);
            }
        }

        $data->name         = strtoupper($request->name);
        $data->employee_number      = $request->employee_number;
        $data->absensi_number       = $request->absensi_number;
        $data->nik                  = $request->nik;
        $data->ext                  = $request->ext;
        $data->tempat_lahir         = $request->tempat_lahir;
        $data->tanggal_lahir        = $request->tanggal_lahir;
        $data->marital_status       = $request->marital_status;
        $data->jenis_kelamin        = $request->jenis_kelamin;
        $data->blood_type           = $request->blood_type;
        $data->email                = $request->email;
        $data->join_date            = $request->join_date;
        $data->organisasi_status    = $request->organisasi_status;
        $data->npwp_number          = $request->npwp_number;
        $data->bpjs_number          = $request->bpjs_number;
        $data->jamsostek_number     = $request->jamsostek_number;
        $data->ktp_number           = $request->ktp_number;
        $data->passport_number      = $request->passport_number;
        $data->kk_number            = $request->kk_number;
        $data->telepon              = $request->telepon;
        $data->mobile_1             = $request->mobile_1;
        $data->mobile_2             = $request->mobile_2;
        $data->agama                = $request->agama;
        $data->current_address      = $request->current_address;
        $data->id_address           = $request->id_address;
       
        $data->access_id            = 2;
        $data->branch_type          = $request->branch_type;
        $data->hak_cuti             = 12;
        $data->cuti_yang_terpakai   = 0;
        $data->cabang_id            =$request->cabang_id;
        $data->nama_rekening        = $request->nama_rekening;
        $data->nomor_rekening       = $request->nomor_rekening;
        $data->bank_id              = $request->bank_id;
        $data->ext                  = $request->ext;
        $data->is_pic_cabang        = isset($request->is_pic_cabang) ? $request->is_pic_cabang : 0;
        
        $data->empore_organisasi_direktur   = $request->empore_organisasi_direktur;
        $data->empore_organisasi_manager_id = $request->empore_organisasi_manager_id;
        $data->empore_organisasi_staff_id   = $request->empore_organisasi_staff_id;
        $data->structure_organization_custom_id = $request->structure_organization_custom_id;

        if ($request->hasFile('foto'))
        {
            $file = $request->file('foto');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/foto/');
            $file->move($destinationPath, $fileName);

            $data->foto = $fileName;
        }

        if ($request->hasFile('foto_ktp'))
        {
            $fileKtp = $request->file('foto_ktp');
            $fileNameKtp = md5($fileKtp->getClientOriginalName() . time()) . "." . $fileKtp->getClientOriginalExtension();

            $destinationPath = public_path('/storage/fotoktp/');
            $fileKtp->move($destinationPath, $fileNameKtp);

            $data->foto_ktp = $fileNameKtp;
        }

        $data->save();

        if(isset($request->dependent))
        {
            foreach($request->dependent['nama'] as $key => $item)
            {
                $dep = new UserFamily();
                $dep->user_id           = $data->id;
                $dep->nama          = $request->dependent['nama'][$key];
                $dep->hubungan      = $request->dependent['hubungan'][$key];
                $dep->tempat_lahir  = $request->dependent['tempat_lahir'][$key];
                $dep->tanggal_lahir = $request->dependent['tanggal_lahir'][$key];
                $dep->tanggal_meninggal = $request->dependent['tanggal_meninggal'][$key];
                $dep->jenjang_pendidikan = $request->dependent['jenjang_pendidikan'][$key];
                $dep->pekerjaan = $request->dependent['pekerjaan'][$key];
                $dep->tertanggung = $request->dependent['tertanggung'][$key];
                $dep->save();
            }
        }

        if(isset($request->inventaris_mobil))
        {
            foreach($request->inventaris_mobil['tipe_mobil'] as $k => $item)
            {
                $inventaris                 = new UserInventarisMobil();
                $inventaris->user_id        = $data->id;
                $inventaris->tipe_mobil     = $request->inventaris_mobil['tipe_mobil'][$k];
                $inventaris->tahun          = $request->inventaris_mobil['tahun'][$k];
                $inventaris->no_polisi      = $request->inventaris_mobil['no_polisi'][$k];
                $inventaris->status_mobil   = $request->inventaris_mobil['status_mobil'][$k];
                $inventaris->save();
            }
        }

        if(isset($request->education))
        {
            foreach($request->education['pendidikan'] as $key => $item)
            {
                $edu = new UserEducation();
                $edu->user_id = $data->id;
                $edu->pendidikan    = $request->education['pendidikan'][$key];
                $edu->tahun_awal    = $request->education['tahun_awal'][$key];
                $edu->tahun_akhir   = $request->education['tahun_akhir'][$key];
                $edu->fakultas      = $request->education['fakultas'][$key];
                $edu->jurusan       = $request->education['jurusan'][$key];
                $edu->nilai         = $request->education['nilai'][$key];
                $edu->kota          = $request->education['kota'][$key];
                $edu->save();
            }
        }

        if(isset($request->cuti))
        {
            // user Education
            foreach($request->cuti['cuti_id'] as $key => $item)
            {
                $c = new UserCuti();
                $c->user_id = $data->id;
                $c->cuti_id    = $request->cuti['cuti_id'][$key];
                $c->kuota    = $request->cuti['kuota'][$key];
                $c->cuti_terpakai    = $request->cuti['terpakai'][$key];
                $c->sisa_cuti    = $request->cuti['kuota'][$key] - $request->cuti['terpakai'][$key];
                $c->save();
            }
        }

        if(isset($request->inventaris_lainnya['jenis']))
        {
            foreach($request->inventaris_lainnya['jenis'] as $k => $i)
            {
                $i              = new UserInventaris();
                $i->user_id     = $data->id;
                $i->jenis       = $request->inventaris_lainnya['jenis'][$k];
                $i->description = $request->inventaris_lainnya['description'][$k];
                $i->save();
            }
        }

        return redirect()->route('administrator.karyawan.edit', $data->id)->with('message-success', 'Data saved successfully');
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data               = new User();

        if(checkUserLimit())
        {
            $this->validate($request,[
            'nik'               => 'required|unique:users',
            //'email'               => 'required|unique:users',
            //'confirmation'      => 'same:password',
            ]);

            $data->password             = bcrypt($request->password);
            $data->name                 = strtoupper($request->name);
            $data->employee_number      = $request->employee_number;
            $data->absensi_number       = $request->absensi_number;
            $data->nik                  = $request->nik;
            $data->ext                  = $request->ext;
            $data->tempat_lahir         = $request->tempat_lahir;
            $data->tanggal_lahir        = $request->tanggal_lahir;
            $data->marital_status       = $request->marital_status;
            $data->jenis_kelamin        = $request->jenis_kelamin;
            $data->blood_type           = $request->blood_type;
            $data->email                = $request->email;
            $data->join_date            = $request->join_date;
            $data->organisasi_status    = $request->organisasi_status;
            $data->npwp_number          = $request->npwp_number;
            $data->bpjs_number          = $request->bpjs_number;
            $data->jamsostek_number     = $request->jamsostek_number;
            $data->ktp_number           = $request->ktp_number;
            $data->passport_number      = $request->passport_number;
            $data->kk_number            = $request->kk_number;
            $data->telepon              = $request->telepon;
            $data->mobile_1             = $request->mobile_1;
            $data->mobile_2             = $request->mobile_2;
            $data->agama                = $request->agama;
            $data->current_address      = $request->current_address;
            $data->id_address           = $request->id_address;
            $data->access_id            = 2;
            //$data->branch_type          = $request->branch_type;
            //$data->hak_cuti             = 12;
            //$data->cuti_yang_terpakai   = 0;
            //$data->cabang_id            =$request->cabang_id;
            $data->nama_rekening        = $request->nama_rekening;
            $data->nomor_rekening       = $request->nomor_rekening;
            $data->bank_id              = $request->bank_id;
            $data->ext                  = $request->ext;
            //$data->is_pic_cabang        = isset($request->is_pic_cabang) ? $request->is_pic_cabang : 0;
            
            //$data->empore_organisasi_direktur   = $request->empore_organisasi_direktur;
            //$data->empore_organisasi_manager_id = $request->empore_organisasi_manager_id;
            //$data->empore_organisasi_staff_id   = $request->empore_organisasi_staff_id;
            $data->structure_organization_custom_id  = $request->structure_organization_custom_id;

            if (request()->hasFile('foto'))
            {
                $file = $request->file('foto');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

                $destinationPath = public_path('/storage/foto/');
                $file->move($destinationPath, $fileName);

                $data->foto = $fileName;
            }
            if (request()->hasFile('foto_ktp'))
            {
                $fileKtp = $request->file('foto_ktp');
                $fileNameKtp = md5($fileKtp->getClientOriginalName() . time()) . "." . $fileKtp->getClientOriginalExtension();

                $destinationPath = public_path('/storage/fotoktp/');
                $fileKtp->move($destinationPath, $fileNameKtp);

                $data->foto_ktp = $fileNameKtp;
            }

            $projectId = \Auth::user()->project_id;
            if(!empty($projectId))
            {
                $data->project_id = $projectId;
            }
            $data->save();

            // user Dependent
            if(isset($request->dependent))
            {
                foreach($request->dependent['nama'] as $key => $item)
                {
                    $dep = new UserFamily();
                    $dep->user_id           = $data->id;
                    $dep->nama          = $request->dependent['nama'][$key];
                    $dep->hubungan      = $request->dependent['hubungan'][$key];
                    $dep->tempat_lahir  = $request->dependent['tempat_lahir'][$key];
                    $dep->tanggal_lahir = $request->dependent['tanggal_lahir'][$key];
                    $dep->tanggal_meninggal = $request->dependent['tanggal_meninggal'][$key];
                    $dep->jenjang_pendidikan = $request->dependent['jenjang_pendidikan'][$key];
                    $dep->pekerjaan = $request->dependent['pekerjaan'][$key];
                    $dep->tertanggung = $request->dependent['tertanggung'][$key];
                    $dep->save();
                }
            }

            if(isset($request->inventaris_mobil))
            {
                foreach($request->inventaris_mobil['tipe_mobil'] as $k => $item)
                {
                    $inventaris                 = new UserInventarisMobil();
                    $inventaris->user_id        = $data->id;
                    $inventaris->tipe_mobil     = $request->inventaris_mobil['tipe_mobil'][$k];
                    $inventaris->tahun          = $request->inventaris_mobil['tahun'][$k];
                    $inventaris->no_polisi      = $request->inventaris_mobil['no_polisi'][$k];
                    $inventaris->status_mobil   = $request->inventaris_mobil['status_mobil'][$k];
                    $inventaris->save();
                }
            }
            if(isset($request->education))
            {
                // user Education
                foreach($request->education['pendidikan'] as $key => $item)
                {
                    $edu = new UserEducation();
                    $edu->user_id = $data->id;
                    $edu->pendidikan    = $request->education['pendidikan'][$key];
                    $edu->tahun_awal    = $request->education['tahun_awal'][$key];
                    $edu->tahun_akhir   = $request->education['tahun_akhir'][$key];
                    $edu->fakultas      = $request->education['fakultas'][$key];
                    $edu->jurusan       = $request->education['jurusan'][$key];
                    $edu->nilai         = $request->education['nilai'][$key];
                    $edu->kota          = $request->education['kota'][$key];
                    $edu->save();
                }
            }
            if(isset($request->cuti))
            {
                // user Cuti
                foreach($request->cuti['cuti_id'] as $key => $item)
                {
                    $c = new UserCuti();
                    $c->user_id = $data->id;
                    $c->cuti_id    = $request->cuti['cuti_id'][$key];
                    $c->kuota    = $request->cuti['kuota'][$key];
                    $c->save();
                }
            }else{
                $masterCuti = Cuti::where('jenis_cuti','Leave')->get();
                foreach ($masterCuti as $key => $value) {
                    # code...
                    $userCuti = UserCuti::where('user_id',$data->id)->where('cuti_id',$value->id)->first();
                    if(!$userCuti)
                    {
                        $c = new UserCuti();
                        $c->user_id     = $data->id;
                        $c->cuti_id     = $value->id;
                        $c->kuota      = $value->kuota;
                        $c->sisa_cuti   = $value->kuota;
                        $c->save();
                    }
                }
            }
            if(isset($request->inventaris_lainnya['jenis']))
            {
                foreach($request->inventaris_lainnya['jenis'] as $k => $i)
                {
                    $i              = new UserInventaris();
                    $i->user_id     = $data->id;
                    $i->jenis       = $request->inventaris_lainnya['jenis'][$key];
                    $i->description = $request->inventaris_lainnya['description'][$key];
                    $i->save();
                }
            }
            return redirect()->route('administrator.karyawan.index')->with('message-success', 'Data saved successfully !');
        } else{
            return redirect()->route('administrator.karyawan.index')->with('message-error', ' You can not add a user anymore. You have reached the limit!');
        }
    }
    /**
     * [deleteInvetaris description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteInventarisLainnya($id)
    {
        $data = UserInventaris::where('id', $id)->first();
        $id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Invetaris Data Successfully deleted!');
    }

    /**
     * [DeleteCuti description]
     * @param [type] $id [description]
     */
    public function DeleteCuti($id)
    {
        $data = UserCuti::where('id', $id)->first();
        $user_id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $user_id)->with('message-success', 'Leave data successfully deleted');
    }

    /**
     * [deleteOldUser description]
     * @return [type] [description]
     */
    public function deleteOldUser($id)
    {
        $data = User::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Old data was successfully deleted');
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = User::where('id', $id)->first();
        $data->delete();

        UserFamily::where('user_id', $id)->delete();

        UserEducation::where('user_id', $id)->delete();

        return redirect()->route('administrator.karyawan.index')->with('message-sucess', 'Data successfully deleted');
    }

    /**
     * [autologin description]
     * @return [type] [description]
     */
    public function autologin($id)
    {   
        \Auth::loginUsingId($id);
        \Session::put('is_login_administrator', true);
        
        return redirect()->route('karyawan.dashboard');
    }

    public function downloadExcel($data)
    {
        #$data       = User::where('access_id', 2)->orderBy('id', 'DESC')->get();
        $params = [];
        
        foreach($data as $k =>  $item)
        {
            
            $params[$k]['No']                   = $k+1;
            $params[$k]['Employee Number ']     = $item->employee_number;
            $params[$k]['Absensi Number']       = $item->absensi_number;
            $params[$k]['NIK']                  = $item->nik;
            $params[$k]['Name']                 = $item->name;
            $params[$k]['Join Date']            = $item->join_date;
            $params[$k]['Gender']               = $item->jenis_kelamin;
            $params[$k]['Maritial Status']      = $item->marital_status;
            $params[$k]['Religion']             = $item->agama;
            $params[$k]['KTP Number']           = $item->ktp_number;
            $params[$k]['Passport Number']      = $item->passport_number;
            $params[$k]['KK Number']            = $item->kk_number;
            $params[$k]['NPWP Number']          = $item->npwp_number;
            $params[$k]['No BPJS Kesehatan']    = $item->jamsostek_number;
            $params[$k]['No BPJS Ketenagakerjaan']  = $item->bpjs_number;
            $params[$k]['Place of Birth']       = $item->tempat_lahir;
            $params[$k]['Date of Birth']        = $item->tanggal_lahir;
            $params[$k]['ID Address']           = $item->id_address;
            //$params[$k]['ID City']              = isset($item->kota->nama) ? $item->kota->nama : '';
            //$params[$k]['ID Zip Code']          = $item->id_zip_code;
            $params[$k]['Current Address']      = $item->current_address;
            $params[$k]['Telp']                 = $item->telepon;
            $params[$k]['Ext']                  = $item->ext;
            $params[$k]['Mobile 1']             = $item->mobile_1;
            $params[$k]['Mobile 2']             = $item->mobile_2;
            $params[$k]['Email']                = $item->email;
            $params[$k]['Blood Type']           = $item->blood_type;

            if(!empty($item->bank_id)) {
                $params[$k]['Bank ']                = $item->bank->name;
            }elseif (empty($item->bank_id)) {
                $params[$k]['Bank ']                ="";
            }

            $params[$k]['Bank Account Name']    = $item->nama_rekening;
            $params[$k]['Bank Account Number']  = $item->nomor_rekening;

            $pos ="";

            /*if(!empty($item->empore_organisasi_staff_id)){
                $pos= "Staff";
            }elseif (empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_supervisor_id)) {
                $pos= "Supervisor";
            }elseif (empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_supervisor_id) and !empty($item->empore_organisasi_manager_id)) {
                 $pos= "Manager";
            }elseif (empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_supervisor_id) and empty($item->empore_organisasi_manager_id) and !empty($item->empore_organisasi_direktur)) {
                 $pos= "Direkitur";
            }
            */
            if(!empty($item->empore_organisasi_staff_id)){
                $pos= "Staff";
            }elseif (empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_manager_id)) {
                 $pos= "Manager";
            }elseif (empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_manager_id) and !empty($item->empore_organisasi_direktur)) {
                $pos= "Direktur";
            }

            $params[$k]['Position']             = $pos;

            $jobrule ="";
            /*
            if(!empty($item->empore_organisasi_staff_id)){
                $jobrule = isset($item->empore_staff->name) ? $item->empore_staff->name : '';

            }elseif (empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_supervisor_id)) {
                $jobrule = isset($item->empore_supervisor->name) ? $item->empore_supervisor->name : ''; 
            }elseif (empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_supervisor_id) and !empty($tem->empore_organisasi_manager_id)) {
                $jobrule = isset($item->empore_manager->name) ? $item->empore_manager->name : '';
            }
            */

            if(!empty($item->empore_organisasi_staff_id)){
                $jobrule = isset($item->empore_staff->name) ? $item->empore_staff->name : '';
            }elseif (empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_manager_id)) {
                $jobrule = isset($item->empore_manager->name) ? $item->empore_manager->name : '';
            }
                                    
            $params[$k]['Job Rule']             = $jobrule;
            
            $params[$k]['status']               = $item->organisasi_status;

            $sd = UserEducation::where('user_id', $item->id)->where('pendidikan','SD')->first();

            if(!empty($sd)) {
                    $params[$k]['Education SD']           = $sd ->pendidikan;
                    $params[$k]['Start Year SD']          = $sd->tahun_awal;
                    $params[$k]['End Year SD']            = $sd->tahun_akhir;
                    $params[$k]['Institution SD']         = $sd->fakultas;
                    $params[$k]['City Education SD']      = $sd->kota;
                    $params[$k]['Major SD']               = $sd->jurusan;
                    $params[$k]['GPA SD']                 = $sd->nilai;
            } else
            {
                    $params[$k]['Education SD']           = "-";
                    $params[$k]['Start Year SD']          = "-";
                    $params[$k]['End Year SD']            = "-";
                    $params[$k]['Institution SD']         = "-";
                    $params[$k]['City Education SD']      = "-";
                    $params[$k]['Major SD']               = "-";
                    $params[$k]['GPA SD']                 = "-";
            }
            $smp = UserEducation::where('user_id', $item->id)->where('pendidikan','SMP')->first();
            if(!empty($smp)) {
                    $params[$k]['Education SMP']           = $smp ->pendidikan;
                    $params[$k]['Start Year SMP']          = $smp->tahun_awal;
                    $params[$k]['End Year SMP']            = $smp->tahun_akhir;
                    $params[$k]['Institution SMP']         = $smp->fakultas;
                    $params[$k]['City Education SMP']      = $smp->kota;
                    $params[$k]['Major SMP']               = $smp->jurusan;
                    $params[$k]['GPA SMP']                 = $smp->nilai;
            } else
            {
                    $params[$k]['Education SMP']           = "-";
                    $params[$k]['Start Year SMP']          = "-";
                    $params[$k]['End Year SMP']            = "-";
                    $params[$k]['Institution SMP']         = "-";
                    $params[$k]['City Education SMP']      = "-";
                    $params[$k]['Major SMP']               = "-";
                    $params[$k]['GPA SMP']                 = "-";
            }

            $sma = UserEducation::where('user_id', $item->id)->where('pendidikan','SMA/SMK')->first();
            if(!empty($sma)) {
                    $params[$k]['Education SMA/SMK']           = $sma ->pendidikan;
                    $params[$k]['Start Year SMA/SMK']          = $sma->tahun_awal;
                    $params[$k]['End Year SMA/SMK']            = $sma->tahun_akhir;
                    $params[$k]['Institution SMA/SMK']         = $sma->fakultas;
                    $params[$k]['City Education SMA/SMK']      = $sma->kota;
                    $params[$k]['Major SMA/SMK']               = $sma->jurusan;
                    $params[$k]['GPA SMA/SMK']                 = $sma->nilai;
            } else
            {
                    $params[$k]['Education SMA/SMK']           = "-";
                    $params[$k]['Start Year SMA/SMK']          = "-";
                    $params[$k]['End Year SMA/SMK']            = "-";
                    $params[$k]['Institution SMA/SMK']         = "-";
                    $params[$k]['City Education SMA/SMK']      = "-";
                    $params[$k]['Major SMA/SMK']               = "-";
                    $params[$k]['GPA SMA/SMK']                 = "-";
            }

            $diploma = UserEducation::where('user_id', $item->id)->where('pendidikan','D1')->first();
            if(!empty($diploma)) {
                    $params[$k]['Education D1']           = $diploma ->pendidikan;
                    $params[$k]['Start Year D1']          = $diploma->tahun_awal;
                    $params[$k]['End Year D1']            = $diploma->tahun_akhir;
                    $params[$k]['Institution D1']         = $diploma->fakultas;
                    $params[$k]['City Education D1']      = $diploma->kota;
                    $params[$k]['Major D1']               = $diploma->jurusan;
                    $params[$k]['GPA D1']                 = $diploma->nilai;
            } else
            {
                    $params[$k]['Education D1']           = "-";
                    $params[$k]['Start Year D1']          = "-";
                    $params[$k]['End Year D1']            = "-";
                    $params[$k]['Institution D1']         = "-";
                    $params[$k]['City Education D1']      = "-";
                    $params[$k]['Major D1']               = "-";
                    $params[$k]['GPA D1']                 = "-";
            }

            $diploma2 = UserEducation::where('user_id', $item->id)->where('pendidikan','D2')->first();
            if(!empty($diploma2)) {
                    $params[$k]['Education D2']           = $diploma2 ->pendidikan;
                    $params[$k]['Start Year D2']          = $diploma2->tahun_awal;
                    $params[$k]['End Year D2']            = $diploma2->tahun_akhir;
                    $params[$k]['Institution D2']         = $diploma2->fakultas;
                    $params[$k]['City Education D2']      = $diploma2->kota;
                    $params[$k]['Major D2']               = $diploma2->jurusan;
                    $params[$k]['GPA D2']                 = $diploma2->nilai;
            } else
            {
                    $params[$k]['Education D2']           = "-";
                    $params[$k]['Start Year D2']          = "-";
                    $params[$k]['End Year D2']            = "-";
                    $params[$k]['Institution D2']         = "-";
                    $params[$k]['City Education D2']      = "-";
                    $params[$k]['Major D2']               = "-";
                    $params[$k]['GPA D2']                 = "-";
            }

            $diploma3 = UserEducation::where('user_id', $item->id)->where('pendidikan','D3')->first();
            if(!empty($diploma3)) {
                    $params[$k]['Education D3']           = $diploma3 ->pendidikan;
                    $params[$k]['Start Year D3']          = $diploma3->tahun_awal;
                    $params[$k]['End Year D3']            = $diploma3->tahun_akhir;
                    $params[$k]['Institution D3']         = $diploma3->fakultas;
                    $params[$k]['City Education D3']      = $diploma3->kota;
                    $params[$k]['Major D3']               = $diploma3->jurusan;
                    $params[$k]['GPA D3']                 = $diploma3->nilai;
            } else
            {
                    $params[$k]['Education D3']           = "-";
                    $params[$k]['Start Year D3']          = "-";
                    $params[$k]['End Year D3']            = "-";
                    $params[$k]['Institution D3']         = "-";
                    $params[$k]['City Education D3']      = "-";
                    $params[$k]['Major D3']               = "-";
                    $params[$k]['GPA D3']                 = "-";
            }

            $s1 = UserEducation::where('user_id', $item->id)->where('pendidikan','S1')->first();
            if(!empty($s1)) {
                    $params[$k]['Education S1']           = $s1 ->pendidikan;
                    $params[$k]['Start Year S1']          = $s1->tahun_awal;
                    $params[$k]['End Year S1']            = $s1->tahun_akhir;
                    $params[$k]['Institution S1']         = $s1->fakultas;
                    $params[$k]['City Education S1']      = $s1->kota;
                    $params[$k]['Major S1']               = $s1->jurusan;
                    $params[$k]['GPA S1']                 = $s1->nilai;
            } else
            {
                    $params[$k]['Education S1']           = "-";
                    $params[$k]['Start Year S1']          = "-";
                    $params[$k]['End Year S1']            = "-";
                    $params[$k]['Institution S1']         = "-";
                    $params[$k]['City Education S1']      = "-";
                    $params[$k]['Major S1']               = "-";
                    $params[$k]['GPA S1']                 = "-";
            }

            $s2 = UserEducation::where('user_id', $item->id)->where('pendidikan','S2')->first();
            if(!empty($s2)) {
                    $params[$k]['Education S2']           = $s2 ->pendidikan;
                    $params[$k]['Start Year S2']          = $s2->tahun_awal;
                    $params[$k]['End Year S2']            = $s2->tahun_akhir;
                    $params[$k]['Institution S2']         = $s2->fakultas;
                    $params[$k]['City Education S2']      = $s2->kota;
                    $params[$k]['Major S2']               = $s2->jurusan;
                    $params[$k]['GPA S2']                 = $s2->nilai;
            } else
            {
                    $params[$k]['Education S2']           = "-";
                    $params[$k]['Start Year S2']          = "-";
                    $params[$k]['End Year S2']            = "-";
                    $params[$k]['Institution S2']         = "-";
                    $params[$k]['City Education S2']      = "-";
                    $params[$k]['Major S2']               = "-";
                    $params[$k]['GPA S2']                 = "-";
            }

            $s3 = UserEducation::where('user_id', $item->id)->where('pendidikan','S3')->first();
            if(!empty($s3)) {
                    $params[$k]['Education S3']           = $s3 ->pendidikan;
                    $params[$k]['Start Year S3']          = $s3->tahun_awal;
                    $params[$k]['End Year S3']            = $s3->tahun_akhir;
                    $params[$k]['Institution S3']         = $s3->fakultas;
                    $params[$k]['City Education S3']      = $s3->kota;
                    $params[$k]['Major S3']               = $s3->jurusan;
                    $params[$k]['GPA S3']                 = $s3->nilai;
            } else
            {
                    $params[$k]['Education S3']           = "-";
                    $params[$k]['Start Year S3']          = "-";
                    $params[$k]['End Year S3']            = "-";
                    $params[$k]['Institution S3']         = "-";
                    $params[$k]['City Education S3']      = "-";
                    $params[$k]['Major S3']               = "-";
                    $params[$k]['GPA S3']                 = "-";
            }

            $ayah = UserFamily::where('user_id', $item->id)->where('hubungan','Ayah Kandung')->first();
            if(!empty($ayah)) {
                    $params[$k]['Relative Name Ayah Kandung']           = $ayah ->nama;
                    $params[$k]['Place of birth Ayah Kandung']          = $ayah->tempat_lahir;
                    $params[$k]['Date of birth Ayah Kandung']           = $ayah->tanggal_lahir;
                    $params[$k]['Education level Ayah Kandung']         = $ayah->jenjang_pendidikan;
                    $params[$k]['Occupation Ayah Kandung']              = $ayah->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Ayah Kandung']           = "-";
                    $params[$k]['Place of birth Ayah Kandung']          = "-";
                    $params[$k]['Date of birth Ayah Kandung']           = "-";
                    $params[$k]['Education level Ayah Kandung']         = "-";
                    $params[$k]['Occupation Ayah Kandung']              = "-";
            }
            $ibu = UserFamily::where('user_id', $item->id)->where('hubungan','Ibu Kandung')->first();
            if(!empty($ibu)) {
                    $params[$k]['Relative Name Ibu Kandung']           = $ibu ->nama;
                    $params[$k]['Place of birth Ibu Kandung']          = $ibu->tempat_lahir;
                    $params[$k]['Date of birth Ibu Kandung']           = $ibu->tanggal_lahir;
                    $params[$k]['Education level Ibu Kandung']         = $ibu->jenjang_pendidikan;
                    $params[$k]['Occupation Ibu Kandung']              = $ibu->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Ibu Kandung']           = "-";
                    $params[$k]['Place of birth Ibu Kandung']          = "-";
                    $params[$k]['Date of birth Ibu Kandung']           = "-";
                    $params[$k]['Education level Ibu Kandung']         = "-";
                    $params[$k]['Occupation Ibu Kandung']              = "-";
            }
            
            $istri = UserFamily::where('user_id', $item->id)->where('hubungan','Istri')->first();
            if(!empty($istri)) {
                    $params[$k]['Relative Name Istri']           = $istri ->nama;
                    $params[$k]['Place of birth Istri']          = $istri->tempat_lahir;
                    $params[$k]['Date of birth Istri']           = $istri->tanggal_lahir;
                    $params[$k]['Education level Istri']         = $istri->jenjang_pendidikan;
                    $params[$k]['Occupation Istri']              = $istri->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Istri']           = "-";
                    $params[$k]['Place of birth Istri']          = "-";
                    $params[$k]['Date of birth Istri']           = "-";
                    $params[$k]['Education level Istri']         = "-";
                    $params[$k]['Occupation Istri']              = "-";
            }

            $suami = UserFamily::where('user_id', $item->id)->where('hubungan','Suami')->first();
            if(!empty($suami)) {
                    $params[$k]['Relative Name Suami']           = $suami ->nama;
                    $params[$k]['Place of birth Suami']          = $suami->tempat_lahir;
                    $params[$k]['Date of birth Suami']           = $suami->tanggal_lahir;
                    $params[$k]['Education level Suami']         = $suami->jenjang_pendidikan;
                    $params[$k]['Occupation Suami']              = $suami->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Suami']           = "-";
                    $params[$k]['Place of birth Suami']          = "-";
                    $params[$k]['Date of birth Suami']           = "-";
                    $params[$k]['Education level Suami']         = "-";
                    $params[$k]['Occupation Suami']              = "-";
            }

            $anak1 = UserFamily::where('user_id', $item->id)->where('hubungan','Anak 1')->first();
            if(!empty($anak1)) {
                    $params[$k]['Relative Name Anak 1']           = $anak1 ->nama;
                    $params[$k]['Place of birth Anak 1']          = $anak1->tempat_lahir;
                    $params[$k]['Date of birth Anak 1']           = $anak1->tanggal_lahir;
                    $params[$k]['Education level Anak 1']         = $anak1->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 1']              = $anak1->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 1']           = "-";
                    $params[$k]['Place of birth Anak 1']          = "-";
                    $params[$k]['Date of birth Anak 1']           = "-";
                    $params[$k]['Education level Anak 1']         = "-";
                    $params[$k]['Occupation Anak 1']              = "-";
            }

            $anak2 = UserFamily::where('user_id', $item->id)->where('hubungan','Anak 2')->first();
            if(!empty($anak2)) {
                    $params[$k]['Relative Name Anak 2']           = $anak2 ->nama;
                    $params[$k]['Place of birth Anak 2']          = $anak2->tempat_lahir;
                    $params[$k]['Date of birth Anak 2']           = $anak2->tanggal_lahir;
                    $params[$k]['Education level Anak 2']         = $anak2->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 2']              = $anak2->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 2']           = "-";
                    $params[$k]['Place of birth Anak 2']          = "-";
                    $params[$k]['Date of birth Anak 2']           = "-";
                    $params[$k]['Education level Anak 2']         = "-";
                    $params[$k]['Occupation Anak 2']              = "-";
            }

            $anak3 = UserFamily::where('user_id', $item->id)->where('hubungan','Anak 3')->first();
            if(!empty($anak3)) {
                    $params[$k]['Relative Name Anak 3']           = $anak3 ->nama;
                    $params[$k]['Place of birth Anak 3']          = $anak3->tempat_lahir;
                    $params[$k]['Date of birth Anak 3']           = $anak3->tanggal_lahir;
                    $params[$k]['Education level Anak 3']         = $anak3->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 3']              = $anak3->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 3']           = "-";
                    $params[$k]['Place of birth Anak 3']          = "-";
                    $params[$k]['Date of birth Anak 3']           = "-";
                    $params[$k]['Education level Anak 3']         = "-";
                    $params[$k]['Occupation Anak 3']              = "-";
            }

            $anak4 = UserFamily::where('user_id', $item->id)->where('hubungan','Anak 4')->first();
            if(!empty($anak4)) {
                    $params[$k]['Relative Name Anak 4']           = $anak4 ->nama;
                    $params[$k]['Place of birth Anak 4']          = $anak4->tempat_lahir;
                    $params[$k]['Date of birth Anak 4']           = $anak4->tanggal_lahir;
                    $params[$k]['Education level Anak 4']         = $anak4->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 4']              = $anak4->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 4']           = "-";
                    $params[$k]['Place of birth Anak 4']          = "-";
                    $params[$k]['Date of birth Anak 4']           = "-";
                    $params[$k]['Education level Anak 4']         = "-";
                    $params[$k]['Occupation Anak 4']              = "-";
            }

            $anak5 = UserFamily::where('user_id', $item->id)->where('hubungan','Anak 5')->first();
            if(!empty($anak5)) {
                    $params[$k]['Relative Name Anak 5']           = $anak5 ->nama;
                    $params[$k]['Place of birth Anak 5']          = $anak5->tempat_lahir;
                    $params[$k]['Date of birth Anak 5']           = $anak5->tanggal_lahir;
                    $params[$k]['Education level Anak 5']         = $anak5->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 5']              = $anak5->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 5']           = "-";
                    $params[$k]['Place of birth Anak 5']          = "-";
                    $params[$k]['Date of birth Anak 5']           = "-";
                    $params[$k]['Education level Anak 5']         = "-";
                    $params[$k]['Occupation Anak 5']              = "-";
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

        return \Excel::create('Report-Employee-'.date('d-m-Y'),  function($excel) use($params, $styleHeader){
              $excel->sheet('Karyawan',  function($sheet) use($params){
                
                // $sheet->cell('B1', function($cell) {
                //         $cell->setValue(get_setting('title'));
                //         $cell->setFontSize(16);
                //         $cell->setAlignment('center');
                //     })->mergeCells('B1:Q1');

                // $sheet->cell('B2', function($cell) {
                //         $cell->setValue(get_setting('description'))
                //         ->setAlignment('center');
                //     })->mergeCells('B2:Q2');

                // $sheet->setSize(array(
                //     'A1' => array(
                //         'height'    => 20
                //     ),
                //     'A2' => array(
                //         'height'    => 30
                //     ),
                //     'A5' => [
                //         'width' => 5,
                //         'height' => 25
                //     ]
                // ));
                
                $sheet->cell('A1:EJ1', function($cell) {
                        $cell->setFontSize(12);
                        $cell->setBackground('#EEEEEE');
                        $cell->setFontWeight('bold');
                        $cell->setBorder('solid');
                    });


                $borderArray = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THICK,
                            'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );

                $sheet->fromArray($params, null, 'A1', true);

              });

            $excel->getActiveSheet()->getStyle('A5:EI1')->applyFromArray($styleHeader);

        })->download('xls');
    }
}