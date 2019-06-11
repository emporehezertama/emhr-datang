@extends('layouts.karyawan')

@section('title', 'Overtime Sheet')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Overtime Sheet</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Overtime Sheet</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="#" id="form-overtime" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Data Overtime Sheet</h3>
                        <br />
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-12">NIK / Employee Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $data->user->nik .' - '. $data->user->name  }}" readonly="true" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Position</label>
                            <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control" value="{{ isset($data->user->structure->position) ? $data->user->structure->position->name:''}}{{ isset($data->user->structure->division) ? '-'. $data->user->structure->division->name:'' }}">
                            </div>
                        </div>
                        <hr />
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-hover manage-u-table">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>DATE</th>
                                        <th>DESCRIPTION</th>
                                        <th>START</th>
                                        <th>END</th>
                                        <th>TOTAL OVERTIME (HOURS)</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-lembur">
                                    @foreach($data->overtime_form as $no => $item)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td><input type="text" readonly="true" value="{{ $item->tanggal }}" class="form-control"></td>
                                        <td><input type="text" readonly="true" class="form-control" value="{{ $item->description }}"></td>
                                        <td><input type="text" readonly="true" class="form-control" value="{{ $item->awal }}" /></td>
                                        <td><input type="text" readonly="true" class="form-control" value="{{ $item->akhir }}" /></td>
                                        <td><input type="text" readonly="true" class="form-control" value="{{ $item->total_lembur }}" /></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="clearfix"></div>
                        <br />
                        @foreach($data->historyApproval as $key => $item)
                            <div class="form-group">
                                <label class="col-md-12">Note Approval {{$item->setting_approval_level_id}}</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control note" value="{{ $item->note }}">
                                </div>
                            </div>
                            @endforeach

                        <input type="hidden" name="status" value="0" />
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="clearfix"></div>
                        <br />
                        <a href="{{ route('karyawan.overtime-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
    </div>
    @include('layouts.footer')
</div>
@section('footer-script')
@endsection
@endsection