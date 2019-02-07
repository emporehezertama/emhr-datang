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
            <form class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
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
                                <label class="col-md-6">NIK / Employee Name</label>
                                <label class="col-md-6">Position</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="" class="form-control" value="{{ $data->user->nik .' - '. $data->user->name }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="" class="form-control" value="{{ empore_jabatan($data->user_id) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Claim Date</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control" value="{{ $data->tanggal_pengajuan }}" />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                        </div>
                        <div class="col-md-6">
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
                                      <th>QTY</th>
                                  </tr>
                              </thead>
                              <tbody class="table-claim">
                                @php ($total = 0)
                                @php ($total_disetujui = 0)
                                @foreach($form as $key => $f)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><input type="text" class="form-control datepicker" readonly="true" name="tanggal_kwitansi[]" value="{{ $f->tanggal_kwitansi }}"  /></td>
                                     <td>
                                        @if($data->user->id == $f->user_family_id)
                                            <input type="text" readonly="true" class="form-control" value="Employee">
                                        @else
                                            <input type="text" readonly="true" class="form-control" value="{{ $f->UserFamily->nama }}">
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->user->id == $f->user_family_id)
                                            <input type="text" readonly="true" class="form-control" value="{{ isset($f->user_family->name) ? $f->user_family->name : ''  }}" />
                                        @else
                                            <input type="text" readonly="true" class="form-control" value="{{ isset($f->UserFamily->nama) ? $f->UserFamily->nama : ''  }}" />
                                        @endif
                                    </td>
                                    <td>
                                        <select class="form-control" readonly>
                                            <option value="">Pilih Jenis Klaim</option>
                                            @foreach(['RJ' => 'RJ (Rawat Jalan)', 'RI' => 'RI (Rawat Inap)', 'MA' => 'MA (Melahirkan)'] as $k => $i)
                                            <option value="{{ $k }}" {{ $f->jenis_klaim == $k ? 'selected' : '' }} >{{ $i }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" required value="{{ number_format($f->jumlah) }}" readonly /></td>
                                    <td><a onclick="show_image('{{ $f->file_bukti_transaksi }}')" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i>Transaction File</a></td>
                                    <td><input type="text" readonly="true" class="form-control" value="{{ number_format($f->nominal_approve) }}"></td>
                                </tr>
                                @php($total += $f->jumlah)
                                @php($total_disetujui += $f->nominal_approve)
                                @endforeach
                              </tbody>
                              <tfoot>
                                  <tr>
                                      <th colspan="5" style="text-align: right;">TOTAL</th>
                                      <th colspan="2">Rp. {{ number_format($total) }}</th>
                                      <th class="th-total-disetujui">Rp. {{ number_format($total_disetujui) }}</th>
                                  </tr>
                              </tfoot>
                          </table>  
                        </div>
                        <br />
                        <br />
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('administrator.overtime.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                                <br style="clear: both;" />
                            </div>
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

        var no = $('.table-claim tr').length;

        var html = '<tr>';
            html += '<td>'+ (no+1) +'</td>';
            html += '<td><input type="text" class="form-control datepicker" name="tanggal_kwitansi[]" /></td>';
            html += '<td><input type="text" class="form-control" name="nama_pasien[]" required /></td>';
            html += '<td><select name="hubungan[]" class="form-control" required=""><option value="">Pilih Hubungan</option><option>Suami</option><option>Istri</option><option>Anak ke 1</option><option>Anak ke 2</option><option>Anak ke 3</option><option>Anak ke 4</option></select></td>';
            html += '<td><select name="jenis_klaim[]" class="form-control"><option value="">Pilih Jenis Klaim</option><option value="RJ">RJ (Rawat Jalan)</option><option value="RI">RI (Rawat Inap)</option><option value="MA">MA (Melahirkan)</option></select></td>';
            html += '<td><input type="number" class="form-control" name="jumlah[]" /></td>';
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
