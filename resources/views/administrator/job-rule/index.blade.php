@extends('layouts.administrator')

@section('title', 'Job Rule')

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
                <a href="{{ route('administrator.job-rule.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> TAMBAH JOB RULE</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Job Rule</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Job Rule</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>DIRECTORATE</th>
                                    <th>DIVISION</th>
                                    <th>DEPARTMENT</th>
                                    <th>SECTION / UNIT</th>
                                    <th>POSITION</th>
                                    <th>JOB RULE</th>
                                    <th>CREATED</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>    
                                        <td>{{ (isset($item->directorate) ? $item->directorate->name : '-')  }}</td>
                                        <td>{{ (isset($item->division) ? $item->division->name : '-') }}</td>
                                        <td>{{ (isset($item->department) ? $item->department->name : '-') }}</td>
                                        <td>{{ (isset($item->unit) ? $item->unit->name : '-') }}</td>
                                        <td>{{ (isset($item->position) ? $item->position->name : '-') }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('administrator.job-rule.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> edit</button></a>
                                            <form action="{{ route('administrator.job-rule.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')" method="post" style="float: left;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete</button>
                                            </form>
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