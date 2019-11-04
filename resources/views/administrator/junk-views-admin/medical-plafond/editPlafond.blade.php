@extends('layouts.administrator')

@section('title', 'Medical Plafond')

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
                <h4 class="page-title">Form Medical Plafond</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Medical Plafond</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.medical-plafond.update-medical-plafond', $data->id) }}" method="POST">
                
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Business Trip Allowance</h3>
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
                            <label class="col-md-12">Medical Type</label>
                            <div class="col-md-6">
                                <select class="form-control" name="medical_type_id">
                                        <option value=""> - choose Position - </option>
                                        @foreach($type as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->medical_type_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Position</label>
                            <div class="col-md-6">
                                <select class="form-control" name="position_id">
                                        <option value=""> - choose Position - </option>
                                        @foreach($position as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->position_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Amount</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="nominal" value="{{ $data->nominal }}"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description">{{ $data->description }}</textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <a href="{{ route('administrator.medical-plafond.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        <button type="submit"  class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_submit"><i class="fa fa-save"></i> Save</button>
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
@section('footer-script')
 
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
