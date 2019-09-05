@extends('layouts.karyawan')

@section('title', 'Profile')

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
                <h4 class="page-title">HOME</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Home</a></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-4">
                <div class="panel">
                    <div class="p-30">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4">
                                @if(empty(Auth::user()->foto))
                                <img src="{{ asset('admin-css/images/user.png') }}" alt="varun" class="img-circle img-responsive">
                                @else
                                <img src="{{ asset('storage/foto/'. Auth::user()->foto) }}" alt="varun" class="img-circle img-responsive">
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <h2 class="m-b-0">{{ Auth::user()->name }}</h2>
                                <h4>{{ empore_jabatan(Auth::user()->id) }}</h4>
                                <a class="btn btn-info btn-xs" id="change_password">Change Password <i class="fa fa-key"></i></a>
                                @if(Auth::user()->last_change_password !== null) 
                                    <p>Last Update :  {{ date('d F Y H:i', strtotime(Auth::user()->last_change_password)) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-20 text-center">
                        <table class="table table-hover">
                            <tr>
                                <th>NIK</th>
                                <th> : {{ Auth::user()->nik }}</th>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th> : {{ Auth::user()->email }}</th>
                            </tr>
                            <tr>
                                <th>Place of birth</th>
                                <th> : {{ Auth::user()->tempat_lahir }}</th>
                            </tr>
                            <tr>
                                <th>Date of birth</th>
                                <th> : {{ Auth::user()->tanggal_lahir }}</th>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <th> : {{ Auth::user()->jenis_kelamin }}</th>
                            </tr>
                            <tr>
                                <th>Religion</th>
                                <th> : {{ Auth::user()->agama }}</th>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-8 col-sm-12">
                <div class="white-box">
                    <div class="panel">
                         <ul class="nav customtab nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#dependent" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Dependent</span></a></li>                            
                            <li role="presentation" class=""><a href="#education" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Education</span></a></li>
                            <li role="presentation" class=""><a href="#department" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Department / Division</span></a></li>
                            <li role="presentation" class=""><a href="#rekening_bank" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Bank Account</span></a></li>
                            <li role="presentation" class=""><a href="#inventaris" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Inventory</span></a></li>
                            <li role="presentation" class=""><a href="#cuti" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Leave</span></a></li>
                            <li role="presentation" class=""><a href="#absensi" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Attendance</span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade" id="inventaris" style="overflow: auto;">
                                <table class="table table-bordered">
                                     <thead>
                                    <tr>
                                        <th width="70" class="text-center">#</th>
                                        <th>ASSET NUMBER</th>
                                        <th>ASSET NAME</th>
                                        <th>ASSET TYPE</th>
                                        <th>SERIAL/PLAT NUMBER</th>
                                        <th>PURCHASE/RENTAL DATE</th>
                                        <th>ASSET CONDITION</th>
                                        <th>STATUS ASSET</th>
                                        <th>PIC</th>
                                        <th>HANDOVER DATE</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->assets as $no => $item)
                                        <tr>
                                            <td class="text-center">{{ $no+1 }}</td>   
                                            <td>{{ $item->asset_number }}</td>
                                            <td>{{ $item->asset_name }}</td>
                                            <td>{{ isset($item->asset_type->name) ? $item->asset_type->name : ''  }}</td>
                                            <td>{{ $item->asset_sn }}</td>
                                            <td>{{ format_tanggal($item->purchase_date) }}</td>
                                            <td>{{ $item->asset_condition }}</td>
                                            <td>{{ $item->assign_to }}</td>
                                            <td>{{ isset($item->user->name) ? $item->user->name : '' }}</td>
                                            <td>{{ $item->handover_date != "" ?  format_tanggal($item->handover_date) : '' }}</td>
                                            <td>
                                                @if($item->handover_date === NULL)
                                                    <label class="btn btn-warning btn-xs">Waiting Acceptance</label>
                                                @endif

                                                @if($item->handover_date !== NULL)
                                                    <label class="btn btn-success btn-xs">Accepted</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                <br />
                            </div>
                            

                            <div role="tabpanel" class="tab-pane fade" id="absensi">
                                <h3 class="box-title m-b-0">Attendance</h3>
                                <table class="table">
                                    <thead class="header" >
                                        <tr>
                                            <th rowspan="2" style="padding: 3px 5px;vertical-align: middle;text-align:center;">Date</th>
                                            <th rowspan="2" style="padding: 3px 5px;vertical-align: middle;text-align:center;">Day</th>
                                            <th colspan="2" style="padding: 3px 5px;vertical-align: middle;text-align:center;">Clock</th>
                                            <th rowspan="2" style="padding: 3px 5px;vertical-align: middle;text-align:center;">Late CLOCK In</th>
                                            <th rowspan="2" style="padding: 3px 5px;vertical-align: middle;text-align:center;">Early CLOCK Out</th>
                                            <th rowspan="2" style="padding: 3px 5px;vertical-align: middle;text-align:center;">Duration</th>
                                        </tr>
                                        <tr>
                                            <th style="padding: 3px 5px;vertical-align: middle;text-align:center;">In</th>
                                            <th style="padding: 3px 5px;vertical-align: middle;text-align:center;">Out</th>
                                        </tr>
                                    </thead>
                                    <tbody class="no-padding-td">
                                        @foreach($absensi as $item)
                                        <tr>
                                            <td><?php echo substr($item->date, 0, 10) ?></td>
                                            <td>{{ $item->timetable }}</td>
                                            <td>
                                                @if(!empty($item->long) || !empty($item->lat) || !empty($item->pic)) 
                                                    <a href="javascript:void(0)" data-title="Clock In <?=date('d F Y', strtotime($item->date))?> <?=$item->clock_in?>" data-long="<?=$item->long?>" data-lat="<?=$item->lat?>" data-pic="<?=asset('upload/attendance/'.$item->pic)?>" data-time="<?=$item->clock_in?>" onclick="detail_attendance(this)" title="Mobil Attendance"> {{ $item->clock_in }}</a> 
                                                    <i title="Mobile Attendance" class="fa fa-mobile pull-right" style="font-size: 20px;"></i>
                                                @else
                                                    {{ $item->clock_in }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($item->long_out) || !empty($item->lat_out) || !empty($item->pic_out))
                                                    
                                                    <a href="javascript:void(0)" data-title="Clock Out  <?=date('d F Y', strtotime($item->date))?> <?=$item->clock_out?>" data-long="<?=$item->long_out?>" data-lat="<?=$item->lat_out?>" data-pic="<?=asset('upload/attendance/'.$item->pic_out)?>" data-time="<?=$item->clock_out?>" onclick="detail_attendance(this)" title="Mobil Attendance"> {{ $item->clock_out }}</a>
                                                    <i title="Mobile Attendance" class="fa fa-mobile pull-right" style="font-size: 20px;"></i>
                                                @else
                                                    {{ $item->clock_out }}
                                                @endif
                                            </td>
                                            <td>{{ $item->late }}</td>   
                                            <td>{{ $item->early }}</td>    
                                            <td>{{ $item->work_time }}</td> 
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br />
                            </div>

                            


                            <div role="tabpanel" class="tab-pane fade" id="cuti">
                                <h3 class="box-title m-b-0">Leave / Permit</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Leave / Permit Type</th>
                                            <th>Quota</th>
                                            <th>Leave Taken</th>
                                            <th>Leave Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_cuti">
                                        @foreach(Auth::user()->cuti as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ isset($item->cuti->jenis_cuti) ? $item->cuti->jenis_cuti : '' }}</td>
                                            <td>{{ $item->kuota }}</td>
                                            <td>{{ $item->cuti_terpakai }}</td>
                                            <td>{{ $item->sisa_cuti }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br />
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="rekening_bank">
                                <div class="form-group">
                                    <label class="col-md-12">Name of Account</label>
                                    <div class="col-md-6">
                                        <input type="text" name="nama_rekening" class="form-control" readonly="true" value="{{ $data->nama_rekening }}"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Account Number</label>
                                    <div class="col-md-6">
                                       <input type="text" name="nomor_rekening" class="form-control"  readonly="true" value="{{ $data->nomor_rekening }}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Name of Bank</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="bank_id" readonly="true">
                                            <option value="">Pilih Bank</option>
                                            @foreach(get_bank() as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $data->bank_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="department">
                                @if(get_setting('struktur_organisasi') == 3)
                                <div class="form-group">
                                    <label class="col-md-12">Position</label>
                                    <div class="col-md-6">
                                       <input type="text" name="position" class="form-control"  readonly="true" value="{{ isset($data->structure->position->name) ? $data->structure->position->name : '' }}" />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-md-12">Division</label>
                                    <div class="col-md-6">
                                       <input type="text" name="division" class="form-control"  readonly="true" value="{{ isset($data->structure->division) ? $data->structure->division->name:'' }}" />
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <label class="col-md-12">Branch Type</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="branch_type" readonly="true">
                                            <option value=""> - none - </option>
                                            @foreach(['HO', 'BRANCH'] as $item)
                                            <option {{ $data->branch_type == $item ? ' selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                               
                                <div class="form-group section-cabang" style="{{ $data->branch_type == "HO" ? 'display:none' : ''  }}">
                                    <label class="col-md-12">Branch</label>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6">
                                        <select class="form-control" name="cabang_id" readonly="true">
                                            <option value="">Choose Branch</option>
                                            @foreach(get_cabang() as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $data->cabang_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                    <div class="clearfix" /></div>
                                    <br class="clearfix" />
                                    <br>
                                    <div class="col-md-12">
                                        <label><input type="checkbox" name="is_pic_cabang" value="1" {{ $data->is_pic_cabang == 1 ? 'checked' : '' }}> Branch PIC</label>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr />
                                </div>

                                <div class="section-ho">
                                    <div class="form-group">
                                        <label class="col-md-12">Division</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="division_id" readonly="true">
                                                <option value="">Choose Division</option>
                                                @foreach(get_organisasi_division() as $item)
                                                <option value="{{ $item->id }}" {{ $data->division_id == $item->id ? 'selected' : '' }} >{{ $item->name }}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Department</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="department_id" readonly="true">
                                                <option value="">Choose Department</option>
                                                @foreach(get_organisasi_department($data->division_id) as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $data->department_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Unit / Section</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="section_id" readonly="true">
                                                <option value="">Choose Section</option>
                                                @foreach(get_organisasi_unit() as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $data->section_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Position</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="organisasi_position" readonly="true">
                                               @foreach(get_organisasi_position($data->section_id) as $item)
                                                <option {{ $item->id == $data->organisasi_position ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Job Rule</label>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" value="{{ $data->organisasi_job_role }}" name="organisasi_job_role" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        
                            <div role="tabpanel" class="tab-pane fade in active" id="dependent">
                                <h3 class="box-title m-b-0">Dependent</h3>
                                <br />
                                <br />
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Relationship</th>
                                                <th>Place of birth</th>
                                                <th>Date of birth</th>
                                                <th>Date of death</th>
                                                <th>Education level</th>
                                                <th>Occupation</th>
                                            </tr>
                                        </thead>
                                        <tbody class="dependent_table">
                                            @foreach($data->userFamily as $no => $item)
                                            <tr>
                                                <td>{{ $no+1 }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->hubungan }}</td>
                                                <td>{{ $item->tempat_lahir }}</td>
                                                <td>{{ $item->tanggal_lahir }}</td>
                                                <td>{{ $item->tanggal_meninggal }}</td>
                                                <td>{{ $item->jenjang_pendidikan }}</td>
                                                <td>{{ $item->pekerjaan }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                             <div role="tabpanel" class="tab-pane fade" id="education">
                                <h3 class="box-title m-b-0">Education</h3>
                                <br />
                                <br />
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Education</th>
                                                <th>Year of Start</th>
                                                <th>Year of Graduate</th>
                                                <th>School Name</th>
                                                <th>Major</th>
                                                <th>Grade</th>
                                                <th>City</th>
                                            </tr>
                                        </thead>
                                        <tbody class="education_table">
                                            @foreach($data->userEducation as $no => $item)
                                            <tr>
                                                <td>{{ $no+1 }}</td>
                                                <td>{{ $item->pendidikan }}</td>
                                                <td>{{ $item->tahun_awal }}</td>
                                                <td>{{ $item->tahun_akhir }}</td>
                                                <td>{{ $item->fakultas }}</td>
                                                <td>{{ $item->jurusan }}</td>
                                                <td>{{ $item->nilai }}</td>
                                                <td>{{ $item->kota }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br /><br />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div><br />
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
</div>
<style type="text/css">
    .col-in h3 {
        font-size: 20px;
    }
</style>


@section('footer-script')
     <div class="modal fade" id="modal_reset_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form>
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="exampleModalLabel1">Reset Password !</h4> 
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Password:</label>
                        <input type="password" name="password"class="form-control" placeholder="Password"> 
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Konfirmasi Password:</label>
                        <input type="password" name="confirm"class="form-control" placeholder="Konfirmasi Password"> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="submit_password">Submit Password <i class="fa fa-arrow-right"></i></button>
                </div>
              </form>
            </div>
        </div>
    </div> 

    <script type="text/javascript">
    

        $("#change_password").click(function(){

            $("#modal_reset_password").modal("show");

        });

        $("#submit_password").click(function(){

            var password    = $("input[name='password']").val();
            var confirm     = $("input[name='confirm']").val();

            if(password == "" || confirm == "")
            {
                bootbox.alert('Password atau Konfirmasi Password harus diisi !');
                return false;
            }

            if(password != confirm)
            {
                bootbox.alert('Password tidak sama');
            }
            else
            {
                 $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.update-first-password') }}',
                    data: {'id' : {{ Auth::user()->id }}, 'password' : password, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {
                        location.reload();
                    }
                });
            }
        });
    </script>
@endsection

@endsection
