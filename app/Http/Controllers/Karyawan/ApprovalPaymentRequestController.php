<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\PaymentRequestForm;

class ApprovalPaymentRequestController extends Controller
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
        $params['data'] = PaymentRequest::where('approve_direktur_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-payment-request.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {   
        if(isset($request->nominal_approve))
        {
            foreach($request->nominal_approve as $k => $item)
            {
                $i = PaymentRequestForm::where('id', $k)->first();
                if($i)
                {
                    $i->note                = $request->note[$k];
                    $i->nominal_approved    = $item;
                    $i->save();
                }
            }
        }
        
        $data = PaymentRequest::where('id', $request->id)->first();
        $status                         = $request->status;
        $data->approve_direktur         = $status;
        $data->approve_direktur_date    = date('Y-m-d H:i:s');
        $params['data']                 = $data;

        if($status >=1)
        {
            $status = 2;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Payment Request <strong style="color: green;">APPROVED</strong>.</p>';

            \Mail::send('email.payment-request-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Payment Request');
                }
            );
        }
        else
        {
            $status = 3;
            
            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Payment Request <strong style="color: red;">REJECTED</strong>.</p>';

            \Mail::send('email.payment-request-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Payment Request');
                }
            );
        }

        $data->status = $status;
        $data->save();

        return redirect()->route('karyawan.approval.payment_request.index')->with('message-success', 'Form Payment Request Successfully Processed !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = PaymentRequest::where('id', $id)->first();

        return view('karyawan.approval-payment-request.detail')->with($params);
    }
}
