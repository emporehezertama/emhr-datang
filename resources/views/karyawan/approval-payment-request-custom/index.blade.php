@extends('layouts.karyawan')

@section('title', 'Approval Payment Request')

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
                <h4 class="page-title">Manage Approval Payment Request</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Approval Payment Request</li>
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
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>TO</th>
                                    <th>PURPOSE</th>
                                    <th>METHOD PAYMENT</th>
                                    <th>STATUS</th>
                                    <th>CREATED</th>
                                    <th width="100">MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    @if($item->is_approved == NULL)
                                        @if($item->paymentRequest->status == 3)
                                            <?php continue;?>
                                        @endif

                                        @if(!cek_level_payment_request_up($item->paymentRequest->id))
                                            <?php continue;?>
                                        @endif
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>    
                                        <td>{{ $item->paymentRequest->user->nik }}</td>
                                        <td>{{ $item->paymentRequest->user->name }}</td>
                                        <td>Accounting Department</td>
                                        <td>{{ $item->tujuan }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td><a onclick="detail_approval_paymentRequestCustom({{ $item->id }})">
                                            {!! status_cuti($item->status) !!}
                                            </a>
                                        </td>
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('karyawan.approval.payment-request-custom.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> 
                                        
                                            @if($item->is_approved === NULL and $item->status < 2)
                                                Process
                                            @else
                                                Detail
                                            @endif

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
