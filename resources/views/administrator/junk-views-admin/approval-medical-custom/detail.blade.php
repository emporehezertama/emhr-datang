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
            <form class="form-horizontal" id="form-medical" enctype="multipart/form-data" action="{{ route('administrator.approval.medical-custom.proses') }}" method="POST">

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
                                    <input type="text" class="form-control" readonly="true" value="{{ $data->user->nik .' - '. $data->user->name }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control department" value="{{ isset($data->user->structure->position) ? $data->user->structure->position->name:''}}{{ isset($data->user->structure->division) ? '-'. $data->user->structure->division->name:'' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Claim Date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" readonly name="tanggal_pengajuan" required value="{{ $data->tanggal_pengajuan }}" />
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
                        <hr />
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
                                      <th>AMOUNT</th>
                                      <th>FILE</th>
                                      <th>AMOUNT APPROVED</th>

                                  </tr>
                              </thead>
                              <tbody class="table-claim">
                                @php ($total = 0)
                                @php ($total_disetujui = 0)
                                @foreach($data->form as $key => $f)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><input type="text" class="form-control datepicker"  readonly="true" name="tanggal_kwitansi[]" value="{{ $f->tanggal_kwitansi }}"  /></td>
                                     <td>
                                        @if($data->user->id == $f->user_family_id)
                                            <input type="text" readonly="true" class="form-control" value="Saya Sendiri">
                                        @else
                                            <input type="text" readonly="true" class="form-control" value="{{ isset($f->UserFamily->hubungan) ? $f->UserFamily->hubungan : ''  }}">
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
                                        <input type="text" readonly="true" class="form-control" value="{{ isset($f->medicalType)? $f->medicalType->name:'' }}">
                                    </td>
                                    <td><input type="text" readonly="true" class="form-control" required value="{{ $f->no_kwitansi }}" /></td>
                                    <td>
                                        <input type="text" class="form-control" required value="{{ number_format($f->jumlah) }}" readonly />
                                    </td>
                                    <td>
                                        <a onclick="show_image('{{ $f->file_bukti_transaksi }}')" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i>View</a>
                                    </td>
                                    <td>
                                        @if($f->nominal_approve != NULL)
                                            <input type="text" name="nominal_approve[{{ $f->id }}]" class="form-control input_nominal_approve price_format" value="{{ number_format($f->nominal_approve) }}" >

                                        @endif
                                        @if($f->nominal_approve == NULL)
                                            <input type="text" name="nominal_approve[{{ $f->id }}]" class="form-control input_nominal_approve price_format" value="{{ number_format($f->jumlah) }}">
                                        @endif
                                    </td>
                                </tr>
                                @php($total += $f->jumlah)
                                @php($total_disetujui += $f->nominal_approve)
                                @endforeach
                              </tbody>
                              <tfoot>
                                  <tr>
                                      <th colspan="6" style="text-align: right;">TOTAL</th>
                                      <th colspan="2">IDR {{ number_format($total) }}</th>
                                      <th class="th-total-disetujui">IDR {{ number_format($total_disetujui) }}</th>
                                  </tr>
                              </tfoot>
                            </table>
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
                        </div>
                        <div class="clearfix"></div>
                        <br />

                            <input type="hidden" name="status" value="0" />
                            <input type="hidden" name="id" value="{{ $data->id }}">
                        </div>

                        <br />

                        <a href="{{ route('administrator.approval.medical-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        @if($history->is_approved === NULL and $data->status < 2)
                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-check"></i> Approve</a>
                        <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Reject</a>
                        @endif

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
<script type="text/javascript">

    $(document).ready(function () {
        calculate_amountApprove();
    });

    var calculate_amountApprove  = function(){
    var total_nominal = 0;
        $(".input_nominal_approve").each(function(){
            if($(this).val() != "")
            {
                var value = $(this).val();
                total_nominal += parseInt(value.split('.').join(''));            
            }
        });
       $('.th-total-disetujui').html('Rp '+numberWithComma(total_nominal));
    }


    function show_image(img)
    {
        bootbox.alert('<img src="{{ asset('storage/file-medical/') }}/'+ img +'" style = \'width: 100%;\' />');
    }


    $(".input_nominal_approve").on('input', function(){
        var total_nominal = 0;
        $(".input_nominal_approve").each(function(){
            if($(this).val() != "")
            {
                var value = $(this).val();
                total_nominal += parseInt(value.split('.').join(''));            
            }
        });
        $('.th-total-disetujui').html('Rp '+numberWithComma(total_nominal));
    });

    $("#btn_approved").click(function(){
        bootbox.confirm('Approve Employee Medical Reimbursement?', function(result){

            $("input[name='status']").val(1);
            if(result)
            {
                $('#form-medical').submit();
            }
        });
    });

    $("#btn_tolak").click(function(){
        bootbox.confirm('Reject Employee Medical Reimbursement?', function(result){

            if(result)
            {
                $('#form-medical').submit();
            }

        });
    });
</script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
