<!DOCTYPE html>
<html>
<head>
	<title>Payroll</title>
</head>
<body>
	<h1>Payroll</h1>
	<table>
		<tbody>
			<tr>
			@foreach($data as $key => $item)
				@if($key == 0)
				  @foreach($item as $header => $val)
					<td style="border: 1px solid #000000;"><strong>{{ $header }}</strong></td>
				  @endforeach
				@endif
			@endforeach
			</tr>
			<tr>
				@foreach($data as $header => $item)
					@foreach($item as $key => $val)
						<td style="border: 1px solid #000000;"><strong>{{ $item[$key] }}</strong></td>
					@endforeach
				@endforeach
			</tr>
		</tbody>
	</table>
</body>
</html>