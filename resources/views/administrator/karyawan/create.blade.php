@extends('layouts.administrator')

@section('title', 'Karyawan')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Karyawan</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10 pull-right" onclick="document.getElementById('form-karyawan').submit()"><i class="fa fa-save"></i> Save Employee Data </button>
            </div>
        </div>
    <div class="row">
        <form class="form-horizontal" enctype="multipart/form-data" id="form-karyawan" action="{{ route('administrator.karyawan.store') }}" method="POST">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
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
                    <ul class="nav customtab nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#biodata" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Biodata</span></a></li>

                        <li role="presentation" class=""><a href="#dependent" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Dependent</span></a></li>
                        
                        <li role="presentation" class=""><a href="#education" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Education</span></a></li>

                        <li role="presentation" class=""><a href="#department" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Department / Division</span></a></li>

                        <li role="presentation" class=""><a href="#rekening_bank" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Bank Account</span></a></li>

                         <li role="presentation" class=""><a href="#inventaris" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Inventaris</span></a></li>

                        <li role="presentation" class=""><a href="#cuti" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Leave</span></a></li>
                        
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="cuti">
                            <h3>Leave</h3>
                            <a class="btn btn-info btn-xs" id="add_cuti"><i class="fa fa-plus"></i> Add</a>
                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Leave Type</th>
                                            <th>Quota</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_cuti"></tbody>
                                </table>
                                <br />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="inventaris">
                            <h3>Mobil</h3>
                            <a class="btn btn-info btn-xs" id="add_inventaris_mobil"><i class="fa fa-plus"></i> Tambah</a>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipe Mobil</th>
                                        <th>Tahun</th>
                                        <th>No Polisi</th>
                                        <th>Status Mobil</th>
                                    </tr>
                                </thead>
                                <tbody class="table_mobil"></tbody>
                            </table>
                            <br />
                            <h3>Lainnya</h3>
                            <a class="btn btn-info btn-xs" id="add_inventaris_lainnya"><i class="fa fa-plus"></i> Tambah</a>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Inventaris</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="table_inventaris_lainnya"></tbody>
                            </table><br />
                        </div> 
                        <div role="tabpanel" class="tab-pane fade" id="rekening_bank">
                            <div class="form-group">
                                <label class="col-md-12">Name of Account</label>
                                <div class="col-md-6">
                                    <input type="text" name="nama_rekening" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Account Number</label>
                                <div class="col-md-6">
                                   <input type="text" name="nomor_rekening" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Name of Bank</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="bank_id">
                                        <option value="">Choose Bank</option>
                                        @foreach(get_bank() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                        <div role="tabpanel" class="tab-pane fade" id="department">
                            @if(get_setting('struktur_organisasi') == 3)
                                <div class="form-group">
                                    <label class="col-md-12">Branch</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="branch_id" id="branch_id">
                                        <option value=""> - choose - </option>
                                        @foreach(cabang() as $item)
                                        <option value="{{ $item["id"] }}" >{{ $item["name"] }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Position</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="structure_organization_custom_id">
                                            <option value=""> Choose </option>
                                            @foreach($structure as $item)
                                            <option value="{{ $item["id"]}}">{{ $item["name"] }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label class="col-md-12">Office Type</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="branch_type">
                                            <option value="">Choose Office Type</option>
                                            @foreach(['HO', 'BRANCH'] as $item)
                                            <option>{{ $item }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                </div>
                                 <div class="form-group section-cabang" style="display:none">
                                    <label class="col-md-3">Branch</label>
                                    <div class="clearfix"></div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="cabang_id">
                                            <option value="">Choose Branch</option>
                                            @foreach(get_cabang() as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                    <div class="clearfix" /></div>
                                    <br class="clearfix" />
                                    <div class="col-md-12">
                                        <label><input type="checkbox" name="is_pic_cabang" value="1"> Branch PIC</label>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr />
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Director</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="empore_organisasi_direktur">
                                            <option value=""> Choose </option>
                                            @foreach(empore_list_direktur() as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Manager</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="empore_organisasi_manager_id">
                                            <option value=""> Choose </option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Staff</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="empore_organisasi_staff_id">
                                            <option value=""> Choose </option>
                                        </select> 
                                    </div>
                                </div>
                            @endif
                        </div>
                        

                        <div role="tabpanel" class="tab-pane fade active in" id="biodata">
                            <h3 class="box-title m-b-0">Biodata</h3>
                            <br />
                            <br />
                            {{ csrf_field() }}
                            <div class="col-md-6" style="padding-left: 0">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        @if(!empty($data->foto))
                                        <img src="{{ asset('storage/foto/'. $data->foto) }}" style="width: 200px;" />
                                        @else
                                        <img src="{{ asset('admin-css/images/user.png') }}" style="width: 200px;" />
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-info btn-xs" onclick="open_dialog_photo()"><i class="fa fa-upload"></i> Change Photo</button>
                                        <input type="file" name="foto" class="form-control" style="display: none;" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12">Name</label>
                                    <div class="col-md-10">
                                        <input type="text" name="name" style="text-transform: uppercase"  class="form-control " value="{{ old('name')}}"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Employee Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="employee_number" class="form-control " value="{{ old('employee_number')}}"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Absensi Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="absensi_number" class="form-control " value="{{ old('absensi_number')}}"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">NIK</label>
                                    <div class="col-md-10">
                                        <input type="text" name="nik" value="{{ old('nik')}}" class="form-control "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Ext</label>
                                    <div class="col-md-10">
                                        <input type="text" name="ext" value="{{ old('ext') }}" class="form-control "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Place of Birth</label>
                                    <div class="col-md-10">
                                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir')}}" class="form-control "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Date of Birth</label>
                                    <div class="col-md-10">
                                        <input type="text" name="tanggal_lahir" value="{{ old('tanggal_lahir')}}" class="form-control datepicker2"> </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Marital Status</label>
                                    <div class="col-md-10">
                                        <select class="form-control " name="marital_status">
                                            <option value="">- Marital Status -</option>
                                            <option value="Bujangan/Wanita" >Single</option>
                                            <option value="Menikah" >Married</option>
                                            <option value="Menikah Anak 1" >Married with 1 Child</option>
                                            <option value="Menikah Anak 2" >Married with 2 Child</option>
                                            <option value="Menikah Anak 3" >Married with 3 Child</option>
                                        </select>
                                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Gender</label>
                                    <div class="col-md-10">
                                        <select class="form-control " name="jenis_kelamin">
                                            <option value=""> - Gender - </option>
                                            @foreach(['Male', 'Female'] as $item)
                                                <option {{ old('jenis_kelamin')== $item ? 'selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Blood Type</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control " name="blood_type" value="{{ old('blood_type') }}" /> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Email</label>
                                    <div class="col-md-10">
                                        <input type="email" value="{{ old('email') }}" class="form-control " name="email" id="example-email"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Password</label>
                                    <div class="col-md-10">
                                        <input type="password" value="{{ old('password') }}" name="password" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Confirm Password</label>
                                    <div class="col-md-10">
                                        <input type="password" value="{{ old('
                                            confirm') }}" name="confirm" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Join Date</label>
                                    <div class="col-md-10">
                                        <input type="text" name="join_date" value="{{ old('join_date') }}" class="form-control  datepicker2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Employee Status</label>
                                    <div class="col-md-10">
                                        <select class="form-control " name="organisasi_status">
                                            <option value="">- Select - </option>
                                            @foreach(['Permanent', 'Contract'] as $item)
                                            <option {{ old('organisasi_status') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="padding-left: 0">
                                <div class="form-group">
                                    <label class="col-md-12">NPWP Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="npwp_number" value="{{ old('npwp_number') }}" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">BPJS Employment Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="bpjs_number" value="{{ old('bpjs_number') }}" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">BPJS Health Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="jamsostek_number" value="{{ old('jamsostek_number') }}" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">ID Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="ktp_number" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Passport Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="passport_number" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">KK Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="kk_number" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Telephone</label>
                                    <div class="col-md-10">
                                        <input type="number" value="{{ old('telepon') }}" name="telepon" class="form-control "> </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-12">Mobile 1</label>
                                    <div class="col-md-10">
                                        <input type="number" name="mobile_1" class="form-control "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Mobile 2</label>
                                    <div class="col-md-10">
                                        <input type="number" name="mobile_2" class="form-control "> </div>
                                </div>
                               <div class="form-group">
                                    <label class="col-md-12">Religion</label>
                                    <div class="col-md-10">
                                        <select class="form-control " name="agama">
                                            <option value=""> - Religion - </option>
                                            @foreach(agama() as $item)
                                                <option value="{{ $item }}"> {{ $item }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Current Address</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control " name="current_address"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">ID Addres</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control " name="id_address"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">ID Picture</label>
                                    <div class="col-md-10">
                                        <input type="file" name="foto_ktp" class="form-control " />
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                         <div role="tabpanel" class="tab-pane fade" id="dependent">
                            <h3 class="box-title m-b-0">Dependent</h3> <a class="btn btn-info btn-sm" id="btn_modal_dependent"><i class="fa fa-plus"></i> Add</a>
                            <br />
                            <br />
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Relationship</th>
                                            <th>Place of birth</th>
                                            <th>Date of birth</th>
                                            <th>Date of death</th>
                                            <th>Education Level</th>
                                            <th>Occupation</th>
                                            <th>Dependent</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dependent_table"></tbody>
                                </table><br /><br />
                            </div>
                        </div>

                         <div role="tabpanel" class="tab-pane fade" id="education">
                            <h3 class="box-title m-b-0">Education</h3> <a class="btn btn-info btn-sm" id="btn_modal_education"><i class="fa fa-plus"></i> Add</a>
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
                                    <tbody class="education_table"></tbody>
                                </table><br /><br />
                            </div>
                        </div>
                    </div>
                    
                    <!-- <a href="{{ route('administrator.karyawan.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save Employee Data</button>
                     -->
                    <br style="clear: both;" />
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>                    
    </div>
</div>
    @include('layouts.footer')
</div>

<!-- modal content dependent  -->
<div id="modal_dependent" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Dependent</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-dependent">
                        <div class="form-group">
                            <label class="col-md-12">Name</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-nama">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Relationship</label>
                            <div class="col-md-12">
                                <select class="form-control modal-hubungan">
                                    <option value="">Choose Relationship</option>
                                    <!-- <option>Spouse</option> -->
                                    <option value="Suami">Husband</option>
                                    <option value="Istri">Wife</option>
                                    <option value="Ayah Kandung">Father</option>
                                    <option value="Ibu Kandung">Mother</option>
                                    <option value="Anak 1">First Child</option>
                                    <option value="Anak 2">Second Child</option>
                                    <option value="Anak 3">Third Child</option>
                                    <option value="Anak 4">Fourth Child</option>
                                    <option value="Anak 5">Fifth Child</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Place of birth</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-tempat_lahir">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Date of birth</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control datepicker2 modal-tanggal_lahir">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-12">Date of death</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control datepicker2 modal-tanggal_meninggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Education Level</label>
                            <div class="col-md-12">
                                <select class="form-control modal-jenjang_pendidikan">
                                    <option value="">Choose Education Level</option>
                                    <option value="TK">TK</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA / SMK">SMA / SMK</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Occupation</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-pekerjaan" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Dependent</label>
                            <div class="col-md-12">
                                <select class="form-control modal-tertanggung">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_dependent">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal content education  -->
<div id="modal_education" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Education</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-education">
                        <div class="form-group">
                            <label class="col-md-3">Education</label>
                            <div class="col-md-9">
                                <select class="form-control modal-pendidikan">
                                    <option value="">Choose Education</option>
                                    <option>SD</option>
                                    <option>SMP</option>
                                    <option>SMA/SMK</option>
                                    <option>D1</option>
                                    <option>D2</option>
                                    <option>D3</option>
                                    <option>S1</option>
                                    <option>S2</option>
                                    <option>S3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">School Name/University</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control modal-fakultas" name="modal-fakultas" id="modal-fakultas"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Year of Start</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control modal-tahun_awal" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Year of Graduate</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control modal-tahun_akhir" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Major</label>
                            <div class="col-md-9">
                                <select class="form-control modal-jurusan">
                                    <option value="">Choose Major</option>
                                    @foreach(get_program_studi() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Grade</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control modal-nilai" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">City</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control modal-kota" name="modal-kota" id="modal-kota"/>
                            </div>
                        </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_education">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal content education  -->
<div id="modal_inventaris_mobil" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Inventaris Mobil</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-inventaris">
                        <div class="form-group">
                            <label class="col-md-12">Tipe Mobil</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-tipe_mobil">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Tahun</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-tahun">
                            </div>
                       </div>
                       <div class="form-group">
                            <label class="col-md-12">No Polisi</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-no_polisi">
                            </div>
                       </div>
                       <div class="form-group">
                            <label class="col-md-12">Status Mobil</label>
                            <div class="col-md-12">
                                <select class="form-control modal-status_mobil">
                                    <option value="">- none -</option>
                                    <option>Rental</option>
                                    <option>Perusahaan</option>
                                </select>
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_inventaris_mobil">Tambah</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal content education  -->
<div id="modal_inventaris_lainnya" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Inventaris Lainnya</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-inventaris">
                        <div class="form-group">
                            <label class="col-md-12">Jenis Inventaris</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-inventaris-jenis">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Keterangan</label>
                            <div class="col-md-12">
                                <textarea class="form-control modal-inventaris-description"></textarea>
                            </div>
                       </div>
                      
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_inventaris_lainnya">Tambah</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal content education  -->
<div id="modal_cuti" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Leave Type</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-cuti">
                        <div class="form-group">
                            <label class="col-md-12">Leave Type</label>
                            <div class="col-md-12">
                                <select class="form-control modal-jenis_cuti">
                                    <option value="">- none -</option>
                                    @foreach(get_master_cuti() as $i)
                                    <option value="{{ $i->id }}">{{ $i->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Quota</label>
                            <div class="col-md-12">
                                <input type="number" class="form-control modal-kuota">
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_cuti">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<style type="text/css">
    .ui-autocomplete{
            z-index: 9999999 !important;
        }
</style>
@section('footer-script')
    <style type="text/css">
        .staff-branch-select, .head-branch-select {
            display: none;
        }
        
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Date picker plugins css -->
    <link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker-employee/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker-employee/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">

        jQuery('.datepicker2').datepicker({
            format: 'yyyy-mm-dd',
        });

        $("#modal-fakultas").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('ajax.get-university') }}",
                    method:"POST",
                    data: {'word' : request.term, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType:"json",
                    success:function(data)
                    {
                        response(data);
                    }
                })
            },
            select: function( event, ui ) {
                $("input[name='modal-fakultas']").val(ui.item.id)
            },
            showAutocompleteOnFocus: true
        });

        $("#modal-kota").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('ajax.get-city') }}",
                    method:"POST",
                    data: {'word' : request.term, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType:"json",
                    success:function(data)
                    {
                        response(data);
                    }
                })
            },
            select: function( event, ui ) {
                $("input[name='modal-kota']").val(ui.item.id)
            },
            showAutocompleteOnFocus: true
        });

          
        function open_dialog_photo()
        {
            $("input[name='foto']").trigger('click');   
        }

        $("select[name='empore_organisasi_direktur']").on('change', function(){
            var id  = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-manager-by-direktur') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    var el = '<option value="">Choose</option>';

                    $(data.data).each(function(k,v){
                        console.log(v);
                       el += '<option value="'+ v.id +'">'+ v.name +'</option>';
                    });

                    $("select[name='empore_organisasi_manager_id']").html(el);
                }
            });
        }); 


        $("select[name='empore_organisasi_manager_id']").on('change', function(){
            var id  = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-staff-by-manager') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    var el = '<option value="">Choose</option>';

                    $(data.data).each(function(k,v){
                        console.log(v);
                       el += '<option value="'+ v.id +'">'+ v.name +'</option>';
                    });

                    $("select[name='empore_organisasi_staff_id']").html(el);
                }
            });
        }); 

         $("select[name='jabatan_cabang']").on('change', function(){

            if($(this).val() =='Staff')
            {
                $('.head-branch-select').hide();
                $('.staff-branch-select').show();
            }
            else if($(this).val() =='Head')
            {
                $('.head-branch-select').show();
                $('.staff-branch-select').hide();   
            }
            else
            {
                $('.head-branch-select').hide();
                $('.staff-branch-select').hide();
            }

        });

        $("select[name='branch_type']").on('change', function(){

            if($(this).val() == 'BRANCH')
            {
                $(".section-cabang").show();
            }
            else
            {
                $(".section-cabang").hide();
            }
        });


        $("#add_inventaris_lainnya").click(function(){

            $("#modal_inventaris_lainnya").modal('show');
        });

        $("#add_modal_inventaris_lainnya").click(function(){

            var el = '<tr>';
            var modal_jenis            = $('.modal-inventaris-jenis').val();
            var modal_description                 = $('.modal-inventaris-description').val();
            
            el += '<td>'+ (parseInt($('.table_mobil tr').length) + 1)  +'</td>';
            el +='<td>'+ modal_jenis +'</td>';
            el +='<td>'+ modal_description +'</td>';;
            el +='<input type="hidden" name="inventaris_lainnya[jenis][]" value="'+ modal_jenis +'" />';
            el +='<input type="hidden" name="inventaris_lainnya[description][]" value="'+ modal_description +'" />';

            $('.table_inventaris_lainnya').append(el);
            $('#modal_inventaris_lainnya').modal('hide');
        });

        $("#add_cuti").click(function(){
            $("#modal_cuti").modal('show');
        });

        $("#add_modal_cuti").click(function(){

            var jenis_cuti = $('.modal-jenis_cuti :selected');
            var kuota = $('.modal-kuota').val();

            var el = '<tr><td>'+ (parseInt($('.table_cuti tr').length) + 1) +'</td><td>'+ jenis_cuti.text() +'</td><td>'+ kuota +'</td></tr>';
            
            el += '<input type="hidden" name="cuti[cuti_id][]" value="'+ jenis_cuti.val() +'" />';
            el += '<input type="hidden" name="cuti[kuota][]" value="'+ kuota +'" />';

            $("form.frm-modal-cuti").trigger('reset');

            $('.table_cuti').append(el);

            $("#modal_cuti").modal('hide');
        });

        $("#add_inventaris_mobil").click(function(){

            $("#modal_inventaris_mobil").modal('show');
        });

        $("#add_modal_inventaris_mobil").click(function(){

            var el = '<tr>';
            var modal_tipe_mobil            = $('.modal-tipe_mobil').val();
            var modal_tahun                 = $('.modal-tahun').val();
            var modal_no_polisi             = $('.modal-no_polisi').val();
            var modal_status_mobil          = $('.modal-status_mobil').val();
            
            el += '<td>'+ (parseInt($('.table_mobil tr').length) + 1)  +'</td>';
            el +='<td>'+ modal_tipe_mobil +'</td>';
            el +='<td>'+ modal_tahun +'</td>';
            el +='<td>'+ modal_no_polisi +'</td>';
            el +='<td>'+ modal_status_mobil +'</td>';
            el +='<input type="hidden" name="inventaris_mobil[tipe_mobil][]" value="'+ modal_tipe_mobil +'" />';
            el +='<input type="hidden" name="inventaris_mobil[tahun][]" value="'+ modal_tahun +'" />';
            el +='<input type="hidden" name="inventaris_mobil[no_polisi][]" value="'+ modal_no_polisi +'" />';
            el +='<input type="hidden" name="inventaris_mobil[status_mobil][]" value="'+ modal_status_mobil +'" />';

            $('.table_mobil').append(el);
            $('#modal_inventaris_mobil').modal('hide');
        });


        $("#add_modal_dependent").click(function(){

            var el = '<tr>';
            var modal_nama                  = $('.modal-nama').val();
            var modal_hubungan              = $('.modal-hubungan').val();
            var modal_tempat_lahir          = $('.modal-tempat_lahir').val();
            var modal_tanggal_lahir         = $('.modal-tanggal_lahir').val();
            var modal_tanggal_meninggal     = $('.modal-tanggal_meninggal').val();
            var modal_jenjang_pendidikan    = $('.modal-jenjang_pendidikan').val();
            var modal_pekerjaan             = $('.modal-pekerjaan').val();
            var modal_tertanggung           = $('.modal-tertanggung').val();
            
            el += '<td>'+ parseInt($('.dependent_table tr').length) + 1  +'</td>';
            el +='<td>'+ modal_nama +'</td>';
            el +='<td>'+ modal_hubungan +'</td>';
            el +='<td>'+ modal_tempat_lahir +'</td>';
            el +='<td>'+ modal_tanggal_lahir +'</td>';
            el +='<td>'+ modal_tanggal_meninggal +'</td>';
            el +='<td>'+ modal_jenjang_pendidikan +'</td>';
            el +='<td>'+ modal_pekerjaan +'</td>';
            el +='<td>'+ modal_tertanggung +'</td>';
            el +='<input type="hidden" name="dependent[nama][]" value="'+ modal_nama +'" />';
            el +='<input type="hidden" name="dependent[hubungan][]" value="'+ modal_hubungan +'" />';
            el +='<input type="hidden" name="dependent[tempat_lahir][]" value="'+ modal_tempat_lahir +'" />';
            el +='<input type="hidden" name="dependent[tanggal_lahir][]" value="'+ modal_tanggal_lahir +'" />';
            el +='<input type="hidden" name="dependent[tanggal_meninggal][]" value="'+ modal_tanggal_meninggal +'" />';
            el +='<input type="hidden" name="dependent[jenjang_pendidikan][]" value="'+ modal_jenjang_pendidikan +'" />';
            el +='<input type="hidden" name="dependent[pekerjaan][]" value="'+ modal_pekerjaan +'" />';
            el +='<input type="hidden" name="dependent[tertanggung][]" value="'+ modal_tertanggung +'" />';

            $('.dependent_table').append(el);
            $('.frm-modal-dependent').trigger('reset');
            $('#modal_dependent').modal('hide');
        });

        $("#add_modal_education").click(function(){
            var el = '<tr>';
            var modal_pendidikan            = $('.modal-pendidikan').val();
            var modal_fakultas              = $('.modal-fakultas').val();
            var modal_tahun_awal            = $('.modal-tahun_awal').val();
            var modal_tahun_akhir           = $('.modal-tahun_akhir').val();
            var modal_jurusan               = $('.modal-jurusan').val();
            var modal_nilai                 = $('.modal-nilai').val();
            var modal_kota                  = $('.modal-kota').val();
            
            el += '<td>'+ (parseInt($('.education_table tr').length) + 1 )  +'</td>';
            el +='<td>'+ modal_pendidikan +'</td>';
             el +='<td>'+ modal_fakultas +'</td>';
            el +='<td>'+ modal_tahun_awal +'</td>';
            el +='<td>'+ modal_tahun_akhir +'</td>';
            el +='<td>'+ modal_jurusan +'</td>';
            el +='<td>'+ modal_nilai +'</td>';
            el +='<td>'+ modal_kota +'</td>';
            el +='<input type="hidden" name="education[pendidikan][]" value="'+ modal_pendidikan +'" />';
            el +='<input type="hidden" name="education[fakultas][]" value="'+ modal_fakultas +'" />';
            el +='<input type="hidden" name="education[tahun_awal][]" value="'+ modal_tahun_awal +'" />';
            el +='<input type="hidden" name="education[tahun_akhir][]" value="'+ modal_tahun_akhir +'" />';
            el +='<input type="hidden" name="education[jurusan][]" value="'+ modal_jurusan +'" />';
            el +='<input type="hidden" name="education[nilai][]" value="'+ modal_nilai +'" />';
            el +='<input type="hidden" name="education[kota][]" value="'+ modal_kota +'" />';

            $('.education_table').append(el);

            $('#modal_education').modal('hide');
            $('form.frm-modal-education').reset();
        });

        $("#btn_modal_dependent").click(function(){

            $('#modal_dependent').modal('show');

        });

         $("#btn_modal_education").click(function(){

            $('#modal_education').modal('show');

        });

        function get_kabupaten(el)
        {
            var id = $(el).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-kabupaten-by-provinsi') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var html_ = '<option value="">Choose Districts</option>';

                    $(data.data).each(function(k, v){
                        html_ += "<option value=\""+ v.id_kab +"\">"+ v.nama +"</option>";
                    });

                    $(el).parent().find('select').html(html_);
                }
            });
        }

        jQuery('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

        $("select[name='provinsi_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-kabupaten-by-provinsi') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var html_ = '<option value="">Choose Disytricts</option>';

                    $(data.data).each(function(k, v){
                        html_ += "<option value=\""+ v.id_kab +"\">"+ v.nama +"</option>";
                    });

                    $("select[name='kabupaten_id'").html(html_);
                }
            });
        });

        $("select[name='kabupaten_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.get-kecamatan-by-kabupaten') }}',
                    data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {

                        var html_ = '<option value=""> Choose Sub-District</option>';

                        $(data.data).each(function(k, v){
                            html_ += "<option value=\""+ v.id_kec +"\">"+ v.nama +"</option>";
                        });

                        $("select[name='kecamatan_id'").html(html_);
                    }
            });
        });

        $("select[name='kecamatan_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.get-kelurahan-by-kecamatan') }}',
                    data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {

                        var html_ = '<option value=""> Choose Village</option>';

                        $(data.data).each(function(k, v){
                            html_ += "<option value=\""+ v.id_kel +"\">"+ v.nama +"</option>";
                        });

                        $("select[name='kelurahan_id'").html(html_);
                    }
            });
        });

        $("select[name='division_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-department-by-division') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var html_ = '<option value=""> Choose Department</option>';

                    $(data.data).each(function(k, v){
                        html_ += "<option value=\""+ v.id +"\">"+ v.name +"</option>";
                    });

                    $("select[name='department_id'").html(html_);
                }
            });
        });

        $("select[name='department_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-section-by-department') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var html_ = '<option value=""> Choose Section</option>';

                    $(data.data).each(function(k, v){
                        html_ += "<option value=\""+ v.id +"\">"+ v.name +"</option>";
                    });

                    $("select[name='section_id'").html(html_);
                }
            });
        });

    </script>
@endsection
@endsection