<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use App\Directorate;

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
        $params['department']       = \App\Department::where('division_id', $params['data']['division_id'])->get();
        $params['provinces']        = \App\Provinsi::all();
        $params['dependent']        = \App\UserFamily::where('user_id', \Auth::user()->id)->first();
        $params['education']        = \App\UserEducation::where('user_id', \Auth::user()->id)->first();
        $params['kabupaten']        = \App\Kabupaten::where('id_prov', $params['data']['provinsi_id'])->get();
        $params['kecamatan']        = \App\Kecamatan::where('id_kab', $params['data']['kabupaten_id'])->get();
        $params['kelurahan']        = \App\Kelurahan::where('id_kec', $params['data']['kecamatan_id'])->get();
        $params['division']         = \App\Division::all();
        $params['section']          = \App\Section::where('division_id', $params['data']['division_id'])->get();
        $params['news']             = \App\News::where('status', 1)->orderBy('id', 'DESC')->limit(4)->get();
        $params['internal_memo']    = \App\InternalMemo::orderBy('id', 'DESC')->limit(5)->get();
        $params['peraturan_perusahaan']    = \App\PeraturanPerusahaan::orderBy('id', 'DESC')->limit(5)->get();
        $params['ulang_tahun']      = \App\User::whereMonth('tanggal_lahir', date('m'))->whereDay('tanggal_lahir', date('d'))->get();

        $data = User::orderBy('name', 'ASC')->limit(1); 

        if(isset($_GET['name']))
        {
            $data = $data->where('name', 'LIKE', '%'. $_GET['name'] .'%');

            if(!empty($_GET['name']))
            {
                $related            = new \App\RelatedSearchKaryawan();
                $related->user_id   = \Auth::user()->id;
                $related->keyword   = $_GET['name'];
                $related->save();
            }
        }
        else
        {
            $related = \App\RelatedSearchKaryawan::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->first();

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
        $params['data'] = \App\RequestPaySlip::where('user_id', \Auth::user()->id)->get();

        return view('karyawan.request-pay-slip')->with($params);
    }

    /**
     * [profile description]
     * @return [type] [description]
     */
    public function profile()
    {
        $params['data'] = User::where('id', \Auth::user()->id)->first();
        $params['department']       = \App\Department::where('division_id', $params['data']['division_id'])->get();
        $params['provinces']        = \App\Provinsi::all();
        $params['dependent']        = \App\UserFamily::where('user_id', \Auth::user()->id)->first();
        $params['education']        = \App\UserEducation::where('user_id', \Auth::user()->id)->first();
        $params['kabupaten']        = \App\Kabupaten::where('id_prov', $params['data']['provinsi_id'])->get();
        $params['kecamatan']        = \App\Kecamatan::where('id_kab', $params['data']['kabupaten_id'])->get();
        $params['kelurahan']        = \App\Kelurahan::where('id_kec', $params['data']['kecamatan_id'])->get();
        $params['division']         = \App\Division::all();
        $params['section']          = \App\Section::where('division_id', $params['data']['division_id'])->get();

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
        $params['data'] = \App\News::where('id', $id)->first();
        $params['news_list_right'] = \App\News::orderBy('id', 'DESC')->limit(10)->get();

        return view('karyawan.news.readmore')->with($params);
    }

    /**
     * [downloadInternalMemo description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function downloadInternalMemo($id)
    {   
        $im = \App\InternalMemo::where('id', $id)->first();
        
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
        $im = \App\PeraturanPerusahaan::where('id', $id)->first();
        
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
        $params['list'] = \App\News::orderBy('id', 'DESC')->get();
        $params['news_list_right'] = \App\News::orderBy('id', 'DESC')->get();

        if(isset($_GET['keyword-news']) and !empty($_GET['keyword-news']))
        {
            $params['news_list_right'] = \App\News::where('title', 'LIKE', '%'. $_GET['keyword-news'] .'%')->orderBy('id', 'DESC')->get();
        }

        return view('karyawan.morenews')->with($params);
    }

    /**
     * [internalMemoMore description]
     * @return [type] [description]
     */
    public function internalMemoMore()
    {
        $params['data'] = \App\InternalMemo::orderBy('id', 'DESC')->get();
        $params['internal_memo']    = \App\InternalMemo::orderBy('id', 'DESC')->get();
        $params['peraturan_perusahaan']    = \App\PeraturanPerusahaan::orderBy('id', 'DESC')->get();

        if(isset($_GET['keyword-internal-memo']) and !empty($_GET['keyword-internal-memo']))
        {
            $params['internal_memo'] = \App\InternalMemo::where('title', 'LIKE', '%'. $_GET['keyword-internal-memo'] .'%')->orderBy('id', 'DESC')->get();
        }

        if(isset($_GET['keyword-peraturan']) and !empty($_GET['keyword-peraturan']))
        {
            $params['peraturan_perusahaan'] = \App\PeraturanPerusahaan::where('title', 'LIKE', '%'. $_GET['keyword-peraturan'] .'%')->orderBy('id', 'DESC')->get();
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
