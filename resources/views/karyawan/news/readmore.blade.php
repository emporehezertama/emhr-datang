@extends('layouts.karyawan')

@section('title', 'News')

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
                <h4 class="page-title">Dashboard</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">News</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="white-box">
                    <h2 class="box-title" style="margin-bottom:0;">{{ $data->title }}</h2>
                    <p><small>{{ $data->created_at }}</small></p>
                    <hr /> 
                    
                    @if(!empty($data->image))
                        <p style="text-align: center;">
                            <img src="{{ asset('storage/news/'. $data->image) }}" />
                        </p>
                    @endif
                    
                    {!! $data->content !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    @foreach($news_list_right as $key => $item)
                        @if($key >= 7)
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="white-box" style="padding: 7px 4px 7px 8px;margin-bottom:8px;">
                                    <div class="col-md-4" style="padding:0;">
                                        @if(!empty($item->thumbnail))
                                        <a href="{{ route('karyawan.news.readmore', $item->id) }}">
                                            <img src="{{ asset('storage/news/'. $item->thumbnail) }}" style="width: 100%; margin-top: 2px;" />
                                        </a>
                                        @endif
                                    </div>
                                    <div class="col-md-8" style="padding-right:0;">
                                        <h4 style="padding-bottom:0; margin-bottom:0;padding-top:0;margin-top:0;"><a href="{{ route('karyawan.news.readmore', $item->id) }}">{{ $item->title }}</a></h4>
                                        <p style="margin-bottom:0;"><small>{{ date('d F Y H:i', strtotime($item->created_at)) }}</small></p>
                                        <p>
                                            {{ substr(strip_tags($item->content),0, 40) }}
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>

        </div>
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
</style>
@endsection
