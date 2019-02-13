<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelUser;
use Auth;
use Session;
use Illuminate\Support\Facades\Input;
use App\Models\Directorate;
use App\Models\Division;
use App\Models\Department;
use App\Models\Section;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UserInventarisMobil;
use App\Models\UserInventaris;
use App\Models\UserCuti;
use App\Models\UserEducation;
use App\Models\UserFamily;
use App\Models\PayrollOthers;
use App\Models\PayrollPtkp;
use App\Models\Payroll;
use App\Models\PayrollNet;
use App\Models\PayrollGross;
use App\Models\Airports;
use App\Models\MedicalReimbursement;
use App\Models\OvertimeSheet;
use App\Models\PaymentRequest;
use App\Models\StatusApproval;
use App\Models\CutiKaryawan;
use App\Models\ExitInterview;
use App\Models\Training;
use App\Models\SettingApproval;
use App\Models\BranchHead;
use App\Models\BranchStaff;
use App\Models\EmporeOrganisasiDirektur;
use App\Models\EmporeOrganisasiManager;
use App\Models\EmporeOrganisasiStaff;
use App\User;

class AjaxController extends Controller
{
    protected $respon;

    /**
     * [__construct description]
     */
    public function __construct()
    {
        /**
         * [$this->respon description]
         * @var [type]
         */
        $this->respon = ['message' => 'error'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ;
    }

    /**
     * [updatePasswordAdministrator description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updatePasswordAdministrator(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data               = \App\User::where('id', \Auth::user()->id)->first();
            
            if(!\Hash::check($request->currentpassword, $data->password))
            {
                $params['message']  = 'error';
                $params['data']     = 'Current password salah';
            }
            else
            {
                $data->password                 = bcrypt($request->password);
                $data->last_change_password     = date('Y-m-d H:i:s');
                $data->save();

                \Session::flash('message-success', 'Password berhasil di rubah');
            }
        }   
        
        return response()->json($params);
    }

    /**
     * [updateFirstPassword description]
     * @return [type] [description]
     */
    public function updatePassword(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data               = \App\User::where('id', $request->id)->first();
            $data->password     = bcrypt($request->password);
            $data->is_reset_first_password = 1; 
            $data->last_change_password = date('Y-m-d H:i:s');
            $data->save();

            \Session::flash('message-success', 'Password berhasil di rubah');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateInventarisMobil description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateInventarisMobil(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = UserInventarisMobil::where('id', $request->id)->first();
            $data->tipe_mobil           = $request->tipe_mobil;
            $data->tahun                = $request->tahun;
            $data->no_polisi            = $request->no_polisi;
            $data->status_mobil         = $request->status_mobil;
            $data->save();

            \Session::flash('message-success', 'Data Cuti Berhasil di update');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateInventarisLainnya description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateInventarisLainnya(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = UserInventaris::where('id', $request->id)->first();
            $data->jenis            = $request->jenis;
            $data->description      = $request->description;
            $data->save();

            \Session::flash('message-success', 'Data Inventaris Berhasil di update');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateCuti description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateCuti(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = UserCuti::where('id', $request->id)->first();
            $data->cuti_id          = $request->cuti_id;
            $data->kuota            = $request->kuota;
            $data->cuti_terpakai    = $request->terpakai;
            $data->sisa_cuti        = $request->kuota - $request->terpakai;
            $data->save();

            \Session::flash('message-success', 'Data Cuti Berhasil di update');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateEducation description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateEducation(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = UserEducation::where('id', $request->id)->first();
            $data->pendidikan       = $request->pendidikan;
            $data->tahun_awal       = $request->tahun_awal;
            $data->tahun_akhir      = $request->tahun_akhir;
            $data->fakultas         = $request->fakultas;
            $data->jurusan          = $request->jurusan;
            $data->nilai            = $request->nilai;
            $data->kota             = $request->kota;
            $data->save();

            \Session::flash('message-success', 'Data Education Berhasil di update');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateDependent description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateDependent(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = UserFamily::where('id', $request->id)->first();
            $data->nama             = $request->nama;
            $data->hubungan         = $request->hubungan;
            $data->tempat_lahir     = $request->tempat_lahir;
            $data->tanggal_lahir    = $request->tanggal_lahir;
            $data->tanggal_meninggal= $request->tanggal_meninggal;
            $data->jenjang_pendidikan=$request->jenjang_pendidikan;
            $data->pekerjaan        = $request->pekerjaan;
            $data->tertanggung      = $request->tertanggung;
            $data->save();

            \Session::flash('message-success', 'Data Dependent Berhasil di update');
        }   
        
        return response()->json($params);
    }

    /**
     * [getBulangPaySlip description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getBulangPaySlip(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
            //$params = \App\Payroll::select(\DB::raw('month(created_at) as bulan'))->whereYear('created_at', '=', $request->tahun)->where('user_id', $request->user_id)->get();

            $params = User::select(\DB::raw('month(join_date) as bulan'))->whereYear('join_date', '=', $request->tahun)->where('id', $request->user_id)->first();

            $bulanArray = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Augustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
            
            $bulan = [];
            for($b = $params->bulan; $b <= date('m'); $b++)
            {
                $bulan[$b]['id'] = $b;
                $bulan[$b]['name'] = $bulanArray[$b];
            }
        }

        return response()->json($bulan);
    }

   
    public function getCalculatePayroll(Request $request)
    {
        $biaya_jabatan  = PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum   = PayrollOthers::where('id', 2)->first()->value;
        $bpjs_pensiunan_batas = PayrollOthers::where('id', 3)->first()->value;
        $bpjs_kesehatan_batas = PayrollOthers::where('id', 4)->first()->value;
        
        $params = [];
        if($request->ajax())
        {
            $bpjs_ketenagakerjaan_persen = 4.24;
            $bpjs_ketenagakerjaan = ($request->salary * $bpjs_ketenagakerjaan_persen / 100);
            $bpjs_ketenagakerjaan2_persen = 2;
            $bpjs_ketenagakerjaan2 = ($request->salary * $bpjs_ketenagakerjaan2_persen / 100);

            $bpjs_kesehatan         = 0;
            $bpjs_kesehatan2        = 0;
            $bpjs_kesehatan_persen  = 4;
            $bpjs_kesehatan2_persen = 1;

            if($request->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan     = ($request->salary * $bpjs_kesehatan_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan     = ($bpjs_kesehatan_batas * $bpjs_kesehatan_persen / 100);
            }

            if($request->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan2     = ($request->salary * $bpjs_kesehatan2_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan2     = ($bpjs_kesehatan_batas * $bpjs_kesehatan2_persen / 100);
            }

            $bpjs_pensiun         = 0;
            $bpjs_pensiun2        = 0;
            $bpjs_pensiun_persen  = 2;
            $bpjs_pensiun2_persen = 1;

            if($request->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun     = ($request->salary * $bpjs_pensiun_persen / 100); 
            }
            else
            {
                $bpjs_pensiun     = ($bpjs_pensiunan_batas * $bpjs_pensiun_persen / 100);
            }

            if($request->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun2     = ($request->salary * $bpjs_pensiun2_persen / 100); 
            }
            else
            {
                $bpjs_pensiun2     = ($bpjs_pensiunan_batas * $bpjs_pensiun2_persen / 100);
            }

            $overtime_claim = $request->ot_multiple_hours / 173 * $request->salary;
            $bpjspenambahan = $bpjs_ketenagakerjaan + $bpjs_kesehatan + $bpjs_pensiun;
            $bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2;

            $gross_income = ($request->salary + $request->call_allow + $request->transport_allowance + $request->homebase_allowance + $request->laptop_allowance + $overtime_claim + $bpjspenambahan) * 12 + $request->bonus;

            $gross_income2 = ($request->salary + $request->call_allow + $request->transport_allowance + $request->homebase_allowance + $request->laptop_allowance + $overtime_claim + $bpjspenambahan + $request->bonus) - $bpjspengurangan;


            // burdern allowance
            $burden_allow = 5 * $gross_income2 / 100;
            $biaya_jabatan_bulan = $biaya_jabatan / 12;
            if($burden_allow > $biaya_jabatan_bulan)
            {
                $burden_allow = $biaya_jabatan_bulan;
            }
 
            $total_deduction = ($bpjspengurangan * 12) + ($burden_allow*12);

            $net_yearly_income          = $gross_income - $total_deduction;

            $untaxable_income = 0;

            $ptkp = PayrollPtkp::where('id', 1)->first();
            if($request->marital_status == 'Bujangan/Wanita' || $request->marital_status == "")
            {
                $untaxable_income = $ptkp->bujangan_wanita;
            }
            if($request->marital_status == 'Menikah')
            {
                $untaxable_income = $ptkp->menikah;
            }
            if($request->marital_status == 'Menikah Anak 1')
            {
                $untaxable_income = $ptkp->menikah_anak_1;
            }
            if($request->marital_status == 'Menikah Anak 2')
            {
                $untaxable_income = $ptkp->menikah_anak_2;
            }
            if($request->marital_status == 'Menikah Anak 3')
            {
                $untaxable_income = $ptkp->menikah_anak_3;
            }

            $taxable_yearly_income = $net_yearly_income - $untaxable_income;

            // Perhitungan 5 persen
            $income_tax_calculation_5 = 0;
            if($taxable_yearly_income < 0)
            {
                $income_tax_calculation_5 = 0;   
            }
            elseif($taxable_yearly_income <= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * $taxable_yearly_income;
            }
            if($taxable_yearly_income >= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * 50000000;
            }

            // Perhitungan 15 persen
            $income_tax_calculation_15 = 0;
            if($taxable_yearly_income >= 250000000 )
            {
                $income_tax_calculation_15 = 0.15 * (250000000 - 50000000);
            }
            if($taxable_yearly_income >= 50000000 and $taxable_yearly_income <= 250000000)
            {
                $income_tax_calculation_15 = 0.15 * ($taxable_yearly_income - 50000000);
            }

            // Perhitungan 25 persen
            $income_tax_calculation_25 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_25 = 0.25 * (500000000 - 250000000);
            }
 
            if($taxable_yearly_income <= 500000000 and $taxable_yearly_income >= 250000000)
            {
                $income_tax_calculation_25 = 0.25 * ($taxable_yearly_income - 250000000);
            }

            $income_tax_calculation_30 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_30 = 0.35 * ($taxable_yearly_income - 500000000);
            }

            $yearly_income_tax = $income_tax_calculation_5 + $income_tax_calculation_15 + $income_tax_calculation_25 + $income_tax_calculation_30;
            $monthly_income_tax = $yearly_income_tax / 12;
            $gross_income_per_month       = $gross_income / 12;

            $less               = $bpjspengurangan + $monthly_income_tax; 

             $gross_thp = ($request->salary + $request->call_allow + $request->transport_allowance + $request->homebase_allowance + $request->laptop_allowance + $request->other_income + $overtime_claim + $request->other_income+ $request->medical_claim+ $request->bonus);

            $thp                = $gross_thp - $less - $request->other_deduction;


            $params['gross_income']         = number_format($gross_income); 
            $params['burden_allow']         = number_format($burden_allow);
            $params['bpjs_ketenagakerjaan'] = number_format($bpjs_ketenagakerjaan);
            $params['bpjs_ketenagakerjaan2'] = number_format($bpjs_ketenagakerjaan2);
            $params['bpjs_kesehatan']         = number_format($bpjs_kesehatan);
            $params['bpjs_kesehatan2']        = number_format($bpjs_kesehatan2);
            $params['bpjs_pensiun']         = number_format($bpjs_pensiun);
            $params['bpjs_pensiun2']        = number_format($bpjs_pensiun2);
            $params['total_deduction']      = number_format($total_deduction);
            $params['net_yearly_income']    = number_format($net_yearly_income);
            $params['untaxable_income']     = number_format($untaxable_income);
            $params['taxable_yearly_income']        = number_format($taxable_yearly_income);
            $params['income_tax_calculation_5']     = number_format($income_tax_calculation_5); 
            $params['income_tax_calculation_15']    = number_format($income_tax_calculation_15); 
            $params['income_tax_calculation_25']    = number_format($income_tax_calculation_25); 
            $params['income_tax_calculation_30']    = number_format($income_tax_calculation_30); 
            $params['yearly_income_tax']            = number_format($yearly_income_tax);
            $params['monthly_income_tax']           = number_format($monthly_income_tax);
            $params['gross_income_per_month']                 = number_format($gross_income_per_month);
            $params['less']                         = number_format($less);
            $params['thp']                          = number_format($thp);
            $params['overtime_claim']               = number_format($overtime_claim);
        }
        
        return response()->json($params);
    }


    public function getCalculatePayrollNet(Request $request)
    {
        $biaya_jabatan = PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum = PayrollOthers::where('id', 2)->first()->value;
        $bpjs_pensiunan_batas = PayrollOthers::where('id', 3)->first()->value;
        $bpjs_kesehatan_batas = PayrollOthers::where('id', 4)->first()->value;
        
        $params = [];
        if($request->ajax())
        {
            $bpjs_ketenagakerjaan_persen = 4.24;
            $bpjs_ketenagakerjaan = ($request->salary * $bpjs_ketenagakerjaan_persen / 100);
            $bpjs_ketenagakerjaan2_persen = 2;
            $bpjs_ketenagakerjaan2 = ($request->salary * $bpjs_ketenagakerjaan2_persen / 100);

            $bpjs_kesehatan         = 0;
            $bpjs_kesehatan2        = 0;
            $bpjs_kesehatan_persen  = 4;
            $bpjs_kesehatan2_persen = 1;

            if($request->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan     = ($request->salary * $bpjs_kesehatan_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan     = ($bpjs_kesehatan_batas * $bpjs_kesehatan_persen / 100);
            }

            if($request->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan2     = ($request->salary * $bpjs_kesehatan2_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan2     = ($bpjs_kesehatan_batas * $bpjs_kesehatan2_persen / 100);
            }

            $bpjs_pensiun         = 0;
            $bpjs_pensiun2        = 0;
            $bpjs_pensiun_persen  = 2;
            $bpjs_pensiun2_persen = 1;

            if($request->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun     = ($request->salary * $bpjs_pensiun_persen / 100); 
            }
            else
            {
                $bpjs_pensiun     = ($bpjs_pensiunan_batas * $bpjs_pensiun_persen / 100);
            }

            if($request->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun2     = ($request->salary * $bpjs_pensiun2_persen / 100); 
            }
            else
            {
                $bpjs_pensiun2     = ($bpjs_pensiunan_batas * $bpjs_pensiun2_persen / 100);
            }


            $overtime = $request->ot_normal_hours / 173 * $request->salary;

            $total_income= $request->salary +$request->call_allowance+ $request->transport_allowance+$request->meal_allow + $request->homebase_allowance +$request->laptop_allowance +$overtime +$request->bonus + $request->medical_claim + $request->other_income + $request->other_income2 ;

            $total_deduction = ($request->deduction1 + $request->deduction2 + $request->deduction3);

            $thp = $total_income - $total_deduction;


            $bpjspenambahan = $bpjs_ketenagakerjaan + $bpjs_kesehatan + $bpjs_pensiun;
            $bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2;

            $gross_income = ($request->salary +$request->call_allowance+ $request->transport_allowance+$request->meal_allow + $request->homebase_allowance +$request->laptop_allowance +$overtime + $bpjspenambahan) * 12 + $request->bonus;

            $gross_income2 = ($request->salary +$request->call_allowance+ $request->transport_allowance+$request->meal_allow + $request->homebase_allowance +$request->laptop_allowance +$overtime + $bpjspenambahan + $request->bonus) - $bpjspengurangan;


            // burdern allowance
            $burden_allow = 5 * $gross_income2 / 100;
            $biaya_jabatan_bulan = $biaya_jabatan / 12;
            if($burden_allow > $biaya_jabatan_bulan)
            {
                $burden_allow = $biaya_jabatan_bulan;
            }
 
            $total_deductionPer = ($bpjspengurangan * 12) + ($burden_allow*12);

            $net_yearly_income          = $gross_income - $total_deductionPer;

            $untaxable_income = 0;

            $ptkp = PayrollPtkp::where('id', 1)->first();
            if($request->marital_status == 'Bujangan/Wanita' || $request->marital_status == "")
            {
                $untaxable_income = $ptkp->bujangan_wanita;
            }
            if($request->marital_status == 'Menikah')
            {
                $untaxable_income = $ptkp->menikah;
            }
            if($request->marital_status == 'Menikah Anak 1')
            {
                $untaxable_income = $ptkp->menikah_anak_1;
            }
            if($request->marital_status == 'Menikah Anak 2')
            {
                $untaxable_income = $ptkp->menikah_anak_2;
            }
            if($request->marital_status == 'Menikah Anak 3')
            {
                $untaxable_income = $ptkp->menikah_anak_3;
            }

            $taxable_yearly_income = $net_yearly_income - $untaxable_income;

            // Perhitungan 5 persen
            $income_tax_calculation_5 = 0;
            if($taxable_yearly_income < 0)
            {
                $income_tax_calculation_5 = 0;   
            }
            elseif($taxable_yearly_income <= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * $taxable_yearly_income;
            }
            if($taxable_yearly_income >= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * 50000000;
            }

            // Perhitungan 15 persen
            $income_tax_calculation_15 = 0;
            if($taxable_yearly_income >= 250000000 )
            {
                $income_tax_calculation_15 = 0.15 * (250000000 - 50000000);
            }
            if($taxable_yearly_income >= 50000000 and $taxable_yearly_income <= 250000000)
            {
                $income_tax_calculation_15 = 0.15 * ($taxable_yearly_income - 50000000);
            }

            // Perhitungan 25 persen
            $income_tax_calculation_25 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_25 = 0.25 * (500000000 - 250000000);
            }
 
            if($taxable_yearly_income <= 500000000 and $taxable_yearly_income >= 250000000)
            {
                $income_tax_calculation_25 = 0.25 * ($taxable_yearly_income - 250000000);
            }

            $income_tax_calculation_30 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_30 = 0.35 * ($taxable_yearly_income - 500000000);
            }

            $yearly_income_tax = $income_tax_calculation_5 + $income_tax_calculation_15 + $income_tax_calculation_25 + $income_tax_calculation_30;
            $monthly_income_tax = $yearly_income_tax / 12;

            
            $params['overtime']      = number_format($overtime);
            $params['total_income']      = number_format($total_income);
            $params['total_deduction']   = number_format($total_deduction);
            $params['thp']               = number_format($thp);
            $params['yearly_income_tax']      = number_format($yearly_income_tax);
            $params['monthly_income_tax']      = number_format($monthly_income_tax);
            $params['bpjs_ketenagakerjaan'] = number_format($bpjs_ketenagakerjaan);
            $params['bpjs_ketenagakerjaan2'] = number_format($bpjs_ketenagakerjaan2);
            $params['bpjs_kesehatan']         = number_format($bpjs_kesehatan);
            $params['bpjs_kesehatan2']        = number_format($bpjs_kesehatan2);
            $params['bpjs_pensiun']         = number_format($bpjs_pensiun);
            $params['bpjs_pensiun2']        = number_format($bpjs_pensiun2);

        }
        
        return response()->json($params);
    }

public function getCalculatePayrollGross(Request $request)
    {
        $biaya_jabatan  = PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum   = PayrollOthers::where('id', 2)->first()->value;
        $bpjs_pensiunan_batas = PayrollOthers::where('id', 3)->first()->value;
        $bpjs_kesehatan_batas = PayrollOthers::where('id', 4)->first()->value;
        
        $params = [];
        if($request->ajax())
        {
            $bpjs_ketenagakerjaan_persen = 4.24;
            $bpjs_ketenagakerjaan = ($request->salary * $bpjs_ketenagakerjaan_persen / 100);
            $bpjs_ketenagakerjaan2_persen = 2;
            $bpjs_ketenagakerjaan2 = ($request->salary * $bpjs_ketenagakerjaan2_persen / 100);

            $bpjs_kesehatan         = 0;
            $bpjs_kesehatan2        = 0;
            $bpjs_kesehatan_persen  = 4;
            $bpjs_kesehatan2_persen = 1;

            if($request->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan     = ($request->salary * $bpjs_kesehatan_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan     = ($bpjs_kesehatan_batas * $bpjs_kesehatan_persen / 100);
            }

            if($request->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan2     = ($request->salary * $bpjs_kesehatan2_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan2     = ($bpjs_kesehatan_batas * $bpjs_kesehatan2_persen / 100);
            }

            $bpjs_pensiun         = 0;
            $bpjs_pensiun2        = 0;
            $bpjs_pensiun_persen  = 2;
            $bpjs_pensiun2_persen = 1;

            if($request->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun     = ($request->salary * $bpjs_pensiun_persen / 100); 
            }
            else
            {
                $bpjs_pensiun     = ($bpjs_pensiunan_batas * $bpjs_pensiun_persen / 100);
            }

            if($request->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun2     = ($request->salary * $bpjs_pensiun2_persen / 100); 
            }
            else
            {
                $bpjs_pensiun2     = ($bpjs_pensiunan_batas * $bpjs_pensiun2_persen / 100);
            }

            $overtime_claim = $request->ot_multiple_hours / 173 * $request->salary;
            $bpjspenambahan = $bpjs_ketenagakerjaan + $bpjs_kesehatan + $bpjs_pensiun;
            $bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2;

            $gross_income = ($request->salary + $request->call_allow + $request->transport_allowance + $request->homebase_allowance + $request->laptop_allowance + $overtime_claim + $bpjspenambahan) * 12 + $request->bonus;

            $gross_income2 = ($request->salary + $request->call_allow + $request->transport_allowance + $request->homebase_allowance + $request->laptop_allowance + $overtime_claim + $bpjspenambahan + $request->bonus) - $bpjspengurangan;


            // burdern allowance
            $burden_allow = 5 * $gross_income2 / 100;
            $biaya_jabatan_bulan = $biaya_jabatan / 12;
            if($burden_allow > $biaya_jabatan_bulan)
            {
                $burden_allow = $biaya_jabatan_bulan;
            }
 
            $total_deduction = ($bpjspengurangan * 12) + ($burden_allow*12);

            $net_yearly_income          = $gross_income - $total_deduction;

            $untaxable_income = 0;

            $ptkp = PayrollPtkp::where('id', 1)->first();
            if($request->marital_status == 'Bujangan/Wanita' || $request->marital_status == "")
            {
                $untaxable_income = $ptkp->bujangan_wanita;
            }
            if($request->marital_status == 'Menikah')
            {
                $untaxable_income = $ptkp->menikah;
            }
            if($request->marital_status == 'Menikah Anak 1')
            {
                $untaxable_income = $ptkp->menikah_anak_1;
            }
            if($request->marital_status == 'Menikah Anak 2')
            {
                $untaxable_income = $ptkp->menikah_anak_2;
            }
            if($request->marital_status == 'Menikah Anak 3')
            {
                $untaxable_income = $ptkp->menikah_anak_3;
            }

            $taxable_yearly_income = $net_yearly_income - $untaxable_income;

            // Perhitungan 5 persen
            $income_tax_calculation_5 = 0;
            if($taxable_yearly_income < 0)
            {
                $income_tax_calculation_5 = 0;   
            }
            elseif($taxable_yearly_income <= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * $taxable_yearly_income;
            }
            if($taxable_yearly_income >= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * 50000000;
            }

            // Perhitungan 15 persen
            $income_tax_calculation_15 = 0;
            if($taxable_yearly_income >= 250000000 )
            {
                $income_tax_calculation_15 = 0.15 * (250000000 - 50000000);
            }
            if($taxable_yearly_income >= 50000000 and $taxable_yearly_income <= 250000000)
            {
                $income_tax_calculation_15 = 0.15 * ($taxable_yearly_income - 50000000);
            }

            // Perhitungan 25 persen
            $income_tax_calculation_25 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_25 = 0.25 * (500000000 - 250000000);
            }
 
            if($taxable_yearly_income <= 500000000 and $taxable_yearly_income >= 250000000)
            {
                $income_tax_calculation_25 = 0.25 * ($taxable_yearly_income - 250000000);
            }

            $income_tax_calculation_30 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_30 = 0.35 * ($taxable_yearly_income - 500000000);
            }

            $yearly_income_tax = $income_tax_calculation_5 + $income_tax_calculation_15 + $income_tax_calculation_25 + $income_tax_calculation_30;
            $monthly_income_tax = $yearly_income_tax / 12;
            $gross_income_per_month       = $gross_income / 12;

            $less               = $bpjspengurangan; 

             $gross_thp = ($request->salary + $request->call_allow + $request->transport_allowance + $request->homebase_allowance + $request->laptop_allowance + $request->other_income + $overtime_claim + $request->other_income+ $request->medical_claim+ $request->bonus);

            $thp                = $gross_thp - $less - $request->other_deduction;


            $params['gross_income']         = number_format($gross_income); 
            $params['burden_allow']         = number_format($burden_allow);
            $params['bpjs_ketenagakerjaan'] = number_format($bpjs_ketenagakerjaan);
            $params['bpjs_ketenagakerjaan2'] = number_format($bpjs_ketenagakerjaan2);
            $params['bpjs_kesehatan']         = number_format($bpjs_kesehatan);
            $params['bpjs_kesehatan2']        = number_format($bpjs_kesehatan2);
            $params['bpjs_pensiun']         = number_format($bpjs_pensiun);
            $params['bpjs_pensiun2']        = number_format($bpjs_pensiun2);
            $params['total_deduction']      = number_format($total_deduction);
            $params['net_yearly_income']    = number_format($net_yearly_income);
            $params['untaxable_income']     = number_format($untaxable_income);
            $params['taxable_yearly_income']        = number_format($taxable_yearly_income);
            $params['income_tax_calculation_5']     = number_format($income_tax_calculation_5); 
            $params['income_tax_calculation_15']    = number_format($income_tax_calculation_15); 
            $params['income_tax_calculation_25']    = number_format($income_tax_calculation_25); 
            $params['income_tax_calculation_30']    = number_format($income_tax_calculation_30); 
            $params['yearly_income_tax']            = number_format($yearly_income_tax);
            $params['monthly_income_tax']           = number_format($monthly_income_tax);
            $params['gross_income_per_month']                 = number_format($gross_income_per_month);
            $params['less']                         = number_format($less);
            $params['thp']                          = number_format($thp);
            $params['overtime_claim']               = number_format($overtime_claim);
        }
        
        return response()->json($params);
    }


    /**
     * [getKaryawan description]
     * @return [type] [description]
     */
    public function getKaryawan(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
                $data =  User::where('name', 'LIKE', "%". $request->name . "%")->orWhere('nik', 'LIKE', '%'. $request->name .'%')->get();

                $params = [];
                foreach($data as $k => $item)
                {
                    if($k >= 10) continue;

                    $params[$k]['id'] = $item->id;
                    $params[$k]['value'] = $item->nik .' - '. $item->name;
                }
        }
        
        return response()->json($params); 
    }


    /**
     * [getKaryawan description]
     * @return [type] [description]
     */
    public function getKaryawanPayroll(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
            $data =  User::where('name', 'LIKE', "%". $request->name . "%")->orWhere('nik', 'LIKE', '%'. $request->name .'%')->get();

            $karyawan = [];
            foreach($data as $k => $i)
            {
                $payroll = Payroll::where('user_id', $i->id)->first();
                // existing user payroll skip
                if($payroll) continue;

                if($i->access_id != 2) continue; // jika bukan karyawan maka skip

                $karyawan[$k]['id']     = $i->id;
                $karyawan[$k]['value']  = $i->nik .' - '. $i->name;
            }
        }

        return response()->json($karyawan); 
    }
 
 public function getKaryawanPayrollNet(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
            $data =  \User::where('name', 'LIKE', "%". $request->name . "%")->orWhere('nik', 'LIKE', '%'. $request->name .'%')->get();

            $karyawan = [];
            foreach($data as $k => $i)
            {
                $payroll = PayrollNet::where('user_id', $i->id)->first();
                // existing user payroll skip
                if($payroll) continue;

                if($i->access_id != 2) continue; // jika bukan karyawan maka skip

                $karyawan[$k]['id']     = $i->id;
                $karyawan[$k]['value']  = $i->nik .' - '. $i->name;
            }
        }

        return response()->json($karyawan); 
    }

    public function getKaryawanPayrollGross(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
            $data =  User::where('name', 'LIKE', "%". $request->name . "%")->orWhere('nik', 'LIKE', '%'. $request->name .'%')->get();

            $karyawan = [];
            foreach($data as $k => $i)
            {
                $payroll = PayrollGross::where('user_id', $i->id)->first();
                // existing user payroll skip
                if($payroll) continue;

                if($i->access_id != 2) continue; // jika bukan karyawan maka skip

                $karyawan[$k]['id']     = $i->id;
                $karyawan[$k]['value']  = $i->nik .' - '. $i->name;
            }
        }

        return response()->json($karyawan); 
    }

    /**
     * [getAirports description]
     * @return [type] [description]
     */
    public function getAirports(Request $request)
    {
        $data = [];
        if($request->ajax())
        {
            if(strlen($request->word) >=3 ) 
            { 
                $data =  Airports::where('name', 'LIKE', "%". $request->word . "%")->orWhere('cityName', 'LIKE', '%'. $request->word .'%')->orWhere('countryName', 'LIKE', '%'. strtoupper($request->word) .'%')->groupBy('code')->get();

                $params = [];
                foreach($data as $k => $item)
                {
                    if($k == 10) continue;

                    $params[$k] = $item;
                    $params[$k]['value'] = $item->name .' - '. $item->cityName;
                }
            }
        }
        
        return response()->json($params);   
    }


    /**
     * [getHistoryApprovalOvertime description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalMedical(Request $request)
    {
        if($request->ajax())
        {
            $data = MedicalReimbursement::where('id', $request->foreign_id)->first();

            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($data->atasan->name))
            {
                $data->atasan_name = $data->atasan->nik .' - '. $data->atasan->name;
            }
 
            if(isset($data->direktur->name))
            {
                $data->direktur_name = $data->direktur->nik .' - '. $data->direktur->name;
            }


            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalOvertime description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalOvertime(Request $request)
    {
        if($request->ajax())
        {
            $data = OvertimeSheet::where('id', $request->foreign_id)->first();

            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($data->atasan->name))
            {
                $data->atasan_name = $data->atasan->nik .' - '. $data->atasan->name;
            }
 
            if(isset($data->direktur->name))
            {
                $data->direktur_name = $data->direktur->nik .' - '. $data->direktur->name;
            }


            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalPaymentRequest description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getHistoryApprovalPaymentRequest(Request $request)
    {
        if($request->ajax())
        {
            $data = PaymentRequest::where('id', $request->foreign_id)->first();
            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($data->atasan->name))
            {
                $data->atasan_name = $data->atasan->nik .' - '. $data->atasan->name;
            }
 
            if(isset($data->direktur->name))
            {
                $data->direktur_name = $data->direktur->nik .' - '. $data->direktur->name;
            }

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getStatusApproval description]
     * @return [type] [description]
     */
    public function getHistoryApproval(Request $request)
    {
        if($request->ajax())
        {
            $data = StatusApproval::where('jenis_form', $request->jenis_form)->where('foreign_id', $request->foreign_id)->get();

            $obj = [];
            foreach($data as $key => $item)
            {
                $obj[$key] = $item;
                $obj[$key]['user_approval'] = $item->user_approval;
            }

            return response()->json(['message' => 'success', 'data' => $obj]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalCuti description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalCuti(Request $request)
    {
        if($request->ajax())
        {
            $data = CutiKaryawan::where('id', $request->foreign_id)->first();

            $atasan = User::where('id', $data->approved_atasan_id)->first();
            $direktur = User::where('id', $data->approve_direktur_id)->first();
            
            $data->atasan = "";
            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
            }

            if(isset($direktur))
            {
                $data->direktur = $direktur->nik .' - '. $direktur->name;
            }

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }


    /**
     * [getHistoryApprovalCuti description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalExit(Request $request)
    {
        if($request->ajax())
        {
            $data = ExitInterview::where('id', $request->foreign_id)->first();
            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($data->atasan->name))
            {
                $data->atasan_name = $data->atasan->nik .' - '. $data->atasan->name;
            }
 
            if(isset($data->direktur->name))
            {
                $data->direktur_name = $data->direktur->nik .' - '. $data->direktur->name;
            }


            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalCuti description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalTraining(Request $request)
    {
        if($request->ajax())
        {
            $data       = Training::where('id', $request->foreign_id)->first();
            $atasan     = User::where('id', $data->approved_atasan_id)->first();
            $direktur   = User::where('id', $data->approve_direktur_id)->first();

            $data->atasan = "";

            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
            }

            if(isset($direktur))
            {
                $data->direktur = $direktur->nik .' - '. $direktur->name;
            }

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalTrainingBill description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalTrainingBill(Request $request)
    {
        if($request->ajax())
        {
            $data       = Training::where('id', $request->foreign_id)->first();
            $atasan     = User::where('id', $data->approved_atasan_id)->first();
            $direktur   = User::where('id', $data->approve_direktur_id)->first();
            
            $data->atasan = "";

            if(!empty($data->user->empore_organisasi_staff_id))
            {
                $data->jenis_karyawan = 'staff';
            }

            if(empty($data->user->empore_organisasi_staff_id) and !empty($data->user->empore_organisasi_manager_id))
            {
                $data->jenis_karyawan = 'manager';
            }

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
            }

            if(isset($direktur))
            {
                $data->direktur = $direktur->nik .' - '. $direktur->name;
            }

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingTrainingGaDepartment(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'training_mengetahui';
            $data->user_id      = $request->id;
            $data->nama_approval= 'GA Department';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingOvertimeManagerDepartment(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'overtime';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Manager Department';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingExitHRD(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'exit_clearance';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HRD';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingExitGA(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'exit_clearance';
            $data->user_id      = $request->id;
            $data->nama_approval= 'GA';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingExitIT(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'exit_clearance';
            $data->user_id      = $request->id;
            $data->nama_approval= 'IT';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingExitAccounting(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'exit_clearance';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Accounting';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingTrainingHRD(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'training';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HRD';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

     /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingTrainingFinance(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'training';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Finance';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingOvertimeHrOperation(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'overtime';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR Operation';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingExitHrDirector(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'exit';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR Director';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingExitHRGM description]
     * @param Request $request [description]
     */
    public function addSettingExitHRGM(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'exit';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR GM';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingExitHrManager description]
     * @param Request $request [description]
     */
    public function addSettingExitHrManager(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'exit';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR Manager';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerHR description]
     * @param Request $request [description]
     */
    public function addSettingOvertimeManagerHR(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'overtime';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Manager HR';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingMedicalGMHR description]
     * @param Request $request [description]
     */
    public function addSettingMedicalGMHR(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'medical';
            $data->user_id      = $request->id;
            $data->nama_approval= 'GM HR';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingMedicalManagerHR description]
     * @param Request $request [description]
     */
    public function addSettingMedicalManagerHR(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'medical';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Manager HR';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingMedicalHRBenefit description]
     * @param Request $request [description]
     */
    public function addSettingMedicalHRBenefit(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'medical';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR Benefit';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addInvetarisMobil description]
     * @param Request $request [description]
     */
    public function addInvetarisMobil(Request $request)
    {
        if($request->ajax())
        {
            $data               = new UserInvetarisMobil();
            $data->user_id      = $request->user_id;
            $data->tipe_mobil   = $request->tipe_mobil;
            $data->tahun        = $request->tahun;
            $data->no_polisi    = $request->no_polisi;
            $data->status_mobil = $request->status_mobil;
            $data->save();
            
            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addtSettingPaymentRequestApproval description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingPaymentRequestApproval(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'payment_request';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Approval';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }


    /**
     * [addtSettingPaymentRequestApproval description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingPaymentRequestVerification(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'payment_request';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Verification';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }


    /**
     * [addtSettingPaymentRequestApproval description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingPaymentRequestPayment(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'payment_request';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Payment';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addtSettingCutiPersonalia description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingCutiPersonalia(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'cuti';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Personalia';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addtSettingCutiAtasan description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingCutiAtasan(Request $request)
    {
        if($request->ajax())
        {
            $data               = new SettingApproval();
            $data->jenis_form   = 'cuti';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Atasan';
            $data->save();
            
            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getKaryawanById description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getKaryawanById(Request $request)
    {
        if($request->ajax())
        {
            $data = User::where('id', $request->id)->first();

            $data->department_name  = isset($data->department) ? $data->department->name : '';
            $data->cabang_name      = isset($data->cabang->name) ? $data->cabang->name : '';

            $data->dependent    = UserFamily::where('user_id', $data->id)->get();
            $data->jabatan      = empore_jabatan($request->id);

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getKabupateByProvinsi description]
     * @return [type] [description]
     */
    public function getKabupatenByProvinsi(Request $request)
    {
        if($request->ajax())
        {
            $kabupaten = Kabupaten::where('id_prov', $request->id)->get();

            return response()->json(['message' => 'success', 'data' => $kabupaten]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getKecamatanByKabupaten description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getKecamatanByKabupaten(Request $request)
    {
        if($request->ajax())
        {
            $kabupaten = Kecamatan::where('id_kab', $request->id)->get();

            return response()->json(['message' => 'success', 'data' => $kabupaten]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getKelurahanByKecamatan description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getKelurahanByKecamatan(Request $request)
    {
        if($request->ajax())
        {
            $kabupaten = Kelurahan::where('id_kec', $request->id)->get();

            return response()->json(['message' => 'success', 'data' => $kabupaten]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getDivisionByDirectorate description]
     * @return [type] [description]
     */
    public function getDepartmentByDivision(Request $request)
    {
        if($request->ajax())
        {
            $data = Department::where('division_id', $request->id)->get();
        
            return response()->json(['message'=> 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getDepartmentByDivision description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getSectionByDepartment(Request $request)
    {
        if($request->ajax())
        {
            $data = Section::where('department_id', $request->id)->get();
        
            return response()->json(['message'=> 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getDivisionByDirectorate description]
     * @return [type] [description]
     */
    public function getDivisionByDirectorate(Request $request)
    {
        if($request->ajax())
        {
            $data = Division::where('directorate_id', $request->id)->get();
        
            return response()->json(['message'=> 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getStructureBranch description]
     * @return [type] [description]
     */
    public function getStructureBranch()
    {
        foreach(BranchHead::all() as $k => $item)
        {
            $data[$k]['name'] = 'Head';
            $data[$k]['title'] = $item->name;
            $data[$k]['children'] = [];

            foreach(BranchStaff::where('branch_head_id', $item->id)->get() as $k2 => $i2)
            {
                $data[$k]['children'][$k2]['title'] = $i2->name;
                $data[$k]['children'][$k2]['name'] = 'Staff';
            }
        }

        return response()->json($data);
    }

    /**
     * [getStructure description]
     * @return [type] [description]
     */
    public function getStructure()
    {
        $data = [];

        $directorate = EmporeOrganisasiDirektur::all();
        foreach($directorate as $key_dir => $dir)
        {
            $data['name'] = 'Director';
            $data['title'] = $dir->name;
            $data['children'] = [];

            $num_key_div = 0;
            foreach(EmporeOrganisasiManager::where('empore_organisasi_direktur_id', $dir->id)->get() as $key_div => $div)
            {
                $data['children'][$key_div]['name'] = 'Manager';
                $data['children'][$key_div]['title'] = $div->name;

                foreach(EmporeOrganisasiStaff::where('empore_organisasi_manager_id', $div->id)->get() as $key_dept => $dept)
                {
                    $data['children'][$key_div]['children'][$key_dept]['name'] = 'Staff';
                    $data['children'][$key_div]['children'][$key_dept]['title'] = $dept->name;
                }
                
                $num_key_div++;
            }
        }

        return response()->json($data);
    } 

    /**
     * Get structure custom
     * @return json
     */
    public function getStructureCustome()
    {
        $data = structure_custom();

        return json_encode($data);
    } 
}