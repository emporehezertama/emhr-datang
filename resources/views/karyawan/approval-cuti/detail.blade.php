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
            <form class="form-horizontal" id="form-cuti" enctype="multipart/form-data" action="{{ route('karyawan.approval.cuti.proses') }}" method="POST">
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
                                    <input type="text" class="form-control" value="{{ $data->karyawan->nik .' / '. $data->karyawan->name }}" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Position</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ empore_jabatan($data->karyawan->id) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Leave Quota</label>
                                <label class="col-md-3">Leave Taken</label>
                                <label class="col-md-3">Leave Balance</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control kuota_cuti"  value="{{ $data->temp_kuota }}" readonly="true" />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control cuti_terpakai" readonly="true" value="{{ $data->temp_cuti_terpakai }}"  />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" readonly="true" class="form-control sisa_cuti" value="{{ $data->temp_sisa_cuti }}">
                                </div>
                            </div>
                            <div class="form-group">
                                @if($data->approve_direktur != NULL)
                                <div class="col-md-12">
                                    <input type="text" readonly="true" class="form-control approve_direktur_noted" value="{{ $data->approve_direktur_noted }}">
                                </div>
                                @else
                                <div class="col-md-12">
                                    <textarea class="form-control noted" name="noted" placeholder="Note"></textarea>
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
                                    <input type="text" class="form-control datepicker" value="{{ $data->tanggal_cuti_start }}" readonly="true" />
                                </div>
                                <div class="col-md-5 p-l-0">
                                    <input type="text" class="form-control datepicker" value="{{ $data->tanggal_cuti_end }}" readonly="true">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" value="{{ $data->total_cuti }} Day's" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Leave Type</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" value="{{ $data->cuti->jenis_cuti }}" readonly="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Purpose</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" readonly="true">{{ $data->keperluan }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Backup Person</label>
                                <div class="col-md-12"> 
                                    <input type="text" readonly="true" value="{{ $data->backup_karyawan->name }}" class="form-control">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-12">Position</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control" value="{{ empore_jabatan($data->backup_karyawan->id) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Mobile Number</label>
                                <label class="col-md-6">Email</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control no_handphone" value="{{ $data->backup_karyawan->telepon }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control email" value="{{ $data->backup_karyawan->email }}">
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="status" value="0" />
                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="clearfix"></div>
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('karyawan.approval.cuti.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                            @if($data->is_approved_atasan ==1 and $data->approve_direktur === NULL and $data->status < 3)
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
