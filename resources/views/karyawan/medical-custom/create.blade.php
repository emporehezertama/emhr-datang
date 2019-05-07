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
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('karyawan.medical-custom.store') }}" id="form-medical" method="POST"  autocomplete="off">
                <div class="col-md-12">
                    <div class="white-box">
                        
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
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ isset(Auth::user()->structure->position) ? Auth::user()->structure->position->name:''}}{{ isset(Auth::user()->structure->division) ? '-'. Auth::user()->structure->division->name:''}}">
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
                                      <th>RECEIPT NO/ KWITANSI NO</th>
                                      <th>QTY</th>
                                      <th>FILE</th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody class="table-claim">
                                <!--
                                <tr class="oninput">
                                    <td>1</td>
                                    <td><input type="text" class="form-control datepicker input" required name="tanggal_kwitansi[]" /></td>
                                    <td>
                                        <select name="user_family_id[]" class="form-control input" onchange="select_hubungan(this)" required>
                                            <option value="">Choose Relationship</option>
                                            <option value="{{ \Auth::user()->id }}" data-nama="{{ \Auth::user()->name }}">My Self</option>
                                            @foreach(Auth::user()->userFamily as $item)
                                            <option value="{{ $item->id }}" data-nama="{{ $item->nama }}">{{ $item->hubungan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" readonly="true" class="form-control nama_hubungan input" /></td>
                                    <td>
                                        <select name="medical_type_id[]" class="form-control input" required>
                                            <option value=""> - choose Medical Type - </option>
                                        @foreach($type as $item)
                                        <option value="{{ $item->id }}" {{ $item->id== request()->medical_type_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="no_kwitansi[]" required /></td> 
                                    <td><input type="number" class="form-control input" name="jumlah[]" required /></td>
                                    <td><input type="file" class="form-control input" name="file_bukti_transaksi[]" required /></td>
                                    <td></td>
                                </tr>
                                -->
                              </tbody>
                              <tfoot>
                                  <tr>
                                      <th colspan="6" style="text-align: right;">TOTAL : </th>
                                      <th class="th-total"></th>
                                  </tr>
                              </tfoot>
                          </table>
                          <span class="btn btn-info btn-xs pull-right" id="add">Add</span>

                        </div>

                     
                        <div class="clearfix"></div>
                        <br />
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('karyawan.medical-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
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

    validate_form = true;

    show_hide_add();
    cek_button_add();

    jQuery('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    var data_dependent = [];

    $("#btn_submit").click(function(){
        var jumlah = $('.table-claim tr').length;
        var validate = true;

        if(jumlah <= 0)
        {
            bootbox.alert('Form not completed. Please check and resubmit.');
            validate = false;
        }
        if(!validate_form){
            bootbox.alert('Form not completed. Please check and resubmit.');
            return false;
        }
        if(validate){
            bootbox.confirm('Process Form Medical Reimbursement ?', function(result){
            if(result)
            {
                $("#form-medical").submit();
            }
            });
        }
        
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
                                '<option value="">Pilih Hubungan</option><option value="{{ \Auth::user()->id }}" data-nama="{{ \Auth::user()->name }}">My Self</option>@foreach(Auth::user()->userFamily as $item)<option value="{{ $item->id }}" data-nama="{{ $item->nama }}">{{ $item->hubungan }}</option>@endforeach'+
                            '</select>'+
                        '</td>'+
                        '<td><input type="text" readonly="true" class="form-control nama_hubungan" /></td>'+
                        '<td>'+
                            '<select name="medical_type_id[]" class="form-control input" required>'+
                                            '<option value=""> - choose Medical Type - </option>'+
                                        '@foreach($type as $item)'+
                                        '<option value="{{ $item->id }}" {{ $item->id== request()->medical_type_id ? 'selected' : '' }}>{{ $item->name }}</option> @endforeach'+
                                        '</select>'+
                        '</td> '+
                        '<td><input type="text" class="form-control" name="no_kwitansi[]" required /></td>'+
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
    if(confirm("Delete this item ?"))
    {
        $(el).parent().parent().remove();
        cek_button_add();
        show_hide_add();
    }
}

</script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
