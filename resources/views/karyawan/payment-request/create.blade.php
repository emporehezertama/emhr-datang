@extends('layouts.administrator')

@section('title', 'Payment Request')

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
                <h4 class="page-title">Form Payment Request</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Payment Request</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" autocomplete="off" id="form_payment" enctype="multipart/form-data" action="{{ route('karyawan.payment-request.store') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Data Payment Request</h3>
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
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label class="col-md-12">From</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ Auth::user()->nik .' / '. Auth::user()->name  }}" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">To : Accounting Department</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Tujuan / Purpose</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="tujuan"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Trancation Type</label>
                                <div class="col-md-12">
                                    <label style="font-weight: normal;"><input type="radio" name="transaction_type" value="Advance" /> Advance</label> &nbsp;&nbsp;
                                    <label style="font-weight: normal;"><input type="radio" name="transaction_type" value="Payment" /> Payment</label>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-12">Payment Method</label>
                                <div class="col-md-12">
                                    <label style="font-weight: normal;"><input type="radio" name="payment_method" value="Cash" /> Cash</label> &nbsp;&nbsp;
                                    <label style="font-weight: normal;"><input type="radio" name="payment_method" value="Bank Transfer" /> Bank Transfer</label>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-12">Name of Account</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly="true" value="{{ Auth::user()->nama_rekening }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Account Number</label>
                                <div class="col-md-12">
                                    <input type="number" class="form-control" readonly="true" value="{{ Auth::user()->nomor_rekening }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Name Of Bank</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly="true" value="{{ isset(Auth::user()->bank) ? Auth::user()->bank->name : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="col-md-6" style="padding-left: 0;">
                            <h4><b>Approval</b></h4>
                            <div class="col-md-12" style="border: 1px solid #eee; padding: 15px">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control autcomplete-atasan" placeholder="Select Superior  / Supervisor">
                                        <input type="hidden" name="approved_atasan_id" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12">Position</label>
                                    <div class="col-md-6">
                                        <input type="text" readonly="true" class="form-control jabatan_atasan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6">Phone Number</label>
                                    <label class="col-md-6">Email</label>
                                    <div class="col-md-6">
                                        <input type="text" readonly="true" class="form-control no_handphone_atasan">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" readonly="true" class="form-control email_atasan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="table-responsive">
                            <table class="table table-hover manage-u-table">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>TYPE</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>ESTIMATION COST</th>
                                        <th>AMOUNT</th>
                                        <th>AMOUNT APPROVED</th>
                                        <th>RECEIPT TRANSACTION</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-lembur">
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <div class="col-md-10" style="padding-left:0;">
                                                <select name="type[]" class="form-control input" onchange="select_type_(this)">
                                                    <option value=""> - none - </option>
                                                    <option>Parkir</option>
                                                    <option>Bensin</option>
                                                    <option>Tol</option>
                                                    <option>Overtime Transport</option>
                                                    <option>Others</option>
                                                </select>
                                            </div>
                                            <div class="content_bensin"></div>
                                            <div class="content_overtime"></div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control input" name="description[]">
                                        </td>
                                        <td>
                                            <input type="number" name="quantity[]" value="1" class="form-control input">
                                        </td>
                                        <td>
                                            <input type="number" name="estimation_cost[]" class="form-control estimation ">
                                        </td>
                                        <td>
                                            <input type="number" name="amount[]" class="form-control amount">
                                        </td>
                                        <td>
                                            <input type="number" name="amount_approved[]" class="form-control" readonly="true">
                                        </td>
                                        <td>
                                            <input type="file" name="file_struk[]" class="form-control input">
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background: #eee;">
                                        <th colspan="4" class="text-right" style="font-size: 14px;">Total Claim : </th>
                                        <th class="total_estimation" style="font-size: 14px;">0</th>
                                        <th class="total_amount" style="font-size: 14px;" colspan="3">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <a class="btn btn-info btn-xs pull-right" id="add"><i class="fa fa-plus"></i> Add</a>
                        </div>
                        <div class="clearfix"></div>
                        <br />

                        <a href="{{ route('karyawan.payment-request.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="submit_payment"><i class="fa fa-save"></i> Submit Payment Request</a>
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
    @include('layouts.footer')
</div>

<!-- sample modal content -->
<div id="modal_overtime" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Data Overtime</h4> </div>
                <div class="modal-body">
                   <div class="form-horizontal modal-form-overtime">
                    @if(!data_overtime_user(Auth::user()->id))
                        <p><i>No Data Overtime</i></p>
                    @endif

                    @if(data_overtime_user(Auth::user()->id))
                    <table class="table tabl-hover">
                       <thead>
                           <tr>
                               <th width="50">NO</th>
                               <th>DATE</th>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach(data_overtime_user(Auth::user()->id) as $item)
                        <?php if($item->is_payment_request != ""){ continue; } ?>
                        <tr>
                           <td><input type="checkbox" name="overtime_item" value="{{ $item->id }}"></td>
                           <td>{{ $item->created_at }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                       </table>
                    @endif
                   </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" id="btn_cancel_overtime" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info btn-sm" id="add_overtime">Tambah</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- sample modal content -->
<div id="modal_bensin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Data Gasoline</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal" id="form_modal_bensin">
                        <div class="form-group">
                            <label class="col-md-12">Date of purchase of gasoline</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control datepicker modal_tanggal_struk_bensin" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Odometer (KM)</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control modal_odo_from" placeholder="From Odo Meter" />
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control modal_odo_to" placeholder="To Odo Meter" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Liter</label>
                            <div class="col-md-12">
                                <input type="number" class="form-control modal_liter" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Cost</label>
                            <div class="col-md-12">
                                <input type="number" class="form-control modal_cost" />
                            </div>
                        </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" id="btn_cancel_bensin" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_bensin">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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

    jQuery('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });

    $(".autcomplete-atasan" ).autocomplete({
        source: list_atasan,
        minLength:0,
        select: function( event, ui ) {
            $( "input[name='approved_atasan_id']" ).val(ui.item.id);

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


</script>
<script src="{{ asset('js/payment-request/karyawan.js') }}?v={{ date('ymdhis') }}"></script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
