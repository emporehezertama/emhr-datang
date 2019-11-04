@extends('layouts.administrator')

@section('title', 'Payroll')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title" style="overflow: inherit; ">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <h4 class="page-title pull-left m-r-10">Payroll</h4>
                <form method="POST" action="{{ route('administrator.payroll.index') }}" id="filter-form" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="reset" value="0">
                    <div class="pull-right" style="padding-left:0;">
                        <button type="button" id="filter_view" class="btn btn-default btn-sm btn-outline"> <i class="fa fa-search-plus"></i></button>
                        <div class="btn-group m-r-10">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-sm btn-info dropdown-toggle waves-effect waves-light" type="button">Action 
                                <i class="fa fa-gear"></i>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="javascript:void(0)" onclick="reset_filter()"> <i class="fa fa-refresh"></i> Reset Filter</a></li>
                                <li><a href="{{ route('administrator.payroll.create') }}"> <i class="fa fa-plus"></i> Create</a></li>
                                <li><a href="#" onclick="submit_filter_download()"><i class="fa fa-download"></i> Download</a></li>
                                <!--li><a href="#" onclick="submit_filter_bank_download()"><i class="fa fa-download"></i> Download Format Bank</a></li-->
                                <li><a href="javascript:void(0)" id="calculate"><i class="fa fa-refresh"></i> Calculate</a></li>
                                <li><a id="add-import-karyawan"> <i class="fa fa-file"></i> Import</a></li>
                                <li><a href="#" onclick="submit_bukti_potong()" title="Download Bukti Potong"><i class="fa fa-download"></i> Bukti Potong</a></li>
                                <li><a href="javascript:void(0)" onclick="submit_sendpayslip()" title="Send Payslip"><i class="fa fa-send-o"></i> Send Payslip</a></li>
                                <li><a href="javascript:void(0)" onclick="submit_lock()" title="Lock Payslip"><i class="fa fa-lock"></i> Lock Payslip</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-1 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="is_calculate">
                                <option value="">- Status -</option>
                                <option value="0" {{ (\Session::get('is_calculate') == '0') ? 'selected' : '' }}>No Calculated</option>
                                <option value="1" {{ (\Session::get('is_calculate') == '1') ? 'selected' : '' }}>Calculated</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="division_id">
                                <option value=""> - Division - </option>
                                @foreach($division as $item)
                                <option value="{{ $item->id }}" {{ $item->id== \Session::get('division_id') ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="position_id">
                                <option value=""> - Position - </option>
                                @foreach($position as $item)
                                <option value="{{ $item->id }}" {{ $item->id== \Session::get('position_id') ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="employee_status">
                                <option value="">- Employee Status - </option>
                                <option {{ (\Session::get('employee_status') == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                <option {{ (\Session::get('employee_status') == 'Contract') ? 'selected' : '' }}>Contract</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="month">
                                <option value="">- Month - </option>
                                @foreach(month_name() as $key => $item)
                                <option value="{{ $key }}" {{ (\Session::get('month') == $key) ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 pull-right" style="padding-left:0;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="year">
                                <option value="">- Year - </option>
                                @for($year=2018; $year <= ((Int)date('Y') + 5); $year++))
                                <option {{ (\Session::get('year') == $year) ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        <div class="form-group m-b-0">
                            <input type="text" class="form-control form-control-line" name="name" value="{{ \Session::get('name') }}" placeholder="Nik / Name">
                        </div>
                    </div>
                    <input type="hidden" name="action" value="view">
                    <div class="clearfix"></div>
                    <div id="filter-form-user"></div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
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
                            @php ($new=false)
                            @if(isset($data))   
                                @foreach($data as $no => $item)
                                    @if(isset($item->user))
                                        @if(\Session::get('month') and \Session::get('year'))
                                            @if( \Session::get('month') != (Int)date('m') || \Session::get('year') != date('Y'))
                                                @php($history = get_payroll_history($item->user_id, \Session::get('month'), \Session::get('year') ))
                                                @if($history)
                                                    @php($item = $history)
                                                    @php($item->is_calculate = 1)
                                                @endif
                                            @endif
                                        @endif
                                        <tr>
                                            <td><input type="checkbox" name="payroll_id[]" data-user_id="{{ $item->user_id }}" value="{{ $item->id }}"></td>
                                            <td>{{ $i }}</td>
                                            <td>{{ $item->user->nik }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ number_format($item->total_earnings) }}</td>
                                            <td>{{ number_format($item->total_deduction) }}</td>
                                            <td>{{ number_format($item->thp) }}</td>
                                            <td class="">
                                                @if(\Session::get('month') and \Session::get('year'))
                                                    @php($history_ = cek_payroll_user_id($item->user_id, \Session::get('month'), \Session::get('year') ))
                                                    @if(!$history_)
                                                        <label class="btn btn-warning btn-xs btn-circle" title="Not Calculate"><i class="fa fa-close"></i></label>
                                                    @elseif($history_)
                                                        <label class="btn btn-success btn-xs  btn-circle"  title="Calculated"><i class="fa fa-check"></i> </label>
                                                    @endif
                                                @else
                                                    @if($item->is_calculate == 0)
                                                        <label class="btn btn-warning btn-xs btn-circle" title="Not Calculate"><i class="fa fa-close"></i></label>
                                                    @else
                                                        <label class="btn btn-success btn-xs  btn-circle"  title="Calculated"><i class="fa fa-check"></i> </label>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(\Session::get('month') and \Session::get('year'))
                                                    @php($history = get_payroll_history($item->user_id, \Session::get('month'), \Session::get('year') ))
                                                    @if(\Session::get('month') == date('m') and \Session::get('year') == date('Y'))
                                                     <a href="{{ route('administrator.payroll.detail', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> detail</a>
                                                    @elseif(isset($history))
                                                     <a href="{{ route('administrator.payroll.detail-history', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> detail</a>
                                                    @endif
                                                @endif
                                                
                                                @if(\Session::get('month') and \Session::get('year'))
                                                    @php($history_ = cek_payroll_user_id($item->user_id, \Session::get('month'), \Session::get('year') ))
                                                    @if(!$history_)
                                                        <a href="{{ route('administrator.payroll.create-by-payroll-id', $item->id) }}?date={{ \Session::get('year') }}-{{ \Session::get('month') }}-01" class="btn btn-warning btn-xs"><i class="fa fa-plus"></i> Create Payroll </a>
                                                        @php($new = true)
                                                        @php($item->is_lock = 0)
                                                    @endif
                                                @endif
                                                
                                                @if($item->is_lock==1)
                                                    <a href="" class="pull-right text-danger" title="Lock Payroll" style="font-size: 25px;"><i class="fa fa-lock"></i></a> 
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

@section('footer-script')
<style type="text/css" media="screen">
    .ui-datepicker-year {
        width: 97% !important;
        height: 28px !important;
        border: 1px solid #e9e9e9;
    }
</style>
<script type="text/javascript">
    function submit_lock()
    {
        $("#filter-form input[name='action']").val('lock');

        $("#filter-form").submit();
    }
    
    function submit_sendpayslip()
    {
        $("#filter-form input[name='action']").val('submitpayslip');

        var count   = $("input[name='payroll_id[]']").filter(':checked');
        var html    = '';

        $(count).each(function(k,v){
            html += '<input type="hidden" name="user_id[]" value="'+ $(v).data('user_id') +'" />';

        });
        $('.section-user-id').html(html);
        $("#filter-form").submit();
    }

    function reset_filter()
    {
        $("#filter-form input.form-control, #filter-form select").val("");
        $("input[name='reset']").val(1);
        $("#filter-form").submit();
    }

    $('#dpYears').datepicker( {
        //yearRange: "c-100:c",
        changeMonth: false,
        changeYear: true,
        showButtonPanel: true,
        closeText:'Select',
        currentText: 'This year',
        onClose: function(dateText, inst) {
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).val($.datepicker.formatDate("yy", new Date(year, 0, 1)));
        },
        beforeShow: function(input, inst){
          if ($(this).val()!='')
          {
            var year = $(this).val();
            //$(this).datepicker('option','defaultDate', new Date(tmpyear, 0, 1));
            $(this).datepicker( {
                changeMonth: false,
                changeYear: true,
                showButtonPanel: true,
                closeText:'Select',
                currentText: 'This year',
                setDate: new Date(year, 0, 1)
            });
          }
        }
      }).focus(function () {
        $(".ui-datepicker-month").hide();
        $(".ui-datepicker-calendar").hide();
        $(".ui-datepicker-current").hide();
        $(".ui-datepicker-prev").hide();
        $(".ui-datepicker-next").hide();
        $("#ui-datepicker-div").position({
          my: "left top",
          at: "left bottom",
          of: $(this)
        });
      }).attr("readonly", false);

    var payroll_selected = 0;

    function submit_bukti_potong()
    {
        $("#filter-form input[name='action']").val('bukti-potong');

        $("#filter-form").submit();
        /*
        if(payroll_selected > 0)
        {
            $("#form_table_payroll").attr('target', '_blank')
            $("#form_table_payroll").submit();
        }
        else
        {
            _alert('Select payroll !');
        }
        */
    }

    $("input[name='check_all']").click(function () {    
        $('input:checkbox').prop('checked', this.checked);  
        check_button_payslip();
    });

    function check_button_payslip()
    {
        payroll_selected = $("input:checkbox").filter(':checked').length;
    }

    $('input:checkbox').click(function(){
        check_button_payslip();
    });

    $("#filter_view").click(function(){
        $("#filter-form input[name='action']").val('view');
        $("#filter-form").submit();

    });

    $("input[type='checkbox']").click(function(){
        var count   = $("input[name='payroll_id[]']").filter(':checked');
        var html    = '';

        $(count).each(function(k,v){
            html += '<input type="hidden" name="user_id[]" value="'+ $(v).data('user_id') +'" />';
            html += '<input type="hidden" name="payroll_id[]" value="'+ $(v).val() +'" />';
        });

        $("#filter-form-user").html(html); 
    });

    var submit_filter_download = function(){
        $("#filter-form input[name='action']").val('download');

        $("#filter-form").submit();
    }

    var submit_filter_bank_download = function(){
        $("#filter-form input[name='action']").val('downloadBank');

        $("#filter-form").submit();
    }


    $("#btn_import").click(function(){

        if($("input[type='file']").val() == "")
        {
            bootbox.alert('File can not be empty');
            return false;
        }

        $("#form-upload").submit();
        $("#form-upload").hide();
        $('.div-proses-upload').show();

    });

    $("#add-import-karyawan").click(function(){
        if($("select[type='year']").val() == ""){
            alert("a");
        }
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