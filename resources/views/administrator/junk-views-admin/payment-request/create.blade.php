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
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.payment-request.store') }}" method="POST">
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
                                    <select name="from_user_id" class="form-control">
                                        <option value="">Choose from</option>
                                        @foreach($karyawan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nik }} / {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">To : Accounting Department</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Purpose</label>
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
                                    <input type="text" name="nama_pemilik_rekening" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Account Number</label>
                                <div class="col-md-12">
                                    <input type="number" name="no_rekening" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Name Of Bank</label>
                                <div class="col-md-12">
                                    <input type="text" name="nama_bank" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Payment Amount</label>
                                <div class="col-md-12">
                                    <input type="number" name="nominal_pembayaran" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-hover manage-u-table">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>ESTIMATION COST</th>
                                        <th>AMOUNT</th>
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
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save Data</button>
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


@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
