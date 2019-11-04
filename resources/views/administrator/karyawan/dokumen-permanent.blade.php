<!DOCTYPE html>
<html>
<head>
	<title>Dokument Kontrak</title>
<style type="text/css">
	.col {
		width: 50%;
		float: left;
	}

	body {
		font-size: 13px;
		text-align: justify;
	}

</style>
</head>
<body>
	<div class="col">
		<h4 style="text-align: center; ">PERJANJIAN KERJA WAKTU TIDAK TERTENTU</h4>
		<ol>
			<li>
				<table style="width: 100%;">
					<tr>
						<td style="width: 50px;">Nama   </td>
						<td>: PT. EMPORE HEZER TAMA</td>
					</tr>
					<tr>
						<td>Alamat</td> 
						<td>: </td>
					</tr>
				</table>

				<p>Yang dalam hal ini diwakili oleh XXX selaku Kuasa Direksi Perseroan yaitu berdasarkan Surat Kuasa No. 029/DK/IV/14  tgl 1 Mei 2014.
					Untuk selanjutnya disebut sebagai Pihak Pertama/ Perusahaan.
				</p>
			</li>
			<li>
				<table style="width: 100%;">
					<tr>
						<td style="width: 80px;">Nama</td>
						<td>: {{ $data->name }}</td>
					</tr>
					<tr>
						<td>Tempat </td>
						<td>: {{ $data->tempat_lahir }}</td>
					</tr>
					<tr>
						<td>Tgl Lahir</td>
						<td>: {{ $data->tanggal_lahir }}</td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>: {{ $data->alamat }}</td>
					</tr>
				</table>
				<p>Bertindak untuk dan atas nama sendiri, untuk selanjutnya disebut sebagai Pihak Kedua / Pekerja.</p>

			</li>
		</ol>
		<p style="padding-left: 10px;padding-right: 10px;">
			Latar Belakang<br /><br />

			Perusahaan membutuhkan jasa tenaga ahli dan/atau jasa pelayanan pekerjaan untuk memenuhi keperluan beberapa Proyek (selanjutnya disebut ''Klien'')<br />

			Pada hari ini tanggal {{ $data->join_date }}  di Jakarta  kedua belah pihak telah sepakat untuk mengadakan perjanjian kerja waktu tertentu dengan ketentuan di bawah ini :<br />
		</p>
		<br />
		<p style="text-align: center;"><strong>PASAL 1<br />
			Jangka Waktu Perjanjian</strong>
			</p>
		<ol>
			<li>
				Perjanjian Kerja Waktu Tertentu ini berlaku terhitung mulai {{ $data->join_date }}.

				<p>Perjanjian Kerja ini adalah bagian dari MPA</p>
			</li>
			<li>
				Apabila Perjanjian Kerja Waktu Tertentu akan diper-panjang, Perusahaan akan memberikan pemberitahu-an tertulis selambat-lambatnya empat belas (14) hari di muka sebelum masa Kontrak berakhir.
			</li>
		</ol>
	</div>
	<div class="col">
		<h4 style="text-align: center; ">EMPLOYMENT AGREEMENT FOR INDEFINITE PERIOD</h4>
		<ol>
			<li>
				<table style="width: 100%;">
					<tr>
						<td style="width: 50px;">Nama</td>
						<td>: PT. EMPORE HEZER TAMA</td>
					</tr>
					<tr>
						<td>Address</td>
						<td> : </td>
					</tr>
				</table>
				<p>In this case is represented by ERIKA as Board of Directors’ Agent of the company under the Power of Attorney  No. 029/DK/IV/14  date  1st Mei 2014.
				Hereinafter called First Party/Employer</p>
			</li>
			<li>
				<table style="width: 100%;">
					<tr>
						<td style="width: 80px;">Name </td>
						<td>: {{ $data->name }}</td>
					</tr>
					<tr>
						<td>Place</td>
						<td>: {{ $data->tempat_lahir }}</td>
					</tr>
					<tr>
						<td>Birth Date</td>
						<td>: {{ $data->tanggal_lahir }}</td>
					</tr>
					<tr>
						<td>Address</td>
						<td>: {{ $data->alamat }}</td>
					</tr>
				</table>
				<p>Acting for and on my own behalf, hereinafter called Second Party / Employee.</p>
			</li>
		</ol>
		<p style="padding-left: 10px;padding-right: 10px;">
			Background<br /><br />

			Company has a demand for expertise and or task base services to be seconded for several Project partners (which further called as ''Client'').<br />
			
			On this day {{ $data->join_date }}  in Jakarta  the parties have agreed to enter into an employment agreement For definite period, under the following terms and conditions:<br />
		</p>
		<br />
			<p style="text-align: center;"><strong>
				ARTICLE 1<br />
				Period of Employment Agreement
			</strong></p>

		<ol>
			<li>
				This Employment Agreement for Definite Period shall become effective starting from  {{ $data->join_date }}.
				<p>This agreement is part of MPA.</p>
			</li>
			<li>
				If the Employment Agreement For Definite Period is to be extended, the Company shall inform in writing not later than fourteen (14) notice days prior to the contract expiration. 
			</li>
		</ol>
	</div>
</body>
</html>