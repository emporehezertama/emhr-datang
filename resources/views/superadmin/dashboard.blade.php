@extends('layouts.superadmin')

@section('title', 'Dashboard')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
         <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Client Area</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="form-group">
                        <label class="col-md-12">List Module</label>
                        @foreach($product as $no => $item)
                            @php($check='')
                            @foreach($data as $key => $items)
                                @if($items->crm_product_id == $item->id)
                                    @php($check='checked')
                                @endif
                            @endforeach
                            <div class="col-md-6">
                                <label><input type="checkbox" {{$check}} disabled="true" style="margin-right: 10px; margin-bottom: 10px" name="project_product_id['+$item->id+']" value="{{$item->id}}"> {{$item->name}}</label>
                            </div>
                        <div class="clearfix"></div>
                        @endforeach
                    </div>
                    @foreach($project as $no => $itemProject)
                    <div class="form-group">
                        <label class="col-md-12">Project Name</label>
                        <div class="col-md-6">
                            <input type="text" name="name" readonly="true" class="form-control" value="{{$itemProject->name}}">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Project Type</label>
                            @php($type='')
                            @if($itemProject->project_type == 1)
                                @php($type = 'License')
                            @elseif($itemProject->project_type == 2)
                                @php($type = 'Trial')
                            @endif
                        <div class="col-md-6">
                            <input type="hidden" name="project_type_id" class="form-control" value="{{$itemProject->project_type}}">
                            <input type="text" name="project_type" readonly="true" class="form-control" value="{{$type}}">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group" id="divLabelDuration" name="divLabelDuration" style="display: none;">
                        <label class="col-md-12">Duration (Day/s)</label>
                        <div class="col-md-6">
                            <input type="text" name="durataion" readonly="true" class="form-control" value="{{$itemProject->durataion}}">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group" id="divLabelExpired" name="divLabelExpired" style="display: none;">
                        <label class="col-md-12">Expired Date</label>
                        <div class="col-md-6">
                            <input type="text" name="expired_date" readonly="true" class="form-control" value="{{$itemProject->expired_date}}">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group" id="divLabelLicense" name="divLabelLicense" style="display: none;">
                        <label class="col-md-12">License Number</label>
                        <div class="col-md-6">
                            <input type="text" name="license_number" readonly="true" class="form-control" value="{{$itemProject->license_number}}">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        
    </div>
    @include('layouts.footer')
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
    var el = $("input[name='project_type_id']").val();
    if(el == 1)
    {
      document.getElementById('divLabelDuration').style.display = "none";
      document.getElementById('divLabelExpired').style.display = "none";
      document.getElementById('divLabelLicense').style.display = "block";
    }
    if(el == 2)
    {   
        document.getElementById('divLabelDuration').style.display = "block";
        document.getElementById('divLabelExpired').style.display = "block";
        document.getElementById('divLabelLicense').style.display = "none";
    }

});
</script>
@endsection
@endsection
