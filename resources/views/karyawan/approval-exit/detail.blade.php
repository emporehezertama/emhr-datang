@extends('layouts.karyawan')

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
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('karyawan.approval.exit.proses') }}" method="POST" id="exit_interview_form">
                <div class="col-md-12">
                    <div class="white-box">

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
                                                    <th>FORM NO</th>
                                                    <th style="width: 50px;">CHECKED</th>
                                                    <th>NOTE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list_exit_clearance_document as $no => $item)
                                                <tr>
                                                    <td>{{ $no + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->form_no }}</td>
                                                    <td style="text-align: center;">
                                                        <input type="checkbox" value="1" {{ $item->hrd_checked == 1 ? 'checked' : '' }} name="check_dokument[{{ $item->id }}]">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="check_document_catatan[{{ $item->id }}]" class="form-control catatan"  {{ $item->status == 0 ? 'readonly="true"' : '' }} value="{{ $item->hrd_note }}" />
                                                        @if($item->hrd_checked == 1)
                                                            <small>Submit Date : {{ Carbon\Carbon::parse($item->hrd_check_date)->format('d M Y H:i') }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">INVENTORY RETURN TO HRD</label>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30px;">NO</th>
                                                    <th>ITEM</th>
                                                    <th style="width: 50px;">CHECKED</th>
                                                    <th>NOTE</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                @foreach($list_exit_clearance_inventory_to_hrd as $no => $item)
                                                <tr>
                                                    <td>{{ $no + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td style="text-align: center;">
                                                        <input type="checkbox" {{ $item->hrd_checked == 1 ? 'checked'  : '' }} name="check_inventory_hrd[{{ $item->id }}]" value="1">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="check_inventory_hrd_catatan[{{ $item->id }}]"  {{ $item->hrd_checked == 0 ? 'readonly="true"' : '' }} class="form-control catatan" value="{{ $item->hrd_note }}" />
                                                        @if($item->hrd_checked == 1)
                                                            <small>Submit Date : {{ Carbon\Carbon::parse($item->hrd_check_date)->format('d M Y H:i') }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">INVENTORY RETURN TO GENERAL AFFAIR (GA)</label>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30px;">NO</th>
                                                    <th>ITEM</th>
                                                    <th style="width:20px;">CHECKED</th>
                                                    <th>NOTE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list_exit_clearance_inventory_to_ga as $no => $item)
                                                <tr>
                                                    <td>{{ $no + 6 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td style="text-align: center;">
                                                        <input type="checkbox" name="check_inventory_ga[{{ $item->id }}]" value="1" {{ $item->ga_checked == 1 ? 'checked' : '' }} />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="check_inventory_ga_catatan[{{ $item->id }}]" {{ $item->ga_checked == 0 ? 'readonly="true"' : '' }} class="form-control catatan" value="{{ $item->ga_note }}" />
                                                         @if($item->ga_checked == 1)
                                                            <small>Submit Date : {{ Carbon\Carbon::parse($item->ga_check_date)->format('d M Y H:i') }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12">INVENTORY RETURN</label>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30px;">NO</th>
                                                    <th>ITEM</th>
                                                    <th style="width:20px;">CHECKED</th>
                                                    <th>NOTE</th>
                                                </tr>
                                            </thead>
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
                                                                    <th>PLAT NO</th>
                                                                    <th>CAR STATUS</th>
                                                                    <th>PURCHASE DATE</th>
                                                                    <th>ASSET CONDITION</th>
                                                                    <th>ASSIGN TO</th>
                                                                    <th>EMPLOYEE</th>
                                                                    <th>HANDOVER DATE</th>
                                                                    <th style="width:20px;">CHECKED</th>
                                                                    <th>NOTE</th>
                                                                </tr>
                                                            </thead>
                                                            @php($no=0)
                                                            @foreach($data->assets as $k => $item)
                                                                @if($item->asset->asset_type->name =='Mobil')
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
                                                                            <input type="checkbox" name="check_asset[{{ $item->id }}]" value="1" {{ $item->status == 1 ? 'checked' : '' }} />
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="catatan_asset[{{ $item->id }}]" class="form-control catatan" value="{{ $item->catatan }}" />
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
                                                                    <th>NOTE</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php($no=0)
                                                                @foreach($data->assets as $k => $item)
                                                                  @if(isset($item->asset->asset_type->name) and $item->asset->asset_type->name !='Mobil')
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
                                                                            <input type="checkbox" name="check_asset[{{ $item->id }}]" value="1" {{ $item->status == 1 ? 'checked' : '' }} />
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="catatan_asset[{{ $item->id }}]" class="form-control catatan" value="{{ $item->catatan }}" />
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
                                </div>
                                <hr />
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <a href="{{ route('karyawan.approval.exit.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                        <button type="submit" class="btn btn-sm btn-info waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Update Form</button>
                                        @if($data->approve_direktur === NULL)
                                            <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-save"></i> Approve </a>
                                            <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Denied</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in active" id="interview">
                                {{ csrf_field() }}
                                <div class="col-md-6" style="padding-left: 0;">
                                    <div class="form-group">
                                        <label class="col-md-6">NIK / Employee Name</label>
                                        <label class="col-md-6">Position</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" value="{{ $data->user->nik .' / '. $data->user->name }}" readonly="true">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" class="form-control department" value="{{ empore_jabatan($data->user->id) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6">Resign Date</label>
                                        <label class="col-md-6">Join Data</label>
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
                                    <label class="col-md-6">Resignation reason :</label>
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            @foreach(get_reason_interview() as $item)
                                            <?php 

                                                if($data->exit_interview_reason != $item->id)
                                                {
                                                    continue;
                                                }
                                            ?>
                                            <li class="list-group-item"><label>{{ $item->label }}</label></li>
                                            @endforeach
                                            @if($item->exit_interview_reason == 'Others')
                                            <li class="list-group-item">
                                                <label><input type="radio" name="exit_interview_reason" value="other" {{ $data->exit_interview_reason == 'other' ? 'checked' : '' }} /> Other (Lainnya, ditulis alasannya)</label>
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
                                    <label class="col-md-12">Things that will be done after resign from Empore Hezer Tama</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="kegiatan_setelah_resign" readonly="true">{{ $data->kegiatan_setelah_resign }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <a href="{{ route('karyawan.approval.exit.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                            <a href="#clearance" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false" class="btn btn-info btn-sm">NEXT <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>    
                <input type="hidden" name="status" value="0" />
                <input type="hidden" name="id" value="{{ $data->id }}">
                <input type="hidden" name="action" value="update" >
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
@section('footer-script')
    <script type="text/javascript">
    

        $("#btn_approved").click(function(){
            bootbox.confirm('Approve Pengajuan Exit Interview & Exit Clearance Karyawan ?', function(result){
                $("input[name='status']").val(1);
                if(result)
                {
                    $("input[name='action']").val('proses');
                    $('#exit_interview_form').submit();
                }
            });
        });

        $("#btn_tolak").click(function(){
            bootbox.confirm('Tolak Pengajuan Exit Interview & Exit Clearance Karyawan ?', function(result){
                if(result)
                {
                    $("input[name='action']").val('proses');

                    $('#exit_interview_form').submit();
                }
            });
        });

        $("input[type='checkbox']").each(function(){
            
            $(this).click(function(){

                if($(this).prop('checked'))
                {   
                    $(this).parent().parent().find(".catatan").removeAttr('readonly');
                }
                else
                {
                    $(this).parent().parent().find(".catatan").attr('readonly', true);
                }
            });
        });
    </script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
