@extends('layouts.administrator')

@section('title', 'Form Import Employee Attendance')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Import Employee Attendance</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Import Employee Attendance</li>
                </ol>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.absensi.temp-import') }}" method="POST">
                <div class="col-md-12 p-l-0 p-r-0">
                    <div class="white-box">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif

                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label class="col-md-12">Select File</label>
                            <div class="col-md-6">
                               <input type="file" name="file" class="form-control">
                            </div><div class="clearfix"></div><br />
                            <div class="col-md-12">
                                <a href="{{ asset('storage/sample/Sample-Attendance.xls') }}"><i class="fa fa-download"></i> Download Sample Excel</a>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('administrator.absensi.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                            <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Import Attendance</button>
                            <br style="clear: both;" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
@endsection
