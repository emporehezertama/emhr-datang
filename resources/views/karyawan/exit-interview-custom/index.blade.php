@extends('layouts.karyawan')

@section('title', 'Exit Interview')

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
                <h4 class="page-title hidden-xs hidden-sm">Manage Exit Interview<</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                @if(cek_create_exit_interview(\Auth::user()->id))
                <a href="{{ route('karyawan.exit-custom.create') }}" class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light"> <i class="fa fa-plus"></i> ADD EXIT INTERVIEW</a>
                @endif
                <ol class="breadcrumb hidden-xs hidden-sm">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Exit Interview</li>
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
                                    <th>RESIGN DATE</th>
                                    <th>REASON FOR LEAVING</th>
                                    <th>STATUS EXIT INTERVIEW</th>
                                    <th>CREATED</th>
                                    <th>STATUS EXIT CLEARANCE</th>
                                    <th width="100">MANAGE</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>    
                                        <td>{{ $item->resign_date }}</td>
                                        <td>
                                            @if($item->exit_interview_reason == "")
                                                {{ $item->other_reason }}
                                            @else
                                                {!! $item->exitInterviewReason->label !!}
                                            @endif
                                        </td>
                                        <td>
                                            <a onclick="detail_approval_exitCustom({{ $item->id }})"> 
                                                {!! status_exit_interview($item->status) !!}
                                            </a>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a onclick="detail_approval_clearanceCustom({{ $item->id }})">
                                                @if(count($item->countAssets) >= 1)
                                                <label class="btn btn-warning btn-xs">Waiting Approval</label>
                                                @else
                                                <label class="btn btn-success btn-xs"><i class="fa fa-chceck"></i>Approved</label>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                           <a href="{{ route('karyawan.exit-custom.edit', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> Detail</a>
                                           @if($item->status < 3)
                                                <a href="{{ route('karyawan.exit-custom.clearance', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> Exit Clearance</a>
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
