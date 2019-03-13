@extends('layouts.administrator')

@section('title', 'Backup App & Database')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Backup App & Database</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
                <button type="button" class="btn btn-info" onclick="form_setting.submit()"><i class="fa fa-save"></i> Save Setting</button>
            </div>
        </div>
        <div class="row">
            <form class="form-horizontal" id="form-setting" name="form_setting" enctype="multipart/form-data" action="{{ route('administrator.setting.backup-save') }}" method="POST">
                {{ csrf_field() }}
                <div class="col-md-6 p-l-0">
                    <div class="white-box">
                        <div class="form-group">
                            <label class="col-md-5">Email Notifikasi</label>
                            <label class="col-md-5">Backup Type</label>
                            <div class="col-md-5">
                                <input type="email" class="form-control" name="setting[backup_mail]" value="{{ get_setting('backup_mail') }}" />
                            </div>
                            <div class="col-md-5">
                                <select class="form-control" name="setting[backup_type]">
                                    <option value="0"> - Select Type Backup - </option>
                                    <option value="1" {{ get_setting('backup_type') == 1 ? 'selected' : '' }}>All Apps & Database</option>
                                    <option value="2" {{ get_setting('backup_type') == 2 ? 'selected' : '' }}>Database Only</option>
                                    <option value="3" {{ get_setting('backup_type') == 3 ? 'selected' : '' }}>Apps Only</option>
                                </select>
                            </div>
                        </div>
                     
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-2 p-l-0">
                                    <label class="m-r-0">Schedule Backup</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="m-r-10"><input type="radio" value="3" name="setting[schedule]" {{ get_setting('schedule') == 3 ? 'checked' : '' }} /> Nightly / Daily</label>
                                    <label class="m-r-10"><input type="radio" value="4" name="setting[schedule]" {{ get_setting('schedule') == 4 ? 'checked' : '' }} /> Weekly</label>
                                    <label class="m-r-10"><input type="radio" value="5" name="setting[schedule]" {{ get_setting('schedule') == 5 ? 'checked' : '' }} /> Monthly</label>
                                    <div class="">
                                        <input type="text" class="form-control datepicker" name="setting[schedule_custom_date]" placeholder="Custom Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-l-0">
                    <div class="white-box">
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Used Storage</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                        </table>
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
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'ckeditor' );
    CKEDITOR.replace( 'ckeditor_testing' );

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
