<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\AssetTracking;

class AssetController extends Controller
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
            $data   = Asset::orderBy('asset.id', 'DESC')->join('users','users.id','=','asset.user_id')->where('users.project_id', $user->project_id)->select('asset.*');
        }else {
            $data   = Asset::orderBy('id', 'DESC');
        }

        if(isset($_GET['asset_type_id']))
        {
            if(!empty($_GET['asset_type_id']))
            {
                $data = $data->where('asset_type_id', $_GET['asset_type_id']);
            }

            if(!empty($_GET['asset_condition']))
            {
                $data = $data->where('asset_condition', $_GET['asset_condition']);
            }

            if(!empty($_GET['assign_to']))
            {
                $data = $data->where('assign_to', $_GET['assign_to']);
            }
        }

        $params['data'] = $data->paginate(50);

        return view('administrator.asset.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['asset_type']       = AssetType::all();
        $params['asset_number']     = $this->asset_number();
        
        return view('administrator.asset.create')->with($params);
    }

    /**
     * [asset_number description]
     * @return [type] [description]
     */
    public function asset_number()
    {
        $no = 0;

        $count = Asset::count()+1;

        if(strlen($count) == 1)
        {
            $no = "000". $count;
        }

        if(strlen($count) == 2)
        {
            $no = "00". $count;
        }

        if(strlen($count) == 3)
        {
            $no = "0". $count;
        }

        if(strlen($count) == 4)
        {
            $no = $count;
        }

        return $no;
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = Asset::where('id', $id)->first();
        $params['asset_type']       = AssetType::all();
        $params['asset_number']     = $this->asset_number();

        return view('administrator.asset.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = Asset::where('id', $id)->first();
        $data->asset_name       = $request->asset_name;
        $data->asset_type_id    = $request->asset_type_id;
        $data->asset_sn         = $request->asset_sn;
        $data->purchase_date    = date('Y-m-d', strtotime($request->purchase_date));
        $data->asset_condition  = $request->asset_condition;
        $data->assign_to        = $request->assign_to;
        $data->handover_date    = NULL;
        //$data->tipe_mobil       = $request->tipe_mobil;
        //$data->tahun            = $request->tahun;
        //$data->no_polisi        = $request->no_polisi;
        $data->status_mobil     = $request->status_mobil;
        $data->remark           = $request->remark;
        //$data->rental_date      = $request->rental_date;
        $data->user_id          = $request->user_id;
        $data->save();

        $tracking                   = new AssetTracking();
        $tracking->asset_number     = $data->asset_number; 
        $tracking->asset_name       = $data->asset_name;
        $tracking->asset_type_id    = $data->asset_type_id;
        $tracking->asset_sn         = $data->asset_sn;
        $tracking->purchase_date    = date('Y-m-d', strtotime($data->purchase_date));
        $tracking->asset_condition  = $data->asset_condition;
        $tracking->assign_to        = $data->assign_to;
        $tracking->user_id          = $data->user_id;
        $tracking->asset_id         = $data->id;
        //$data->tipe_mobil           = $request->tipe_mobil;
        //$data->tahun                = $request->tahun;
        //$data->no_polisi            = $request->no_polisi;
        $data->status_mobil         = $request->status_mobil;
        $data->remark           = $request->remark;
        //$data->rental_date      = $request->rental_date;
        $tracking->save();

        $params['data']         = Asset::where('id', $data->id)->first();

        if($data->user->email != "")
        {
            \Mail::send('administrator.asset.acceptance-email', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Asset Acceptance Confirmation');
                }
            );
        }

        return redirect()->route('administrator.asset.index')->with('message-success', 'Data saved successfully');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Asset::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.asset.index')->with('message-sucess', 'Data deleted successfully');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new Asset();
        $data->asset_number     = $request->asset_number; 
        $data->asset_name       = $request->asset_name;
        $data->asset_type_id    = $request->asset_type_id;
        $data->asset_sn         = $request->asset_sn;
        $data->purchase_date    = date('Y-m-d', strtotime($request->purchase_date));
        $data->asset_condition  = $request->asset_condition;
        $data->assign_to        = $request->assign_to;
        $data->user_id          = $request->user_id;
        //$data->tipe_mobil       = $request->tipe_mobil;
        //$data->tahun            = $request->tahun;
        //$data->no_polisi        = $request->no_polisi;
        $data->status_mobil     = $request->status_mobil;
        $data->remark           = $request->remark;
        //$data->rental_date      = $request->rental_date;
        $data->save();

        $tracking                   = new AssetTracking();
        $tracking->asset_name       = $data->asset_name;
        $tracking->asset_type_id    = $data->asset_type_id;
        $tracking->asset_sn         = $data->asset_sn;
        $tracking->purchase_date    = date('Y-m-d', strtotime($data->purchase_date));
        $tracking->asset_condition  = $data->asset_condition;
        $tracking->assign_to        = $data->assign_to;
        $tracking->user_id          = $data->user_id;
        $tracking->asset_id         = $data->id;
        //$data->tipe_mobil           = $request->tipe_mobil;
        //$data->tahun                = $request->tahun;
        //$data->no_polisi            = $request->no_polisi;
        $data->status_mobil         = $request->status_mobil;
        $data->remark               = $request->remark;
        //$data->rental_date          = $request->rental_date;
        $tracking->save();
        
        $params['data']         = Asset::where('id', $data->id)->first();

        if($data->user->email != "")
        {
            \Mail::send('administrator.asset.acceptance-email', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Asset Acceptance Confirmation');
                }
            );
        }
        return redirect()->route('administrator.asset.index')->with('message-success', 'Data saved successfully !');
    }
}
