<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingPaymentRequestController extends Controller
{   
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['approval'] = \App\SettingApproval::where('jenis_form', 'payment_request')->where('nama_approval', 'Approval')->orderBy('id', 'DESC')->get();
        $params['verification'] = \App\SettingApproval::where('jenis_form', 'payment_request')->where('nama_approval', 'Verification')->orderBy('id', 'DESC')->get();
        $params['payment'] = \App\SettingApproval::where('jenis_form', 'payment_request')->where('nama_approval', 'Payment')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-payment-request.index')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\SettingApproval::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-payment-request.index')->with('message-success', 'Data Approval berhasi di hapus');
    }
}
 