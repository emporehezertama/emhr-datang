<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use App\Models\OrganisasiDirectorate;
use App\Models\OrganisasiDepartment;
use App\Models\Provinsi;
use App\Models\UserFamily;
use App\Models\UserEducation;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiSection;
use App\Models\News;
use App\Models\InternalMemo;
use App\Models\PeraturanPerusahaan;
use App\Models\RelatedSearchKaryawan;
use App\Models\RequestPaySlip;

class IndexController extends Controller
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
        $params['data'] = User::where('id', \Auth::user()->id)->first();
        $params['department']       = OrganisasiDepartment::where('organisasi_division_id', $params['data']['division_id'])->get();
        $params['provinces']        = Provinsi::all();
        $params['dependent']        = UserFamily::where('user_id', \Auth::user()->id)->first();
        $params['education']        = UserEducation::where('user_id', \Auth::user()->id)->first();
        $params['kabupaten']        = Kabupaten::where('id_prov', $params['data']['provinsi_id'])->get();
        $params['kecamatan']        = Kecamatan::where('id_kab', $params['data']['kabupaten_id'])->get();
        $params['kelurahan']        = Kelurahan::where('id_kec', $params['data']['kecamatan_id'])->get();
        $params['division']         = OrganisasiDivision::all();
        $params['section']          = OrganisasiSection::where('division_id', $params['data']['division_id'])->get();
        $params['news']             = News::where('status', 1)->orderBy('id', 'DESC')->limit(4)->get();
        $params['internal_memo']    = InternalMemo::orderBy('id', 'DESC')->limit(5)->get();
        $params['peraturan_perusahaan']    = PeraturanPerusahaan::orderBy('id', 'DESC')->limit(5)->get();
        $params['ulang_tahun']      = User::whereMonth('tanggal_lahir', date('m'))->whereDay('tanggal_lahir', date('d'))->get();

        $data = User::orderBy('name', 'ASC')->limit(1); 

        if(isset($_GET['name']))
        {
            $data = $data->where('name', 'LIKE', '%'. $_GET['name'] .'%');

            if(!empty($_GET['name']))
            {
                $related            = new RelatedSearchKaryawan();
                $related->user_id   = \Auth::user()->id;
                $related->keyword   = $_GET['name'];
                $related->save();
            }
        }
        else
        {
            $related = RelatedSearchKaryawan::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->first();

            if(isset($related))
            {
                $data = $data->where('name', 'LIKE', '%'. $related->keyword .'%');
            }
        }

        $params['datasearch'] = $data->get();

        if(!isset($_GET['name']) and !isset($_GET['nik']))
        {
            $params['datasearch'] = $data->get();
        }

        return view('karyawan.index')->with($params);
    }

    /**
     * [requestPaySlip description]
     * @return [type] [description]
     */
    public function requestPaySlip()
    {
        $params['data'] = RequestPaySlip::where('user_id', \Auth::user()->id)->get();

        return view('karyawan.request-pay-slip')->with($params);
    }

    /**
     * [profile description]
     * @return [type] [description]
     */
    public function profile()
    {
        $params['data'] = User::where('id', \Auth::user()->id)->first();
        $params['department']       = OrganisasiDepartment::where('organisasi_division_id', $params['data']['division_id'])->get();
        $params['provinces']        = Provinsi::all();
        $params['dependent']        = UserFamily::where('user_id', \Auth::user()->id)->first();
        $params['education']        = UserEducation::where('user_id', \Auth::user()->id)->first();
        $params['kabupaten']        = Kabupaten::where('id_prov', $params['data']['provinsi_id'])->get();
        $params['kecamatan']        = Kecamatan::where('id_kab', $params['data']['kabupaten_id'])->get();
        $params['kelurahan']        = Kelurahan::where('id_kec', $params['data']['kecamatan_id'])->get();
        $params['division']         = OrganisasiDivision::all();
        $params['section']          = OrganisasiSection::where('division_id', $params['data']['division_id'])->get();

        return view('karyawan.profile')->with($params);
    }

    /**
     * [find description]
     * @return [type] [description]
     */
    public function find()
    {       
        $data = User::orderBy('id', 'DESC'); 

        if(isset($_GET['name']))
            $data = $data->where('name', 'LIKE', '%'. $_GET['name'] .'%');

        if(isset($_GET['nik']))
            $data = $data->where('nik', 'LIKE', '%'. $_GET['nik'] .'%');

        $params['data'] = $data->get();

        if(!isset($_GET['name']) and !isset($_GET['nik']))
            $params['data'] = [];

        return view('karyawan.find')->with($params);
    }

    /**
     * [readmore description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function readmore($id)
    {
        $params['data']             = News::where('id', $id)->first();
        $params['news_list_right']  = News::orderBy('id', 'DESC')->limit(10)->get();

        return view('karyawan.news.readmore')->with($params);
    }

    /**
     * [downloadInternalMemo description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function downloadInternalMemo($id)
    {   
        $im = InternalMemo::where('id', $id)->first();
        
        if($im)
        {
            return response()->download(asset('storage/internal-memo/'. $im->file), $im->title .".pdf", ['Content-Type: application/pdf']);
        }
        else
        {
            return redirect()->route('karyawan.dashboard');
        }
    }

    /**
     * [downloadInternalMemo description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function downloadPeraturanPerusahaan($id)
    {   
        $im = PeraturanPerusahaan::where('id', $id)->first();
        
        if($im)
        {
            return response()->download(asset('storage/peraturan-perusahaan/'. $im->file), $im->title .".pdf");
        }
        else
        {
            return redirect()->route('karyawan.dashboard');
        }
    }

    /**
     * [newsmore description]
     * @return [type] [description]
     */
    public function newsmore()
    {
        $params['list']             = News::orderBy('id', 'DESC')->get();
        $params['news_list_right']  = News::orderBy('id', 'DESC')->get();

        if(isset($_GET['keyword-news']) and !empty($_GET['keyword-news']))
        {
            $params['news_list_right'] = News::where('title', 'LIKE', '%'. $_GET['keyword-news'] .'%')->orderBy('id', 'DESC')->get();
        }

        return view('karyawan.morenews')->with($params);
    }

    /**
     * [internalMemoMore description]
     * @return [type] [description]
     */
    public function internalMemoMore()
    {
        $params['data']                 = InternalMemo::orderBy('id', 'DESC')->get();
        $params['internal_memo']        = InternalMemo::orderBy('id', 'DESC')->get();
        $params['peraturan_perusahaan'] = PeraturanPerusahaan::orderBy('id', 'DESC')->get();

        if(isset($_GET['keyword-internal-memo']) and !empty($_GET['keyword-internal-memo']))
        {
            $params['internal_memo'] = InternalMemo::where('title', 'LIKE', '%'. $_GET['keyword-internal-memo'] .'%')->orderBy('id', 'DESC')->get();
        }

        if(isset($_GET['keyword-peraturan']) and !empty($_GET['keyword-peraturan']))
        {
            $params['peraturan_perusahaan'] = PeraturanPerusahaan::where('title', 'LIKE', '%'. $_GET['keyword-peraturan'] .'%')->orderBy('id', 'DESC')->get();
        }

        return view('karyawan.more-internal-memo')->with($params);
    }

    /**
     * [autologin description]
     * @return [type] [description]
     */
    public function backtoadministrator()
    {   
        if(\Session::get('is_login_administrator'))
        {
            \Auth::loginUsingId(4);
        
            return redirect()->route('administrator.dashboard')->with('message-success', 'Welcome Back Administrator');
        }
        else
        {
            return redirect()->route('karyawan.dashboard')->with('message-error', 'Access denied !');
        }
    }
}
