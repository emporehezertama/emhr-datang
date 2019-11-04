@extends('layouts.administrator')

@section('title', 'Payroll')

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
                <h4 class="page-title">Payroll</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a id="add-import-karyawan" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-file"></i> IMPORT PAYROLL</a>
                <a href="{{ route('administrator.payrollgross.download') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-cloud-download"></i> DOWNLOAD TEMPLATE</a>
                <a href="{{ route('administrator.payrollgross.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> CREATE PAYROLL</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Payroll</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0" style="float: left; margin-right: 10px;">Manage Payroll</h3>
                    <label class="btn btn-warning btn-sm" id="calculate"><i class="fa fa-refresh"></i> Calculate Payroll</label>
                    <hr />
                    <div class="clearfix"></div>
                    
                    <form method="POST" action="{{ route('administrator.payrollgross.index') }}" id="filter-form">
                        <p>Filter Form</p>
                        {{ csrf_field() }}
                        <div class="col-md-1" style="padding-left:0;">
                            <div class="form-group">
                                <select class="form-control" name="is_calculate">
                                    <option value="">- Status -</option>
                                    <option value="0" {{ (request() and request()->is_calculate == '0') ? 'selected' : '' }}>No Calculated</option>
                                    <option value="1" {{ (request() and request()->is_calculate == '1') ? 'selected' : '' }}>Calculated</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1" style="padding-left:0;">
                            <div class="form-group">
                                <select class="form-control" name="jabatan">
                                    <option value="">- Position - </option>
                                    <option {{ (request() and request()->jabatan == 'Staff') ? 'selected' : '' }}>Staff</option>
                                    <option {{ (request() and request()->jabatan == 'Manager') ? 'selected' : '' }}>Manager</option>
                                    <option {{ (request() and request()->jabatan == 'Direktur') ? 'selected' : '' }}>Director</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-left:0;">
                            <div class="form-group">
                                <select class="form-control" name="employee_status">
                                    <option value="">- Employee Status - </option>
                                    <option {{ (request() and request()->employee_status == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                    <option {{ (request() and request()->employee_status == 'Contract') ? 'selected' : '' }}>Contract</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="view">
                        <div class="col-md-3" style="padding-left:0;">
                            <button type="button" id="filter_view" class="btn btn-default btn-sm">View in table <i class="fa fa-search-plus"></i></button>
                            <button type="button" onclick="submit_filter_download()" class="btn btn-info btn-sm">Payroll Report<i class="fa fa-download"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </form>

                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>SALARY</th>
                                    <th>BASIC SALLARY</th>
                                    <th>LESS: TAX, PENSION & JAMSOSTEK (MONTHLY)</th>
                                    <th>TAKE HOME PAY</th>
                                    <th>STATUS</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>

                           	@php ($i = 1)
                            @if(isset($data))	
	                            @foreach($data as $no => $item)
	                            	@if(isset($item->user))
			                            <tr>
			                                <td>{{ $i }}</td>
			                                <td>{{ $item->user->nik or '' }}</td>
			                                <td>{{ $item->user->name or '' }}</td>
			                                <td>{{ number_format($item->salary) }}</td>
			                                <td>{{ number_format($item->basic_salary) }}</td>
			                                <td>{{ number_format($item->less) }}</td>
			                                <td>{{ number_format($item->thp) }}</td>
			                                <td>
			                                    @if($item->is_calculate == 0)
			                                        <label class="btn btn-warning btn-xs btn-circle" title="Not Calculate"><i class="fa fa-close"></i></label>
			                                    @else
			                                        <label class="btn btn-success btn-xs  btn-circle"  title="Calculated"><i class="fa fa-check"></i> </label>
			                                    @endif
			                                </td>
			                                <td>
			                                    <a href="{{ route('administrator.payrollgross.detail', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> detail</a>
			                                </td>
			                            </tr>
			                            @php ($i ++)
                                    @else
                                    
			                        @endIf
	                            @endforeach
	                        @endIf
                            </tbody>
                        </table>
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
                    <form method="POST" id="form-upload" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('administrator.payrollgross.temp-import') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
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
                    <h3>Proses upload harap menunggu !</h3>
                    <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@section('footer-script')
<script type="text/javascript">
    
    $("#filter_view").click(function(){
        $("#filter-form input[name='action']").val('view');
        $("#filter-form").submit();

    });

    var submit_filter_download = function(){
        $("#filter-form input[name='action']").val('download');
        $("#filter-form").submit();
    }

    $("#btn_import").click(function(){

        if($("input[type='file']").val() == "")
        {
            bootbox.alert('File harus dipilih');

            return false;
        }

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

<script type="text/javascript">
    $("#calculate").click(function(){
        
        bootbox.confirm('Calculate Payroll ?', function(res){

            bootbox.dialog({closeButton: false, message: '<div class="text-center"><h4><i class="fa fa-spin fa-spinner"></i> Please Wait, Calculate Payroll...</h4></div>' })

            setTimeout(function(){
                window.location = '{{ route('administrator.payrollgross.calculate') }}';
            }, 2000);
        });

    });

    $( "#from, #to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            if(this.id == 'from'){
              var dateMin = $('#from').datepicker("getDate");
              var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate()); // Min Date = Selected + 1d
              var rMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 31); // Max Date = Selected + 31d
              $('#to').datepicker("option","minDate",rMin);
              $('#to').datepicker("option","maxDate",rMax);                    
            }
        }
    });
</script>
@endsection
@endsection
