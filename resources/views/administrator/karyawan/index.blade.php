@extends('layouts.administrator')

@section('title', 'Karyawan')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title" style="overflow: inherit;">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Employee</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <form method="POST" action="" id="filter-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="action" value="view">
                    <div class="btn-group pull-right">
                        <a href="javascript:void(0)" title="Layout Table Employee Grid / Table" aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-sm btn-outline dropdown-toggle">
                            @if(get_setting('layout_karyawan') == 'grid') 
                                <i class="fa fa-th-large"></i>
                            @else
                                <i class="fa fa-list"></i>
                            @endif
                        </a>
                        <ul role="menu" class="dropdown-menu" style="min-width: 10px;">
                            @if(get_setting('layout_karyawan') == 'grid') 
                            <li><a href="{{ route('administrator.karyawan.index') }}?layout_karyawan=list" class="pull-right" title="Table Data" style="{{ (get_setting('layout_karyawan') == 'list') ? 'color: grey;' : '' }} padding: 0px 10px;"><i class="fa fa-list"></i></a></li>
                            @else
                            <li><a href="{{ route('administrator.karyawan.index') }}?layout_karyawan=grid" class="pull-right" title="Grid Data" style="{{ (get_setting('layout_karyawan') == 'grid') ? 'color: grey;' : '' }} padding: 0px 10px;"><i class="fa fa-th-large"></i></a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="btn-group m-l-10 m-r-10 pull-right">
                        <a href="javascript:void(0)" aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">Action 
                            <i class="fa fa-gear"></i>
                        </a>
                        <ul role="menu" class="dropdown-menu">
                            @if(checkUserLimit())
                            <li><a href="{{ route('administrator.karyawan.create') }}"> <i class="fa fa-plus"></i> Add Employee</a></li>
                            @endif
                            <li><a href="javascript:void(0)" id="add-import-karyawan"> <i class="fa fa-upload"></i> Import</a></li>
                            <li><a onclick="submit_filter_download()"><i class="fa fa-download"></i> Download </a></li>
                        </ul>
                    </div>
                    <button id="filter_view" class="btn btn-default btn-sm pull-right btn-outline"> <i class="fa fa-search-plus"></i></button>
                    <div class="col-md-2 pull-right">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="jabatan">
                                <option value="">- Position - </option>
                                <option {{ (request() and request()->jabatan == 'Staff') ? 'selected' : '' }}>Staff</option>
                                <option {{ (request() and request()->jabatan == 'Manager') ? 'selected' : '' }}>Manager</option>
                                <option {{ (request() and request()->jabatan == 'Direktur') ? 'selected' : '' }}>Director</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="employee_status">
                                <option value="">- Employee Status - </option>
                                <option {{ (request() and request()->employee_status == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                <option {{ (request() and request()->employee_status == 'Contract') ? 'selected' : '' }}>Contract</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        <div class="form-group  m-b-0">
                            <input type="text" name="name" class="form-control form-control-line" value="{{ (request() and request()->name) ? request()->name : '' }}" placeholder="Name / NIK Employee">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            @if(get_setting('layout_karyawan') == 'list')
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <div class="table-responsive" style="overflow-y: unset;overflow-x: unset;">
                        <table id="data_table_no_pagging" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIK</th>
                                    <th>@lang('general.name')</th>
                                    <th>GENDER</th>
                                    <th>TELEPHONE</th>
                                    <th>EMAIL</th>
                                    <th>POSITION </th>
                                    <th>
                                        @if($countPos > 0)
                                            <a href="{{ route('administrator.karyawan.index', ['position'=> 1])}}"><label class="btn btn-danger btn-xs" style="text-align: center;" title="">{{$countPos}}</label></a>
                                        @endif
                                    </th>
                                    <th>DIVISION</th>
                                    <th>RESIGN</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ strtoupper($item->name) }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>{{ $item->telepon }}</td>
                                        <td>{{ $item->email }}</td>
                                        @if(get_setting('struktur_organisasi') == 3)
                                        <td>{{ isset($item->structure->position) ? $item->structure->position->name:''}}</td>
                                        <td></td>
                                        <td>
                                            {{ isset($item->structure->division) ? $item->structure->division->name:'' }}
                                        </td>
                                        @else
                                        <td>
                                            @if(!empty($item->empore_organisasi_staff_id))
                                                Staff
                                            @endif

                                            @if(empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_manager_id))
                                                Manager
                                            @endif

                                            @if(empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_manager_id) and !empty($item->empore_organisasi_direktur))
                                                Direktur
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($item->empore_organisasi_staff_id))
                                                {{ isset($item->empore_staff->name) ? $item->empore_staff->name : '' }}
                                            @endif

                                            @if(empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_manager_id))
                                                {{ isset($item->empore_manager->name) ? $item->empore_manager->name : '' }}
                                            @endif
                                        </td>
                                        @endif
                                        <td>
                                            @if(isset($item->resign_date))
                                                <label class="btn btn-danger btn-xs" style="text-align: center;" title="{{$item->resign_date}}">R</label>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group m-r-10">
                                                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle waves-effect waves-light" type="button">Action 
                                                    <span class="caret"></span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('administrator.karyawan.edit', ['id' => $item->id]) }}"><i class="fa fa-search-plus"></i> Detail</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('administrator.karyawan.destroy', $item->id) }}" method="post">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}                                               
                                                            <a href="javascript:void(0)" onclick="confirm_delete('Delete this data ?', this)"><i class="ti-trash"></i> Delete</a>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('administrator.karyawan.print-profile', $item->id) }}" target="_blank"><i class="fa fa-print"></i> Print</a>
                                                    </li>
                                                    
                                                    @if(!empty($item->generate_kontrak_file))
                                                        <li>
                                                            <a href="{{ asset('/storage/file-kontrak/'. $item->id. '/'. $item->generate_kontrak_file) }}" target="_blank"><i class="fa fa-search-plus"></i> View Contract File</a> 
                                                        </li>
                                                    @endif

                                                    @if($item->is_generate_kontrak == "")
                                                    <li>
                                                        <a onclick="generate_file_document({{ $item->id }})"><i class="fa fa-file"></i> Generate Contract Document</a>
                                                    </li>
                                                    @endif
                                                    <li>
                                                        <a onclick="upload_file_dokument({{ $item->id }})"><i class="fa fa-upload"></i> Upload Contract File</a>
                                                    </li>
                                                    <li>
                                                        <a onclick="confirm_loginas('{{ $item->name }}','{{ route('administrator.karyawan.autologin', $item->id) }}')"><i class="fa fa-key"></i> Autologin</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-m-6 pull-left text-left">Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries</div>
                        <div class="col-md-6 pull-right text-right">{{ $data->appends($_GET)->render() }}</div><div class="clearfix"></div>
                    </div>
                </div>
            </div> 
            @else
                @foreach($data as $no => $item)
                    <div class="col-md-4 col-sm-4">
                        <div class="white-box" style="min-height: 241px;">
                            <div class="row">
                                <div class="btn-group m-r-10 pull-right">
                                    <a aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle waves-effect waves-light">Action 
                                        <span class="caret"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="{{ route('administrator.karyawan.edit', ['id' => $item->id]) }}"><i class="fa fa-search-plus"></i> Detail</a></li>
                                        <li>
                                            <form action="{{ route('administrator.karyawan.destroy', $item->id) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <a href="javascript:void(0)" onclick="confirm_delete('Delete this data ?', this)"><i class="ti-trash"></i> Delete</a>
                                            </form>
                                        </li>
                                        <li><a href="{{ route('administrator.karyawan.print-profile', $item->id) }}" target="_blank"><i class="fa fa-print"></i> Print</a></li>                                        
                                        @if(!empty($item->generate_kontrak_file))
                                            <li><a href="{{ asset('/storage/file-kontrak/'. $item->id. '/'. $item->generate_kontrak_file) }}" target="_blank"><i class="fa fa-search-plus"></i> View Contract File</a> </li>
                                        @endif
                                        @if($item->is_generate_kontrak == "")
                                        <li><a onclick="generate_file_document({{ $item->id }})"><i class="fa fa-file"></i> Generate Contract Document</a></li>
                                        @endif
                                        <li><a onclick="upload_file_dokument({{ $item->id }})"><i class="fa fa-upload"></i> Upload Contract File</a></li>
                                        <li><a onclick="confirm_loginas('{{ $item->name }}','{{ route('administrator.karyawan.autologin', $item->id) }}')"><i class="fa fa-key"></i> Autologin</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <a href="{{ route('administrator.karyawan.edit', $item->id) }}">
                                        @if(empty($item->foto))
                                            @if($item->jenis_kelamin == 'Male' || $item->jenis_kelamin == "")
                                                <img src="{{ asset('images/user-man.png') }}" alt="{{ $item->title }}" class="img-circle img-responsive">
                                            @else
                                                <img src="{{ asset('images/user-woman.png') }}" alt="{{ $item->title }}" class="img-circle img-responsive">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/foto/'.$item->foto) }}" alt="{{ $item->title }}" class="img-circle img-responsive">
                                        @endif
                                    </a><br />
                                    <p><strong>{{ $item->nik }}</strong></p>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <h3 class="box-title m-b-0">{{ $item->name }}</h3> 
                                    <small>
                                    @if(!empty($item->empore_organisasi_staff_id))
                                        {{ isset($item->empore_staff->name) ? $item->empore_staff->name : '' }}
                                    @endif

                                    @if(empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_manager_id))
                                        {{ isset($item->empore_manager->name) ? $item->empore_manager->name : '' }}
                                    @endif
                                    </small>
                                    <address>
                                        {{ $item->current_address }}<br />
                                        @if(!empty($item->telepon))
                                            <i class="mdi mdi-phone"></i> {{ $item->telepon }}<br />
                                        @endif
                                        @if(!empty($item->email))
                                            <i class="mdi mdi-email"></i> <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                                        @endif
                                    </address>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @include('layouts.footer')
</div>

<!-- modal content education  -->
<div id="modal_upload_dokument" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Upload Contract Document</h4> </div>
                <form method="POST" id="form-upload-file-dokument" enctype="multipart/form-data" class="form-horizontal" action="{{ route('administrator.karyawan.upload-dokument-file') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3">File (xls)</label>
                        <div class="col-md-9">
                            <input type="file" name="file" class="form-control" />
                            <input type="hidden" name="user_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info btn-sm">Upload File</button>
                </div>
            </form>
            <div style="text-align: center;display: none;" class="div-proses-upload">
                <h3>Proses upload harap menunggu !</h3>
                <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
            </div>
        </div>
    </div>
</div> 

<!-- modal content education  -->
<div id="modal_generate_dokument" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Generate Contract Document</h4> </div>
                    <form method="POST" id="form-generate-file-dokument" enctype="multipart/form-data" class="form-horizontal" action="{{ route('administrator.karyawan.generate-dokument-file') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-6">Join Date</label>
                            <label class="col-md-6">End Date</label>
                            <div class="col-md-6">
                                <input type="text" name="join_date" class="form-control datepicker">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="end_date" class="form-control datepicker">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Status</label>
                            <div class="col-md-9">                                
                                <select class="form-control" name="organisasi_status">
                                    <option value="">- pilih -</option>
                                    <option>Permanent</option>
                                    <option>Contract</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="user_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm">Generate File</button>
                    </div>
                </form>
                <div style="text-align: center;display: none;" class="div-proses-upload">
                    <h3>Proses upload harap menunggu !</h3>
                    <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
                </div>
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
                    <form method="POST" id="form-upload" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('administrator.karyawan.import') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">File (xls)</label>
                            <div class="col-md-9">
                                <input type="file" name="file" class="form-control" />
                            </div>
                        </div>
                        <a href="{{ asset('storage/sample/Sample-Karyawan.xlsx') }}"><i class="fa fa-download"></i> Download Sample Excel</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <label class="btn btn-info btn-sm" id="btn_import">Import</label>
                    </div>
                </form>
                <div style="text-align: center;display: none;" class="div-proses-upload">
                    <h3>Uploading !</h3>
                    <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')
<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    
    $("#filter_view").click(function(){
        $("#filter-form input[name='action']").val('view');
        $("#filter-form").submit();

    });

    var submit_filter_download = function(){
        $("#filter-form input[name='action']").val('download');
        $("#filter-form").submit();
    }

    function confirm_loginas(name, url)
    {
        bootbox.confirm("Login as "+ name +" ? ", function(result){

            if(result)
            {
                window.location = url;
            }
        });
    }

    jQuery('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

    function generate_file_document(id)
    {
        $("#modal_generate_dokument").modal("show");

        $("#form-generate-file-dokument input[name='user_id']").val(id);

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-karyawan-by-id') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                $("#form-generate-file-dokument input[name='join_date']").val(data.data.join_date);
                $("#form-generate-file-dokument input[name='end_date']").val(data.data.end_date);
                $("#form-generate-file-dokument select[name='organisasi_status']").val(data.data.organisasi_status);
            }
        });
    }

    function upload_file_dokument(id)
    {
        $("#modal_upload_dokument").modal("show");

        $("#form-upload-file-dokument input[name='user_id']").val(id);
    }

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