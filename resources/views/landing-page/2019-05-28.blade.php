<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<title>EM-HR - HRIS Application System The Best and Complete</title>
		<style type="text/css">
			body {
				font-family: "Trebuchet MS", Helvetica, sans-serif;
			}
			.bg-1 {
				background: url('{{ asset('landing-page/2019-05-28/Background1.png') }}');
				background-size: contain;
			}
			.bg-2 {
				background: url('{{ asset('landing-page/2019-05-28/Background2.png') }}');
				background-size: cover;
				padding-top: 40px;
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

			.btn_login 
			{
				color: white !important;
				background: #bfbfbf;
			    width: 100px;
			    border-radius: 0 0 17px 17px;
			    margin-top: -1px;
			    height: 45px;
			    margin-right: 25px;
			    border: 0;
			    padding-top: 10px;
			}
		</style>
		<script type="text/javascript">
			function form_free_trial()
			{
				$('html, body').animate({
			        scrollTop: $(".container_bottom").offset().top
			    }, 1000);
			}

			@if(Session::has('message-success'))
				alert("{{ Session::get('message-success') }}");
			@endif

		</script>
	</head>
<body>
	<div>
		<a href="{{ route('login') }}" class="btn btn-info float-right btn_login">Login</a>
		<div class="bg-1">
		  <div class="container" style="height: 100vh;">
			<div class="col-md-4 float-left section-1">
				<h1 style="color: #acce22; font-size: 53px;">EM-HR</h1>
				<h3 style="color: #0e9a88; font-size: 29px;">HRIS Application System The Best and Complete</h1>
				<h4 style="margin-bottom: 4px;margin-top: 15px;">Help Your Company</h4>
				<p>
					Save Up To Tens Of Millions Of Rupiah <br />
					Easy, Practical & Efficient 	
				</p>
				<button class="btn_trial_1" onclick="form_free_trial()">Free Trial Now</button>
			</div>

			<div class="col-md-8 float-left" style="height: 100vh;">
				<img src="{{ asset('landing-page/2019-05-28/Model1.png') }}" style="width: 100%; position: absolute; bottom: -41px;">
			</div>
			<div class="clearfix"></div>
		  </div>
		</div>
		<div class="bg-2">
		  <div class="container container_bottom">
			<div class="col-md-4 float-left">
				<img src="{{ asset('landing-page/2019-05-28/bubble background.png') }}" style="width: 100%; margin-left: -23px;" />
			</div>
			<h1 class="text-right"><label style="color: #0e9a88;font-size: 29px;">There is ease in</label> <label style="color: #acce22">EM-HR</label> <label  style="color: #0e9a88">Application</label></h1>
			<div class="col-md-6 float-right">

				<div class="form">
					<form method="POST" action="{{ route('post-landing-page1') }}" class="col-md-12 px-0 pt-2" style="padding-top: 0px !important; padding-bottom: 10px">
                        {{ csrf_field() }}

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif

						<div class="bg-form-title">
							<h3 style="color: white; text-align: center;font-size: 23px;padding-top: 13px !important;" class="py-2 px-0 mx-0 mt-0">Start Free Register</h3>
						</div>
						<div class="px-5 pt-4">
							<div class="form-group">
								<input type="text" class="form-control" name="nama" placeholder="Full Name" required>
							</div>
							<div class="form-group">
								<select name="jabatan" class="form-control">
									<option value=""> - Position - </option>
									<option>Owner</option>
									<option>HRD / Finance</option>
									<option>IT</option>
									<option>Others</option>
								</select>
							</div>
							<div class="form-group">
								<input type="email" class="form-control" name="email" placeholder="Email" required>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="Password" required>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="confirm" placeholder="Confirm Password" required>
							</div>
							<div class="form-group">
								<input type="input" class="form-control" name="nama_perusahaan" placeholder="Company" required>
							</div>
							<div class="form-group">
								<select class="form-control" name="bidang_usaha" required>
									<option value=""> - Choose Business Specialization - </option>
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
								<input type="text" name="handphone" class="form-control" placeholder="Handphone Number" required>
							</div>
							<!-- <div class="form-group">
								<div class="float-left px-0 mx-0" style="width: 15px">
									<input type="checkbox" name="agree" value="1" required>
								</div>
								<div class="float-left col-md-11" style="padding-left: 7px !important; padding-top: 2px !important;">
									<label style="font-size: 12px;">I have read and agree to the EM-HR.com and End User License Agreement</label>
								</div>
								<div class="clearfix"></div>
							</div> -->
						</div>
						<div class="form-group text-center">
							<button class="btn_trial_2" type="submit">Create an Free Trial Account</button>
						</div>
					</form>
				</div>
			</div>
			<div class="clearfix"></div>			
		</div>
		<div>
			<img src="{{ asset('landing-page/2019-05-28/line botton.png') }}" class="mb-4" style="width: 100%; margin-top: 1%">
		</div>
	  </div>
	</div>
</body>
</html>