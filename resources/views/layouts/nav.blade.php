@if(Auth::user()->access_id == 1)
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        <li><a href="{{ route('administrator.dashboard') }}"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> Dashboard </a></li>
        <li class="devider"></li>
        <li>
            <a href="{{ route('administrator.karyawan.index') }}">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">@lang('menu.employee')<span class="fa arrow"></span></span>
            </a>
        </li>
        <li class="mega-nav">
            <a href="#" style="position: relative;">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Workflow Monitoring<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                @if(get_setting('struktur_organisasi') == 3)
                    <li><a href="{{ route('administrator.leaveCustom.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.leave_or_permit')</span></a></li>
                    <li><a href="{{ route('administrator.paymentRequestCustom.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.payment_request')</span></a></li>
                    <li><a href="{{ route('administrator.overtimeCustom.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.overtime_sheet') </span></a></li>
                    <li><a href="{{ route('administrator.trainingCustom.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Training & Business Trip</span></a></li>
                    <li><a href="{{ route('administrator.medicalCustom.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Medical Reimbursement</span></a></li>
                    <li><a href="{{ route('administrator.exitCustom.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Exit Interview & Clearance</span></a></li>
                @else
                    <li><a href="{{ route('administrator.cuti.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.leave_or_permit')</span></a></li>
                    <li><a href="{{ route('administrator.payment-request.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.payment_request')</span></a></li>
                    <li><a href="{{ route('administrator.medical.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.medical_reimbursement')</span></a></li>
                    <li><a href="{{ route('administrator.overtime.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.overtime_sheet') </span></a></li>
                    <li><a href="{{ route('administrator.exit-interview.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Exit Interview & Clearance </span></a></li>
                    <li><a href="{{ route('administrator.training.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Training & Business Trip</span></a></li>
                @endif
                <li><a href="{{ route('administrator.request-pay-slip.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Request Pay Slip</span></a></li>
            </ul>
        </li>

        <li>
            @if(get_setting('struktur_organisasi') == 3)
            <a href="{{ route('administrator.organization-structure-custom.index') }}" class="waves-effect">
                <i class="mdi mdi-account-network fa-fw"></i> <span class="hide-menu">@lang('menu.organization_structure')<span class="fa arrow"></span></span>
            </a>
            @else
            <a href="{{ route('administrator.structure') }}" class="waves-effect">
                <i class="mdi mdi-account-network fa-fw"></i> <span class="hide-menu">@lang('menu.organization_structure')<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('administrator.empore-direktur.index') }}"><i class="mdi mdi-account-network fa-fw"></i><span class="hide-menu">Director</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.empore-manager.index') }}"><i class="mdi mdi-account-network fa-fw"></i><span class="hide-menu">Manager</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.empore-staff.index') }}"><i class="mdi mdi-account-network fa-fw"></i><span class="hide-menu">Staff</span></a>
                </li>
            </ul>
            @endif
        </li>
        <li class="mega-nav">
            <a href="{{ route('administrator.setting.index') }}" class="waves-effect">
                <i class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">@lang('menu.setting')</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">
                <i class="mdi mdi-newspaper fa-fw"></i> <span class="hide-menu">News List / Memo<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{ route('administrator.news.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">News</span></a></li>
                <li><a href="{{ route('administrator.internal-memo.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Internal Memo</span></a></li>
                <li><a href="{{ route('administrator.peraturan-perusahaan.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Product Information</span></a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('administrator.payroll.index') }}">
                <i class="mdi mdi-newspaper fa-fw"></i> <span class="hide-menu">Payroll</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">
                <i class="mdi mdi-database fa-fw"></i> <span class="hide-menu">Asset Management<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('administrator.asset.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Asset</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.asset-type.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Asset Type</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.asset-tracking.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Asset Tracking</span></a>
                </li>
            </ul>
        </li>
        @if(get_setting('struktur_organisasi') == 3)
        <li>
            <a href="javascript:void(0)">
                <i class="mdi mdi-database fa-fw"></i> <span class="hide-menu">Setting Approval<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('administrator.setting-approvalLeave.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Leave/Permit Approval</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.setting-approvalPaymentRequest.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Payment Request Approval</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.setting-approvalOvertime.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Overtime Approval</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.setting-approvalTraining.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Training Approval</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.setting-approvalMedical.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Medical Approval</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.setting-approvalExit.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Exit Interview</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.setting-approvalClearance.index') }}"><i class="mdi mdi-database fa-fw"></i><span class="hide-menu">Exit Clearance</span></a>
                </li>
            </ul>
        </li>
        @endif

       <!--  <li>
            <a href="{{ route('attendance.index') }}"><i class="mdi mdi-clock fa-fw"></i> <span class="hide-menu">Attendance</span></a>
        </li> -->

    </ul>
@else
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        <li> <a href="{{ route('karyawan.dashboard') }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> Dashboard </a></li>
        <li class="devider"></li>
        <li class="mega-nav">
            <a href="javascript:void(0)" class="waves-effect">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Management Form<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                    @if(get_setting('struktur_organisasi') == 3)
                     <li>
                        <a href="{{ route('karyawan.leave.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Leave / Permit</span></a>
                    </li>
                    <li>
                        <a href="{{ route('karyawan.payment-request-custom.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Payment Request</span></a>
                    </li>
                    <li>
                    <a href="{{ route('karyawan.overtime-custom.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Overtime Sheet </span></a>
                    </li>
                    <li>
                    <a href="{{ route('karyawan.training-custom.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Training & Business Trip</span></a>
                    </li>
                    <li>
                    <a href="{{ route('karyawan.medical-custom.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Medical Reimbursement</span></a>
                    </li>
                    <li>
                    <a href="{{ route('karyawan.exit-custom.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Exit Interview & Clearance</span></a>
                    </li>
                    @else
                     <li>
                        <a href="{{ route('karyawan.cuti.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Leave / Permit</span></a>
                    </li>
                    <li>
                        <a href="{{ route('karyawan.payment-request.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Payment Request</span></a>
                    </li>
                    <li>
                    <a href="{{ route('karyawan.overtime.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Overtime Sheet </span></a>
                    </li>
                    <li>
                        <a href="{{ route('karyawan.exit-interview.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Exit Interview & Clearance</span></a>
                    </li>
                     <li>
                        <a href="{{ route('karyawan.training.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Training & Business Trip</span></a>
                    </li>
                    <li>
                        <a href="{{ route('karyawan.medical.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Medical Reimbursement</span></a>
                    </li>
                    @endif
            </ul>
        </li>
        <li class="mega-nav">
            <a href="{{ route('karyawan.request-pay-slip.index') }}" class="waves-effect">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Request Pay Slip</span>
            </a>
        </li>
    @if(get_setting('struktur_organisasi') == 3)
        @php($leave_menu = count_leave_approval())
        @php($payment_menu = count_payment_request_approval())
        @php($overtime_menu = count_overtime_approval())
        @php($training_menu = count_training_approval())
        @php($medical_menu = count_medical_approval())
        @php($exit_menu = count_exit_approval())
        @php($clearance_menu = count_clearance_approval())
        @if($leave_menu['all'] > 0 || $payment_menu['all'] > 0 || $overtime_menu['all'] > 0 || $training_menu['all'] > 0 || $medical_menu['all'] > 0 || $exit_menu['all'] > 0 || $clearance_menu['all'] > 0)
        <li style="position: relative;">
                <a href="javascript:void(0)" class="waves-effect">
                    <i class="mdi mdi-account-check fa-fw"></i> <span class="hide-menu">Management Approval<span class="fa arrow"></span></span>
                </a>
                @if($leave_menu['waiting'] > 0 || $payment_menu['waiting'] > 0 || $overtime_menu['waiting'] > 0 || $training_menu['waiting'] > 0 || $medical_menu['waiting'] > 0 || $exit_menu['waiting'] > 0 || $clearance_menu['waiting'] > 0)    
                    <div class="notify" style="position: absolute;top: 61px;right: 10px;"> <span class="heartbit"></span> <span class="point"></span> </div>
                @endif

            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('karyawan.approval.leave-custom.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Leave/Permit</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $leave_menu['waiting'] }}</label>
                    </a>
                </li>
                <li>
                    <a href="{{ route('karyawan.approval.payment-request-custom.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Payment Request</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $payment_menu['waiting'] }}</label>
                    </a>
                </li>
                <li>
                    <a href="{{ route('karyawan.approval.overtime-custom.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Overtime Sheet</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $overtime_menu['waiting'] }}</label>
                    </a>
                </li>
                <li>
                    <a href="{{ route('karyawan.approval.training-custom.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Business Trip / Training</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $training_menu['waiting'] }}</label>
                    </a>
                </li>
                <li>
                    <a href="{{ route('karyawan.approval.medical-custom.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Medical Reimbursement</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $medical_menu['waiting'] }}</label>
                    </a>
                </li>
                <li>
                    <a href="{{ route('karyawan.approval.exit-custom.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Exit Interview</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $exit_menu['waiting'] }}</label>
                    </a>
                </li>
                <li>
                    <a href="{{ route('karyawan.approval.clearance-custom.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Exit Clearance</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ $clearance_menu['waiting'] }}</label>
                    </a>
                </li>
                
            </ul>
        </li>
        @endif
    @else
            <!--- cek cuti sebagai DIREKTUR --->
            @if(empore_is_direktur(Auth::user()->id))
            <li style="position: relative;">
                    <a href="javascript:void(0)" class="waves-effect">
                        <i class="mdi mdi-account-check fa-fw"></i> <span class="hide-menu">Management Approval As Direktur<span class="fa arrow"></span></span>
                    </a>
                    @if(cek_cuti_direktur('null') > 0 ||  cek_training_direktur('null') > 0 || approval_count_payment_request('null') || approval_count_medical('null', 'direktur') > 0 || approval_count_overtime('null', 'direktur') || approval_count_exit('null', 'direktur'))    
                        <div class="notify" style="position: absolute;top: 61px;right: 10px;"> <span class="heartbit"></span> <span class="point"></span> </div>
                    @endif

                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('karyawan.approval.cuti.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Cuti / Ijin</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_cuti_direktur('null') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.training.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Training & Perjanalan Dinas</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_training_direktur('null') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.payment_request.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Payment Request</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ approval_count_payment_request('null', 'direktur') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.medical.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Medical Reimbursement</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ approval_count_medical('null', 'direktur') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.overtime.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Overtime Sheet</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ approval_count_overtime('null', 'direktur') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.exit.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Exit Interview</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ approval_count_exit('null', 'direktur') }}</label>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(cek_cuti_atasan('all') > 0 || cek_training_atasan('all') > 0 || approval_count_payment_request('all', 'atasan') > 0 || approval_count_medical('all', 'atasan') > 0 || approval_count_overtime('all', 'atasan') || approval_count_exit('all', 'atasan'))
            
            <li style="position: relative;">
                    <a href="javascript:void(0)" class="waves-effect">
                        <i class="mdi mdi-account-check fa-fw"></i> <span class="hide-menu">Management Approval As Manager<span class="fa arrow"></span></span>
                    </a>
                    @if(cek_cuti_atasan('null') > 0 || cek_training_atasan('null') > 0 || approval_count_payment_request('null', 'atasan') > 0 || approval_count_medical('null', 'atasan') > 0 || approval_count_overtime('null', 'atasan') || approval_count_exit('null', 'atasan') )    
                        <div class="notify" style="position: absolute;top: 61px;right: 10px;"> <span class="heartbit"></span> <span class="point"></span> </div>
                    @endif
                    
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('karyawan.approval.cuti-atasan.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Cuti / Ijin</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_cuti_atasan('null') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.training-atasan.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Training & Perjanalan Dinas</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_training_atasan('null') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.payment-request-atasan.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Payment Request</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ approval_count_payment_request('null', 'atasan') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.medical-atasan.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Medical Reimbursement</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ approval_count_medical('null', 'atasan') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.overtime-atasan.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Overtime Sheet</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ approval_count_overtime('null', 'atasan') }}</label>
                        </a>
                    </li>
                    <li style="position: relative;">
                        <a href="{{ route('karyawan.approval.exit-atasan.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Exit Interview & Exit Clearance</span>
                            <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ approval_count_exit('null', 'atasan') }}</label>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
    @endif     
    </ul>
@endif