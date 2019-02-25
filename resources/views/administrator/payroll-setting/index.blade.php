@extends('layouts.administrator')

@section('title', 'Setting Payroll')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Setting Payroll</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box p-l-1 p-r-1">
                     <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab" aria-expanded="true"> General</a></li>
                        <li role="presentation"><a href="#pph" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> PPH</span></a></li>
                        <li role="presentation" class=""><a href="#ptkp" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs"> PTKP</span></a></li>
                        <li role="presentation" class=""><a href="#others" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs"> Others</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="general">
                            <div class="col-md-12">
                               
                                <form method="POST" action="" class="form-horizontal">
                                    <div class="col-md-6 p-l-0">
                                        <div class="form-group">
                                            <label class="col-md-4">Type Payroll</label>
                                            <div class="col-md-3">
                                                <select class="form-control" name="setting[type_payroll]">
                                                    <option value="1">Payroll Gross</option>
                                                    <option value="2">Payroll Net</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4">BPJS Ketengakerjaan </label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="number" name="setting[bpjs_ketenagakerjaan]" class="form-control" />
                                                    <span class="input-group-addon" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4">BPJS Kesehatan </label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="number" name="setting[bpjs_kesehatan]" class="form-control" />
                                                    <span class="input-group-addon" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><div class="clearfix"></div>
                            
                            <div class="col-md-6" style="border: 1px solid #eee;width: 49%;">
                                <h3>Earnings</h3>
                                <table class="table table-stripped data_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th>Title</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($earnings as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->title }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <a href="" class="btn btn-info btn-xs pull-right" data-toggle="modal" data-target=".modal-add-earnings"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="col-md-6 pull-right" style="margin-left:1%;border: 1px solid #eee;width: 49%;">
                                <h3>Deductions</h3>
                                <table class="table table-stripped data_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">No</th>
                                            <th>Title</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deductions as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->title }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <a href="" class="btn btn-info btn-xs pull-right" data-toggle="modal" data-target=".modal-add-deductions"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pph">
                            <h3 class="box-title m-b-0">Setting PPH 21</h3>
                            <a href="{{ route('administrator.payroll-setting.add-pph') }}" class="btn btn-info btn-sm" style="position: absolute;z-index: 99999;"><i class="fa fa-plus"></i> ADD PPH 21 SETTING</a>
                            <div class="table-responsive">
                                <table id="data_table_no_copy" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>LOWER LIMIT</th>
                                            <th>UPPER LIMIT</th>
                                            <th>RATE</th>
                                            <th>MINIMAL TAX</th>
                                            <th>TAX ACCUMULATION</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pph as $item)
                                        <tr>
                                            <td>{{ number_format($item->batas_bawah) }}</td>
                                            <td>{{ number_format($item->batas_atas) }}</td>
                                            <td>{{ $item->tarif }}</td>
                                            <td>{{ number_format($item->pajak_minimal) }}</td>
                                            <td>{{ number_format($item->akumulasi_pajak) }}</td>
                                            <td>
                                                <a href="{{ route('administrator.payroll-setting.delete-pph', $item->id) }}" onclick="return confirm('Delete this data ?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                                <a href="{{ route('administrator.payroll-setting.edit-pph', $item->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="ptkp">
                            <h3 class="box-title m-b-0">Setting PTKP</h3>
                            <div class="table-responsive">
                                <table id="data_table_no_copy2" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>SINGLE</th>
                                            <th>MARRIED</th>
                                            <th>MARRIED WITH 1 CHILD</th>
                                            <th>MARRIED WITH 2 CHILD</th>
                                            <th>MARRIED WITH 3 CHILD</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($ptkp as $item)
                                       <tr>
                                           <td>{{ number_format($item->bujangan_wanita) }}</td>
                                           <td>{{ number_format($item->menikah) }}</td>
                                           <td>{{ number_format($item->menikah_anak_1) }}</td>
                                           <td>{{ number_format($item->menikah_anak_2) }}</td>
                                           <td>{{ number_format($item->menikah_anak_3) }}</td>
                                           <td>
                                            <a href="{{ route('administrator.payroll-setting.edit-ptkp', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> edit</a>
                                           </td>
                                       </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="others">
                            <h3 class="box-title m-b-0">Others Setting</h3>
                            <a href="{{ route('administrator.payroll-setting.add-others') }}" class="btn btn-info btn-sm" style="position: absolute;z-index: 99999;"><i class="fa fa-plus"></i> ADD OTHERS SETTING</a>
                            <div class="table-responsive">
                                <table id="data_table_no_copy3" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="70" class="text-center">#</th>
                                            <th>LABEL</th>
                                            <th>VALUE</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($others as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ $item->label }}</td>
                                            <td>{{ number_format($item->value) }}</td>
                                            <td>
                                                <a href="{{ route('administrator.payroll-setting.delete-others', $item->id) }}" onclick="return confirm('Delete this data?')" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i> </a>
                                                <a href="{{ route('administrator.payroll-setting.edit-others', $item->id) }}" class="btn btn-default btn-xs "><i class="fa fa-edit"></i> </a>
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
    </div>
    @include('layouts.footer')
</div>

<div class="modal fade modal-add-deductions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Deductions</h4> </div>
                <form method="POST" id="form-upload" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('administrator.payroll-setting.store-deductions') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3">Title</label>
                        <div class="col-md-9">
                            <input type="text" name="title" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-add-earnings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Earnings</h4> </div>
                <form method="POST" id="form-upload" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('administrator.payroll-setting.store-earnings') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-2">Title</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="title" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-info btn-sm" id="btn_import"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
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
    </div>
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
