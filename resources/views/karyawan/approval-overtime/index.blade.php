@extends('layouts.karyawan')

@section('title', 'Overtime Sheet')

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
                <h4 class="page-title">Approval Overtime</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Overtime Sheet</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Overtime</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>OVERTIME DATE</th>
                                    <th>STATUS</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td> 
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</td>   
                                        <td>{{ date('d F Y', strtotime($item->created_at))}}</td>                                     
                                        <td>
                                            <a onclick="status_approval_overtime({{ $item->id }})"> 
                                                @if($item->is_approved_atasan  == 1)
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
                                                @if($item->status == 3)
                                                    <label class="btn btn-danger btn-xs"><i class="fa fa-close"></i> Reject</label>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('karyawan.approval.overtime.detail', ['id' => $item->id]) }}">
                                            @if($item->is_approved_atasan == 1)
                                                @if($item->approve_direktur === NULL)
                                                    <label class="btn btn-info btn-xs">proses <i class="fa fa-arrow-right"></i> </label>
                                                @else
                                                    <label class="btn btn-info btn-xs">detail <i class="fa fa-search-plus"></i> </label>
                                                @endif
                                            @else
                                                <label class="btn btn-success btn-xs"><i class="fa fa-search-plus"></i> detail</label>
                                            @endif  
                                            </a>
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
