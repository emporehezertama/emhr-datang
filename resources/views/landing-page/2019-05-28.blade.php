<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<script src="{{ asset('js/bootbox.min.js') }}"></script>
		
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
				cursor: pointer;
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
		<div class="bg-2" >
		  <div class="container">
			<div class="row" > 
				<div class="col-md-4 float-left section-1">
					<h1 style="color: #acce22; font-size: 53px;">EM-HR</h1>
					<h3 style="color: #0e9a88; font-size: 29px;">HRIS Application System The Best and Complete</h1>
					<h4 style="margin-bottom: 4px;margin-top: 15px;">Help Your Company</h4>
					<p>
						Save Up To Tens Of Millions Of Rupiah <br />
						Easy, Practical & Efficient 	
					</p>
					<button class="btn_trial_1" onclick="form_free_trial()">Create Member</button>
				</div>

				<div class="col-md-8 float-right section-1" >
					<img src="{{ asset('landing-page/2019-05-28/modelEMHRsmall.png') }}" style="width: 125%; position: absolute; bottom: -10px; right: -195px;">
				</div>
			</div>
		  </div>



			<div class="container" >
				<div class="col-md-6 float-left section-1" >
					<iframe width="100%" height="320px" src="https://www.youtube.com/embed/y8h1fB7lSIQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<div class="col-md-6 float-right section-1">
					<h1 style="font-size: 320%; font-weight: 800; color: #0E9A88;">Em-HR System</h1>
					<h5 style="text-align: justify;">Still choosing the application that suit your office needs ? Now comes the web based Em-HR application 
						that makes it easy for Business Owner and HRD to manage and analyze employee performance</h5>

				</div>
				<div class="clearfix"></div>
			</div>
			<div class="container" style="margin-top: 7%; ">
				<div style="margin: 50px 0;">
					<div class="row">
						<div class="col-md-12" style="text-align: center; margin-bottom: 20px;">
							<h1 style="font-size: 320%; font-weight: 800;">Why do we have to use the system <span style="color: #0E9A88;">Em-HR</span> ?</h1>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<img style="margin: 0 25%; width: 30%;" src="{{ asset('landing-page/2019-05-28/simple-and-easy.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 15% 5% 5%; text-align: center; font-size: 18px;">
								<h3>Simple and Easy to Use</h3>
							</div>
						</div>
						<div class="col-md-4">
							<img style="margin: 0 30%;  width: 40%;" src="{{ asset('landing-page/2019-05-28/Complete Features.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 5% 10%; text-align: center; font-size: 18px;">
								<h3>Complete Features</h3>
							</div>
						</div>
						<div class="col-md-4">
							<img style="margin: 0 30%;  width: 53%;" src="{{ asset('landing-page/2019-05-28/Affordable Prices.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 5% 20%; text-align: center; font-size: 18px;">
								<h3>Affordable Prices</h3>
							</div>
						</div>
					</div>
				</div>
				


				<div>
					<div class="row" style="margin-top: 10%; margin-bottom: 3%;">
						<div class="col-md-12" style="text-align: center;">
							<h2 style="font-size: 320%; font-weight: 800;">What feature do you get from</h2>
							<h2 style="font-size: 360%; font-weight: 800; color: #0E9A88;">the Em-HR System?</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4" >
							<img style="margin: 0 35%; width: 40%;" alt="leave and permit" src="{{ asset('landing-page/2019-05-28/Core HR.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 5% 15%; text-align: center; font-size: 18px;">
								<p>Standard modules that are often used in managing human resource</p>
							</div>
						</div>
						<div class="col-md-4" >
							<img style="margin: 0 35%; width: 40%;" alt="leave and permit" src="{{ asset('landing-page/2019-05-28/Payroll.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 5% 15%; text-align: center; font-size: 18px;">
								<p>Detail of personal pay rate calculation net / gross</p>
							</div>
						</div>
						<div class="col-md-4" >
							<img style="margin: 0 35%; width: 60%;" alt="Leave and permit" src="{{ asset('landing-page/2019-05-28/Leave and permit.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 5% 15%; text-align: center; font-size: 18px;">
								<p>For employee who will apply for leave or for permission</p>
							</div>
						</div>


						<div class="col-md-4" >
							<img style="margin: 0 15%; width: 75%;" alt="Payment Request" src="{{ asset('landing-page/2019-05-28/Payment Request.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 5% 15%; text-align: center; font-size: 18px;">
								<p>Advance Claim or any payment related to employee task</p>
							</div>
						</div>
						<div class="col-md-4" >
							<img style="margin: 0 14%; width: 80%;" alt="Overtime Request" src="{{ asset('landing-page/2019-05-28/Overtime Request.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 5% 15%; text-align: center; font-size: 18px;">
								<p>Determine calculation of overtime rate in terms of number of hours and wages</p>
							</div>
						</div>
						<div class="col-md-4" >
							<img style="margin: 0 8%; width: 112%;" alt="Medical Reimbursement" src="{{ asset('landing-page/2019-05-28/Medical Reimbursement.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 5% 15%; text-align: center; font-size: 18px;">
								<p>Advance claim or any payment related to employee task</p>
							</div>
						</div>


						<div class="col-md-4" >
							<img style="margin: 0 0; width: 100%;" alt="Training and Business Trip" src="{{ asset('landing-page/2019-05-28/Training and Business Trip.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 0 15%; text-align: center; font-size: 18px;">
								<p>Claimable expenses or Cash Advance method</p>
							</div>
						</div>
						<div class="col-md-4" >
							<img style="margin: 0 5%; width: 100%;" alt="Exit Interview & Clearance" src="{{ asset('landing-page/2019-05-28/Exit Training & Clearance.png') }}"/>
							
							<div class="col-md-12" style="padding: 5% 10% 0 20%; text-align: center; font-size: 18px;">
								<p>Procedure to validating employee has no pending obligation to the company</p>
							</div>
						</div>
						<div class="col-md-4" >
							<img style="margin: 0 38%; width: 43%;" alt="Attendance" src="{{ asset('landing-page/2019-05-28/Attendance.png') }}"/>
							<div class="col-md-12" style="padding: 5% 0 0 20%; text-align: center; font-size: 18px;">
								<p>integrating several attendance devices such as finger print machines, mobile attendance is an integrated Em-HR system</p>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6" >
						<img style="margin: 0 45%; width: 28%;" alt="Dashboard" src="{{ asset('landing-page/2019-05-28/Dashboard.png') }}"/>
						<div class="col-md-12" style="padding: 5% 10% 0 30%; text-align: center; font-size: 18px;">
							<p>Brief information on module selection in the form of diagrams or graphic value</p>
						</div>
					</div>
					<div class="col-md-6" >
						<img style="margin: 0 15%; width: 58%;" alt="Facility Management" src="{{ asset('landing-page/2019-05-28/Facility Management.png') }}"/>
						<div class="col-md-12" style="padding: 2% 30% 0 20%; text-align: center; font-size: 18px;">
							<p>asset management settings used by employees</p>
						</div>
					</div>
				</div>


				<div style="margin-top: 11%;">
					<div class="row" style="padding-bottom: 5%;">
						<div class="col-md-12" style="text-align: center;">
							<h1 style="font-size: 320%; font-weight: 800;"><b>Easy Step to Use the <span style="color: #0E9A88;">Em-HR System</span></b></h1>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4" >
							<img style="margin: 0 35%; width: 40%;" alt="Register for free" src="{{ asset('landing-page/2019-05-28/Register for free.png') }}"/>
							
							<div class="col-md-12" style="padding: 2% 20% 0 30%; text-align: center; font-size: 18px;">
								<h4>Register for free</h4>
							</div>
						</div>
						<div class="col-md-4" >
							<img style="margin: 0 35%; width: 40%;" alt="install emhr"src="{{ asset('landing-page/2019-05-28/install emhr.png') }}"/>
							<div class="col-md-12" style="padding: 2% 20% 0 30%; text-align: center; font-size: 18px;">
								<h4>Install Em-HR</h4>
							</div>
						</div>
						<div class="col-md-4" >
							<img style="margin: 0 35%; width: 40%;" alt="feel the ease" src="{{ asset('landing-page/2019-05-28/feel the ease.png') }}"/>
							<div class="col-md-12" style="padding: 2% 20% 0 30%; text-align: center; font-size: 18px;">
								<h4>Feel the Ease</h4>
							</div>
						</div>
					</div>
				</div>
			</div>

		  <div class="container container_bottom" style="margin-top: 9%;">
			<div class="col-md-4 float-left">
				<img src="{{ asset('landing-page/2019-05-28/bubble background.png') }}" style="width: 73%; margin-left: -23px; margin-top: 70px" />
			</div>
			<div class="col-md-8 float-right">
				<h1 class="text-center"><label style="color: #0e9a88;font-size: 29px;">There is ease in</label> <label style="color: #acce22">EM-HR</label> <label  style="color: #0e9a88">Application</label></h1>
			
				<div class="form">
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<form method="POST" action="{{ route('post-landing-page1') }}" class="col-md-12 px-0 pt-2" style="padding-top: 0px !important; padding-bottom: 10px">
							{{ csrf_field() }}
							<div class="bg-form-title">
								<h3 style="color: white; text-align: center;font-size: 23px;padding-top: 10px !important;" class="py-2 px-0 mx-0 mt-0">Register Member</h3>
							</div>
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
							<div class="px-5 pt-4">
								<div class="form-group">
									<input type="text" class="form-control" id="nama" name="nama" placeholder="Full Name" value="{{ old('nama') }}" required>
								</div>
								<div class="form-group">
									<select id="jabatan" name="jabatan" class="form-control">
										<option value=""> - Position - </option>
										<option>Owner</option>
										<option>HRD / Finance</option>
										<option>IT</option>
										<option>Others</option>
									</select>
								</div>
								<div class="form-group">
									<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
								</div>
								<!--div class="form-group">
									<input type="password" class="form-control" name="password" placeholder="Password"  value="{{ old('password') }}" required>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" name="confirm" placeholder="Confirm Password" value="{{ old('confirm') }}" required>
								</div-->
								<div class="form-group">
									<input type="input" class="form-control" id="nama_perusahaan" name="nama_perusahaan" placeholder="Company" value="{{ old('company') }}" required>
								</div>
								<div class="form-group">
									<select class="form-control" id="bidang_usaha" name="bidang_usaha" required>
										<option value=""> - Choose Business Specialization - </option>
										<option>Agriculture / Mining</option>
										<option>Business Services</option>
										<option>Computers and Electronics</option>
										<option>Consumer Services</option>
										<option>Education</option>
										<option>Energy & Utilities</option>
										<option>Financial Services</option>
										<option>Government</option>
										<option>Healtcare, Pharmaceuticals, & Biotech</option>
										<option>Manufacturing</option>
										<option>Media & Entertainment</option>
										<option>Non Profit</option>
										<option>Real Estate & Contruction</option>
										<option>Retail</option>
										<option>Software & Internet</option>
										<option>Telecommunications</option>
										<option>Transportation & Storage</option>
										<option>Travel, Recreation, & Leisure</option>
										<option>Wholesale & Distribution</option>
										<option>Consumer Products</option>
										<option>Others</option>
									</select>
								</div>
								<div class="form-group">
									<input type="text" id="handphone" name="handphone" class="form-control" placeholder="Handphone Number" value="{{ old('handphone') }}" required>
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
								<button class="btn_trial_2" type="submit">Create Member</button>
							</div>
						</form>

						</div>
						
						<div class="col-md-4"></div>
					</div>
					
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row" style="margin: 120px 0 0 0;">
				<div class="col-md-4">
						<img style="width: 80%;" alt="hand with phone" src="{{ asset('landing-page/2019-05-28/hand with phone.png') }}"/>
					</div>
					<div class="col-md-8">
					<br><br>
						<div class="row">
							<h3>Get <span style="color: #0E9A88;">Em-HR Mobile Attendance</span> service with 2 easy steps</h3>
							<p>Register your company on this site, then download the EMHR Attendance Application on :</p>
						</div>
						<div class="row">
							<div class="col-md-12">
								<img style="width: 70%; padding: 0 0 0 20%;" src="{{ asset('landing-page/2019-05-28/playstore dan IOS.png') }}"/>
							</div>
						</div>
					</div>
			</div>	
		</div>


		<div style="text-align: center;">
			<img src="{{ asset('landing-page/2019-05-28/line botton.png') }}" style="width: 100%;">
			<div style="padding: 1% 0;">
				<div class="xb-col-12">
					<div class="bottom-footer center">
						<div class="copyright no-social" style="font-size: 100%; color: rgba(0, 0, 0, 0.4)">Copyright © PT. Empore Hezer Tama <?php echo date('Y'); ?></div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>

<script type="text/javascript">
	$('#nama').on('input', function(){
		$('#nama2').val($('#nama').val());
	});
	$('#jabatan').change(function(){
		$('#jabatan2').val($('#jabatan').val());
	});
	$('#email').on('input', function(){
		$('#email2').val($('#email').val());
	});
	$('#nama_perusahaan').on('input', function(){
		$('#nama_perusahaan2').val($('#nama_perusahaan').val());
	});
	$('#bidang_usaha').on('change', function(){
		$('#bidang_usaha2').val($('#bidang_usaha').val());
	});
	$('#handphone').on('input', function(){
		$('#handphone2').val($('#handphone').val());
	});


	function submitFormPricelist(){
		if($('#nama2').val() != '' || $('#jabatan2').val() != '' || $('#email2').val() != '' || $('#nama_perusahaan2').val() != '' || $('#bidang_usaha2').val() != '' || $('#handphone2').val() != ''){
			$('#form-price-list').submit();
		}else{
			bootbox.confirm({
                title : "<i class=\"fa fa-warning\"></i> EMPORE SYSTEM",
                message: "Field tidak boleh kosong",
                closeButton: false,
                buttons: {

                },
                callback: function (result) {
                    if(result)
                    { 
                        
                    }
                }
            });
		}
	}
	
</script>

</body>
</html>