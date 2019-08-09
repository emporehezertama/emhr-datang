<table>
	<thead>
		<tr>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>No</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>Nik</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>Name</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>Date</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>Day</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff; text-align: center;" colspan="2"><strong>Clock</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>Late CLOCK In</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>Early CLOCK Out</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>Duration</strong></td>
		</tr>
		<tr>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;"><strong>In</strong></td>
			<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;"><strong>Out</strong></td>
		</tr>
	</thead>
	<tbody>
		
		@foreach($params as $key => $item)
		<tr>
			<td style="border: 1px solid #000000;">{{$key+1}}</td>
			<td style="border: 1px solid #000000;">{{$item['nik']}}</td>
			<td style="border: 1px solid #000000;">{{$item['nik']}}</td>
			<td style="border: 1px solid #000000;">{{$item['name']}}</td>
			<td style="border: 1px solid #000000;">{{$item['date']}}</td>
			<td style="border: 1px solid #000000;">{{$item['date']}}</td>
			<td style="border: 1px solid #000000;">{{$item['nik']}}</td>
			<td style="border: 1px solid #000000;">{{$item['nik']}}</td>
			<td style="border: 1px solid #000000;">{{$item['work_time']}}</td>
			<td style="border: 1px solid #000000;">{{$item['work_time']}}</td>
		</tr>
		@endforeach
	</tbody>
</table>