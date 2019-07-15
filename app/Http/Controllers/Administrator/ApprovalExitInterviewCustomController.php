<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExitInterview;
use App\Models\ExitInterviewAssets;
use App\Models\HistoryApprovalExit;
use App\Models\Asset;
use App\User;

class ApprovalExitInterviewCustomController extends Controller
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
         $params['data'] = cek_exit_approval();

        return view('administrator.approval-exit-custom.index')->with($params);
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

    public function detail($id)
    {
        $params['data']         = ExitInterview::where('id', $id)->first();
        $params['history'] = HistoryApprovalExit::where('exit_interview_id',$id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        return view('administrator.approval-exit-custom.detail')->with($params);
    }
    public function proses(Request $request)
    {  
        $data = ExitInterview::where('id', $request->id)->first();
        $status                         = $request->status;

        $historyApprov      = HistoryApprovalExit::where('exit_interview_id',$data->id)->get();
        $params['data']     = $data;
        $params['value']    = $historyApprov;

        $history =  HistoryApprovalExit::where('exit_interview_id',$request->id)->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();

        $exitHistory = $data->historyApproval;
        $trukturlast = $exitHistory->last();

        if($request->status == 0)
        {
            $status = 3;

            $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Exit Interview & Clearance <strong style="color: red;">REJECTED</strong>.</p>';
            // send email
            \Mail::send('email.exit-approval-custom', $params,
                function($message) use($data,$historyApprov) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Exit Interview');
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
                    $params['text']     = '<p><strong>Dear Sir/Madam '. $data->user->name .'</strong>,</p> <p>  Submission of your Exit Interview <strong style="color: green;">APPROVED</strong>.</p>';

                    \Mail::send('email.exit-approval-custom', $params,
                        function($message) use($data,$historyApprov) {
                            $message->from('emporeht@gmail.com');
                            $message->to($data->user->email);
                            $message->subject('Empore - Exit Interview');
                        });  
                        $history->approval_id    = \Auth::user()->id;
                        $history->is_approved    = 1;
                        $history->date_approved  = date('Y-m-d H:i:s');
                        $history->note           = $request->noteApproval;
                        $history->save();

                    $updateUser       = User::where('id', $data->user_id)->first();
                    $updateUser->resign_date = $data->resign_date;
                    $updateUser->status = 2;
                    $updateUser->save();

                } else{
                    $status = 1;
                    $userLevelNext = $history->setting_approval_level_id +1;
                    $userDataNext = HistoryApprovalExit::where('exit_interview_id',$history->exit_interview_id)->where('setting_approval_level_id', $userLevelNext)->first();
                    $userStructure = $userDataNext["structure_organization_custom_id"];
                    $userApproval = user_approval_custom($userStructure);


                    foreach ($userApproval as $key => $items) { 
                        if($items->email == "") continue;
                            $params['text']     = '<p><strong>Dear Sir/Madam '. $items->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Exit Interview and currently waiting your approval.</p>';

                            \Mail::send('email.exit-approval-custom', $params,
                                function($message) use($data, $historyApprov,$items) {
                                $message->from('emporeht@gmail.com');
                                $message->to($items->email);
                                $message->subject('Empore - Exit Interview');
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

        return redirect()->route('administrator.approval.exit-custom.index')->with('message-success', 'Form Exit Interview & Clearance Reimbursement Successfully Processed !');

    }
}
