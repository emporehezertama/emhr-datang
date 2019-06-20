@extends('layouts.karyawan')

@section('title', 'Approval Business Trip')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Business Trip</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Business Trip</li>
                </ol>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table_no_pagging" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>DEPARTMENT / POSITION</th>
                                    <th>ACTIVITY TYPE</th>
                                    <th>ACTIVITY TOPIC</th>
                                    <th>ACTIVITY DATE</th>
                                    <th>STATUS</th>
                                    <th>BILL</th>
                                    <th>CREATED</th>
                                    <th width="100">MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    @if($item->is_approved == NULL)
                                        @if($item->training->status == 3)
                                            <?php continue;?>
                                        @endif
                                        @if(!cek_level_training_up($item->training->id))
                                            <?php continue;?>
                                        @endif
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>  
                                        <td>{{ $item->training->user->nik }}</td>
                                        <td>{{ $item->training->user->name }}</a></td>
                                        <td>{{ isset($item->training->user->structure->position) ? $item->training->user->structure->position->name:''}}{{ isset($item->training->user->structure->division) ? '-'. $item->training->user->structure->division->name:''}}</td> 
                                        <td>{{ isset($item->training->training_type)? $item->training->training_type->name:''}}</td>
                                        <td>{{ $item->topik_kegiatan }}</td>
                                        <td>{{ date('d F Y', strtotime($item->tanggal_kegiatan_start)) }} - {{ date('d F Y', strtotime($item->tanggal_kegiatan_end)) }}</td>
                                        <td>
                                            <a onclick="detail_approval_trainingCustom({{ $item->id }})"> 
                                            {!! status_cuti($item->status) !!}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" onclick="detail_approval_trainingClaimCustom({{ $item->id }})"> 
                                                {!! status_cuti($item->status_actual_bill) !!}
                                            </a>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                                @if($item->is_approved === NULL and $item->status < 2)
                                                <a href="{{ route('karyawan.approval.training-custom.detail', ['id' => $item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-book"></i> Process</a>
                                                @else
                                                <a href="{{ route('karyawan.approval.training-custom.detail', ['id' => $item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-book"></i> Detail</a>
                                                @endif
                                        </td>
                                        <td>
                                            @if($item->status == 2)
                                                @if($item->is_approved_claim === NULL and $item->status_actual_bill == 1)
                                                @if(cek_level_training_up($item->training->id))

                                                    <a href="{{ route('karyawan.approval.training-custom.claim', ['id' => $item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-book"></i> Process Claim</a>
                                                @endif
                                                @elseif($item->is_approved_claim != NULL and $item->status_actual_bill >= 1)
                                                    <a href="{{ route('karyawan.approval.training-custom.claim', ['id' => $item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-book"></i> Detail Claim</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    @include('layouts.footer')
</div>
@endsection
