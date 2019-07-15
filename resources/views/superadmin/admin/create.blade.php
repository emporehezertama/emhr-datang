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
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('superadmin.admin.store') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Data Administrator</h3>
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
                        <div class="col-md-6" style="padding-left: 0">
                            <div class="form-group">
                                <label class="col-md-12">Name</label>
                                <div class="col-md-10">
                                <input type="text" name="name" style="text-transform: uppercase"  class="form-control autocomplete"> </div>
                                <input type="hidden" name="admin_id" />
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">NIK / User Name</label>
                                <div class="col-md-10">
                                <input type="text" name="nik" class="form-control nik"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Email</label>
                                <div class="col-md-10">
                                <input type="email" class="form-control email" name="email" > </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password</label>
                                <div class="col-md-10">
                                <input type="password" value="{{ old('password') }}" name="password" class="form-control "> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Confirm Password</label>
                                <div class="col-md-10">
                                <input type="password" value="{{ old('confirm') }}" name="confirm" class="form-control "></div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Mobile </label>
                                <div class="col-md-10">
                                <input type="number" name="mobile_1" class="form-control mobile_1"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Privilege </label>
                                @foreach($data as $no => $item)
                                <div class="col-md-10">
                                    <label><input type="checkbox" style="margin-right: 10px; margin-bottom: 10px" name="product_id[]" value="{{$item->crm_product_id}}"> {{$item->modul_name}}</label>
                                </div>
                            <div class="clearfix"></div>
                            @endforeach
                            </div>
                        </div>
                        <div class="clearfix"></div>
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
@section('footer-script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
    .ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front {
        z-index: 9999 !important;
    } 
</style>
<script type="text/javascript">

    $(".autocomplete" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-administrator') }}",
              method : 'POST',
              data: {
                'name': request.term,'_token' : $("meta[name='csrf-token']").attr('content')
              },
              success: function( data ) {
                response(data);
              }
            });
        },
        select: function( event, ui ) {
            $("input[name='admin_id']").val(ui.item.id);
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-karyawan-by-id') }}',
                data: {'id' : ui.item.id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    $('.nik').val(data.data.nik);
                    $('.email').val(data.data.email);
                    $('.mobile_1').val(data.data.mobile_1);
                    /*
                    setTimeout(function(){
                        $(".autocomplete").val(" ");

                        $(".autocomplete").triggerHandler("focus");

                    }, 500);
                    /*
                }
            });
            $(".autocomplete").val("");
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });
</script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
