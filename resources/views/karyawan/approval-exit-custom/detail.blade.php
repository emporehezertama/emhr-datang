@extends('layouts.karyawan')

@section('title', 'Exit Interview Form')

@section('sidebar')

@endsection

@section('content')

<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Exit Interview Form</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Exit Interview Form</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('karyawan.approval.exit-custom.proses') }}" method="POST" id="exit_interview_form">
                <div class="col-md-12">
                    <div class="white-box">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        {{ csrf_field() }}
                                <div class="col-md-6" style="padding-left: 0;">
                                    <div class="form-group">
                                        <label class="col-md-12">NIK / Employee Name</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" value="{{ $data->user->nik .' / '. $data->user->name }}" readonly="true">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6">Position</label>
                                        <label class="col-md-6">Join Date</label>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" class="form-control department" value="{{ isset($data->user->structure->position) ? $data->user->structure->position->name : '' }}{{isset($data->user->structure->division) ? '-'. $data->user->structure->division->name:''}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" class="form-control" value="{{ $data->user->join_date }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6">Resign Date</label>
                                        <label class="col-md-6">Date Last Work</label>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" name="resign_date" class="form-control datepicker" value="{{ $data->resign_date }}" >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" name="last_work_date" class="form-control datepicker" value="{{ $data->last_work_date }}" >
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br />
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group">
                                    <label class="col-md-6">Resignation reason :</label>
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            @foreach(get_reason_interview() as $item)
                                            <?php 

                                                if($data->exit_interview_reason != $item->id)
                                                {
                                                    continue;
                                                }
                                            ?>
                                                <textarea class="form-control" readonly="true" name="reason">{{ $item->label }}</textarea>  
                                                @if($item->id == 1)
                                                <div class="form-group perusahaan_lain">
                                                <hr />
                                                    <label class="col-md-12">If move to other company </label>
                                                    <p class="col-md-6">New company name</p>
                                                    <p class="col-md-6">Scope of work</p>
                                                    <div class="col-md-6">
                                                        <textarea class="form-control" readonly="true" name="tujuan_perusahaan_baru">{{ $data->tujuan_perusahaan_baru }}</textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <textarea class="form-control" readonly="true" name="jenis_bidang_usaha">{{ $data->jenis_bidang_usaha }}</textarea>
                                                    </div>
                                                </div>
                                                @elseif($item->id == 12)
                                                <textarea class="form-control" readonly="true" name="other_reason">{{ $data->other_reason }}</textarea>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Most memorable moments while working at this company</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="hal_berkesan" readonly="true">{{ $data->hal_berkesan }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                <!--
                                <div class="form-group">
                                    <label class="col-md-12">Unmemorable moments while working at this company</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="hal_tidak_berkesan" readonly="true">{{ $data->hal_tidak_berkesan }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                -->
                                <div class="form-group">
                                    <label class="col-md-12">Suggestion and Critic</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="masukan" readonly="true">{{ $data->masukan }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Approval Note</label>
                                @if($history->is_approved != NULL)
                                <div class="col-md-12">
                                    <input type="text" readonly="true" class="form-control note" value="{{ $history->note }}">
                                </div>
                                @else
                                <div class="col-md-12">
                                    <textarea class="form-control note" name="note" placeholder="Note"></textarea>
                                </div>
                                @endif
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <a href="{{ route('karyawan.approval.exit-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                                        @if($history->is_approved === NULL and $data->status < 2)
                                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-check"></i> Approve</a>
                                        <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Reject</a>
                                        @endif
                                    </div>
                                </div>
                    </div>
                </div>    
                <input type="hidden" name="status" value="0" />
                <input type="hidden" name="id" value="{{ $data->id }}">
                <input type="hidden" name="action" value="update" >
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
@section('footer-script')
    <script type="text/javascript">
    

        $("#btn_approved").click(function(){
            bootbox.confirm('Approve Submission Exit Interview & Exit Clearance Employee ?', function(result){
                $("input[name='status']").val(1);
                if(result)
                {
                    $('#exit_interview_form').submit();
                }
            });
        });

        $("#btn_tolak").click(function(){
            bootbox.confirm('Reject Submission Exit Interview & Exit Clearance Employee ?', function(result){
                if(result)
                {
                    $('#exit_interview_form').submit();
                }
            });
        });
    </script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
