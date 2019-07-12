@extends('layouts.administrator')

@section('title', 'Overtime Sheet')

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
                <h4 class="page-title">Form Overtime Sheet</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Overtime Sheet</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.approval.overtime-custom.proses') }}" id="form-overtime" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Data Overtime Sheet</h3>
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
                         <?php
                            $readonly = ''; 
                            if($history->is_approved != NULL)
                            {
                                $readonly = ' readonly="true"'; 
                            }
                        ?>
                        
                        <div class="form-group">
                            <label class="col-md-12">NIK / Employee Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $data->user->nik .' - '. $data->user->name  }}" readonly="true" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Position</label>
                            <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control" value="{{ isset($data->user->structure->position) ? $data->user->structure->position->name:''}}{{ isset($data->user->structure->division) ? '-'. $data->user->structure->division->name:'' }}">
                            </div>
                        </div>
                       
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-hover manage-u-table">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>DATE</th>
                                        <th>DESCRIPTION</th>
                                        <th>START</th>
                                        <th>END</th>
                                        <th>OT (HOURS)</th>
                                        <th>START APPROVED</th>
                                        <th>END APPROVED</th>
                                        <th>OT (HOURS) APPROVED</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-lembur">
                                    @foreach($data->overtime_form as $no => $item)
                                    <tr>
                                        <input type="hidden" name="id_overtime_form[]" class="form-control"  value="{{ $item->id }}" readonly="true">
                                        <td>{{ $no+1 }}</td>
                                        <td><input type="text" readonly="true" value="{{ $item->tanggal }}" class="form-control"></td>
                                        <td><input type="text" readonly="true" class="form-control" value="{{ $item->description }}"></td>
                                        <td><input type="text" readonly="true" class="form-control" value="{{ $item->awal }}" /></td>
                                        <td><input type="text" readonly="true" class="form-control" value="{{ $item->akhir }}" /></td>
                                        <td><input type="text" readonly="true" class="form-control" value="{{ $item->total_lembur }}" /></td>

                                        @if($item->pre_awal_approved != null)
                                        <td>
                                            <input type="text" name="pre_awal_approved[]" class="form-control time-picker pre_awal_approved" {{$readonly}} value="{{ $item->pre_awal_approved }}" />
                                        </td>
                                        <td>
                                            <input type="text" name="pre_akhir_approved[]" class="form-control time-picker pre_akhir_approved" {{$readonly}} value="{{ $item->pre_akhir_approved }}" />
                                        </td>
                                        <td>
                                            <input type="text" id ="pre_total_approved[]" name="pre_total_approved[]" readonly="true" class="form-control pre_total_approved" value="{{ $item->pre_total_approved }}" />
                                        </td>
                                        @endif
                                        @if($item->pre_awal_approved == null)
                                         <td>
                                            <input type="text" name="pre_awal_approved[]" class="form-control time-picker pre_awal_approved" value="{{ $item->awal }}" />
                                        </td>
                                        <td>
                                            <input type="text" name="pre_akhir_approved[]" class="form-control time-picker pre_akhir_approved" value="{{ $item->akhir }}" />
                                        </td>
                                        <td>
                                            <input type="text" name="pre_total_approved[]" readonly="true" class="form-control pre_total_approved" value="{{ $item->total_lembur }}" />
                                        </td>
                                        @endif
                                         <td>
                                            @if($data->status < 2)
                                            <a class="btn btn-danger btn-xs" onclick="cancel_(this)"><i class="fa fa-trash"></i>Cancel</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <div class="form-group">
                            @if($history->note != NULL)
                            <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control note" value="{{ $history->note }}">
                            </div>
                            @else
                            <div class="col-md-6">
                                <textarea class="form-control noteApproval" name="noteApproval" placeholder="Note Approval"></textarea>
                            </div>
                            @endif
                            
                        <input type="hidden" name="status" value="0" />
                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="clearfix"></div>
                        <br />
                         <a href="{{ route('administrator.approval.overtime-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        @if($history->is_approved === NULL and $data->status < 2)
                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-check"></i> Approve</a>
                        <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Reject</a>
                        @endif


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
@section('footer-script')
<link href="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>

<script type="text/javascript">
    function cancel_(el)
    {
        var result = "00:00";
        $(el).parent().parent().find('.pre_awal_approved').val(result);
        $(el).parent().parent().find('.pre_akhir_approved').val(result);
        $(el).parent().parent().find('.pre_total_approved').val(result);
        //$(el).parent().parent().find('.awal_claim').setAttribute('value','My default value');
    }
</script>

<script type="text/javascript">
    $('.time-picker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    sum_total_pre();

    function sum_total_pre()
    {
        $("input.pre_awal_approved, input.pre_akhir_approved").each(function(){

            $(this).on('change', function(){

                var start = $(this).parent().parent().find('.pre_awal_approved').val(),
                    end = $(this).parent().parent().find('.pre_akhir_approved').val();

                if(start =="" || end == "") { return false; } 
                
                start = start.split(":");
                end = end.split(":");
                var startDate = new Date(0, 0, 0, start[0], start[1], 0);
                var endDate = new Date(0, 0, 0, end[0], end[1], 0);
                var diff = endDate.getTime() - startDate.getTime();
                var hours = Math.floor(diff / 1000 / 60 / 60);
                diff -= hours * 1000 * 60 * 60;
                var minutes = Math.floor(diff / 1000 / 60);

                // If using time pickers with 24 hours format, add the below line get exact hours
                if (hours < 0)
                    hours = hours + 24;

                var result =  (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;

                $(this).parent().parent().find('.pre_total_approved').val(result);
           
            });
        });
    }

   
    $("#btn_approved").click(function(){
        bootbox.confirm('Approve Employee Overtime ?', function(result){

            $("input[name='status']").val(1);
            if(result)
            {
                $('#form-overtime').submit();
            }

        });
    });

    $("#btn_tolak").click(function(){
        bootbox.confirm('Reject Employee Overtime ?', function(result){

            if(result)
            {
                $('#form-overtime').submit();
            }

        });
    });

</script>


@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
