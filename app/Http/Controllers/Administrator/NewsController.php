<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     
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
        //$params['data'] = \App\News::where('status', 1)->orderBy('id', 'DESC')->get();
        $params['data'] = \App\News::orderBy('id', 'DESC')->get();

        return view('administrator.news.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.news.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = \App\News::where('id', $id)->first();

        return view('administrator.news.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = \App\News::where('id', $id)->first();
        $data->title            = $request->title;
        $data->content          = $request->content;
        $data->status           = $request->status;

        if (request()->hasFile('thumbnail'))
        {

            $file = $request->file('thumbnail');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/news/');
            $file->move($destinationPath, $fileName);

            \Image::make(public_path('storage/news/'. $fileName))->fit(100, 70)->save(public_path('storage/news/'. $fileName));

            $data->thumbnail = $fileName;
        }

        if (request()->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/news/');
            $file->move($destinationPath, $fileName);

            $data->image = $fileName;
        }

        $data->save();

        return redirect()->route('administrator.news.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\News::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.news.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new \App\News();
        $data->title            = $request->title;
        $data->content          = $request->content;
        $data->status           = $request->status;
        
        if (request()->hasFile('thumbnail'))
        {
            $file = $request->file('thumbnail');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/news/');
            $file->move($destinationPath, $fileName);

            \Image::make(public_path('storage/news/'. $fileName))->fit(100, 70)->save(public_path('storage/news/'. $fileName));

            $data->thumbnail = $fileName;
        }
        
        if (request()->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/news/');
            $file->move($destinationPath, $fileName);

            $data->image = $fileName;
        }

        $data->save();

        return redirect()->route('administrator.news.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
