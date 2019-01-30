<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cabang;

class CabangController extends Controller
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
        $params['data'] = Cabang::all();

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
        $data       = Cabang::where('id', $id)->first();
        $data->name             = $request->name;
        $data->alamat           = $request->alamat; 
        $data->telepon          = $request->telepon; 
        $data->fax              = $request->fax; 
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
                    
                    $data  = new \App\Cabang();
                    $data->name     = strtoupper($item[2]);
                    $data->alamat   = $item[3];
                    $data->telepon  = $item[4];
                    $data->fax      = $item[5];
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
        $data           = new Cabang();
        $data->name             = $request->name;
        $data->alamat           = $request->alamat; 
        $data->telepon          = $request->telepon; 
        $data->fax              = $request->fax; 
        $data->save();

        return redirect()->route('administrator.cabang.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
