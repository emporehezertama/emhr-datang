<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayrollSettingController extends Controller
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
        $params['ptkp']     = \App\PayrollPtkp::all();
        $params['pph']      = \App\PayrollPPH::all();
        $params['others']   = \App\PayrollOthers::all();

        return view('administrator.payroll-setting.index')->with($params);
    }

    /**
     * [deletePtkp description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deletePtkp($id)
    {       
        $pph = \App\PayrollPtkp::where('id', $id)->first();
        $pph->delete();

        return redirect()->route('administrator.payroll-setting.index')->with('message-success', 'PTKP Setting berhasil di hapus');
    }

    /**
     * [editOthers description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editOthers($id)
    {
        $params['data'] = \App\PayrollOthers::where('id', $id)->first();

        return view('administrator.payroll-setting.edit-others')->with($params);
    }

    /**
     * [deleteOthers description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteOthers($id)
    {       
        $pph = \App\PayrollOthers::where('id', $id)->first();
        $pph->delete();

        return redirect()->route('administrator.payroll-setting.index')->with('message-success', 'Others Setting berhasil di hapus');
    }

    /**
     * [updateOthers description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateOthers(Request $request, $id)
    {
        $data           = \App\PayrollOthers::where('id', $id)->first();
        $data->label    = $request->label;
        $data->value    = $request->value;
        $data->save();

        return redirect()->route('administrator.payroll-setting.index')->with('message-success', 'Data berhasil disimpan');
    }

    /**
     * [addPPH description]
     */
    public function addPPH()
    {
        return view('administrator.payroll-setting.add-pph');
    }

    /**
     * [addPPH description]
     */
    public function editPPH($id)
    {
        $params['data'] = \App\PayrollPPH::where('id', $id)->first();

        return view('administrator.payroll-setting.edit-pph')->with($params);
    }

    /**
     * [deletePPH description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deletePPH($id)
    {       
        $pph = \App\PayrollPPH::where('id', $id)->first();
        $pph->delete();

        return redirect()->route('administrator.payroll-setting.index')->with('message-success', 'PPH Setting berhasil di hapus');
    }


    /**
     * [addOthers description]
     */
    public function addOthers()
    {
        return view('administrator.payroll-setting.add-others');
    }   

    /**
     * [updatePPH description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function updatePPH(Request $request, $id)
    {
        $data                   = \App\PayrollPPH::where('id', $id)->first();
        $data->batas_bawah      = $request->batas_bawah;
        $data->batas_atas       = $request->batas_atas;
        $data->tarif            = $request->tarif;
        $data->pajak_minimal    = $request->pajak_minimal;
        $data->akumulasi_pajak  = $request->akumulasi_pajak;
        $data->kondisi_lain     = $request->kondisi_lain;
        $data->save();

        return redirect()->route('administrator.payroll-setting.index')->with('message-success', 'Data berhasil disimpan');
    }

    /**
     * [storePPH description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function storePPH(Request $request)
    {
        $data                   = new \App\PayrollPPH();
        $data->batas_bawah      = $request->batas_bawah;
        $data->batas_atas       = $request->batas_atas;
        $data->tarif            = $request->tarif;
        $data->pajak_minimal    = $request->pajak_minimal;
        $data->akumulasi_pajak  = $request->akumulasi_pajak;
        $data->kondisi_lain     = $request->kondisi_lain;
        $data->save();

        return redirect()->route('administrator.payroll-setting.index')->with('message-success', 'Data berhasil disimpan');
    }

    /**
     * [storeOthers description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function storeOthers(Request $request)
    {
        $data           = new \App\PayrollOthers();
        $data->label    = $request->label;
        $data->value    = $request->value;
        $data->save();

        return redirect()->route('administrator.payroll-setting.index')->with('message-success', 'Data berhasil disimpan');
    }

    /**
     * [editPtkp description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editPtkp($id)
    {
        $params['data'] = \App\PayrollPtkp::where('id', $id)->first();

        return view('administrator.payroll-setting.edit-ptkp')->with($params);
    }

    /**
     * [storePPH description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updatePtkp(Request $request)
    {
        $data                       = new \App\PayrollPtkp();
        $data->bujangan_wanita      = $request->bujangan_wanita;
        $data->menikah              = $request->menikah;
        $data->menikah_anak_1       = $request->menikah_anak_1;
        $data->menikah_anak_2       = $request->menikah_anak_2;
        $data->menikah_anak_3       = $request->menikah_anak_3;
        $data->save();

        return redirect()->route('administrator.payroll-setting.index')->with('message-success', 'Data berhasil disimpan');
    }
}
