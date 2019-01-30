@extends('layouts.administrator')

@section('title', 'Employee Attendance')

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
                <h4 class="page-title">Attendance</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Preview Upload Attendance</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Preview Attendance Import</h3>
                    <a href="{{ route('administrator.absensi.import-all') }}" onclick="return confirm('Proses semua data ini?')" class="btn btn-info btn-sm">Process All Data</a>
                    <br />
                    <div class="table-responsive">
                        <table class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>EMPLOYEE NO</th>
                                    <th>AC NO</th>
                                    <th>NAME</th>
                                    <th>AUTO ASSIGN</th>
                                    <th>DATE</th>
                                    <th>TIMETABLE</th>
                                    <th>ON DUTY</th>
                                    <th>OFF DUTY</th>
                                    <th>CLOCK IN</th>
                                    <th>CLOCK OUT</th>
                                    <th>NORMAL</th>
                                    <th>REAL TIME</th>
                                    <th>LATE</th>
                                    <th>EARLY</th>
                                    <th>ABSENT</th>
                                    <th>OT TIME</th>
                                    <th>WORK TIME</th>
                                    <th>EXCEPTION</th>
                                    <th>MUST C IN</th>
                                    <th>MUST C OUT</th>
                                    <th>DEPARTMENT</th>
                                    <th>NDAYS</th>
                                    <th>WEEKEND</th>
                                    <th>HOLIDAY</th>
                                    <th>ATT TIME</th>
                                    <th>NDAYS OT</th>
                                    <th>WEEKEND OT</th>
                                    <th>HOLIDAY OT</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $no => $item)
                                <tr style="background: yellow;">
                                    <td>{{ $no + 1 }}</td>
                                    <td>
                                        
                                        {{ $item->emp_no }}
                                        
                                        @if(!empty($item->absensi_item_id))
                                            <a href="{{ route('administrator.absensi.deletenew', $item->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Hapus data yang baru ?')"><i class="fa fa-trash"></i> Delete New Data</a>
                                            <a href="{{ route('administrator.absensi.deleteold', $item->absensi_item_id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Hapus data yang lama ?')"><i class="fa fa-trash"></i> Delete Old Data</a>
                                        @endif

                                    </td>
                                    <td>{{ $item->ac_no }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->auto_assign }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->timetable }}</td>
                                    <td>{{ $item->on_dutty }}</td>
                                    <td>{{ $item->off_dutty }}</td>
                                    <td>{{ $item->clock_in }}</td>
                                    <td>{{ $item->clock_out }}</td>
                                    <td>{{ $item->normal }}</td>
                                    <td>{{ $item->real_time }}</td>
                                    <td>{{ $item->late }}</td>
                                    <td>{{ $item->early }}</td>
                                    <td>{{ $item->absent }}</td>
                                    <td>{{ $item->ot_time }}</td>
                                    <td>{{ $item->work_time }}</td>
                                    <td>{{ $item->exception }}</td>
                                    <td>{{ $item->must_c_in }}</td>
                                    <td>{{ $item->must_c_out }}</td>
                                    <td>{{ $item->department }}</td>
                                    <td>{{ $item->ndays }}</td>
                                    <td>{{ $item->weekend }}</td>
                                    <td>{{ $item->holiday }}</td>
                                    <td>{{ $item->att_time }}</td>
                                    <td>{{ $item->ndays_ot }}</td>
                                    <td>{{ $item->weekend_ot }}</td>
                                    <td>{{ $item->holiday_ot }}</td>
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
