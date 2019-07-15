@extends('layouts.administrator')

@section('title', 'Business Trip')

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
                <h4 class="page-title"></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Business Trip</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" id="form-actual-bill" enctype="multipart/form-data" action="{{ route('administrator.training-custom.prosesclaim') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Form Actual Bill</h3>
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

                        <?php 
                        
                        $readonly = ''; 
                        if($data->status_actual_bill >= 2)
                        {
                            $readonly = ' readonly="true"'; 
                        }

                        ?>
                        <div class="table-responsive">
                            <table class="table data_table display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="5">1. Acomodation & Transportation </th>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <th>Nominal</th>
                                        <th>Nominal Approved</th>
                                        <th>Note</th>
                                        <th>Receipt Transaction</th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-acomodation">
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th>Sub Total</th>
                                    <th class="sub_total_1">{{ number_format($data->sub_total_1) }}</th>
                                    <th colspan="3">{{ number_format($data->sub_total_1_disetujui) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <a class="btn btn-info btn-xs pull-right" id="addAcomodation"><i class="fa fa-plus"></i> Add</a>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <div class="table-responsive">
                            <table class="table data_table display nowrap" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr>
                                    <th colspan="12">2. Daily & Meal Allowance </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align: center;">Morning</th>
                                        <th colspan="2" style="text-align: center;">Afternoon</th>
                                        <th colspan="2" style="text-align: center;">Evening</th>
                                        <th colspan="4"></th>
                                    </tr>

                                    <tr>
                                        <th>Date</th>
                                        <th>Plafond Meal Allowance</th>
                                        <th>Claim</th>
                                        <th>Approved</th>
                                        <th>Claim</th>
                                        <th>Approved</th>
                                        <th>Claim</th>
                                        <th>Approved</th>
                                        <th>Plafond Daily Allowance</th>
                                        <th>Daily Allowance</th>
                                        <th>Nominal Approved</th>
                                        <th>Receipt Transaction</th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-allowance">
                                </tbody>
                                <tfoot>
                                    <tr hidden="true"> 
                                        <th colspan="2"> Sub Total</th>
                                        <th class="totalMorning"> 0</th>
                                        <th class="totalMorningApproved"> 0</th>
                                        <th class="totalAfternoon"> 0</th>
                                        <th class="totalAfternoonApproved"> 0</th>
                                        <th class="totalEvening"> 0</th>
                                        <th colspan="2" class="totalEveningApproved"> 0</th>
                                        <th class="totalDaily"> 0</th>
                                        <th class="totalDailyApproved"> 0</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"> Sub Total Claim</th>
                                        <th colspan="10" class="sub_total_2">{{ number_format($data->sub_total_2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"> Sub Total Approve</th>
                                        <th colspan="10" >{{ number_format($data->sub_total_2_disetujui) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <a class="btn btn-info btn-xs pull-right" id="addAllowance"><i class="fa fa-plus"></i> Add</a>
                        </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table data_table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th colspan="5">3. Other's  </th>
                                </tr>
                                <tr>
                                    <th>Description </th>
                                    <th>Nominal </th>
                                    <th>Nominal Approved </th>
                                    <th>Note </th>
                                    <th>Receipt Transaction </th>
                                </tr>
                            </thead>
                            <tbody class="table-content-other">
                                <tfoot>
                                    <tr>
                                    <th>Sub Total</th>
                                    <th class="sub_total_3">{{ number_format($data->sub_total_3) }}</th>
                                    <th colspan="3">{{ number_format($data->sub_total_3_disetujui) }}</th>
                                    </tr>
                                </tfoot>
                            </tbody>
                        </table>
                        <a class="btn btn-info btn-xs pull-right" id="addOther"><i class="fa fa-plus"></i> Add</a>
                    </div>
                    <div class="clearfix"></div>
                    <br />

                        <div class="col-md-6 table-total" style="padding-left:0;">
                            <table class="table table-hover">
                                <tr>
                                    <th>Total Actual Bill</th>
                                    <th class="total_actual_bill">
                                        IDR {{ number_format($data->sub_total_1 + $data->sub_total_2 + $data->sub_total_3) }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Cash Advance</th>
                                    <th>IDR {{ number_format($data->pengambilan_uang_muka) }}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 table-total" style="padding-right:0;">
                            <table class="table table-hover">
                                <tr>
                                    <th>Total Actual Bill Approved</th>
                                    <th class="total_actual_bill_disetujui">
                                         IDR {{ number_format($data->sub_total_1_disetujui + $data->sub_total_2_disetujui + $data->sub_total_3_disetujui) }}
                                    </th>
                                </tr>
                                <tr>
                                    @php( $total_reimbursement_disetujui = $data->sub_total_1_disetujui + $data->sub_total_2_disetujui + $data->sub_total_3_disetujui - $data->pengambilan_uang_muka )
                                    @if($total_reimbursement_disetujui < 0)
                                    <th>Total Pengembalian </th>
                                    @php ($total_reimbursement_disetujui = abs($total_reimbursement_disetujui))
                                    @else
                                    <th>Total Reimbursement Approved </th>
                                    @endif
                                    <th class="total_reimbursement_disetujui">
                                        IDR {{ number_format($total_reimbursement_disetujui) }}
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <table class="table table-hover">
                            <tr>
                                <th>
                                    Note
                                    <textarea class="form-control" name="noted_bill"  {{ $readonly }} >{{ $data->noted_bill }}</textarea>
                                </th>
                            </tr>
                        </table>
                        <div class="clearfix"></div>
                        <hr style="margin-top:0;" />
                    
                    <input type="hidden" name="id" value="{{ $data->id }}" />
                    <input type="hidden" name="status_actual_bill" value="1">
                    <input type="hidden" name="sub_total_1" value="{{ $data->sub_total_1 }}" />
                    <input type="hidden" name="sub_total_2" value="{{ $data->sub_total_2 }}" />
                    <input type="hidden" name="sub_total_3" value="{{ $data->sub_total_3 }}" />


                    <div class="col-md-12" style="padding-left: 0;">
                        <a href="{{ route('administrator.training-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        @if($data->status_actual_bill ==1 or $data->status_actual_bill =="")
                        <button type="submit" class="btn btn-sm btn-warning waves-effect waves-light m-r-10" id="save-as-draft-form"><i class="fa fa-save"></i> Save as Draft</button>

                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="submit-form"><i class="fa fa-save"></i> Submit Actual Bill</a>
                        @endif
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
@extends('layouts.footer')
</div>
<style type="text/css">
    .custome_table tr th {
        padding-top: 5px !important;
        padding-bottom: 5px !important;
    }
    .table-total table tr th {
        font-size: 14px !important; 
        background-color: #eee !important;
    }
    /*
    table.dataTable thead th, table.dataTable thead td
    {
        border-bottom: 0 !important;
    }
    table.dataTable tfoot th, table.dataTable tfoot td
    {
        border-bottom: 0 !important;
        border-top: 0 !important;
    }
    */
</style>
@section('footer-script')

<script type="text/javascript">

var general_el;
var validate_form = false;

show_hide_addAcomodation();
cek_button_addAcomodation();
show_hide_addAllowance();
cek_button_addAllowance();
show_hide_addOther();
cek_button_addOther();

//acomodation 
function show_hide_addAcomodation()
{       
    validate_form = true;
    
    $('.input').each(function(){
     
        if($(this).val() == "")
        {
            validate_form = false;
        }
    });
}

function cek_button_addAcomodation()
{
    $('.input').each(function(){
        $(this).on('keyup',function(){
            show_hide_addAcomodation();
        })
        $(this).on('change',function(){
            show_hide_addAcomodation();
        })
    });
}
function delete_itemAcomodation(el)
{
    if(confirm('Delete this data?'))
    {
        $(el).parent().parent().hide(function(){
            $(el).parent().parent().remove();
            setTimeout(function(){
                show_hide_addAcomodation();
                cek_button_addAcomodation();
                calculate_nominalAcomodation();
                calculate_all();
            });
        }); 
    }
}

//allowance
function show_hide_addAllowance()
{       
    validate_form = true;
    
    $('.input').each(function(){
     
        if($(this).val() == "")
        {
            validate_form = false;
        }
    });
}

function cek_button_addAllowance()
{
    $('.input').each(function(){
        $(this).on('keyup',function(){
            show_hide_addAllowance();
        })
        $(this).on('change',function(){
            show_hide_addAllowance();
        })
    });
}
function delete_itemAllowance(el)
{
    if(confirm('Delete this data?'))
    {
        $(el).parent().parent().hide("slow", function(){
            $(el).parent().parent().remove();
            setTimeout(function(){
                show_hide_addAllowance();
                cek_button_addAllowance();
                calculate_nominalMorning();
                calculate_nominalAfternoon();
                calculate_nominalEvening();
                calculate_allAllowance();
                calculate_all();                
            });
        }); 
    }
}
//Other
function show_hide_addOther()
{       
    validate_form = true;
    $('.input').each(function(){
        if($(this).val() == "")
        {
            validate_form = false;
        }
    });
}

function cek_button_addOther()
{
    $('.input').each(function(){
        $(this).on('keyup',function(){
            show_hide_addOther();
        })
        $(this).on('change',function(){
            show_hide_addOther();
        })
    });
}
function delete_itemOther(el)
{
    if(confirm('Delete this data?'))
    {
        $(el).parent().parent().hide("slow", function(){
            $(el).parent().parent().remove();
            setTimeout(function(){
                show_hide_addOther();
                cek_button_addOther();
                calculate_nominalOther();
                calculate_all();
            });
        }); 
    }
}

var calculate_nominalAcomodation  = function(){
    var totalnominalAcomodation = 0;
        $('.nominalAcomodation').each(function(){
            if($(this).val() != ""){
                    totalnominalAcomodation += parseInt($(this).val());
                }
        });
    $('.sub_total_1').html(numberWithComma(totalnominalAcomodation));
    $("input[name='sub_total_1']").val(totalnominalAcomodation);
}

$("#addAcomodation").click(function(){
    var no = $('.table-content-acomodation tr').length;
    var html = '<tr>';
        html += '<td><select class="form-control training_transportation_type_id" \name="training_transportation_type_id[]">\
                                        <option value=""> - choose - </option>\
                                        @foreach($transportationtype as $item)\
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>\
                                        @endforeach\
                                </select></td>';
        html += '<td><input type="text" class="form-control nominalAcomodation" name="nominalAcomodation[]"></td>';
        html += '<td><input type="text" name="nominalAcomodation_approved[]"  class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" name="noteAcomodation[]" class="form-control noteAcomodation"></td>';
        html += '<td><input type="file" name="file_strukAcomodation[]" class="form-control input"></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_itemAcomodation(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-acomodation').append(html);
    show_hide_addAcomodation();
    cek_button_addAcomodation();

    $(".nominalAcomodation").on('input', function(){
        calculate_nominalAcomodation();
        calculate_all();
    });

});

var calculate_nominalMorning  = function(){
    var totalnominalMorning = 0;
        $('.morning').each(function(){
            if($(this).val() != ""){
                    totalnominalMorning += parseInt($(this).val());
                }
        });
    $('.totalMorning').html(numberWithComma(totalnominalMorning));
}

var calculate_nominalAfternoon  = function(){
    var totalnominalAfternoon = 0;
        $('.afternoon').each(function(){
            if($(this).val() != ""){
                    totalnominalAfternoon += parseInt($(this).val());
                }
        });
    $('.totalAfternoon').html(numberWithComma(totalnominalAfternoon));
}

var calculate_nominalEvening  = function(){
    var totalnominalEvening = 0;
        $('.evening').each(function(){
            if($(this).val() != ""){
                    totalnominalEvening += parseInt($(this).val());
                }
        });
    $('.totalEvening').html(numberWithComma(totalnominalEvening));
}

var calculate_nominalDaily  = function(){
    var totalnominalDaily = 0;
        $('.daily').each(function(){
            if($(this).val() != ""){
                    totalnominalDaily += parseInt($(this).val());
                }
        });
    $('.totalDaily').html(numberWithComma(totalnominalDaily));
}

var calculate_allAllowance  = function(){
        var totalAll = 0;

        var totalMorning    = parseInt(document.getElementsByClassName("totalMorning")[0].innerHTML.replace(/,/g, ""));
        var totalAfternoon  = parseInt(document.getElementsByClassName("totalAfternoon")[0].innerHTML.replace(/,/g, ""));
        var totalEvening    = parseInt(document.getElementsByClassName("totalEvening")[0].innerHTML.replace(/,/g, ""));
        var totalDaily      = parseInt(document.getElementsByClassName("totalDaily")[0].innerHTML.replace(/,/g, ""));
        totalAll =(parseInt(totalMorning + totalAfternoon + totalEvening + totalDaily));
        
        $('.sub_total_2').html(numberWithComma(totalAll));
        $("input[name='sub_total_2']").val(totalAll);
}

$("#addAllowance").click(function(){
    //@php ($plafond_dinas = getPlafondTraining($data->lokasi_kegiatan,$data->tempat_tujuan))
    var no = $('.table-content-allowance tr').length;
    var html = '<tr>';
        html += '<td><input type="date" name="date[]" required class="form-control" onchange="calculate_allAllowance()" \
        placeholder="Date"></td>';
        html += '<td><input type="text" class="form-control meal_plafond" readonly="true" name="meal_plafond[]" value="#">';
        html += '<td><input type="text" class="form-control morning" name="morning[]"></td>';
        html += '<td><input type="text" name="morning_approved[]"  class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" name="afternoon[]" class="form-control afternoon "></td>';
        html += '<td><input type="text" name="afternoon_approved[]" class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" name="evening[]" class="form-control evening"></td>';
        html += '<td><input type="text" name="evening_approved[]" class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" class="form-control daily_plafond" readonly="true" name="daily_plafond[]" value="#"></td>';
        html += '<td><input type="text" name="daily[]" class="form-control daily"></td>';
        html += '<td><input type="text" name="daily_approved[]" class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="file" name="file_strukAllowance[]" class="form-control input"></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_itemAllowance(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-allowance').append(html);
    show_hide_addAllowance();
    cek_button_addAllowance();
    $(".morning").on('input', function(){
        calculate_nominalMorning();
        calculate_allAllowance();
        calculate_all();
    });
    $(".afternoon").on('input', function(){
        calculate_nominalAfternoon();
        calculate_allAllowance();
        calculate_all();
    });
    $(".evening").on('input', function(){
        calculate_nominalEvening();
        calculate_allAllowance();
        calculate_all();
    });
    $(".daily").on('input', function(){
        calculate_nominalDaily();
        calculate_allAllowance();
        calculate_all();
    });
});


var calculate_nominalOther  = function(){
    var totalnominalOther = 0;
        $('.nominalOther').each(function(){
            if($(this).val() != ""){
                    totalnominalOther += parseInt($(this).val());
                }
        });
    $('.sub_total_3').html(numberWithComma(totalnominalOther));
    $("input[name='sub_total_3']").val(totalnominalOther);
}

$("#addOther").click(function(){
    var no = $('.table-content-other tr').length;
    var html = '<tr>';
        html += '<td><input type="text" class="form-control descriptionOther" name="descriptionOther[]">';
        html += '<td><input type="text" class="form-control nominalOther" name="nominalOther[]"></td>';
        html += '<td><input type="text" name="nominalOther_approved[]"  class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" name="noteOther[]" class="form-control noteOther"></td>';
        html += '<td><input type="file" name="file_strukOther[]" class="form-control input"></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_itemOther(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-other').append(html);
    show_hide_addOther();
    cek_button_addOther();
    $(".nominalOther").on('input', function(){
        calculate_nominalOther();
        calculate_all();
    });

});

   
</script>

<script type="text/javascript">

    function calculate_all()
    {
        var total_actual_bill = 0;
 
        if($("input[name='sub_total_1']").val() != "")
        {  
            total_actual_bill       += parseInt($("input[name='sub_total_1']").val());
        }
       
        if( $("input[name='sub_total_2']").val() != "")
        {
            total_actual_bill       += parseInt($("input[name='sub_total_2']").val());
        }
        
        if( $("input[name='sub_total_3']").val() != "")
        {
            total_actual_bill       += parseInt($("input[name='sub_total_3']").val());
        }
        
        {{ !empty($data->pengambilan_uang_muka) ? ' total_reimbursement -='. $data->pengambilan_uang_muka .';' : '' }};

        $('.total_actual_bill').html(numberWithComma(total_actual_bill));
    }

    function show_img(img)
    {
        bootbox.alert(
        {
            message : '<img src="'+ img +'" style="width: 100%;" />',
            size: 'large' 
        });
    }

    $("#submit-form").click(function(){

        bootbox.confirm('Submit Actual Bill ?', function(res){
            if(res)
            {
                $("input[name='status_actual_bill']").val(2);
                $("#form-actual-bill").submit();
            }
        });     
    });
</script>


<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
@endsection
