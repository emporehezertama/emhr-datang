@extends('layouts.administrator')

@section('title', 'Overtime Sheet')

@section('content')
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
        </div>
        <div class="row">
            <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data" action="{{ route('administrator.overtime-custom.store') }}" method="POST">
                <div class="col-md-12 p-l-0 p-r-0">
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
                        <div class="col-md-6 m-b-0">
                            <div class="form-group">
                                <label class="col-md-6">NIK / Employee Name</label>
                                <label class="col-md-6">Position</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ Auth::user()->nik .' - '. Auth::user()->name  }}" readonly="true" />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ isset(Auth::user()->structure->position) ? Auth::user()->structure->position->name:''}}{{ isset(Auth::user()->structure->division) ? '-'. Auth::user()->structure->division->name:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered manage-u-table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>DATE</th>
                                            <th>DESCRIPTION</th>
                                            <th>START</th>
                                            <th>END</th>
                                            <th>TOTAL OVERTIME (HOURS)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-content-lembur">
                                        <!--
                                        <tr>
                                            <td>1</td>
                                            <td><input type="text" name="tanggal[]" class="form-control datepicker date_overtime"></td>
                                            <td><input type="text" name="description[]" class="form-control"></td>
                                            <td><input type="text" name="awal[]" class="form-control time-picker awal" /></td>
                                            <td><input type="text" name="akhir[]" class="form-control time-picker akhir" /></td>
                                            <td><input type="text" name="total_lembur[]" class="form-control total_lembur" readonly="true" /></td>
                                            <td><a class="btn btn-danger btn-xs" onclick="hapus_(this)"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                        -->
                                    </tbody>
                                </table>
                                <a class="btn btn-info btn-xs pull-right" id="add"><i class="fa fa-plus"></i> Add</a>
                            </div>
                        </div>
                        <hr />
                        <div class="clearfix"></div>
                        <br />
                        <a href="{{ route('administrator.overtime-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <a  class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_submit"><i class="fa fa-save"></i> Send Overtime</a>
                        <br style="clear: both;" />
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
@section('footer-script')
<link href="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
<script src="https://momentjs.com/downloads/moment.min.js"></script>

<script type="text/javascript">
    $("#btn_submit").click(function(){

        var total = $('.table-content-lembur tr').length;

        if(total == 0) return false;
        bootbox.confirm('Do you want to submit Overtime?', function(result){
            if(result)
            {
                $('form.form-horizontal').submit();
            }
        });
    });

   
    var disabledDates = [];
        $("input[name='tanggal[]']").each(function(){
            if($(this).val() != "")
            {
                disabledDates.push($(this).val());
            }
        });
    jQuery('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            beforeShowDay: function(date){
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [ disabledDates.indexOf(string) == -1 ]
            }
        });

    hitung_total_lembur();

    /*jQuery('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
    });
*/
    // Clock pickers
    $('.time-picker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $("select[name='user_id']").on('change', function(){

        var id = $(this).val();

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-karyawan-by-id') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                $('.jabatan').val(data.data.nama_jabatan);
                $('.department').val(data.data.department_name);
            }
        });

    });

    $("#add").click(function(){

        var disabledDates = [];
        $("input[name='tanggal[]']").each(function(){
            if($(this).val() != "")
            {
                disabledDates.push($(this).val());
            }
        });

        var no = $('.table-content-lembur tr').length;
        var html = '<tr>';
            html += '<td>'+ (no+1) +'</td>';
            html += '<td><input type="text" name="tanggal[]" class="form-control datepicker date_overtime"></td>';
            html += '<td><input type="text" name="description[]" class="form-control description"></td>';
            html += '<td><input type="text" name="awal[]" class="form-control time-picker awal" /></td>';
            html += '<td><input type="text" name="akhir[]" class="form-control time-picker akhir" /></td>';
            html += '<td><input type="text" name="total_lembur[]" class="form-control total_lembur" readonly="true" /></td>';
            html += '<td><a class="btn btn-danger btn-xs" onclick="hapus_(this)"><i class="fa fa-trash"></i></a></td>';
            html += '</tr>';

        $('.table-content-lembur').append(html);

        $('.time-picker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });

        jQuery('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            beforeShowDay: function(date){
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [ disabledDates.indexOf(string) == -1 ]
            }
        });

        hitung_total_lembur();
    });

    function hapus_(el)
    {
        $(el).parent().parent().remove();
    }

     function hitung_total_lembur()
    {
        $("input.awal, input.akhir").each(function(){

            $(this).on('change', function(){
                var start = $(this).parent().parent().find('.awal').val(),
                    end = $(this).parent().parent().find('.akhir').val();

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

                $(this).parent().parent().find('.total_lembur').val(result);
            });
        });
    }
</script>
@endsection
@endsection
