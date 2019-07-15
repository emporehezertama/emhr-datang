<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InternalMemo;

class InternalMemoController extends Controller
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
            $params['data'] = InternalMemo::orderBy('id', 'DESC')->join('users','users.id','=','internal_memo.user_created')->where('users.project_id', $user->project_id)->select('internal_memo.*')->get();
        } else
        {
            $params['data'] = InternalMemo::orderBy('id', 'DESC')->get();
        }
        return view('administrator.internal-memo.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.internal-memo.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = InternalMemo::where('id', $id)->first();

        return view('administrator.internal-memo.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = InternalMemo::where('id', $id)->first();
        $data->title            = $request->title;
        $data->content            = $request->content;
        $data->status            = $request->status;
        
        if (request()->hasFile('thumbnail'))
        {

            $file = $request->file('thumbnail');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/internal-memo/');
            $file->move($destinationPath, $fileName);

            \Image::make(public_path('storage/internal-memo/'. $fileName))->fit(100, 70)->save(public_path('storage/internal-memo/'. $fileName));

            $data->thumbnail = $fileName;
        }

        if (request()->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/internal-memo/');
            $file->move($destinationPath, $fileName);

            $data->image = $fileName;
        }

        if (request()->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/internal-memo/');
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }

        $data->save();

        return redirect()->route('administrator.internal-memo.index')->with('message-success', 'Data successfully saved !');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = InternalMemo::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.internal-memo.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new InternalMemo();
        $data->title            = $request->title;
        $data->content          = $request->content;
        $data->status           = $request->status;
        
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        }

        if (request()->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/internal-memo/');
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }


        if (request()->hasFile('thumbnail'))
        {
            $file = $request->file('thumbnail');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/internal-memo/');
            $file->move($destinationPath, $fileName);

            \Image::make(public_path('storage/internal-memo/'. $fileName))->fit(100, 70)->save(public_path('storage/internal-memo/'. $fileName));

            $data->thumbnail = $fileName;
        }
        
        if (request()->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/internal-memo/');
            $file->move($destinationPath, $fileName);

            $data->image = $fileName;
        }


        $data->save();
    //    echo $data->image;

        return redirect()->route('administrator.internal-memo.index')->with('message-success', 'Data successfully saved !');
    }
}
