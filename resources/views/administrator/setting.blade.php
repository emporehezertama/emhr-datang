@extends('layouts.administrator')

@section('title', 'Setting')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Setting</h4> </div>
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
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting.general') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">General</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.cabang.index') }}"><i class="mdi mdi-office fa-fw"></i><span class="hide-menu">Branch</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.provinsi.index') }}"><i class="mdi mdi-google-maps fa-fw"></i><span class="hide-menu">@lang('setting.provinsi')</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.kabupaten.index') }}"><i class="mdi mdi-google-maps fa-fw"></i><span class="hide-menu">District / City</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.kecamatan.index') }}"><i class="mdi mdi-google-maps fa-fw"></i><span class="hide-menu">@lang('setting.kecamatan')</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.alasan-pengunduran-diri.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Reason for Leaving</span></a>
                        </div>
                        <div class="clearfix"></div><hr />
                        <div class="col-md-2">
                            <a href="{{ route('administrator.cuti-bersama.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Collective Leave</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.absensi.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Attendance</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.libur-nasional.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Public Holiday</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.plafond-dinas.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Business Trip Allowance</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.universitas.index') }}"><i class="mdi mdi-library-books fa-fw"></i><span class="hide-menu">University</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.program-studi.index') }}"><i class="mdi mdi-library-books fa-fw"></i><span class="hide-menu">Major</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting.email') }}"><i class="mdi mdi-email fa-fw"></i><span class="hide-menu">Email</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting-master-cuti.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Leave</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.bank.index') }}"><i class="mdi mdi-bank fa-fw"></i><span class="hide-menu">Bank</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.backup') }}"><i class="mdi mdi-bank fa-fw"></i><span class="hide-menu">Backup App & Database</span></a>
                        </div>
                        <div class="clearfix"></div><br />
                    </div>
                </div>
            </div>                        
        </div>
    </div>
   @include('layouts.footer')
</div>
@endsection
