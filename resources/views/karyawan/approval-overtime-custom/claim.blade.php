@extends('layouts.karyawan')

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
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('karyawan.approval.overtime-custom.prosesClaim') }}" id="form-overtime" method="POST">
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
                            if($history->is_approved_claim != NULL)
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
                                <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th colspan="3" style="text-align: center;">PRE</th>
                                        <th colspan="3" style="text-align: center;">PRE APPROVED</th>
                                        <th colspan="2" style="text-align: center;">FINGER PRINT</th>
                                        <th colspan="3" style="text-align: center;">CLAIM</th>
                                        <th colspan="3" style="text-align: center;">CLAIM APPROVED</th>
                                        <th>OT APPROVED</th>
                                    </tr>
                                    <tr>
                                        <th>NO</th>
                                        <th>DATE</th>
                                        <th>DESCRIPTION</th>
                                        <th>START</th>
                                        <th>END</th>
                                        <th>OT (HOURS)</th>
                                        <th>START</th>
                                        <th>END</th>
                                        <th>OT (HOURS)</th>
                                        <th>IN </th>
                                        <th>OUT </th>
                                        <th>START</th>
                                        <th>END </th>
                                        <th>OT (HOURS)</th>
                                        <th>START</th>
                                        <th>END</th>
                                        <th>OT(HOURS)</th>
                                        <th>CALCULATED</th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-lembur">
                                    @foreach($data->overtime_form as $no => $item)
                                    <tr>
                                        <input type="hidden" name="id_overtime_form[]" class="form-control"  value="{{ $item->id }}" readonly="true">
                                        <td>{{ $no+1 }}</td>
                                        <td><input type="text" style="width: 125px" readonly="true" value="{{ $item->tanggal }}" name="tanggal[]" class="form-control tanggal"></td>
                                        <td><input type="text" style="width: 150px" readonly="true" name="description[]" class="form-control" value="{{ $item->description }}"></td>
                                        <td><input type="text" style="width: 70px" readonly="true" name="awal[]" class="form-control" value="{{ $item->awal }}" /></td>
                                        <td><input type="text" style="width: 70px" readonly="true" name="akhir[]" class="form-control" value="{{ $item->akhir }}" /></td>
                                        <td><input type="text" readonly="true" name="total_lembur[]" class="form-control" value="{{ $item->total_lembur }}" /></td>
                                        <td><input type="text" style="width: 70px" readonly="true" name="pre_awal_approved[]" class="form-control" value="{{ $item->pre_awal_approved }}" /></td>
                                        <td><input type="text" style="width: 70px" readonly="true" name="pre_akhir_approved[]" class="form-control" value="{{ $item->pre_akhir_approved }}" /></td>
                                        <td><input type="text" readonly="true" name="pre_total_approved[]" class="form-control" value="{{ $item->pre_total_approved }}" /></td>
                                        @php($in = overtime_absensi($item->tanggal,$data->user_id))
                                        <td><input type="text" style="width: 70px" readonly="true" class="form-control" value="{{ isset($in) ? $in->clock_in :''}}" /></td>
                                        <td><input type="text" style="width: 70px" readonly="true" class="form-control" value="{{ isset($in) ? $in->clock_out :''}}" /></td>
                                        <td><input type="text" name="awal_claim[]" style="width: 70px"  readonly="true" class="form-control" value="{{ $item->awal_claim }}" /></td>
                                        <td><input type="text" name="akhir_claim[]" style="width: 70px" readonly="true"  class="form-control" value="{{ $item->akhir_claim }}" /></td>
                                        <td><input type="text" name="total_lembur_claim[]" readonly="true" class="form-control total_lembur_claim"  value="{{ $item->total_lembur_claim }}" /></td>
                                        @if($item->awal_approved != null)
                                        <td>
                                            <input type="text" style="width: 70px" name="awal_approved[]" class="form-control time-picker awal_approved" {{$readonly}} value="{{ $item->awal_approved }}" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 70px" name="akhir_approved[]" class="form-control time-picker akhir_approved" {{$readonly}} value="{{ $item->akhir_approved }}" />
                                        </td>
                                        <td>
                                            <input type="text" id ="total_lembur_approved[]" name="total_lembur_approved[]" readonly="true" class="form-control total_lembur_approved" value="{{ $item->total_lembur_approved }}" />
                                        </td>
                                        @endif
                                        @if($item->awal_approved == null)
                                         <td>
                                            <input type="text" style="width: 70px" name="awal_approved[]" class="form-control time-picker awal_approved" value="{{ $item->awal_claim }}" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 70px" name="akhir_approved[]" class="form-control time-picker akhir_approved" value="{{ $item->akhir_claim }}" />
                                        </td>
                                        <td>
                                            <input type="text" name="total_lembur_approved[]" readonly="true" class="form-control total_lembur_approved" value="{{ $item->total_lembur_claim }}" />
                                        </td>
                                        @endif
                                        <td><input type="text" name="overtime_calculate[]" readonly="true" class="form-control overtime_calculate" value="{{ $item->overtime_calculate }}" /></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control note" value="{{ $history->note }}">
                            </div>
                            @if($history->note_claim != NULL)
                            <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control note_claim" value="{{ $history->note_claim }}">
                            </div>
                            @else
                            <div class="col-md-6">
                                 <textarea class="form-control note_claim" name="note_claim" placeholder="Note Claim Approval "></textarea>
                            </div>
                             @endif
                            
                        <input type="hidden" name="status" value="0" />
                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="clearfix"></div>
                        <br />
                         <a href="{{ route('karyawan.approval.overtime-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        @if($history->is_approved_claim === NULL and $data->status_claim < 2)
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
    
    $(document).ready(function () {
        sum_total_ot();
        sum_total_approved();
    });
    jQuery('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
    });

    // Clock pickers
    $('.time-picker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    sum_total_approved();

    function sum_total_ot(){
         $("input.total_lembur_approved").each(function(){
            var total_lembur = $(this).parent().find('.total_lembur_approved').val();

            var date = $(this).parent().parent().find('.tanggal').val();
            date = new Date(date);
                
                var total_hours = total_lembur.split(':')[0];
                var total_minutes = (total_lembur.split(':')[1])/60;
                var overtime_calculate = 0;
                var el = $(this);
                var tanggal = date.getFullYear() + "-"+ (date.getMonth()+1) + "-" + date.getDate();

                var dateAjax = false;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.get-date-overtime-custom') }}',
                    data: {'date' : tanggal ,'_token' : $("meta[name='csrf-token']").attr('content') },
                    dataType: 'json',
                    success: function (data) {
                        dateAjax = data.result;
                        // jika tanggal masuk hari libur
                        if(date.getDay() == 6 || date.getDay() == 0 || dateAjax)
                        {
                            //pembulatan menit ke 60
                            if(total_hours < 8)
                            {
                                overtime_calculate = (total_hours * 2) + (total_minutes * 2);
                            }else if (total_hours == 8)
                            {
                                overtime_calculate = (total_hours * 2) + (total_minutes * 3);
                            }else if(total_hours == 9)
                            {
                                overtime_calculate = (8 * 2) + (1*3)+(total_minutes * 4);
                            }else if(total_hours >=10)
                            {
                                overtime_calculate = (8 * 2) + (1*3)+((total_hours-9)*4)+(total_minutes * 4);
                            }
                        }
                        else
                        {
                            if(total_hours < 2 )
                            {
                                if(total_hours == 0)
                                {
                                    overtime_calculate = total_minutes * 1.5;
                                }else{
                                    overtime_calculate = (1*1.5) + (total_minutes*2); 
                                }                     
                            }
                            else if(total_hours >= 2)
                            {
                                overtime_calculate = ((total_hours -1) * 2) + 1.5 + (total_minutes*2);
                            }
                        }
                    el.parent().parent().find('.overtime_calculate').val(overtime_calculate); 
                    }
                });

                

         });
                
    }
    
    function sum_total_approved()
    {

        $("input.awal_approved, input.akhir_approved").each(function(){
            $(this).on('change', function(){

                var start = $(this).parent().parent().find('.awal_approved').val(),
                    end = $(this).parent().parent().find('.akhir_approved').val();

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
                var jam = (hours <= 9 ? "0" : "") + hours;
                var menit = (minutes <= 9 ? "0" : "") + minutes;

                $(this).parent().parent().find('.total_lembur_approved').val(result);
                var date = $(this).parent().parent().find('.tanggal').val();
                
                    date = new Date(date);

                var tanggal = date.getFullYear() + "-"+ (date.getMonth()+1) + "-" + date.getDate();

                //var total = hours-a;
                var total_hours = hours;
                var total_minutes = minutes/60;
                var overtime_calculate = 0;
                var el = $(this);
                
                var dateAjax = false;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.get-date-overtime-custom') }}',
                    data: {'date' : tanggal ,'_token' : $("meta[name='csrf-token']").attr('content') },
                    dataType: 'json',
                    success: function (data) {
                        dateAjax = data.result;

                        // jika tanggal masuk hari libur
                        if(date.getDay() == 6 || date.getDay() == 0 || dateAjax)
                        {
                            //pembulatan menit ke 60
                            if(total_hours < 8)
                            {
                                overtime_calculate = (total_hours * 2) + (total_minutes * 2);
                            }else if (total_hours == 8)
                            {
                                overtime_calculate = (total_hours * 2) + (total_minutes * 3);
                            }else if(total_hours == 9)
                            {
                                overtime_calculate = (8 * 2) + (1*3)+(total_minutes * 4);
                            }else if(total_hours >=10)
                            {
                                overtime_calculate = (8 * 2) + (1*3)+((total_hours-9)*4)+(total_minutes * 4);
                            }
                        }
                        else
                        {
                            if(total_hours < 2 )
                            {
                                if(total_hours == 0)
                                {
                                    overtime_calculate = total_minutes * 1.5;
                                }else{
                                    overtime_calculate = (1*1.5) + (total_minutes*2); 
                                }                     
                            }
                            else if(total_hours >= 2)
                            {
                                overtime_calculate = ((total_hours -1) * 2) + 1.5 + (total_minutes*2);
                            }
                        }

                       // console.log(dateAjax);
                       el.parent().parent().find('.overtime_calculate').val(overtime_calculate);
                    }
                });

                
                //$(this).parent().parent().find('.overtime_calculate').val(dateAjax); 
                
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
