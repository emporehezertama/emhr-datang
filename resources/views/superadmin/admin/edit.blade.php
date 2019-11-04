@extends('layouts.superadmin')

@section('title', 'Administrator')

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
                <h4 class="page-title">Form Administrator</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Administrator</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('superadmin.admin.update', $data->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Update Data Administrator</h3>
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
                            <label class="col-md-12">Name</label>
                            <div class="col-md-6">
                                <input type="text" readonly="true" name="name" class="form-control name" value="{{ $data->name }}"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">NIK / User Name</label>
                            <div class="col-md-6">
                            <input type="text" readonly="true" name="nik" class="form-control nik" value="{{ $data->nik }}"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Email</label>
                            <div class="col-md-6">
                            <input type="email" class="form-control email" name="email" value="{{ $data->email }}"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Password</label>
                            <div class="col-md-6">
                            <input type="password" name="password" class="form-control " value="{{ $data->password }}"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Confirm Password</label>
                            <div class="col-md-6">
                            <input type="password" value="{{ $data->password }}" name="confirm" class="form-control "></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Mobile </label>
                            <div class="col-md-6">
                            <input type="number" value="{{ $data->mobile_1 }}" name="mobile_1" class="form-control mobile_1"> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Privilege </label>
                            @foreach($module as $no => $item)
                                @php($check='')
                                @foreach($moduleAdmin as $key => $items)
                                    @if($items->product_id == $item->crm_product_id)
                                        @php($check='checked')
                                    @endif
                                @endforeach
                            <div class="col-md-6">
                                <label><input type="checkbox" {{$check}} style="margin-right: 10px; margin-bottom: 10px" name="product_id[]" value="{{$item->crm_product_id}}"> {{$item->modul_name}}</label>
                                </div>
                            <div class="clearfix"></div>
                            @endforeach
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="white-box form-horizontal">
                        <a href="{{ route('superadmin.admin.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
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
