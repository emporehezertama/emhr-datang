@if(Auth::user()->access_id == 1)
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        <li> <a href="{{ route('administrator.dashboard') }}"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> Dashboard </a></li>
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
                <li>
                    <a href="{{ route('administrator.cuti.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.leave_or_permit')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('administrator.payment-request.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.payment_request')</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.medical.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.medical_reimbursement')</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.overtime.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">@lang('menu.overtime_sheet') </span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.exit-interview.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Exit Interview & Clearance </span>
                    </a>
                </li>
                 <li>
                    <a href="{{ route('administrator.training.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Training & Business Trip</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('administrator.request-pay-slip.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Request Pay Slip Gross</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.request-pay-slipnet.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Request Pay Slip Net</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.request-pay-slipgross.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Request Pay Slip Net/Gross</span></a>
                </li>
            </ul>
        </li>

        <li>
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
                <li>
                    <a href="{{ route('administrator.news.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">News</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.internal-memo.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Internal Memo</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.peraturan-perusahaan.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Product Information</span></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">
                <i class="mdi mdi-newspaper fa-fw"></i> <span class="hide-menu">Payroll<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('administrator.payroll.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Payroll Gross</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.payrollnet.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Payroll Net</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.payrollgross.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Payroll Net/Gross</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.payroll-setting.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Setting Payroll</span></a>
                </li>
            </ul>
        </li>

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
            </ul>
        </li>
        <li class="mega-nav">
            <a href="javascript:void(0)" class="waves-effect">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Request Pay Slip<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('karyawan.request-pay-slip.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Pay Slip Gross</span></a>
                </li>
                <li>
                    <a href="{{ route('karyawan.request-pay-slipnet.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Pay Slip Net</span></a>
                </li>
                <li>
                    <a href="{{ route('karyawan.request-pay-slipgross.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Pay Slip Net/Gross</span></a>
                </li>
            </ul>
        </li>

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

    </ul>
@endif