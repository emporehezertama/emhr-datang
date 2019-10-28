@extends('layouts.administrator')

@section('title', 'Overtime Sheet')

@section('sidebar')

@endsection

@section('content')

<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->
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
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('karyawan.approval.overtime-custom.prosesClaim') }}" id="form-overtime" method="POST">
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
                       
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                                <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th colspan="3" style="text-align: center;">PRE</th>
                                        <th colspan="3" style="text-align: center;">PRE APPROVED</th>
                                        <th colspan="2" style="text-align: center;">FINGER PRINT</th>
                                        <th colspan="3" style="text-align: center;">CLAIM</th>
                                        <th colspan="3" style="text-align: center;">CLAIM APPROVED</th>
                                        <th>OT APPROVED</th>
                                    </tr>
                                    <tr>
                                        <th>NO</th>
                                        <th>DATE</th>
                                        <th>DESCRIPTION</th>
                                        <th>START</th>
                                        <th>END</th>
                                        <th>OT (HOURS)</th>
                                        <th>START</th>
                                        <th>END</th>
                                        <th>OT (HOURS)</th>
                                        <th>IN </th>
                                        <th>OUT </th>
                                        <th>START</th>
                                        <th>END </th>
                                        <th>OT (HOURS)</th>
                                        <th>START</th>
                                        <th>END</th>
                                        <th>OT(HOURS)</th>
                                        <th>CALCULATED</th>
                                    </tr>
                                </thead>
                                <tbody class="table-content-lembur">
                                    @foreach($data->overtime_form as $no => $item)
                                    <tr>
                                        <input type="hidden" name="id_overtime_form[]" class="form-control"  value="{{ $item->id }}" readonly="true">
                                        <td>{{ $no+1 }}</td>
                                        <td><input type="text" style="width: 125px" readonly="true" value="{{ $item->tanggal }}" name="tanggal[]" class="form-control"></td>
                                        <td><input type="text" style="width: 150px" readonly="true" name="description[]" class="form-control" value="{{ $item->description }}"></td>
                                        <td><input type="text" style="width: 70px" readonly="true" name="awal[]" class="form-control" value="{{ $item->awal }}" /></td>
                                        <td><input type="text" style="width: 70px" readonly="true" name="akhir[]" class="form-control" value="{{ $item->akhir }}" /></td>
                                        <td><input type="text" readonly="true" name="total_lembur[]" class="form-control" value="{{ $item->total_lembur }}" /></td>
                                        <td><input type="text" style="width: 70px" readonly="true" name="pre_awal_approved[]" class="form-control" value="{{ $item->pre_awal_approved }}" /></td>
                                        <td><input type="text" style="width: 70px" readonly="true" name="pre_akhir_approved[]" class="form-control" value="{{ $item->pre_akhir_approved }}" /></td>
                                        <td><input type="text" readonly="true" name="pre_total_approved[]" class="form-control" value="{{ $item->pre_total_approved }}" /></td>
                                        @php($in = overtime_absensi($item->tanggal,$data->user_id))
                                        <td><input type="text" style="width: 70px" readonly="true" class="form-control" value="{{ isset($in) ? $in->clock_in :''}}" /></td>
                                        <td><input type="text" style="width: 70px" readonly="true" class="form-control" value="{{ isset($in) ? $in->clock_out :''}}" /></td>
                                        <td><input type="text" name="awal_claim[]" style="width: 70px"  readonly="true" class="form-control" value="{{ $item->awal_claim }}" /></td>
                                        <td><input type="text" name="akhir_claim[]" style="width: 70px" readonly="true"  class="form-control" value="{{ $item->akhir_claim }}" /></td>
                                        <td><input type="text" name="total_lembur_claim[]" readonly="true" class="form-control total_lembur_claim"  value="{{ $item->total_lembur_claim }}" /></td>
                                        <td>
                                            <input type="text" style="width: 70px" name="awal_approved[]" class="form-control awal_approved" readonly="true" value="{{ $item->awal_approved }}" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 70px" name="akhir_approved[]" class="form-control akhir_approved" readonly="true" value="{{ $item->akhir_approved }}" />
                                        </td>
                                        <td>
                                            <input type="text" name="total_lembur_approved[]" readonly="true" class="form-control total_lembur_approved" value="{{ $item->total_lembur_approved }}" />
                                        </td>
                                        <td><input type="text" name="overtime_calculate[]" readonly="true" class="form-control overtime_calculate" value="{{ $item->overtime_calculate }}" /></td>
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
                            <div class="col-md-6">
                               <input type="text" readonly="true" class="form-control note_claim" value="{{ $item->note_claim }}">
                            </div>
                        </div>
                        @endforeach

                        
                            
                        <input type="hidden" name="status" value="0" />
                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="clearfix"></div>
                        <br />
                         <a href="{{ route('administrator.overtimeCustom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>

                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @extends('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
