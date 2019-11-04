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
                <h4 class="page-title">Data Payment Request</h4> </div>
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
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.payment-request.update', $data->id) }}" method="POST">
                <form class="form-horizontal" id="form_payment" enctype="multipart/form-data" action="{{ route('karyawan.payment-request.store') }}" method="POST">
                <div class="col-md-12">
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
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label class="col-md-12">From</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ $data->user->nik }} / {{ $data->user->name }}" readonly="true">
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
                                    <label style="font-weight: normal;"><input type="radio" name="payment_method" {{ $data->payment_method == 'Cash' ? 'checked="true"' : '' }} value="Cash" /> Cash</label> &nbsp;&nbsp;
                                    <label style="font-weight: normal;"><input type="radio" name="payment_method" {{ $data->payment_method == 'Bank Transfer' ? 'checked="true"' : '' }} value="Bank Transfer" /> Bank Transfer</label>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-12">Name of Account</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly="true" value="{{  isset($data->user->nama_rekening) ? $data->user->nama_rekening : ''}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Account Number</label>
                                <div class="col-md-12">
                                    <input type="number" class="form-control" readonly="true" value="{{ isset($data->user->nomor_rekening) ? $data->user->nomor_rekening : '' }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Name Of Bank</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" readonly="true" value="{{ isset($data->user->bank->name) ? $data->user->bank->name : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
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
                                        <th>AMOUNT</th>
                                        <th>AMOUNT APPROVED</th>
                                        <th>TRANSACTION RECEIPT</th>
                                        <th>NOTE</th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-lembur">
                                    @php($total_amount=0)
                                    @php($total_amount_approved=0)
                                    @foreach($form as $key => $item)
                                    @php($total_amount +=$item->amount)
                                    @php($total_amount_approved +=$item->nominal_approved)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>
                                        <td>{{ $item->type_form }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->amount) }}</td>
                                        <td>{{ number_format($item->nominal_approved) }}</td>
                                        <td>
                                            @if(!empty($item->file_struk)) 
                                                <a onclick="show_image('{{ $item->file_struk }}')" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i>View </a>
                                                
                                            @endif
                                        </td>
                                        <td>{{ $item->note }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background: #eee;">
                                        <th colspan="4" style="text-align: right;">Total</th>
                                        <th>{{ number_format($total_amount) }}</th>
                                        <th colspan="3">{{ number_format($total_amount_approved) }}</th>
                                    </tr>
                                </tfoot>
                                
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        @foreach($data->historyApproval as $key => $item)
                            <div class="form-group">
                                <label class="col-md-12">Note Approval {{$item->setting_approval_level_id}}</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control note" value="{{ $item->note }}">
                                </div>
                            </div>
                            @endforeach
                        <div class="clearfix"></div>
                        <br />
                        <a href="{{ route('administrator.paymentRequestCustom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
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
@section('footer-script')
<script type="text/javascript">
    
    $("#add").click(function(){

        var no = $('.table-content-lembur tr').length;

        var html = '<tr>';
            html += '<td>'+ (no+1) +'</td>';
            html += '<td><textarea name="description[]" class="form-control"></textarea></td>';
            html += '<td><input type="number" name="quantity[]" class="form-control" /></td>';
            html += '<td><input type="number" name="estimation_cost[]" class="form-control" /></td>';
            html += '<td><input type="number" name="amount[]" class="form-control"  /></td>';
            html += '</tr>';

        $('.table-content-lembur').append(html);

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
