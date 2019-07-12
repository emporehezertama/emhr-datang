@if(Auth::user()->access_id == 1)
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        @if(checkModuleAdmin(2))
        <li><a href="{{ route('administrator.dashboard') }}"><i class="mdi mdi-chart-bar fa-fw" data-icon="v"></i> Dashboard </a></li>
        <li class="devider"></li>
        @endif
        @if(checkModuleAdmin(3))
        <li>
            <a href="{{ route('administrator.karyawan.index') }}">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">@lang('menu.employee')<span class="fa arrow"></span></span>
            </a>
        </li>
        @endif

        @if(checkModuleAdmin(4) || checkModuleAdmin(5) || checkModuleAdmin(6) || checkModuleAdmin(7) || checkModuleAdmin(8) || checkModuleAdmin(9) || checkModuleAdmin(10))
        <li class="mega-nav">
            <a href="#" style="position: relative;">
                <i class="mdi mdi-playlist-check fa-fw"></i> <span class="hide-menu">Workflow Monitoring<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                    @if(checkModuleAdmin(4))
                    <li><a href="{{ route('administrator.leaveCustom.index') }}"><i class="mdi mdi-calendar-multiple-check fa-fw"></i><span class="hide-menu">@lang('menu.leave_or_permit')</span></a></li>
                    @endif
                    @if(checkModuleAdmin(6))
                    <li><a href="{{ route('administrator.paymentRequestCustom.index') }}"><i class="mdi mdi-cash-multiple fa-fw"></i><span class="hide-menu">@lang('menu.payment_request')</span></a></li>
                    @endif
                    @if(checkModuleAdmin(7))
                    <li><a href="{{ route('administrator.overtimeCustom.index') }}"><i class="mdi mdi-clock-fast fa-fw"></i><span class="hide-menu">@lang('menu.overtime_sheet') </span></a></li>
                    @endif
                    @if(checkModuleAdmin(8))
                    <li><a href="{{ route('administrator.trainingCustom.index') }}"><i class="mdi mdi-taxi fa-fw"></i><span class="hide-menu">Training & Business Trip</span></a></li>
                    @endif
                    @if(checkModuleAdmin(5))
                    <li><a href="{{ route('administrator.medicalCustom.index') }}"><i class="mdi mdi-stethoscope fa-fw"></i><span class="hide-menu">Medical Reimbursement</span></a></li>
                    @endif
                    @if(checkModuleAdmin(9))
                    <li><a href="{{ route('administrator.exitCustom.index') }}"><i class="mdi mdi-account-remove fa-fw"></i><span class="hide-menu">Exit Interview & Clearance</span></a></li>
                    @endif
                
                    @if(checkModuleAdmin(10))
                    <li><a href="{{ route('administrator.request-pay-slip.index') }}"><i class="mdi mdi-library-books fa-fw"></i><span class="hide-menu">Request Pay Slip</span></a></li>
                    @endif
            </ul>
        </li>
        @endif

        @if(checkModuleAdmin(11))
        <li>
            <a href="{{ route('administrator.organization-structure-custom.index') }}" class="waves-effect">
            <i class="mdi mdi-sitemap fa-fw"></i> <span class="hide-menu">@lang('menu.organization_structure')<span class="fa arrow"></span></span>
            </a>
        </li>
        @endif
        @if(checkModuleAdmin(12))
        <li>
            <a href="javascript:void(0)">
                <i class="mdi mdi-newspaper fa-fw"></i> <span class="hide-menu">News List / Memo<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{ route('administrator.news.index') }}"><i class="mdi mdi-book-multiple fa-fw"></i><span class="hide-menu">News</span></a></li>
                <li><a href="{{ route('administrator.internal-memo.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Internal Memo</span></a></li>
                <li><a href="{{ route('administrator.peraturan-perusahaan.index') }}"><i class="mdi mdi-file-document-box fa-fw"></i><span class="hide-menu">Product Information</span></a></li>
            </ul>
        </li>
        @endif
        @if(checkModuleAdmin(13))
        <li>
            <a href="{{ route('administrator.payroll.index') }}">
                <i class="mdi mdi-cash fa-fw"></i> <span class="hide-menu">Payroll</span>
            </a>
        </li>
        @endif
        @if(checkModuleAdmin(14))
        <li>
            <a href="javascript:void(0)">
                <i class="mdi mdi-nutrition fa-fw"></i> <span class="hide-menu">Facilities Management<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('administrator.asset.index') }}"><i class="mdi mdi-home-modern fa-fw"></i><span class="hide-menu">Facilities</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.asset-type.index') }}"><i class="mdi mdi-plus-network fa-fw"></i><span class="hide-menu">Facilities Type</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.asset-tracking.index') }}"><i class="mdi mdi-chemical-weapon fa-fw"></i><span class="hide-menu">Facilities Tracking</span></a>
                </li>
            </ul>
        </li>
        @endif
       
        @if(checkModuleAdmin(15))
       <li>
             <a href="{{ route('attendance.index') }}"><i class="mdi mdi-fingerprint fa-fw"></i><span class="hide-menu">Attendance</span></a>
        </li>
        @endif
        @if(checkModuleAdmin(16))
        <li class="mega-nav">
            <a href="{{ route('administrator.setting.index') }}" class="waves-effect">
                <i class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">@lang('menu.setting')</span>
            </a>
        </li>
        @endif
        <!--As Karyawan-->
        <li class="devider"></li>
          @if(checkModule(4) || checkModule(5) || checkModule(6) || checkModule(7) || checkModule(8) || checkModule(9) || checkModule(10))
        <li class="mega-nav">
            <a href="javascript:void(0)" class="waves-effect">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Management Form<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                     @if(checkModule(4)) 
                    <li>
                        <a href="{{ route('administrator.leave.index') }}"><i class="mdi mdi-calendar-multiple-check fa-fw"></i><span class="hide-menu">Leave / Permit</span></a>
                    </li>
                    @endif
                    @if(checkModule(6))
                    <li>
                        <a href="{{ route('administrator.payment-request-custom.index') }}"><i class="mdi mdi-cash-multiple fa-fw"></i><span class="hide-menu">Payment Request</span></a>
                    </li>
                    @endif
                    @if(checkModule(7))
                    <li>
                    <a href="{{ route('administrator.overtime-custom.index') }}"><i class="mdi mdi-clock-fast fa-fw"></i><span class="hide-menu">Overtime Sheet </span></a>
                    </li>
                    @endif
                    @if(checkModule(8))
                    <li>
                    <a href="{{ route('administrator.training-custom.index') }}"><i class="mdi mdi-taxi fa-fw"></i><span class="hide-menu">Training & Business Trip</span></a>
                    </li>
                    @endif
                    @if(checkModule(5))
                    <li>
                    <a href="{{ route('administrator.medical-custom.index') }}"><i class="mdi mdi-stethoscope fa-fw"></i><span class="hide-menu">Medical Reimbursement</span></a>
                    </li>
                    @endif
                    @if(checkModule(9))
                    <li>
                    <a href="{{ route('administrator.exit-custom.index') }}"><i class="mdi mdi-account-remove fa-fw"></i><span class="hide-menu">Exit Interview & Clearance</span></a>
                    </li>
                    @endif
                    @if(checkModule(10))
                    <li class="mega-nav">
                        <a href="{{ route('administrator.request-pay-slip-karyawan.index') }}" class="waves-effect">
                            <i class="mdi mdi-library-books fa-fw"></i> <span class="hide-menu">Request Pay Slip</span>
                        </a>
                    </li>
                    @endif
            </ul>
        </li>
        @endif
        

        @php($leave_menu = count_leave_approval())
        @php($payment_menu = count_payment_request_approval())
        @php($overtime_menu = count_overtime_approval())
        @php($training_menu = count_training_approval())
        @php($medical_menu = count_medical_approval())
        @php($exit_menu = count_exit_approval())
        @php($clearance_menu = count_clearance_approval())
        @if($leave_menu['all'] > 0 || $payment_menu['all'] > 0 || $overtime_menu['all'] > 0 || $training_menu['all'] > 0 || $medical_menu['all'] > 0 || $exit_menu['all'] > 0 || $clearance_menu['all'] > 0)

            @if(checkModule(4) || checkModule(5) || checkModule(6) || checkModule(7) || checkModule(8) || checkModule(9))
            <li style="position: relative;">
                    <a href="javascript:void(0)" class="waves-effect">
                        <i class="mdi mdi-account-check fa-fw"></i> <span class="hide-menu">Management Approval<span class="fa arrow"></span></span>
                    </a>
                    @if($leave_menu['waiting'] > 0 || $payment_menu['waiting'] > 0 || $overtime_menu['waiting'] > 0 || $training_menu['waiting'] > 0 || $medical_menu['waiting'] > 0 || $exit_menu['waiting'] > 0 || $clearance_menu['waiting'] > 0)    
                        <div class="notify" style="position: absolute;top: 61px;right: 10px;"> <span class="heartbit"></span> <span class="point"></span> </div>
                    @endif

                <ul class="nav nav-second-level">
                    @if(checkModule(4))
                    <li>
                        <a href="{{ route('administrator.approval.leave-custom.index') }}"><i class="mdi mdi-calendar-check fa-fw"></i><span class="hide-menu">Leave/Permit</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $leave_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(6))
                    <li>
                        <a href="{{ route('administrator.approval.payment-request-custom.index') }}"><i class="mdi mdi-cast fa-fw"></i><span class="hide-menu">Payment Request</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $payment_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(7))
                    <li>
                        <a href="{{ route('administrator.approval.overtime-custom.index') }}"><i class="mdi mdi-checkbox-multiple-marked-circle-outline fa-fw"></i><span class="hide-menu">Overtime Sheet</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $overtime_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(8))
                    <li>
                        <a href="{{ route('administrator.approval.training-custom.index') }}"><i class="mdi mdi-car-connected fa-fw"></i><span class="hide-menu">Business Trip / Training</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $training_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(5))
                    <li>
                        <a href="{{ route('administrator.approval.medical-custom.index') }}"><i class="mdi mdi-hospital-building fa-fw"></i><span class="hide-menu">Medical Reimbursement</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $medical_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(9))
                    <li>
                        <a href="{{ route('administrator.approval.exit-custom.index') }}"><i class="mdi mdi-arrow-right-bold-circle-outline fa-fw"></i><span class="hide-menu">Exit Interview</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $exit_menu['waiting'] }}</label>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('administrator.approval.clearance-custom.index') }}"><i class="mdi mdi-checkbox-multiple-marked-outline fa-fw"></i><span class="hide-menu">Exit Clearance</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $clearance_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
        @endif
    </ul>
@elseif(Auth::user()->access_id == 3)
<ul class="nav" id="side-menu">
    <li class="user-pro">
        <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
        </a>
    </li>
    <li><a href="{{ route('superadmin.dashboard') }}"><i class="mdi mdi-chart-bar fa-fw" data-icon="v"></i> Dashboard </a></li>
    <li class="devider"></li>
    <li>
        <a href="{{ route('superadmin.admin.index') }}">
        <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Admin<span class="fa arrow"></span></span>
        </a>
    </li>
    <li class="mega-nav">
        <a href="#" style="position: relative;">
        <i class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Setting<span class="fa arrow"></span></span>
        </a>
        <ul class="nav nav-second-level">
            <li><a href="{{ route('superadmin.setting.general') }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu">General</span></a></li>
            <li><a href="{{ route('superadmin.setting.email') }}"><i class="mdi mdi-email fa-fw"></i><span class="hide-menu">Email</span></a></li>
            <li><a href="{{ route('superadmin.setting.backup') }}"><i class="mdi mdi-backup-restore fa-fw"></i><span class="hide-menu">Backup App & Database</span></a></li>
        </ul>
    </li>
</ul>
@else
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        @if(checkModule(2))
        <li> <a href="{{ route('karyawan.dashboard') }}" class="waves-effect"><i class="mdi mdi-chart-bar fa-fw" data-icon="v"></i> Dashboard </a></li>
        @endif
        <li class="devider"></li>
          @if(checkModule(4) || checkModule(5) || checkModule(6) || checkModule(7) || checkModule(8) || checkModule(9))
        <li class="mega-nav">
            <a href="javascript:void(0)" class="waves-effect">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Management Form<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                     @if(checkModule(4)) 
                    <li>
                        <a href="{{ route('karyawan.leave.index') }}"><i class="mdi mdi-calendar-multiple-check fa-fw"></i><span class="hide-menu">Leave / Permit</span></a>
                    </li>
                    @endif
                    @if(checkModule(6))
                    <li>
                        <a href="{{ route('karyawan.payment-request-custom.index') }}"><i class="mdi mdi-cash-multiple fa-fw"></i><span class="hide-menu">Payment Request</span></a>
                    </li>
                    @endif
                    @if(checkModule(7))
                    <li>
                    <a href="{{ route('karyawan.overtime-custom.index') }}"><i class="mdi mdi-clock-fast fa-fw"></i><span class="hide-menu">Overtime Sheet </span></a>
                    </li>
                    @endif
                    @if(checkModule(8))
                    <li>
                    <a href="{{ route('karyawan.training-custom.index') }}"><i class="mdi mdi-taxi fa-fw"></i><span class="hide-menu">Training & Business Trip</span></a>
                    </li>
                    @endif
                    @if(checkModule(5))
                    <li>
                    <a href="{{ route('karyawan.medical-custom.index') }}"><i class="mdi mdi-stethoscope fa-fw"></i><span class="hide-menu">Medical Reimbursement</span></a>
                    </li>
                    @endif
                    @if(checkModule(9))
                    <li>
                    <a href="{{ route('karyawan.exit-custom.index') }}"><i class="mdi mdi-account-remove fa-fw"></i><span class="hide-menu">Exit Interview & Clearance</span></a>
                    </li>
                    @endif
                    @if(checkModule(10))
                    <li class="mega-nav">
                        <a href="{{ route('karyawan.request-pay-slip.index') }}" class="waves-effect">
                            <i class="mdi mdi-library-books fa-fw"></i> <span class="hide-menu">Request Pay Slip</span>
                        </a>
                    </li>
                    @endif
            </ul>
        </li>
        @endif
        
        @php($leave_menu = count_leave_approval())
        @php($payment_menu = count_payment_request_approval())
        @php($overtime_menu = count_overtime_approval())
        @php($training_menu = count_training_approval())
        @php($medical_menu = count_medical_approval())
        @php($exit_menu = count_exit_approval())
        @php($clearance_menu = count_clearance_approval())
        @if($leave_menu['all'] > 0 || $payment_menu['all'] > 0 || $overtime_menu['all'] > 0 || $training_menu['all'] > 0 || $medical_menu['all'] > 0 || $exit_menu['all'] > 0 || $clearance_menu['all'] > 0)

            @if(checkModule(4) || checkModule(5) || checkModule(6) || checkModule(7) || checkModule(8) || checkModule(9))
            <li style="position: relative;">
                    <a href="javascript:void(0)" class="waves-effect">
                        <i class="mdi mdi-account-check fa-fw"></i> <span class="hide-menu">Management Approval<span class="fa arrow"></span></span>
                    </a>
                    @if($leave_menu['waiting'] > 0 || $payment_menu['waiting'] > 0 || $overtime_menu['waiting'] > 0 || $training_menu['waiting'] > 0 || $medical_menu['waiting'] > 0 || $exit_menu['waiting'] > 0 || $clearance_menu['waiting'] > 0)    
                        <div class="notify" style="position: absolute;top: 61px;right: 10px;"> <span class="heartbit"></span> <span class="point"></span> </div>
                    @endif

                <ul class="nav nav-second-level">
                    @if(checkModule(4))
                    <li>
                        <a href="{{ route('karyawan.approval.leave-custom.index') }}"><i class="mdi mdi-calendar-check fa-fw"></i><span class="hide-menu">Leave/Permit</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $leave_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(6))
                    <li>
                        <a href="{{ route('karyawan.approval.payment-request-custom.index') }}"><i class="mdi mdi-cast fa-fw"></i><span class="hide-menu">Payment Request</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $payment_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(7))
                    <li>
                        <a href="{{ route('karyawan.approval.overtime-custom.index') }}"><i class="mdi mdi-checkbox-multiple-marked-circle-outline fa-fw"></i><span class="hide-menu">Overtime Sheet</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $overtime_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(8))
                    <li>
                        <a href="{{ route('karyawan.approval.training-custom.index') }}"><i class="mdi mdi-car-connected fa-fw"></i><span class="hide-menu">Business Trip / Training</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $training_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(5))
                    <li>
                        <a href="{{ route('karyawan.approval.medical-custom.index') }}"><i class="mdi mdi-hospital-building fa-fw"></i><span class="hide-menu">Medical Reimbursement</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $medical_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                    @if(checkModule(9))
                    <li>
                        <a href="{{ route('karyawan.approval.exit-custom.index') }}"><i class="mdi mdi-arrow-right-bold-circle-outline fa-fw"></i><span class="hide-menu">Exit Interview</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $exit_menu['waiting'] }}</label>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('karyawan.approval.clearance-custom.index') }}"><i class="mdi mdi-checkbox-multiple-marked-outline fa-fw"></i><span class="hide-menu">Exit Clearance</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $clearance_menu['waiting'] }}</label>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
        @endif
           
    </ul>
@endif