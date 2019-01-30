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
            <form class="form-horizontal" id="form-actual-bill" enctype="multipart/form-data" action="{{ route('karyawan.training.submit-biaya') }}" method="POST">
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
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" {{$readonly}}  name="transportasi_ticket" value="{{ $data->transportasi_ticket }}" ></td>
                                    <td><input placeholder="IDR"  type="number" class="form-control" readonly="true" value="{{ $data->transportasi_ticket_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_ticket_file" />
                                        </div>
                                        @if(!empty($data->transportasi_ticket_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_ticket_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_ticket_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Taxi</td>
                                    <td><input placeholder="IDR" type="number" {{$readonly}} class="form-control calculate_1" name="transportasi_taxi" value="{{ $data->transportasi_taxi }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" value="{{ $data->transportasi_taxi_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_taxi_file" />
                                        </div>
                                        @if(!empty($data->transportasi_taxi_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_taxi_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_taxi_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Gasoline</td>
                                    <td><input placeholder="IDR"  type="number" {{$readonly}} class="form-control calculate_1" name="transportasi_gasoline" value="{{ $data->transportasi_gasoline }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" value="{{ $data->transportasi_gasoline_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_gasoline_file" />
                                        </div>
                                        @if(!empty($data->transportasi_gasoline_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_gasoline_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_gasoline_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Tol</td>
                                    <td><input placeholder="IDR" type="number" {{$readonly}} class="form-control calculate_1" name="transportasi_tol" value="{{ $data->transportasi_tol }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" value="{{ $data->transportasi_tol_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_tol_file" />
                                        </div>
                                        @if(!empty($data->transportasi_tol_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_tol_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_tol_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Parking</td>
                                    <td><input placeholder="IDR" type="number" {{$readonly}} class="form-control calculate_1" name="transportasi_parkir" value="{{ $data->transportasi_parkir }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" value="{{ $data->transportasi_parkir_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_parkir_file" />
                                        </div>
                                        @if(!empty($data->transportasi_parkir_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_parkir_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_parkir_catatan }}"></td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Sub Total</th>
                                    <th class="total_transport">{{ number_format($data->sub_total_1) }}</th>
                                    <th colspan="3">{{ number_format($data->sub_total_1_disetujui) }}</th>
                                </tr>
                            </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                             <tr>   
                                    <th style="background: #eee;">2. Hotel and Meal Allowance</th>
                                    <th style="background: #eee;">Plafond</th>
                                    <th style="background: #eee;">Nominal / days</th>
                                    <th style="background: #eee;">QTY (days)</th>
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
                                    <td><input type="number" class="form-control calculate_2" {{$readonly}} name="uang_hotel_nominal" placeholder="IDR " value="{{ $data->uang_hotel_nominal }}" ></td>
                                    <td><input type="number" class="form-control" {{$readonly}} placeholder="QTY" name="uang_hotel_qty"  value="{{ $data->uang_hotel_qty }}" ></td>
                                    <td class="total_pengajuan_hotel">
                                        @if(empty($data->uang_hotel_qty))
                                            {{ number_format($data->uang_hotel_nominal) }}
                                        @else
                                            {{ number_format($data->uang_hotel_nominal * $data->uang_hotel_qty) }}
                                        @endif
                                    </td>
                                    <td><input type="text" readonly="true"  class="form-control" value="{{ $data->uang_hotel_nominal_disetujui }}" ></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="uang_hotel_file" />
                                        </div>
                                        @if(!empty($data->uang_hotel_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_hotel_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" {{$readonly}} placeholder="Note" readonly="true" value="{{ $data->uang_hotel_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Meal Allowance</td>
                                    <td>IDR {{ number_format($plafond_dinas->tunjangan_makanan) }}</td>
                                    <td>
                                        <input type="hidden" class="form-control" name="uang_makan_plafond" value="{{ $plafond_dinas->tunjangan_makan }}" >
                                        <input type="number" class="form-control" {{$readonly}} name="uang_makan_nominal" value="{{ $data->uang_makan_nominal }}" placeholder="IDR " >
                                    </td>
                                    <td><input type="number" class="form-control" {{$readonly}} value="{{ $data->uang_makan_qty }}" name="uang_makan_qty" placeholder="QTY" ></td>
                                    <td class="total_pengajuan_makan">
                                        @if(empty($data->uang_makan_qty))
                                            {{ number_format($data->uang_makan_nominal) }}
                                        @else
                                            {{ number_format($data->uang_makan_nominal * $data->uang_makan_qty) }}
                                        @endif
                                    </td>
                                    <td><input type="text" readonly="true" class="form-control" value="{{ $data->uang_makan_nominal_disetujui }}" ></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="uang_makan_file" />
                                        </div>
                                        @if(!empty($data->uang_makan_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_makan_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" placeholder="Catatan" readonly="true" value="{{ $data->uang_makan_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Daily Allowance</td>
                                    <td>IDR {{ number_format($plafond_dinas->hotel) }}</td>
                                    <td>
                                        <input type="hidden" class="form-control" name="uang_harian_plafond" value="{{ $plafond_dinas->hotel }}" >
                                        <input type="number" class="form-control calculate_2" {{$readonly}} value="{{ $data->uang_harian_nominal }}" name="uang_harian_nominal" placeholder="IDR " >
                                    </td>
                                    <td><input type="number" class="form-control" {{$readonly}} name="uang_harian_qty" value="{{ $data->uang_harian_qty }}" placeholder="QTY" ></td>
                                    <td class="total_pengajuan_harian">
                                        @if(empty($data->uang_harian_qty))
                                            {{ number_format($data->uang_harian_nominal) }}
                                        @else 
                                            {{ number_format($data->uang_harian_nominal * $data->uang_harian_qty ) }}
                                        @endif
                                    </td>
                                    <td><input type="text" readonly="true" class="form-control"  value="{{ $data->uang_harian_nominal_disetujui }}" ></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="uang_harian_file" />
                                        </div>
                                        @if(!empty($data->uang_harian_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_harian_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" placeholder="Catatan" readonly="true" value="{{ $data->uang_harian_catatan }}"></td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: right;">Sub Total</th>
                                    <th colspan="3" class="sub_total_pengajuan">{{ number_format($data->sub_total_2) }}</th>
                                    <th colspan="3">{{ number_format($data->sub_total_2_disetujui) }}</th>
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
                                    <input type="text" name="uang_biaya_lainnya1" {{$readonly}}  class="form-control" placeholder="Other Expense" value="{{ $data->uang_biaya_lainnya1 }}" />
                                </td>
                                <td>
                                    <input type="text" name="uang_biaya_lainnya1_nominal" {{$readonly}}  value="{{ $data->uang_biaya_lainnya1_nominal }}" class="form-control" placeholder="IDR " />
                                </td>
                                <td>
                                    <input type="text" readonly="true" class="form-control" value="{{ $data->uang_biaya_lainnya1_nominal_disetujui }}" {{$readonly}}  placeholder="IDR " />
                                </td>
                                <td>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="uang_biaya_lainnya1_file" />
                                    </div>
                                    @if(!empty($data->uang_biaya_lainnya1_file))
                                    <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya1_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                    @endif
                                </td>`
                                <td>
                                    <input type="text" readonly="true" class="form-control" value="{{ $data->uang_biaya_lainnya1_catatan }}" placeholder="Note" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="uang_biaya_lainnya2" {{$readonly}}  value="{{ $data->uang_biaya_lainnya2 }}" class="form-control" placeholder="Other Expense" />
                                </td>
                                <td>
                                    <input type="text" class="form-control" {{$readonly}}  value="{{ $data->uang_biaya_lainnya2_nominal }}" name="uang_biaya_lainnya2_nominal" placeholder="IDR " />
                                </td>
                                <td>
                                    <input type="text" class="form-control" readonly="true" placeholder="IDR" value="{{ $data->uang_biaya_lainnya2_nominal_disetujui }}" />
                                </td>
                                <td>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="uang_biaya_lainnya2_file" />
                                    </div>
                                    @if(!empty($data->uang_biaya_lainnya2_file))
                                    <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya2_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" readonly="true" value="{{ $data->uang_biaya_lainnya2_catatan }}" class="form-control" placeholder="Note" />
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">Sub Total</th>
                                <th class="sub_total_nominal_lainnya">{{ number_format($data->sub_total_3) }}</th>
                                <th colspan="3" class="total_lain_lain_disetujui">{{ number_format($data->sub_total_3_disetujui) }}</th>
                            </tr>
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
                    <input type="hidden" name="status_actual_bill" value="1">
                    <input type="hidden" name="sub_total_1" value="{{ $data->sub_total_1 }}" />
                    <input type="hidden" name="sub_total_2" value="{{ $data->sub_total_2 }}" />
                    <input type="hidden" name="sub_total_3" value="{{ $data->sub_total_3 }}" />

                    <div class="col-md-12" style="padding-left: 0;">
                        <a href="{{ route('karyawan.training.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
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

        $('.total_transport').html(numberWithComma(val));
        $("input[name='sub_total_1']").val(val);

        calculate_all();
    });

    $("input[name='uang_hotel_nominal'], input[name='uang_hotel_qty'], input[name='uang_makan_nominal'], input[name='uang_makan_qty'], input[name='uang_harian_nominal'], input[name='uang_harian_qty'], input[name='uang_pesawat_qty'], input[name='uang_biaya_lainnya1_nominal'], input[name='uang_biaya_lainnya2_nominal']").on('input', function(){
        calculate_all();
    });

    function calculate_all()
    {
        var val = 0;

        var hotel       = $("input[name='uang_hotel_nominal']").val();
        var hotel_qty   = $("input[name='uang_hotel_qty']").val();

        var makan       = $("input[name='uang_makan_nominal']").val();
        var makan_qty   = $("input[name='uang_makan_qty']").val();

        var harian       = $("input[name='uang_harian_nominal']").val();
        var harian_qty   = $("input[name='uang_harian_qty']").val();

        var nominal_lainnya1    = $("input[name='uang_biaya_lainnya1_nominal']").val();
        var nominal_lainnya2    = $("input[name='uang_biaya_lainnya2_nominal']").val();

        var nominal_lainnya = 0;

        if(nominal_lainnya1 != "")
        {
            nominal_lainnya += parseInt(nominal_lainnya1);
        }

        if(nominal_lainnya2 != "")
        {
            nominal_lainnya += parseInt(nominal_lainnya2);
        }

        $('.sub_total_nominal_lainnya').html(numberWithComma(nominal_lainnya));
        $("input[name='sub_total_3']").val(nominal_lainnya);



        if(hotel != "")
        {   
            if(hotel_qty != "")
            {
                hotel = parseInt(hotel) * parseInt(hotel_qty);
            }

            val += parseInt(hotel);

            $('.total_pengajuan_hotel').html(numberWithComma(hotel));
        }

        if(makan != "")
        {   
            if(makan_qty != "")
            {
                makan = parseInt(makan) * parseInt(makan_qty);
            }

            val += parseInt(makan);

            $('.total_pengajuan_makan').html(numberWithComma(makan));
        }

        if(harian != "")
        {   
            if(harian_qty != "")
            {
                harian = parseInt(harian) * parseInt(harian_qty);
            }

            val += parseInt(harian);

            $('.total_pengajuan_harian').html(numberWithComma(harian));
        }

        $('.sub_total_pengajuan').html(numberWithComma(val));
        $("input[name='sub_total_2']").val(val);


        var total_reimbursement = 0;
        var total_actual_bill = 0;

        if($("input[name='sub_total_1']").val() != "")
        {
            total_reimbursement     += parseInt($("input[name='sub_total_1']").val());   
            total_actual_bill       += parseInt($("input[name='sub_total_1']").val());
        }

        if( $("input[name='sub_total_2']").val() != "")
        {
            total_reimbursement     += parseInt($("input[name='sub_total_2']").val());
            total_actual_bill       += parseInt($("input[name='sub_total_2']").val());
        }

        if( $("input[name='sub_total_3']").val() != "")
        {
            total_reimbursement     += parseInt($("input[name='sub_total_3']").val());
            total_actual_bill       += parseInt($("input[name='sub_total_3']").val());
        }

        {{ !empty($data->pengambilan_uang_muka) ? ' total_reimbursement -='. $data->pengambilan_uang_muka .';' : '' }};


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
