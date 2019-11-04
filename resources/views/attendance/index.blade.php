@extends('layouts.administrator')

@section('title', 'Employee Attendance')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title" style="overflow: inherit;">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Manage Attendance</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <form method="POST" action="{{ route('attendance.index') }}" id="filter-form" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="action" value="view">
                        <input type="hidden" name="reset" value="0">
                        <input type="hidden" name="eksport" value="0">
                        <input type="hidden" name="import" value="0">

                        <div class="pull-right">
                            <div class="btn-group m-l-10 m-r-10 pull-right">
                                <a href="javascript:void(0)" aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">Action
                                    <i class="fa fa-gear"></i>
                                </a>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="reset_filter()"><i class="fa fa-refresh"></i> Reset Filter </a></li>
                                    <li><a href="javascript:void(0)" onclick="eksportAttendance()"><i class="fa fa-download"></i> Exsport </a></li>
                                    <li><a href="javascript:void(0)" data-toggle="modal" data-target="#modal_import"><i class="fa fa-upload"></i> Import </a></li>
                                </ul>
                            </div>
                            <button id="filter_view" class="btn btn-default btn-sm btn-outline"> <i class="fa fa-search-plus"></i></button>
                        </div>
                        <div class="col-md-2 pull-right">
                            <select name="branch" class="form-control form-control-line" id="branch">
                                <option value="" selected>- Branch -</option>
                                @foreach(cabang() as $item)
                                    <option {{ $item->id == \Session::get('branch') ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 pull-right">
                            <input type="text"  name="filter_end" class="form-control datepicker form-control-line" id="filter_end" placeholder="End Date" value="{{ \Session::get('filter_end') }}">
                        </div>
                        <div class="col-md-2 pull-right">
                            <input type="text" name="filter_start" class="form-control datepicker form-control-line" id="filter_start" placeholder="Start Date" value="{{ \Session::get('filter_start') }}" />
                        </div>
                        <div class="col-md-3 pull-right">
                            <input type="text" name="name" id="nama_nik" class="form-control form-control-line autocomplete-karyawan" placeholder="Nik / Name" value="{{ \Session::get('name')}}">
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 p-l-0 p-r-0">
                    <div class="white-box">
                        <table class="data_table_no_pagging table table-background">
                            <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">NIK</th>
                                <th rowspan="2">Name</th>
                                <th rowspan="2">Date</th>
                                <th rowspan="2">Day</th>
                                <th colspan="2" style="text-align: center;">Clock</th>
                                <th rowspan="2">Late CLOCK In</th>
                                <th rowspan="2">Early CLOCK Out</th>
                                <th rowspan="2">Duration</th>
                            </tr>
                            <tr>
                                <th>In</th>
                                <th>Out</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $key => $item)
                                @if(!isset($item->user->nik) || empty($item->date))
                                    <?php continue; ?>
                                @endif
                                <tr>
                                    <td>{{ $key+1 }} </td>
                                    <td>{{ $item->user->nik }} </td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->timetable }}</td>
                                    <td>
                                        @if(!empty($item->long) || !empty($item->lat) || !empty($item->pic))
                                            <a href="javascript:void(0)" data-title="Clock In <?=date('d F Y', strtotime($item->date))?> <?=$item->clock_in?>" data-long="<?=$item->long?>" data-lat="<?=$item->lat?>" data-pic="<?=asset('upload/attendance/'.$item->pic)?>" data-time="<?=$item->clock_in?>" data-long-office="<?=$item->long_office?>" data-lat-office="<?=$item->lat_office?>" data-radius-office="<?=$item->radius_office?>" onclick="detail_attendance(this)" title="Mobil Attendance"> {{ $item->clock_in }}</a>
                                            <i title="Mobile Attendance" class="fa fa-mobile pull-right" style="font-size: 20px;"></i>
                                        @else
                                            {{ $item->clock_in }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($item->long_out) || !empty($item->lat_out) || !empty($item->pic_out))
                                            <a href="javascript:void(0)" data-title="Clock Out  <?=date('d F Y', strtotime($item->date))?> <?=$item->clock_out?>" data-long="<?=$item->long_out?>" data-lat="<?=$item->lat_out?>" data-pic="<?=asset('upload/attendance/'.$item->pic_out)?>" data-time="<?=$item->clock_out?>" data-long-office="<?=$item->long_office?>" data-lat-office="<?=$item->lat_office?>" data-radius-office="<?=$item->radius_office?>" onclick="detail_attendance(this)" title="Mobil Attendance"> {{ $item->clock_out }}</a>
                                            <i title="Mobile Attendance" class="fa fa-mobile pull-right" style="font-size: 20px;"></i>
                                        @else
                                            {{ $item->clock_out }}
                                        @endif
                                    </td>
                                    <td>{{ $item->late }}</td>
                                    <td>{{ $item->early }}</td>
                                    <td>{{ $item->work_time }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-m-6 pull-left text-left">Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries</div>
                        <div class="col-md-6 pull-right text-right">{{ $data->appends($_GET)->render() }}</div><div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        @include('layouts.footer')
    </div>
    <div id="modal_import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" class="form-horizontal" action="{{ route('attendance.import') }}" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Import Attendance</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-12">File </label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" required name="file">
                            </div>
                            <div class="col-md-12">
                                <a href="{{ asset('storage/sample/Sample-attendance.xlsx') }}"><i class="fa fa-download"></i> Download Sample Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info waves-effect btn-sm">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal_detail_attendance" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Attendance</h4> </div>
                <div class="modal-body">
                    <form class="form-horizontal frm-modal-inventaris-lainnya">
                        <div class="form-group">
                            <div class="col-md-12 input_pic">
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="map" style="height: 254px; width: 100%;"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6">Latitude </label>
                            <label class="col-md-6">Longitude </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-latitude" readonly="true">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-longitude" readonly="true">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_import_attendance" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Import Data</h4> </div>
                <form method="POST" id="form-upload" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('attendance.import') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">File (xls)</label>
                            <div class="col-md-9">
                                <input type="file" name="file" class="form-control" />
                            </div>
                        </div>
                        <a href="{{ asset('storage/sample/Sample-Attendance.xlsx') }}"><i class="fa fa-download"></i> Download Sample Excel</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <label class="btn btn-info btn-sm" id="btn_import">Import</label>
                    </div>
                </form>
                <div style="text-align: center;display: none;" class="div-proses-upload">
                    <h3>Uploading !</h3>
                    <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@section('js')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTctq_RFrwKOd84ZbvJYvU3MEcrLmPNJ8"
            async defer>
            </script>

    <script type="text/javascript">
        $("#filter_view").click(function(){
            if($('#filter_start').val() > $('#filter_end').val()){
                alert('Tanggal Tidak Boleh Backdate!');
            }else{
                $("#filter-form input[name='action']").val('view');
                $("#filter-form").submit();
            }
        });
        
        function reset_filter()
        {
            $("#filter-form input.form-control, #filter-form select").val("");
            $("input[name='reset']").val(1);
            $("#filter-form").submit();
        }

        function importAttendance(){
            $('#modal_import_attendance').modal('show');
            $('.div-proses-upload').hide();
            $("#form-upload").show();
        }

        $("#btn_import").click(function(){

            $("#form-upload").submit();
            $("#form-upload").hide();
            $('.div-proses-upload').show();

        });

        function eksportAttendance(){
            $("input[name='eksport']").val(1);
            $("#filter-form").submit();

            $("input[name='eksport']").val(0);
        }
    </script>
    <script>
        function detail_attendance(el)
        {
            var img = '<img src="'+ $(el).data('pic') +'" style="width:100%;" />';
            $('#modal_detail_attendance .modal-title').html($(el).data('title'));
            $('.input_pic').html(img);
            $(".input-latitude").val($(el).data('lat'));
            $(".input-longitude").val($(el).data('long'));
            $("#modal_detail_attendance").modal("show");

            // The location of Uluru
            var userLoc = {lat: $(el).data('lat'), lng: $(el).data('long')};
            var icon = "{{asset('images/icon/icon_man.png')}}";
            // The map, centered at Uluru
            setTimeout(function(){
                var map = new google.maps.Map(
                    document.getElementById('map'));
                // The marker, positioned at Uluru
                var userMarker = new google.maps.Marker({position: userLoc, map: map,icon: icon});
                var bounds = new google.maps.LatLngBounds();
                bounds.extend(userMarker.getPosition());
                var padding = 0;
                if($(el).data('lat-office')!="" && $(el).data('long-office')!="") {
                    var officeLoc = {lat: $(el).data('lat-office'), lng: $(el).data('long-office')};
                    var radius = $(el).data('radius-office');
                    var distance = getDistance(userLoc.lat,userLoc.lng,officeLoc.lat,officeLoc.lng);
                    var color;
                    if(distance > radius){
                        color = "#FF0000";
                        padding = 0;
                    }
                    else{
                        color = "#7cb342";
                        padding = 100;
                    }

                    var cityCircle = new google.maps.Circle({
                        strokeColor: color,
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: color,
                        fillOpacity: 0.35,
                        map: map,
                        center: officeLoc,
                        radius: radius
                    });
                    console.log("City Circle colored : "+color);

                    bounds.extend(officeLoc);
                }
                map.fitBounds(bounds,padding);
            }, 1000);
        }
        function getDistance(lat1,lon1,lat2,lon2) {

            var R = 6371000; // Radius of the earth in m
            var dLat = deg2rad(lat2-lat1);  // deg2rad below
            var dLon = deg2rad(lon2-lon1);
            var a =
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            var d = R * c; // Distance in km
            return d;
        }

        function deg2rad(deg) {
            return deg * (Math.PI/180)
        }

        $(".autocomplete-karyawan").autocomplete({
            minLength:0,
            limit: 25,
            source: function( request, response ) {
                $.ajax({
                    url: "{{ route('ajax.get-karyawan') }}",
                    method : 'POST',
                    data: {
                        'name': request.term,'_token' : $("meta[name='csrf-token']").attr('content')
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function( event, ui ) {
                $( "input[name='id']" ).val(ui.item.id);
            }
        }).on('focus', function () {
            $(this).autocomplete("search", "");
        });


    </script>
@endsection
@endsection
