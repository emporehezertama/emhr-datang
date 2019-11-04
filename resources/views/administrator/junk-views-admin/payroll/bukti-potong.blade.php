<!DOCTYPE html>
<html>
<head>
	<title>Bukti Potong</title>
	<style type="text/css">
		.bordered {
			 border-spacing:initial;
		}
		.bordered tr td, .bordered tr th{
			border: 0.1px solid black;
			padding-top : 5px;
			padding-bottom: 5px;
			padding-left: 5px;
		}
		* {
			font-size: 10px;
			font-family: Tahoma, Geneva, sans-serif;
		}
  		.page_break { 
  			page-break-before: always; 
  		}
		.text-blue {
			color: #327b7b
		}
		small {
			font-size: 8px;
		}
	</style>
</head>
<body>
  @foreach($data as $item)
  	@if(!isset($item->user->name))
  	<?php continue; ?>
  	@endif
	<table style="width: 100%;border-top:1px dotted black;">
		<tr>
			<td style="width: 23%;text-align: center;" rowspan="2">
				<img src="{{ asset('images/kemenkeu.png') }}" style="height: 70px;" />
				<h5 style="margin-top:0;padding-top:0;">KEMENTERIAN KEUANGAN RI DIREKTORAT JENDERAL PAJAK</h5>
			</td>	
			<td style="vertical-align: top;width: 40%;border-left: 1px solid;border-bottom: 1px solid black;border-right:1px solid black; padding-left: 10px;text-align: center;vertical-align: middle;">
				<h5 style="padding-top:0;margin-top:0;">
					BUKTI PEMOTONGAN PAJAK PENGHASILAN PASAL 21 BAGI PEGAWAI TETAP ATAU PENERIMA PENSIUN ATAU TUNJANGAN HARI TUA/JAMINAN HARI TUA BERKALA
				</h5>	
			</td>
			<td style="width: 25%;" rowspan="2">
				<h2 style="padding-bottom:0;margin-bottom:0;font-size: 13px;text-align: center;">FOMULIR 1721 - A1</h2>
				<div style="width: 80%; margin: auto;">
					<p style="padding-top:0;margin-top:0;">Lembar ke-1 : untuk Penerima Penghasilan</p>
					<p>Lembar ke-2 : untuk Pemotong</p>
				</div>
				<p><strong>MASA PEROLEHAN PENGHASILAN</strong></p>
				<p>
					<small class="text-blue">H02</small>
					<label style="border-bottom: 1px solid; width: 40px;">{{ send_bukti_potong($item->user_id,$tahun, 'start') }}</label> - <u style="width: 30px;">{{ send_bukti_potong($item->user_id,$tahun, 'end') }}</u>
				</p>
			</td>
		</tr>
		<tr>
			<td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom:1px solid black;">NOMOR : <small class="text-blue">H01</small></td>	
		</tr>
	</table>
	<table style="border: 1px solid;width: 100%;">
		<tr>
			<th style="padding-top:5px;padding-bottom:5px; width: 100px; text-align: left;">NPWP PEMOTONG</th>
			<td> : 
				<small class="text-blue">H03</small>
				<div style="border-bottom: 1px solid black; margin-left: 5px;"> 
					{{ $no_npwp }}
				</div>
			</td>
		</tr>
		<tr>
			<th style="text-align: left;">NAMA PEMOTONG</th>
		 	<td> : 
		 		<small class="text-blue">H04</small>
				<div style="border-bottom: 1px solid black; margin-left: 5px;"> 
					{{ $nama_npwp }}
				</div>
		 	</td>
		</tr>
	</table>
	<p><strong> A. IDENTITAS PENERIMA PENGHASILAN YANG DIPOTONG</strong></p>
	<table style="border: 1px solid black; width: 100%;">
		<tr>
			<td style="width: 120px;"> 1. NPWP</td>
			<td>: 
				<small class="text-blue">A01</small>
				<div style="border-bottom: 1px solid black; margin-left: 5px;"> 
					{{ $item->user->npwp_number }}
				</div>
			</td>
			<td colspan="3">6. STATUS / JUMLAH TANGGUNGAN KELUARGA UNTUK PTKP</td>
		</tr>
		<tr>
			<td> 2. NIK / NO PASPOR</td>
			<td>:
				<small class="text-blue">A02</small>
				<div style="border-bottom: 1px solid black; margin-left: 5px;"> 
			 		{{ $item->user->nik }}
			 	</div>
			 </td>
			 <td>
			 	TK/
				<small class="text-blue">A07</small>
				<div style="border-bottom: 1px solid black; margin-left: 15px;"></div>
			 </td>
			 <td>
			 	K/
				<small class="text-blue">A06</small>
				<div style="border-bottom: 1px solid black; margin-left: 5px;"></div>
			 </td>
			 <td>
			 	HB/
				<small class="text-blue">A09</small>
				<div style="border-bottom: 1px solid black; margin-left: 5px;"></div>
			 </td>
		</tr>
		<tr>
			<td> 3. NAMA</td>
			<td>: <small class="text-blue">A03</small> {{ $item->user->name }}</td>
			<td>7. NAMA JABATAN</td>
			<td>
				<small class="text-blue">A10</small>
				<div style="border-bottom: 1px solid black; margin-left: 5px;">{{ isset($item->user->structure->position) ? $item->user->structure->position->name:''}}</div>
			</td>
		</tr>
		<tr>
			<td> 4. ALAMAT</td>
			<td>: <small class="text-blue">A04</small></td>
			<td>8. KARYAWAN ASING : </td>
			<td>
				<small class="text-blue">A11</small>
				<div style="height: 15px; width: 20px; float: left; border: 1px solid; margin-left: 10px;margin-right: 5px;"></div> 
			</td>
		</tr>
		<tr>
			<td>5. JENIS KELAMIN </td>
			@if($item->user->jenis_kelamin == 'Male')
			<td>
				<label style="color: #327b7b; font-size: 8px;float: left">A05</label><div style="height: 15px; width: 20px; float: left;  border: 1px solid; margin-left: 10px;margin-right: 5px;">X</div><div style="float: left;"> LAKI-LAKI</div>
			</td>
			<td>
				<label style="color: #327b7b; font-size: 8px;float: left">A06</label><div style="height: 15px; width: 20px; float: left; border: 1px solid; margin-left: 10px;margin-right: 5px;"></div><div style="float: left;">PEREMPUAN</div>
			</td>
			@elseif($item->user->jenis_kelamin == 'Female')
			<td>
				<label style="color: #327b7b; font-size: 8px;float: left">A05</label><div style="height: 15px; width: 20px; float: left; border: 1px solid; margin-left: 10px;margin-right: 5px;"></div><div style="float: left;"> LAKI-LAKI</div>
			</td>
			<td>
				<label style="color: #327b7b; font-size: 8px;float: left">A06</label><div style="height: 15px; width: 20px; float: left;  border: 1px solid; margin-left: 10px;margin-right: 5px;">X</div><div style="float: left;">PEREMPUAN</div>
			</td>
			@else
			<td>
				<label style="color: #327b7b; font-size: 8px;float: left">A05</label><div style="height: 15px; width: 20px; float: left; border: 1px solid; margin-left: 10px;margin-right: 5px;"></div><div style="float: left;"> LAKI-LAKI</div>
			</td>
			<td>
				<label style="color: #327b7b; font-size: 8px;float: left">A06</label><div style="height: 15px; width: 20px; float: left; border: 1px solid; margin-left: 10px;margin-right: 5px;"></div><div style="float: left;">PEREMPUAN</div>
			</td>
			@endif
		</tr>
		<tr>
			<td>9. KODE NEGARA DOMISILI</td>
			<td>: <small class="text-blue">A12</small></td>
		</tr>
		
	</table>
	<p><strong> B. RINCIAN PENGHASILAN DAN PENGHITUNGAN PPh PASAL 21</strong></p>

	<table style="width: 100%;" class="bordered">
		<tr>
			<th colspan="2" style="text-align: center;"> URAIAN</th>
			<th> JUMLAH (Rp)</th>
		</tr>
		<tr>
			<th colspan="2" style="text-align: left;">
				<label style="float: left;"> KODE OBJEK PAJAK : </label>
				<div style="height: 15px; width: 25px; border: 1px solid; float: left; margin-left: 10px;margin-right: 5px;">X</div><label style="float: left;">21-100-01</label>
				<div style="height: 15px; width: 25px; border: 1px solid; float: left; margin-left: 10px;margin-right: 5px;"></div> <label style="float: left;">21-100-02</label> 
				<div style="clear: both;"></div>
			</th>
			<td>
			</td>
		</tr>
		<tr>
			<th colspan="2" style="text-align: left;"> PENGHASILAN BRUTO</th>
			<td></td>
		</tr>
		<tr>
			<td style="width: 25px;text-align: center;">1.</td>
			<td> GAJI/PENSIUN ATAU THT/JHT</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'gaji')) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">2.</td>
			<td> TUNJANGAN PPh</td>
			<td style="text-align: right;"></td>
		</tr>
		<tr>
			<td style="text-align: center;">3.</td>
			<td> TUNJANGAN LAINNYA, UANG LEMBUR DAN SEBAGAINYA</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'tunjangan')) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">4.</td>
			<td> HONORIUM DAN IMBALAN LAIN SEJENISNYA</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">5.</td>
			<td> PREMI ASURANSI YANG DIBAYAR PEMBERI KERJA</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'premi')) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">6.</td>
			<td> PENERIMAAN DALAM BENTUK NATURA DAN KENIKMATAN LAINNYA YANG DIKENAKAN PEMOTONGAN PPh PASAL 21</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">7.</td>
			<td> TANTIEM, BONUS, GRATIFIKASI, JASA PRODUKSI DAN THR</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'bonus')) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">8.</td>
			<td> JUMLAH PENGHASILAN BRUTO (1 S.D.7)</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'bruto')) }}</td>
		</tr>
		<tr>
			<th colspan="2"> PENGURANGAN : </th>
			<th></th>
		</tr>
		<tr>
			<td style="text-align: center;">9.</td>
			<td> BIAYA JABATAN/BIAYA PENSIUN</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'burden')) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">10.</td>
			<td> IURAN PENSIUN ATAU IURAN THT/JTH</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'jht')) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">11.</td>
			<td> JUMLAH PENGURANGAN (9 SD.10)</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'pengurang')) }}</td>
		</tr>
		<tr>
			<th colspan="2" style="text-align: left;"> PENGHITUNGAN PPh PASAL 21:</th>
			<th></th>
		</tr>
		<tr>
			@php($neto = 0)
			@php($neto =  (send_bukti_potong($item->user_id,$tahun, 'bruto'))-(send_bukti_potong($item->user_id,$tahun, 'pengurang')))
			<td style="text-align: center;">12.</td>
			<td> JUMLAH PENGHASILAN NETO (8 - 11)</td>
			<td style="text-align: right;">{{ format_idr($neto) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">13.</td>
			<td> PENGHASILAN NETO MASA SEBELUMNYA</td>
			<td></td>
		</tr>
		<tr>
			
			<td style="text-align: center;">14.</td>
			<td> JUMLAH PENGHASILAN NETO UNTUK PENGHITUNGAN PPh PASAL 21 (SETAHUN/DISETAHUNKAN)</td>
			<td style="text-align: right;">{{ format_idr($neto) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">15.</td>
			<td> PENGHASILAN TIDAK KENA PAJAK (PTKP)</td>
			<td style="text-align: right;">{{ format_idr(get_ptkp($item->user_id)) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">16.</td>
			<td> PENGHASILAN KENA PAJAK SETAHUN/DISETAHUNKAN (14 - 15)</td>
			<td style="text-align: right;">{{ format_idr(($neto) - (get_ptkp($item->user_id))) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">17.</td>
			<td> PPh PASAL 21 ATAS PENGHASILAN KENA PAJAK SETAHUN/DISETAHUNKAN</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'pph21')) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">18.</td>
			<td> PPh PASAL 21 YANG TELAH DIPOTONG MASA SEBELUMNYA</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">19.</td>
			<td> PPh PASAL 21 TERUTANG</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'pph21')) }}</td>
		</tr>
		<tr>
			<td style="text-align: center;">20.</td>
			<td> PPh PASAL 21 DAN PPh PASAL 26 YANG TELAH DIPOTONG DAN DILUNASI</td>
			<td style="text-align: right;">{{ format_idr(send_bukti_potong($item->user_id,$tahun, 'pph21')) }}</td>
		</tr>
	</table>
	<p><strong> C. IDENTITAS PEMOTONG</strong></p>
	<table style="width: 100%;border: 1px solid black;">
		<tr>
			<td style="width: 100px;padding-top: 10px;">1. NPWP : <small class="text-blue">C01</small></td>
			<td>{{ $no_npwp }}</td>
			<td> 3. TANGGAL & TANDA TANGAN </td>
			<td colspan="2" rowspan="2">
				<table style="width: 100%;border: 1px solid black;">
					<tr>
						<td style="width: 100px;padding-top: 15px; padding-bottom: 15px"></td>
					</tr>
					<tr>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width: 100px;padding-top: 10px;">2. NAMA : <small class="text-blue">C02</small></td>
			<td>{{ $nama_npwp }}</td>
			<td><small class="text-blue">C03</small> {{date("Y-m-d")}}</td>
			<td colspan="2" rowspan="2"></td>
		</tr>
	</table>
	<div class="page_break"></div>
  @endforeach
</body>
</html>