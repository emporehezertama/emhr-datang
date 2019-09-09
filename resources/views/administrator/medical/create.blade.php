@extends('layouts.administrator')

@section('title', 'Medical Reimbursement')

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
                <h4 class="page-title">Form Medical Reimbursement</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Medical Reimbursement</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.medical.store') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Form Medical Reimbursement</h3>
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
                                    <select name="user_id" class="form-control" required>
                                        <option value="">Choose Employee</option>
                                        @foreach($karyawan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nik .' / '.$item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Position</label>
                                <label class="col-md-6">Division / Departement</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Claim Date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control datepicker" name="tanggal_pengajuan" required />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                        </div>
                        <div class="col-md-6">
                            
                            <br />
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Outpatient</td>
                                        <td>Original slip, Diagnosa, Copy of Prescription, Copy of MRI (if available)</td>
                                    </tr>
                                    <tr>
                                        <td>Inpatient</td>
                                        <td>Original slip, Diagnosa, Copy of Prescription, Copy of MRI (if available)</td>
                                    </tr>
                                    <tr>
                                        <td>Maternity</td>
                                        <td>Original slip, Certificate of Birth</td>
                                    </tr>
                                    <tr>
                                        <td>Eyeglasses</td>
                                        <td>Original slip, Ophthalmologists check up (for the first time)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div>
                          <table class="table table-hover">
                              <thead>
                                  <tr>
                                      <th>NO</th>
                                      <th>RECEIPT DATE</th>
                                      <th>RELATIONSHIP</th>
                                      <th>PATIENT NAME</th>
                                      <th>GENDER</th>
                                      <th>AMOUNT</th>
                                  </tr>
                              </thead>
                              <tbody class="table-claim">
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" class="form-control datepicker" required name="tanggal_kwitansi[]" /></td>
                                    <td>
                                        <select name="user_family_id[]" class="form-control" onchange="select_hubungan(this)" required>
                                            <option value="">Choose Relationship</option>
                                        </select>
                                    </td>
                                    <td><input type="text" readonly="true" class="form-control nama_hubungan" /></td>
                                    <td>
                                        <select name="jenis_klaim[]" class="form-control" required>
                                            <option value="">Pilih Jenis Klaim</option>
                                            @foreach(['RJ' => 'RJ (Rawat Jalan)', 'RI' => 'RI (Rawat Inap)', 'MA' => 'MA (Melahirkan)', 'Kacamata' => 'Kacamata'] as $k => $i)
                                            <option value="{{ $k }}">{{ $i }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control" name="jumlah[]" required /></td>
                                </tr>
                              </tbody>
                          </table>  
                          <span class="btn btn-info btn-xs pull-right" id="add">Add</span>
                        </div>
                        <br />
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('administrator.overtime.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                            <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Submit Medical Reimbursement</button>
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

    var data_dependent = [];
    
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

                var el = '<option value="">Pilih Hubungan</option>';

                $(data.data.dependent).each(function(k, v){
                    
                    el += '<option value="'+ v.id +'" data-nama="'+ v.nama +'">'+ v.hubungan +'</option>';    
                });

                $("select[name='user_family_id[]']").html(el);
            }
        });

    });

    function select_hubungan(el)
    {
        var nama_hubungan = $(el).find(":selected").data('nama');
        
        if(nama_hubungan == "") return false;

        $(el).parent().parent().find('.nama_hubungan').val(nama_hubungan);
    }
    

    $("#add").click(function(){

        var no = $('.table-claim tr').length;

        var html = '<tr>';
            html += '<td>'+ (no+1) +'</td>';

            html += '</tr>';

        $('.table-claim').append(html);

         jQuery('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

    });

</script>


@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
