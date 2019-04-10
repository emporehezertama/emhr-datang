@extends('layouts.administrator')

@section('title', 'Overtime Sheet')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title" style="overflow: inherit;">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Overtime Sheet</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <form method="POST" action="{{ route('administrator.overtimeCustom.index') }}" id="filter-form">
                        {{ csrf_field() }}
                        <div style="padding-left:0; float: right;">
                            <div class="btn-group m-l-10 m-r-10 pull-right">
                                <a href="javascript:void(0)" aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">Action 
                                    <i class="fa fa-gear"></i>
                                </a>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="submit_filter_download()">Download Excel <i class="fa fa-download"></i></a></li>
                                </ul>
                            </div>
                            <button type="button" id="filter_view" class="btn btn-default btn-sm pull-right btn-outline"><i class="fa fa-search-plus"></i></button>
                        </div>
                        <div class="col-md-2 pull-right">
                            <div class="form-group  m-b-0">
                                <select class="form-control form-control-line" name="division_id">
                                        <option value=""> - Choose Division - </option>
                                        @foreach($division as $item)
                                        <option value="{{ $item->id }}" {{ $item->id== request()->division_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 pull-right">
                            <div class="form-group  m-b-0">
                                <select class="form-control form-control-line" name="position_id">
                                        <option value=""> - Choose Position - </option>
                                        @foreach($position as $item)
                                        <option value="{{ $item->id }}" {{ $item->id== request()->position_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2  pull-right">
                            <div class="form-group  m-b-0">
                                <select class="form-control form-control-line" name="employee_status">
                                    <option value="">- Employee Status - </option>
                                    <option {{ (request() and request()->employee_status == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                    <option {{ (request() and request()->employee_status == 'Contract') ? 'selected' : '' }}>Contract</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="view">
                        <div class="clearfix"></div>
                    </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    
                    <div class="table-responsive">
                        <table id="data_table_no_pagging" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th> 
                                    <th>NAME</th> 
                                    <th>POSITION</th>
                                    <th>OVERTIME SUBMISSION</th>
                                    <th>SUBMISSION STATUS</th>
                                    <th>CLAIM STATUS</th>
                                    <th>#</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <?php if(!isset($item->user->name)) { continue; } ?>
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ isset($item->user->structure->position) ? $item->user->structure->position->name:''}}{{ isset($item->user->structure->division) ? '-'. $item->user->structure->division->name:''}}</td>
                                        <td>{{ date('d F Y', strtotime($item->created_at))}}</td>
                                        <td> 
                                            <a onclick="detail_approval_overtime_custom({{ $item->id }})">
                                            {!! status_overtime($item->status) !!}</a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" onclick="detail_approval_overtimeClaim_custom({{ $item->id }})"> 
                                                {!! status_overtime($item->status_claim) !!}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('administrator.overtimeCustom.proses', $item->id) }}" class="btn btn-info btn-xs">Detail <i class="fa fa-search-plus"></i></a>
                                        </td>
                                        <td>
                                            @if($item->status == 2 and $item->status_claim >= 1) 
                                                <a href="{{ route('administrator.overtimeCustom.claim', $item->id) }}" class="btn btn-info btn-xs">Detail Claim<i class="fa fa-search-plus"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-m-6 pull-left text-left">Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries</div>
                        <div class="col-md-6 pull-right text-right">{{ $data->appends($_GET)->render() }}</div><div class="clearfix"></div>
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
</script>
@endsection
@endsection
