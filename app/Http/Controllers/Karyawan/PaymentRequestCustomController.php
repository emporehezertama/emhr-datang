<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\PaymentRequestForm;
use App\User;
use Carbon\Carbon;
use App\Models\PaymentRequestOvertime;
use App\Models\OvertimeSheet;
use App\Models\PaymentRequestBensin;
use App\Models\SettingApprovalPaymentRequestItem;
use App\Models\SettingApprovalLeave;
use App\Models\HistoryApprovalPaymentRequest;

class PaymentRequestCustomController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $params['data'] = PaymentRequest::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.payment-request-custom.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();

        return view('karyawan.payment-request-custom.create')->with($params);
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
        $checkApproval = \Auth::user()->approvalLeave;

        if($checkApproval == null)
        {
            return redirect()->route('karyawan.payment-request-custom.index')->with('message-error', 'Your position is not defined yet. Please contact your admin!');
        }else{
            $checkApproval = $checkApproval->level1PaymentRequest;
            if($checkApproval == null){
                return redirect()->route('karyawan.payment-request-custom.index')->with('message-error', 'Setting approval not define yet. Please contact your admin !');
            }
            if($checkApproval)
            $data                       = new PaymentRequest();
            $data->user_id              = \Auth::user()->id;
            $data->transaction_type     = $request->transaction_type;
            $data->payment_method       = $request->payment_method;
            $data->tujuan               = $request->tujuan;
            $data->status               = 1;
            $data->is_proposal_approved = 0;
            $data->is_proposal_verification_approved = 0;
            $data->is_payment_approved  = 0;
            $data->save();

            // jika ada overtime
            if(isset($request->overtime))
            {
                foreach($request->overtime as $k => $i)
                {
                    $form                       = new PaymentRequestOvertime();
                    $form->payment_request_id   = $data->id;
                    $form->overtime_sheet_id    = $i;
                    $form->save();

                    $ov                         = OvertimeSheet::where('id', $i)->first();
                    $ov->is_payment_request     = 1;
                    $ov->save();
                }
            }

            if(isset($request->bensin))
            {
                foreach($request->bensin['tanggal'] as $k => $item)
                {
                    $bensin                     = new PaymentRequestBensin();
                    $bensin->payment_request_id = $data->id;
                    $bensin->user_id            = \Auth::user()->id;
                     $bensin->tanggal  = Carbon::parse($request->bensin['tanggal'][$k])->format('d.m.y');
                    //$bensin->tanggal            = $request->bensin['tanggal'][$k];
                    $bensin->odo_start          = $request->bensin['odo_from'][$k];
                    $bensin->odo_end            = $request->bensin['odo_to'][$k];
                    $bensin->liter              = $request->bensin['liter'][$k];
                    $bensin->cost               = $request->bensin['cost'][$k];
                    $bensin->save();
                }
            }

            foreach($request->description as $key => $item)
            {
                $form = new PaymentRequestForm();
                $form->payment_request_id   = $data->id;
                $form->description          = $item;
                $form->type_form            = $request->type[$key];
                $form->quantity             = $request->quantity[$key];
                $form->estimation_cost      = $request->estimation_cost[$key];
                $form->amount               = $request->amount[$key];

                if($request->hasFile('file_struk'))
                {
                    foreach($request->file_struk as $k => $file)
                    {
                        if ($file and $key == $k ) {
                        
                            $image = $file;
                            
                            //$name = time().'.'.$image->getClientOriginalExtension();
                            $name = (PaymentRequestForm::count()+1).'.'.$image->getClientOriginalExtension();
                            $destinationPath = public_path('storage/file-struk/');
                            
                            $image->move($destinationPath, $name);

                            $form->file_struk = $name;
                        }
                    }
                }

                //dd($request->hasFile('file_struk'));

                $form->save();
            }

            $params['data']     = $data;
            $position = \Auth::user()->structure_organization_custom_id;
            $settingApproval = \Auth::user()->approvalLeave->id; //idnya
            $settingApprovalItem = \Auth::user()->approvalLeave->level1PaymentRequest->structure_organization_custom_id;

            $historyApproval    = \Auth::user()->approvalLeave->itemsPaymentRequest;
            foreach ($historyApproval as $key => $value) {
                # code...
                $history = new HistoryApprovalPaymentRequest();
                $history->payment_request_id = $data->id;
                $history->setting_approval_level_id = $value->setting_approval_level_id;
                $history->structure_organization_custom_id = $value->structure_organization_custom_id;
                $history->save();
            }
            $historyApprov = HistoryApprovalPaymentRequest::where('payment_request_id',$data->id)->get();

            $userApproval = user_approval_custom($settingApprovalItem);
            foreach ($userApproval as $key => $value) { 
                
                if($value->email == "") continue;
                
                $params['data']     = $data;
                $params['value']    = $historyApprov;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $value->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Payment Request and currently waiting your approval.</p>';

               \Mail::send('email.payment-request-approval-custom', $params,
                    function($message) use($data, $value) {
                    $message->from('emporeht@gmail.com');
                    $message->to($value->email);
                    $message->subject(get_setting('mail_name').' - Payment Request');
                }); 
            }

            //dd($position, $settingApproval,$settingApprovalItem, $historyApproval);

            return redirect()->route('karyawan.payment-request-custom.index')->with('message-success', 'Payment Request successfully processed');
            }
        
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
        $params['data']         = PaymentRequest::where('id', $id)->first();
        $params['karyawan']     = User::whereIn('access_id', [1,2])->get();
        $params['form']         = PaymentRequestForm::where('payment_request_id', $id)->get();

        return view('karyawan.payment-request-custom.edit')->with($params);
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
}
