@extends('layouts.administrator')

@section('title', 'Setting On Leave')

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
                <h4 class="page-title">Setting On Leave</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('administrator.setting-master-cuti.create') }}" class="btn btn-sm btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD SETTING</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Setting On Leave</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>DESCRIPTION</th>
                                    <th>LEAVE TYPE</th>
                                    <th>QUOTA</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->jenis_cuti }}</td>
                                        <td>{{ $item->kuota }}</td>
                                        <td>
                                            <a href="{{ route('administrator.setting-master-cuti.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                            <a href="{{ route('administrator.setting-master-cuti.delete', ['id' => $item->id]) }}" onclick="return confirm('Delete this data?')"> <button class="btn btn-danger btn-xs m-r-5"><i class="fa fa-trash"></i> delete</button></a>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>                        
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
   @include('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
