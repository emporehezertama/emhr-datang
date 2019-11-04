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
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" id="exit_interview_form">
                <div class="col-md-12">
                    <div class="white-box">
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
                                <label class="col-md-6">Join Date</label>
                                <div class="col-md-6">
                                <input type="text" readonly="true" class="form-control jabatan" value="{{ isset($data->user->structure->position) ? $data->user->structure->position->name : '' }}{{ isset($data->user->structure->division) ? $data->user->structure->division->name : ''}}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control" value="{{ $data->user->join_date }}">                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Resign Date</label>
                                <label class="col-md-6">Date Last Work</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" name="resign_date" class="form-control datepicker" value="{{ $data->resign_date }}" >
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" name="last_work_date" class="form-control datepicker" value="{{ $data->last_work_date }}">
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
                            @if($item->id == 12)
                            <textarea class="form-control" readonly="true" name="reason">{{ $item->label}} {{ $data->other_reason}}
                            </textarea>
                            @else
                            <textarea class="form-control" readonly="true" name="reason">{{ $item->label }}
                            </textarea>
                            @endif
                            
                            @if($item->id == 1)
                            <div class="form-group perusahaan_lain">
                            <hr />
                                <label class="col-md-12">If move to other company </label>
                                <p class="col-md-6">New company name</p>
                                <p class="col-md-6">Scope of work</p>
                                <div class="col-md-6">
                                    <textarea class="form-control" readonly="true" name="tujuan_perusahaan_baru">{{ $data->tujuan_perusahaan_baru }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" readonly="true" name="jenis_bidang_usaha">{{ $data->jenis_bidang_usaha }}</textarea>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        </ul>
                        </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label class="col-md-12">Most memorable moments at this company</label>
                                <div class="col-md-12">
                                <textarea class="form-control" name="hal_berkesan" readonly="true">{{ $data->hal_berkesan }}</textarea>
                                </div>
                        </div>
                        <hr />
                        <!--
                        <div class="form-group">
                            <label class="col-md-12">Unmemorable moments while working at this company</label>
                            <div class="col-md-12">
                            <textarea class="form-control" name="hal_tidak_berkesan" readonly="true">{{ $data->hal_tidak_berkesan }}</textarea>
                            </div>
                        </div>
                        <hr />
                        -->
                        <div class="form-group">
                            <label class="col-md-12">Suggestion and Critic</label>
                            <div class="col-md-12">
                            <textarea class="form-control" name="masukan" readonly="true">{{ $data->masukan }}</textarea>
                            </div>
                        </div>
                        <hr />
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <a href="{{ route('administrator.exit-custom.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
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
