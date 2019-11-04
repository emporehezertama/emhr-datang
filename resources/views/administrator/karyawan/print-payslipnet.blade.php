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
	<h3>PAY-SLIP</h3>
	<br />
	<table style="width: 100%;">
		<tr>
			<th style="color: #538135;">PERIODE</th>
			<th style="color: #538135;">PAYMENT METHOD</th>
			<th style="color: #538135;">BANK</th>
		</tr>
		<tr>
			<td style="padding-bottom: 30px;"></td>
			<td style="padding-bottom: 30px;">Direct Transfer</td>
			<td style="padding-bottom: 30px;">{{ isset($data->user->bank->name) ? $data->user->bank->name : '' }}</td>
		</tr>
		<tr>
			<th style="color: #538135;">DIVISI/TEAM</th>
			<th style="color: #538135;">EMPLOYEE NAME</th>
			<th style="color: #538135;">E-MAIL</th>
		</tr>
		<tr>
			<td>{{ $data->user->organisasi_job_role }}</td>
			<td>{{ $data->user->name }}</td>
			<td>{{ $data->user->email }}</td>
		</tr>
	</table>
	<br />
	<table style="width: 100%;" class="border">
		<tr>
			<th colspan="2" style="padding-bottom: 15px;padding-top: 15px;">INCOME</th>
			<th colspan="2">DEDUCTION</th>
		</tr>
		<tr>
			<td><strong>Basic Salary</strong></td>
			<td style="text-align: right;">{{ number_format($data->salary) }}</td>
			<td>PPh 21</td>
			<td style="text-align: right;">{{ number_format($data->monthly_income_tax) }}</td>
		</tr>
		<tr>
			<td>Position Allowance</td>
			<td style="text-align: right;">{{ $data->burden_allow }}</td>
			<td>BPJS Ketenagakerjaan</td>
			<td style="text-align: right;">{{ $data->jamsostek_result }}</td>
		</tr>
		<tr>
			<td>Call Allowance</td>
			<td style="text-align: right;">0</td>
			<td>BPJS Kesehatan</td>
			<td style="text-align: right;">0</td>
		</tr>
		<tr>
			<td>Transport Allowance</td>
			<td style="text-align: right;">0</td>
			<td>Pemotongan Lain-lain</td>
			<td style="text-align: right;">0</td>
		</tr>
		<tr>
			<td>THR</td>
			<td style="text-align: right;">{{ $data->bonus }}</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Bonus Project</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Overtime</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>BPJS Ketenagakerjaan</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>BPJS Kesehatan</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Other Income</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<th>Total Income</th>
			<th style="text-align: right;">{{ number_format($data->thp*12) }}</th>
			<th>Total Deduction</th>
			<th style="text-align: right;">{{ number_format($data->less * 12) }}</th>
		</tr>
	</table>
	<br />
	<!-- <div style="page-break-before:always"></div> -->
	<p><strong>Net Salary</strong><br />
		<label style="font-size: 10px;">Take Home Pay</label>
	</p>

	<h3>IDR {{ number_format($data->thp*12) }}</h3>
</body>
</html>