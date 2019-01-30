@extends('layouts.karyawan')

@section('title', 'Dashboard')

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
                <h4 class="page-title">HOME</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <form method="GET" action="" style="float: right; width: 40%;">
                    <div class="form-group">
                        <i class="fa fa-search-plus" style="float: left;font-size: 20px;margin-top: 9px;margin-right: 12px;"></i>
                        <input type="text" name="keyword-karyawan" class="form-control autocomplete-karyawan" style="float:left;width: 80%;margin-right: 5px;" placeholder="Search Karyawan Here...">
                    </div>
                </form>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            
            <div class="col-lg-12 col-sm-12 col-md-12" id="content_search_karyawan">

            </div>


            <div class="col-lg-4 col-sm-4 col-md-4">
                <div class="panel panel-themecolor">
                    <div class="panel-heading"><i class="fa fa-list-alt"></i> News List</h2></div>
                    <div class="panel-body">
                        @foreach($news as $item)
                            <div class="col-md-12" style="padding:0;">
                                <div class="col-md-4" style="padding:0;">
                                    @if(!empty($item->thumbnail))
                                    <a href="{{ route('karyawan.news.readmore', $item->id) }}">
                                        <img src="{{ asset('storage/news/'. $item->thumbnail) }}" style="width: 100%;" />
                                    </a>
                                    @endif
                                </div>
                                <div class="col-md-8" style="padding-right:0;">
                                    <h4 style="padding-bottom:0; margin-bottom:0;padding-top:0;margin-top:0;"><a href="{{ route('karyawan.news.readmore', $item->id) }}">{{ $item->title }}</a></h4>
                                    <p style="margin-bottom:0;"><small>{{ date('d F Y H:i', strtotime($item->created_at)) }}</small></p>
                                    <p>
                                        {{ substr(strip_tags($item->content),0, 50) }}
                                    </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr style="margin-top:10px; margin-bottom:10px;" />
                        @endforeach
                        <a href="{{ route('karyawan.news.more') }}" class="btn btn-rounded btn-danger btn-block p-10" style="color: white;"><i class="fa fa-list"></i> More News</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4">
                <div class="panel panel-themecolor" style="margin-bottom: 20px">
                    <div class="panel-heading" style="background: #2cabe3; border:1px solid #2cabe3;"><i class="fa fa-info-circle"></i> Internal Memo</h2></div>
                    <div class="panel-body">
                        @foreach($internal_memo as $item)
                            <div class="col-md-12" style="padding-bottom:0;padding-top:0;">
                                <a href="{{ asset('storage/internal-memo/'. $item->file) }}" target="_blank">
                                    <h4 style="margin-bottom:0;padding-bottom:0;color:#2cabe3; ">{{ $item->title }}</h4>
                                </a>
                                    <p style="margin-top:0;"><small>{{ date('d F Y H:i', strtotime($item->created_at)) }}</small></p>
                                <a href="{{ route('karyawan.download-internal-memo', $item->id) }}">
                                    <p style="position: absolute;top: 0;right: 0; font-size: 20px;color: #2cabe3;">
                                        <i class="fa fa-cloud-download"></i>
                                    </p>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                            <hr style="margin-top: 5px; margin-bottom:5px;" />
                        @endforeach
                        <br />
                        <a href="{{ route('karyawan.internal-memo.more') }}" class="btn btn-rounded btn-info btn-block p-10" style="color: white;"><i class="fa fa-info-circle"></i> More Internal Memo</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4">
                <div class="panel panel-themecolor" style="margin-bottom: 20px">
                    <div class="panel-heading" style="background: #53e69d; border:1px solid #53e69d;"><i class="fa fa-gavel"></i> Product Information</h2></div>
                    <div class="panel-body">
                        @foreach($peraturan_perusahaan as $item)
                            <div class="col-md-12" style="padding-bottom:0;padding-top:0;">
                                <a href="{{ asset('storage/peraturan-perusahaan/'. $item->file) }}" target="_blank">
                                    <h4 style="margin-bottom:0;padding-bottom:0;color:#53e69d;">{{ $item->title }}</h4>
                                </a>
                                    <p style="margin-top:0;"><small>{{ date('d F Y H:i', strtotime($item->created_at)) }}</small></p>
                                <a href="{{ route('karyawan.download-peraturan-perusahaan', $item->id) }}">
                                    <p style="position: absolute;top: 0;right: 0; font-size: 20px;color:#53e69d;">
                                        <i class="fa fa-cloud-download"></i>
                                    </p>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                            <hr style="margin-top: 5px; margin-bottom:5px;" />
                        @endforeach
                        <br />
                        <a href="" class="btn btn-rounded btn-success btn-block p-10" style="color: white;"><i class="fa fa-gavel"></i> More Product Information</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-8 col-md-8" style="padding:0">
                @foreach($ulang_tahun as $i)
                <div class="col-md-4">
                    <div class="panel panel-themecolor">
                        <div class="panel-body">
                            <img src="{{ asset('images/hp.png') }}" class="hp" /> 
                            @if(empty($i->foto))
                                <img src="{{ asset('images/user.png') }}" style="width: 100px;float: left;" class="img-responsive">
                            @else
                                <img src="{{ asset('storage/foto/'. $i->foto) }}" style="width: 100px;float: left;" class="img-responsive">
                            @endif
                            <p style="margin-bottom:0;color: #4d9a00;"><strong>{{ $i->name }}</strong></p>
                            <p style="margin-top:5px;margin-bottom: 10px;">{{ $i->nik }}</p>
                            <h5>{{ isset($i->cabang->name) ? $i->cabang->name : '' }}</h5>
                            <h5>{{ isset($i->organisasi_job_role) ? $i->organisasi_job_role : '' }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="clearfix"></div>    
            <!-- <div class="col-md-4">
                <div class="white-box">
                    <h2 class="box-title">Ulang Tahun</h2>
                    <hr />
                    @foreach($ulang_tahun as $i)
                        <div class="col-md-6">
                            <div class="col-md-3">
                                @if(empty($i->foto))
                                    <img src="{{ asset('admin-css/images/user.png') }}" alt="varun" class="img-circle img-responsive">
                                @else
                                    <img src="{{ asset('storage/foto/'. Auth::user()->foto) }}" alt="varun" class="img-circle img-responsive">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <p style="margin-bottom:0;color: #4d9a00;"><strong>{{ $i->name }}</strong></p>
                                <p style="margin-top:5px;margin-bottom: 10px;">{{ $i->nik }}</p>
                                <h5>{{ isset($i->cabang->name) ? $i->cabang->name : '' }}</h5>
                                <h5>{{ isset($i->organisasi_job_role) ? $i->organisasi_job_role : '' }}</h5>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    @endforeach
                    
                    <div class="clearfix"></div>
                </div>
            </div> -->

    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
</div>
<style type="text/css">
    .col-in h3 {
        font-size: 20px;
    }
    .hp {
        width: 78px;
        position: absolute;
        bottom: 38px;
        left: 153px;
    }
</style>
@section('footer-script')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

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
            

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-karyawan-by-id') }}',
                data: {'id' : ui.item.id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    data = data.data;

                    var el = '<div class="panel panel-themecolor" style="position:relative;"><div class="panel-body"><i class="ti-close" onclick="tutup_ini(this)" style=" position: absolute;right: 36px;top: 18px;color: red;cursor:pointer;"></i><div class="table-responsive">';
                        el += '<table class="table table-striped">';
                        el += '<thead><tr>';
                        el += '<th>NIK</th>';
                        el += '<th>NAMA</th>';
                        el += '<th>TELEPON</th>';
                        el += '<th>EMAIL</th>';
                        el += '<th>EXT</th>';
                        el += '<th>JOB RULE</th>';
                        el += '</tr></thead>';

                        el += '<tbody><tr>';
                        el += '<td>'+ data.nik +'</td>';
                        el += '<td>'+ data.name +'</td>';
                        el += '<td>'+ (data.telepon == null ? '' : data.telepon ) +'</td>';
                        el += '<td>'+ (data.email == null ? '' : data.email) +'</td>';
                        el += '<td>'+ (data.ext ==null ? '' : data.ext) +'</td>';
                        el += '<td>'+ data.organisasi_job_role +'</td>';
                        el += '</tr></tbody>';
                        el += '</table>';
                        el += '</div></div></div>'

                        $("#content_search_karyawan").prepend(el);

                    setTimeout(function(){
                        $(".autocomplete-karyawan").val(" ");

                        $(".autocomplete-karyawan").triggerHandler("focus");

                    }, 500);
                }
            });

            $(".autocomplete-karyawan" ).val("");
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");

    });

    function tutup_ini(el)
    {
        $(el).parent().parent().hide("slow");
    }
</script>
@endsection

@endsection
