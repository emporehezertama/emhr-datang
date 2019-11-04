<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiDirectorate;

class DivisionController extends Controller
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
            $params['data'] = OrganisasiDivision::join('users','users.id','=','organisasi_division.user_created')->where('users.project_id', $user->project_id)->select('organisasi_division.*')->get();
        }else{
            $params['data'] = OrganisasiDivision::all();
        }

        return view('administrator.division.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.division.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = OrganisasiDivision::where('id', $id)->first();
        return view('administrator.division.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                               = OrganisasiDivision::where('id', $id)->first();
        $data->name                         = $request->name;
        $data->save();

        return redirect()->route('administrator.division.index')->with('message-success', 'Data successfully saved');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = OrganisasiDivision::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.division.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                               = new OrganisasiDivision();
        $data->name                         = $request->name;
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        } 
        $data->save();

        return redirect()->route('administrator.division.index')->with('message-success', 'Data successfully saved!');
    }
}
