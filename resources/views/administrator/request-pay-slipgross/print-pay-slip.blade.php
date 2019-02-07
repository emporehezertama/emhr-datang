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

	<img src="{{  asset('empore.png') }}" style="width: 140px; float: right;" /> 
	<h3>PT. Empore Hezer Tama </h3>
	<p><strong>PAYSLIP {{ $bulan[$k] }} {{ $tahun }}</strong></p>
	<br />
	<table style="width: 100%;">
		<tr>
			<th>EMPORE ID</th>
			<th> : {{ $data->user->nik }}</th>
			<th>Status</th>
			<th> : {{ $data->user->organisasi_status }}</th>
		</tr>
		<tr>
			<th>Name</th>
			<th> : {{ $data->user->name }}</th>
			<th>NPWP</th>
			<th> : {{ $data->user->npwp_number }}</th>
		</tr>
		<tr>
			<th>Position Title</th>
			<th colspan="2"> : {{ empore_jabatan($data->user->id) }}</th>
		</tr>
	</table>
	<br />
	<strong>IDR Portion</strong>
	<table style="width: 100%;" class="border">
		<tr>
			<th style="padding-bottom: 15px;padding-top: 15px;">Income Description</th>
			<th style="text-align: right;">Amount</th>
			<th>Deduction Description</th>
			<th style="text-align: right;">Amount</th>
		</tr>
		<tr>
			<td>Basic Salary</td>
			<td style="text-align: right;">{{ number_format($item->basic_salary) }}</td>
			<td>BPJS Ketengakerjaan 2% (employee)</td>
			<td style="text-align: right;">{{ number_format($item->bpjs_ketenagakerjaan2) }}</td>
		</tr>
		<tr>
			<td>Actual Salary</td>BPJS Ketengakerjaan 2% 
			<td style="text-align: right;">{{ number_format($item->salary) }}</td>
			<td>BPJS Kesehatan (1%) (employee)</td>
			<td style="text-align: right;">{{ number_format($item->	bpjs_kesehatan2) }}</td>
		</tr>
		<tr>
			<td>Call Allowance</td>
			<td style="text-align: right;">{{ number_format($item->call_allow) }}</td>
			<td>BPJS Pensiun 1% (employee)</td>
			<td style="text-align: right;"> {{ number_format($item->bpjs_pensiun2) }} </td>
		</tr>
		<tr>
			<td>Transport Allowance</td>
			<td style="text-align: right;">{{ number_format($item->transport_allowance) }}</td>
			<td>Other deduction</td>
			<td style="text-align: right;">{{ number_format($item->other_deduction) }}</td>
		</tr>
		<tr>
			<td>Homebase Allowance</td>
			<td style="text-align: right;">{{ number_format($item->homebase_allowance) }}</td>
			<td>PPH21</td>
			<td style="text-align: right;">{{ number_format($item->monthly_income_tax) }}</td>
		</tr>
		<tr>
			<td>Laptop Allowance</td>
			<td style="text-align: right;">{{ number_format($item->laptop_allowance) }}</td>
			<td></td>
			<td style="text-align: right;"></td>
		</tr>
		<tr>
			<td>Overtime Claim</td>
			<td style="text-align: right;">{{ number_format($item->overtime_claim) }}</td>
			<td></td>
			<td style="text-align: right;"></td>
		</tr>
		<tr>
			<td>Other Income</td>
			<td style="text-align: right;">{{ number_format($item->other_income) }}</td>
			<td></td>
			<td style="text-align: right;"></td>
		</tr>
		<tr>
			<td>Medical Claim</td>
			<td style="text-align: right;">{{ number_format($item->medical_claim) }}</td>
			<td></td>
			<td style="text-align: right;"></td>
		</tr>
	</table>
	<br />
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