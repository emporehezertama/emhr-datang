@extends('layouts.karyawan')

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
                <h4 class="page-title hidden-xs hidden-sm">Manage Payment Request</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('karyawan.payment-request-custom.create') }}" class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light"> <i class="fa fa-plus"></i> ADD PAYMENT REQUEST</a>

                <ol class="breadcrumb hidden-xs hidden-sm">
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
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>TO</th>
                                    <th>PURPOSE</th>
                                    <!--<th>TRANSACTION TYPE</th>-->
                                    <th>PAYMENT METHOD</th>
                                    <th>STATUS</th>
                                    <th>CREATED</th>
                                    <th width="100">MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>    
                                        <td>Accounting Department</td>
                                        <td>{{ $item->tujuan }}</td>
                                       <!-- <td>{{ $item->transaction_type }}</td>-->
                                        <td>{{ $item->payment_method }}</td>
                                        <td>
                                            <a onclick="detail_approval_paymentRequestCustom({{ $item->id }})">
                                                {!! status_payment_request($item->status) !!}
                                            </a>
                                           
                                        </td>
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('karyawan.payment-request-custom.edit', $item->id) }}" class="btn btn-info btn-xs"><<i class="fa fa-search-plus"></i> detail</a>
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
@endsection
