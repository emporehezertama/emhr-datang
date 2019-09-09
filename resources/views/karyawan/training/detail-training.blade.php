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
            <form class="form-horizontal" id="form-training" enctype="multipart/form-data" action="{{ route('karyawan.approval.training-atasan.proses') }}" method="POST">
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
                        </ul>

                        <div class="tab-content">

                            
                            <div role="tabpanel" class="tab-pane fade in active" id="kegiatan">
                                <h4>Form Activity</h4>
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
                                        <div class="col-md-6 select-cabang" style="{{  $data->jenis_training != 'Branch Visit' ? 'display: none;' : '' }}">
                                            <select class="form-control" name="cabang_id" readonly>
                                                <option value="">Choose Branch Location </option>
                                                @foreach(get_cabang() as $item)
                                                <option {{ $item->id == $data->cabang_id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                    @if($data->pengambilan_uang_muka != "")
                                    <hr />
                                    <h4><b>Cash Advance</b></h4>
                                    <div class="col-md-12" style="border: 1px solid #eee; padding: 15px">
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
                                                <input type="text" readonly class="form-control datepicker" name="tanggal_penyelesain" value="{{ date('Y-m-d', strtotime($data->tanggal_pengajuan .' +10 day')) }}" />
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="clearfix"></div><br />
                                    <hr />
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="pesawat">
                                <h4>Form Booking</h4>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Choose Route</label>
                                    <div class="col-md-6">
                                        <label style="font-weight: normal;">
                                            <input type="radio" readonly="true" {{ $data->pesawat_perjalanan == 'Sekali Jalan' ? 'checked' : '' }} name="pesawat_perjalanan" value="Sekali Jalan"> One Way
                                        </label> &nbsp;&nbsp;
                                        <label style="font-weight: normal;">
                                            <input type="radio" readonly="true" {{ $data->pesawat_perjalanan == 'Pulang Pergi' ? 'checked' : '' }} name="pesawat_perjalanan" value="Pulang Pergi"> Round Trip
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

                                    <div class="col-md-2"><input type="text" placeholder="Return Date" name="tanggal_pulang" class="form-control datepicker" readonly value="{{ $data->tanggal_pulang }}">
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

                                <div class="form-group">
                                    <label class="col-md-12">Business Trip Partner</label>
                                    <div class="col-md-8"> 
                                        <input type="text" class="form-control" value="{{ $data->pergi_bersama }}" readonly="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Note</label>
                                    <div class="col-md-8"> 
                                        <input type="text" class="form-control" value="{{ $data->note }}" readonly="true" />
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <input type="hidden" name="status" value="0" />
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('karyawan.training.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
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
