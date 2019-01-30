<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $params['data'] = \App\CutiBersama::orderBy('id', 'DESC')->get();

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
        $params['data']         = \App\CutiBersama::where('id', $id)->first();

        return view('administrator.cuti-bersama.edit')->with($params);
    }
    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\CutiBersama::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.cuti-bersama.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new \App\CutiBersama();
        $data->dari_tanggal     = $request->dari_tanggal;
        $data->sampai_tanggal   = $request->sampai_tanggal;
        $data->total_cuti       = $request->total_cuti;
        $data->save();

        // minus cuti bersama semua karyawan
        $cuti_karyawan = \App\UserCuti::where('cuti_id', 1)->get();
        foreach($cuti_karyawan as $item)
        {
            // update cuti karyawan
             $cuti          = \App\UserCuti::where('id', $item->id)->first();
             $cuti->kuota   = $item->kuota - $request->total_cuti;
             $cuti->save();

             // save history karyawan
             $history                       = new \App\CutiBersamaHistoryKaryawan();
             $history->user_id              = $item->user_id;
             $history->cuti_bersama_id      = $data->id;
             $history->cuti_bersama_old     = $item->kuota;
             $history->cuti_bersama_new     = $item->kuota - $request->total_cuti;
             $history->save();
        }

        return redirect()->route('administrator.bank.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
