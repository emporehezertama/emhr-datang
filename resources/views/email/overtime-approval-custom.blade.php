@extends('email.general')

@section('content')
{!! $text !!}

<table>
	<thead>
		<tr>
			<td colspan="2"><hr /></td>
		</tr>
		@foreach($data->overtime_form as $item)
		<tr>
			<td style="text-align: left;">Overtime Date</td>
			<td style="text-align: left;"> : {{ date('d F Y', strtotime($item->tanggal)) }}</td>
		</tr>
		<tr>
			<td style="text-align: left;">Total Overtime (hours) </td>
			<td style="text-align: left;"> : {{ $item->total_lembur }}</td>
		</tr>
		<tr>
			<td colspan="2"><hr /></td>
		</tr>
		@endforeach
	</thead>
</table>
<br />	
<div class="modal-body" id="modal_content_history_approval">
	<div class="panel-body">
		@foreach($value as $key => $item)
			<table>
				<tr>
					<th style="text-align: left;">{{$item->level->name}} </th>
					<th style="text-align: left;"> : {{ (isset($item->structure->position) ? $item->structure->position->name:'').(isset($item->structure->division) ? '-'.$item->structure->division->name:'') }}</th>

				</tr>
			</table>
		@endforeach
	</div>
</div>
@endsection