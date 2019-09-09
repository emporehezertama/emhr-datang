@extends('layouts.karyawan')

@section('title', 'Business Trip')

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
                    <li class="active">Business Trip</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Business Trip</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>DEPARTMENT / POSITION</th>
                                    <th>ACTIVITY TYPE</th>
                                    <th>ACTIVITY TOPIC</th>
                                    <th>ACTIVITY DATE</th>
                                    <th>STATUS</th>
                                    <th>BILL</th>
                                    <th>CREATED</th>
                                    <th width="100">MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    @if(!isset($item->user->name))
                                        <?php continue; ?>
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>  
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</a></td>
                                        <td>{{ empore_jabatan($item->user->id) }}</td> 
                                        <td>{{ $item->jenis_training }}</td>
                                        <td>{{ $item->topik_kegiatan }}</td>
                                        <td>{{ date('d F Y', strtotime($item->tanggal_kegiatan_start)) }} - {{ date('d F Y', strtotime($item->tanggal_kegiatan_end)) }}</td>
                                        <td>
                                            @if($item->is_approved_atasan == 0)
                                                <label class="btn btn-warning btn-xs" onclick="status_approval_training({{ $item->id }})">Waiting Approval</label>
                                            @else
                                                <label class="btn btn-success btn-xs" onclick="status_approval_training({{ $item->id }})">Approved</label>
                                            @endif
                                        </td>
                                        <td> 
                                            @if($item->status == 2)
                                                <a onclick="status_approval_actual_bill({{ $item->id }})"> 
                                                    @if($item->status_actual_bill == 2 and $item->is_approve_atasan_actual_bill == "")
                                                        <label class="btn btn-warning btn-xs">Wating Approval</label>
                                                    @endif

                                                    @if($item->status_actual_bill == 2 and $item->is_approve_atasan_actual_bill === 0)
                                                        <label class="btn btn-danger btn-xs">Denied</label>
                                                    @endif

                                                    @if($item->status_actual_bill == 2 and $item->is_approve_atasan_actual_bill == 1)
                                                        <label class="btn btn-success btn-xs">Approved</label>
                                                    @endif

                                                    @if($item->status_actual_bill == 3)
                                                        <label class="btn btn-success btn-xs">Approved</label>
                                                    @endif

                                                    @if($item->status_actual_bill == 4)
                                                        <label class="btn btn-danger btn-xs">Denied</label>
                                                    @endif
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>

                                            @if($item->status_actual_bill == 2 and $item->is_approve_atasan_actual_bill == 0)
                                             <a href="{{ route('karyawan.approval.training-atasan.biaya', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-file"></i> Proses Actual Bill</button></a>
                                            @endif

                                            @if($item->is_approve_atasan_actual_bill == 1 || $item->is_approve_atasan_actual_bill === 0 )
                                             <a href="{{ route('karyawan.approval.training-atasan.biaya', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-file"></i> Detail Actual Bill</button></a>
                                            @endif

                                            @if($item->is_approved_atasan == 0)
                                                <a href="{{ route('karyawan.approval.training-atasan.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5">proses <i class="fa fa fa-arrow-right"></i></button></a>
                                            @else
                                                <a href="{{ route('karyawan.approval.training-atasan.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5">detai <i class="fa fa-search-plus"></i></button></a>
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
