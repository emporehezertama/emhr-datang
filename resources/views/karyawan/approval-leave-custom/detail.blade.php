@extends('layouts.karyawan')

@section('title', 'Employee Leave')

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
                <h4 class="page-title">Form Employee Leave</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Employee Leave</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" id="form-cuti" enctype="multipart/form-data" action="{{ route('karyawan.approval.leave-custom.proses') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Form Leave</h3>
                        <hr />
                        <br />
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
                                    <input type="text" class="form-control" value="{{ $datas->karyawan->nik .' / '. $datas->karyawan->name }}" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Position</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ isset($datas->karyawan->structure->position) ? $datas->karyawan->structure->position->name:''}}{{ isset($datas->karyawan->structure->division) ? '-'. $datas->karyawan->structure->division->name:''}}">
                                </div>
                            </div>
                            <div class="form-group" id="LeaveType">
                                <label class="col-md-6">Leave Quota</label>
                                <label class="col-md-3">Leave Taken</label>
                                <label class="col-md-3">Leave Balance</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control kuota_cuti"  value="{{ $datas->temp_kuota }}" readonly="true" />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control cuti_terpakai" readonly="true" value="{{ $datas->temp_cuti_terpakai }}"  />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" readonly="true" class="form-control sisa_cuti" value="{{ $datas->temp_sisa_cuti }}">
                                </div>
                            </div>
                            <div class="form-group">
                                @if($history->note != NULL)
                                <div class="col-md-12">
                                    <input type="text" readonly="true" class="form-control note" value="{{ $history->note }}">
                                </div>
                                @else
                                <div class="col-md-12">
                                    <textarea class="form-control note" name="note" placeholder="Note"></textarea>
                                </div>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <br />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-12">Date of Leave</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control datepicker" value="{{ $datas->tanggal_cuti_start }}" readonly="true" />
                                </div>
                                <div class="col-md-5 p-l-0">
                                    <input type="text" class="form-control datepicker" value="{{ $datas->tanggal_cuti_end }}" readonly="true">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" value="{{ $datas->total_cuti }} Days" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Leave /Permit Description</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ $datas->cuti->description }}" readonly="true">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" value="{{ $datas->jam_pulang_cepat }}" readonly="true">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" value="{{ $datas->jam_datang_terlambat }}" readonly="true">
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Purpose</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" readonly="true">{{ $datas->keperluan }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Backup Person</label>
                                <div class="col-md-12"> 
                                    <input type="text" readonly="true" value="{{ $datas->backup_karyawan->name }}" class="form-control">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-12">Position</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control" value="{{ isset($datas->backup_karyawan->structure->position) ? $datas->backup_karyawan->structure->position->name:''}}{{ isset($datas->backup_karyawan->structure->division) ? '-'. $datas->backup_karyawan->structure->division->name:''}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Mobile Number</label>
                                <label class="col-md-6">Email</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control no_handphone" value="{{ $datas->backup_karyawan->mobile_1 }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control email" value="{{ $datas->backup_karyawan->email }}">
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="status" value="0" />
                        <input type="hidden" name="id" value="{{ $datas->id }}">

                        <div class="clearfix"></div>
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('karyawan.approval.leave-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                            @if($history->is_approved === NULL and $datas->status < 2)
                            <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-save"></i> Approve</a>
                            <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Denied</a>
                            @endif

                           
                            <br style="clear: both;" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @extends('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@section('footer-script')
LeaveType
    <script type="text/javascript">
        $("#btn_approved").click(function(){
            bootbox.confirm('Approve the leave form ?', function(result){

                $("input[name='status']").val(1);
                if(result)
                {
                    $('#form-cuti').submit();
                }

            });
        });

        $("#btn_tolak").click(function(){
            bootbox.confirm('Reject the leave form ?', function(result){

                if(result)
                {
                    $('#form-cuti').submit();
                }

            });
        });
    </script>
@endsection

@endsection
