@extends('layouts.administrator')

@section('title', 'Dashboard')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row m-t-10">
            <div class="col-sm-12">
                <div class="white-box m-b-2">
                    <div class="box-title pull-left" style="text-transform: inherit;"><i class="fa fa-user m-r-5"></i> Employees Status</div>
                    <button class="btn btn-xs btn-info pull-right datepicker"><i class="fa fa-table m-r-5"></i> {{ date('dS M Y') }} </button>
                    <div class="clearfix"></div>

                    <div class="row row-in">
                        <div class="col-lg-2 col-sm-6 row-in-br">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger" style="font-size: 18px !important;padding-top: 18px;">
                                    {{ employee('active') }}
                                    </span>
                                </li>
                                <li class="col-middle">
                                    <h4>Present</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-sm-6 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-info" style="font-size: 18px !important;padding-top: 18px;">
                                    {{ employee('on-leave') }}
                                    </span>
                                </li>
                                <li class="col-middle">
                                    <h4>On Leave</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-sm-6 row-in-br">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-success" style="font-size: 18px !important;padding-top: 18px;">
                                        {{ employee('permanent') }}
                                    </span>
                                </li>
                                <li class="col-middle">
                                    <h4>Permanent</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-sm-6  b-0">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-warning" style="font-size: 18px !important;padding-top: 18px;">
                                        {{ employee('contract') }}
                                    </span>
                                </li>
                                <li class="col-middle">
                                    <h4>Contract</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-sm-6  b-0">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md" style="font-size: 18px !important;padding-top: 18px;background: grey;">
                                        {{ employee('on-tour') }}
                                    </span>
                                </li>
                                <li class="col-middle">
                                    <h4>On Tour</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-sm-6  b-0">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-warning" style="font-size: 18px !important;padding-top: 18px;background: purple;">
                                        {{ employee('late-comers') }}
                                    </span>
                                </li>
                                <li class="col-middle">
                                    <h4>Late Comers</h4>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6"><div id="calendar2"></div></div>
            <div class="col-sm-3">
                <div class="white-box" style="margin-bottom:10px;">
                    <div class="box-title" style="text-transform: inherit;">Department wise headcount distribution</div>
                    <div id="pie-chart-1" style="height:218px; padding-top: 20px; width:"></div>
                    <div class="col-md-6">
                        <p><button class="btn btn-xs" style="background: #ff7676"> &nbsp;&nbsp;</button> Accounting</p>
                        <p><button class="btn btn-xs" style="background: #2cabe3"> &nbsp;&nbsp;</button> Admin</p>
                    </div>
                    <div class="col-md-6">
                        <p><button class="btn btn-xs" style="background: #53e69d"> &nbsp;&nbsp;</button> Analysis</p>
                        <p><button class="btn btn-xs btn-warning"> &nbsp;&nbsp;</button> Business Proccess</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="col-md-6 col-sm-6 col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2 class="m-b-0 font-medium">{{ total_karyawan() }}</h2>
                                <h5 class="text-muted m-t-0">Total Headcount</h5>
                            </div>
                            <div class="col-sm-6">
                                <div class="pull-right">
                                    <h1 style="font-size: 80px;color: #74bfd0;"><i class="fa fa-user"></i></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2 class="m-b-0 font-medium">{{ employee_exit_this_month() }}</h2>
                                <h5 class="text-muted m-t-0">Exit This Month</h5>
                            </div>
                            <div class="col-sm-6">
                                <div class="pull-right">
                                    <h1 style="font-size: 80px;color: #74bfd0;"><i class="fa fa-warning"></i></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="white-box" style="margin-bottom:10px;">
                    <div class="box-title pull-left" style="text-transform: inherit;"><i class="mdi mdi-chart-areaspline m-r-5"></i> Monthly joinees and resignees</div>
                    <button class="btn btn-xs btn-danger pull-right datepicker"><i class="mdi mdi-filter" style="font-size: 12px"></i> </button>
                    <div class="clearfix"></div>
                    <div id="chart-1" style="height: 220px"></div>
                    <p class="text-center">
                        <label class="text-danger"><i class="fa fa-circle"></i></label> Monthly resignees
                        <label class="text-info m-l-10"><i class="fa fa-circle"></i></label> Monthly joinees
                    </p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="white-box" style="margin-bottom:10px;">
                    <div class="box-title pull-left" style="text-transform: inherit;"><i class="mdi mdi-chart-line m-r-5"></i> Attrition Rate</div>
                    <button class="btn btn-xs btn-info pull-right datepicker"><i class="mdi mdi-filter" style="font-size: 12px"></i></button>
                    <div class="clearfix"></div>
                    <div id="chart-2" style="height: 220px"></div>
                    <p class="text-center"><label class="text-info m-l-10"><i class="fa fa-circle"></i></label> Attrition Rate</p>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>

<!-- BEGIN MODAL -->
<div class="modal fade none-border" id="my-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Add Event</strong></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .col-in h3 {
        font-size: 20px;
    }
</style>
<link href="{{ asset('admin-css/plugins/bower_components/css-chart/css-chart.css') }}" rel="stylesheet">
<script src="{{ asset('admin-css/plugins/bower_components/chartist-js/dist/chartist.min.js') }}"></script>
<link href="{{ asset('admin-css/plugins/bower_components/calendar/dist/fullcalendar.css') }}" rel="stylesheet" />
@section('js')
<script src="{{ asset('admin-css/plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('admin-css/plugins/bower_components/calendar/dist/cal-init.js') }} "></script>

<script type="text/javascript">
    $('#calendar2').fullCalendar({
        height: 390
    });

    // Morris donut chart
    Morris.Donut({
        element: 'pie-chart-1',
        data: [{
                label: "",
                value: 15
            }, {
                label: "",
                value: 15,
            }, {
                label: "",
                value: 35,
            }, {
                label: "",
                value: 105
        }],
        resize: true,
        colors: ['#ff7676', '#2cabe3', '#53e69d', '#7bcef3']
    });

    new Chartist.Line('#chart-1', {
        labels: [@for($i=1; $i<=12; $i++) '{{ date('M',  mktime(0, 0, 0, $i, 10)) }}' @if($i !=12),@endif @endfor],
        series: [
                [5, 2, 7, 4, 5, 3, 5, 4, 3, 5, 1, 6],
                [0, 3, 8, 3, 4, 7, 8, 2, 4, 6, 4, 9],
            //[@for($i=1; $i<=12; $i++){{ employee_get_resigness($i) }} @if($i !=12),@endif @endfor],
            //[@for($i=1; $i<=12; $i++){{ employee_get_joinees($i) }}@if($i !=12),@endif @endfor]
        ]
    }, {
        top: 0,
        low: 1,
        showPoint: true,
        height: 210,
        fullWidth: true,
        plugins: [
    Chartist.plugins.tooltip()
  ],
        axisY: {
            labelInterpolationFnc: function (value) {
                return (value / 1) + 'k';
            }
        },
        showArea: true
    });


    //ct-visits
    new Chartist.Line('#chart-2', {
         labels: ['2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015'],
         series: [
    [5, 2, 7, 4, 5, 3, 5, 4]
  ]
     }, {
         top: 0,

         low: 1,
         showPoint: true,

         fullWidth: true,
         plugins: [
    Chartist.plugins.tooltip()
  ],
         axisY: {
             labelInterpolationFnc: function (value) {
                 return (value / 1) + 'k';
             }
         },
         showArea: true
     });


    //  // This is for Morris-chart-2
    // Morris.Area({
    //     element: 'chart-2',
    //     data: [
    //     @for($i=1; $i<=12; $i++) 
    //         { 
    //             period: '{{ date('M',  mktime(0, 0, 0, $i, 10)) }}', 
    //             SiteA: {{ employee_rate($i) }}
    //         }
    //         @if($i !=12),@endif  
    //     @endfor

    //     // {
    //     //         period: '2010',
    //     //         SiteA: 0,

    //     // }, {
    //     //         period: '2011',
    //     //         SiteA: 130,

    //     // }, {
    //     //         period: '2012',
    //     //         SiteA: 80,

    //     // }, {
    //     //         period: '2013',
    //     //         SiteA: 70,

    //     // }, {
    //     //         period: '2014',
    //     //         SiteA: 180,

    //     // }, {
    //     //         period: '2015',
    //     //         SiteA: 105,

    //     // },
    //     //     {
    //     //         period: '2016',
    //     //         SiteA: 250,

    //     // }
        
    //     ],
    //     xkey: 'period',
    //     ykeys: ['SiteA'],
    //     labels: ['Site A'],
    //     pointSize: 0,
    //     fillOpacity: 0.4,
    //     pointStrokeColors: ['#2cabe3'],
    //     behaveLikeLine: true,
    //     gridLineColor: '#e0e0e0',
    //     lineWidth: 0,
    //     smooth: false,
    //     hideHover: 'auto',
    //     lineColors: ['#2cabe3'],
    //     resize: true

    // });
</script>
@endsection
@endsection
