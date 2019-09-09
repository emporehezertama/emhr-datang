<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	<style type="text/css">
		td {
			border: 1px solid #000000;
		}	
	</style>
</head>
@php($user = \App\User::where('id', $user_id)->first())
<body>
	<h2>{{ $user->nik }} / {{ $user->name }}</h2>
	<br />
	<h3>PPh 21 Calculation</h3>
	<br />
	<table class="border">
		<tbody>
			<tr>
				<th style="width: 45px;border: 1px solid #000000;background: #7f7f7f;color: #ffffff;"><strong>Month</strong></th>
				<th  style="width: 30px;background:#7f7f7f;border: 1px solid #000000;color: #ffffff;">EM - HR</th>
        		@for ($month = 1; $month <= 12; $month++) 
        		<th style="color: #ffffff;background: #7f7f7f;text-align: center;border: 1px solid #000000; width: 15px">{{ date('M', mktime(0, 0, 0, $month, 10)) }}</th>
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000">Monthly PPH 21</td>	
				<td style="border: 1px solid #000000">MONTHLY INCOME TAX</td>	
				@for ($month = 1; $month <= 12; $month++) 
        		<th style="border: 1px solid #000000; width: 25px">{{ format_idr( isset($data[$month]->pph21) ? $data[$month]->pph21 : 0) }}</th>
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000;">Cummulative PP21 (PAID)</td>
				<td style="border: 1px solid #000000;"></td>
				@php($commulative_pph21 = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($commulative_pph21 += isset($data[$month]->pph21) ? $data[$month]->pph21 : 0)
        		<th style="border: 1px solid #000000; width: 15px">
        			{{ format_idr( $commulative_pph21) }}
        		</th>
				@endfor
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td><strong>YTD</strong></td>
			</tr>
	@for ($month = 1; $month <= 12; $month++) 
		@php($gross[$month] = 0 )
		@php($total_deduction[$month] = 0 )
	@endfor
			<tr>
				<td style="background: #7f7f7f;border: 1px solid #000000;width: 32px;color: #ffffff;"> Earnings (Salary and Overtime) </td>
				<td style="background: #7f7f7f;border: 1px solid #000000; width: 30px;color: #ffffff;">  EM - HR </td>
				@for ($month = 1; $month <= 12; $month++) 
	        		<th style="border: 1px solid #000000;background: #7f7f7f; width: 15px;color: #ffffff;">{{ date('M', mktime(0, 0, 0, $month, 10)) }}</th>
				@endfor
			</tr>
			<tr>
				<td> Basic salary w.o. Tunjangan Pajak</td>
				<td> SALARY </td>
				@php($gross_year = 0)
				@php($salary = 0)
				@php($salary_ = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($salary += get_payroll_history_param($user_id, $year, $month, 'salary') )
				
				@if($salary !=0 and $salary_==0)
					@php($salary_ = $salary)
				@endif

				@php($gross_year += get_payroll_history_param($user_id, $year, $month, 'salary'))
        		<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($salary) }}</th>
        		@php($gross[$month] += $salary)
				@endfor
			</tr>
			@foreach(get_earnings() as $key => $item)
			 <tr>
				<td style="border: 1px solid #000000;">{{ $item->title }}</td>
				<td style="border: 1px solid #000000;">EARNING {{ $key+1 }}</td>
				@php($earning = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($earning += get_payroll_earning_history_param((isset($data[$month]->id) ? $data[$month]->id : 0), $year, $month, $item->id))
        		<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($earning) }}</th>
        		@php($gross[$month] += $earning)
				@endfor
			 </tr>
			@endforeach
			<tr>
				<td style="border: 1px solid #000000;"> Jaminan Kecelakaan Kerja (JKK) - paid for by company </td>
				<td style="border: 1px solid #000000;"> BPJS JKK (company) </td>
				@php($bpjs1 = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($bpjs1 += get_payroll_history_param($user_id, $year, $month, 'bpjs_jkk_company'))
				<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($bpjs1) }}</th>
        		@php($gross[$month] += $bpjs1)
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000;"> Jaminan Kematian (JK) - paid for by company </td>
				<td style="border: 1px solid #000000;"> BPJS JKematian (company) </td>
				@php($bpjs2 = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($bpjs2 += get_payroll_history_param($user_id, $year, $month, 'bpjs_jkm_company') )
				<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($bpjs2) }}</th>
        		@php($gross[$month] += $bpjs2)
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000;"> BPJS Kesehatan </td>
				<td style="border: 1px solid #000000;"> BPJS Kesehatan (company) </td>
				@php($bpjs3 = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($bpjs3 += get_payroll_history_param($user_id, $year, $month, 'bpjs_kesehatan_company') )
				<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($bpjs3) }}</th>
        		@php($gross[$month] += $bpjs3)
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000;"> THR/Bonus </td>
				<td style="border: 1px solid #000000;"> </td>
				@php($bonus = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($bonus += get_payroll_history_param($user_id, $year, $month, 'bonus') )
				<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($bonus) }}</th>
        		@php($gross[$month] += $bonus)
				@endfor
			</tr>
			<tr>
				<th style="border: 1px solid #000000;background: #deeaf6;"> Gross Salary / ytd (A) </th>
				<th style="background: #deeaf6;"> </th>
				@for ($month = 1; $month <= 12; $month++) 
        		<th style="border: 1px solid #000000; width: 15px;background: #deeaf6;"><strong>{{ format_idr($gross[$month]) }}</strong></th>
				@endfor
			</tr>
			<tr>
				<td style="background: #7f7f7f;border: 1px solid #000000;color: #ffffff;">  Deductions </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
				<td style="background: #7f7f7f;border: 1px solid #000000;"> </td>
			</tr>

			<tr>
				<td style="border: 1px solid #000000;"> Tunjangan Jabatan</td>
				<td style="border: 1px solid #000000;"> 5% * SALARY</td>
				@php($tunjangan = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($tunjangan += get_payroll_history_param($user_id, $year, $month, 'burden_allow'))
        		<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($tunjangan) }}</th>
        		@php($total_deduction[$month] += $tunjangan)
        		@endfor
			</tr>
		
			<tr>
				<td style="border: 1px solid #000000;"> Jaminan Tunjangan Hari Tua (JHT) - Staff</td>
				<td style="border: 1px solid #000000;"> BPJS JHT (employee)</td>
				@php($bpjs1 = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($bpjs1 += get_payroll_history_param($user_id, $year, $month, 'bpjs_ketenagakerjaan_employee'))
				<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($bpjs1) }}</th>
        		@php($total_deduction[$month] += $bpjs1)
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000;"> Jaminan Pension (JP) - Staff</td>
				<td style="border: 1px solid #000000;"> BPJS JP (employee)</td>
				@php($bpjs2 = 0)
				@for ($month = 1; $month <= 12; $month++) 
				@php($bpjs2 += get_payroll_history_param($user_id, $year, $month, 'bpjs_pensiun_employee'))
				<th style="border: 1px solid #000000; width: 15px;">{{ format_idr($bpjs2) }}</th>
        		@php($total_deduction[$month] += $bpjs2)
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000; background: #deeaf6;"> <strong>Total Deductions/ ytd (B)</strong></td>
				<td style="border: 1px solid #000000; background: #deeaf6;"> </td>
				@for ($month = 1; $month <= 12; $month++) 
				<td style="border: 1px solid #000000; background: #deeaf6;"><strong>{{ format_idr($total_deduction[$month]) }}</strong></td>
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000;"> Nett Salary / ytd (A-B) </td>
				<td style="border: 1px solid #000000;"> </td>
				@for ($month = 1; $month <= 12; $month++) 
        		<th style="border: 1px solid #000000; width: 15px;background: #deeaf6;">{{ format_idr($gross[$month] - $total_deduction[$month]) }}</th>
				@endfor
			</tr>
			<tr>
				<td style="border: 1px solid #000000;"> Nett Salary / year (C ) </td>
				<td style="border: 1px solid #000000;"> </td>
				@for ($month = 1; $month <= 12; $month++)
        		<th style="border: 1px solid #000000; width: 15px;background: #deeaf6;">{{ format_idr((($gross[$month] - $total_deduction[$month])*12 / $month)) }}</th>
				@endfor

			</tr>
			<tr>
				<td style="border: 1px solid #000000;"> PTKP Status</td>
				<td style="border: 1px solid #000000;"> PTKP Status</td>
				@for ($month = 1; $month <= 12; $month++) 
	        		<th style="border: 1px solid #000000; width: 15px;">
					@if($user->marital_status == 'Bujangan/Wanita')
	        			TK/0
	        		@endif
	        		@if($user->marital_status == 'Menikah')
	        			K/0
	        		@endif
	        		@if($user->marital_status == 'Menikah Anak 1')
	        			K/1
	        		@endif
	        		@if($user->marital_status == 'Menikah Anak 2')
	        			K/2
	        		@endif
	        		@if($user->marital_status == 'Menikah Anak 3')
	        			K/3
	        		@endif
        		</th>
				@endfor	
			</tr>
			<tr>
				<td style="border: 1px solid #000000; background: #deeaf6;"> <strong> PTKP / year (E) </strong></td>
				<td style="border: 1px solid #000000; background: #deeaf6;">  PTKP value </td>
				@for ($month = 1; $month <= 12; $month++) 
        		<th style="border: 1px solid #000000; width: 15px; background: #deeaf6;">{{ format_idr( get_ptkp($user_id)) }}</th>
				@endfor	
			</tr>
			<tr>
				<td style="border: 1px solid #000000; background: #deeaf6;"> <strong> Penghasilan Kena Pajak PKP / year (D-E) </strong></td>
				<td style="border: 1px solid #000000; background: #deeaf6;"> </td>
				@for ($month = 1; $month <= 12; $month++) 
        		<th style="border: 1px solid #000000; width: 15px; background: #deeaf6;">{{ format_idr(((($gross[$month] - $total_deduction[$month])*12 / $month) - get_ptkp($user_id))) }}</th>
				@endfor	
			</tr>
			<tr>
				<td style="border: 1px solid #000000; background: #deeaf6;"> <strong> PPh terutang / year</strong></td>
				<td style="border: 1px solid #000000; background: #deeaf6;"></td>
				@for ($month = 1; $month <= 12; $month++)  
				<td style="border: 1px solid #000000; background: #deeaf6;">
					@php($pph_terutang = ((($gross[$month] - $total_deduction[$month])*12 / $month) - get_ptkp($user_id)))
					{{ format_idr( getpphYear($pph_terutang)) }}
				</td>
				@endfor
			</tr>
		</tbody>
	</table>
</body>
</html>