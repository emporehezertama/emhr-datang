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

class PaymentRequestController extends Controller
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
        $params['data'] = PaymentRequest::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.payment-request.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['karyawan'] = User::where('access_id', 2)->get();

        return view('karyawan.payment-request.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = PaymentRequest::where('id', $id)->first();
        $params['karyawan']     = User::where('access_id', 2)->get();
        $params['form']         = PaymentRequestForm::where('payment_request_id', $id)->get();

        return view('karyawan.payment-request.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = PaymentRequest::where('id', $id)->first();
        $data->save();

        return redirect()->route('karyawan.payment-request.index')->with('message-success', 'Data successfully saved');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = PaymentRequest::where('id', $id)->first();
        $data->delete();

        return redirect()->route('karyawan.payment-request.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                       = new PaymentRequest();
        $data->user_id              = \Auth::user()->id;
        $data->transaction_type     = $request->transaction_type;
        $data->payment_method       = $request->payment_method;
        $data->tujuan               = $request->tujuan;
        $data->status               = 1;
        $data->is_proposal_approved = 0;
        $data->is_proposal_verification_approved = 0;
        $data->is_payment_approved  = 0;
        $data->approve_direktur_id      = get_direktur(\Auth::user()->id)->id; 
        $data->approved_atasan_id       = $request->approved_atasan_id;
        
        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            $data->is_approved_atasan = 1;
        }

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
                        
                        $name = time().'.'.$image->getClientOriginalExtension();
                        
                        $destinationPath = public_path('storage/file-struk/');
                        
                        $image->move($destinationPath, $name);

                        $form->file_struk = $name;
                    }
                }
            }

            $form->save();
        }

        $params['data']     = $data;
        $params['text']     = '<p><strong>Dear Sir/Madam '. $data->atasan->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Payment Request and currently waiting your approval.</p>';

        \Mail::send('email.payment-request-approval', $params,
            function($message) use($data) {
                $message->from('emporeht@gmail.com');
                $message->to($data->atasan->email);
                $message->subject('Empore - Payment Request');
            }
        );

        return redirect()->route('karyawan.payment-request.index')->with('message-success', 'Payment Request successfully processed');
    }
}
