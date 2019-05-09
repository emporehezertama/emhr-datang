<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlafondDinas;
use App\Models\PlafondDinasLuarNegeri;
use App\Models\OrganisasiPosition;

class PlafondDinasController extends Controller
{   

	public function __construct(\Maatwebsite\Excel\Excel $excel)
	{
	    $this->excel = $excel;
	}

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['data']             = PlafondDinas::orderby('organisasi_position_id','DESC')->get();
        $params['data_luarnegeri']  = PlafondDinasLuarNegeri::all();

        return view('administrator.plafond-dinas.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        $params['position'] = OrganisasiPosition::all();
        return view('administrator.plafond-dinas.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = PlafondDinas::where('id', $id)->first();
        $params['position'] = OrganisasiPosition::all();
        return view('administrator.plafond-dinas.edit')->with($params);
    }

    /**
     * [import description]
     * @return [type] [description]
     */
    public function import(Request $request)
    {	
    	$this->validate($request, [
	        'file' => 'required',
	    ]);

    	if($request->hasFile('file')){

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

            foreach($rows as $key => $row)
            {
            	if($key >=5)
                {
                    if($row[1] == "") continue;

                    if($request->jenis_plafond == 'Domestik'){
                        $data = new PlafondDinas();
                    }
                    else
                    {
                        $data = new PlafondDinasLuarNegeri();
                    }

                    $position = OrganisasiPosition::where('name', 'LIKE', '%%'.  $row[1] .'%')->first();

                    if($position)
                    {
                	   $data->organisasi_position_id       = $position->id;
                    }

                    $data->hotel                        = $row[2];
                    $data->tunjangan_makanan            = $row[3];
                    $data->tunjangan_harian             = $row[4];
                    //$data->pesawat                      = $row[5];
                    $data->keterangan                   = $row[6];
                    $data->organisasi_position_text     = $row[1];
                	$data->save();
                }
	        }
        }

        return redirect()->route('administrator.plafond-dinas.index')->with('messages-success', 'Data successfully import');
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function update(Request $request, $id)
    {
        //dd($request);

        $data = PlafondDinas::where('id', $id)->first();
        //$data->hotel                        = $request->hotel;
        $data->tunjangan_makanan            = $request->tunjangan_makanan;
        $data->tunjangan_harian             = $request->tunjangan_harian;
        //$data->pesawat                      = $request->pesawat;
        $data->keterangan                   = $request->keterangan;
        $data->organisasi_position_id       = $request->organisasi_position_id;
        $data->plafond_type                 = $request->plafond_type;
        $data->save();

        return redirect()->route('administrator.plafond-dinas.index')->with('message-success', 'Data successfully saved');
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = PlafondDinas::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.plafond-dinas.index')->with('message-success', 'Data successfully deleted');
    } 

    /**
     * [update description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data = new PlafondDinas();
        $data->tunjangan_makanan            = $request->tunjangan_makanan;
        $data->tunjangan_harian             = $request->tunjangan_harian;
        //$data->pesawat                      = $request->pesawat;
        $data->keterangan                   = $request->keterangan;
        $data->organisasi_position_id       = $request->organisasi_position_id;
        $data->plafond_type                 = $request->plafond_type;
        
        $data->save();

        return redirect()->route('administrator.plafond-dinas.index')->with('message-success', 'Data successfully saved');
    }
     /**
     * [create description]
     * @return [type] [description]
     */
    public function createLuarNegeri()
    {
        $params['position'] = OrganisasiPosition::all();
        return view('administrator.plafond-dinas.createLuar')->with($params);
    }
    /**
     * [update description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function storeLuarNegeri(Request $request)
    {
        $data = new PlafondDinasLuarNegeri();
        $data->tunjangan_makanan            = $request->tunjangan_makanan;
        $data->tunjangan_harian             = $request->tunjangan_harian;
        //$data->pesawat                      = $request->pesawat;
        $data->keterangan                   = $request->keterangan;
        $data->organisasi_position_id       = $request->organisasi_position_id;
        //$data->plafond_type                 = $request->plafond_type;
        
        $data->save();

        return redirect()->route('administrator.plafond-dinas.index')->with('message-success', 'Data successfully saved');
    }

    public function editLuarNegeri($id)
    {
        $params['data'] = PlafondDinasLuarNegeri::where('id', $id)->first();
        $params['position'] = OrganisasiPosition::all();
        return view('administrator.plafond-dinas.editLuar')->with($params);
    }

    public function updateLuarNegeri(Request $request, $id)
    {
        //dd($request);

        $data = PlafondDinasLuarNegeri::where('id', $id)->first();
        //$data->hotel                        = $request->hotel;
        $data->tunjangan_makanan            = $request->tunjangan_makanan;
        $data->tunjangan_harian             = $request->tunjangan_harian;
        //$data->pesawat                      = $request->pesawat;
        $data->keterangan                   = $request->keterangan;
        $data->organisasi_position_id       = $request->organisasi_position_id;
        //$data->plafond_type                 = $request->plafond_type;
        $data->save();

        return redirect()->route('administrator.plafond-dinas.index')->with('message-success', 'Data successfully saved');
    }

     /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteLuarNegeri($id)
    {
        $data = PlafondDinasLuarNegeri::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.plafond-dinas.index')->with('message-success', 'Data successfully deleted');
    } 

}
