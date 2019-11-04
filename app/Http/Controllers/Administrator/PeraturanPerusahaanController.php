<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PeraturanPerusahaan;

class PeraturanPerusahaanController extends Controller
{
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
            $params['data'] = PeraturanPerusahaan::orderBy('id', 'DESC')->join('users','users.id','=','peraturan_perusahaan.user_created')->where('users.project_id', $user->project_id)->select('peraturan_perusahaan.*')->get();
        } else
        {
            $params['data'] = PeraturanPerusahaan::orderBy('id', 'DESC')->get();
        }
        return view('administrator.peraturan-perusahaan.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.peraturan-perusahaan.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = PeraturanPerusahaan::where('id', $id)->first();

        return view('administrator.peraturan-perusahaan.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = PeraturanPerusahaan::where('id', $id)->first();
        $data->title            = $request->title;
        $data->content            = $request->content;
        $data->status            = $request->status;
        
        if (request()->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/peraturan-perusahaan/');
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }

        if (request()->hasFile('thumbnail'))
        {

            $file = $request->file('thumbnail');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/peraturan-perusahaan/');
            $file->move($destinationPath, $fileName);

            \Image::make(public_path('storage/peraturan-perusahaan/'. $fileName))->fit(100, 70)->save(public_path('storage/peraturan-perusahaan/'. $fileName));

            $data->thumbnail = $fileName;
        }
        
        if (request()->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/peraturan-perusahaan/');
            $file->move($destinationPath, $fileName);

            $data->image = $fileName;
        }


        $data->save();

        return redirect()->route('administrator.peraturan-perusahaan.index')->with('message-success', 'Data successfully saved !');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = PeraturanPerusahaan::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.peraturan-perusahaan.index')->with('message-sucess', 'Data successfully deleted !');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new PeraturanPerusahaan();
        $data->title            = $request->title;
        $data->content          = $request->content;
        $data->status            = $request->status;

        if (request()->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/peraturan-perusahaan/');
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }

        if (request()->hasFile('thumbnail'))
        {
            $file = $request->file('thumbnail');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/peraturan-perusahaan/');
            $file->move($destinationPath, $fileName);

            \Image::make(public_path('storage/peraturan-perusahaan/'. $fileName))->fit(100, 70)->save(public_path('storage/peraturan-perusahaan/'. $fileName));

            $data->thumbnail = $fileName;
        }
        
        if (request()->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/peraturan-perusahaan/');
            $file->move($destinationPath, $fileName);

            $data->image = $fileName;
        }



        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        }else{
            $data->user_created           = "";
        }

        $data->save();

        return redirect()->route('administrator.peraturan-perusahaan.index')->with('message-success', 'Data successfully saved !');
    }
}
