<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Provinsi;

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
     * @r  eturn \Illuminate\Http\Response
     */
    public function index()
    {
        $user   =   \Auth::user();

        if($user->project_id != Null){
            $params['data'] = Provinsi::orderBy('nama', 'ASC')->get();

        /*    foreach($provinsi as $prov){
                $params['data'] = Provinsi::join('provinsi_detail_allowance', 'provinsi.id_prov', '=', 'provinsi_detail_allowance.id_prov')
                                     //   ->where('provinsi.project_id', $user->project_id)
                                        ->where('provinsi.id_prov', $prov->id_prov)
                                        ->orderBy('provinsi.nama', 'ASC')
                                        ->get();
                
            echo dd(json_encode($prov)); 
                                        
        }   */
            
        }else{
            $params['data'] = Provinsi::orderBy('nama', 'ASC')->get();
        }

        
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
        $data = Provinsi::where('id_prov', $id)->first();
        $data->type = $request->type;
        $data->save();
        
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
