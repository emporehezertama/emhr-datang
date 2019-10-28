<!DOCTYPE html>
<html>
<head>
	<title>Payslip {{ $user->nik .'/'. $user->name }}</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
    		border-spacing: 0;
		}
		table.border tr th, table.border tr td {
			border: 1px solid black;
			padding: 5px 10px;
		}
	</style>
</head>
<body>
	@foreach($dataArray as $k => $item)
	<img src="{{  asset(get_setting('logo')) }}" style="height: 80; float: right;" /> 
	<h3>{{ get_setting('title') }} </h3>
	<p><strong>PAYSLIP {{ $bulan }} {{ $tahun }}</strong></p>
	<br />
	<table style="width: 100%;">
		<tr>
			<th style="width: 20%;">EMPLOYEE ID</th>
			<th style="width: 30%;"> : {{ $user->nik }}</th>
			<th style="width: 25%;">Status</th>
			<th style="width: 25%;"> : {{ $user->organisasi_status }}</th>
		</tr>
		<tr>
			<th>Name</th>
			<th> : {{ $user->name }}</th>
			<th>NPWP</th>
			<th> : {{ $user->npwp_number }}</th>
		</tr>
		<tr>
			<th>Position Title</th>
			<th> : {{ empore_jabatan($user->id) }}</th>
			<th>BPJS Karyawan Number</th>
			<th> : {{ $user->bpjs_number }}</th>
		</tr>
	</table>
	<br />
	<strong>IDR Portion</strong>
	<table style="width: 100%">
		<tr>
			<td style="width: 49%;vertical-align: top;">
				<table style="width: 100%;" class="border">
					<tr>
						<th style="padding-bottom: 15px;padding-top: 15px;">Income Description</th>
						<th style="text-align: right;">Amount</th>
					</tr> 
					<tr>
						<td>Salary</td>
						<td style="text-align: right;">{{ format_idr($item->salary) }}</td>
					</tr>
					@if($item->bonus > 0)
					<tr>
						<td>Bonus / THR</td>
						<td style="text-align: right;">{{ format_idr($item->bonus) }}</td>
					</tr>
					@endif
					<tr>
						<td>BPJS JKK {{ get_setting('bpjs_jkk_company') }}% (Company) </td>
						<td style="text-align: right;">{{ format_idr( $item->bpjs_jkk_company ) }}</td>
					</tr>
					<tr>
						<td>BPJS JKM {{ get_setting('bpjs_jkm_company') }}% (Company) </td>
						<td style="text-align: right;">{{ format_idr( $item->bpjs_jkm_company ) }}</td>
					</tr>
					<tr>
						<td>BPJS JHT {{ get_setting('bpjs_jht_company') }}% (Company) </td>
						<td style="text-align: right;">{{ format_idr( $item->bpjs_jht_company ) }}</td>
					</tr>
					<tr>
						<td>BPJS Pensiun {{ get_setting('bpjs_pensiun_company') }}% (Company) </td>
						<td style="text-align: right;">{{ format_idr( $item->bpjs_pensiun_company ) }}</td>
					</tr>
					<tr>
						<td>BPJS Kesehatan {{ get_setting('bpjs_kesehatan_company') }}% (Company) </td>
						<td style="text-align: right;">{{ format_idr( $item->bpjs_kesehatan_company ) }}</td>
					</tr>
					@foreach(payrollEarningsEmployeeHistory($item->id) as $i)
                        @if(isset($i->payrollEarnings->title))
                          <tr>
                          	<td>
                          		{{ $i->payrollEarnings->title }}
                          	</td>
                          	<td style="text-align: right;">
                          		{{ format_idr($i->nominal) }}
                          	</td>
                          </tr>
                        @endif
                    @endforeach
                    <tr>
                    	<td>Monthly Income Tax / PPh21 (ditanggung perusahaan)</td>
                    	<td style="text-align: right;">
                    		{{ format_idr($item->pph21) }}
                    	</td>
                    </tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<th style="width:78%;">Total Earning </th>
						<th>{{ format_idr($item->total_earnings) }}</th>
					</tr>
				</table>
			</td>
			<td>&nbsp;</td>
			<td style="width: 49%;vertical-align: top;">
				<table style="width: 100%;" class="border">
					<tr>
						<th style="padding-bottom: 15px;padding-top: 15px;">Deduction Description</th>
						<th style="text-align: right;">Amount</th>
					</tr>
					<tr>
						<td>BPJS Jaminan Hari Tua (JHT) {{ get_setting('bpjs_jaminan_jht_employee') }}% (Employee) </td>
						<td style="text-align: right;">{{ format_idr( $item->bpjs_ketenagakerjaan_employee ) }}</td>
					</tr>
					<tr> 
						<td>BPJS Kesehatan ({{ get_setting('bpjs_kesehatan_employee') }}%) (employee)</td>
						<td style="text-align: right;">{{ format_idr($item->bpjs_kesehatan_employee) }}</td>
					</tr>
					<tr>
						<td>BPJS Jaminan Pensiun (JP) {{ get_setting('bpjs_jaminan_jp_employee') }}% (Employee)</td>
						<td style="text-align: right;"> {{ format_idr($item->bpjs_pensiun_employee) }} </td>
					</tr>
					<tr>
						<td>Total BPJS Company</td>
						<td style="text-align: right;"> {{ format_idr($item->bpjstotalearning) }} </td>
					</tr>
					<tr>
						<td>PPH21</td>
						<td style="text-align: right;">{{ format_idr($item->pph21) }}</td>
					</tr>
					@foreach(payrollDeductionsEmployeeHistory($item->id) as $i)
                        @if(isset($i->payrollDeductions->title))
                          <tr>
                          	<td>
                          		{{ $i->payrollDeductions->title }}
                          	</td>
                          	<td style="text-align: right;">
                          		{{ format_idr($i->nominal) }}
                          	</td>
                          </tr>
                        @endif
                    @endforeach
				</table>
				<table style="width: 100%;">
					<tr>
						<th style="width: 78%;">Total Deduction </th>
						<th> {{ format_idr($item->total_deduction) }}</th>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table style="width: 50%;">
		<tr>
			<th style="border-bottom: 1px solid black;"></th>
			<th style="border-bottom: 1px solid black;">IDR Portion</th>
		</tr>
		<tr>
			<th>Take Home Pay </th>
			<th> : {{ format_idr($item->thp) }}</th>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th>Bank Transfer Details</th>
		</tr>
		<tr>
			<td>Bank</td>
			<td> : {{ isset($user->bank->name) ? $user->bank->name : '' }}</td>
		</tr>
		<tr>
			<td>A/C no</td>
			<td> : {{ isset($user->nomor_rekening) ? $user->nomor_rekening : '' }}</td>
		</tr>
		<tr>
			<td>Account name</td>
			<td> : {{ isset($user->nama_rekening) ? $user->nama_rekening : '' }}</td>
		</tr>
	</table>
	
	@endforeach
</body>
</html>