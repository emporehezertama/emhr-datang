@extends('layouts.administrator')

@section('title', 'Setting')

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
                <h4 class="page-title">Setting</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Setting</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0 pull-left">Setting</h3>
                    <div class="clearfix"></div>
                    <hr />
                    <br />
                    <div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">General</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.cabang.index') }}"><i class="mdi mdi-office fa-fw"></i><span class="hide-menu">Branch</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.kabupaten.index') }}"><i class="mdi mdi-google-maps fa-fw"></i><span class="hide-menu">District / City</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.bank.index') }}"><i class="mdi mdi-bank fa-fw"></i><span class="hide-menu">Bank</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.alasan-pengunduran-diri.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Reason for Leaving</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting-master-cuti.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Leave</span></a>
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
                            <a href="{{ route('administrator.asset.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Asset</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.asset-type.index') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">Asset Type</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="col-md-2">
                            <a href="{{ route('administrator.universitas.index') }}"><i class="mdi mdi-library-books fa-fw"></i><span class="hide-menu">University</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.program-studi.index') }}"><i class="mdi mdi-library-books fa-fw"></i><span class="hide-menu">Major</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.profile') }}"><i class="mdi mdi-account fa-fw"></i><span class="hide-menu">Profile Administrator</span></a>
                        </div>

                        <div class="clearfix"></div><br />
                    </div>
                </div>

              <!--   <div class="white-box">
                    <h3 class="box-title m-b-0 pull-left">Setting Approval Form</h3>
                    <div class="clearfix"></div>
                    <hr />
                    <br />
                    <div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting-cuti.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Cuti / Izin Karyawan</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting-payment-request.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Payment Request</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting-medical.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Medical Reimbursement</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting-overtime.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Overtime Sheet </span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting-training.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Training & Perjalanan Dinas</span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('administrator.setting-exit-clearance.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Exit Clearance Management</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                    </div>
                </div> -->

            </div>                        
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
