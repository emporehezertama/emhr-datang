<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalReimbursement;
use App\Models\MedicalReimbursementForm;
use App\User;
use App\Models\MedicalType;
use App\Models\HistoryApprovalMedical;

class MedicalKaryawanCustomController extends Controller
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
         $params['data'] = MedicalReimbursement::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('administrator.medical-custom.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $params['type'] = MedicalType::join('users', 'users.id','=', 'medical_type.user_created')->where('users.project_id', $user->project_id)->select('medical_type.*')->get();
        }else{
            $params['type'] = MedicalType::all();
        }
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();

        return view('administrator.medical-custom.create')->with($params);
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
        $checkApproval = \Auth::user()->approvalLeave->level1Medical;
        if($checkApproval == null)
        {
            return redirect()->route('administrator.medical-custom.index')->with('message-error', 'Setting approval not define yet. Please contact your admin !');
        }else
        {
            $data                       = new MedicalReimbursement();
            $data->user_id              = \Auth::user()->id;
            $data->tanggal_pengajuan    = $request->tanggal_pengajuan;
            $data->status               = 1;  
            $data->save();

            foreach($request->tanggal_kwitansi as $key => $item)
            {   
                $form                           = new MedicalReimbursementForm();
                $form->medical_reimbursement_id = $data->id;
                $form->tanggal_kwitansi         = $request->tanggal_kwitansi[$key];
                $form->user_family_id           = $request->user_family_id[$key];
                $form->medical_type_id          = $request->medical_type_id[$key];
                $form->no_kwitansi              = $request->no_kwitansi[$key];
                $form->jumlah                   = $request->jumlah[$key];

                if (request()->hasFile('file_bukti_transaksi'))
                {
                    $file = $request->file('file_bukti_transaksi');

                    foreach($file as $k => $f)
                    {
                        if($k == $key)
                        {
                            $fname = md5($f->getClientOriginalName() . time()) . "." . $f->getClientOriginalExtension();

                            $destinationPath = public_path('/storage/file-medical/');
                            $f->move($destinationPath, $fname);
                            $form->file_bukti_transaksi = $fname;
                        }
                    }
                }
                $form->save();
            }
            $params['data']     = $data;
            $position = \Auth::user()->structure_organization_custom_id;
            $settingApproval = \Auth::user()->approvalLeave->id; //idnya 
            $settingApprovalItem = \Auth::user()->approvalLeave->level1Medical->structure_organization_custom_id;

            $historyApproval    = \Auth::user()->approvalLeave->itemsMedical;
            foreach ($historyApproval as $key => $value) {
                # code...
                $history = new HistoryApprovalMedical();
                $history->medical_reimbursement_id = $data->id;
                $history->setting_approval_level_id = $value->setting_approval_level_id;
                $history->structure_organization_custom_id = $value->structure_organization_custom_id;
                $history->save();
            }
            $historyApprov = HistoryApprovalMedical::where('medical_reimbursement_id',$data->id)->get();

            $userApproval = user_approval_custom($settingApprovalItem);
            foreach ($userApproval as $key => $value) { 
                
                if($value->email == "") continue;
                
                $params['data']     = $data;
                $params['value']    = $historyApprov;
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $value->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Medical Reimbursement and currently waiting your approval.</p>';
               \Mail::send('email.medical-approval-custom', $params,
                    function($message) use($data, $value) {
                    $message->from('emporeht@gmail.com');
                    $message->to($value->email);
                    $message->subject(get_setting('mail_name').' - Medical Reimbursement');
                }); 
            }
            return redirect()->route('administrator.medical-custom.index')->with('message-success', 'Medical Reimbursement succesfully process');
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
        $params['data'] = MedicalReimbursement::where('id', $id)->first();;
        $params['form'] = MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();

        return view('administrator.medical-custom.edit')->with($params);
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
