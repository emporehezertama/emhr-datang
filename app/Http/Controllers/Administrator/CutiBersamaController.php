<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CutiBersama;
use App\Models\UserCuti;
use App\Models\CutiBersamaHistoryKaryawan;

class CutiBersamaController extends Controller
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
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['data'] = CutiBersama::orderBy('cuti_bersama.id', 'DESC')->join('users','users.id','=','cuti_bersama.user_created')->where('users.project_id', $user->project_id)->select('cuti_bersama.*')->get();
        }else{
            $params['data'] = CutiBersama::orderBy('id', 'DESC')->get();
        }
        return view('administrator.cuti-bersama.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.cuti-bersama.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = CutiBersama::where('id', $id)->first();

        return view('administrator.cuti-bersama.edit')->with($params);
    }
    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = CutiBersama::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.cuti-bersama.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new CutiBersama();
        $data->dari_tanggal     = $request->dari_tanggal;
        $data->sampai_tanggal   = $request->sampai_tanggal;
        $data->total_cuti       = $request->total_cuti;

        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        } 
        $data->save();

        // minus cuti bersama semua karyawan
        if($user->project_id != NULL)
        {
            $cuti_karyawan = UserCuti::join('users','users.id','=','user_cuti.user_id')->where('user_cuti.cuti_id', 1)->where('users.project_id', $user->project_id)->select('user_cuti.*')->get();
        }else{
            $cuti_karyawan = UserCuti::where('cuti_id', 1)->get();
        }
        
        foreach($cuti_karyawan as $item)
        {
            // update cuti karyawan
             $cuti          = UserCuti::where('id', $item->id)->first();
             $cuti->kuota   = $item->kuota - $request->total_cuti;
             $cuti->save();

             // save history karyawan
             $history                       = new CutiBersamaHistoryKaryawan();
             $history->user_id              = $item->user_id;
             $history->cuti_bersama_id      = $data->id;
             $history->cuti_bersama_old     = $item->kuota;
             $history->cuti_bersama_new     = $item->kuota - $request->total_cuti;
             $history->save();
        }

        return redirect()->route('administrator.cuti-bersama.index')->with('message-success', 'Data successfully saved!');
    }
}
