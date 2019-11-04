
<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="logo.gif" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
<title>Login System</title>
<!-- Bootstrap Core CSS -->
<link href="{{ asset('admin-css/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- animation CSS -->
<link href="{{ asset('admin-css/css/animate.css') }}" rel="stylesheet">
<!-- Custom CSS -->
<link href="{{ asset('admin-css/css/style.css') }}?time=<?=date('His')?>" rel="stylesheet">
<!-- color CSS -->
<link href="{{ asset('admin-css/css/colors/blue.css') }}" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>

@yield('content')

</section>
<!-- jQuery -->
<script src="{{ asset('admin-css/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('admin-css/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>

<!--slimscroll JavaScript -->
<script src="{{ asset('admin-css/js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('admin-css/js/waves.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('admin-css/js/custom.min.js') }}"></script>
<!--Style Switcher -->
<script src="{{ asset('admin-css/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>

<script type="text/javascript">
	
	setTimeout(function(){
		$(".img-contact").animate({width:'toggle'},350);
	}, 2000);

	$('.close_contact').on('click', function(){
		$(".img-contact").animate({
					    'margin-top' : "-50%",
					    'opacity' : '0'
					    },500);;
	});
	
  	$(document).ready(function(){

     	$(".toggle-password").click(function() {

		  $(this).toggleClass("fa-eye fa-eye-slash");
		  
		  var input = $("#password");

		  if (input.attr("type") == "password") {
		    input.attr("type", "text");
		  } else {
		    input.attr("type", "password");
		  }
		});

  	});
</script>

</body>
</html>
