<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiburNasionalController extends Controller
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
        $params['data'] = \App\LiburNasional::orderBy('id', 'DESC')->get();

        return view('administrator.libur-nasional.index')->with($params);
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
                    
                    $data  = new \App\LiburNasional();
                    $data->tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[2]);
                    $data->keterangan = $item[3];
                    $data->save();
                }
            }

            return redirect()->route('administrator.libur-nasional.index')->with('message-success', 'Data berhasil diimport !');
        }
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.libur-nasional.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = \App\LiburNasional::where('id', $id)->first();

        return view('administrator.libur-nasional.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data               = \App\LiburNasional::where('id', $id)->first();
        $data->tanggal      = $request->tanggal; 
        $data->keterangan   = $request->keterangan;
        $data->save();

        return redirect()->route('administrator.libur-nasional.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\LiburNasional::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.libur-nasional.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new \App\LiburNasional();
        $data->tanggal             = $request->tanggal;
        $data->keterangan      = $request->keterangan;
        $data->save();

        return redirect()->route('administrator.libur-nasional.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
