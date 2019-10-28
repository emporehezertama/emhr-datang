@if(Auth::user()->access_id == 1)
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        <li><a href="{{ route('administrator.dashboard') }}"><i class="mdi mdi-chart-bar fa-fw" data-icon="v"></i> Dashboard </a></li>
        <li class="devider"></li>
        <li>
            <a href="{{ route('administrator.karyawan.index') }}">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">@lang('menu.employee')<span class="fa arrow"></span></span>
            </a>
        </li>
        <li>
            <a href="{{ route('administrator.organization-structure-custom.index') }}" class="waves-effect">
            <i class="mdi mdi-sitemap fa-fw"></i> <span class="hide-menu">@lang('menu.organization_structure')<span class="fa arrow"></span></span>
            </a>
        </li>
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
        <li>
            <a href="{{ route('attendance.index') }}"><i class="mdi mdi-fingerprint fa-fw"></i><span class="hide-menu">Attendance</span></a>
        </li>
        <li class="mega-nav">
            <a href="{{ route('administrator.setting.index') }}" class="waves-effect">
                <i class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">@lang('menu.setting')</span>
            </a>
        </li>
        <!--As Karyawan-->
        @if(Auth::user()->project_id != 1)
            <li class="devider"></li>


        @php($leave_menu = count_leave_approval())
        @php($payment_menu = count_payment_request_approval())
        @php($overtime_menu = count_overtime_approval())
        @php($training_menu = count_training_approval())
        @php($medical_menu = count_medical_approval())
        @php($exit_menu = count_exit_approval())
        @php($clearance_menu = count_clearance_approval())
        @if($leave_menu['all'] > 0 || $payment_menu['all'] > 0 || $overtime_menu['all'] > 0 || $training_menu['all'] > 0 || $medical_menu['all'] > 0 || $exit_menu['all'] > 0 || $clearance_menu['all'] > 0)

            
        @endif
        @endif
    </ul>
@else
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        <li> <a href="{{ route('karyawan.dashboard') }}" class="waves-effect"><i class="mdi mdi-chart-bar fa-fw" data-icon="v"></i> Dashboard </a></li>
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
                    @if(checkModule(13))
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

           
        @endif
           
    </ul>
@endif