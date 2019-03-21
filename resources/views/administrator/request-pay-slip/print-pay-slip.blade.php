<!DOCTYPE html>
<html>
<head>
	<title>Payslip {{ $data->user->nik .'/'. $data->user->name }}</title>
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
	<img src="{{  asset(get_setting('logo')) }}" style="width: 140px; float: right;" /> 
	<h3>PT. Empore Hezer Tama </h3>
	<p><strong>PAYSLIP {{ $bulan[$k] }} {{ $tahun }}</strong></p>
	<br />
	<table style="width: 100%;">
		<tr>
			<th style="width: 20%;">EMPORE ID</th>
			<th style="width: 30%;"> : {{ $data->user->nik }}</th>
			<th style="width: 25%;">Status</th>
			<th style="width: 25%;"> : {{ $data->user->organisasi_status }}</th>
		</tr>
		<tr>
			<th>Name</th>
			<th> : {{ $data->user->name }}</th>
			<th>NPWP</th>
			<th> : {{ $data->user->npwp_number }}</th>
		</tr>
		<tr>
			<th>Position Title</th>
			<th> : {{ empore_jabatan($data->user->id) }}</th>
			<th>BPJS Karyawan Number</th>
			<th> : {{ $data->user->bpjs_number }}</th>
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
						<td style="text-align: right;">{{ number_format($item->salary) }}</td>
					</tr>
					@if($item->bonus > 0)
					<tr>
						<td>Bonus / THR</td>
						<td style="text-align: right;">{{ number_format($item->bonus) }}</td>
					</tr>
					@endif
					@foreach(payrollEarningsEmployeeHistory($item->id) as $i)
                        @if(isset($i->payrollEarnings->title))
                          <tr>
                          	<td>
                          		{{ $i->payrollEarnings->title }}
                          	</td>
                          	<td style="text-align: right;">
                          		{{ number_format($i->nominal) }}
                          	</td>
                          </tr>
                        @endif
                    @endforeach
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
						<td style="text-align: right;">{{ number_format($item->salary * get_setting('bpjs_jaminan_jht_employee') / 100) }}</td>
					</tr>
					<tr> 
						<td>BPJS Kesehatan ({{ get_setting('bpjs_kesehatan_employee') }}%) (employee)</td>
						<td style="text-align: right;">{{ number_format($item->bpjs_kesehatan_employee) }}</td>
					</tr>
					<tr>
						<td>BPJS Jaminan Pensiun (JP) {{ get_setting('bpjs_jaminan_jp_employee') }}% (Employee)</td>
						<td style="text-align: right;"> {{ number_format($item->bpjs_pensiun_employee) }} </td>
					</tr>
					<tr>
						<td>PPH21</td>
						<td style="text-align: right;">{{ number_format($item->pph21) }}</td>
					</tr>
					@foreach(payrollDeductionsEmployeeHistory($item->id) as $i)
                        @if(isset($i->payrollDeductions->title))
                          <tr>
                          	<td>
                          		{{ $i->payrollDeductions->title }}
                          	</td>
                          	<td style="text-align: right;">
                          		{{ number_format($i->nominal) }}
                          	</td>
                          </tr>
                        @endif
                    @endforeach
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
			<th> : {{ number_format($item->thp) }}</th>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th>Bank Transfer Details</th>
		</tr>
		<tr>
			<td>Bank</td>
			<td> : {{ isset($data->user->bank->name) ? $data->user->bank->name : '' }}</td>
		</tr>
		<tr>
			<td>A/C no</td>
			<td> : {{ isset($data->user->nomor_rekening) ? $data->user->nomor_rekening : '' }}</td>
		</tr>
		<tr>
			<td>Account name</td>
			<td> : {{ isset($data->user->nama_rekening) ? $data->user->nama_rekening : '' }}</td>
		</tr>
	</table>
	
	@if($total == 0)
	@elseif(($k+1) != $total)
		<div style="page-break-before:always"></div>
	@endif
	@endforeach
</body>
</html>