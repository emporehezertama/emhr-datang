@extends('layouts.administrator')

@section('title', 'Payroll Karyawan')

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
                <h4 class="page-title">Form Payroll Karyawan</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Payroll Karyawan</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.payroll.update', $data->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Payroll Karyawan</h3>
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
                                   <input type="text" value="{{ $data->user->nik .' - '. $data->user->name }}" class="form-control autocomplete-karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Basic Salary</label>
                                <div class="col-md-6">
                                   <input type="text" name="basic_salary" value="{{ number_format($data->basic_salary) }}" class="form-control price_format" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Actual Salary</label>
                                <div class="col-md-6">
                                   <input type="text" name="salary" value="{{ $data->salary }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Call Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="call_allow" value="{{ $data->call_allow }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Yearly Bonus, THR or others     </label>
                                <div class="col-md-6">
                                   <input type="text" name="bonus" value="{{ $data->bonus }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Transport Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="transport_allowance"  value="{{ number_format($data->transport_allowance) }}" class="form-control  price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Homebase Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="homebase_allowance" value="{{ $data->homebase_allowance }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Laptop Allowance</label>
                                <div class="col-md-6">
                                   <input type="text" name="laptop_allowance" value="{{ $data->laptop_allowance }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">OT Normal Hours</label>
                                <div class="col-md-6">
                                   <input type="text" name="ot_normal_hours" value="{{ $data->ot_normal_hours }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">OT Multiple Hours</label>
                                <div class="col-md-6">
                                   <input type="number" name="ot_multiple_hours" value="{{ $data->ot_multiple_hours }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Other Income</label>
                                <div class="col-md-6">
                                   <input type="text" name="other_income" value="{{ $data->other_income }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Remark Other Income</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark_other_income" value="{{ $data->remark_other_income }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Medical Claim</label>
                                <div class="col-md-6">
                                   <input  type="text" name="medical_claim" value="{{ $data->medical_claim }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Overtime Claim</label>
                                <div class="col-md-6">
                                   <input type="text" name="overtime_claim" readonly="true" value="{{ number_format($data->ot_multiple_hours / 173 * $data->salary) }}" class="form-control overtime_claim">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Remark</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark" value="{{ $data->remark }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Other Deduction</label>
                                <div class="col-md-6">
                                   <input  type="text" name="other_deduction" value="{{ $data->other_deduction }}" class="form-control price_format">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Remark Other Deduction</label>
                                <div class="col-md-6">
                                   <input type="text" name="remark_other_deduction" value="{{ $data->remark_other_deduction }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Gross Income Per Year </label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="gross_income" value="{{ number_format($data->gross_income) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Burden Allowance (Monthly)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="burden_allow" value="{{ number_format($data->burden_allow) }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label class="col-md-3">BPJS Ketengakerjaan 4.24%</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_ketenagakerjaan" value="{{ number_format($data->bpjs_ketenagakerjaan) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Kesehatan (4%)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_kesehatan" value="{{ number_format($data->bpjs_kesehatan) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Pensiun 2%</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_pensiun" value="{{ number_format($data->bpjs_pensiun) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Ketengakerjaan 2%</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_ketenagakerjaan2" value="{{ number_format($data->bpjs_ketenagakerjaan2) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Kesehatan (1%)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_kesehatan2" value="{{ number_format($data->bpjs_kesehatan2) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">BPJS Pensiun 1%</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="bpjs_pensiun2" value="{{ number_format($data->bpjs_pensiun2) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Total Deduction ( Burden + BPJS )</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="total_deduction" value="{{ number_format($data->total_deduction) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">NET Yearly Income  ( 2 - 5 )    </label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="net_yearly_income" value="{{ number_format($data->net_yearly_income) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Untaxable Income </label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="untaxable_income" value="{{ number_format($data->untaxable_income) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Taxable Yearly Income  ( 6 - 7)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="taxable_yearly_income" value="{{ number_format($data->taxable_yearly_income) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">5%    ( 0-50 million)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="income_tax_calculation_5" value="{{ number_format($data->income_tax_calculation_5) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">15%  ( 50 - 250 million)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="income_tax_calculation_15" value="{{ number_format($data->income_tax_calculation_15) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">25%  ( 250-500 million)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="income_tax_calculation_25" value="{{ number_format($data->income_tax_calculation_25) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">30%  ( > 500 million)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="income_tax_calculation_30" value="{{ number_format($data->income_tax_calculation_30) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Yearly Income Tax</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="yearly_income_tax" value="{{ number_format($data->yearly_income_tax) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Monthly Income Tax / PPh21 </label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="monthly_income_tax" value="{{ number_format($data->monthly_income_tax) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">GROSS INCOME PER MONTH</label>
                                <div class="col-md-6">
                                   <input type="text" name="gross_income_per_month" readonly="true" value="{{ number_format($data->gross_income_per_month) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Less : Tax, BPJS (Monthly)</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="less" value="{{ number_format($data->less) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Take Home Pay</label>
                                <div class="col-md-6">
                                   <input type="text" readonly="true" name="thp" value="{{ number_format($data->thp) }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{ $data->user_id }}" name="user_id">
                         
                        <div class="clearfix"></div>
                        <br />
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('administrator.payroll.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save </button>
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
<script type="text/javascript">

    $("input[name='salary'], input[name='call_allow'], input[name='bonus'], input[name='ot_multiple_hours'],input[name='homebase_allowance'],input[name='laptop_allowance'],input[name='other_income'],input[name='medical_claim'], input[name='other_deduction'],input[name='transport_allowance']").on('input', function(){
        calculate();
    });

    function calculate()
    {
        var salary      = $("input[name='salary']").val();
        var call_allow  = $("input[name='call_allow']").val();
        var bonus       = $("input[name='bonus']").val();
        var ot_multiple_hours   = $("input[name='ot_multiple_hours']").val();
        var homebase_allowance  = $("input[name='homebase_allowance']").val();
        var laptop_allowance    = $("input[name='laptop_allowance']").val();
        var other_income        = $("input[name='other_income']").val();
        var medical_claim       = $("input[name='medical_claim']").val();
        var marital_status = '{{ $data->user->marital_status }}';
        var transport_allowance  = $("input[name='transport_allowance']").val();
        var other_deduction  = $("input[name='other_deduction']").val();

        salary =  salary.replace(',','');
        salary =  salary.replace(',','');
        call_allow =  call_allow.replace(',','');
        call_allow =  call_allow.replace(',','');
        bonus =  bonus.replace(',','');
        bonus =  bonus.replace(',','');
        ot_multiple_hours =  ot_multiple_hours.replace(',','');
        ot_multiple_hours =  ot_multiple_hours.replace(',','');
        homebase_allowance =  homebase_allowance.replace(',','');
        homebase_allowance =  homebase_allowance.replace(',','');
        laptop_allowance =  laptop_allowance.replace(',','');
        laptop_allowance =  laptop_allowance.replace(',','');
        other_income =  other_income.replace(',','');
        other_income =  other_income.replace(',','');
        medical_claim =  medical_claim.replace(',','');
        medical_claim =  medical_claim.replace(',','');
        transport_allowance = transport_allowance.replace(',','');
        transport_allowance = transport_allowance.replace(',','');
        other_deduction = other_deduction.replace(',','');
        other_deduction = other_deduction.replace(',','');
        

        $.ajax({
            url: "{{ route('ajax.get-calculate-payroll') }}",
            method : 'POST',
            data: {
                'salary': salary.replace(',',''), 'call_allow' : call_allow.replace(',',''), 'marital_status' : marital_status.replace(',',''), 'bonus': bonus.replace(',',''),
                'ot_multiple_hours' : ot_multiple_hours.replace(',',''),
                 '_token' : $("meta[name='csrf-token']").attr('content'),
                 'homebase_allowance' : homebase_allowance.replace(',',''),
                 'laptop_allowance' : laptop_allowance.replace(',',''),
                 'other_income' : other_income.replace(',',''),
                 'medical_claim' : medical_claim.replace(',',''),
                 'other_deduction' : other_deduction.replace(',',''),
                 'transport_allowance' : transport_allowance
            },
            success: function( data ) {
                console.log(data);
                $("input[name='gross_income_per_month']").val(data.gross_income_per_month);
                $("input[name='burden_allow']").val(data.burden_allow);
                $("input[name='gross_income']").val(data.gross_income);
                $("input[name='income_tax_calculation_5']").val(data.income_tax_calculation_5);
                $("input[name='income_tax_calculation_15']").val(data.income_tax_calculation_15);
                $("input[name='income_tax_calculation_25']").val(data.income_tax_calculation_25);
                $("input[name='income_tax_calculation_30']").val(data.income_tax_calculation_30);
               // $("input[name='jamsostek_result']").val(data.jamsostek_result);
                $("input[name='bpjs_ketenagakerjaan']").val(data.bpjs_ketenagakerjaan);
                $("input[name='bpjs_ketenagakerjaan2']").val(data.bpjs_ketenagakerjaan2);
                $("input[name='bpjs_kesehatan']").val(data.bpjs_kesehatan);
                $("input[name='bpjs_kesehatan2']").val(data.bpjs_kesehatan2);
                $("input[name='bpjs_pensiun']").val(data.bpjs_pensiun);
                $("input[name='bpjs_pensiun2']").val(data.bpjs_pensiun2);
               // $("input[name='jkk_result']").val(data.jkk_result);
                $("input[name='less']").val(data.less);
                $("input[name='monthly_income_tax']").val(data.monthly_income_tax);
                $("input[name='net_yearly_income']").val(data.net_yearly_income);
                $("input[name='taxable_yearly_income']").val(data.taxable_yearly_income);
                $("input[name='thp']").val(data.thp);
                $("input[name='total_deduction']").val(data.total_deduction);
                $("input[name='untaxable_income']").val(data.untaxable_income);
                $("input[name='yearly_income_tax']").val(data.yearly_income_tax);
                $("input[name='overtime_claim']").val(data.overtime_claim);
            }
        });
    }
</script>
@endsection

<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
