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
                <h4 class="page-title">Manage Payment Request</h4> 
            </div>
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
            <div class="col-md-12">
                <div class="white-box">
                    <form method="POST" action="{{ route('administrator.paymentRequestCustom.index') }}" id="filter-form">
                        <p>Filter Form</p>
                        {{ csrf_field() }}
                        <div class="col-md-1" style="padding-left:0;">
                            <div class="form-group">
                                <select class="form-control" name="division_id">
                                        <option value=""> - choose Division - </option>
                                        @foreach($division as $item)
                                        <option value="{{ $item->id }}" {{ $item->id== request()->division_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1" style="padding-left:0;">
                            <div class="form-group">
                                <select class="form-control" name="position_id">
                                        <option value=""> - choose Position - </option>
                                        @foreach($position as $item)
                                        <option value="{{ $item->id }}" {{ $item->id== request()->position_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-left:0;">
                            <div class="form-group">
                                <select class="form-control" name="employee_status">
                                    <option value="">- Employee Status - </option>
                                    <option {{ (request() and request()->employee_status == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                    <option {{ (request() and request()->employee_status == 'Contract') ? 'selected' : '' }}>Contract</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="view">
                        <div class="col-md-3" style="padding-left:0;">
                            <button type="button" id="filter_view" class="btn btn-default btn-sm">View in table <i class="fa fa-search-plus"></i></button>
                            <button type="button" onclick="submit_filter_download()" class="btn btn-info btn-sm">Download Excel <i class="fa fa-download"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>TO</th>
                                    <th>FROM</th>
                                    <th>PURPOSE</th>
                                    <!--<th>TRANSACTION TYPE</th>-->
                                    <th>PAYMENT METHOD</th>
                                    <th>TOTAL AMOUNT</th>
                                    <th>STATUS</th>
                                    <th>CREATED</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <?php if(!isset($item->user->name)) { continue; } ?>
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>    
                                        <td>Accounting Department</td>
                                        <td>{{ $item->user->nik }} / {{ $item->user->name }}</td>
                                        <td>{{ $item->tujuan }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>{{ number_format(sum_payment_request_price($item->id)) }}</td>
                                        <td>
                                            <a onclick="detail_approval_payment_custom({{ $item->id }})"> 
                                                {!! status_payment_request($item->status) !!}
                                            </a>
                                        </td>
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('administrator.paymentRequestCustom.proses', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>


@section('footer-script')
    <script type="text/javascript">
    
         $("#filter_view").click(function(){
            $("#filter-form input[name='action']").val('view');
            $("#filter-form").submit();

        });

        var submit_filter_download = function(){
            $("#filter-form input[name='action']").val('download');
            $("#filter-form").submit();
        }
        $("#btn_pembatalan").click(function(){

            if($("textarea[name='note']").val() == "")
            {
                bootbox.alert('Alasan pembatalan harus diisi ');
                return false;
            }

            $("#form-pembatalan").submit();
        });

        function batalkan_pengajuan(id)
        { 
            $('.id-pembatalan').val(id);

            $("#modal_pembatalan").modal('show');
        }

    </script>
@endsection

@endsection
