@extends('layouts.administrator')

@section('title', 'Setting')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                 </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Setting</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 pt-1 p-l-0 p-r-0">
                <div class="white-box">
                    <div>
                        <h5 class="box-title">Setting</h5>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting.general') }}" ><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">General</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.cabang.index') }}"><i class="mdi mdi-office fa-fw"></i><span class="hide-menu">Branch</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.provinsi.index') }}"><i class="mdi mdi-google-maps fa-fw"></i><span class="hide-menu">@lang('setting.provinsi')</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.kabupaten.index') }}"><i class="mdi mdi-map-marker-radius fa-fw"></i><span class="hide-menu">District / City</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.kecamatan.index') }}"><i class="mdi mdi-map-marker fa-fw"></i><span class="hide-menu">@lang('setting.kecamatan')</span></a>
                        </div>
                        <div class="clearfix"></div><hr />
                        <div class="col-md-2">
                             @if(checkModuleAdmin(4))
                                <a href="{{ route('administrator.libur-nasional.index') }}"><i class="mdi mdi-calendar-multiple fa-fw"></i><span class="hide-menu">Public Holiday</span></a>
                             @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-calendar-multiple fa-fw"></i><span class="hide-menu">Public Holiday</span></a>
                             @endif
                            
                        </div>
                        
                        <div class="col-md-2">
                            <a href="{{ route('administrator.universitas.index') }}"><i class="mdi mdi-school fa-fw"></i><span class="hide-menu">University</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.program-studi.index') }}"><i class="mdi mdi-library-books fa-fw"></i><span class="hide-menu">Major</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.position.index') }}"><i class="mdi mdi-account-star fa-fw"></i><span class="hide-menu">Position</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="col-md-2">
                            <a href="{{ route('administrator.division.index') }}"><i class="mdi mdi-account-star-variant fa-fw"></i><span class="hide-menu">Division</span></a>
                        </div>
                        <div class="clearfix"></div><hr />
                        <div class="col-md-2">
                            <a href="{{ route('attendance-setting.index') }}"><i class="mdi mdi-fingerprint fa-fw"></i><span class="hide-menu">Attendance & Shift</span></a>

                        </div>
                        <div class="clearfix"></div><br />
                    </div>
                </div>
            </div>                        
        </div>

        
    </div>
   @include('layouts.footer')
</div>
<style type="text/css">
    .box-title{
        margin-bottom: 25px !important;
        margin-left: 16px !important;
        font-size: 12px !important;
        color: #337ab7 !important;
    }
    a.disabled {
        cursor: default !important;
    }

</style>
@endsection
