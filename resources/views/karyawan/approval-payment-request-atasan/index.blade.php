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
                <h4 class="page-title">Dashboard</h4> 
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
                    <h3 class="box-title m-b-0">Manage Approval Payment Request</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>TO</th>
                                    <th>PURPOSE</th>
                                    <th>TRANSACTION TYPE</th>
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
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>Accounting Department</td>
                                        <td>{{ $item->tujuan }}</td>
                                        <td>{{ $item->transaction_type }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>
                                            <!--
                                            <a onclick="status_approval_payment_request({{ $item->id }})"> 
                                                @if($item->is_approved_atasan === NULL)
                                                    <label class="btn btn-warning btn-xs">Waiting Approval</label>
                                                @endif
                                                @if($item->is_approved_atasan ==1)
                                                    <label class="btn btn-success btn-xs">Approved</label>
                                                @endif
                                                @if($item->is_approved_atasan ===0)
                                                    <label class="btn btn-danger btn-xs">Reject</label>
                                                @endif
                                            </a>
-->
                                            @if($item->status == 1)
                                                @if($item->is_approved_atasan === NULL)
                                                    <label onclick="status_approval_payment_request({{ $item->id }})" class="btn btn-warning btn-xs">Waiting Approval</label>
                                                @endif
                                                
                                                @if($item->is_approved_atasan === 0) 
                                                    <label onclick="status_approval_payment_request({{ $item->id }})" class="btn btn-danger btn-xs">Rejected</label>
                                                @endif

                                                @if($item->is_approved_atasan == 1)
                                                    <label onclick="status_approval_payment_request({{ $item->id }})" class="btn btn-success btn-xs">Approved</label>
                                                @endif
                                            @elseif($item->status == 2)
                                                <label onclick="status_approval_payment_request({{ $item->id }})" class="btn btn-success btn-xs">Approved</label>
                                            @elseif($item->status ==3)
                                                <label onclick="status_approval_payment_request({{ $item->id }})" class="btn btn-danger btn-xs">Rejected</label>
                                            @elseif($item->status ==4)
                                                 <label class="btn btn-danger btn-xs" onclick="bootbox.alert('<h4>Reason</h4><hr /><p>{{ $item->note_pembatalan }}</p>')"><i class="fa fa-close"></i>Cancelled</label>
                                            @endif

                                        </td>
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @if(!cek_status_approval_user(Auth::user()->id, 'payment_request', $item->id)  and $item->status < 4)
                                                <a href="{{ route('karyawan.approval.payment-request-atasan.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5">proses <i class="fa fa-arrow-right"></i></button></a>
                                            @else
                                                <a href="{{ route('karyawan.approval.payment-request-atasan.detail', ['id' => $item->id]) }}"> <button class="btn btn-default btn-xs m-r-5">detail <i class="fa fa-search-plus"></i></button></a>
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
