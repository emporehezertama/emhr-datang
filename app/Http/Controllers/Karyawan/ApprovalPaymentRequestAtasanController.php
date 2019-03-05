<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\StatusApproval;
use App\Models\PaymentRequestForm;

class ApprovalPaymentRequestAtasanController extends Controller
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
        $params['data'] = PaymentRequest::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();    

        return view('karyawan.approval-payment-request-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $status = new StatusApproval;
        $status->approval_user_id       = \Auth::user()->id;
        $status->jenis_form             = 'payment_request';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->save();    

        if(isset($request->nominal_approve))
        {
            foreach($request->nominal_approve as $k => $item)
            {
                $i = PaymentRequestForm::where('id', $k)->first();
                if($i)
                {
                    $i->note = $request->note[$k];
                    $i->nominal_approved = $item;
                    $i->save();
                }
            }
        }

        $data                        = PaymentRequest::where('id', $request->id)->first();
        $data->date_approved_atasan     = date('Y-m-d H:i:s');
        $params['data']     = $data;
        
        if($request->status == 1)
        {
            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->direktur->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Payment Request and currently waiting your approval.</p>';

            \Mail::send('email.payment-request-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->direktur->email);
                    $message->subject('Empore - Payment Request');
                }
            );
        }
        else
        {
            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Payment Request <strong style="color: red;">Rejected</strong>.</p>';

            \Mail::send('email.payment-request-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Payment Request');
                }
            );
        }

        $data->date_approved_atasan     = date('Y-m-d H:i:s');
        $data->is_approved_atasan    = $request->status;
        $data->save();
        
        return redirect()->route('karyawan.approval.payment-request-atasan.index')->with('message-success', 'Form Payment Request Successfully Processed !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = PaymentRequest::where('id', $id)->first();

        return view('karyawan.approval-payment-request-atasan.detail')->with($params);
    }
}
