@extends('layouts.administrator')

@section('title', 'List of Asset')

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
                <h4 class="page-title">Form List of Asset</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">List of Asset</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.asset.update', $data->id) }}" method="POST">
                <div class="col-md-12">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Asset</h3>
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
                            <label class="col-md-12">Asset Number</label>
                            <div class="col-md-6">
                               <input type="text" readonly="true" class="form-control" value="{{ $data->asset_number }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Name</label>
                            <div class="col-md-6">
                               <input type="text" name="asset_name" class="form-control" value="{{ $data->asset_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Type</label>
                            <div class="col-md-6">
                                <select name="asset_type_id" class="form-control">
                                    <option value=""> - none - </option>
                                    @foreach($asset_type as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $data->asset_type_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="asset-mobil col-md-6" style="{{ ($data->asset_type->name != 'Mobil' ? 'display: none;' : '') }}">
                            <div class="form-group">
                                <label class="col-md-12">Car Type</label>
                                <div class="col-md-12">
                                    <input type="text" name="tipe_mobil" value="{{ $data->tipe_mobil }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Year</label>
                                <div class="col-md-12">
                                    <input type="text" name="tahun" class="form-control" value="{{ $data->tahun }}">
                                </div>
                           </div>
                           <div class="form-group">
                                <label class="col-md-12">Plat Number</label>
                                <div class="col-md-12">
                                    <input type="text" name="no_polisi" class="form-control" value="{{ $data->no_polisi }}">
                                </div>
                           </div>
                           <div class="form-group">
                                <label class="col-md-12">Car Status</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="status_mobil">
                                        <option value="">- none -</option>
                                        <option {{ $data->status_mobil == 'Rental' ? 'selected' : '' }}>Rental</option>
                                        <option {{ $data->status_mobil == 'Perusahaan' ? 'selected' : '' }}>Company Inventory</option>
                                    </select>
                                </div>
                           </div>
                        </div>
                        <div class="form-group asset-sn"  style="{{ ($data->asset_type->name == 'Mobil' ? 'display: none;' : '') }}">
                            <label class="col-md-12">Asset S/N or Code</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="asset_sn" value="{{ $data->asset_sn }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Purchase Date</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="purchase_date" value="{{ $data->purchase_date }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Remark</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="remark" value="{{ $data->remark }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Rental Date</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="rental_date" value="{{ $data->rental_date }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Condition</label>
                            <div class="col-md-6">
                                <select class="form-control" name="asset_condition">
                                    <option value=""> - none - </option>
                                    <option value="Good" {{ $data->asset_condition =='Good' ? 'selected' : '' }}>Good</option>
                                    <option value="Malfunction" {{ $data->asset_condition =='Malfunction' ? 'selected' : '' }}>Malfunction</option>
                                    <option value="Lost" {{ $data->asset_condition =='Lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-12">Assign To</label>
                            <div class="col-md-6">
                                <select class="form-control" name="assign_to">
                                    <option value=""> - none - </option>
                                    <option {{ $data->assign_to =='Employee' ? 'selected' : '' }}>Employee</option>
                                    <option {{ $data->assign_to =='Office Facility' ? 'selected' : '' }}>Office Facility</option>
                                    <option {{ $data->assign_to =='Office Inventory/idle' ? 'selected' : '' }}>Office Inventory/idle</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Employee/PIC Name </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-karyawan" readonly value="{{ $data->user->nik .' - '. $data->user->name }}">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <hr />
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('administrator.asset.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Update Data</button>
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
    @include('layouts.footer')
</div>
<style type="text/css">
    .asset-mobil {
        padding:10px;
        border:1px solid #eee;
        background: #efefef;
        margin-bottom: 20px;
    }
</style>
@section('footer-script')
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
</script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
