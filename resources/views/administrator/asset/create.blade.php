@extends('layouts.administrator')

@section('title', 'List of Asset')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Add List of Asset</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">List of Asset</li>
                </ol>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data" action="{{ route('administrator.asset.store') }}" method="POST">
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
                            <label class="col-md-12">Asset Number</label>
                            <div class="col-md-6">
                               <input type="text" name="asset_number" readonly="true" class="form-control" value="{{ $asset_number }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Name</label>
                            <div class="col-md-6">
                               <input type="text" name="asset_name" class="form-control" value="{{ old('asset_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Type</label>
                            <div class="col-md-6">
                                <select name="asset_type_id" class="form-control">
                                    <option value=""> - none - </option>
                                    @foreach($asset_type as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="asset-mobil col-md-6">
                            <div class="form-group">
                                <label class="col-md-12">Car Type</label>
                                <div class="col-md-12">
                                    <input type="text" name="tipe_mobil" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Year</label>
                                <div class="col-md-12">
                                    <input type="text" name="tahun" class="form-control">
                                </div>
                           </div>
                           <div class="form-group">
                                <label class="col-md-12">Plat Number</label>
                                <div class="col-md-12">
                                    <input type="text" name="no_polisi" class="form-control">
                                </div>
                           </div>
                           <div class="form-group">
                                <label class="col-md-12">Car Status</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="status_mobil">
                                        <option value="">- none -</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Perusahaan">Company Inventory</option>
                                    </select>
                                </div>
                           </div>
                        </div>
                        <div class="form-group asset-sn">
                            <label class="col-md-12">Asset S/N or Code</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="asset_sn" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Purchase Date</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="purchase_date" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Remark</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="remark" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Rental Date</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="rental_date" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Condition</label>
                            <div class="col-md-6">
                                <select class="form-control" name="asset_condition">
                                    <option value=""> - none - </option>
                                    <option value="Good">Good</option>
                                    <option value="Malfunction">Malfunction</option>
                                    <option value="Lost">Lost</option>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-12">Assign To</label>
                            <div class="col-md-6">
                                <select class="form-control" name="assign_to">
                                    <option value=""> - none - </option>
                                    <option>Employee</option>
                                    <option>Office Facility</option>
                                    <option>Office Inventory/idle</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Employee/PIC Name </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-karyawan">
                                <input type="hidden" name="user_id" class="form-control" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('administrator.asset.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                            <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save and Send</button>
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
    @include('layouts.footer')
</div>
<style type="text/css">
    .asset-mobil {
        display: none;
        padding:10px;
        border:1px solid #eee;
        background: #efefef;
        margin-bottom: 20px;
    }
</style>
@section('footer-script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $("select[name='asset_type_id']").on('change', function(){
        var val = $("select[name='asset_type_id'] option:selected").text();

        if(val == 'Mobil')
        {
            $('.asset-mobil').slideDown("slow");
            $(".asset-sn").hide();
        }
        else
        {
            $('.asset-mobil').slideUp("slow");
            $(".asset-sn").show();
        }
    });
    jQuery('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
    });
    
    $(".autocomplete-karyawan" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan') }}",
              method : 'POST',
              data: {
                'name': request.term,'_token' : $("meta[name='csrf-token']").attr('content')
              },
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
            $( "input[name='user_id']" ).val(ui.item.id);
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });
</script>
@endsection
@endsection
