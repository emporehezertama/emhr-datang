@extends('layouts.administrator')

@section('title', 'Branch Office')

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
                    <h4 class="page-title">Form Branch List</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="active">Branch List</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- .row -->
            <div class="row">
                <form id="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.cabang.store') }}" method="POST">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Add Branch List</h3>
                            <hr />
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-12">Branch Name</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Telephone</label>
                                <div class="col-md-6">
                                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Fax</label>
                                <div class="col-md-6">
                                    <input type="text" name="fax" class="form-control" value="{{ old('fax') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Address</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="alamat">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Lokasi</label>
                                <div class="col-md-6">
                                    <div id="map" style="height: 400px; width: 100%;"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Radius (M)</label>
                                <div class="col-md-6">
                                    <input type="number" id="radius" name="radius" class="form-control" value="{{ old('radius') }}">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                            <div class="col-md-12">
                                <a href="{{ route('administrator.cabang.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
                                <br style="clear: both;" />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.row -->
            <!-- ============================================================== -->
        </div>
        <!-- /.container-fluid -->
        @extends('layouts.footer')
    </div>

    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTctq_RFrwKOd84ZbvJYvU3MEcrLmPNJ8"
            async defer></script>
    <script>

        setTimeout(function() {
            var currentRadius = '0';
            $('#radius').on('change paste keyup',function () {

                if(typeof marker.getPosition()=== "undefined" && currentRadius != $(this).val()) {
                    alert("Pilih lokasi terlebih dahulu!");
                }

                currentRadius = $(this).val();
                cityCircle.setRadius(parseInt(currentRadius));
                console.log($(this).val());
            });
            var jakarta = {lat: -6.21462, lng: 106.84513};



            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 10, center: jakarta});
            var marker = new google.maps.Marker({map : map});
            var cityCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map : map
            });
            @if(old('latitude') && old('longitude'))
            cityCircle.setCenter({lat: {{old('latitude')}}, lng: {{old('longitude')}}});
            marker.setPosition({lat: {{old('latitude')}}, lng: {{old('longitude')}}});
            map.setCenter({lat: {{old('latitude')}}, lng: {{old('longitude')}}});
            cityCircle.setRadius({{old('radius')}});
            map.setZoom(16);
            console.log("Data lat/lng : {{old('latitude')}}");
            @else
            console.log("Tidak ada data lama");
            @endif
            console.log(marker.getPosition());
            map.addListener('click', function(e) {
                marker.setPosition(e.latLng);
                cityCircle.setCenter(e.latLng);
                console.log(marker.getPosition());
                map.setCenter(e.latLng);
                // map.setZoom(16);

            });
            cityCircle.addListener('click', function(e) {
                marker.setPosition(e.latLng);
                cityCircle.setCenter(e.latLng);
                console.log(marker.getPosition());
                map.setCenter(e.latLng);
                // map.setZoom(16);

            });
            // The marker, positioned at Uluru
            // var marker = new google.maps.Marker({position: uluru, map: map});
            //

            $('#form').submit(function(eventObj) {
                if(typeof marker.getPosition()!== "undefined") {
                    $(this).append("<input type='hidden' name='latitude' value='"+marker.getPosition().lat()+"' /> ");
                    $(this).append("<input type='hidden' name='longitude' value='"+marker.getPosition().lng()+"' /> ");
                }
                return true;
            });
        },1000);
    </script>
@endsection
