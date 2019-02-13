@if(Session::has('message-success'))
<script type="text/javascript">
	_alert("{{ Session::get('message-success') }}");
</script>
@endif

@if(Session::has('message-error'))
<script type="text/javascript">
	_alert("{{ Session::get('message-error') }}");
</script>
@endif