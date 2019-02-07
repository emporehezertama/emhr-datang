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
                <h4 class="page-title">NEWS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <form method="GET" action="" style="float: right; width: 40%;">
                    <div class="form-group">
                        <input type="text" name="keyword-news" class="form-control" style="float:left;width: 80%;margin-right: 5px;height: 28px;" placeholder="Search Here ..." value="{{ isset($_GET['keyword-news']) ? $_GET['keyword-news'] : '' }}" >
                        <button type="submit" class="btn btn-default" style="height: 28px; padding-top: 4px;">GO</button>
                    </div>
                </form>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12 col-xs-12">
                        <div class="news-slide m-b-15">
                            <div class="vcarousel slide">
                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                        @foreach($news_list_right as $key => $item)
                                            @if($key == 0)
                                            <div class="overlaybg">
                                                <img src="{{ asset('storage/news/'. $item->image) }}">
                                            </div>
                                            <div class="news-content"><span class="label label-danger label-rounded">News</span>
                                                <h2>{{ $item->title }}</h2> 
                                                <p style="color: white;">{{ substr(strip_tags($item->content),0, 120) }}</p>
                                                <a href="{{ route('karyawan.news.readmore', $item->id) }}">Read More</a></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-xs-12">
                        <div class="row">
                            @foreach($news_list_right as $key => $item)
                            <?php 
                                if($key == 0) continue;

                                if($key >= 7) continue;
                            ?>

                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="white-box" style="padding: 7px 4px 7px 8px;min-height: 99px;">
                                    <div class="col-md-4" style="padding:0;">
                                        @if(!empty($item->thumbnail))
                                        <a href="{{ route('karyawan.news.readmore', $item->id) }}">
                                            <img src="{{ asset('storage/news/'. $item->thumbnail) }}" style="width: 100%; margin-top: 7px;" />
                                        </a>
                                        @endif
                                    </div>
                                    <div class="col-md-8" style="padding-right:0;">
                                        <h4 style="padding-bottom:0; margin-bottom:0;padding-top:0;margin-top:0; font-size: 14px;"><a href="{{ route('karyawan.news.readmore', $item->id) }}">{{ $item->title }}</a></h4>
                                        <p style="margin-bottom:0;"><small>{{ date('d F Y H:i', strtotime($item->created_at)) }}</small></p>
                                        <!-- <p>
                                            {{ substr(strip_tags($item->content),0, 40) }}
                                        </p> -->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            @if($key == 2)
                            <div class="clearfix"></div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="row">
                        @foreach($news_list_right as $key => $item)
                            @if($key >= 7)
                                <div class="col-lg-4 col-sm-4 col-xs-12">
                                    <div class="white-box" style="padding: 7px 4px 7px 8px;">
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
