<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use App\Models\ProvinsiDetailAllowance;

class ProvinsiController extends Controller
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
        $params['data'] = Provinsi::orderBy('nama', 'ASC')->get();

        return view('administrator.provinsi.index')->with($params);

    }

    /**
     * Store 
     * @param  Request $request
     * @return redirect
     */
    public function store(Request $request)
    {
        $data = new Provinsi();
        $data->nama = $request->nama;
        $data->type = $request->type;
        $data->project_id = \Auth::user()->project_id;
        $data->save();
        
        return redirect()->route('administrator.provinsi.index')->with('message-success', \Lang::get('setting.provinsi-message-success'));
    }

    /**
     * Update Store
     * @param  Request $request
     */
    public function update(Request $request, $id)
    {
        if(\Auth::user()->project_id == 1){
            $data = Provinsi::where('id_prov', $id)->first();
            $data->nama = $request->nama;
            $data->save();

        }
        
        $check = ProvinsiDetailAllowance::where('project_id', \Auth::user()->project_id)->where('id_prov', $id)->count();
        if($check < 1){
            $data = new ProvinsiDetailAllowance();
            $data->id_prov = $id;
            $data->type = $request->type;
            $data->project_id = \Auth::user()->project_id;
            $data->save(); 
        }else{
            $data = ProvinsiDetailAllowance::where('project_id', \Auth::user()->project_id)->where('id_prov', $id)->first();
            $data->type = $request->type;
            $data->save();
        }
        
        return redirect()->route('administrator.provinsi.index')->with('message-success', \Lang::get('setting.provinsi-message-success'));
    }

    /**
     * Destroy
     * @return redirect
     */
    public function destroy($id)
    {
        $data = Provinsi::where('id_prov', $id)->delete();

        return redirect()->route('administrator.provinsi.index')->with('message-sucess', \Lang::get('setting.provinsi-message-delete'));
    } 
}
