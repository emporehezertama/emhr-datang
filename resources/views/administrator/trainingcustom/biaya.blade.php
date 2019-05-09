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
            <form class="form-horizontal" id="form-actual-bill" enctype="multipart/form-data" action="{{ route('karyawan.approval.training-custom.prosesClaim') }}" method="POST">
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
                                <tbody class="table-content-value">
                                     @foreach($data->training_acomodation as $no => $item)
                                        <tr>
                                             <input type="hidden" name="id_acomodation[]" class="form-control"  value="{{ $item->id }}" readonly="true">
                                             <td><input type="text" readonly="true" value="{{ $item->date }}" name="dateAcomodation[]" class="form-control"></td>
                                             <td><input type="text" readonly="true" name="training_transportation_type_id[]" class="form-control" value="{{ isset($item->transportation_type)? $item->transportation_type->name:''}}"></td>
                                            <td><input type="text" readonly="true" class="form-control price_format nominalAcomodation" name="nominalAcomodation[]" value="{{ $item->nominal}}"></td>
                                            <td>
                                           <input type="text" readonly="true" name="nominalAcomodation_approved[]" class="form-control nominalAcomodation_approved" value="{{$item->nominal_approved}}">
                                            </td>
                                            <td><input type="text" readonly="true" class="form-control noteAcomodation" name="noteAcomodation[]" value="{{ $item->note}}"></td>
                                            <td>
                                                @if(!empty($item->file_struk))
                                                <label onclick="show_img('{{ asset('storage/file-acomodation/'. $item->file_struk)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th colspan="2" style="text-align: center;">Sub Total</th>
                                    <th class="sub_total_1">{{ number_format($data->sub_total_1) }}</th>
                                    <th class="sub_total_1_disetujui" >{{ number_format($data->sub_total_1_disetujui) }}</th>
                                    <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
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
                                <tbody class="table-content-value">
                                    @foreach($data->training_allowance as $no => $item2)
                                        <tr>
                                             <input type="hidden" name="id_allowance[]" class="form-control"  value="{{ $item2->id }}" readonly="true">
                                             <td><input type="text" readonly="true" value="{{ $item2->date }}" name="dateAllowance[]" class="form-control"></td>
                                             <td><input type="text" class="form-control meal_plafond price_format" readonly="true" name="meal_plafond[]" value="{{number_format($item2->meal_plafond)}}"></td>
                                             <td><input type="text" class="form-control morning price_format" readonly="true" name="morning[]" value="{{ number_format($item2->morning) }}"></td>
                                             <td>
                                                 <input type="text" readonly="true" name="morning_approved[]"  class="form-control price_format morning_approved" value="{{ number_format($item2->morning_approved) }}">
                                            </td>
                                            <td><input type="text" class="form-control afternoon price_format" readonly="true" name="afternoon[]" value="{{ number_format($item2->afternoon) }}"></td>
                                            <td>
                                                <input type="text" readonly="true" name="afternoon_approved[]"  class="form-control price_format afternoon_approved" value="{{ number_format($item2->afternoon_approved) }}">
                                            </td>
                                            <td><input type="text" class="form-control evening price_format" readonly="true" name="evening[]" value="{{ number_format($item2->evening) }}"></td>
                                            <td>
                                                <input type="text" readonly="true" name="evening_approved[]"  class="form-control price_format evening_approved" value="{{ number_format($item2->evening_approved) }}">
                                            </td>
                                            <td><input type="text" readonly="true" class="form-control noteAllowance" name="noteAllowance[]" value="{{ $item2->note}}"></td>
                                            <td>
                                                @if(!empty($item2->file_struk))
                                                <label onclick="show_img('{{ asset('storage/file-allowance/'. $item2->file_struk)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
                                        <th class ="sub_total_2_disetujui" colspan="8" >{{ number_format($data->sub_total_2_disetujui) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
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
                                <tbody class="table-content-value">
                                     @foreach($data->training_daily as $no => $item3)
                                        <tr>
                                            <input type="hidden" name="id_daily[]" class="form-control"  value="{{ $item3->id }}" readonly="true">
                                             <td><input type="text" readonly="true" value="{{ $item3->date }}" name="dateDaily[]" class="form-control"></td>
                                             <td><input type="text" class="form-control daily_plafond price_format" readonly="true" name="daily_plafond[]" value="{{number_format($item3->daily_plafond)}}"></td>
                                             <td><input type="text" class="form-control nominalDaily price_format" readonly="true" name="nominalDaily[]" value="{{number_format($item3->daily)}}"></td>
                                             <td>
                                                <input type="text" readonly="true" name="nominalDaily_approved[]"  class="form-control price_format nominalDaily_approved" value="{{ number_format($item3->daily_approved) }}" >
                                            </td>
                                             <td><input type="text" readonly="true" class="form-control noteDaily" name="noteDaily[]" value="{{ $item3->note}}"></td>
                                            <td>
                                                @if(!empty($item3->file_struk))
                                                <label onclick="show_img('{{ asset('storage/file-daily/'. $item3->file_struk)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>                               
                                <tfoot>
                                    <tr>
                                    <th colspan="2" style="text-align: center;">Sub Total</th>
                                    <th class="sub_total_3">{{ number_format($data->sub_total_3) }}</th>
                                    <th class="sub_total_3_disetujui" >{{ number_format($data->sub_total_3_disetujui) }}</th>
                                    <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
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
                                    @foreach($data->training_other as $no => $item4)
                                        <tr>
                                            <input type="hidden" name="id_other[]" class="form-control"  value="{{ $item4->id }}" readonly="true">
                                             <td><input type="text" readonly="true" value="{{ $item4->date }}" name="dateOther[]" class="form-control"></td>
                                             <td><input type="text" readonly="true" class="form-control descriptionOther" name="descriptionOther[]" value="{{ $item4->description }}"></td>
                                             <td><input type="text" class="form-control nominalOther price_format" readonly="true" name="nominalOther[]" value="{{number_format($item4->nominal)}}"></td>
                                             <td>
                                                <input type="text" readonly="true" name="nominalOther_approved[]"  class="form-control price_format nominalOther_approved" value="{{ number_format($item4->nominal_approved) }}">
                                            </td>
                                             <td><input type="text" readonly="true" class="form-control noteOther" name="noteOther[]" value="{{ $item4->note}}"></td>
                                            <td>
                                                @if(!empty($item4->file_struk))
                                                <label onclick="show_img('{{ asset('storage/file-daily/'. $item4->file_struk)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
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
                                    <th class="sub_total_4_disetujui">{{ number_format($data->sub_total_4_disetujui) }}</th>
                                    <th colspan="2"> </th>
                                    </tr>
                            </tfoot>
                        </table>
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
                        <input type="hidden" name="status_actual_bill" value="0">
                        <input type="hidden" name="sub_total_1_disetujui" value="{{ $data->sub_total_1_disetujui }}">
                        <input type="hidden" name="sub_total_2_disetujui" value="{{ $data->sub_total_2_disetujui }}">
                        <input type="hidden" name="sub_total_3_disetujui" value="{{ $data->sub_total_3_disetujui }}">
                        <input type="hidden" name="sub_total_4_disetujui" value="{{ $data->sub_total_4_disetujui }}">

                        <div class="col-md-12" style="padding-left: 0;">
                            <a href="{{ route('administrator.trainingCustom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
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

</style>
@section('footer-script')
<script type="text/javascript">

    function show_img(img)
    {
        bootbox.alert(
        {
            message : '<img src="'+ img +'" style="width: 100%;" />',
            size: 'large' 
        });
    }

    
</script>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
@endsection
