@extends('layouts.karyawan')

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
            <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data" action="{{ route('karyawan.overtime.store') }}" method="POST">
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
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ empore_jabatan(\Auth::user()->id) }}">
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
                                            <th>TOTAL OVERTIME (HOUR'S)</th>
                                            <th>OVERTIME CALCULATED</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-content-lembur">
                                        <tr>
                                            <td>1</td>
                                            <td><input type="text" name="tanggal[]" class="form-control datepicker date_overtime"></td>
                                            <td><input type="text" name="description[]" class="form-control"></td>
                                            <td><input type="text" name="awal[]" class="form-control time-picker awal" /></td>
                                            <td><input type="text" name="akhir[]" class="form-control time-picker akhir" /></td>
                                            <td><input type="text" name="total_lembur[]" class="form-control total_lembur" readonly="true" /></td>
                                            <td><input type="text" name="overtime_calculated[]" class="form-control overtime_calculated" readonly="true" /></td>
                                            <td><a class="btn btn-danger btn-xs" onclick="hapus_(this)"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a class="btn btn-info btn-xs pull-right" id="add"><i class="fa fa-plus"></i> Add</a>
                            </div>
                        </div>
                        <hr />

                        <h4><b>Approval</b></h4>
                        <div class="col-md-6" style="border: 1px solid #eee; padding: 15px">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control autcomplete-atasan" placeholder="Select Superior  / Supervisor">
                                    <input type="hidden" name="atasan_user_id" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Position</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan_atasan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Mobile Number</label>
                                <label class="col-md-6">Email</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control no_handphone_atasan">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control email_atasan">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <a href="{{ route('karyawan.overtime.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
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
<script type="text/javascript">
    var list_atasan = [];

    @foreach(empore_get_atasan_langsung() as $item)
        list_atasan.push({id : {{ $item->id }}, value : '{{ $item->nik .' - '. $item->name.' - '. empore_jabatan($item->id) }}',  });
    @endforeach
</script>
<script type="text/javascript">
    $(".autcomplete-atasan" ).autocomplete({
        source: list_atasan,
        minLength:0,
        select: function( event, ui ) {
            $( "input[name='atasan_user_id']" ).val(ui.item.id);

            var id = ui.item.id;

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-karyawan-by-id') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    $('.jabatan_atasan').val(data.data.jabatan);
                    $('.department_atasan').val(data.data.department_name);
                    $('.no_handphone_atasan').val(data.data.telepon);
                    $('.email_atasan').val(data.data.email);
                }
            });
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });

    $("#btn_submit").click(function(){

        var total = $('.table-content-lembur tr').length;

        if(total == 0) return false;

        if($("input[name='atasan_user_id']").val() == "")
        {
            bootbox.alert('You must choose Approval!');
            return false;
        }
        bootbox.confirm('Do you want to submit Overtime?', function(result){
            if(result)
            {
                $('form.form-horizontal').submit();
            }
        });
    });

    hitung_total_lembur();

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
            html += '<td><input type="text" name="tanggal[]" class="form-control datepicker"></td>';
            html += '<td><input type="text" name="description[]" class="form-control"></td>';
            html += '<td><input type="text" name="awal[]" class="form-control time-picker awal" /></td>';
            html += '<td><input type="text" name="akhir[]" class="form-control time-picker akhir" /></td>';
            html += '<td><input type="text" name="total_lembur[]" class="form-control total_lembur" readonly="true" /></td>';
            html += '<td><input type="text" name="overtime_calculated[]" class="form-control overtime_calculated" readonly="true" /></td>';
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

                var timeOfCall = $(this).parent().parent().find('.awal').val(),
                    timeOfResponse = $(this).parent().parent().find('.akhir').val();

                if(timeOfCall =="" || timeOfResponse == "") { return false; }

                var hours = timeOfResponse.split(':')[0] - timeOfCall.split(':')[0],
                    minutes = timeOfResponse.split(':')[1] - timeOfCall.split(':')[1];

                if (timeOfCall <= "12:00:00" && timeOfResponse >= "13:00:00"){
                    a = 1;
                } else {
                    a = 0;
                }

                minutes = minutes.toString().length<2?'0'+minutes:minutes;
                
                if(minutes<0){
                    hours--;
                    minutes = 60 + minutes;
                }

                hours = hours.toString().length<2?'0'+hours:hours;

                $(this).parent().parent().find('.total_lembur').val(hours-a+ ':' + minutes);

                var date = $(this).parent().parent().find('.date_overtime').val();
                    date = new Date(date);

                var total_lembur = hours-a;
                var total_overtime_calculated = 0;

                // jika tanggal masuk hari libur
                if(date.getDay() == 6 || date.getDay() == 0)
                {
                    //$('.overtime_calculated').val( total_lembur * 1.5 );   
                }
                else
                {
                    if(total_lembur < 2 )
                    {
                        total_overtime_calculated = 1 * 1.5;                        
                    }
                    else if(total_lembur >= 2)
                    {
                        total_overtime_calculated = total_lembur * 2 + 1.5;                        

                    }

                    $('.overtime_calculated').val( total_overtime_calculated );                       
                }
            });
        });
    }
</script>
@endsection
@endsection
