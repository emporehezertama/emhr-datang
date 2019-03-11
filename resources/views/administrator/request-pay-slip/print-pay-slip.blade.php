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
	<table style="width: 100%">
		<tr>
			<td style="width: 50%;vertical-align: top;">
				<table style="width: 100%;" class="border">
					<tr>
						<th style="padding-bottom: 15px;padding-top: 15px;">Income Description</th>
						<th style="text-align: right;">Amount</th>
					</tr>
					<tr>
						<td>Salary</td>
						<td style="text-align: right;">{{ number_format($item->salary) }}</td>
					</tr>
					<tr>
						<td>Bonus / THR</td>
						<td style="text-align: right;">{{ number_format($item->bonus) }}</td>
					</tr>
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
			<td style="width: 50%;vertical-align: top;">
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
						<td style="text-align: right;">{{ number_format($item->salary * get_setting('bpjs_kesehatan_employee') / 100) }}</td>
					</tr>
					<tr>
						<td>BPJS Jaminan Pensiun (JP) {{ get_setting('bpjs_jaminan_jp_employee') }}% (Employee)</td>
						<td style="text-align: right;"> {{ number_format($item->salary * get_setting('bpjs_jaminan_jp_employee') / 100) }} </td>
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
	@if($total == 0)
	@elseif(($k+1) != $total)
		<div style="page-break-before:always"></div>
	@endif
	@endforeach
</body>
</html>