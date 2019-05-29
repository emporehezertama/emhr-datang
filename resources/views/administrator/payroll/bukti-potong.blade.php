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
		}
		* {
			font-size: 10px;
			font-family: Tahoma, Geneva, sans-serif;
		}
	</style>
</head>
<body>
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
			<td style="width: 25%">
				<h4 style="padding-bottom:0;margin-bottom:0;">FOMULIR 1721 - A1</h4>
				<p style="padding-top:0;margin-top:0;">Lembar ke-1 : untuk Penerima Penghasilan</p>
				<p>Lembar ke-2 : untuk Pemotong</p>
			</td>
		</tr>
		<tr>
			<td style="border-left: 1px solid black;border-bottom:1px solid black;">NOMOR : </td>	
		</tr>
	</table>
	<table style="border: 1px solid;width: 100%;">
		<tr>
			<th style="padding-top:5px;padding-bottom:5px;">NPWP<br /> PEMOTONG</th>
			<td> : </td>
		</tr>
		<tr>
			<th>NAMA<br /> PEMOTONG</th>
			<td> : </td>
		</tr>
	</table>
	<p>A. IDENTITAS PENERIMA PENGHASILAN YANG DIPOTONG</p>
	<table style="border: 1px solid black; width: 100%;">
		<tr>
			<td>1. NPWP</td>
			<td>: </td>
		</tr>
		<tr>
			<td>2. NIK / NO PASPOR</td>
			<td>: </td>
		</tr>
		<tr>
			<td>3. NAMA</td>
			<td>: </td>
		</tr>
		<tr>
			<td>4. ALAMAT</td>
			<td>: </td>
		</tr>
	</table>
	<p>B. RINCIAN PENGHASILAN DAN PENGHITUNGAN PPh PASAL 21</p>

	<table style="width: 100%;" class="bordered">
		<tr>
			<th colspan="2" style="text-align: center;">URAIAN</th>
			<th>JUMLAH</th>
		</tr>
		<tr>
			<th colspan="2">KODE OBJEK PAJAK</th>
			<td></td>
		</tr>
		<tr>
			<th colspan="2">PENGHASILAN BRUTO</th>
			<td></td>
		</tr>
		<tr>
			<td style="width: 25px;text-align: center;">1.</td>
			<td>GAJI/PENSIUN ATAU THT/JHT</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">2.</td>
			<td>TUNJANGAN PPh</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">3.</td>
			<td>TUNJANGAN LAINNYA, UANG LEMBUR DAN SEBAGAINYA</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">4.</td>
			<td>HONORIUM DAN IMBALAN LAIN SEJENISNYA</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">5.</td>
			<td>PREMI ASURANSI YANG DIBAYAR PEMBERI KERJA</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">6.</td>
			<td>PENERIMAAN DALAM BENTUK NATURA DAN KENIKMATAN LAINNYA YANG DIKENAKAN PEMOTONGAN PPh PASAL 21</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">7.</td>
			<td>TANTIEM, BONUS, GRATIFIKASI, JASA PRODUKSI DAN THR</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">8.</td>
			<td>JUMLAH PENGHASILAN BRUTO (1 S.D.7)</td>
			<td></td>
		</tr>
		<tr>
			<th colspan="2">PENGURANGAN : </th>
			<th></th>
		</tr>
		<tr>
			<td style="text-align: center;">9.</td>
			<td>BIAYA JABATAN/BIAYA PENSIUN</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">10.</td>
			<td>IURAN PENSIUN ATAU IURAN THT/JTH</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">11.</td>
			<td>JUMLAH PENGURANGAN (9 SD.10)</td>
			<td></td>
		</tr>
		<tr>
			<th colspan="2" style="text-align: left;">PENGHITUNGAN PPh PASAL 21:</th>
			<th></th>
		</tr>
		<tr>
			<td style="text-align: center;">12.</td>
			<td>JUMLAH PENGHASILAN NETO (8 - 11)</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">13.</td>
			<td>PENGHASILAN NETO MASA SEBELUMNYA</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">14.</td>
			<td>JUMLAH PENGHASILAN NETO UNTUK PENGHITUNGAN PPh PASAL 21 (SETAHUN/DISETAHUNKAN)</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">15.</td>
			<td>PENGHASILAN TIDAK KENA PAJAK (PTKP)</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">16.</td>
			<td>PENGHASILAN KENA PAJAK SETAHUN/DISETAHUNKAN (14 - 15)</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">17.</td>
			<td>PPh PASAL 21 ATAS PENGHASILAN KENA PAJAK SETAHUN/DISETAHUNKAN</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">18.</td>
			<td>PPh PASAL 21 YANG TELAH DIPOTONG MASA SEBELUMNYA</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">19.</td>
			<td>PPh PASAL 21 TERUTANG</td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: center;">20.</td>
			<td>PPh PASAL 21 DAN PPh PASAL 26 YANG TELAH DIPOTONG DAN DILUNASI</td>
			<td></td>
		</tr>
	</table>
	<p>C. IDENTITAS PEMOTONG </p>
	<table style="width: 100%;border: 1px solid black;">
		<tr>
			<td>1. NPWP </td>
			<td style="border-bottom: 1px solid black;"></td>
		</tr>
		<tr>
			<td>2. NAMA </td>
			<td style="border-bottom: 1px solid black;"></td>
		</tr>
	</table>
</body>
</html>