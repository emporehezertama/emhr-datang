@extends('layouts.karyawan')

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
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('karyawan.medical.store') }}" id="form-medical" method="POST"  autocomplete="off">
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
                                    <input type="text" readonly="" class="form-control" value="{{ Auth::user()->nik .' - '. Auth::user()->name }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="" class="form-control" value="{{ empore_jabatan(Auth::user()->id) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Claim Date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ date('Y-m-d') }}" name="tanggal_pengajuan" readonly="true" />
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
                                      <th>CLAIM TYPE</th>
                                      <th>QTY</th>
                                      <th>FILE</th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody class="table-claim">
                                <tr class="oninput">
                                    <td>1</td>
                                    <td><input type="text" class="form-control datepicker input" required name="tanggal_kwitansi[]" /></td>
                                    <td>
                                        <select name="user_family_id[]" class="form-control input" onchange="select_hubungan(this)" required>
                                            <option value="">Choose Relationship</option>
                                            <option value="{{ \Auth::user()->id }}" data-nama="{{ \Auth::user()->name }}">Saya Sendiri</option>
                                            @foreach(Auth::user()->userFamily as $item)
                                            <option value="{{ $item->id }}" data-nama="{{ $item->nama }}">{{ $item->hubungan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" readonly="true" class="form-control nama_hubungan input" /></td>
                                    <td>
                                        <select name="jenis_klaim[]" class="form-control input" required>
                                            <option value="">Choose Claim Type</option>
                                            @foreach(jenis_claim_medical() as $k => $i)
                                            <option value="{{ $k }}">{{ $i }}</option>
                                            @endforeach
                                        </select>
                                    </td> 
                                    <td><input type="number" class="form-control input" name="jumlah[]" required /></td>
                                    <td><input type="file" class="form-control input" name="file_bukti_transaksi[]" required /></td>
                                    <td></td>
                                </tr>
                              </tbody>
                              <tfoot>
                                  <tr>
                                      <th colspan="5" style="text-align: right;">TOTAL : </th>
                                      <th class="th-total"></th>
                                  </tr>
                              </tfoot>
                          </table>
                          <span class="btn btn-info btn-xs pull-right" id="add">Add</span>
                        </div>

                        <h4><b>Approval</b></h4>
                        <div class="col-md-6" style="border: 1px solid #eee; padding: 15px">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control autcomplete-atasan" placeholder="Select Superior  / Atasan Langsung">
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
                                <label class="col-md-6">Handphone</label>
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
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('administrator.overtime.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_submit"><i class="fa fa-save"></i> Submit Medical Reimbursement</a>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

    var list_atasan = [];
    @foreach(empore_get_atasan_langsung() as $item)
    list_atasan.push({id : {{ $item->id }}, value : '{{ $item->nik .' - '. $item->name.' - '. empore_jabatan($item->id) }}',  });
    @endforeach
</script>
<script type="text/javascript">

    validate_form = true;

    show_hide_add();
    cek_button_add();

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

    jQuery('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    var data_dependent = [];

    $("#btn_submit").click(function(){

        if(!validate_form){
            bootbox.alert('Form must be filled ?');

            return false;
        }

        if($("input[name='atasan_user_id']").val() == ""){
            bootbox.alert('Approval name must be chosen !');
            return false;
        }

        bootbox.confirm('Process Form Medical Reimbursement ?', function(result){
            if(result)
            {
                $("#form-medical").submit();
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

        var html =  '<tr class="oninput">'+
                        '<td>'+(no+1)+'</td>'+
                        '<td><input type="text" class="form-control datepicker input" required name="tanggal_kwitansi[]" /></td>'+
                        '<td>'+
                            '<select name="user_family_id[]" class="form-control input" onchange="select_hubungan(this)" required>'+
                                '<option value="">Pilih Hubungan</option><option value="{{ \Auth::user()->id }}" data-nama="{{ \Auth::user()->name }}">Saya Sendiri</option>@foreach(Auth::user()->userFamily as $item)<option value="{{ $item->id }}" data-nama="{{ $item->nama }}">{{ $item->hubungan }}</option>@endforeach'+
                            '</select>'+
                        '</td>'+
                        '<td><input type="text" readonly="true" class="form-control nama_hubungan" /></td>'+
                        '<td>'+
                            '<select name="jenis_klaim[]" class="form-control input" required>'+
                                '<option value="">Pilih Jenis Klaim</option>@foreach(jenis_claim_medical() as $k => $i)<option value="{{ $k }}">{{ $i }}</option>@endforeach'+
                            '</select>'+
                        '</td>'+
                        '<td><input type="number" class="form-control input" name="jumlah[]" required /></td>'+
                        '<td><input type="file" class="form-control input" name="file_bukti_transaksi[]" required /></td>'+
                        '<td><a class="btn btn-danger btn-xs" onclick="hapus_item(this)"><i class="fa fa-trash"></i></a></td>'+
                        '</tr>';

        $('.table-claim').append(html);

        jQuery('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        cek_button_add();
        show_hide_add();
    });

function show_hide_add()
{
    $("#add").show();
    validate_form = true;
    $('.oninput .input').each(function(){

        if($(this).val() == "")
        {
            $("#add").hide();
            validate_form = false;
        }
    });

    var total_nominal = 0;
    $(".oninput input[name='jumlah[]']").each(function(){
        if($(this).val() != "")
        {
            total_nominal += parseInt($(this).val());
        }
    });

    $('.th-total').html(numberWithComma(total_nominal));

}

function cek_button_add()
{
    $('.oninput input').on('keyup',function(){
        show_hide_add();
    });

    $('.oninput input').on('change',function(){
        show_hide_add();
    });

    $('.oninput select').on('change',function(){
        show_hide_add();
    });
}

function hapus_item(el)
{
    if(confirm("Hapus item ?"))
    {
        $(el).parent().parent().remove();
        cek_button_add()
    }
}

</script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
