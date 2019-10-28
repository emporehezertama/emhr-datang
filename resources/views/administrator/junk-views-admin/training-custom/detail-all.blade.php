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
            <form class="form-horizontal" id="form-training" enctype="multipart/form-data" action="{{ route('administrator.approval.training-atasan.proses') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Form Business Trip</h3>
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
                        
                        <ul class="nav customtab nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#kegiatan" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Activity</span></a></li>

                            <li role="presentation" class=""><a href="#pesawat" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Trip by Plane</span></a></li>
                            <li role="presentation" class=""><a href="#biaya" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Cost Calculation</span></a></li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane fad" id="biaya">
                                <h4>Actual Bill</h4>
                                <hr />
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
                                            <td><input placeholder="IDR"  type="number" class="form-control" name="transportasi_ticket_disetujui" value="{{ $data->transportasi_ticket_disetujui }}"  readonly="true"></td>
                                            <td>
                                                @if(!empty($data->transportasi_ticket_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_ticket_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" class="form-control" name="transportasi_ticket_catatan" value="{{ $data->transportasi_ticket_catatan }}"  readonly="true"></td>
                                        </tr>
                                        <tr>
                                            <td>Taxi</td>
                                            <td><input placeholder="IDR" type="number" class="form-control" readonly="true" name="transportasi_taxi" value="{{ $data->transportasi_taxi }}" ></td>
                                            <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_taxi_disetujui" value="{{ $data->transportasi_taxi_disetujui }}" readonly="true"></td>
                                            <td>
                                                @if(!empty($data->transportasi_taxi_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_taxi_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" class="form-control" name="transportasi_taxi_catatan" readonly="true" value="{{ $data->transportasi_taxi_catatan }}" ></td>
                                        </tr>
                                        <tr>
                                            <td>Gasoline</td>
                                            <td><input placeholder="IDR"  type="number" class="form-control" name="transportasi_gasoline" value="{{ $data->transportasi_gasoline }}" readonly="true" ></td>
                                            <td><input placeholder="Rp" type="number" class="form-control" name="transportasi_gasoline_disetujui" value="{{ $data->transportasi_gasoline_disetujui }}" readonly="true"></td>
                                            <td>
                                                @if(!empty($data->transportasi_gasoline_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_gasoline_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" name="transportasi_gasoline_catatan" readonly="true" class="form-control" /></td>
                                        </tr>
                                        <tr>
                                            <td>Tol</td>
                                            <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_tol" value="{{ $data->transportasi_tol }}" readonly="true" ></td>
                                            <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_tol_disetujui" value="{{ $data->transportasi_tol_disetujui }}" ></td>
                                            <td>
                                                @if(!empty($data->transportasi_tol_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_tol_file)  }}')" class="btn btn-info btn-xs" readonly="true"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" class="form-control" name="transportasi_tol_catatan" readonly="true" value="{{ $data->tranportasi_tol_catatan }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Parking</td>
                                            <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_parkir" value="{{ $data->transportasi_parkir }}" readonly="" ></td>
                                            <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_parkir_disetujui" value="{{ $data->transportasi_parkir_disetujui }}" readonly="true"></td>
                                            <td>
                                                @if(!empty($data->transportasi_parkir_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_parkir_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" class="form-control" name="transportasi_parkir_catatan" readonly="true" value="{{ $data->transportasi_parkir_catatan }}"></td>
                                        </tr>
                                        <tr>
                                            <th>Sub Total</th>
                                            <th class="total_transport">Rp. {{ $total_transportasi_nominal }}</th>
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
                                        @foreach(plafond_perjalanan_dinas(\Auth::user()->organisasiposition->name) as $item)
                                        <tr>
                                            <td>Hotel</td>
                                            <td>
                                                IDR {{ number_format($item->hotel) }}
                                                <input type="hidden" name="uang_hotel_plafond" value="{{ $item->hotel }}">
                                            </td>
                                            <td><input type="number" class="form-control" name="uang_hotel_nominal" placeholder="IDR " value="{{ $data->uang_hotel_nominal }}" readonly="true" ></td>
                                            <td><input type="number" class="form-control" placeholder="AMOUNT" name="uang_hotel_qty"  value="{{ $data->uang_hotel_qty }}" readonly="true"></td>
                                            <td>{{ $data->uang_hotel_nominal * $data->uang_hotel_qty }}</td>
                                            <td><input type="text" name="uang_hotel_nominal_disetujui"  readonly="true" value="{{ $data->uang_hotel_nominal_disetujui }}" class="form-control"></td>
                                            <td>
                                                @if(!empty($data->uang_hotel_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_hotel_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" class="form-control" placeholder="Catatan" readonly="true" name="uang_hotel_catatan" value="{{ $data->uang_hotel_catatan }}"></td>
                                        </tr>

                                        <tr>
                                            <td>Meal Allowance</td>
                                            <td>IDR {{ number_format($item->tunjangan_makanan) }}</td>
                                            <td>
                                                <input type="hidden" class="form-control" name="uang_makan_plafond" value="{{ $item->tunjangan_makan }}" >
                                                <input type="number" class="form-control" name="uang_makan_nominal" value="{{ $data->uang_makan_nominal }}" placeholder="Rp. " readonly="" >
                                            </td>
                                            <td><input type="number" class="form-control" value="{{ $data->uang_makan_qty }}" name="uang_makan_qty" readonly="true" placeholder="AMOUNT" ></td>
                                            <td>{{ $data->uang_makan_nominal * $data->uang_makan_qty }}</td>
                                            <td><input type="text" name="uang_makan_nominal_disetujui" value="{{ $data->uang_makan_nominal_disetujui }}" class="form-control" readonly="true"></td>
                                            <td>
                                                @if(!empty($data->uang_makan_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_makan_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" class="form-control" placeholder="Note" name="uang_makan_catatan" value="{{ $data->uang_makan_catatan }}" readonly="true"></td>
                                        </tr>
                                        <tr>
                                            <td>Daily Allowance</td>
                                            <td>IDR {{ number_format($item->hotel) }}</td>
                                            <td>
                                                <input type="hidden" class="form-control" name="uang_harian_plafond" value="{{ $item->hotel }}" >
                                                <input type="number" class="form-control" value="{{ $data->uang_harian_nominal }}" name="uang_harian_nominal" placeholder="IDR " readonly="true" >
                                            </td>
                                            <td><input type="number" class="form-control" name="uang_harian_qty" value="{{ $data->uang_harian_qty }}" placeholder="AMOUNT" readonly="true" ></td>
                                            <td>{{ $data->uang_harian_nominal * $data->uang_harian_qty }}</td>
                                            <td><input type="text" class="form-control" name="uang_harian_nominal_disetujui" readonly="true"></td>
                                            <td>
                                                @if(!empty($data->uang_harian_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_harian_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" class="form-control" placeholder="Catatan" name="uang_harian_catatan" value="{{ $data->uang_harian_catatan }}" readonly="true"></td>
                                        </tr>
                                        <tr>
                                            <td>Plane</td>
                                            <td>{{ $item->pesawat }}</td>
                                            <td>
                                                <input type="hidden" class="form-control" name="uang_pesawat_plafond" value="{{ $item->pesawat }}" >
                                                <input type="number" class="form-control" value="{{ $data->uang_pesawat_nominal }}"å name="uang_pesawat_nominal" placeholder="IDR " readonly="true" >
                                            </td>
                                            <td><input type="number" class="form-control" name="uang_pesawat_qty" value="{{ $data->uang_pesawat_qty }}" placeholder="AMOUNT" readonly="true" ></td>
                                            <td>{{ $data->uang_pesawat_nominal * $data->uang_pesawat_qty }}</td>
                                            <td><input type="text" name="uang_pesawat_nominal_disetujui" class="form-control" readonly="true"></td>
                                            <td>
                                                @if(!empty($data->uang_pesawat_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_pesawat_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td><input type="text" class="form-control" placeholder="Catatan" name="uang_pesawat_catatan" value="{{ $data->uang_pesawat_catatan }}" readonly="true"></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th>Sub Total</th>
                                            <th></th>
                                            <th>{{ $total_hotel_nominal }}</th>
                                            <th>{{ $total_hotel_qty }}</th>
                                            <th>{{ $total_hotel_nominal_dan_qty }}</th>
                                        </tr>
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
                                                <input type="text" name="uang_biaya_lainnya1_nominal" value="{{ $data->uang_biaya_lainnya1_nominal }}" class="form-control" placeholder="IDR " readonly="true" />
                                            </td>
                                            <td>
                                                <input type="text" name="uang_biaya_lainnya1_nominal_disetujui" value="{{ $data->uang_biaya_lainnya1_nominal_disetujui }}"  class="form-control" readonly="true" placeholder="IDR " />
                                            </td>
                                            <td>
                                                @if(!empty($data->uang_biaya_lainnya1_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya1_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="uang_biaya_lainnya1_catatan" value="{{ $data->uang_biaya_lainnya1_catatan }}" placeholder="Note" readonly="true" />
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
                                                <input type="text" class="form-control" name="uang_biaya_lainnya2_nominal_disetujui" value="{{ $data->uang_biaya_lainnya2_nominal_disetujui }}" readonly="true" placeholder="IDR" />
                                            </td>
                                            <td>
                                                @if(!empty($data->uang_biaya_lainnya2_file))
                                                <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya2_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" name="uang_biaya_lainnya2_catatan" value="{{ $data->uang_biaya_lainnya2_catatan }}" class="form-control" readonly="true" placeholder="Note" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Sub Total</th>
                                        </tr>

                                        <tr>
                                            <th colspan="6">Total Actual Bill</th>
                                        </t>
                                        <tr>
                                            <th colspan="6">Cash Advance</th>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Total Reimbursement</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in active" id="kegiatan">
                                <h4>Form Kegiatan</h4>
                                <hr />
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6">Business Trip Type</label>
                                        <label class="col-md-6 select-cabang" style="display: none;">Branch Location</label>
                                        <div class="clearfix"></div>
                                        <div class="col-md-6">
                                            <select name="jenis_training" readonly class="form-control">
                                                <option value="">Choose Business Trip Type</option>
                                                @foreach(jenis_perjalanan_dinas() as $item)
                                                <option {{ $item == $data->jenis_training ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 select-cabang" style="{{ $data->jenis_traning != 'Branch Visit' ? 'display: none;' : '' }} ">
                                            <select class="form-control" name="cabang_id" readonly>
                                                <option value="">Choose Branch Location </option>
                                                @foreach(get_cabang() as $item)
                                                <option {{ $item->id == $data->cabang_id ? 'selected' : '' }}>{{ $item->name .' - '. $item->alamat  }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Activity Location</label>
                                        <div class="col-md-12">
                                            <label style="font-weight: normal;margin-right: 10px;">
                                                <input type="radio" name="lokasi_kegiatan" value="Dalam Negeri" {{ $data->lokasi_kegiatan == 'Dalam Negeri'  ? 'checked' : '' }}> Local
                                            </label>

                                            <label style="font-weight: normal;">
                                                <input type="radio" name="lokasi_kegiatan" value="Luar Negeri" {{ $data->lokasi_kegiatan == 'Luar Negeri' ? 'checked' : '' }}> Abroad
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Destination</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" readonly name="tempat_tujuan" value="{{ $data->tempat_tujuan }}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Activity Topic</label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" readonly name="topik_kegiatan">{{ $data->topik_kegiatan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Activity Date</label>
                                        <div class="col-md-6">
                                            <input type="text" name="tanggal_kegiatan_start" class="form-control datepicker" placeholder="From Date" readonly value="{{ $data->tanggal_kegiatan_start}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="tanggal_kegiatan_end" class="form-control datepicker" placeholder="To Date" readonly value="{{ $data->tanggal_kegiatan_end  }}">
                                        </div>
                                    </div>
                                    <div style="{{ empty($data->pengambilan_uang_muka) ? 'display: none' : '';  }}">
                                        <div class="form-group">
                                            <label class="col-md-12">Cash Advance Collection (IDR)</label>
                                            <div class="col-md-6">
                                                <input type="text" readonly class="form-control" name="pengambilan_uang_muka" value="{{ !empty($data->pengambilan_uang_muka) ? number_format($data->pengambilan_uang_muka) : '' }}" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6">Request Date</label>
                                            <label class="col-md-6">Settlement Date</label>
                                            <div class="col-md-6">
                                                <input type="text" readonly class="form-control datepicker" value="{{ $data->tanggal_pengajuan }}" name="tanggal_pengajuan" />
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" readonly class="form-control datepicker" name="tanggal_penyelesain" value="{{ $data->tanggal_penyelesain }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="pesawat">
                                <h4>Form Booking</h4>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Choose Route</label>
                                    <div class="col-md-6">
                                        <label style="font-weight: normal;">
                                            <input type="radio" {{ $data->pesawat_perjalanan == 'Sekali Jalan' ? 'checked' : '' }} name="pesawat_perjalanan" value="Sekali Jalan"> One Way
                                        </label> &nbsp;&nbsp;
                                        <label style="font-weight: normal;">
                                            <input type="radio" {{ $data->pesawat_perjalanan == 'Sekali Jalan' ? 'checked' : '' }} name="pesawat_perjalanan" value="Pulang Pergi"> Round Trip
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Date / Time</label>
                                    <div class="col-md-2">
                                        <input type="text" placeholder="Departure Date" value="{{ $data->tanggal_berangkat }}" name="tanggal_berangkat" readonly class="form-control datepicker">
                                    </div>
                                    <div style="float: left; width: 5px;padding-top:10px;"> / </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control time_picker" value="{{ $data->waktu_berangkat }}" placeholder="Time" readonly name="waktu_berangkat" />
                                    </div>
                                    <div style="float: left; width: 5px;padding-top:10px;"> - </div>

                                    <div class="col-md-2"><input type="text" placeholder="Return Date" name="tanggal_pulang" class="form-control datepicker" readonly value="{{ $data->tanggal_pulangn }}">
                                    </div>
                                    <div style="float: left; width: 5px;padding-top:10px;"> / </div>
                                     <div class="col-md-1">
                                        <input type="text" class="form-control time_picker" value="{{ $data->waktu_pulang }}" placeholder="Time" readonly name="waktu_pulang" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">From Airport</label>
                                    <label class="col-md-3">To Airport</label>
                                    <div class="clearfix"></div>
                                    <div class="col-md-3">
                                        <input type="text" name="pesawat_rute_dari" value="{{ $data->pesawat_rute_dari }}" class="form-control" readonly id="rute_dari" placeholder="From">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="pesawat_rute_tujuan" value="{{ $data->pesawat_rute_tujuan }}"  class="form-control" readonly id="rute_tujuan" placeholder="To">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Passenger Information</label>
                                    <div class="col-md-6">
                                        <table class="table table-bordered custome_table">
                                            <thead>
                                                <tr>
                                                    <th>NIK</th>
                                                    <th>KTP Number</th>
                                                    <th>Passport Number</th>
                                                    <th>Gender</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-penumpang">
                                                <tr>
                                                    <td>{{ $data->user->name .' / '. $data->user->nik }}</td>
                                                    <td>{{ $data->user->ktp_number }}</td>
                                                    <td>{{ $data->user->passport_number }}</td>
                                                    <td>{{ $data->user->jenis_kelamin }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2">Class</label>
                                    <label class="col-md-10">Airline</label>
                                    <div class="col-md-2">
                                        <label style="font-weight: normal;">
                                            <input type="radio" name="pesawat_kelas" value="Ekonomi" {{ $data->pesawat_kelas == 'Ekonomi' ? 'checked' : '' }} /> Economy 
                                        </label> 
                                        <label style="font-weight: normal;">
                                            <input type="radio" name="pesawat_kelas" value="Bisnis"  {{ $data->pesawat_kelas == 'Bisnis' ? 'checked' : '' }}/> Business 
                                        </label> 
                                    </div>
                                    <div class="col-md-6"> 
                                        <input type="text" readonly class="form-control" name="pesawat_maskapai" value="{{ $data->pesawat_maskapai }}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="status" value="0" />
                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="col-md-12" style="padding-left: 0;">
                            <a href="{{ route('administrator.approval.training-atasan.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
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
</style>

@section('footer-script')
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
@endsection
