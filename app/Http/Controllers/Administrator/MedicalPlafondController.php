<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalType;
use App\Models\MedicalPlafond;
use App\Models\OrganisasiPosition;


class MedicalPlafondController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['type']      = MedicalType::join('users','users.id','=','medical_type.user_created')->where('users.project_id', $user->project_id)->select('medical_type.*')->get();
            $params['plafond']   = MedicalPlafond::join('users','users.id','=','medical_plafond.user_created')->where('users.project_id', $user->project_id)->select('medical_plafond.*')->get();
        }else{
            $params['type']      = MedicalType::all();
            $params['plafond']   = MedicalPlafond::all();
        }

        return view('administrator.medical-plafond.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('administrator.medical-plafond.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = new MedicalType();
        $data->name            = $request->name;
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        } 
        $data->save();

        return redirect()->route('administrator.medical-plafond.index')->with('message-success', 'Data successfully saved');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $params['data'] = MedicalType::where('id', $id)->first();
        return view('administrator.medical-plafond.edit')->with($params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = MedicalType::where('id', $id)->first();
        $data->name            = $request->name;
        $data->save();

        return redirect()->route('administrator.medical-plafond.index')->with('message-success', 'Data successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = MedicalType::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.medical-plafond.index')->with('message-success', 'Data successfully deleted');
    }
     /**
     * [create description]
     * @return [type] [description]
     */
    public function createMedicalPlafond()
    {
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['type'] = MedicalType::join('users','users.id','=','medical_type.user_created')->where('users.project_id', $user->project_id)->select('medical_type.*')->get();
            $params['position'] = OrganisasiPosition::join('users','users.id','=','organisasi_position.user_created')->where('users.project_id', $user->project_id)->select('organisasi_position.*')->get();
        }else{
            $params['type'] = MedicalType::all();
            $params['position'] = OrganisasiPosition::all();
        }
        
        return view('administrator.medical-plafond.createPlafond')->with($params);
    }

    public function storeMedicalPlafond(Request $request)
    {
        $data = new MedicalPlafond();
        $data->medical_type_id     = $request->medical_type_id;
        $data->position_id         = $request->position_id;
        $data->nominal             = $request->nominal;
        $data->description         = $request->description;
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        } 
        $data->save();

        return redirect()->route('administrator.medical-plafond.index')->with('message-success', 'Data successfully saved');
    }

    public function editMedicalPlafond($id)
    {
        $params['data'] = MedicalPlafond::where('id', $id)->first();
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['type'] = MedicalType::join('users','users.id','=','medical_type.user_created')->where('users.project_id', $user->project_id)->select('medical_type.*')->get();
            $params['position'] = OrganisasiPosition::join('users','users.id','=','organisasi_position.user_created')->where('users.project_id', $user->project_id)->select('organisasi_position.*')->get();
        }else{
            $params['type'] = MedicalType::all();
            $params['position'] = OrganisasiPosition::all();
        }
        return view('administrator.medical-plafond.editPlafond')->with($params);
    }

    public function updateMedicalPlafond(Request $request, $id)
    {
        $data = MedicalPlafond::where('id', $id)->first();
        $data->nominal       = $request->nominal;
        $data->description   = $request->description;
        $data->medical_type_id     = $request->medical_type_id;
        $data->position_id         = $request->position_id;
        $data->save();

        return redirect()->route('administrator.medical-plafond.index')->with('message-success', 'Data successfully saved');
    }

     /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteMedicalPlafond($id)
    {
        $data = MedicalPlafond::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.medical-plafond.index')->with('message-success', 'Data successfully deleted');
    } 
}
