@extends('layouts.karyawan')

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
            <form class="form-horizontal" id="form-actual-bill" enctype="multipart/form-data" action="{{ route('karyawan.approval.training.proses-biaya') }}" method="POST">
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
                            $readonly = "";
                            if($data->approve_direktur_actual_bill == 1)
                            {
                                $readonly = ' readonly="true" ';
                            }
                        ?>
                       
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="background: #eee;">1. Transportation</th>
                                    <th style="background: #eee;">Nominal</th>
                                    <th style="background: #eee;">Nominal Approved</th>
                                    <th style="background: #eee;">Receipt Transaction</th>
                                    <th style="background: #eee;">Note</th>
                                </tr>
                                <tr>
                                    <td>Ticket (Train/Airlines/Ship,etc)</td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" name="transportasi_ticket" value="{{ $data->transportasi_ticket }}" ></td>
                                    <td><input placeholder="IDR"  type="number" class="form-control calculate_1" name="transportasi_ticket_disetujui" value="{{ $data->transportasi_ticket_disetujui }}"{{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_ticket_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_ticket_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" name="transportasi_ticket_catatan" value="{{ $data->transportasi_ticket_catatan }}" {{$readonly}}></td>
                                </tr>
                                <tr>
                                    <td>Taxi</td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" name="transportasi_taxi" value="{{ $data->transportasi_taxi }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" name="transportasi_taxi_disetujui" value="{{ $data->transportasi_taxi_disetujui }}"{{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_taxi_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_taxi_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" name="transportasi_taxi_catatan" value="{{ $data->transportasi_taxi_catatan }}" {{$readonly}} ></td>
                                </tr>
                                <tr>
                                    <td>Gasoline</td>
                                    <td><input placeholder="IDR"  type="number" class="form-control" name="transportasi_gasoline" value="{{ $data->transportasi_gasoline }}" readonly="true" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" name="transportasi_gasoline_disetujui" value="{{ $data->transportasi_gasoline_disetujui }}"{{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_gasoline_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_gasoline_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" name="transportasi_gasoline_catatan" class="form-control" value="{{ $data->transportasi_gasoline_catatan }}" {{$readonly}} /></td>
                                </tr>
                                <tr>
                                    <td>Tol</td>
                                    <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_tol" value="{{ $data->transportasi_tol }}" readonly="true" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" name="transportasi_tol_disetujui" value="{{ $data->transportasi_tol_disetujui }}" {{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_tol_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_tol_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" name="transportasi_tol_catatan" value="{{ $data->transportasi_tol_catatan }}" {{$readonly}}></td>
                                </tr>
                                <tr>
                                    <td>Parking</td>
                                    <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_parkir" value="{{ $data->transportasi_parkir }}" readonly="" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" name="transportasi_parkir_disetujui" value="{{ $data->transportasi_parkir_disetujui }}"{{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_parkir_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_parkir_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" name="transportasi_parkir_catatan" value="{{ $data->transportasi_parkir_catatan }}" {{$readonly}}></td>
                                </tr>
                                <tr>
                                    <th>Sub Total</th>
                                    <th class="total_transport">{{ number_format($data->sub_total_1) }}</th>
                                    <th class="total_transport_disetujui" colspan="3">{{ number_format($data->sub_total_1_disetujui) }}</th>
                                </tr>
                            </tbody>
                    </table>
                    <table class="table table-bordered">
                            <tbody>
                                 <tr>
                                    <th style="background: #eee;">2. Hotel and Meal Allowance</th>
                                    <th style="background: #eee;">Plafond</th>
                                    <th style="background: #eee;">Nominal / days</th>
                                    <th style="background: #eee;">Amount (days)</th>
                                    <th style="background: #eee;">Total Request</th>
                                    <th style="background: #eee;">Nominal Approved</th>
                                    <th style="background: #eee;">Receipt Transaction</th>
                                    <th style="background: #eee;">Note</th>

                                    </tr>
                                    @php ($plafond_dinas = plafond_perjalanan_dinas(jabatan_level_user($data->user_id)))
                                    @if($plafond_dinas)
                                    <tr>
                                        <td>Hotel</td>
                                        <td>
                                            IDR {{ number_format($plafond_dinas->hotel) }}
                                            <input type="hidden" name="uang_hotel_plafond" value="{{ $plafond_dinas->hotel }}">
                                        </td>
                                        <td><input type="number" class="form-control" name="uang_hotel_nominal" placeholder="IDR " value="{{ $data->uang_hotel_nominal }}" readonly="true" ></td>
                                        <td><input type="number" class="form-control" placeholder="AMOUNT" name="uang_hotel_qty"  value="{{ $data->uang_hotel_qty }}" readonly="true"></td>
                                        <td>
                                            @if(empty($data->uang_hotel_qty))
                                                {{ number_format($data->uang_hotel_nominal) }}
                                            @else
                                                {{ number_format($data->uang_hotel_nominal * $data->uang_hotel_qty) }}
                                            @endif
                                        </td>
                                        <td><input type="text" name="uang_hotel_nominal_disetujui" value="{{ $data->uang_hotel_nominal_disetujui }}" class="form-control" {{$readonly}}></td>
                                        <td>
                                            @if(!empty($data->uang_hotel_file))
                                            <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_hotel_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                            @endif
                                        </td>
                                        <td><input type="text" class="form-control" placeholder="Catatan" name="uang_hotel_catatan" value="{{ $data->uang_hotel_catatan }}" {{$readonly}}></td>
                                    </tr>

                                    <tr>
                                        <td>Meal Allowance</td>
                                        <td>IDR {{ number_format($plafond_dinas->tunjangan_makanan) }}</td>
                                        <td>
                                            <input type="hidden" class="form-control" name="uang_makan_plafond" value="{{ $plafond_dinas->tunjangan_makan }}" >
                                            <input type="number" class="form-control" name="uang_makan_nominal" value="{{ $data->uang_makan_nominal }}" placeholder="IDR " readonly="" >
                                        </td>
                                        <td><input type="number" class="form-control" value="{{ $data->uang_makan_qty }}" name="uang_makan_qty" readonly="true" placeholder="AMOUNT" {{$readonly}} ></td>
                                        <td>
                                            @if(empty($data->uang_makan_qty))
                                                {{ number_format($data->uang_makan_nominal) }}
                                            @else
                                                {{ number_format($data->uang_makan_nominal * $data->uang_makan_qty) }}
                                            @endif
                                        </td>
                                        <td><input type="text" name="uang_makan_nominal_disetujui" value="{{ $data->uang_makan_nominal_disetujui }}" class="form-control" {{$readonly}}></td>
                                        <td>
                                            @if(!empty($data->uang_makan_file))
                                            <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_makan_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                            @endif
                                        </td>
                                        <td><input type="text" class="form-control" placeholder="Catatan" name="uang_makan_catatan" value="{{ $data->uang_makan_catatan }}" {{$readonly}}></td>
                                    </tr>
                                    <tr>
                                        <td>Daily Allowance</td>
                                        <td>IDR {{ number_format($plafond_dinas->hotel) }}</td>
                                        <td>
                                            <input type="hidden" class="form-control" name="uang_harian_plafond" value="{{ $plafond_dinas->hotel }}" >
                                            <input type="number" class="form-control" value="{{ $data->uang_harian_nominal }}" name="uang_harian_nominal" placeholder="IDR " readonly="true" >
                                        </td>
                                        <td><input type="number" class="form-control" name="uang_harian_qty" value="{{ $data->uang_harian_qty }}" placeholder="AMOUNT" readonly="true" ></td>
                                        <td>
                                            @if(empty($data->uang_harian_qty))
                                                {{ number_format($data->uang_harian_nominal) }}
                                            @else 
                                                {{ number_format($data->uang_harian_nominal * $data->uang_harian_qty ) }}
                                            @endif
                                        </td>
                                        <td><input type="text" class="form-control" name="uang_harian_nominal_disetujui" value="{{ $data->uang_harian_nominal_disetujui }}" {{$readonly}}></td>
                                        <td>
                                            @if(!empty($data->uang_harian_file))
                                            <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_harian_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                            @endif
                                        </td>
                                        <td><input type="text" class="form-control" placeholder="Catatan" name="uang_harian_catatan" value="{{ $data->uang_harian_catatan }}" {{$readonly}}></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: right;">Sub Total</th>
                                        <th>{{ number_format($data->sub_total_2) }}</th>
                                        <th colspan="2" style="text-align: right;">Sub Total Disetujui</th>
                                        <th class="sub_total_2_disetujui" colspan="3">{{ number_format($data->sub_total_2_disetujui) }}</th>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="8"><i>No fare available ...</i></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                    <table class="table table-bordered">
                            <tr>
                                <th colspan="2" style="background: #eee;">3. Other's </th>
                                <th style="background: #eee;">Nominal </th>
                                <th style="background: #eee;">Nominal Approved </th>
                                <th style="background: #eee;">Receipt Transaction </th>
                                <th style="background: #eee;">Note </th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="uang_biaya_lainnya1" class="form-control" placeholder="Other Expense" value="{{ $data->uang_biaya_lainnya1 }}" readonly="true" />
                                </td>
                                <td>
                                    <input type="text" name="uang_biaya_lainnya1_nominal" value="{{ $data->uang_biaya_lainnya1_nominal }}" class="form-control" placeholder="Rp. " readonly="true" />
                                </td>
                                <td>
                                    <input type="text" name="uang_biaya_lainnya1_nominal_disetujui" value="{{ $data->uang_biaya_lainnya1_nominal_disetujui }}" class="form-control" placeholder="IDR " {{$readonly}} />
                                </td>
                                <td>
                                    @if(!empty($data->uang_biaya_lainnya1_file))
                                    <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya1_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="uang_biaya_lainnya1_catatan" value="{{ $data->uang_biaya_lainnya1_catatan }}" placeholder="Note" {{$readonly}} />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="uang_biaya_lainnya2" value="{{ $data->uang_biaya_lainnya2 }}" class="form-control" placeholder="Other Expense" readonly="true" />
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $data->uang_biaya_lainnya2_nominal }}" name="uang_biaya_lainnya2_nominal" placeholder="IDR " readonly="true" />
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="uang_biaya_lainnya2_nominal_disetujui" value="{{ $data->uang_biaya_lainnya2_nominal_disetujui }}" placeholder="IDR" {{$readonly}} />
                                </td>
                                <td>
                                    @if(!empty($data->uang_biaya_lainnya2_file))
                                    <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya2_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" name="uang_biaya_lainnya2_catatan" value="{{ $data->uang_biaya_lainnya2_catatan }}" class="form-control" placeholder="Catatan" {{$readonly}} />
                                </td>
                            </tr>
                           <tr>
                                <th colspan="2">Sub Total</th>
                                <th class="sub_total_nominal_lainnya">{{ number_format($data->sub_total_3) }}</th>
                                <th colspan="3" class="total_lain_lain_disetujui">{{ number_format($data->sub_total_3_disetujui) }}</th>
                            </tr>
                        </tbody>
                    </table>
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
                        <input type="hidden" name="status_actual_bill" value="0">
                        <input type="hidden" name="sub_total_1_disetujui" value="{{ $data->sub_total_1_disetujui }}">
                        <input type="hidden" name="sub_total_2_disetujui" value="{{ $data->sub_total_2_disetujui }}">
                        <input type="hidden" name="sub_total_3_disetujui" value="{{ $data->sub_total_3_disetujui }}">

                        <div class="col-md-12" style="padding-left: 0;">
                            <a href="{{ route('karyawan.approval.training.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>

                            @if($data->is_approve_finance_actual_bill == "")
                            <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-check"></i> Approved</a>
                            <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Denied</a>
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
    }
</style>
@section('footer-script')
<script type="text/javascript">
 $(".calculate_1").on('input', function(){

        var val = 0;

        $(".calculate_1").each(function(){

            if($(this).val() != "")
            {
                val += parseInt($(this).val());                
            }
        });

        $('.total_transport_disetujui').html(numberWithComma(val));
        $("input[name='sub_total_1_disetujui']").val(val);

        calculate_all();
    });

    $("input[name='uang_hotel_nominal_disetujui'], input[name='uang_makan_nominal_disetujui'],input[name='uang_harian_nominal_disetujui'], input[name='uang_biaya_lainnya1_nominal_disetujui'], input[name='uang_biaya_lainnya2_nominal_disetujui']").on('input', function(){
        calculate_all();
    });

    function calculate_all()
    {
        var total_actual = 0;

        $(".calculate_1").each(function(){

            if($(this).val() != "")
            {
                total_actual += parseInt($(this).val());                
            }
        });

        $("input[name='sub_total_1_disetujui']").val(total_actual);
        

        var total_hotel = 0;

        @if(!empty(@plafond_dinas))
        if($("input[name='uang_hotel_nominal_disetujui']").val() != "")
        {
            total_hotel += parseInt($("input[name='uang_hotel_nominal_disetujui']").val());
        }

        if($("input[name='uang_makan_nominal_disetujui']").val() != "")
        {
            total_hotel += parseInt($("input[name='uang_makan_nominal_disetujui']").val());
        }       

        if($("input[name='uang_harian_nominal_disetujui']").val() != "")
        {
            total_hotel += parseInt($("input[name='uang_harian_nominal_disetujui']").val());
        }       
        @endif

        var total_lainnya = 0;

        var lainnya1 = $("input[name='uang_biaya_lainnya1_nominal_disetujui']").val(); 
        var lainnya2 = $("input[name='uang_biaya_lainnya2_nominal_disetujui']").val(); 

        if(lainnya1 != "")
        {
            total_lainnya += parseInt(lainnya1);
            total_actual += parseInt(lainnya1);
        }

        if(lainnya2 != "")
        {
            total_lainnya += parseInt(lainnya2);
            total_actual += parseInt(lainnya2);
        }
        
        $('.total_lain_lain_disetujui').html(numberWithComma(total_lainnya));

        $("input[name='sub_total_3_disetujui']").val(total_lainnya);
        $("input[name='sub_total_2_disetujui']").val(total_hotel);
        $(".sub_total_2_disetujui").html(numberWithComma(total_hotel));

        total_actual = total_actual + total_hotel;
        total_reimbursement = parseInt(total_actual) {{ !empty($data->pengambilan_uang_muka) ? '-'. $data->pengambilan_uang_muka : '' }};

        //
        if(total_reimbursement <=0 )
        {
            total_reimbursement  = 0;
        }

        $('.total_actual_bill_disetujui').html(numberWithComma(total_actual));
        $('.total_reimbursement_disetujui').html(numberWithComma(total_reimbursement));
    }

    function show_img(img)
    {
        bootbox.alert(
        {
            message : '<img src="'+ img +'" style="width: 100%;" />',
            size: 'large' 
        });
    }

    $("#btn_approved").click(function(){
        bootbox.confirm('Approve Actual Bill Perjalanan Dinas Karyawan ?', function(result){

            $("input[name='status_actual_bill']").val(1);
            if(result)
            {
                $('#form-actual-bill').submit();
            }

        });
    });

    $("#btn_tolak").click(function(){
        bootbox.confirm('Tolak Actual Bill Perjalanan Dinas Karyawan ?', function(result){

            if(result)
            {
                $('#form-actual-bill').submit();
            }

        });
    });
</script>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
@endsection
