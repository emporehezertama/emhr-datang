<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<title>EM-HR - HRIS Application System The Best and Complete</title>
		<style type="text/css">
			.bg-1 {
				background: url('{{ asset('landing-page/2019-05-28/Background1.png') }}');
				background-size: contain;
			}
			.bg-2 {
				background: url('{{ asset('landing-page/2019-05-28/Background2.png') }}');
				background-size: cover;
			}
			.form form {
				background: white;
			}
			.btn_trial_1 {
				background: url('{{ asset('landing-page/2019-05-28/button trial now.png') }}');
				background-size: cover;
				border: 0;
				width: 252px;
				height: 45px;
				color : white;
				font-size: 20px;
				cursor: pointer;
			}
			.btn_trial_2 {
				background: url('{{ asset('landing-page/2019-05-28/button trial now.png') }}');
				background-size: cover;
				border: 0;
				width: 303px;
				height: 54px;
				color : white;
				font-size: 20px;
			}
			.btn_trial_3 {
				background: url('{{ asset('landing-page/2019-05-28/button trial now.png') }}');
				background-size: cover;
				border: 0;
				width: 303px;
				height: 54px;
				color : white;
				font-size: 20px;
			}
			.bg-form-title {
				background: url('{{ asset('landing-page/2019-05-28/button trial start register.png') }}');
				background-size: cover;
				border: 0;
				width: 100%;
				height: 54px;
				color : white;
				font-size: 20px;
			}
			.section-1 {
				margin-top: 15%;
			}
		</style>
		<script type="text/javascript">
			function form_free_trial()
			{
				$('html, body').animate({
			        scrollTop: $(".form").offset().top
			    }, 1000);
			}
		</script>
	</head>
<body>
	<div>
		<div class="bg-1" style="height: 100vh;">
		  <div class="container">
			<div class="col-md-4 float-left section-1">
				<h1 style="color: #acce22">EM-HR</h1>
				<h3 style="color: #0e9a88">HRIS Application System The Best and Complete</h1>
				<h4>Help Your Company</h4>
				<p>
					Save Up To Tens Of Millions Of Rupiah <br />
					Easy, Practical & Efficient 	
				</p>
				<button class="btn_trial_1" onclick="form_free_trial()">Free Trial Now</button>
			</div>
			<div class="col-md-68 float-left">
				<img src="{{ asset('landing-page/2019-05-28/Model1.png') }}" style="width: 100%; margin-top: 10%">
			</div>
			<div class="clearfix"></div>
		  </div>
		</div>
		<div class="bg-2">
		  <div class="container">
			<div class="col-md-4 float-left">
				<img src="{{ asset('landing-page/2019-05-28/bubble background.png') }}" style="width: 100%;" />
			</div>
			<div class="col-md-8 float-right">
				<div class="form">
					<h1 class="text-center"><label style="color: #0e9a88">There is ease in</label> <label style="color: #acce22">EM-HR</label> <label  style="color: #0e9a88">Application</label></h1>
					<form method="POST" action="{{ route('post-landing-page1') }}" class="col-md-12 px-0 pt-2" style="padding-top: 0px !important; padding-bottom: 10px">
                        {{ csrf_field() }}
						<div class="bg-form-title">
							<h3 style="color: white; text-align: center;font-size: 23px;padding-top: 13px !important;" class="py-2 px-0 mx-0 mt-0">Start Free Register</h3>
						</div>
						<div class="px-5 pt-4">
							<div class="form-group">
								<input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required>
							</div>
							<div class="form-group">
								<select name="jabatan" class="form-control">
									<option value=""> - Jabatan - </option>
									<option>Owner</option>
									<option>HRD / Finance</option>
									<option>IT</option>
									<option>Lainnya</option>
								</select>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="Email" required>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="Password" required>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="confirm" placeholder="Konfirmasi Password" required>
							</div>
							<div class="form-group">
								<input type="input" class="form-control" name="nama_perusahaan" placeholder="Nama Perusahaan" required>
							</div>
							<div class="form-group">
								<select class="form-control" name="bidang_usaha" required>
									<option value=""> - Pilih Bidang Usaha - </option>
									<option>Asuransi</option>
									<option>Barang Hasil Kerajinan</option>
									<option>Barang-Barang Konsumen</option>
									<option>Bunga dan Tanaman Hias</option>
									<option>Distribusi dan Pemasaran</option>
									<option>Elektronika</option>
									<option>Event Organizer</option>
									<option>Farmasi</option>
									<option>Furniture</option>
									<option>Hewan Peliharaan</option>
									<option>Kayu dan Pengolahannya</option>
									<option>Keramik  Porselen dan Kaca</option>
									<option>Klinik dan Rumah Sakit</option>
									<option>Komputer dan Perangkatnya</option>
									<option>Konsultan</option>
									<option>Koperasi</option>
									<option>Kosmetik</option>
									<option>Lembaga Keuangan Lain</option>
									<option>Lembaga Pemerintah</option>
									<option>Lembaga Sosial</option>
									<option>Mainan</option>
									<option>Makanan dan Minuman</option>
									<option>Manufaktur</option>
									<option>Otomotif</option>
									<option>Pakan Ternak </option>
									<option>Pemasok</option>
									<option>Pendidikan dan Pelatihan</option>
									<option>Peralatan Kantor</option>
									<option>Peralatan Rumah Tangga</option>
									<option>Percetakan dan Media Massa</option>
									<option>Perdagangan Eceran</option>
									<option>Perhiasan</option>
									<option>Perhotelan dan Pariwisata</option>
									<option>Perikanan</option>
									<option>Periklanan</option>
									<option>Perkebunan</option>
									<option>Pertanian</option>
									<option>Perusahaan Investasi </option>
									<option>Peternakan</option>
									<option>Plastik dan Kemasan</option>
									<option>Promosi dan Periklanan </option>
									<option>Property and Real Estate</option>
									<option>Restoran dan Katering </option>
									<option>Rokok </option>
									<option>Salon dan Spa</option>
									<option>Teknologi Informatika</option>
									<option>Telekomunikasi </option>
									<option>Transportasi dan Ekspedisi </option>
									<option>Kontraktor dan Industrial</option>
									<option>Wedding Organizer</option>
									<option>Bisnis Retail</option>
									<option>Industri Jamu dan Wisata Herbal</option>
									<option>Bisnis Laundry</option>
									<option>Konstruksi dan Pembangunan</option>
								</select>
							</div>
							<div class="form-group">
								<input type="text" name="" class="form-control" placeholder="Handphone" required>
							</div>
							<div class="form-group">
								<label><input type="checkbox" name="agree" value="1" required> I have read and agree to the EM-HR.com and End User Terms and Conditions & Agreement  </label>
							</div>
						</div>
						<div class="form-group text-center">
							<button class="btn_trial_2" type="submit">Create an Free Trial Account</button>
							<hr />
						</div>
					</form>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	  </div>
	</div>
	<img src="{{ asset('landing-page/2019-05-28/line botton.png') }}" class="mb-4" style="width: 100%; margin-top: 10%">
</body>
</html>