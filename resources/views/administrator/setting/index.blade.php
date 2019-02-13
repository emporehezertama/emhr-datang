@extends('layouts.administrator')

@section('title', 'General Setting')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">General Setting</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
                <button type="button" class="btn btn-info" onclick="form_setting.submit()"><i class="fa fa-save"></i> Save Setting</button>
            </div>
        </div>
        <div class="row">
            <form class="form-horizontal" id="form-setting" name="form_setting" enctype="multipart/form-data" action="{{ route('administrator.setting.save') }}" method="POST">
                {{ csrf_field() }}
                <div class="col-md-6 p-l-0 p-r-0">
                    <div class="white-box">
                        <div class="form-group">
                            <label class="col-md-12">Website Title</label>
                            <div class="col-md-12">
                                <input type="text" name="setting[title]" class="form-control" value="{{ get_setting('title') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Website Description</label>
                            <div class="col-md-12">
                                <textarea class="form-control" name="setting[description]" style="height: 150px;">{{ get_setting('description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Footer Description</label>
                            <div class="col-md-12">
                                <textarea class="form-control" name="setting[footer_description]">{{ get_setting('footer_description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6">Language</label>
                            <label class="col-md-6">Timezones <label class="text-danger"> {{ date('d F Y H:i') }}</label></label>
                            <div class="col-md-6">
                                <select class="form-control" name="setting[language]">
                                    @foreach(list_language() as $key => $item)
                                    <option {{ $key == get_setting('language') ? 'selected' : '' }} value="{{ $key }}" >{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" name="setting[timezone]">
                                    @foreach(generate_timezone_list() as $key => $item)
                                    <option {{ $key == get_setting('timezone') ? 'selected' : '' }} value="{{ $key }}" >{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">@lang('setting.struktur-organisasi')</label>
                            <div class="col-md-6">
                                <select class="form-control" name="setting[struktur_organisasi]">
                                    <option value="1" {{ get_setting('struktur_organisasi') == 1 ? 'selected' : '' }}>Simple</option>
                                    <option value="2" {{ get_setting('struktur_organisasi') == 2 ? 'selected' : '' }}>Middle</option>
                                    <option value="3" {{ get_setting('struktur_organisasi') == 3 ? 'selected' : '' }}>Custome</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 p-r-0">
                    <div class="white-box">
                       <div class="form-group">
                            <label class="col-md-6">Header Color</label>
                            <label class="col-md-6">Menu Color</label>
                            <div class="col-md-6">
                                <div class="colorPickSelectorheader_color" style="float: left;"></div>
                                <input type="text" class="form-control header_color" style="float: left; width: 80%;" name="setting[header_color]" value="{{ empty(get_setting('header_color')) ? '#bd332b' : get_setting('header_color') }}">
                            </div>
                            <div class="col-md-6">
                                <div class="colorPickSelectormenu_color" style="float: left;"></div>                                
                                <input type="text" class="form-control menu_color" style="float: left; width: 80%;" name="setting[menu_color]" value="{{ empty(get_setting('menu_color')) ? '#eaeaea' : get_setting('menu_color') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Logo</label>
                            <div class="col-md-6">
                                <input type="file" name="logo" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                @if(!empty(get_setting('logo')))
                                <img src="{{ get_setting('logo') }}" style="height: 50px; " />
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Favicon</label>
                            <div class="col-md-6">
                                <input type="file" name="favicon" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                @if(!empty(get_setting('favicon')))
                                <img src="{{ get_setting('favicon') }}" style="height: 15px;" />
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Logo Footer</label>
                            <div class="col-md-6">
                                <input type="file" name="logo_footer" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                @if(!empty(get_setting('logo_footer')))
                                <img src="{{ get_setting('logo_footer') }}" style="height: 50px;" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>                   
        </div>
    </div>
    @include('layouts.footer')
</div>
@section('js')
<style type="text/css">
    .colorPickSelectorheader_color, .colorPickSelectormenu_color{
          border-radius: 5px;
          width: 36px;
          height: 36px;
          cursor: pointer;
          -webkit-transition: all linear .2s;
          -moz-transition: all linear .2s;
          -ms-transition: all linear .2s;
          -o-transition: all linear .2s;
          transition: all linear .2s;
          border: 1px solid #eee;
        }

</style>
<link rel="stylesheet" href="{{ asset('js/colorpicker/src/colorPick.css') }}">
<script src="{{ asset('js/colorpicker/src/colorPick.js') }}"></script> 
<script type="text/javascript">

    $(".colorPickSelectorheader_color").colorPick({
        'initialColor' : '{{ empty(get_setting('header_color')) ? '#bd332b' : get_setting('header_color') }}',
        'onColorSelected': function(){
            $('.navbar-header').css({ backgroundColor: this.color });
            $(".header_color").val(this.color);

            this.element.css({'backgroundColor': this.color, 'color': this.color});
        }
    });

    $(".colorPickSelectormenu_color").colorPick({
        'initialColor' : '{{ empty(get_setting('menu_color')) ? '#bd332b' : get_setting('menu_color') }}',
        'onColorSelected': function(){
            $('#side-menu > li > a.active').css({ backgroundColor: this.color });
            $(".menu_color").val(this.color);

            this.element.css({'backgroundColor': this.color, 'color': this.color});
            $('.navbar-header').css("border-top", '5px solid '+ this.color );
        }
    });


    $(".header_color").on("input",function(){
        var warna  = $(this).val();

        $('.navbar-header').css({ backgroundColor: warna});
    });

    $(".menu_color").on("input",function(){
        var warna  = $(this).val();

        $('#side-menu > li > a.active').css("background-color",  warna);
        $('.navbar-header').css("border-top", '5px solid '+ warna );

    });
</script>
@endsection
@endsection
