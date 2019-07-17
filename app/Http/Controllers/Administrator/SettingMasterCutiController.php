<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\User;
use App\Models\UserCuti;

class SettingMasterCutiController extends Controller
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
            $params['data'] = Cuti::orderBy('cuti.id', 'DESC')->join('users','users.id','=','cuti.user_created')->where('users.project_id', $user->project_id)->select('cuti.*')->get();
        }else{
            $params['data'] = Cuti::orderBy('id', 'DESC')->get();
        }
        return view('administrator.setting-master-cuti.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.setting-master-cuti.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = Cuti::where('id', $id)->first();

        return view('administrator.setting-master-cuti.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = Cuti::where('id', $id)->first();
        $data->jenis_cuti       = $request->jenis_cuti; 
        $data->description       = $request->description;
        $data->kuota            = $request->kuota;
        $data->save();

        return redirect()->route('administrator.setting-master-cuti.index')->with('message-success', 'Data successfully saved');
    }   

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $data = Cuti::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-master-cuti.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Cuti::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-master-cuti.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data               = new Cuti();
        $data->jenis_cuti   = $request->jenis_cuti;
        $data->kuota        = $request->kuota;
        $data->description  = $request->description;

        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        } 
        $data->save();

        if($data->jenis_cuti == 'Leave')
        {
            if($user->project_id != NULL)
            {
                $dataUser = User::whereIn('access_id',[1,2])->whereNull('resign_date')->where('project_id',$user->project_id)->get();
            }else{
                $dataUser = User::whereIn('access_id',[1,2])->whereNull('resign_date')->get();
            }
            foreach ($dataUser as $key => $value) {
                # code...
                $userCuti = UserCuti::where('user_id',$value->id)->where('cuti_id',$data->id)->first();
                if(!$userCuti)
                {
                    $c = new UserCuti();
                    $c->user_id     = $value->id;
                    $c->cuti_id     = $data->id;
                    $c->kuota       = $data->kuota;
                    $c->sisa_cuti   = $data->kuota;
                    $c->save();
                }
            }
        }

        return redirect()->route('administrator.setting-master-cuti.index')->with('message-success', 'Data successfully saved !');
    }
}
