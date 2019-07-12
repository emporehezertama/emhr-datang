@extends('layouts.administrator')

@section('title', 'Leave / Permit Employee')

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
                <h4 class="page-title hidden-xs hidden-sm">Manage Employee Leave</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                @if(cek_approval('cuti_karyawan'))
                    <a href="{{ route('administrator.leave.create') }}" class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light" onclick=""> <i class="fa fa-plus"></i> ADD LEAVE</a>
                @else
                    <a class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light" onclick="bootbox.alert('Sorry you can not apply this transaction before the previous transaction has been completely approved')"> <i class="fa fa-plus"></i> ADD LEAVE</a>
                @endif
                <ol class="breadcrumb hidden-xs hidden-sm">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Leave / Permit Employee</li>
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
                                    <th>DATE OF LEAVE / PERMIT</th>
                                    <th>LEAVE / PERMIT TYPE</th>
                                    <th>LEAVE / PERMIT DURATION</th>
                                    <th>PURPOSE</th>
                                    <th>STATUS</th>
                                    <th>CREATED</th>
                                    <th width="100">MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>   
                                        <td>{{ date('d F Y', strtotime($item->tanggal_cuti_start)) }} - {{ date('d F Y', strtotime($item->tanggal_cuti_end)) }}</td>
                                        <td>{{ isset($item->cuti) ? $item->cuti->description : '' }}</td>
                                        <td>{{ $item->total_cuti }} Day/s</td>
                                        <td>{{ $item->keperluan }}</td>
                                        <td>
                                            <a onclick="detail_approval_leaveCustom({{ $item->id }})">
                                            {!! status_cuti($item->status) !!}
                                            </a>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('administrator.leave.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> detail</button></a>
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

<!-- sample modal content -->
<div id="modal_history_approval" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">History Approval</h4> </div>
                <div class="modal-body" id="modal_content_history_approval"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection