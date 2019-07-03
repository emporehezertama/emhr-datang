@extends('layouts.administrator')

@section('title', 'Collective Leave')

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
                <h4 class="page-title">Form Collective Leave</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Collective Leave</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.cuti-bersama.store') }}" method="POST" id="form-cuti-bersama">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Collective Leave</h3>
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
                            <label class="col-md-12">Date</label>
                            <div class="col-md-3">
                               <input type="text" name="dari_tanggal" placeholder="From Date" class="form-control datepicker">
                            </div>
                            <div class="col-md-3">
                               <input type="text" name="sampai_tanggal" placeholder="To Date" class="form-control datepicker">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Total Collective Leave</label>
                            <div class="col-md-3">
                               <input type="number" name="total_cuti" class="form-control">
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('administrator.cuti-bersama.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                            <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="submit-cuti"><i class="fa fa-save"></i> Submit Collective Leave</a>
                            <br style="clear: both;" />
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
@section('footer-script')
    <link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">

        $("#submit-cuti").click(function(){ 

            if($("input[name='dari_tanggal']").val() == "" || $("input[name='sampai_tanggal']").val() == "" || $("input[name='total_cuti']").val() == "" )
            {

                bootbox.alert('Complete all form!');
                return false;
            }
            bootbox.confirm('<label style="color: red;">Collective leave will deduct the annual leave of all employees </label><br ><br > Do you want process this collective leave?', function(result){
                if(result)
                {
                    $("#form-cuti-bersama").submit();
                }
            });

        });

        jQuery('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    </script>
@endsection
    
@endsection
