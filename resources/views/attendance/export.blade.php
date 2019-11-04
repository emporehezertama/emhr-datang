<!DOCTYPE html>
<html>
<head>
	<title>Attendance </title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff;" rowspan="2"><strong>No</strong></td>
				<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff; width: 20px;" rowspan="2"><strong>Nik</strong></td>
				<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff; width: 30px;" rowspan="2"><strong>Name</strong></td>
				<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff; width: 20px;" rowspan="2"><strong>Date</strong></td>
				<td style="border: 1px solid #000000; background:#7f7f7f;color: #ffffff; width: 20px;" rowspan="2"><strong>Day</strong></td>
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
			@foreach($data as $key => $item)
				@if(!isset($item->user->nik) || empty($item->date))
                <?php continue; ?>
                @endif
			<tr>
				<td style="border: 1px solid #000000;">{{$key+1}}</td>
				<td style="border: 1px solid #000000;">{{$item->user->nik}}</td>
				<td style="border: 1px solid #000000;">{{$item->user->name}}</td>
				<td style="border: 1px solid #000000;">{{$item->date}}</td>
				<td style="border: 1px solid #000000;">{{$item->timetable}}</td>
				<td style="border: 1px solid #000000;">{{$item->clock_in}}</td>
				<td style="border: 1px solid #000000;">{{$item->clock_out}}</td>
				<td style="border: 1px solid #000000;">{{$item->late}}</td>
				<td style="border: 1px solid #000000;">{{$item->early}}</td>
				<td style="border: 1px solid #000000;">{{$item->work_time}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>
