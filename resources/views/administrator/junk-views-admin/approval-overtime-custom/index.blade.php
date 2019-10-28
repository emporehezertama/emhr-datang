@extends('layouts.administrator')

@section('title', 'Approval Overtime Sheet')

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
                <h4 class="page-title">Manage Approval Overtime</h4> 
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
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>OVERTIME SUBMISSION</th>
                                    <th>SUBMISSION STATUS</th>
                                    <th>CLAIM STATUS</th>
                                    <th>#</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    @if($item->is_approved == NULL)
                                        @if($item->overtimeSheet->status == 3 || $item->overtimeSheet->status_claim == 3)
                                            <?php continue;?>
                                        @endif
                                        @if(!cek_level_overtime_up($item->overtimeSheet->id))
                                            <?php continue;?>
                                        @endif

                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td> 
                                        <td>{{ $item->overtimeSheet->user->nik }}</td>
                                        <td>{{ $item->overtimeSheet->user->name }}</td>   
                                        <td>{{ date('d F Y', strtotime($item->created_at))}}</td>                                     
                                        <td><a href="javascript:;" onclick="detail_approval_overtime_custom({{ $item->id }})"> 
                                                {!! status_overtime($item->status) !!}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" onclick="detail_approval_overtimeClaim_custom({{ $item->id }})"> 
                                                {!! status_overtime($item->status_claim) !!}
                                            </a>
                                        </td>
                                        <td>
                                            @if($item->is_approved === NULL and $item->status < 2)
                                                <a href="{{ route('administrator.approval.overtime-custom.detail', ['id' => $item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-arrow-right"></i> process</a>
                                            @else
                                                <a href="{{ route('administrator.approval.overtime-custom.detail', ['id' => $item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-search-plus"></i> detail</a>
                                            @endif
                                            
                                        </td>
                                        <td>
                                            @if($item->status == 2)
                                                @if($item->is_approved_claim === NULL and $item->status_claim == 1)
                                                @if(cek_level_overtime_up($item->overtimeSheet->id))

                                                    <a href="{{ route('administrator.approval.overtime-custom.claim', ['id' => $item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-arrow-right"></i> process claim</a>
                                                @endif
                                                @elseif($item->is_approved_claim != NULL and $item->status_claim >= 1)
                                                    <a href="{{ route('administrator.approval.overtime-custom.claim', ['id' => $item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-search-plus"></i> claimed detail</a>
                                                @endif
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
