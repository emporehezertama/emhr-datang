<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;

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
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['data'] = News::orderBy('id', 'DESC')->join('users','users.id','=','news.user_created')->where('users.project_id', $user->project_id)->select('news.*')->paginate(50);
        } else
        {
            $params['data'] = News::orderBy('id', 'DESC')->paginate(50);
        }
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
        $params['data'] = News::where('id', $id)->first();

        return view('administrator.news.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = News::where('id', $id)->first();
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

        return redirect()->route('administrator.news.index')->with('message-success', 'Data successfully saved');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = News::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.news.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new News();
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
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        }else{
            $data->user_created = "";
        }
        
        $data->save();

        return redirect()->route('administrator.news.index')->with('message-success', 'Data successfully saved !');
    }
}
