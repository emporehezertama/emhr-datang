@extends('layouts.administrator')

@section('title', 'Business Trip Allowance')

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
                <h4 class="page-title">Form Business Trip Allowance</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Business Trip Allowance</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.plafond-dinas.update', $data->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                
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
                            <label class="col-md-12">Position</label>
                            <div class="col-md-6">
                                <select class="form-control" name="organisasi_position_id">
                                        <option value=""> - choose Position - </option>
                                        @foreach($position as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->organisasi_position_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Plafond Type</label>
                            <div class="col-md-6">
                                <select class="form-control" name="plafond_type">
                                    <option value=""> - none - </option>
                                    @foreach(get_plafond_type() as $item)
                                    <option {{ $item == $data->plafond_type ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                      
                        <!--
                        <div class="form-group">
                            <label class="col-md-12">Hotel (IDR)</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="hotel" value="{{ $data->hotel }}"> 
                            </div>
                        </div>
                        -->
                        <div class="form-group">
                            <label class="col-md-12">Meal Allowance / Day (IDR)</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="tunjangan_makanan" value="{{ $data->tunjangan_makanan }}"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Daily Allowance / Day (IDR)</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="tunjangan_harian" value="{{ $data->tunjangan_harian }}"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="keterangan">{{ $data->keterangan }}</textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <a href="{{ route('administrator.plafond-dinas.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
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
