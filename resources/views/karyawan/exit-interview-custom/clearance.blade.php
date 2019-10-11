@extends('layouts.karyawan')

@section('title', 'Exit Clearance Form')

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
                <h4 class="page-title">Exit Clearance</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Exit Clearance </li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data" action="{{ route('karyawan.exit-custom.prosesclearance') }}" method="POST" id="exit_interview_form">
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
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-12">INVENTORY RETURN</label>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="70" class="text-center">No</th>
                                            <th>ASSET NUMBER</th>
                                            <th>ASSET NAME</th>
                                            <th>ASSET TYPE</th>
                                            <th>SERIAL/PLAT NUMBER</th>
                                            <th>PURCHASE/RENTAL DATE</th>
                                            <th>ASSET OWNERSHIP</th>
                                            <th>ASSET CONDITION</th>
                                            <th>HANDOVER DATE</th>
                                            <th>APPROVAL CHECKED</th>
                                            <th>NOTE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($no = 0)
                                        @foreach($data as $k => $item)
                                        @php($no++)
                                        <tr>
                                            <input type="hidden" name="asset[{{$no}}]" value="{{ $item->id }}" />
                                            <td class="text-center">{{ $no }}</td>
                                            <td>{{ $item->asset->asset_number }}</td>
                                            <td>{{ $item->asset->asset_name }}</td>
                                            <td>{{ isset($item->asset->asset_type->name) ? $item->asset->asset_type->name : ''  }}</td>
                                            <td>{{ $item->asset->asset_sn }}</td>
                                            <td>{{ format_tanggal($item->asset->purchase_date) }}</td>
                                            <td>@if($item->asset->status_mobil == 'Rental')
                                                    Rental
                                                @elseif($item->asset->status_mobil == 'Perusahaan')
                                                    Company Inventory
                                                @endif </td>
                                            <td>{{ $item->asset->asset_condition }}</td>
                                            <td>{{ $item->asset->handover_date != "" ?  format_tanggal($item->asset->handover_date) : '' }}</td>

                                            <td style="text-align: center;">
                                                @if($item->approval_check == 1)
                                                <label class="bt btn-success btn-xs"><i class="fa fa-check"></i> </label>
                                                @else
                                                <label class="bt btn-danger btn-xs"><i class="fa fa-close"></i> </label>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" name="catatan[{{$no}}]" class="form-control catatan" value="{{ $item->catatan }}" />
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('karyawan.exit-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="submit_form"><i class="fa fa-save"></i> Submit Exit Clearance</a>
                            </div>
                        </div>

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
@section('footer-script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link href="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
<!-- Clock Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
<script type="text/javascript">

    $("input[name='exit_interview_reason']").click(function(){

        if($(this).val() == 1)
        {
            $('.perusahaan_lain').show("slow");
        }
        else if($(this).val() == 'other')
        {
            $("textarea[name='other_reason']").show();
        }
        else
        {
            $('.perusahaan_lain').hide("slow");
            $("textarea[name='other_reason']").hide();
        }
    });
</script>
<script type="text/javascript">

    var list_atasan = [];

    @foreach(empore_get_atasan_langsung() as $item)
        list_atasan.push({id : {{ $item->id }}, value : '{{ $item->nik .' - '. $item->name.' - '. empore_jabatan($item->id) }}',  });
    @endforeach
</script>
<script type="text/javascript">

    $('#submit_form').click(function(){

        bootbox.confirm("Do you want to submit this form ?", function(result){
            if(result)
            {
                $("#exit_interview_form").submit()
            }
        });

    });

    jQuery('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
    });

    $('.next_exit_clearance').click(function(){

        $("a[href='#clearance']").parent().addClass('active');

        $("a[href='#interview']").parent().removeClass('active');
    });

</script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
