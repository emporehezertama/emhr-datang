<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Support\Facades\Validator;


class CabangController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        parent::__construct();
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
            $params['data'] = Cabang::join('users','users.id','=','cabang.user_created')->where('users.project_id', $user->project_id)->select('cabang.*')->get();
        }else{
            $params['data'] = Cabang::all();
        }

        return view('administrator.cabang.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('administrator.cabang.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = Cabang::where('id', $id)->first();

        return view('administrator.cabang.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'name'  => 'required|max:30'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        $data       = Cabang::where('id', $id)->first();
        $data->name             = $request->name;
        $data->alamat           = $request->alamat;
        $data->telepon          = $request->telepon;
        $data->fax              = $request->fax;
        $data->latitude         = $request->latitude;
        $data->longitude        = $request->longitude;
        $data->radius           = $request->radius;
        $data->save();

        return redirect()->route('administrator.cabang.index')->with('message-success', 'Data berhasil disimpan');
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Cabang::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.cabang.index')->with('message-sucess', 'Data berhasi di hapus');
    }

    /**
     * [import description]
     * @return [type] [description]
     */
    public function import(Request $request)
    {
        if($request->hasFile('file'))
        {
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }

            foreach($rows as $key => $item)
            {
                if($key >= 5)
                {
                    if($item[2] == "") continue;

                    $data  = new Cabang();
                    $data->name     = strtoupper($item[2]);
                    $data->alamat   = $item[3];
                    $data->telepon  = $item[4];
                    $data->fax      = $item[5];

                    $user = \Auth::user();
                    if($user->project_id != NULL)
                    {
                        $data->user_created = $user->id;
                    }
                    $data->save();
                }
            }

            return redirect()->route('administrator.cabang.index')->with('message-success', 'Data berhasil diimport !');
        }
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name'  => 'required|max:30'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        $data           = new Cabang();
        $data->name             = $request->name;
        $data->alamat           = $request->alamat;
        $data->telepon          = $request->telepon;
        $data->fax              = $request->fax;
        $data->latitude         = $request->latitude;
        $data->longitude        = $request->longitude;
        $data->radius           = $request->radius;

        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data->user_created = $user->id;
        }
        $data->save();

        return redirect()->route('administrator.cabang.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
