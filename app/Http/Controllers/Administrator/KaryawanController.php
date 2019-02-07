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
        $params['data'] = User::where('access_id', 2)->orderBy('id', 'DESC')->paginate(50);

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

        return redirect()->route('administrator.karyawan.index')->with('message-success', 'Dokumen berhasil di upload');
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
            $user->marital_status   = empty($item->marital_status) ? $user->marital_status : $item->marital_status;
            $user->agama        = empty($item->agama) ? $user->agama : $item->agama;
            $user->bpjs_number= empty($item->no_bpjs_kesehatan) ? $user->bpjs_number : $item->no_bpjs_kesehatan;
            $user->tempat_lahir     = empty($item->place_of_birth) ? $user->tempat_lahir : $item->place_of_birth ;
            $user->tanggal_lahir    = empty($item->date_of_birth) ? $user->tanggal_lahir : $item->date_of_birth ;
            $user->id_address       = empty($item->id_address) ? $user->id_address : $item->id_address;
            $user->id_city          = empty($item->id_city) ? $user->id_city : $item->id_city;
            $user->id_zip_code      = empty($item->id_zip_code) ? $user->id_zip_code : $item->id_zip_code;
            $user->current_address  = empty($item->current_address) ? $user->current_address : $item->current_address;
            $user->telepon          = empty($item->telp) ? $user->telepon : $item->telp;
            $user->mobile_1         = empty($item->mobile_1) ? $user->mobile_1 : $item->mobile_1;
            $user->mobile_2         = empty($item->mobile_2) ? $user->mobile_2 : $item->mobile_2;
            $user->access_id        = 2;
            $user->status           = 1;
            $user->blood_type       = empty($item->blood_type) ? $user->blood_type : $item->blood_type;
            $user->ktp_number       = empty($item->ktp_number) ? $user->ktp_number : $item->ktp_number;
            $user->passport_number  = empty($item->passport_number) ? $user->passport_number : $item->passport_number;
            $user->kk_number        = empty($item->kk_number) ? $user->kk_number : $item->kk_number;
            $user->npwp_number      = empty($item->npwp_number) ? $user->npwp_number : $item->npwp_number;
            $user->ext              = empty($item->ext) ? $user->ext : $item->ext;
            $user->ldap             = empty($item->ldap) ? $user->ldap : $item->ldap;

            if($item->email != "-") $user->email            = $item->email;

            // find bank
            $bank  = Bank::where('name', 'LIKE', '%'. $item->bank_1 .'%')->first();
            if($bank) $user->bank_id = $bank->id;
            $user->nama_rekening        = $item->bank_account_name_1;
            $user->nomor_rekening       = $item->bank_account_number;

            $user->sisa_cuti            = $item->cuti_sisa_cuti;
            $user->cuti_yang_terpakai   = $item->cuti_terpakai;
            $user->length_of_service    = $item->cuti_length_of_service;
            $user->cuti_status          = $item->cuti_status;
            $user->cuti_2018            = $item->cuti_cuti_2018;

            // get division
            $user->division_id      = $item->organisasi_division;
            $user->department_id    = $item->organisasi_department;
            $user->section_id       = $item->organisasi_unit;
            $user->organisasi_job_role       = $item->organisasi_position_sub;
            $user->organisasi_position       = $item->organisasi_position;

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

            $user->save();

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

        return redirect()->route('administrator.karyawan.index')->with('message-success', 'Data Karyawan berhasil di import');
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
                    $user->join_date        = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[4]);

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
                    $user->no_bpjs_kesehatan= $item[12];
                    $user->place_of_birth   = strtoupper($item[13]);
                    $user->date_of_birth    = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[14]);
                    $user->id_address       = strtoupper($item[15]);

                    // find city
                    $kota = Kabupaten::where('nama', 'LIKE', $item[16])->first();

                    if(isset($kota))
                        $user->id_city          = $kota->id_kab;
                    else
                        $user->id_city          = $item[16];

                    $user->id_zip_code      = $item[17];
                    $user->current_address  = strtoupper($item[18]);
                    $user->telp             = $item[19];
                    $user->ext              = $item[20];
                    $user->ldap              = $item[21];
                    $user->mobile_1         = $item[22];
                    $user->mobile_2         = $item[23];
                    $user->email            = $item[24];
                    $user->blood_type       = $item[25];
                    $user->bank_1           = $item[26];
                    $user->bank_account_name_1= $item[27];
                    $user->bank_account_number= $item[28];

                    if(!empty($item[29]))
                    {
                        $direktur = EmporeOrganisasiDirektur::where('name', 'LIKE', '%'. $item[29] .'%')->first();
                        if(!$direktur)
                        {
                            $direktur = new \EmporeOrganisasiDirektur();
                            $direktur->name =  $item[29];
                            $direktur->save();
                        }

                        $user->empore_organisasi_direktur = $direktur->id;

                        if(!empty($item[30]))
                        {
                            $manager = EmporeOrganisasiManager::where('name', 'LIKE', '%'. $item[30] .'%')->where('empore_organisasi_direktur_id', $direktur->id)->first();
                            if(!$manager)
                            {
                                $manager = new EmporeOrganisasiManager();
                                $manager->empore_organisasi_direktur_id = $direktur->id;
                                $manager->name =  $item[30];
                                $manager->save();
                            }

                            $user->empore_organisasi_manager_id = $manager->id;
                        }

                        if(!empty($item[31]))
                        {
                            $staff = EmporeOrganisasiStaff::where('name', 'LIKE', $item[31])->first();
                            if(!$staff)
                            {
                                $staff = new EmporeOrganisasiStaff();
                                $staff->name =  $item[31];
                                $staff->save();
                            }

                            $user->empore_organisasi_staff_id = $staff->id;
                        }
                    }

                    $cabang = Cabang::where('name', 'LIKE', '%'. strtoupper($item[32]) .'%')->first();
                    if($cabang)
                    {
                        $user->organisasi_branch    = $cabang->id;
                    }
                    else
                    {
                        $cabang = new \App\Cabang();
                        $cabang->name = $item[32];
                        $cabang->save();

                        $user->organisasi_branch    = $cabang->id;
                    }

                    $user->organisasi_ho_or_branch= $item[33];
                    $user->organisasi_status    = $item[34];
                    $user->cuti_length_of_service = $item[35];
                    $user->cuti_cuti_2018       = $item[36];
                    $user->cuti_terpakai        = $item[37];
                    $user->cuti_sisa_cuti       = $item[38];
                    $user->save();

                    // SD
                    $education                  = new UserEducationTemp();
                    $education->user_temp_id    = $user->id;
                    $education->pendidikan      = strtoupper($item[39]);
                    $education->tahun_awal      = $item[40];
                    $education->tahun_akhir     = $item[41];
                    $education->fakultas        = strtoupper($item[42]);
                    $education->kota            = strtoupper($item[43]); // CITY
                    $education->jurusan         = strtoupper($item[44]); // MAJOR
                    $education->nilai           = $item[45]; // GPA
                    $education->certificate     = $item[46];
                    $education->note            = strtoupper($item[47]);
                    $education->save();

                    // SD KE DUA
                    if(!empty($item[48]))
                    {
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = strtoupper($item[48]);
                        $education->tahun_awal      = $item[49];
                        $education->tahun_akhir     = $item[50];
                        $education->fakultas        = strtoupper($item[51]);
                        $education->kota            = strtoupper($item[52]); // CITY
                        $education->jurusan         = strtoupper($item[53]); // MAJOR
                        $education->nilai           = $item[54]; // GPA
                        $education->certificate     = $item[55];
                        $education->note            = strtoupper($item[56]);
                        $education->save();
                    }

                    // SMP
                    $education                  = new UserEducationTemp();
                    $education->user_temp_id    = $user->id;
                    $education->pendidikan      = strtoupper($item[57]);
                    $education->tahun_awal      = $item[58];
                    $education->tahun_akhir     = $item[59];
                    $education->fakultas        = strtoupper($item[60]);
                    $education->kota            = strtoupper($item[61]); // CITY
                    $education->jurusan         = strtoupper($item[62]); // MAJOR
                    $education->nilai           = $item[63]; // GPA
                    $education->certificate     = $item[64];
                    $education->note            = strtoupper($item[65]);
                    $education->save();

                    if(!empty($item[66]))
                    {
                        // SMP  KE 2
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = strtoupper($item[66]);
                        $education->tahun_awal      = $item[67];
                        $education->tahun_akhir     = $item[68];
                        $education->fakultas        = strtoupper($item[69]);
                        $education->kota            = strtoupper($item[70]); // CITY
                        $education->jurusan         = strtoupper($item[71]); // MAJOR
                        $education->nilai           = $item[72]; // GPA
                        $education->certificate     = $item[73];
                        $education->note            = strtoupper($item[74]);
                        $education->save();
                    }

                    // SMA
                    $education                  = new UserEducationTemp();
                    $education->user_temp_id    = $user->id;
                    $education->pendidikan      = strtoupper($item[75]);
                    $education->tahun_awal      = $item[76];
                    $education->tahun_akhir     = $item[77];
                    $education->fakultas        = strtoupper($item[78]);
                    $education->kota            = strtoupper($item[79]); // CITY
                    $education->jurusan         = strtoupper($item[80]); // MAJOR
                    $education->nilai           = $item[81]; // GPA
                    $education->certificate     = $item[82];
                    $education->note            = strtoupper($item[83]);
                    $education->save();

                    // SMA KE 2
                    if(!empty($item[84]))
                    {
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = strtoupper($item[84]);
                        $education->tahun_awal      = $item[85];
                        $education->tahun_akhir     = $item[86];
                        $education->fakultas        = strtoupper($item[87]);
                        $education->kota            = strtoupper($item[88]); // CITY
                        $education->jurusan         = strtoupper($item[89]); // MAJOR
                        $education->nilai           = $item[90]; // GPA
                        $education->certificate     = $item[91];
                        $education->note            = strtoupper($item[92]);
                        $education->save();
                    }

                    $education                  = new UserEducationTemp();
                    $education->user_temp_id    = $user->id;
                    $education->pendidikan      = strtoupper($item[93]);
                    $education->tahun_awal      = $item[94];
                    $education->tahun_akhir     = $item[95];
                    $education->fakultas        = strtoupper($item[96]);
                    $education->kota            = strtoupper($item[97]); // CITY
                    $education->jurusan         = strtoupper($item[98]); // MAJOR
                    $education->nilai           = $item[99]; // GPA
                    $education->certificate     = $item[100];
                    $education->note            = strtoupper($item[101]);
                    $education->save();

                    $education                  = new UserEducationTemp();
                    $education->user_temp_id    = $user->id;
                    $education->pendidikan      = strtoupper($item[102]);
                    $education->tahun_awal      = $item[103];
                    $education->tahun_akhir     = $item[104];
                    $education->fakultas        = strtoupper($item[105]);
                    $education->kota            = strtoupper($item[106]); // CITY
                    $education->jurusan         = strtoupper($item[107]); // MAJOR
                    $education->nilai           = $item[108]; // GPA
                    $education->certificate     = $item[109];
                    $education->note            = strtoupper($item[110]);
                    $education->save();

                    $education                  = new UserEducationTemp();
                    $education->user_temp_id    = $user->id;
                    $education->pendidikan      = strtoupper($item[111]);
                    $education->tahun_awal      = $item[112];
                    $education->tahun_akhir     = $item[113];
                    $education->fakultas        = strtoupper($item[114]);
                    $education->kota            = strtoupper($item[115]); // CITY
                    $education->jurusan         = strtoupper($item[116]); // MAJOR
                    $education->nilai           = $item[117]; // GPA
                    $education->certificate     = $item[118];
                    $education->note            = strtoupper($item[119]);
                    $education->save();

                    $education                  = new UserEducationTemp();
                    $education->user_temp_id    = $user->id;
                    $education->pendidikan      = strtoupper($item[120]);
                    $education->tahun_awal      = $item[121];
                    $education->tahun_akhir     = $item[122];
                    $education->fakultas        = strtoupper($item[123]);
                    $education->kota            = strtoupper($item[124]); // CITY
                    $education->jurusan         = strtoupper($item[125]); // MAJOR
                    $education->nilai           = $item[126]; // GPA
                    $education->certificate     = $item[127];
                    $education->note            = strtoupper($item[128]);
                    $education->save();

                    if(!empty($item[129]))
                    {
                        $education                  = new UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = strtoupper($item[129]);
                        $education->tahun_awal      = $item[130];
                        $education->tahun_akhir     = $item[131];
                        $education->fakultas        = strtoupper($item[132]);
                        $education->kota            = strtoupper($item[133]); // CITY
                        $education->jurusan         = strtoupper($item[134]); // MAJOR
                        $education->nilai           = $item[135]; // GPA
                        $education->certificate     = $item[136];
                        $education->note            = strtoupper($item[137]);
                        $education->save();
                    }

                    $education                  = new UserEducationTemp();
                    $education->user_temp_id    = $user->id;
                    $education->pendidikan      = strtoupper($item[138]);
                    $education->tahun_awal      = $item[139];
                    $education->tahun_akhir     = $item[140];
                    $education->fakultas        = strtoupper($item[141]);
                    $education->kota            = strtoupper($item[142]); // CITY
                    $education->jurusan         = strtoupper($item[143]); // MAJOR
                    $education->nilai           = $item[144]; // GPA
                    $education->certificate     = $item[145];
                    $education->note            = strtoupper($item[146]);
                    $education->save();

                    // ISTRI 1
                    $family                     = new UserFamilyTemp();
                    $family->user_temp_id       = $user->id;
                    $family->hubungan           = strtoupper($item[147]);
                    $family->nama               = strtoupper($item[148]);
                    $family->gender             = ($item[149] =='Male' ? 'Laki-laki' : 'Perempuan');
                    $family->tempat_lahir       = strtoupper($item[150]);
                    $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[151]);
                    $family->pekerjaan          = strtoupper($item[152]);
                    $family->note               = strtoupper($item[153]);
                    $family->save();

                    // ISTRI KE 2
                    if(!empty($item[154]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = strtoupper($item[154]);
                        $family->nama               = strtoupper($item[155]);
                        $family->gender             = ($item[156]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[157]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[158]);
                        $family->pekerjaan          = strtoupper($item[159]);
                        $family->note               = strtoupper($item[160]);
                        $family->save();
                    }

                    // SUAMI
                    if(!empty($item[160]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = strtoupper($item[161]);
                        $family->nama               = strtoupper($item[162]);
                        $family->gender             = ($item[163]== 'Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[164]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[165]);
                        $family->pekerjaan          = strtoupper($item[166]);
                        $family->note               = strtoupper($item[167]);
                        $family->save();
                    }

                    // ANAK 1
                    if(!empty($item[168]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = strtoupper($item[168]);
                        $family->nama               = strtoupper($item[169]);
                        $family->gender             = $item[170] == 'Male' ? 'Laki-laki' : 'Perempuan';
                        $family->tempat_lahir       = strtoupper($item[171]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[172]);
                        $family->pekerjaan          = strtoupper($item[173]);
                        $family->note               = strtoupper($item[174]);
                        $family->save();
                    }

                    // ANAK 2
                    if(!empty($item[175]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = strtoupper($item[175]);
                        $family->nama               = strtoupper($item[176]);
                        $family->gender             = ($item[177] == 'Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[178]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[179]);
                        $family->pekerjaan          = strtoupper($item[180]);
                        $family->note               = strtoupper($item[181]);
                        $family->save();
                    }

                    // ANAK 3
                    if(!empty($item[182]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = strtoupper($item[182]);
                        $family->nama               = strtoupper($item[183]);
                        $family->gender             = $item[184] == 'Male' ? 'Laki-laki' : 'Perempuan';
                        $family->tempat_lahir       = strtoupper($item[185]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[186]);
                        $family->pekerjaan          = strtoupper($item[187]);
                        $family->note               = strtoupper($item[188]);
                        $family->save();
                    }

                    // ANAK 4
                    if(!empty($item[189]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = strtoupper($item[189]);
                        $family->nama               = strtoupper($item[190]);
                        $family->gender             = $item[191]== 'Male' ? 'Laki-laki' : 'Perempuan';
                        $family->tempat_lahir       = strtoupper($item[192]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[193]);
                        $family->pekerjaan          = strtoupper($item[194]);
                        $family->note               = strtoupper($item[195]);
                        $family->save();
                    }

                    // ANAK 5
                    if(!empty($item[196]))
                    {
                        $family                     = new UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = strtoupper($item[196]);
                        $family->nama               = strtoupper($item[197]);
                        $family->gender             = $item[198] == 'Male' ? 'Laki-laki' : 'Perempuan';
                        $family->tempat_lahir       = strtoupper($item[199]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[200]);
                        $family->pekerjaan          = strtoupper($item[201]);
                        $family->note               = strtoupper($item[202]);
                        $family->save();
                    }
                }
            }

            return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Data berhasil di import');
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

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Data Dependent Berhasil dihapus !');
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

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Data Invetaris Berhasil dihapus !');
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

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Data Invetaris Berhasil dihapus !');
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

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Data Educatuin Berhasil dihapus !');
    }

    /**
     * [deleteTemp description]
     * @return [type] [description]
     */
    public function deleteTemp($id)
    {
        $data = UserTemp::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Data Temporary berhasil di hapus');
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
        $data->nik          = $request->nik;
        $data->ldap         = $request->ldap;
        $data->jenis_kelamin= $request->jenis_kelamin;
        $data->email        = $request->email;
        // $data->provinsi_id  = $request->provinsi_id;
        // $data->kabupaten_id = $request->kabupaten_id;
        // $data->kecamatan_id = $request->kecamatan_id;
        // $data->kelurahan_id = $request->kelurahan_id;

        $data->telepon      = $request->telepon;
        $data->agama        = $request->agama;
        $data->current_address= $request->current_address;
        $data->access_id    = 2; //
        $data->division_id  = $request->division_id;
        $data->department_id= $request->department_id;
        $data->section_id   = $request->section_id;
        $data->type_jabatan = $request->type_jabatan;
        $data->nama_jabatan = $request->nama_jabatan;
        $data->hak_cuti     = 12;
        $data->cuti_yang_terpakai = 0;
        $data->cabang_id    =$request->cabang_id;
        $data->nama_rekening    = $request->nama_rekening;
        $data->nomor_rekening   = $request->nomor_rekening;
        $data->bank_id          = $request->bank_id;
        // $data->cabang           = $request->cabang;
        $data->join_date        = $request->join_date;
        $data->tempat_lahir     = $request->tempat_lahir;
        $data->tanggal_lahir    = $request->tanggal_lahir;
        $data->absensi_number       = $request->absensi_number;
        $data->employee_number      = $request->employee_number;
        $data->ktp_number           = $request->ktp_number;
        $data->passport_number      = $request->passport_number;
        $data->kk_number            = $request->kk_number;
        $data->npwp_number          = $request->npwp_number;
        $data->bpjs_number          = $request->bpjs_number;
        $data->organisasi_position     = $request->organisasi_position;
        $data->organisasi_job_role     = $request->organisasi_job_role;
        $data->section_id              = $request->section_id;
        $data->organisasi_status    = $request->organisasi_status;
        $data->branch_type          = $request->branch_type;
        $data->ext                  = $request->ext;
        $data->is_pic_cabang        = isset($request->is_pic_cabang) ? $request->is_pic_cabang : 0;
        $data->branch_staff_id      = $request->branch_staff_id;
        $data->branch_head_id       = $request->branch_head_id;
        $data->blood_type           = $request->blood_type;
        $data->marital_status       = $request->marital_status;
        $data->mobile_1             = $request->mobile_1;
        $data->mobile_2             = $request->mobile_2;
        $data->id_address           = $request->id_address;
        $data->id_city              = $request->id_city;
        $data->empore_organisasi_direktur   = $request->empore_organisasi_direktur;
        $data->empore_organisasi_manager_id = $request->empore_organisasi_manager_id;
        $data->empore_organisasi_staff_id   = $request->empore_organisasi_staff_id;

        if ($request->hasFile('foto'))
        {
            $file = $request->file('foto');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/foto/');
            $file->move($destinationPath, $fileName);

            $data->foto = $fileName;
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

        return redirect()->route('administrator.karyawan.edit', $data->id)->with('message-success', 'Data berhasil disimpan');
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data               = new User();

        $this->validate($request,[
            'nik'               => 'required|unique:users',
            //'email'               => 'required|unique:users',
            //'confirmation'      => 'same:password',
        ]);

        $data->password             = bcrypt($request->password);

        $data->name         = strtoupper($request->name);
        $data->nik          = $request->nik;
        $data->ldap         = $request->ldap;
        $data->jenis_kelamin= $request->jenis_kelamin;
        $data->email        = $request->email;
        $data->ext          = $request->ext;
        $data->telepon      = $request->telepon;
        $data->agama        = $request->agama;
        $data->alamat       = $request->alamat;
        $data->access_id    = 2;
        $data->jabatan_cabang= $request->jabatan_cabang;
        $data->division_id  = $request->division_id;
        $data->department_id= $request->department_id;
        $data->section_id   = $request->section_id;
        $data->type_jabatan = $request->type_jabatan;
        $data->nama_jabatan = $request->nama_jabatan;
        $data->hak_cuti     = 12;
        $data->cuti_yang_terpakai = 0;
        $data->cabang_id    =$request->cabang_id;
        $data->nama_rekening    = $request->nama_rekening;
        $data->nomor_rekening   = $request->nomor_rekening;
        $data->bank_id          = $request->bank_id;
        $data->join_date        = $request->join_date;
        $data->tempat_lahir     = $request->tempat_lahir;
        $data->tanggal_lahir    = $request->tanggal_lahir;
        $data->absensi_number       = $request->absensi_number;
        $data->employee_number      = $request->employee_number;
        $data->ktp_number           = $request->ktp_number;
        $data->passport_number      = $request->passport_number;
        $data->kk_number            = $request->kk_number;
        $data->npwp_number          = $request->npwp_number;
        $data->bpjs_number          = $request->bpjs_number;
        $data->organisasi_position     = $request->organisasi_position;
        $data->organisasi_job_role     = $request->organisasi_job_role;
        $data->section_id              = $request->section_id;
        $data->organisasi_status    = $request->organisasi_status;
        $data->branch_type          = $request->branch_type;
        $data->ext                  = $request->ext;
        $data->is_pic_cabang        = isset($request->is_pic_cabang) ? $request->is_pic_cabang : 0;
        $data->blood_type           = $request->blood_type;
        $data->marital_status           = $request->marital_status;
        $data->empore_organisasi_direktur   = $request->empore_organisasi_direktur;
        $data->empore_organisasi_manager_id = $request->empore_organisasi_manager_id;
        $data->empore_organisasi_staff_id   = $request->empore_organisasi_staff_id;

        if (request()->hasFile('foto'))
        {
            $file = $request->file('foto');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/foto/');
            $file->move($destinationPath, $fileName);

            $data->foto = $fileName;
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
            // user Education
            foreach($request->cuti['cuti_id'] as $key => $item)
            {
                $c = new UserCuti();
                $c->user_id = $data->id;
                $c->cuti_id    = $request->cuti['cuti_id'][$key];
                $c->kuota    = $request->cuti['kuota'][$key];
                $c->save();
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

        return redirect()->route('administrator.karyawan.index')->with('message-success', 'Data berhasil disimpan !');
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

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Data Invetaris Berhasil dihapus !');
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

        return redirect()->route('administrator.karyawan.edit', $user_id)->with('message-success', 'Data Cuti berhasil dihapus');
    }

    /**
     * [deleteOldUser description]
     * @return [type] [description]
     */
    public function deleteOldUser($id)
    {
        $data = User::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Data lama berhasil di hapus');
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

        return redirect()->route('administrator.karyawan.index')->with('message-sucess', 'Data berhasi di hapus');
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
}