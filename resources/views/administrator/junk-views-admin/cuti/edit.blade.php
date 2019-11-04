@extends('layouts.administrator')

@section('title', 'Cuti / Ijin Karyawan')

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
                <h4 class="page-title">Form Leave / Permit Employee</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Leave / Permit Employee</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.cuti.update', $data->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
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
                                    <select name="user_id" class="form-control">
                                        <option value="">Choose Employee</option>
                                        @foreach($karyawan as $item)
                                        <option value="{{ $item->id }}" {{ $data->user_id == $item->id ? 'selected' : '' }} >{{ $item->nik .' / '.$item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Position</label>
                                <label class="col-md-6">Division / Departement</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ empore_jabatan($item->user_id) }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control department" value="{{ isset($data->karyawan->department->name) ? $data->karyawan->department->name ; '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Leave Quota</label>
                                <label class="col-md-6">Leave taken</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control hak_cuti" name="" readonly="true" value="{{ $data->karyawan->hak_cuti }}" />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control cuti_terpakai" name="" readonly="true" value="{{ $data->karyawan->cuti_yang_terpakai }}" />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-12">Date of Leave</label>
                                <div class="col-md-6">
                                    <input type="text" name="tanggal_cuti_start" class="form-control datepicker" placeholder="Start Date" value="{{ $data->tanggal_cuti_start }}" />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="tanggal_cuti_end" class="form-control datepicker" placeholder="End Date" value="{{ $data->tanggal_cuti_end }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Leave Type</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="jenis_cuti">
                                        <option value="">Choose Leave Type</option>
                                        @foreach(['Cuti Tahunan','Izin Khusus (PP pasal 24 ayat 2)'] as $item)
                                        <option {{ $data->jenis_cuti == $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Purpose</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="keperluan">{{ $data->keperluan }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Backup Person</label>
                                <div class="col-md-12">
                                    <select name="backup_user_id" class="form-control" required>
                                        <option value="">Choose Backup Person</option>
                                        @foreach($karyawan as $item)
                                        <option value="{{ $item->id }}" {{ $data->backup_user_id == $item->id ? 'selected' : '' }}>{{ $item->nik .' / '.$item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-6">Position</label>
                                <label class="col-md-6">Division / Departement</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan_backup" value="{{ $data->backup_karyawan->nama_jabatan }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control department_backup" value="{{ $data->backup_karyawan->department->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('administrator.overtime.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                            <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Submit Form Leave</button>
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
@section('footer-script')
<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">

    jQuery('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });
    
    $("select[name='backup_user_id']").on('change', function(){

        var id = $(this).val();

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-karyawan-by-id') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                $('.jabatan_backup').val(data.data.nama_jabatan);
                $('.department_backup').val(data.data.department_name);
            }
        });

    });

    $("select[name='user_id']").on('change', function(){

        var id = $(this).val();

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-karyawan-by-id') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                $('.hak_cuti').val(data.data.hak_cuti);
                $('.jabatan').val(data.data.nama_jabatan);
                $('.department').val(data.data.department_name);
                $('.cuti_terpakai').val(data.data.cuti_yang_terpakai);

                $("select[name='backup_user_id'] option[value="+ id +"]").remove();
            }
        });

    });


    $("#add").click(function(){

        var no = $('.table-content-lembur tr').length;

        var html = '<tr>';
            html += '<td>'+ (no+1) +'</td>';
            html += '<td><textarea name="description[]" class="form-control"></textarea></td>';
            html += '<td><input type="text" name="awal[]" class="form-control" /></td>';
            html += '<td><input type="text" name="akhir[]" class="form-control" /></td>';
            html += '<td><input type="text" name="total_lembur[]" class="form-control"  /></td>';
            html += '<td><select name="employee_id" class="form-control"><option value="">Choose Employee</option></select></td>';
            html += '<td><select name="employee_id" class="form-control"><option value="">Choose SPV</option></select></td>';
            html += '<td><select name="employee_id" class="form-control"><option value="">Choose Manager</option></select></td>';
            html += '</tr>';

        $('.table-content-lembur').append(html);

    });

</script>


@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
