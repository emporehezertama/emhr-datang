@extends('layouts.administrator')

@section('title', 'Exit Interview Form')

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
                <h4 class="page-title">Exit Interview & Exit Clearance Form</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Exit Interview & Exit Clearance Form</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" id="exit_interview_form">
                <div class="col-md-12">
                    <div class="white-box">
                        <ul class="nav customtab nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#interview" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> <strong>EXIT INTERVIEW FORM</strong></span></a></li>
                            <li role="presentation"><a href="#clearance" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs"><strong>EXIT CLEARANCE FORM</strong></span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade" id="clearance">
                                <div class="form-group">
                                    <label class="col-md-12">DOCUMENT LIST</label>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30px;">NO</th>
                                                    <th>ITEM</th>
                                                    <th>FORM NUMBER</th>
                                                    <th style="width: 50px;">CHECKED</th>
                                                    <th>NOTES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list_exit_clearance_document as $no => $item)
                                                <tr>
                                                    <td>{{ $no + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->form_no }}</td>
                                                    <td style="text-align: center;">
                                                        @if($item->hrd_checked == 1)
                                                            <label class="bt btn-success btn-xs"><i class="fa fa-check"></i> </label>
                                                        @else
                                                            <label class="bt btn-danger btn-xs"><i class="fa fa-close"></i> </label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input readonly="true" type="text" name="check_document_catatan[{{ $item->id }}]" class="form-control catatan" value="{{ $item->hrd_note }}" />
                                                        @if($item->hrd_checked == 1)
                                                            <small>Submit Date : {{ Carbon\Carbon::parse($item->hrd_check_date)->format('d M Y H:i') }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tr>
                                                <th colspan="5">
                                                    <label class="col-md-12">INVENTORY RETURN TO HRD</label>
                                                </th>
                                            </tr>
                                            <tbody> 
                                                @foreach($list_exit_clearance_inventory_to_hrd as $no => $item)
                                                <tr>
                                                    <td>{{ $no + 1 }}</td>
                                                    <td colspan="2">{{ $item->name }}</td>
                                                    <td style="text-align: center;">
                                                        @if($item->hrd_checked == 1)
                                                            <label class="bt btn-success btn-xs"><i class="fa fa-check"></i> </label>
                                                        @else
                                                            <label class="bt btn-danger btn-xs"><i class="fa fa-close"></i> </label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input readonly="true" type="text" name="check_inventory_hrd_catatan[{{ $item->id }}]" class="form-control catatan" value="{{ $item->hrd_note }}" />
                                                        @if($item->hrd_checked == 1)
                                                            <small>Submit Date : {{ Carbon\Carbon::parse($item->hrd_check_date)->format('d M Y H:i') }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tr>
                                                <th colspan="5">
                                                    <label class="col-md-12">INVENTORY RETURN TO GENERAL AFFAIR (GA)</label>
                                                </th>
                                            </tr>                                    
                                            <tbody>
                                                @foreach($list_exit_clearance_inventory_to_ga as $no => $item)
                                                <tr>
                                                    <td>{{ $no + 6 }}</td>
                                                    <td colspan="2">{{ $item->name }}</td>
                                                    <td style="text-align: center;">
                                                        @if($item->ga_checked == 1)
                                                            <label class="bt btn-success btn-xs"><i class="fa fa-check"></i> </label>
                                                        @else
                                                            <label class="bt btn-danger btn-xs"><i class="fa fa-close"></i> </label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="text" name="check_inventory_ga_catatan[{{ $item->id }}]" readonly="true" class="form-control catatan" value="{{ $item->ga_note }}" />
                                                         @if($item->ga_checked == 1)
                                                            <small>Submit Date : {{ Carbon\Carbon::parse($item->ga_check_date)->format('d M Y H:i') }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tr>
                                                <th colspan="5">
                                                    <label class="col-md-12">INVENTORY RETURN</label>
                                                </th>
                                            </tr>
                                            <tbody>

                                            @if($data->assets)
                                            <tr>
                                                <td>12</td>
                                                <td colspan="4">
                                                    <p><strong>Car</strong></p>
                                                    <table class="table table-bordered">
                                                       <thead>
                                                                <tr>
                                                                    <th width="70" class="text-center">#</th>
                                                                    <th>ASSET NUMBER</th>
                                                                    <th>ASSET NAME</th>
                                                                    <th>ASSET TYPE</th>
                                                                    <th>CAR TYPE</th>
                                                                    <th>YEAR</th>
                                                                    <th>PLAT NUMBER</th>
                                                                    <th>CAR STATUS</th>
                                                                    <th>PURCHASE DATE</th>
                                                                    <th>ASSET CONDITION</th>
                                                                    <th>ASSIGN TO</th>
                                                                    <th>EMPLOYEE</th>
                                                                    <th>HANDOVER DATE</th>
                                                                    <th style="width:20px;">CHECKED</th>
                                                                    <th>NOTES</th>
                                                                </tr>
                                                            </thead>
                                                            @foreach($data->assets as $no => $item)
                                                                @if(isset($item->asset->asset_type->name) and strtoupper($item->asset->asset_type->name) =='CAR')
                                                                    @if($item->asset->handover_date === NULL)
                                                                        <?php continue; ?>
                                                                    @endif
                                                                    <input type="hidden" name="asset[]" value="{{ $item->id }}" />
                                                                    <tr>
                                                                        <td class="text-center">{{ $no+1 }}</td>   
                                                                        <td>{{ $item->asset->asset_number }}</td>
                                                                        <td>{{ $item->asset->asset_name }}</td>
                                                                        <td>{{ isset($item->asset->asset_type->name) ? $item->asset->asset_type->name : ''  }}</td>
                                                                        <td>{{ $item->asset->tipe_mobil }}</td>
                                                                        <td>{{ $item->asset->tahun }}</td>
                                                                        <td>{{ $item->asset->no_polisi }}</td>
                                                                        <td>{{ $item->asset->status_mobil }}</td>
                                                                        <td>{{ format_tanggal($item->asset->purchase_date) }}</td>
                                                                        <td>{{ $item->asset->asset_condition }}</td>
                                                                        <td>{{ $item->asset->assign_to }}</td>
                                                                        <td>{{ isset($item->asset->user->name) ? $item->asset->user->name : '' }}</td>
                                                                        <td>{{ $item->asset->handover_date != "" ?  format_tanggal($item->asset->handover_date) : '' }}</td>
                                                                        <td style="text-align: center;">
                                                                            @if($item->status == 1)
                                                                                <label class="bt btn-success btn-xs"><i class="fa fa-check"></i> </label>
                                                                            @else
                                                                                <label class="bt btn-danger btn-xs"><i class="fa fa-close"></i> </label>
                                                                            @endif 
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" readonly="true" name="catatan_asset[{{ $item->id }}]" class="form-control catatan" value="{{ $item->catatan }}" />
                                                                             @if($item->status == 1)
                                                                                <small>Submit Date : {{ Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') }}</small>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                            @endif

                                           @if($data->assets)
                                                <tr>
                                                    <td>13</td>
                                                    <td colspan="4">
                                                        <p><strong>Laptop/PC & Other IT Device</strong></p>
                                                        <table class="table table-bordered" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th width="70" class="text-center">#</th>
                                                                    <th>ASSET NUMBER</th>
                                                                    <th>ASSET NAME</th>
                                                                    <th>ASSET TYPE</th>
                                                                    <th>SN</th>
                                                                    <th>PURCHASE DATE</th>
                                                                    <th>ASSET CONDITION</th>
                                                                    <th>ASSIGN TO</th>
                                                                    <th>EMPLOYEE</th>
                                                                    <th>HANDOVER DATE</th>
                                                                    <th style="width:20px;">CHECKED</th>
                                                                    <th>NOTES</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php($no = 0)
                                                                @foreach($data->assets as $k => $item)
                                                                  @if(isset($item->asset->asset_type->name) and $item->asset->asset_type->name != 'Mobil')
                                                                    @if($item->asset->handover_date == NULL)
                                                                        <?php continue; ?>
                                                                    @endif
                                                                    @php($no++)
                                                                    <input type="hidden" name="asset[]" value="{{ $item->id }}" />
                                                                    <tr>
                                                                        <td class="text-center">{{ $no }}</td>   
                                                                        <td>{{ $item->asset->asset_number }}</td>
                                                                        <td>{{ $item->asset->asset_name }}</td>
                                                                        <td>{{ isset($item->asset->asset_type->name) ? $item->asset->asset_type->name : ''  }}</td>
                                                                        <td>{{ $item->asset->asset_sn }}</td>
                                                                        <td>{{ format_tanggal($item->asset->purchase_date) }}</td>
                                                                        <td>{{ $item->asset->asset_condition }}</td>
                                                                        <td>{{ $item->asset->assign_to }}</td>
                                                                        <td>{{ isset($item->asset->user->name) ? $item->asset->user->name : '' }}</td>
                                                                        <td>{{ $item->asset->handover_date != "" ?  format_tanggal($item->asset->handover_date) : '' }}</td>
                                                                        <td style="text-align: center;">
                                                                            @if($item->status == 1)
                                                                                <label class="bt btn-success btn-xs"><i class="fa fa-check"></i> </label>
                                                                            @else
                                                                                <label class="bt btn-danger btn-xs"><i class="fa fa-close"></i> </label>
                                                                            @endif   
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" readonly="true" name="catatan_asset[{{ $item->id }}]" class="form-control catatan" value="{{ $item->catatan }}" />
                                                                             @if($item->status == 1)
                                                                                <small>Submit Date : {{ Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') }}</small>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                  @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br />
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <a href="{{ route('karyawan.exit-interview.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade in active" id="interview">
                                {{ csrf_field() }}
                                <div class="col-md-6" style="padding-left: 0;">
                                    <div class="form-group">
                                        <label class="col-md-12">NIK / Employee Name</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" value="{{ $data->user->nik .' / '. $data->user->name }}" readonly="true">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6">Position</label>
                                        <label class="col-md-6">Division / Departement</label>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" class="form-control jabatan" value="{{ isset($data->user->organisasiposition->name) ? $data->user->organisasiposition->name : '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" class="form-control department" value="{{ isset($data->user->department->name) ? $data->user->department->name : '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6">Resign Date</label>
                                        <label class="col-md-6">Join Date</label>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" name="resign_date" class="form-control datepicker" value="{{ $data->resign_date }}" >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" class="form-control" value="{{ $data->user->join_date }}">
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br />
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group">
                                    <label class="col-md-6">Reason for leaving :</label>
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            @foreach(get_reason_interview() as $item)
                                            <?php 
                                                if($data->exit_interview_reason != $item->id)
                                                {
                                                    continue;
                                                }
                                            ?>
                                            <li class="list-group-item">
                                                <label>{{ $item->label }}</label>
                                                
                                                @if($item->id == 1)
                                                <div class="form-group perusahaan_lain">
                                                    <hr />
                                                    <label class="col-md-12">If move to other company </label>
                                                    <p class="col-md-6">New company name</p>
                                                    <p class="col-md-6">Scope of work </p>
                                                    <div class="col-md-6">
                                                        <textarea class="form-control" readonly="true" name="tujuan_perusahaan_baru">{{ $data->tujuan_perusahaan_baru }}</textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <textarea class="form-control" readonly="true" name="jenis_bidang_usaha">{{ $data->jenis_bidang_usaha }}</textarea>
                                                    </div>
                                                </div>
                                                @endif
                                            </li>
                                            @endforeach
                                            @if($item->exit_interview_reason == 'Others')
                                            <li class="list-group-item">
                                                <label><input type="radio" name="exit_interview_reason" value="other" {{ $data->exit_interview_reason == 'other' ? 'checked' : '' }} /> Other (other reason)</label>
                                                <textarea class="form-control" name="other_reason">{{ $data->other_reason }}</textarea>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Most memorable moments while working at Empore Hezer Tama</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="hal_berkesan" readonly="true">{{ $data->hal_berkesan }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Unmemorable moments while working at Empore Hezer Tama</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="hal_tidak_berkesan" readonly="true">{{ $data->hal_tidak_berkesan }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Suggestion and Critic to Empore Hezer Tama</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="masukan" readonly="true">{{ $data->masukan }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Things that will be done after resign from Empore Hezer Tama </label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="kegiatan_setelah_resign" readonly="true">{{ $data->kegiatan_setelah_resign }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <a href="{{ route('karyawan.exit-interview.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
