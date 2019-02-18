@extends('layouts.administrator')

@section('title', 'Request Pay Slip')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Request Pay Slip</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Request Pay Slip</li>
                </ol>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>POSITION</th>
                                    <th>REQUEST DATE</th>
                                    <th>NOTE</th>
                                    <th>STATUS</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    @if(isset($item->user->nik))
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td> 
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ empore_jabatan($item->user_id) }}</td>
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>
                                            @if($item->status == 1)
                                                <label class="btn btn-warning btn-xs">Waiting Proses Admin</label>
                                            @else
                                                <label class="btn btn-success btn-xs">Done</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == 1)
                                                <a href="{{ route('administrator.request-pay-slip.proses', $item->id) }}" class="btn btn-info btn-xs">proses <i class="fa fa-arrow-right"></i> </a>
                                            @else
                                                <a href="{{ route('administrator.request-pay-slip.proses', $item->id) }}" class="btn btn-info btn-xs">detail <i class="fa fa-search-plus"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    @include('layouts.footer')
</div>
@endsection
