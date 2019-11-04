@extends('email.general')

@section('content')
{!! $text !!}

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Resign Date </th>
			<th style="text-align: left;"> : {{ date('d F Y', strtotime($data->resign_date)) }}</th>
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