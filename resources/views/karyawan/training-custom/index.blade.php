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
                <h4 class="page-title hidden-xs hidden-sm">Manage Business Trip</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('karyawan.training-custom.create') }}" class="btn btn-success btn-sm pull-right m-l-20  widthaves-effect waves-light"> <i class="fa fa-plus"></i> ADD BUSINESS TRIP</a>
                <ol class="breadcrumb hidden-xs hidden-sm">
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
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>ACTIVITY TYPE</th>
                                    <th>ACTIVITY TOPIC</th>
                                    <th>ACTIVITY DATE</th>
                                    <th>STATUS</th>
                                    <th>BILL</th>
                                    <th>CREATED</th>
                                    <th>#</th>
                                    <th width="100">ACTUAL BILL REPORT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>   
                                        <td>{{ isset($item->training_type)? $item->training_type->name:''}}</td>
                                        <td>{{ $item->topik_kegiatan }}</td>
                                        <td>{{ date('d F Y', strtotime($item->tanggal_kegiatan_start)) }} - {{ date('d F Y', strtotime($item->tanggal_kegiatan_end)) }}</td>
                                        <td>
                                            <a onclick="detail_approval_trainingCustom({{ $item->id }})"> 
                                            {!! status_cuti($item->status) !!}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" onclick="detail_approval_trainingClaimCustom({{ $item->id }})"> 
                                                {!! status_cuti($item->status_actual_bill) !!}
                                            </a>
                                        </td>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('karyawan.training-custom.edit', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> detail</a>
                                        </td>
                                        <td>
                                            @if($item->status == 2)
                                                @if(empty($item->status_actual_bill) or $item->status_actual_bill < 1)
                                                    <a href="{{ route('karyawan.training-custom.claim', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-book"></i> Reimbursement</a>
                                                @else
                                                    @if($item->status_actual_bill >= 1)
                                                    <a href="{{ route('karyawan.training-custom.claim', $item->id) }}">
                                                    <label class="btn btn-info btn-xs"><i class="fa fa-history"></i> Detail Actual Bill</label></a>
                                                    @endif
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
@section('footer-script')
@endsection

@endsection
