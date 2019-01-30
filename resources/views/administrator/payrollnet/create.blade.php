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
                <h4 class="page-title">Form Employee Payroll</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Payroll</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.payrollnet.store') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Payroll</h3>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3">NIK / Name</label>
                                <div class="col-md-6">
                                   <input type="text" value="" class="form-control autocomplete-karyawan">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-3">Basic Salary</label>
                                <div class="col-md-6">
                                   <input type="text" name="basic_salary" value="" class="form-control price_format" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Actual Salary</label>
                                <div class="col-md-6">
                                   <input type="text" name="salary" value="" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Call Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="call_allowance" value="" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Transport Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="transport_allowance" value="" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Meal Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="meal_allow" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Homebase Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="homebase_allowance" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Laptop Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="laptop_allowance" value="0" class="form-control price_format">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-3">Overtime Normal Hours</label>
                                <div class="col-md-6">
                                   <input type="number" step="0.01" name="ot_normal_hours" value="0" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Nominal Overtime</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="overtime" value="0" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Bonus</label>
                                <div class="col-md-6">
                                   <input type="text" name="bonus" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Medical</label>
                                <div class="col-md-6">
                                   <input type="text" name="medical_claim" value="0" class="form-control price_format">
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-md-3">Remark Medical</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark_medical" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Other Income 1</label>
                                <div class="col-md-6">
                                   <input type="text" name="other_income" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Remark Other Income1</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark_other_income" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Other Income 2</label>
                                <div class="col-md-6">
                                   <input type="text" name="other_income2" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Remark Other Income2</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark_other_income2" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Total Income</label>
                                <div class="col-md-6">
                                   <input type="text" name="total_income" readonly="true" value="0" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3">Deduction 1</label>
                                <div class="col-md-6">
                                   <input type="text" name="deduction1" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Remark Deduction1</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark_deduction1" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Deduction 2</label>
                                <div class="col-md-6">
                                   <input type="text" name="deduction2" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Remark Deduction2</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark_deduction2" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Deduction 3</label>
                                <div class="col-md-6">
                                   <input type="text" name="deduction3" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Remark Deduction3</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark_deduction3" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Total Deduction </label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="total_deduction" value="0" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Ketengakerjaan 4.24%</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_ketenagakerjaan" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Kesehatan (4%)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_kesehatan" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Pensiun 2%</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_pensiun" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Ketengakerjaan 2%</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_ketenagakerjaan2" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Kesehatan (1%)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_kesehatan2" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Pensiun 1%</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_pensiun2" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Yearly Income Tax</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="yearly_income_tax" value="0"  class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Monthly Income Tax / PPh21</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="monthly_income_tax" value="0"  class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Take Home Pay</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="thp" value="0"  class="form-control price_format">
                                </div>
                            </div>
                            
                        </div>
                        <input type="hidden" name="user_id">
                         
                        <div class="clearfix"></div>
                        <br />
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('administrator.payrollnet.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save Payroll </button>
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
    @extends('layouts.footer')
</div>
@section('footer-script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
    $("input[name='basic_salary'],input[name='salary'],input[name='call_allowance'],input[name='transport_allowance'], input[name='meal_allow'],input[name='homebase_allowance'],input[name='laptop_allowance'],input[name='ot_normal_hours'],input[name='bonus'],input[name='medical_claim'], input[name='other_income'],input[name='other_income2'],input[name='deduction1'],input[name='deduction2'],input[name='deduction3']").on('input', function(){
        calculate();
    });

    function calculate()
    {
        var basic_salary        = $("input[name='basic_salary']").val().replace(',','');
        var salary              = $("input[name='salary']").val().replace(',','');
        var call_allowance      = $("input[name='call_allowance']").val().replace(',','');
        var transport_allowance = $("input[name='transport_allowance']").val().replace(',','');
        var meal_allow          = $("input[name='meal_allow']").val();
        var homebase_allowance  = $("input[name='homebase_allowance']").val().replace(',','');
        var laptop_allowance    = $("input[name='laptop_allowance']").val().replace(',','');
        var ot_normal_hours     = $("input[name='ot_normal_hours']").val().replace(',','');
        var bonus               = $("input[name='bonus']").val().replace(',','');
        var medical_claim       = $("input[name='medical_claim']").val().replace(',','');
        var other_income        = $("input[name='other_income']").val().replace(',','');
        var other_income2       = $("input[name='other_income2']").val().replace(',','');
        var deduction1          = $("input[name='deduction1']").val().replace(',','');
        var deduction2          = $("input[name='deduction2']").val().replace(',','');
        var deduction3          = $("input[name='deduction3']").val().replace(',','');

        basic_salary =  basic_salary.replace(',','');
        basic_salary =  basic_salary.replace(',','');
        salary =  salary.replace(',','');
        salary =  salary.replace(',','');
        call_allowance = call_allowance.replace(',','');
        call_allowance = call_allowance.replace(',','');
        transport_allowance = transport_allowance.replace(',','');
        transport_allowance = transport_allowance.replace(',','');
        meal_allow =  meal_allow.replace(',','');
        meal_allow =  meal_allow.replace(',','');
        homebase_allowance =  homebase_allowance.replace(',','');
        homebase_allowance =  homebase_allowance.replace(',','');
        laptop_allowance =  laptop_allowance.replace(',','');
        laptop_allowance =  laptop_allowance.replace(',','');
        ot_normal_hours =  ot_normal_hours.replace(',','');
        ot_normal_hours =  ot_normal_hours.replace(',','');
        bonus =  bonus.replace(',','');
        bonus =  bonus.replace(',','');
        medical_claim =  medical_claim.replace(',','');
        medical_claim =  medical_claim.replace(',','');
        other_income =  other_income.replace(',','');
        other_income =  other_income.replace(',','');
        other_income2 =  other_income2.replace(',','');
        other_income2 =  other_income2.replace(',','');
        deduction1 =  deduction1.replace(',','');
        deduction1 =  deduction1.replace(',','');
        deduction2 =  deduction2.replace(',','');
        deduction2 =  deduction2.replace(',','');
        deduction3 =  deduction3.replace(',','');
        deduction3 =  deduction3.replace(',','');

        $.ajax({
            url: "{{ route('ajax.get-calculate-payrollnet') }}",
            method : 'POST',
            data: {
                'basic_salary':basic_salary,'salary': salary,'call_allowance' : call_allowance,
                 'transport_allowance' : transport_allowance,'meal_allow' : meal_allow, 'homebase_allowance' : homebase_allowance, 'laptop_allowance' : laptop_allowance, 'ot_normal_hours': ot_normal_hours,'bonus' : bonus, '_token' : $("meta[name='csrf-token']").attr('content'),'medical_claim' : medical_claim,
                 'other_income' : other_income, 'other_income2' : other_income2, 'deduction1' : deduction1, 'deduction2' : deduction2, 'deduction3' : deduction3
            },
            success: function( data ) {
                //console.log(data);
                $("input[name='overtime']").val(data.overtime);
                $("input[name='total_income']").val(data.total_income);
                $("input[name='total_deduction']").val(data.total_deduction);
                $("input[name='thp']").val(data.thp);
                $("input[name='yearly_income_tax']").val(data.yearly_income_tax);
                $("input[name='monthly_income_tax']").val(data.monthly_income_tax);
                $("input[name='bpjs_ketenagakerjaan']").val(data.bpjs_ketenagakerjaan);
                $("input[name='bpjs_ketenagakerjaan2']").val(data.bpjs_ketenagakerjaan2);
                $("input[name='bpjs_kesehatan']").val(data.bpjs_kesehatan);
                $("input[name='bpjs_kesehatan2']").val(data.bpjs_kesehatan2);
                $("input[name='bpjs_pensiun']").val(data.bpjs_pensiun);
                $("input[name='bpjs_pensiun2']").val(data.bpjs_pensiun2);
                               
            }
        });
    }

    $(".autocomplete-karyawan" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan-payrollnet') }}",
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
            $("input[name='user_id']").val(ui.item.id);

             $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-karyawan-by-id') }}',
                data: {'id' : ui.item.id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    marital_status = data.data.marital_status;
                }
            });
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
