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
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('karyawan.overtime.store') }}" method="POST">
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
                        
                        <div class="form-group">
                            <label class="col-md-6">NIK / Employee Name</label>
                            <label class="col-md-6">Position</label>
                            <div class="col-md-6">
                                <select class="form-control" name="user_id">
                                    <option>Choose Employee</option>
                                    @foreach($karyawan as $item)
                                    <option value="{{ $item->id }}"> {{ $item->nik }} - {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control jabatan" value="{{ Auth::user()->nama_jabatan }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6">Department</label>
                            <label class="col-md-6">Branch</label>
                            <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control department" value="{{ isset(Auth::user()->department) ? Auth::user()->department->name : '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control kantor_cabang" value="{{ isset(Auth::user()->cabang) ? Auth::user()->cabang->name : '' }}" >
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
                                        <th>TOTAL OVERTIME (HOURS)</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-lembur">
                                </tbody>
                            </table>
                            <a class="btn btn-info btn-xs pull-right" id="add"><i class="fa fa-plus"></i> Add</a>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                    
                        <a href="{{ route('administrator.overtime.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <a  class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_submit"><i class="fa fa-save"></i> Submit Overtime</a>
                        <br style="clear: both;" />
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

<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<link href="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
<!-- Clock Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
<script type="text/javascript">

    $("#btn_submit").click(function(){

        var total = $('.table-content-lembur tr').length;

        if(total == 0) return false;

        bootbox.confirm('Apakah anda ingin mengajukan Overtime ?', function(result){

            if(result)
            {
                $('form.form-horizontal').submit();
            }
        });

    });

    jQuery('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
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
                $('.kantor_cabang').val(data.data.cabang_name);
            }
        });

    });

    $("#add").click(function(){

        var no = $('.table-content-lembur tr').length;

        var html = '<tr>';
            html += '<td>'+ (no+1) +'</td>';
            html += '<td><input type="text" name="tanggal[]" class="form-control datepicker" required></td>';
            html += '<td><textarea name="description[]" class="form-control" required></textarea></td>';
            html += '<td><input type="text" name="awal[]" class="form-control time-picker awal" required /></td>';
            html += '<td><input type="text" name="akhir[]" class="form-control time-picker akhir" required /></td>';
            html += '<td><input type="text" name="total_lembur[]" class="form-control total_lembur" readonly="true" required /></td>';
            html += '<td><a class="btn btn-danger btn-xs" onclick="hapus_(this)">hapus</a></td>';
            html += '</tr>';

        $('.table-content-lembur').append(html);

        $('.time-picker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });

        jQuery('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

        hitung_total_lembur();
    });

    function hapus_(el)
    {
        $(el).parent().parent().remove();
    }

    function hitung_total_lembur()
    {
        $("input.awal, input.akhir").on('change', function(){

            var timeOfCall = $('.awal').val(),
                timeOfResponse = $('.akhir').val();
            
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
        });
    }

</script>


@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
