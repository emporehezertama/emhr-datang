@extends('layouts.administrator')

@section('title', 'Employee Attendance')

@section('content')        
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Attendance</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Employee Attendance</li>
                </ol>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                     <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#device" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Device</span></a></li>

                        <li role="presentation" class=""><a href="#upload" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Import Attendance</span></a></li>
                    </ul>
    
                     <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="device">
                            <table class="display nowrap data_table_no_pagging" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Device Name</th>
                                        <th>Serial Number</th>
                                        <th>Device Alias Name</th>
                                        <th>Status</th>
                                        <th>Transfer Time</th>
                                        <th>Last Activity</th>
                                        <th>Employee</th>
                                        <th>Finger Print</th>
                                        <th>Transaction</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($device as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->device_name }}</td>
                                        <td>{{ $item->sn }}</td>
                                        <td>{{ $item->alias }}</td>
                                        <td>
                                            @if($item->state == 1)
                                                <label class="text-success"><i class="fa fa-check-circle" style="font-size: 15px;"></i> Online</label>
                                            @else
                                                <label class="text-danger"><i class="fa fa-times-circle" style="font-size: 15px;"></i> Offline</label>
                                            @endif
                                        </td>
                                        <td>{{ $item->trans_time }}</td>
                                        <td>{{ $item->last_activity }}</td>
                                        <td>{{ $item->user_count }}</td>
                                        <td>{{ $item->fp_count }}</td>
                                        <td>{{ $item->transaction_count }}</td>
                                        <td>
                                            <a href="{{ route('attendance.detail-attendance', $item->sn) }}" class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody> 
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="upload">
                             <a href="{{ route('administrator.absensi.import') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> IMPORT ATTENDANCE</a>
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="display nowrap data_table_no_pagging" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="30" class="text-center">#</th>
                                            <th>DATE UPLOAD ATTENDANCE</th>
                                            <th>MANAGE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach($data as $key => $item)
                                        <tr>
                                            <td width="30" >{{ $key + 1 }}</td>
                                            <td>{{ $item->tanggal_upload }}</td>
                                            <td><a href="{{ route('administrator.absensi.detail', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> detail</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div> 
        </div>
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
@endsection
