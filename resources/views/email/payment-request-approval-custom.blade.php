@extends('email.general')

@section('content')
{!! $text !!}

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Request Date </th>
			<th style="text-align: left;"> : {{ date('d F Y', strtotime($data->created_at)) }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Purpose </th>
			<th style="text-align: left;"> : {{ $data->tujuan }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Amount </th>
			<th style="text-align: left;"> : {{ sum_payment_request_price($data->id) }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Payment Method </th>
			<th style="text-align: left;"> : {{ $data->payment_method }}</th>
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