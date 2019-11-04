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
                <h4 class="page-title">Process Payment Request</h4> </div>
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
            <form class="form-horizontal" id="form-payment-request" enctype="multipart/form-data" action="{{ route('administrator.approval.payment-request-custom.proses') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        {{ csrf_field() }}
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label class="col-md-12">From</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" readonly="true" value="{{ $data->user->nik }} / {{ $data->user->name }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">To : Accounting Department</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Purpose</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="tujuan" readonly="true">{{ $data->tujuan }}</textarea>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-12">Payment Method</label>
                                <div class="col-md-12">
                                    <label style="font-weight: normal;"><input type="radio" name="payment_method" value="Cash" {{ $data->payment_method == 'Cash' ? 'checked' : '' }} /> Cash</label> &nbsp;&nbsp;
                                    <label style="font-weight: normal;"><input type="radio" name="payment_method" value="Bank Transfer" {{ $data->payment_method == 'Bank Transfer' ? 'checked' : '' }}  /> Bank Transfer</label>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-12">Name of Account</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly="true" value="{{ $data->user->nama_rekening }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Account Number</label>
                                <div class="col-md-12">
                                    <input type="number" class="form-control" readonly="true" value="{{ $data->user->nomor_rekening }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Name Of Bank</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly="true" value="{{isset($data->user->bank->name)}}" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-hover manage-u-table">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>TYPE</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>AMOUNT</th>
                                        <th>AMOUNT APPROVED</th>
                                        <th>RECEIPT TRANSACTION</th>
                                        <th>NOTE</th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-lembur">
                                    @php($total_cost=0)
                                    @php($total_amount=0)
                                    @php($total_amount_approved=0)
                                    @foreach($data->payment_request_form as $key => $item)
                                    @php($total_amount_approved +=$item->nominal_approved)
                                    @php($total_amount +=$item->amount)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>
                                        <td>{{ $item->type_form }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->amount) }}</td>
                                        <td>
                                            @if($item->nominal_approved != NULL)
                                                <input type="text" name="nominal_approve[{{ $item->id }}]" {{$history->is_approved ? 'readonly="true"' : '' }} class="form-control nominal_approve" value="{{ $item->nominal_approved }}" placeholder="Nominal Approve"/>
                                            @endif
                                            @if($item->nominal_approved == NULL)
                                                <input type="text" name="nominal_approve[{{ $item->id }}]" {{$history->is_approved ? 'readonly="true"' : '' }} class="form-control nominal_approve" value="{{ $item->amount }}" placeholder="Nominal Approve"/>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($item->file_struk)) 
                                                <a onclick="show_image('{{ $item->file_struk }}')" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i>View </a>
                                            @endif
                                        </td>
                                        <td>
                                            <textarea name="note[{{ $item->id }}]" {{$history->is_approved ? 'readonly="true"' : '' }} placeholder="Note" class="form-control">{{ $item->note }}</textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background: #eee;">
                                        <th colspan="4" style="text-align: right;">Total</th>
                                        <th>{{ number_format($total_amount) }}</th>
                                        <th class="total_amountapprove" colspan="3">{{ number_format($total_amount_approved) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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

                        <a href="{{ route('administrator.approval.payment-request-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
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

<div id="modal_other" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Approve by Condition</h4> </div>
                <div class="modal-body form-horizontal">
                    <div class="form-group">
                        <label class="col-md-12">Amount Approved</label>
                        <div class="col-md-12">
                            <input type="number" class="form-control modal_nominal" />
                        </div>
                    </div> 
                    <br />
                    <div class="form-group">
                        <label class="col-md-12">Note</label>
                        <div class="col-md-12">
                            <textarea class="form-control modal_catatan"></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info waves-effect btn-sm" id="btn_modal_oke">Oke</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')
<script type="text/javascript">
    $(document).ready(function () {
        calculate_amountApprove();
    });
        
    var global_el;
    $(".nominal_approve").on('input', function(){
      calculate_amountApprove();
    });

    var calculate_amountApprove  = function(){
    var total = 0;
    $('.nominal_approve').each(function(){
        if($(this).val() != ""){
            total += parseInt($(this).val());
        }
    });

    $('.total_amountapprove').html(numberWithComma(total));
    }


    $("#btn_approve_all").click(function(){

        $('.item_payment').each(function(){
           var nominal_old = $(this).find('.nominal_old').val();

           $(this).html('<p>Nominal disetujui : '+ numberWithComma(nominal_old) +'</p>');
           $(this).parent().find('.nominal_approve').val(nominal_old);
        });

        $("input[name='approve_all']").val(1);

        $(this).remove();
    });

    $("#btn_modal_oke").click(function(){

        var nominal = $('.modal_nominal').val();
        var catatan = $('.modal_catatan').val();

        if(nominal == "") { bootbox.alert('Nominal harus diisi !'); return false;}
        if(catatan == "") { bootbox.alert('Catatan harus diisi !'); return false;}

        var html = '<p>Nominal : '+ numberWithComman(nominal) +'</p>';
            html += '<p>Catatan : '+ catatan +'</p>';

        $(global_el).parent().html(html);
        $(global_el).parent().parent().find('.nominal_approve').val(nominal);
        $(global_el).parent().parent().find('.note').val(catatan);
    });

    function other_(el)
    {
        global_el = el;
        $("#modal_other").modal('show');
    }
    
    function oke_()
    {

    }

    $("#btn_approved").click(function(){
        bootbox.confirm('Approve Employee Payment Request ?', function(result){

            $("input[name='status']").val(1);
            if(result)
            {
                $('#form-payment-request').submit();
            }

        });
    });

    $("#btn_tolak").click(function(){
        bootbox.confirm('Reject Employee Payment Request ?', function(result){

            if(result)
            {
                $('#form-payment-request').submit();
            }

        });
    });
</script>
<script type="text/javascript">
    function show_image(img)
    {
        bootbox.alert('<img src="{{ asset('storage/file-struk/')}}/'+ img +'" style = \'width: 100%;\' />');      
    }
</script>

@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
