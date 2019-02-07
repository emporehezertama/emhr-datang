@extends('layouts.karyawan')

@section('title', 'Request Pay Slip')

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
                <h4 class="page-title hidden-xs hidden-sm">Dashboard</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                @if(Auth::user()->join_date === NULL)
                    <a onclick="bootbox.alert('Silahkan update join date terlebih dahulu !')" class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light"> <i class="fa fa-plus"></i> REQUEST PAY SLIP</a>
                @else
                    <a href="{{ route('karyawan.request-pay-slip.create') }}" class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light"> <i class="fa fa-plus"></i> REQUEST PAY SLIP</a>
                @endif
                
                <ol class="breadcrumb hidden-xs hidden-sm">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Request Pay Slip</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Request Pay Slip</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>SUBMISSION DATE</th>
                                    <th>ADMIN COMMENT</th>
                                    <th>STATUS</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td> 
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>
                                            @if($item->status == 1)
                                                <label class="btn btn-warning btn-xs">Waiting Proses Admin</label>
                                            @else
                                                <label class="btn btn-success btn-xs" onclick="bootbox.alert('Pay Slip anda sudah dikirim ke email anda, silahkan di cek email anda !')">Success Send Email</label>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('karyawan.request-pay-slip.edit', $item->id) }}" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i> detail</a>
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
