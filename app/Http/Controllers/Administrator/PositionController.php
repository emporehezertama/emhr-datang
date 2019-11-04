<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrganisasiPosition;
use App\Models\OrganisasiDirectorate;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiDepartment;
use App\Models\OrganisasiUnit;

class PositionController extends Controller
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
            $params['data'] = OrganisasiPosition::orderBy('organisasi_position.id', 'DESC')->join('users','users.id','=','organisasi_position.user_created')->where('users.project_id', $user->project_id)->select('organisasi_position.*')->get();
        }else{
            $params['data'] = OrganisasiPosition::orderBy('id', 'DESC')->get();
        }
        return view('administrator.position.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.position.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = OrganisasiPosition::where('id', $id)->first();
        return view('administrator.position.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = OrganisasiPosition::where('id', $id)->first();
        $data->name                                 = $request->name;
        $data->save();

        return redirect()->route('administrator.position.index')->with('message-success', 'Data successfully saved');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = OrganisasiPosition::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.position.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new OrganisasiPosition();
        $data->name                         = $request->name;
        
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        } 

        $data->save();

        return redirect()->route('administrator.position.index')->with('message-success', 'Data successfully saved!');
    }
}
