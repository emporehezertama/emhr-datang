@extends('layouts.administrator')

@section('title', 'Form PTKP')

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
                <h4 class="page-title">Form PTKP</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">PTKP</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.payroll-setting.update-ptkp', $data->id) }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Edit Setting PTKP</h3>
                        <hr />
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
                            <label class="col-md-12">Single</label>
                            <div class="col-md-6">
                               <input type="number" name="bujangan" class="form-control" value="{{ $data->bujangan_wanita }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Married</label>
                            <div class="col-md-6">
                               <input type="number" name="menikah" class="form-control" value="{{ $data->menikah }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Married With 1 Child</label>
                            <div class="col-md-6">
                               <input type="number" name="menikah_anak_1" class="form-control" value="{{ $data->menikah_anak_1 }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Married With 2 Child</label>
                            <div class="col-md-6">
                               <input type="number" name="menikah_anak_2" class="form-control" value="{{ $data->menikah_anak_2 }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Married With 3 Child</label>
                            <div class="col-md-6">
                               <input type="number" name="menikah_anak_3" class="form-control" value="{{ $data->menikah_anak_3 }}">
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <br />
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('administrator.payroll-setting.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Update</button>
                                <br style="clear: both;" />
                            </div>
                        </div>
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
