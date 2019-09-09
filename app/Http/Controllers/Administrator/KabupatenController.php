<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kabupaten;

class KabupatenController extends Controller
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
        $params['data'] = Kabupaten::orderBy('nama', 'ASC')->get();

        return view('administrator.kabupaten.index')->with($params);
    }

    /**
     * Store 
     * @param  Request $request
     * @return redirect
     */
    public function store(Request $request)
    {
        $data               = new Kabupaten();
        $data->nama         = $request->nama;
        $data->id_prov      = $request->provinsi_id;
        $data->save();
        
        return redirect()->route('administrator.kabupaten.index')->with('message-success', \Lang::get('setting.kabupaten-message-success'));
    }

    /**
     * Update Store
     * @param  Request $request
     */
    public function update(Request $request, $id)
    {
        $data           = Kabupaten::where('id_kab', $id)->first();
        $data->nama     = $request->nama;
        $data->id_prov  = $request->provinsi_id;
        $data->save();
        
        return redirect()->route('administrator.kabupaten.index')->with('message-success', \Lang::get('setting.kabupaten-message-success'));
    }

    /**
     * Destroy
     * @return redirect
     */
    public function destroy($id)
    {
        $data = Kabupaten::where('id_kab', $id)->delete();

        return redirect()->route('administrator.kabupaten.index')->with('message-success', \Lang::get('setting.kabupaten-message-delete'));
    } 
}