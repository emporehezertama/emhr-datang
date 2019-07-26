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
                        <div class="col-md-2">
                            @if(checkModuleAdmin(9))
                                <a href="{{ route('administrator.alasan-pengunduran-diri.index') }}" ><i class="mdi mdi-playlist-remove fa-fw"></i><span class="hide-menu">Reason for Leaving</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-playlist-remove fa-fw"></i><span class="hide-menu">Reason for Leaving</span></a>
                            @endif
                            
                        </div>
                        <div class="clearfix"></div><hr />
                        <div class="col-md-2">
                            @if(checkModuleAdmin(4))
                                <a href="{{ route('administrator.cuti-bersama.index') }}"><i class="mdi mdi-calendar-text fa-fw"></i><span class="hide-menu">Collective Leave</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-calendar-text fa-fw"></i><span class="hide-menu">Collective Leave</span></a>
                            @endif
                            
                        </div>
                        <div class="col-md-2">
                             @if(checkModuleAdmin(4))
                                <a href="{{ route('administrator.libur-nasional.index') }}"><i class="mdi mdi-calendar-multiple fa-fw"></i><span class="hide-menu">Public Holiday</span></a>
                             @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-calendar-multiple fa-fw"></i><span class="hide-menu">Public Holiday</span></a>
                             @endif
                            
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(8))
                                <a href="{{ route('administrator.plafond-dinas.index') }}"><i class="mdi mdi-cash-100 fa-fw"></i><span class="hide-menu">Business Trip Allowance</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-cash-100 fa-fw"></i><span class="hide-menu">Business Trip Allowance</span></a>
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
                            <a href="{{ route('administrator.setting.email') }}"><i class="mdi mdi-email fa-fw"></i><span class="hide-menu">Email</span></a>
                        </div>
                        <div class="col-md-2">
                             @if(checkModuleAdmin(4))
                                <a href="{{ route('administrator.setting-master-cuti.index') }}"><i class="mdi mdi-calendar-blank fa-fw"></i><span class="hide-menu">Leave</span></a>
                             @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-calendar-blank fa-fw"></i><span class="hide-menu">Leave</span></a>
                             @endif
                            
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.bank.index') }}"><i class="mdi mdi-bank fa-fw"></i><span class="hide-menu">Bank</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-backup-restore fa-fw"></i><span class="hide-menu">Backup App & Database</span></a>
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(13))
                                <a href="{{ route('administrator.payroll-setting.index') }}"><i class="mdi mdi-cash fa-fw"></i><span class="hide-menu">Payroll</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-cash fa-fw"></i><span class="hide-menu">Payroll</span></a>
                            @endif
                            
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.division.index') }}"><i class="mdi mdi-account-star-variant fa-fw"></i><span class="hide-menu">Division</span></a>
                        </div>
                        <div class="clearfix"></div><hr />
                        <div class="col-md-2">
                             @if(checkModuleAdmin(8))
                                <a href="{{ route('administrator.training-type.index') }}"><i class="mdi mdi-airplane fa-fw"></i><span class="hide-menu">Business Trip Type</span></a>
                             @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-airplane fa-fw"></i><span class="hide-menu">Business Trip Type</span></a>
                             @endif
                            
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(5))
                                <a href="{{ route('administrator.medical-plafond.index') }}"><i class="mdi mdi-hospital fa-fw"></i><span class="hide-menu">Medical Plafond</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-hospital fa-fw"></i><span class="hide-menu">Medical Plafond</span></a>
                            @endif
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(5))
                                <a href="{{ route('attendance-setting.index') }}"><i class="mdi mdi-fingerprint fa-fw"></i><span class="hide-menu">Attendance</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-fingerprint fa-fw"></i><span class="hide-menu">Medical Plafond</span></a>
                            @endif
                        </div>
                        <div class="clearfix"></div><br />
                    </div>
                </div>
            </div>                        
        </div>

        <div class="row">
            <div class="col-md-12 pt-1 p-l-0 p-r-0">
                <div class="white-box">
                    <div>
                        <h5 class="box-title">Setting Approval</h5>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(4))
                                <a href="{{ route('administrator.setting-approvalLeave.index') }}"><i class="mdi mdi-calendar-check fa-fw"></i><span class="hide-menu">Leave/Permit Approval</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-calendar-check fa-fw"></i><span class="hide-menu">Leave/Permit Approval</span></a>
                            @endif
                             
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(6))
                                <a href="{{ route('administrator.setting-approvalPaymentRequest.index') }}"><i class="mdi mdi-cast fa-fw"></i><span class="hide-menu">Payment Request Approval</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-cast fa-fw"></i><span class="hide-menu">Payment Request Approval</span></a>
                            @endif
                            
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(7))
                                <a href="{{ route('administrator.setting-approvalOvertime.index') }}"><i class="mdi mdi-checkbox-multiple-marked-circle-outline fa-fw"></i><span class="hide-menu">Overtime Approval</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-checkbox-multiple-marked-circle-outline fa-fw"></i><span class="hide-menu">Overtime Approval</span></a>
                            @endif
                            
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(8))
                                <a href="{{ route('administrator.setting-approvalTraining.index') }}"><i class="mdi mdi-car-connected fa-fw"></i><span class="hide-menu">Training Approval</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-car-connected fa-fw"></i><span class="hide-menu">Training Approval</span></a>
                            @endif
                            
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="col-md-2">
                             @if(checkModuleAdmin(5))
                                <a href="{{ route('administrator.setting-approvalMedical.index') }}"><i class="mdi mdi-hospital-building fa-fw"></i><span class="hide-menu">Medical Approval</span></a>
                             @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-hospital-building fa-fw"></i><span class="hide-menu">Medical Approval</span></a>
                             @endif
                            
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(9))
                                <a href="{{ route('administrator.setting-approvalExit.index') }}"><i class="mdi mdi-arrow-right-bold-circle-outline fa-fw"></i><span class="hide-menu">Exit Interview</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-arrow-right-bold-circle-outline fa-fw"></i><span class="hide-menu">Exit Interview</span></a>
                            @endif
                            
                        </div>
                        <div class="col-md-2">
                            @if(checkModuleAdmin(9))
                                <a href="{{ route('administrator.setting-approvalClearance.index') }}"><i class="mdi mdi-checkbox-multiple-marked-outline fa-fw"></i><span class="hide-menu">Exit Clearance</span></a>
                            @else
                                <a href="javascript:void(0)" class="disabled" onclick="alert('You do not have permission to access this menu')"><i class="mdi mdi-checkbox-multiple-marked-outline fa-fw"></i><span class="hide-menu">Exit Clearance</span></a>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        <hr />
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
