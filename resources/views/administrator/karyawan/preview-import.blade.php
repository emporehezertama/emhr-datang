@extends('layouts.administrator')

@section('title', 'Preview Import Karyawan')

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
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Karyawan</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Preview Import </h3>
                    <a href="{{ route('administrator.karyawan.import-all') }}" onclick="return confirm('Proses semua data ini?')" class="btn btn-info btn-sm">Proses Semua Data</a>
                    <br / >
                    <br / >
                    <br />
                    <div class="table-responsive">
                        <table class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>JOIN DATE</th>
                                    <th>GENDER</th>
                                    <th>NO BPJS KESEHATAN</th>
                                    <th>PLACE OF BIRTH</th>
                                    <th>DATE OF BIRTH</th>
                                    <th>ID ADDRESS</th>
                                    <th>ID CITY</th>
                                    <th>ID ZIP CODE</th>
                                    <th>CURRENT ADDRESS</th>
                                    <th>TELP</th>
                                    <th>MOBILE 1</th>
                                    <th>MOBILE 2</th>
                                    <th>EMAIL</th>
                                    <th>BLOOD TYPE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>
                                            {{ $item->nik }}<br />
                                            <a class="btn btn-info btn-xs" onclick="slide_toogle(this)"><i class="fa fa-info"></i> detail</a>
                                            @if(!empty($item->user_id))
                                            <a href="{{ route('administrator.karyawan.edit', $item->user_id) }}" target="_blank" class="btn btn-warning btn-xs"><i class="fa fa-info"></i> view data yang sama </a>
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->join_date }}</td>
                                        <td>{{ $item->gender }}</td>
                                        <td>{{ $item->no_bpjs_kesehatan }}</td>
                                        <td>{{ $item->place_of_birth }}</td>
                                        <td>{{ $item->date_of_birth }}</td>
                                        <td>{{ $item->id_address }}</td>
                                        <td>{{ $item->id_city }}</td>
                                        <td>{{ $item->id_zip_code }}</td>
                                        <td>{{ $item->current_address }}</td>
                                        <td>{{ $item->telp }}</td>
                                        <td>{{ $item->mobile_1 }}</td>
                                        <td>{{ $item->mobile_2 }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->blood_type }}</td>
                                    </tr>
                                    <tr class="sub_detail" style="display: none;">
                                        <td colspan="18">
                                          <div style="border: 3px solid #dcd1d1;padding:10px;">
                                            <ul class="nav customtab nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#dependent{{ $item->id }}" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Dependent</span></a></li>

                                                <li role="presentation" class=""><a href="#education{{ $item->id }}" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Education</span></a></li>

                                                <li role="presentation" class=""><a href="#department{{ $item->id }}" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Department / Division</span></a></li>

                                                <!-- <li role="presentation" class=""><a href="#rekening_bank{{ $item->id }}" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Data Rekening Bank</span></a></li> -->

                                                <li role="presentation" class=""><a href="#cuti{{ $item->id }}" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Cuti</span></a></li>
                                            </ul>
                                            <div class="tab-content">

                                                <div role="tabpanel" class="tab-pane fade active in" id="dependent{{ $item->id }}">
                                                     <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Relationship</th>
                                                                <th>Relative Name</th>
                                                                <th>Gender</th>
                                                                <th>City</th>
                                                                <th>Date of Birth</th>
                                                                <th>Occupation</th>
                                                                <th>Note</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($item->family as $no => $i)
                                                            <tr>
                                                                <td>{{ $no+1 }}</td>
                                                                <td>{{ $i->hubungan  }}</td>
                                                                <td>{{ $i->nama  }}</td>
                                                                <td>{{ $i->gender  }}</td>
                                                                <td>{{ $i->city  }}</td>
                                                                <td>{{ $i->tanggal_lahir  }}</td>
                                                                <td>{{ $i->pekerjaan  }}</td>
                                                                <td>{{ $i->note  }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <br />
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="education{{ $item->id }}">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Education</th>
                                                                <th>Start Year</th>
                                                                <th>End Year</th>
                                                                <th>Institution</th>
                                                                <th>City</th>
                                                                <th>Major</th>
                                                                <th>GPA</th>
                                                                <th>Certificate</th>
                                                                <th>Note</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($item->education as $no => $i)
                                                            <tr>
                                                                <td>{{ $no+1 }}</td>
                                                                <td>{{ $i->pendidikan }}</td>
                                                                <td>{{ $i->tahun_awal }}</td>
                                                                <td>{{ $i->tahun_akhir }}</td>
                                                                <td>{{ $i->fakultas }}</td>
                                                                <td>{{ $i->kota }}</td>
                                                                <td>{{ $i->jurusan }}</td>
                                                                <td>{{ $i->nilai }}</td>
                                                                <td>{{ $i->certificate }}</td>
                                                                <td>{{ $i->note }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div role="tabpanel" class="tab-pane fade" id="department{{ $item->id }}">
                                                     <table class="table table-bordered">
                                                        <tr>
                                                            <td>Direktur</td>
                                                            <td>{{ isset($item->direktur->name) ? $item->direktur->name : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Manager</td>
                                                            <td>{{ isset($item->manager->name) ? $item->manager->name  : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Staff</td>
                                                            <td>{{ isset($item->staff->name) ? $item->staff->name : '' }}</td>
                                                        </tr>
                                                     </table>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="rekening_bank{{ $item->id }}">

                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="cuti{{ $item->id }}">
                                                     <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Join Date</th>
                                                                <th>Length of Service</th>
                                                                <th>Status</th>
                                                                <th>Cuti 2018</th>
                                                                <th>Cuti Terpakai</th>
                                                                <th>Sisa Cuti</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>{{ $item->cuti_join_date}}</td>
                                                                <td>{{ $item->length_of_service}}</td>
                                                                <td>{{ $item->status}}</td>
                                                                <td>{{ $item->cuti_2018}}</td>
                                                                <td>{{ $item->cuti_terpakai}}</td>
                                                                <td>{{ $item->cuti_sisa_cuti}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <br />
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <br />
                                            <br />
                                          </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
@section('footer-script')
<!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
<script type="text/javascript">
    function slide_toogle(el)
    {
        $(el).parent().parent().next().slideToggle();
    }
</script>
@endsection

@endsection
