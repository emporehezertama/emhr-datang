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
                <h4 class="page-title">Exit Interview</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Exit Interview </li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data" action="{{ route('karyawan.exit-custom.store') }}" method="POST" id="exit_interview_form">
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
                                <div class="col-md-6" style="padding-left: 0;">
                                    <div class="form-group">
                                        <label class="col-md-12">NIK / Employee Name</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" value="{{ Auth::user()->nik .' / '. Auth::user()->name }}" readonly="true">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6">Position</label>
                                        <label class="col-md-6">Join Date </label>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" class="form-control jabatan" value="{{ isset(Auth::user()->structure->position) ? Auth::user()->structure->position->name:''}}{{ isset(Auth::user()->structure->division) ? '-'. Auth::user()->structure->division->name:'' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly="true" class="form-control" value="{{ Auth::user()->join_date }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6">Resign Date </label>
                                        <label class="col-md-6">Date Last Work </label>
                                        <div class="col-md-6">
                                            <input type="text" name="resign_date" class="form-control datepicker" value="" >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="last_work_date" class="form-control datepicker" value="">
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
                                            <li class="list-group-item"><label><input type="radio" name="exit_interview_reason" value="{{ $item->id }}" /> {{ $item->label }}</label>
                                            @if($item->id == 1)
                                            <div class="form-group perusahaan_lain" style="display: none;">
                                                <hr />
                                                <label class="col-md-12">If move to other company </label>
                                                <p class="col-md-6">New company name </p>
                                                <p class="col-md-6">Scope of work </p>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" name="tujuan_perusahaan_baru">{{ old('tujuan_perusahaan_baru') }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" name="jenis_bidang_usaha">{{ old('jenis_bidang_usaha') }}</textarea>
                                                </div>
                                            </div>
                                            @elseif($item->id == 12)
                                            <textarea class="form-control" placeholder="Other Reason" name="other_reason" style="display: none;"></textarea>
                                            @endif
                                            </li>
                                            @endforeach
                                            
                                        </ul>
                                    </div>
                                </div>

                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Most memorable moments at this company</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="hal_berkesan">{{ old('hal_berkesan') }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Unmemorable moments while working at this company</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="hal_tidak_berkesan">{{ old('hal_tidak_berkesan') }}</textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-12">Suggestion and Critic</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="masukan">{{ old('masukan') }}</textarea>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                         <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <a href="{{ route('karyawan.exit-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                    <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="submit_form"><i class="fa fa-save"></i> Submit Exit Interview & Exit Clearance</a>
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
            $("textarea[name='other_reason']").hide();
        }
        else if($(this).val() == 12)
        {
            $("textarea[name='other_reason']").show();
             $('.perusahaan_lain').hide();
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
