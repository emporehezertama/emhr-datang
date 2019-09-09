<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingApproval;

class SettingPaymentRequestController extends Controller
{   
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['approval']         = SettingApproval::where('jenis_form', 'payment_request')->where('nama_approval', 'Approval')->orderBy('id', 'DESC')->get();
        $params['verification']     = SettingApproval::where('jenis_form', 'payment_request')->where('nama_approval', 'Verification')->orderBy('id', 'DESC')->get();
        $params['payment']          = SettingApproval::where('jenis_form', 'payment_request')->where('nama_approval', 'Payment')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-payment-request.index')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = SettingApproval::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-payment-request.index')->with('message-success', 'Data Approval berhasi di hapus');
    }
}
 