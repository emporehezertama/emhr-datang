@extends('layouts.administrator')

@section('title', 'Employee Attendance')

@section('content')        
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Attendance</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <form method="POST" action="{{ route('attendance.index') }}" id="filter-form" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="action" value="view">
                    <input type="hidden" name="reset" value="0">
                    <input type="hidden" name="import" value="0">
                    <div class="pull-right">
                        <button id="filter_view" class="btn btn-default btn-sm btn-outline"> <i class="fa fa-search-plus"></i></button>
                        <button aria-expanded="false" data-toggle="dropdown" class="btn btn-sm btn-info dropdown-toggle waves-effect waves-light " type="button" href="javascript:void(0)" onclick="reset_filter()">Reset Filter 
                            <i class="fa fa-refresh"></i>
                        </button>
                        <!--div aria-expanded="false" data-toggle="dropdown" class="btn btn-sm btn-info dropdown-toggle waves-effect waves-light " onclick="importAttendance()">Import Data -->
                        <button aria-expanded="false" data-toggle="dropdown" class="btn btn-sm btn-info dropdown-toggle waves-effect waves-light "  type="button" href="javascript:void(0)"  onclick="importAttendance()">Eksport Data 
                            <i class="fa fa-download"></i>
                        </button>
                    </div>
                    <div class="col-md-3 pull-right">
                        <input type="text" name="nama_nik" id="nama_nik" class="form-control form-control-line autocomplete-karyawan" placeholder="Nik / Name" value="{{request()->nama_nik}}">
                        <input type="hidden" name="id" id="id" class="form-control" value="{{request()->id}}" />
                    </div>
                    <div class="col-md-2 pull-right">
                        <select name="branch" class="form-control" id="branch">
                            <option value="" selected>- PILIH CABANG -</option>
                            @foreach(cabang() as $item)
                                <option {{ $item->id == request()->branch ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 pull-right">
                        <input type="text"  name="filter_end" class="form-control datepicker" id="filter_end" placeholder="End Date" value="{{ request()->filter_end }}">
                    </div> 
                    <div class="col-md-2 pull-right">
                        <input type="text" name="filter_start" class="form-control datepicker" id="filter_start" placeholder="Start Date" value="{{ request()->filter_start }}" />
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
                                <th rowspan="2" style="width: 80px;">No</th>
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
                                <tr>
                                    <td>{{ $key+1 }}</td>    
                                    <td>{{ $item['nik'] }} </td>    
                                    <td>{{ $item['name'] }}</td>    
                                    <td>{{ $item['date'] }}</td>    
                                    <td>{{ $item['timetable'] }}</td>    
                                    <td>
                                        @if(!empty($item['long']) || !empty($item['lat']) || !empty($item['pic']))
                                            <a href="javascript:void(0)" data-title="Clock In <?=date('d F Y', strtotime($item['date']))?> <?=$item['clock_in']?>" data-long="<?=$item['long']?>" data-lat="<?=$item['lat']?>" data-pic="<?=asset('upload/attendance/'.$item['pic'])?>" data-time="<?=$item['clock_in']?>" onclick="detail_attendance(this)" title="Mobil Attendance"> {{ $item['clock_in'] }}</a> 
                                            <i title="Mobile Attendance" class="fa fa-mobile pull-right" style="font-size: 20px;"></i>
                                        @else
                                            {{ $item['clock_in'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($item['long_out']) || !empty($item['lat_out']) || !empty($item['pic_out']))
                                            <a href="javascript:void(0)" data-title="Clock Out  <?=date('d F Y', strtotime($item['date']))?> <?=$item['clock_out']?>" data-long="<?=$item['long_out']?>" data-lat="<?=$item['lat_out']?>" data-pic="<?=asset('upload/attendance/'.$item['pic_out'])?>" data-time="<?=$item['clock_out']?>" onclick="detail_attendance(this)" title="Mobil Attendance"> {{ $item['clock_out'] }}</a> 
                                            <i title="Mobile Attendance" class="fa fa-mobile pull-right" style="font-size: 20px;"></i>
                                        @else
                                             {{ $item['clock_out'] }}
                                        @endif
                                    </td>
                                    <td>{{ $item['late'] }}</td>   
                                    <td>{{ $item['early'] }}</td>    
                                    <td>{{ $item['work_time'] }}</td>    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--div class="col-m-6 pull-left text-left">Showing  $data->firstItem()  to  $data->lastItem()  of  {{count($data)}}  entries</div>
                    <div class="col-md-6 pull-right text-right"> count($data)->appends($_GET)->render() </div><div class="clearfix"></div-->
                </div>
            </div> 
        </div>
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
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
                            <div id="map"></div>
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
@section('js')
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
        $("#filter-form input.form-control, #filter-form select").val("");
        $("input[name='import']").val(1);
        $("#filter-form").submit();

        $("input[name='import']").val(0);

    /*    var start = $('#filter_start').val();
        var end = $('#filter_end').val();
        var id = $('#id').val();
        var branch = $('#branch').val();
        
        $.ajax({
            type: 'POST',
            url: '{{ route('import-attendance') }}',
            data: {'start' : start, 'end' : end, 'id' : id, 'branch' : branch, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success : function(data){
                alert('ok');
            }
        }); */
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
    var uluru = {lat: $(el).data('lat'), lng: $(el).data('long')};
    // The map, centered at Uluru
    setTimeout(function(){
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 16, center: uluru});
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: uluru, map: map});
    }, 1000);
}

$(".autocomplete-karyawan" ).autocomplete({
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
