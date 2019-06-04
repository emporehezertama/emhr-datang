@extends('layouts.administrator')

@section('title', 'Payroll')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title" style="overflow: inherit; ">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <h4 class="page-title pull-left m-r-10">Payroll</h4>
                <form method="POST" action="{{ route('administrator.payroll.index') }}" id="filter-form">
                    {{ csrf_field() }}
                    <div class="pull-right" style="padding-left:0;">
                        <button type="button" id="filter_view" class="btn btn-default btn-sm btn-outline"> <i class="fa fa-search-plus"></i></button>
                        <div class="btn-group m-r-10">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-sm btn-info dropdown-toggle waves-effect waves-light" type="button">Action 
                                <i class="fa fa-gear"></i>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="{{ route('administrator.payroll.create') }}"> <i class="fa fa-plus"></i> Create</a></li>
                                <li><a href="#" onclick="submit_filter_download()"><i class="fa fa-download"></i> Download</a></li>
                                <li><a href="#" onclick="submit_bukti_potong()"><i class="fa fa-download"></i> Bukti Potong</a></li>
                                <li><a href="javascript:void(0)" id="calculate"><i class="fa fa-refresh"></i> Calculate</a></li>
                                <li><a id="add-import-karyawan"> <i class="fa fa-file"></i> Import</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-1 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="is_calculate">
                                <option value="">- Status -</option>
                                <option value="0" {{ (request() and request()->is_calculate == '0') ? 'selected' : '' }}>No Calculated</option>
                                <option value="1" {{ (request() and request()->is_calculate == '1') ? 'selected' : '' }}>Calculated</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="jabatan">
                                <option value="">- Position - </option>
                                <option {{ (request() and request()->jabatan == 'Staff') ? 'selected' : '' }}>Staff</option>
                                <option {{ (request() and request()->jabatan == 'Manager') ? 'selected' : '' }}>Manager</option>
                                <option {{ (request() and request()->jabatan == 'Direktur') ? 'selected' : '' }}>Director</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="employee_status">
                                <option value="">- Employee Status - </option>
                                <option {{ (request() and request()->employee_status == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                <option {{ (request() and request()->employee_status == 'Contract') ? 'selected' : '' }}>Contract</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="month">
                                <option value="">- Month - </option>
                                @foreach(month_name() as $key => $item)
                                <option value="{{ $key }}" {{ (request() and request()->month == $key) ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        <div class="form-group m-b-0">
                            <input type="text" class="form-control  form-control-line" name="name" value="{{ isset(request()->name) ? request()->name : '' }}" placeholder="Nik / Name">
                        </div>
                    </div>
                    <input type="hidden" name="action" value="view">
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                 <div class="section-btn-send-payslip" style="display: none;">
                    <button type="button" class="btn btn-info btn-xs" onclick="send_payslip()"><i class="fa fa-send-o"></i> Send Payslip</button>
                 </div>
                 <form method="POST" id="form_table_payroll" action="{{ route('administrator.payroll.index') }}">
                    <input type="hidden" name="action" value="bukti-potong">
                    {{ csrf_field() }}
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10" style="text-align: left;padding-left:9px;"><input type="checkbox" title="Check All" name="check_all" /></th>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>EARNINGS</th>
                                    <th>DEDUCTIONS</th>
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
                                            <td><input type="checkbox" name="payroll_id[]" data-user_id="{{ $item->user_id }}" value="{{ $item->id }}"></td>
			                                <td>{{ $i }}</td>
                                            <td>{{ $item->user->nik }}</td>
			                                <td>{{ $item->user->name }}</td>
                                            <td>{{ number_format($item->total_earnings) }}</td>
			                                <td>{{ number_format($item->total_deduction) }}</td>
			                                <td>{{ number_format($item->thp) }}</td>
			                                <td>
			                                    @if($item->is_calculate == 0)
			                                        <label class="btn btn-warning btn-xs btn-circle" title="Not Calculate"><i class="fa fa-close"></i></label>
			                                    @else
			                                        <label class="btn btn-success btn-xs  btn-circle"  title="Calculated"><i class="fa fa-check"></i> </label>
			                                    @endif
			                                </td>
			                                <td>
                                                @if(!isset(request()->month))
			                                     <a href="{{ route('administrator.payroll.detail', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> detail</a>
			                                    @endif
                                            </td>
			                            </tr>
			                            @php ($i ++)
			                        @endIf
	                            @endforeach
	                        @endIf
                            </tbody>
                        </table>
                    </div>
                  </form>
                </div>
            </div> 
        </div>
    </div>
    @include('layouts.footer')
</div>

<!-- modal content education  -->
<div id="modal_import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Import Data</h4> </div>
                    <form method="POST" id="form-upload" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('administrator.payroll.temp-import') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">File (xls)</label>
                            <div class="col-md-9">
                                <input type="file" name="file" class="form-control" />
                            </div>
                        </div>
                        <a href="{{ route('administrator.payroll.download') }}"><i class="fa fa-download"></i> Download Sample Excel</a>
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


<!-- modal send pay slip  -->
<div id="modal_send_pay_slip" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Send Pay Slip</h4> </div>
            <form method="POST" class="form-horizontal form_send_payslip" action="{{ route('administrator.payroll.index') }}">
                {{ csrf_field() }}
                <input type="hidden" name="action" value="send-pay-slip">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-6">Year</label>
                        <label class="col-md-6">Month</label>
                        <div class="col-md-6">
                            <select class="form-control modal-select-year" required name="tahun">
                                <option value="">- Select -</option>
                            </select>
                        </div>
                        <div class="col-md-6 modal-select-month"></div>
                        <div class="section-user-id"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info btn-sm" onclick="submit_payslip()"><i class="fa fa-send-o"></i> Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('footer-script')
<script type="text/javascript">

    var send_payslip = function(){
       $("#modal_send_pay_slip").modal("show");

       $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-year-pay-slip-all') }}',
            data: {'_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                var el = '<option value="">- Select -</option>';
                    
                $.each(data.result, function(k,v){
                    el += '<option value="'+ v.tahun +'">'+ v.tahun +'</option>';
                });              

                $("#modal_send_pay_slip .modal-select-year").html(el);
            }
        }); 

        var count   = $("input[name='payroll_id[]']").filter(':checked');
        var html    = '';

        $(count).each(function(k,v){
            html += '<input type="hidden" name="user_id[]" value="'+ $(v).data('user_id') +'" />';

        });

        $('.section-user-id').html(html);
    }


    function submit_payslip()
    {
        var year    = $('.modal-select-year').val();
        var bulan   = $("input[name='bulan[]']").filter(':checked').length;

        if(year == "" || bulan <= 0)
        {
            _alert('Year / Month required.');
            return false;
        }

        _confirm_submit('Send payslip ?', $('form.form_send_payslip'));
    }

    $("#modal_send_pay_slip .modal-select-year").on('change', function(){

       var tahun = $(this).val();

        if($(this).val() != "")
        {
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-bulan-pay-slip-all') }}',
                data: {'tahun': tahun, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    var el = '';

                    $.each(data, function(k, v){
                        el += '<label><input type="checkbox" value="'+ v.id +'" name="bulan[]" /> '+ v.name +'</label> &nbsp; ';

                    });

                    $('#modal_send_pay_slip .modal-select-month').html(el);
                }
            });
        }
    });

    
    function submit_bukti_potong()
    {
        $("#form_table_payroll").submit();
    }

    $("input[name='check_all']").click(function () {    
        $('input:checkbox').prop('checked', this.checked);  

        check_button_payslip();
    });

    function check_button_payslip()
    {
        var count = $("input:checkbox").filter(':checked').length; 

        if(count > 0)
        {
            $('.section-btn-send-payslip').show();
        }
        else
        {   
            $('.section-btn-send-payslip').hide();
        }
    }

    $('input:checkbox').click(function(){
        check_button_payslip();
    });

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
                window.location = '{{ route('administrator.payroll.calculate') }}';
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