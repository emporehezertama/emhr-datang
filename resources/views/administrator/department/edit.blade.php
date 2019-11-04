@extends('layouts.administrator')

@section('title', 'Department')

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
                <h4 class="page-title">Form Division</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Department</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.department.update', $data->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Data Department</h3>
                        <br />
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
                            <label class="col-md-12">Directorate</label>
                            <div class="col-md-6">
                               <select class="form-control" name="directorate_id" required>
                                    <option value=""> Pilih Directorate</option>
                                    @foreach($directorate as $item)
                                    <option value="{{ $item->id }}" {{ $data->directorate_id == $item->id ? ' selected': '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Division</label>
                            <div class="col-md-6">
                                <select class="form-control" name="division_id" required>
                                    <option value=""> Pilih Division</option>
                                    @foreach($division as $item)
                                    <option value="{{ $item->id }}" {{ $data->division_id == $item->id ? 'selected':'' }} >{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Name Department</label>
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control form-control-line" value="{{ $data->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description">{{ $data->description }}</textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    
                        <a href="{{ route('administrator.department.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Simpan Data</button>
                        <br style="clear: both;" />
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @extends('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
