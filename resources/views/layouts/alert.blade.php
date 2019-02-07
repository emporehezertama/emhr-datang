<link href="{{ asset('admin-css/plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet">
<script src="{{ asset('admin-css/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>

@if(Session::has('message-success'))
<script type="text/javascript">
		swal("Success", "{{ Session::get('message-success') }}", "success");
</script>
@endif

@if(Session::has('message-error'))
<script type="text/javascript">
	swal("Error!", "{{ Session::get('message-error') }}", "error");
</script>
@endif