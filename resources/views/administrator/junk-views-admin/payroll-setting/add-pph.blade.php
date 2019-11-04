@extends('layouts.administrator')

@section('title', 'Form PPH 21')

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
                <h4 class="page-title">Form PPH 21</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">PPH 21</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.payroll-setting.store-pph') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Add Setting PPH 21</h3>
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
                            <label class="col-md-12">Lower Limit (IDR)</label>
                            <div class="col-md-6">
                               <input type="number" name="batas_bawah" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Upper Limit (IDR)</label>
                            <div class="col-md-6">
                               <input type="number" name="batas_atas" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Rate(%)</label>
                            <div class="col-md-6">
                               <input type="number" name="tarif" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Minimal Tax (IDR)</label>
                            <div class="col-md-6">
                               <input type="number" name="pajak_minimal" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Tax Accumulation (IDR)</label>
                            <div class="col-md-6">
                               <input type="number" name="akumulasi_pajak" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Other Condition</label>
                            <div class="col-md-6">
                               <input type="text" name="kondisi_lain" class="form-control">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <br />
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('administrator.payroll-setting.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
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
