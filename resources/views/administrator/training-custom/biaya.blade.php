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
                            <table class="table data_table_no_pagging display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="background-color: rgba(120,130,140,.13)">1. Acommodation & Transportation </th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Claimed</th>
                                        <th>Approved</th>
                                        <th>Note</th>
                                        <th style="width: 70px">Receipt Transaction</th>
                                    </tr>
                                </thead>
                                @if($data->status_actual_bill >0)
                                <tbody class="table-content-value">
                                    @foreach($acomodation as $key => $item)
                                        <tr>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ isset($item->transportation_type)? $item->transportation_type->name:''}}</td>
                                            <td>{{ number_format($item->nominal) }}</td>
                                            <td>{{ number_format($item->nominal_approved) }}</td>
                                            <td>{{ $item->note}}</td>
                                            <td>
                                                @if(!empty($item->file_struk))
                                                <label onclick="show_img('{{ asset('storage/file-acomodation/'. $item->file_struk)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @else
                                <tbody class="table-content-acomodation">
                                </tbody>
                                @endif
                                <tfoot>
                                    <tr>
                                    <th colspan="2" style="text-align: center;">Sub Total</th>
                                    <th class="sub_total_1">{{ number_format($data->sub_total_1) }}</th>
                                    <th >{{ number_format($data->sub_total_1_disetujui) }}</th>
                                    <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
                            @if($data->status_actual_bill < 1 or $data->status_actual_bill =="")
                            <a class="btn btn-info btn-xs pull-right" id="addAcomodation"><i class="fa fa-plus"></i> Add</a>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <div class="table-responsive">
                            <table class="table data_table_no_pagging display nowrap" cellspacing="0" width="100%" >
                                <thead>
                                    <tr>
                                    <th colspan="10" style="background-color: rgba(120,130,140,.13)">2. Meal Allowance </th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Date</th>
                                        <th rowspan="2">Plafond Meal Allowance</th>
                                        <th colspan="2" style="text-align: center;">Morning</th>
                                        <th colspan="2" style="text-align: center;">Afternoon</th>
                                        <th colspan="2" style="text-align: center;">Evening</th>
                                        <th rowspan="2">Note</th>
                                        <th rowspan="2" style="width: 70px">Receipt Transaction</th>
                                    </tr>
                                    <tr>
                                        <th>Claimed</th>
                                        <th>Approved</th>
                                        <th>Claimed</th>
                                        <th>Approved</th>
                                        <th>Claimed</th>
                                        <th>Approved</th>
                                        
                                    </tr>
                                </thead>
                                @if($data->status_actual_bill >0)
                                <tbody class="table-content-value">
                                    @foreach($allowance as $key => $item2)
                                        <tr>
                                            <td>{{ $item2->date }}</td>
                                            <td>{{ number_format($item2->meal_plafond) }}</td>
                                            <td>{{ number_format($item2->morning) }}</td>
                                            <td>{{ number_format($item2->morning_approved) }}</td>
                                            <td>{{ number_format($item2->afternoon) }}</td>
                                            <td>{{ number_format($item2->afternoon_approved) }}</td>
                                            <td>{{ number_format($item2->evening) }}</td>
                                            <td>{{ number_format($item2->evening_approved) }}</td>
                                            <td>{{ $item2->note}}</td>
                                            <td>
                                                @if(!empty($item2->file_struk))
                                                <label onclick="show_img('{{ asset('storage/file-allowance/'. $item2->file_struk)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @else
                                <tbody class="table-content-allowance">
                                </tbody>
                                @endif
                                <tfoot>
                                    <tr hidden="true"> 
                                        <th colspan="2"> Sub Total</th>
                                        <th class="totalMorning"> 0</th>
                                        <th class="totalMorningApproved"> 0</th>
                                        <th class="totalAfternoon"> 0</th>
                                        <th class="totalAfternoonApproved"> 0</th>
                                        <th class="totalEvening"> 0</th>
                                        <th colspan="3" class="totalEveningApproved"> 0</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: center;"> Sub Total Claimed</th>
                                        <th colspan="8" class="sub_total_2">{{ number_format($data->sub_total_2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: center;"> Sub Total Approved</th>
                                        <th colspan="8" >{{ number_format($data->sub_total_2_disetujui) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @if($data->status_actual_bill < 1 or $data->status_actual_bill =="")
                            <a class="btn btn-info btn-xs pull-right" id="addAllowance"><i class="fa fa-plus"></i> Add</a>
                            @endif
                        </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                            <table class="table data_table_no_pagging display nowrap" cellspacing="0" width="100%" >
                                <thead>
                                    <tr>
                                    <th colspan="6" style="background-color: rgba(120,130,140,.13)">3. Daily Allowance </th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Plafond Daily Allowance</th>
                                        <th>Claimed</th>
                                        <th>Approved</th>
                                        <th>Note</th>
                                        <th style="width: 70px">Receipt Transaction</th>
                                    </tr>
                                </thead>
                                @if($data->status_actual_bill >0)
                                <tbody class="table-content-value">
                                    @foreach($daily as $key => $item3)
                                        <tr>
                                            <td>{{ $item3->date }}</td>
                                            <td>{{ number_format($item3->daily_plafond) }}</td>
                                            <td>{{ number_format($item3->daily) }}</td>
                                            <td>{{ number_format($item3->daily_approved) }}</td>
                                            <td>{{ $item3->note}}</td>
                                            <td>
                                                @if(!empty($item3->file_struk))
                                                <label onclick="show_img('{{ asset('storage/file-daily/'. $item3->file_struk)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @else
                                <tbody class="table-content-daily">
                                </tbody>
                                @endif
                                <tfoot>
                                    <tr>
                                    <th colspan="2" style="text-align: center;">Sub Total</th>
                                    <th class="sub_total_3">{{ number_format($data->sub_total_3) }}</th>
                                    <th >{{ number_format($data->sub_total_3_disetujui) }}</th>
                                    <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
                            @if($data->status_actual_bill < 1 or $data->status_actual_bill =="")
                            <a class="btn btn-info btn-xs pull-right" id="addDaily"><i class="fa fa-plus"></i> Add</a>
                            @endif
                        </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table data_table_no_pagging display nowrap" cellspacing="0" width="100%" >
                            <thead>
                                <tr>
                                    <th colspan="6" style="background-color: rgba(120,130,140,.13)">4. Other's  </th>
                                </tr>
                                <tr>
                                    <th>Date </th>
                                    <th>Description </th>
                                    <th>Claimed </th>
                                    <th>Approved </th>
                                    <th>Note </th>
                                    <th style="width: 50px">Receipt Transaction </th>
                                </tr>
                            </thead>
                             @if($data->status_actual_bill >0)
                                <tbody class="table-content-value">
                                    @foreach($other as $key => $item4)
                                        <tr>
                                            <td>{{ $item4->date }}</td>
                                            <td>{{ $item4->description }}</td>
                                            <td>{{ number_format($item4->nominal) }}</td>
                                            <td>{{ number_format($item4->nominal_approved) }}</td>
                                            <td>{{ $item4->note}}</td>
                                            <td>
                                                @if(!empty($item4->file_struk))
                                                <label onclick="show_img('{{ asset('storage/file-other/'. $item4->file_struk)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @else
                            <tbody class="table-content-other">
                            </tbody>
                            @endif
                            <tfoot>
                                    <tr>
                                    <th colspan="2" style="text-align: center;">Sub Total</th>
                                    <th class="sub_total_4">{{ number_format($data->sub_total_4) }}</th>
                                    <th >{{ number_format($data->sub_total_4_disetujui) }}</th>
                                    <th colspan="2"> </th>
                                    </tr>
                            </tfoot>
                        </table>
                       @if($data->status_actual_bill < 1 or $data->status_actual_bill =="")
                        <a class="btn btn-info btn-xs pull-right" id="addOther"><i class="fa fa-plus"></i> Add</a>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    <br />

                        <div class="col-md-6 table-total" style="padding-left:0;">
                            <table class="table table-hover">
                                <tr>
                                    <th>Total Claimed</th>
                                    <th class="total_actual_bill">
                                        IDR {{ number_format($data->sub_total_1 + $data->sub_total_2 + $data->sub_total_3 + $data->sub_total_4) }}
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
                                    <th>Total Approved</th>
                                    <th class="total_actual_bill_disetujui">
                                         IDR {{ number_format($data->sub_total_1_disetujui + $data->sub_total_2_disetujui + $data->sub_total_3_disetujui + $data->sub_total_4_disetujui) }}
                                    </th>
                                </tr>
                                <tr>
                                    @php( $total_reimbursement_disetujui = $data->sub_total_1_disetujui + $data->sub_total_2_disetujui + $data->sub_total_3_disetujui + $data->sub_total_4_disetujui - $data->pengambilan_uang_muka )
                                    @if($total_reimbursement_disetujui < 0)
                                    <th>Total Re-Payment </th>
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
                        <br />
                        @foreach($data->historyApproval as $key => $item)
                            <div class="form-group">
                                <label class="col-md-12">Note Claim Approval {{$item->setting_approval_level_id}}</label>
                                <div class="col-md-12">
                                    <input type="text" readonly="true" class="form-control note" value="{{ $item->note_claim }}">
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <hr style="margin-top:0;" />
                    
                    <input type="hidden" name="id" value="{{ $data->id }}" />
                    <input type="hidden" name="status_actual_bill" value="1">
                    <input type="hidden" name="sub_total_1" value="{{ $data->sub_total_1 }}" />
                    <input type="hidden" name="sub_total_2" value="{{ $data->sub_total_2 }}" />
                    <input type="hidden" name="sub_total_3" value="{{ $data->sub_total_3 }}" />
                    <input type="hidden" name="sub_total_4" value="{{ $data->sub_total_4 }}" />

                    <div class="col-md-12" style="padding-left: 0;">
                        <a href="{{ route('administrator.training-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        @if($data->status_actual_bill < 1 or $data->status_actual_bill =="")
                        <!--<button type="submit" class="btn btn-sm btn-warning waves-effect waves-light m-r-10" id="save-as-draft-form"><i class="fa fa-save"></i> Save as Draft</button>-->

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
   
    
    
    table.data_table_no_pagging thead tr td, table.data_table_no_pagging thead tr th {
        border-bottom: 1px solid rgb(193, 190, 190) !important;
        border-top: 1px solid rgb(193, 190, 190) !important;
        border-right: 1px solid rgb(193, 190, 190) !important;
        border-left: 1px solid rgb(193, 190, 190) !important;
        text-align: center !important;

    }
    table.data_table_no_pagging tfoot tr td, table.data_table_no_pagging tfoot tr th{
         border-bottom: 1px solid rgb(193, 190, 190) !important;
        border-top: 1px solid rgb(193, 190, 190) !important;
        border-right: 1px solid rgb(193, 190, 190) !important;
        border-left: 1px solid rgb(193, 190, 190) !important;
    }

    table.data_table_no_pagging tbody tr td,table.data_table_no_pagging tbody tr th{
            border-bottom: 0 solid rgb(193, 190, 190) !important;
            border-top: 0 solid rgb(193, 190, 190) !important;
            border-left: 1px solid rgb(193, 190, 190) !important;
    }

    table.data_table_no_pagging tbody.table-content-value tr td{
            border-bottom: 0 solid rgb(193, 190, 190) !important;
            border-top: 1px solid rgb(193, 190, 190) !important;
            border-left: 1px solid rgb(193, 190, 190) !important;
            border-right: 1px solid rgb(193, 190, 190) !important;

    }
    /*
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
//Daily
function show_hide_addDaily()
{       
    validate_form = true;
    $('.input').each(function(){
        if($(this).val() == "")
        {
            validate_form = false;
        }
    });
}

function cek_button_addDaily()
{
    $('.input').each(function(){
        $(this).on('keyup',function(){
            show_hide_addDaily();
        })
        $(this).on('change',function(){
            show_hide_addDaily();
        })
    });
}
function delete_itemDaily(el)
{
    if(confirm('Delete this data?'))
    {
        $(el).parent().parent().hide("slow", function(){
            $(el).parent().parent().remove();
            setTimeout(function(){
                show_hide_addDaily();
                cek_button_addDaily();
                calculate_nominalDaily();
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
                    var value = $(this).val();
                    totalnominalAcomodation += parseInt(value.split('.').join(''));
                }
        });
    $('.sub_total_1').html(numberWithComma(totalnominalAcomodation));
    $("input[name='sub_total_1']").val(totalnominalAcomodation);
}

$("#addAcomodation").click(function(){
    
    var no = $('.table-content-acomodation tr').length;
    var html = '<tr>';
        html += '<td><input type="date" name="dateAcomodation[]" required class="form-control" \
        placeholder="Date"></td>';
        html += '<td><select class="form-control training_transportation_type_id" \
        name="training_transportation_type_id[]">\
                                        <option value=""> - choose - </option>\
                                        @foreach($transportationtype as $item)\
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>\
                                        @endforeach\
                                </select></td>';
        html += '<td><input type="text" class="form-control price_format nominalAcomodation" name="nominalAcomodation[]"></td>';
        html += '<td><input type="text" name="nominalAcomodation_approved[]"  class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" style="width: 150px" name="noteAcomodation[]" class="form-control noteAcomodation"></td>';
        html += '<td><input type="file" name="file_strukAcomodation[]" class="form-control input"></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_itemAcomodation(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-acomodation').append(html);
    show_hide_addAcomodation();
    cek_button_addAcomodation();
    price_format();

    $(".nominalAcomodation").on('input', function(){
        calculate_nominalAcomodation();
        calculate_all();
    });

});

var calculate_nominalMorning  = function(){
    var totalnominalMorning = 0;
        $('.morning').each(function(){
            if($(this).val() != ""){
                    var value = $(this).val();
                    totalnominalMorning += parseInt(value.split('.').join(''));
                }
        });
    $('.totalMorning').html(numberWithComma(totalnominalMorning));
}

var calculate_nominalAfternoon  = function(){
    var totalnominalAfternoon = 0;
        $('.afternoon').each(function(){
            if($(this).val() != ""){
                    var value = $(this).val();
                    totalnominalAfternoon += parseInt(value.split('.').join(''));
                }
        });
    $('.totalAfternoon').html(numberWithComma(totalnominalAfternoon));
}

var calculate_nominalEvening  = function(){
    var totalnominalEvening = 0;
        $('.evening').each(function(){
            if($(this).val() != ""){
                    var value = $(this).val();
                    totalnominalEvening += parseInt(value.split('.').join(''));
                }
        });
    $('.totalEvening').html(numberWithComma(totalnominalEvening));
}

var calculate_allAllowance  = function(){
        var totalAll = 0;

        var totalMorning    = parseInt(document.getElementsByClassName("totalMorning")[0].innerHTML.replace(/,/g, ""));
        var totalAfternoon  = parseInt(document.getElementsByClassName("totalAfternoon")[0].innerHTML.replace(/,/g, ""));
        var totalEvening    = parseInt(document.getElementsByClassName("totalEvening")[0].innerHTML.replace(/,/g, ""));
        totalAll =(parseInt(totalMorning + totalAfternoon + totalEvening));
        
        $('.sub_total_2').html(numberWithComma(totalAll));
        $("input[name='sub_total_2']").val(totalAll);
}

$("#addAllowance").click(function(){
    @php ($plafond_dinas = getPlafondTraining($data->lokasi_kegiatan,$data->tempat_tujuan))
    @if($plafond_dinas->tunjangan_makanan == 0)
    {
        alert('Plafond your meal allowance and type of location not define yet. Please contact your admin !');
    }
    @endif
    var no = $('.table-content-allowance tr').length;
    var html = '<tr>';
        html += '<td><input type="date" name="dateAllowance[]" required class="form-control" placeholder="Date"></td>';
        html += '<td><input type="text" class="form-control meal_plafond price_format" readonly="true" name="meal_plafond[]" value="{{$plafond_dinas->tunjangan_makanan}}">';
        html += '<td><input type="text" class="form-control morning price_format" name="morning[]"></td>';
        html += '<td><input type="text" name="morning_approved[]"  class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" name="afternoon[]" class="form-control afternoon price_format "></td>';
        html += '<td><input type="text" name="afternoon_approved[]" class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" name="evening[]" class="form-control evening price_format"></td>';
        html += '<td><input type="text" name="evening_approved[]" class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" style="width: 150px" name="noteAllowance[]" class="form-control noteAllowance"></td>';
        html += '<td><input type="file" name="file_strukAllowance[]" class="form-control input"></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_itemAllowance(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-allowance').append(html);
    show_hide_addAllowance();
    cek_button_addAllowance();
    price_format();
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
});


var calculate_nominalDaily  = function(){
    var totalnominalDaily = 0;
        $('.nominalDaily').each(function(){
            if($(this).val() != ""){
                    var value = $(this).val();
                    totalnominalDaily += parseInt(value.split('.').join(''));
                }
        });
    $('.sub_total_3').html(numberWithComma(totalnominalDaily));
    $("input[name='sub_total_3']").val(totalnominalDaily);
}
$("#addDaily").click(function(){
    @php ($plafond_dinas = getPlafondTraining($data->lokasi_kegiatan,$data->tempat_tujuan))
    @if($plafond_dinas->tunjangan_harian == 0)
    {
        alert('Plafond your daily allowance and type of location not define yet. Please contact your admin !');
    }
    @endif
    var no = $('.table-content-daily tr').length;
    var html = '<tr>';
        html += '<td><input type="date" name="dateDaily[]" required class="form-control" \
        placeholder="Date"></td>';
         html += '<td><input type="text" class="form-control daily_plafond price_format" readonly="true" name="daily_plafond[]" value="{{$plafond_dinas->tunjangan_harian}}">';
          html += '<td><input type="text" name="nominalDaily[]"  class="form-control price_format nominalDaily"></td>';
        html += '<td><input type="text" name="nominalDaily_approved[]"  class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" style="width: 150px" name="noteDaily[]" class="form-control noteDaily"></td>';
        html += '<td><input type="file" name="file_strukDaily[]" class="form-control input"></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_itemDaily(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-daily').append(html);
    show_hide_addDaily();
    cek_button_addDaily();
    price_format();

    $(".nominalDaily").on('input', function(){
        calculate_nominalDaily();
        calculate_all();
    });

});

var calculate_nominalOther  = function(){
    var totalnominalOther = 0;
        $('.nominalOther').each(function(){
            if($(this).val() != ""){
                    var value = $(this).val();
                    totalnominalOther += parseInt(value.split('.').join(''));
                }
        });
    $('.sub_total_4').html(numberWithComma(totalnominalOther));
    $("input[name='sub_total_4']").val(totalnominalOther);
}

$("#addOther").click(function(){
    var no = $('.table-content-other tr').length;
    var html = '<tr>';
        html += '<td><input type="date" name="dateOther[]" required class="form-control" \
        placeholder="Date"></td>';
        html += '<td><input type="text" class="form-control descriptionOther" name="descriptionOther[]"></td>';
        html += '<td><input type="text" class="form-control nominalOther price_format" name="nominalOther[]"></td>';
        html += '<td><input type="text" name="nominalOther_approved[]"  class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" style="width: 150px" name="noteOther[]" class="form-control noteOther"></td>';
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
       var total_reimbursement = 0;
 
        if($("input[name='sub_total_1']").val() != "")
        {  
            total_actual_bill       += parseInt($("input[name='sub_total_1']").val());
             total_reimbursement     += parseInt($("input[name='sub_total_1']").val());
        }
       
        if( $("input[name='sub_total_2']").val() != "")
        {
            total_actual_bill       += parseInt($("input[name='sub_total_2']").val());
             total_reimbursement     += parseInt($("input[name='sub_total_2']").val());
        }
        
        if( $("input[name='sub_total_3']").val() != "")
        {
            total_actual_bill       += parseInt($("input[name='sub_total_3']").val());
             total_reimbursement     += parseInt($("input[name='sub_total_4']").val());
        }

        if( $("input[name='sub_total_4']").val() != "")
        {
            total_actual_bill       += parseInt($("input[name='sub_total_4']").val());
             total_reimbursement     += parseInt($("input[name='sub_total_4']").val());
        }
        
        {{ !empty($data->pengambilan_uang_muka) ? ' total_reimbursement -='. $data->pengambilan_uang_muka .';' : '' }};

        if(total_reimbursement <0 )
        {
            total_reimbursement  = Math.abs(total_reimbursement);
        }

        $('.total_actual_bill').html(numberWithComma(total_actual_bill));
        $('.total_reimbursement').html(numberWithComma(total_reimbursement));
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
        var jumlahAcomodation=$("tbody.table-content-acomodation tr").length;
        var jumlahAllowance=$("tbody.table-content-allowance tr").length;
        var jumlahDaily=$("tbody.table-content-daily tr").length;
        var jumlahOther=$("tbody.table-content-other tr").length;

        var ret = true;
        if(jumlahAcomodation > 0)
        {
            $("tbody.table-content-acomodation tr").each(function() {
                var date = $(this).find("td").eq(0).find("input").val();
                var description = $(this).find("td").eq(1).find("select").val();
                var nominal = $(this).find("td").eq(2).find("input").val();
                if(date== "" || description == "" || nominal== "")
                {
                    bootbox.alert("Data Acommodation & Transportation is incomplete !");
                    ret = false;
                }
           });       
        }
        if(jumlahAllowance > 0)
        {
            $("tbody.table-content-allowance tr").each(function() {
                var date = $(this).find("td").eq(0).find("input").val();
                if(date== "")
                {
                    bootbox.alert("Date Meal Allowance is incomplete !");
                    ret = false;
                }
           });       
        }
        if(jumlahDaily > 0)
        {
            $("tbody.table-content-daily tr").each(function() {
                var date = $(this).find("td").eq(0).find("input").val();
                var nominal = $(this).find("td").eq(2).find("input").val();
                if(date== "" || nominal== "")
                {
                    bootbox.alert("Data Daily Allowance is incomplete !");
                    ret = false;
                }
           });       
        }
        if(jumlahOther > 0)
        {
            $("tbody.table-content-other tr").each(function() {
                var date = $(this).find("td").eq(0).find("input").val();
                var description = $(this).find("td").eq(1).find("select").val();
                var nominal = $(this).find("td").eq(2).find("input").val();
                if(date== "" || description == "" || nominal== "")
                {
                    bootbox.alert("Data Other's is incomplete !");
                    ret = false;
                }
           });       
        }


        if(ret)
        {
            bootbox.confirm('Submit Actual Bill ?', function(res){
                if(res)
                {
                    $("input[name='status_actual_bill']").val(1);
                    $("#form-actual-bill").submit();
                }
            });
        }     
    });
</script>


<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
@endsection
