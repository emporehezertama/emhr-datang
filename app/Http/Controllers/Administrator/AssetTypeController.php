<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AssetType;

class AssetTypeController extends Controller
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
            $params['data'] = AssetType::where('project_id', $user->project_id)->orderBy('id', 'ASC')->get();
        }else{
            $params['data'] = AssetType::orderBy('id', 'ASC')->get();
        }

        return view('administrator.asset-type.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.asset-type.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = AssetType::where('id', $id)->first();

        return view('administrator.asset-type.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                       = AssetType::where('id', $id)->first();
        $data->name                 = $request->name;
        $data->pic_department       = $request->pic_department; 
        $data->save();

        return redirect()->route('administrator.asset-type.index')->with('message-success', 'Data saved successfully');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = AssetType::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.asset-type.index')->with('message-sucess', 'Data deleted successfully');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                       = new AssetType();
        $data->name                 = $request->name; 
        $data->pic_department       = $request->pic_department;
        $data->project_id           = \Auth::user()->project_id;
        $data->save();

        return redirect()->route('administrator.asset-type.index')->with('message-success', 'Data saved successfully !');
    }
}
