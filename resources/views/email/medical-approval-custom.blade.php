@extends('email.general')

@section('content')
{!! $text !!}

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Claim Date </th>
			<th style="text-align: left;"> : {{ date('d F Y', strtotime($data->tanggal_pengajuan)) }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Claim Type </th>
			<th style="text-align: left;"> : {{ medical_type_string($data->id) }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Amount</th>
			<th style="text-align: left;"> : {{ number_format(total_medical_nominal($data->id)) }}</th>
		</tr>
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