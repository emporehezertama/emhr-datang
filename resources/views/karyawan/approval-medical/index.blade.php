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
                <h4 class="page-title">Dashboard</h4> 
            </div>
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
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Medical Reimbursement</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>CLAIM DATE</th>
                                    <th>STATUS</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td> 
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ date('d F Y', strtotime($item->tanggal_pengajuan)) }}</td>
                                        <td>
                                            <a onclick="status_approval_medical({{ $item->id }})"> 
                                            @if($item->status == 1)
                                                @if($item->is_approved_atasan == 1)
                                                    @if($item->approve_direktur === NULL)
                                                        <label class="btn btn-warning btn-xs">Waiting Approval</label>
                                                    @endif    
                                                    @if($item->approve_direktur === 1)
                                                        <label class="btn btn-success btn-xs">Approved</label>
                                                    @endif    
                                                    @if($item->approve_direktur === 0)
                                                        <label class="btn btn-danger btn-xs">Reject</label>
                                                    @endif  
                                                @endif   
                                            @elseif($item->status == 2)
                                                <label class="btn btn-success btn-xs">Approved</label>
                                            @elseif($item->status == 3)
                                                <label class="btn btn-danger btn-xs">Reject</label>
                                            @endif
                                            </a>
                                        </td>
                                        <td>
                                            @if($item->is_approved_atasan == 1 and $item->approve_direktur === NULL and $item->status < 3)
                                                <a href="{{ route('karyawan.approval.medical.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5">proses <i class="fa fa-arrow-right"></i></button></a>
                                            @else
                                                    <a href="{{ route('karyawan.approval.medical.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5">detail <i class="fa fa-arrow-right"></i></button></a>
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
