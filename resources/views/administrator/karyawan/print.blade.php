<!DOCTYPE html>
<html>
<head>
	<title>{{ $data->name }} - {{ $data->nik }}</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
    		border-spacing: 0;
		}
		table tr td {
			-border-bottom: 1px solid #666666;
			padding: 5px 0;
		}

		.table-border {
			width: 100%;
		}
		.table-border tr td, .table-border tr th{
			border-bottom: 1px solid #666666;
		}
	</style>
</head>
<body>
	<h3 style="margin-bottom:0;">{{ $data->name }}</h3>
	<h4 style="margin-top:0;">{{ $data->nik }}</h4>
	
	@if(!empty($data->foto))
		<img src="{{ public_path('storage/foto/'. $data->foto) }}" style="width: 200px; position: absolute; right: 0; top: 100px;">
	@endif

	<hr>
	<table>
		<tr>
			<td>Employee Number</td>
			<td>: {{ $data->employee_number }}</td>
		</tr>
		<tr>
			<td>Absensi Number</td>
			<td>: {{ $data->absensi_number }}</td>
		</tr>
		<tr>
			<td>Place of birth</td>
			<td>: {{ $data->tempat_lahir }}</td>
		</tr>
		<tr>
			<td>Date of birth</td>
			<td>: {{ $data->tanggal_lahir }}</td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>: {{ $data->jenis_kelamin }}</td>
		</tr>
		<tr>
			<td>E-mail</td>
			<td>: {{ $data->email }}</td>
		</tr>
		<tr>
			<td>Join Date</td>
			<td>: {{ $data->join_date }}</td>
		</tr>
		<tr>
			<td>Marital Status</td>
			<td>: {{ $data->marital_status }}</td>
		</tr>

		<tr>
			<td>Ext</td>
			<td>: {{ $data->ext }}</td>
		</tr>
		<tr>
			<td>Telephone</td>
			<td>: {{ $data->telepon }}</td>
		</tr>
		<tr>
			<td>Mobile 1</td>
			<td>: {{ $data->mobile_1 }}</td>
		</tr>
		<tr>
			<td>Mobile 2</td>
			<td>: {{ $data->mobile_2 }}</td>
		</tr>
		<tr>
			<td>Religion</td>
			<td>: {{ $data->agama }}</td>
		</tr>
		<tr>
			<td>ID Number</td>
			<td>: {{ $data->ktp_number }}</td>
		</tr>
		<tr>
			<td>Passport Number</td>
			<td>: {{ $data->passport_number }}</td>
		</tr>
		<tr>
			<td>KK Number</td>
			<td>: {{ $data->kk_number }}</td>
		</tr>
		<tr>
			<td>NPWP Number</td>
			<td>: {{ $data->npwp_number }}</td>
		</tr>
		<tr>
			<td>Jamsostek Number</td>
			<td>: {{ $data->jamsostek_number }}</td>
		</tr>
		<tr>
			<td>BPJS Number</td>
			<td>: {{ $data->bpjs_number }}</td>
		</tr>
		<tr>
			<td>Position</td>
			<td>:@if(!empty($data->empore_organisasi_staff_id))
                                                Staff
                                            @endif

                                            @if(empty($data->empore_organisasi_staff_id) and !empty($data->empore_organisasi_manager_id))
                                                Manager
                                            @endif

                                            @if(empty($data->empore_organisasi_staff_id) and empty($data->empore_organisasi_manager_id) and !empty($data->empore_organisasi_direktur))
                                                Direktur
                                            @endif</td>
		</tr>
		<tr>
			<td>Job Rule</td>
			<td>: @if(!empty($data->empore_organisasi_staff_id))
                                                {{ isset($data->empore_staff->name) ? $data->empore_staff->name : '' }}
                                            @endif

                                            @if(empty($data->empore_organisasi_staff_id) and !empty($data->empore_organisasi_manager_id))
                                                {{ isset($data->empore_manager->name) ? $data->empore_manager->name : '' }}
                                            @endif</td>
		</tr>
		<tr>
			<td>Branch</td>
			<td>: {{ (isset($data->cabang->name) ? $data->cabang->name : '') }}</td>
		</tr>
		<tr>
			<td>ID Address</td>
			<td>: {{ (isset($data->id_address) ? $data->id_address : '') }}</td>
		</tr>
		<tr>
			<td>Current Address</td>
			<td>: {{ (isset($data->current_address) ? $data->current_address : '') }}</td>
		</tr>
		<tr>
			<td>Blood Type</td>
			<td>: {{ (isset($data->blood_type) ? $data->blood_type : '') }}</td>
		</tr>
		<tr>
			<td>Office Type</td>
			<td>: {{ (isset($data->branch_type) ? $data->branch_type : '') }}</td>
		</tr>
		<tr>
			<td>Bank</td>
			<td>: {{ (isset($data->bank->name) ? $data->bank->name : '') }}</td>
		</tr>
		<tr>
			<td>Name of Account</td>
			<td>: {{ (isset($data->nama_rekening) ? $data->nama_rekening : '') }}</td>
		</tr>
		<tr>
			<td>Account Number</td>
			<td>: {{ (isset($data->nomor_rekening) ? $data->nomor_rekening : '') }}</td>
		</tr>
		<tr>
			<td>Employee Status</td>
			<td>: {{ $data->organisasi_status }}</td>
		</tr>
		
	</table>
	<br />
	<h4 style="background: #eee; padding: 10px; margin-bottom: 0; ">Dependent</h4>
	<hr>
	<br />
	<table class="table-border">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Relationship</th>
			<th>Place of birth</th>
			<th>Date of birth</th>
			<th>Education level</th>
			<th>Occupation</th>
		</tr>
		@foreach($data->userFamily as $no => $i)
		<tr>
			<td>{{ $no + 1 }}</td>
			<td>{{ $i->nama }}</td>
			<td>{{ $i->hubungan }}</td>
			<td>{{ $i->tempat_lahir }}</td>
			<td>{{ $i->tanggal_lahir }}</td>
			<td>{{ $i->jenjang_pendidikan }}</td>
			<td>{{ $i->pekerjaan }}</td>
		</tr>
		@endforeach
	</table>

	<br />
	<h4 style="background: #eee; padding: 10px; margin-bottom: 0; ">Education</h4>
	<hr>
	<br />
	<table class="table-border">
		<tr>
			<th>No</th>
			<th>Education</th>
			<th>Year of Start</th>
			<th>Year of Graduate</th>
			<th>School Name</th>
			<th>Major</th>
			<th>Grade</th>
			<th>City</th>
		</tr>
		@foreach($data->userEducation as $no => $i)
		<tr>
			<td>{{ $no + 1 }}</td>
			<td>{{ $i->pendidikan }}</td>
			<td>{{ $i->tahun_awal }}</td>
			<td>{{ $i->tahun_akhir }}</td>
			<td>{{ $i->fakultas }}</td>
			<td>{{ $i->jurusan }}</td>
			<td>{{ $i->nilai }}</td>
			<td>{{ $i->kota }}</td>
		</tr>
		@endforeach
	</table>
	<br />
	<h4 style="background: #eee; padding: 10px; margin-bottom: 0; ">Inventaris Mobil</h4>
	<hr>
	<br />
	<table class="table-border">
		<tr>
			<th>#</th>
			<th>Car Type</th>
			<th>Year</th>
			<th>Plat Number</th>
			<th>Car Status</th>
		</tr>
		@foreach($data->inventaris_mobil as $no => $m)
		<tr>
			<td>{{ $no+1 }}</td>
			<td>{{ $m->tipe_mobil }}</td>
			<td>{{ $m->tahun }}</td>
			<td>{{ $m->no_polisi }}</td>
			<td>{{ $m->status_mobil }}</td>
		</tr>		
		@endforeach
	</table>

	<br />
	<h4 style="background: #eee; padding: 10px; margin-bottom: 0; ">Inventaris Lainnya</h4>
	<hr>
	<br />
	<table class="table-border">
		<tr>
			<th>#</th>
			<th>Inventaris Type</th>
			<th>Description</th>
		</tr>
		@foreach($data->inventaris as $no => $m)
		<tr>
			<td>{{ $no+1 }}</td>
			<td>{{ $m->jenis }}</td>
			<td>{{ $m->description }}</td>
		</tr>		
		@endforeach
	</table>

	<br />
	<h4 style="background: #eee; padding: 10px; margin-bottom: 0; ">Cuti</h4>
	<hr>
	<br />
	<table class="table-border">
		<tr>
			<th>#</th>
			<th>Leave Type</th>
			<th>Quota</th>
			<th>Leave Taken	</th>
			<th>Leave Balance</th>
		</tr>
		@foreach($data->cuti as $no => $m)
		<tr>
			<td>{{ $no+1 }}</td>
			<td>{{ isset($m->cuti->jenis_cuti) ? $m->cuti->jenis_cuti : '' }}</td>
			<td>{{ $m->kuota }}</td>
			<td>{{ $m->cuti_terpakai }}</td>
            <td>{{ $m->sisa_cuti }}</td>
		</tr>		
		@endforeach
	</table>
</body>
</html>