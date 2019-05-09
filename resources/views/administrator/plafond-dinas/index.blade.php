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
                <h4 class="page-title">Dashboard</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <!--
                <a href="{{ route('administrator.plafond-dinas.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD BUSINESS TRIP ALLOWANCE</a>
                
                <a class="btn btn-info btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light" id="add-import-karyawan"> <i class="fa fa-upload"></i> IMPORT</a>
-->
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Business Trip Allowance</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                     <ul class="nav customtab nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#domestik" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Local</span></a></li>
                        <li role="presentation" class=""><a href="#luarnegeri" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs"> Abroad</span></a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="domestik">
                            <h3 class="box-title m-b-0">Setting for Local Business Trip Allowance</h3>
                            <a href="{{ route('administrator.plafond-dinas.create') }}" class="btn btn-success btn-sm  hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD</a>
                            <br />
                            <div class="table-responsive">
                                <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>POSITION</th>
                                            <!--<th>HOTEL (IDR)</th>-->
                                            <th>PLAFOND TYPE</th>
                                            <th>MEAL ALLOWANCE/DAY'S (IDR)</th>
                                            <th>DAILY ALLOWANCE (IDR / DAY'S)</th>
                                            <th>DESCRIPTION</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ isset($item->position) ? $item->position->name :'' }}</td>
                                            <!--<td>{{ number_format($item->hotel) }}</td>-->
                                            <td>{{ $item->plafond_type}}</td>
                                            <td>{{ number_format($item->tunjangan_makanan) }}</td>
                                            <td>{{ number_format($item->tunjangan_harian) }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                    <a href="{{ route('administrator.plafond-dinas.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                                    <form action="{{ route('administrator.plafond-dinas.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}                                               
                                                        <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete</button>
                                                    </form>
                                                </td>
                                        </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="luarnegeri">
                            <h3 class="box-title m-b-0">Setting for Abroad Business Trip Allowance</h3>
                            <a href="{{ route('administrator.plafond-dinas.create-luar-negeri') }}" class="btn btn-success btn-sm  hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD</a>
                            <br />
                            <div class="table-responsive">
                                <table id="data_table2_no_search" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>POSITION</th>
                                            <!--<th>PLAFOND TYPE</th>-->
                                            <!--<th>HOTEL TYPE</th>-->
                                            <th>MEAL ALLOWANCE/DAY'S (USD)</th>
                                            <th>DAILY ALLOWANCE (USD / DAY'S)</th>
                                            <th>DESCRIPTION</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_luarnegeri as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <!--<td>{{ ucfirst( strtolower($item->organisasi_position_text)) }}</td>-->
                                            <!--<td>{{ $item->hotel }}</td>-->
                                            <td>{{ isset($item->position) ? $item->position->name :'' }}</td>
                                            <!--<td>{{ $item->plafond_type}}</td>-->
                                            <td>{{ number_format($item->tunjangan_makanan) }}</td>
                                            <td>{{ number_format($item->tunjangan_harian) }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                    <a href="{{ route('administrator.plafond-dinas.edit-luar-negeri', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                                    <a href="{{ route('administrator.plafond-dinas.destroy-luar-negeri', ['id' => $item->id]) }}"> <button class="btn btn-danger btn-xs m-r-5"><i class="fa fa-trash"></i> delete</button></a>
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
        </div>
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>

<!-- modal content education  -->
<div id="modal_import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Import Data</h4> </div>
                <form method="POST" id="form-upload" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('administrator.plafond-dinas.import') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3">Business Trip Type</label>
                        <div class="col-md-9">
                            <select name="jenis_plafond" class="form-control">
                                <option>Local</option>
                                <option>Abroad</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3">File (xls)</label>
                        <div class="col-md-9">
                            <input type="file" name="file" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                    <label class="btn btn-info btn-sm" id="btn_import">Import</label>
                </div>
            </form>
            <div style="text-align: center;display: none;" class="div-proses-upload">
                <h3>Process upload, please wait !</h3>
                <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')
<script type="text/javascript">
    $("#btn_import").click(function(){

        $("#form-upload").submit();
        $("#form-upload").hide();
        $('.div-proses-upload').show();
    });

    $("#add-import-karyawan").click(function(){
        $("#modal_import").modal("show");
        $('.div-proses-upload').hide();
        $("#form-upload").show();
    })
</script>
@endsection

@endsection
