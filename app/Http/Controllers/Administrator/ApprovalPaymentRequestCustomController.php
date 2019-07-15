<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\HistoryApprovalPaymentRequest;
use App\Models\PaymentRequestForm;

class ApprovalPaymentRequestCustomController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $params['data'] = cek_payment_request_approval();
       
        return view('administrator.approval-payment-request-custom.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = PaymentRequest::where('id', $id)->first();
        $params['history'] = HistoryApprovalPaymentRequest::where('payment_request_id',$id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        return view('administrator.approval-payment-request-custom.detail')->with($params);
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

        $historyApprov      = HistoryApprovalPaymentRequest::where('payment_request_id',$data->id)->get();
        $params['data']     = $data;
        $params['value']    = $historyApprov;

        $history =  HistoryApprovalPaymentRequest::where('payment_request_id',$request->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        $paymentHistory = $data->historyApproval;
        $trukturlast = $paymentHistory->last();

        if($request->status == 0)
        {
            $status = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Payment Request <strong style="color: red;">REJECTED</strong>.</p>';
            // send email
            \Mail::send('email.payment-request-approval-custom', $params,
                function($message) use($data,$historyApprov) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Payment Request');
                }
            ); 
            $history->approval_id    = \Auth::user()->id;
            $history->is_approved    = 0;
            $history->date_approved  = date('Y-m-d H:i:s');
            $history->note           = $request->noteApproval;
            $history->save();

        }else 
        {
            if($trukturlast->structure_organization_custom_id == \Auth::user()->structure_organization_custom_id)
                {
                    $status = 2;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Payment Request <strong style="color: green;">APPROVED</strong>.</p>';

                    \Mail::send('email.payment-request-approval-custom', $params,
                        function($message) use($data,$historyApprov) {
                            $message->from('emporeht@gmail.com');
                            $message->to($data->user->email);
                            $message->subject('Empore - Payment Request');
                        });  
                        $history->approval_id    = \Auth::user()->id;
                        $history->is_approved    = 1;
                        $history->date_approved  = date('Y-m-d H:i:s');
                        $history->note           = $request->noteApproval;
                        $history->save();
                } else{
                    $status = 1;
                    $userLevelNext = $history->setting_approval_level_id +1;
                    $userDataNext = HistoryApprovalPaymentRequest::where('payment_request_id',$history->payment_request_id)->where('setting_approval_level_id', $userLevelNext)->first();
                    $userStructure = $userDataNext["structure_organization_custom_id"];
                    $userApproval = user_approval_custom($userStructure);

                   // dd($userDataNext, $userStructure, $userApproval);

                    foreach ($userApproval as $key => $items) { 
                        if($items->email == "") continue;
                            $params['text']     = '<p><strong>Dear Sir/Madam '. $items->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Payment Request and currently waiting your approval.</p>';

                            \Mail::send('email.payment-request-approval-custom', $params,
                                function($message) use($data, $historyApprov,$items) {
                                $message->from('emporeht@gmail.com');
                                $message->to($items->email);
                                $message->subject('Empore - Payment Request');
                            }); 
                    }
                    $history->approval_id    = \Auth::user()->id;
                    $history->is_approved    = 1;
                    $history->date_approved  = date('Y-m-d H:i:s');
                    $history->note           = $request->noteApproval;
                    $history->save();
                }
        }
        $data->status = $status;
        $data->save();

        return redirect()->route('administrator.approval.payment-request-custom.index')->with('message-success', 'Form Payment Request Successfully Processed !');
    }
}
