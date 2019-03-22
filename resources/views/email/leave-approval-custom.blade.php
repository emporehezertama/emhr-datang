@extends('email.general')

@section('content')
{!! $text !!}

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Date of Leave/Permit </th>
			<th style="text-align: left;"> : {{ date('d F Y', strtotime($data->tanggal_cuti_start)) }} - {{ date('d F Y', strtotime($data->tanggal_cuti_end)) }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Leave/Permit Type </th>
			<th style="text-align: left;"> : {{ isset($data->cuti->jenis_cuti) ? $data->cuti->jenis_cuti : '' }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Leave/Permit Duration </th>
			<th style="text-align: left;"> : {{ $data->total_cuti }} Days</th>
		</tr>
		<tr>
			<th style="text-align: left;">Purpose </th>
			<th style="text-align: left;"> : {{ $data->keperluan }}</th>
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
					<th style="text-align: left;"> : {{ $item->structure->name}}</th>
				</tr>
			</table>
		@endforeach
	</div>
</div>

@endsection