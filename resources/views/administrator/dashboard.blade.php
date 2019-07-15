@extends('layouts.administrator')

@section('title', 'Dashboard')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row m-t-10">
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="row white-box">
                        <div class="form-group">
                            <label class="col-md-12">Filter Date</label>
                            <div class="col-md-3">
                                <input type="text" id="filter_start" name="filter_start" class="form-control datepicker" id="from" placeholder="Start Date" />
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="filter_end"  name="filter_end" class="form-control datepicker" id="to" placeholder="End Date">
                            </div>
                            <div class="col-md-2">
                                <div id="filter-dashboard" class="btn btn-xs btn-danger"><i class="fa fa-search" style="font-size: 20px"></i> Submit</div>
                            </div>
                        </div> 
                    </div>
                </div>
                
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
            
            <div class="col-sm-6">
                <div class="white-box" style="margin-bottom:10px;">
                    <div class="box-title pull-left" style="text-transform: inherit;"><i class="mdi mdi-chart-areaspline m-r-5"></i> Monthly joinees and resignees</div>
                    <!--button id="filter-monthly-join-resign" class="btn btn-xs btn-danger pull-right datepicker"><i class="mdi mdi-filter" style="font-size: 12px"></i> </button-->
                    <div class="clearfix"></div>
                    <div id="chart-1" style="height: 220px"></div>
                    <p class="text-center">
                        <label><i class="fa fa-circle" style="color:#d70206;"></i></label> Monthly resignees
                        <label><i class="fa fa-circle" style="color:#f05b4f;"></i></label> Monthly joinees
                    </p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="white-box" style="margin-bottom:10px;">
                    <div class="box-title pull-left" style="text-transform: inherit;"><i class="mdi mdi-chart-line m-r-5"></i> Attrition Rate</div>
                    <!--button id="filter-attrition" class="btn btn-xs btn-info pull-right datepicker"><i class="mdi mdi-filter" style="font-size: 12px"></i></button-->
                    <div class="clearfix"></div>
                    <div id="chart-2" style="height: 220px"></div>
                    <p class="text-center"><label class=" m-l-10"><i class="fa fa-circle" style="color:#d70206;"></i></label> Attrition Rate</p>
                </div>
            </div>         
            <div class="col-sm-6">
                <div id="calendar2"></div>
            </div>
            <div class="col-sm-3">
                <div class="white-box" style="margin-bottom:10px;">
                    <div class="box-title" style="text-transform: inherit;">Department wise headcount distribution</div>
                    <div id="pie-chart-1" style="height:218px; padding-top: 20px; width:"></div>
                    <div id="color-division"></div>
                   
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
                                <h5 class="text-muted m-t-0">Exit This Month </h5>
                            </div>
                            <div class="col-sm-6">
                                <div class="pull-right">
                                    <h1 style="font-size: 80px;color: #74bfd0;"><i class="fa fa-warning"></i></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2 id="user-active" class="m-b-0 font-medium"></h2>
                                <h5 class="text-muted m-t-0">User Active</h5>
                            </div>
                            <div class="col-sm-6">
                                <div class="pull-right">
                                    <h1 style="font-size: 80px;color: #74bfd0;"><i class="fa fa-user"></i></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>

<!-- BEGIN MODAL -->
<div class="modal fade none-border" id="add-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Add Event</strong></h4>
            </div>
            <div class="modal-body" id="add-event-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success save-event waves-effect waves-light">Submit</button>
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
    


    $(document).ready(function () {
        var tahun = "<?php echo date('Y'); ?>";
        var filter_start = "<?php echo date('Y-')."01-01"; ?>";
        var filter_end = "<?php echo date('Y-m-d'); ?>";

        dataDashboard(filter_start, filter_end);
        getUserActive();
        calendarDashboard();
        headcountDepartment();
    });


    $('#filter-dashboard').click(function(){
        var filter_start = $('#filter_start').val();
        var filter_end = $('#filter_end').val();
        if(filter_start != '' && filter_end != ''){
            if(filter_end >= filter_start ){
                dataDashboard(filter_start, filter_end);
            }else{
                alert("Tanggal Tidak Bisa Backdate");
            }
        }else{
            alert("Silakan Masukkan Tanggal Terlebih Dahulu");
        }
    });


    function dataDashboard(filter_start, filter_end){
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-data-dashboard') }}',
            data: {'filter_start' : filter_start, 'filter_end' : filter_end, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (msg) {
                var hasil = JSON.parse(msg);
                var bulan_label = hasil['bulan_val'];
                var employee_resign = hasil['employee_resign'];
                var employee_join = hasil['employee_join'];
                var attrition = hasil['attrition'];

                filterMonthlyJoinResign(bulan_label, employee_resign, employee_join);
                filterAttrition(bulan_label, attrition);

            }
        });
    }

    function filterMonthlyJoinResign(bulan_label, employee_resign, employee_join){
        new Chartist.Line('#chart-1', {
            high: 100,
            labels: bulan_label,
            series: [
                employee_resign,
                employee_join
            ],
            showlabel: true
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
                    return (value / 1);
                }
            },
            showArea: true
        });
    }
    
    
  
    function filterAttrition(bulan_label, attrition){
        new Chartist.Line('#chart-2', {
            high: 100,
            labels: bulan_label,
            series: [
                attrition
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
                    return (value / 1) + '%';
                }
            },
            showArea: true
        });
    }

    function calendarDashboard(){
        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.get-libur-nasional') }}',
            dataType: 'json',
            success: function (msg) {
                var result = JSON.parse(msg);
                var startdate = result['tanggal'];
                var enddate = result['tanggal'];
                var title = result['keterangan'];
                
                var events = [];
                for(var i = 0; i < startdate.length; i++) 
                {
                    events.push( {
                            title: title[i], 
                            start: startdate[i], 
                            end: enddate[i]
                    })
                }

                $('#calendar2').fullCalendar({
                    dayClick: function(date, allDay, jsEvent, view) {
                    /*  if (allDay) {
                            $('#calendar2')
                                .fullCalendar('changeView', 'basicDay')
                                .fullCalendar('gotoDate',
                                    date.getFullYear(), date.getMonth(), date.getDate());
                        }   */

                        var check = $(this).find('i.checkbox');
                        check.toggleClass('marked');
                    //  $(this).css('background-color', '#4f92ff');
                        $("#add-event").modal("show");
                        $("#add-event-body").html(date.format('YYYY-MM-D'));
                    },

                    dayRender: function(date, cell) {
                        var check = document.createElement('i');
                        check.classList.add('checkbox');
                        cell.append(check);
                        $('.fc-sat, .fc-sun').css('background-color', '#e6eaf2');
                    },
                    events: events,
                    height: 410
                });
            }
        });
    }

    function getUserActive(){
        $.ajax({
            type: 'GET',
            url: '{{ route('ajax.get-user-active') }}',
            dataType: 'json',
            success: function (msg) {
                $('#user-active').html(msg);
                console.log(msg);
            }
        });
        var cekUser = setTimeout("getUserActive()", 5000);
    }

    function  headcountDepartment(){
        var jumlahperdivisi = {!!json_encode($jumlahperdivisi)!!};
        var namedivision = {!!json_encode($namedivision)!!};
        data = [];
        for(var i=0; i<namedivision.length; i++){
            data.push( {
                label: namedivision[i],
                value: jumlahperdivisi[i]
            })
            var colors =  ['#ff7676', '#2cabe3', '#53e69d', '#7bcef3', '#ff63f7', '#fbfcb0', '#ffca60', '#60fff1', '#847bfc', '#ff9696', '#2e7a3c', '#87197c'];
            var div1 = '<div class="col-md-6"><p><button class="btn btn-xs" style="background: ' + colors[i] +' "> &nbsp;&nbsp;</button> ' + namedivision[i] +'</p>';
            var div2 = '<p><button class="btn btn-xs" style="background: ' + colors[i] +' "> &nbsp;&nbsp;</button> ' + namedivision[i] +' </p></div>';
            var number = i % 2;
            if(number == '0'){
                $('#color-division').append(div1);
            }else if(number == Math.round(number)){
                $('#color-division').append(div2);
            }else{
                console.log("error");
            }
        }
        
        Morris.Donut({
            element: 'pie-chart-1',
            data: data,
            resize: true,
            colors: ['#ff7676', '#2cabe3', '#53e69d', '#7bcef3', '#ff63f7', '#fbfcb0', '#ffca60', '#60fff1', '#847bfc', '#ff9696', '#2e7a3c', '#87197c']
        });
    }



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
