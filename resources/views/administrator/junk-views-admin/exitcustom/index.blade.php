@extends('layouts.administrator')

@section('title', 'Exit Interview')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title" style="overflow: inherit;">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Exit Interview & Exit Clearance</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
               <form method="POST" action="{{ route('administrator.exitCustom.index') }}" id="filter-form">
                    {{ csrf_field() }}
                    <div style="padding-left:0; float: right;">
                        <div class="btn-group m-l-10 m-r-10 pull-right">
                            <a href="javascript:void(0)" aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">Action 
                                <i class="fa fa-gear"></i>
                            </a>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="javascript:void(0)" onclick="submit_filter_download()"><i class="fa fa-download"></i> Download Excel</a></li>
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
                    <div class="col-md-2" style="padding-left:0; float: right;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="employee_status">
                                <option value="">- Employee Status - </option>
                                <option {{ (request() and request()->employee_status == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                <option {{ (request() and request()->employee_status == 'Contract') ? 'selected' : '' }}>Contract</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="view">
                </form>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table_no_pagging" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAMA</th>
                                    <th>RESIGN DATE</th>
                                    <th>REASON FOR LEAVING</th>
                                    <th>STATUS EXIT INTERVIEW</th>
                                    <th>STATUS EXIT CLEARANCE</th>
                                    <th width="100">MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                  @if(isset($item->user->name))
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>    
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->resign_date }}</td>
                                        <td>
                                            @if($item->exit_interview_reason == "")
                                                {{ $item->other_reason }}
                                            @else
                                                {!! $item->exitInterviewReason->label !!}
                                            @endif
                                        </td>
                                        <td>
                                            <a onclick="detail_approval_exit_custom({{ $item->id }})">  {!! status_exit_interview($item->status) !!}
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="detail_approval_clearance_custom({{ $item->id }})">
                                                @if(count($item->countAssets) >= 1)
                                                    <label class="btn btn-warning btn-xs">Waiting Approval</label>
                                                @else
                                                <label class="btn btn-success btn-xs"><i class="fa fa-chceck"></i>Approved</label>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('administrator.exitCustom.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> detail</button></a>
                                            <a href="{{ route('administrator.exitCustom.clearance', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> exit clearance</button></a>
                                        </td>
                                    </tr>
                                  @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
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
