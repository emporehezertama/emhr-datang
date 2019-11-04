@extends('layouts.administrator')

@section('title', 'Leave / Permit Employee')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Dashboard</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Leave / Permit Employee</li>
                </ol>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Leave / Permit Employee</h3>
                    <hr />
                    <form method="POST" action="{{ route('administrator.cuti.index') }}" id="filter-form">
                        <p>Filter Form</p>
                        {{ csrf_field() }}
                        <div class="col-md-1" style="padding-left:0;">
                            <div class="form-group">
                                <select class="form-control" name="jabatan">
                                    <option value="">- Position - </option>
                                    <option {{ (request() and request()->jabatan == 'Staff') ? 'selected' : '' }}>Staff</option>
                                    <option {{ (request() and request()->jabatan == 'Manager') ? 'selected' : '' }}>Manager</option>
                                    <option {{ (request() and request()->jabatan == 'Direktur') ? 'selected' : '' }}>Director</option>
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
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>DATE OF LEAVE / PERMIT</th>
                                    <th>LEAVE / PERMIT TYPE</th>
                                    <th>LEAVE / PERMIT DURATION</th>
                                    <th>PURPOSE</th>
                                    <th>STATUS</th>
                                    <th>CREATED</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php ($i = 1)
                                @foreach($data as $no => $item)
                                    @if(isset($item->user))
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>    
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ date('d F Y', strtotime($item->tanggal_cuti_start)) }} - {{ date('d F Y', strtotime($item->tanggal_cuti_end)) }}</td>
                                        <td>{{ isset($item->cuti) ? $item->cuti->jenis_cuti : '' }}</td>
                                        <td>{{ $item->total_cuti }}</td>
                                        <td>{{ $item->keperluan }}</td>
                                        <td>
                                            <a onclick="detail_approval_cuti('cuti', {{ $item->id }})">
                                            {!! status_cuti($item->status) !!}
                                            <!--
                                            @if($item->status == 3)
                                                <label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Rejected</label>
                                            @elseif($item->status == 4)
                                                <label class="btn btn-danger btn-xs" onclick="bootbox.alert('<h4>Reason</h4><hr /><p>{{ $item->note_pembatalan }}</p>')"><i class="fa fa-close"></i>Cancelled</label>
                                            @elseif($item->status == 1)
                                                <label class="btn btn-warning btn-xs">Waiting Approval</label>
                                            @elseif($item->status == 2)
                                                <label class="btn btn-success btn-xs">Approved</label>
                                            @endif
                                            -->
                                        </a>
                                            <!--
                                                <a onclick="detail_approval_cuti('cuti', {{ $item->id }})"> 
                                                @if($item->is_approved_atasan == "")
                                                    <label class="btn btn-warning btn-xs">Waiting Approval Atasan</label>

                                                @else
                                                    @if($item->approve_direktur == "" and $item->is_approved_atasan == 1 and $item->status != 4)
                                                        <label class="btn btn-warning btn-xs">Waiting Approval</label>
                                                    @endif

                                                    @if($item->approve_direktur == 1)
                                                        <label class="btn btn-success btn-xs">Approved</label>
                                                    @endif
                                                @endif
                                                @if($item->status == 4)
                                                <label class="btn btn-danger btn-xs" onclick="bootbox.alert('<h4>Reason for Cancellation</h4><hr /><p>{{ $item->note_pembatalan }}</p>')"><i class="fa fa-close"></i>Canceled</label>
                                                @endif
                                            </a>
                                            -->
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <!--
                                            @if($item->status == 1)
                                            <a onclick="batalkan_pengajuan('{{ $item->id }}')" class="btn btn-danger btn-xs"><i class="fa fa-close"></i> Cancel Leave/Permit</a>
                                            @endif
                                            -->
                                            <a href="{{ route('administrator.cuti.proses', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-arrow-right"></i> Detail</a>
                                            <!--
                                            <a href="{{ route('administrator.cuti.delete', $item->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>
                                            -->
                                        </td>
                                    </tr>
                                    @php ($i++)
                                    @endif
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
<div id="modal_pembatalan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <form class="form-horizontal" id="form-pembatalan" enctype="multipart/form-data" action="{{ route('administrator.cuti.batal') }}" method="POST">
                    {{ csrf_field() }}
                    <h4 class="modal-title" id="myModalLabel">Cancellation Form</h4> </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">Reason for Cancellation</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="note"></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" class="id-pembatalan" name="id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                        <button type="button" class="btn btn-info btn-sm" id="btn_pembatalan">Proces Cancellation <i class="fa fa-arrow-right"></i> </button>
                    </div>
                </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                bootbox.alert('Reason for Cancellation must filled ');
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
