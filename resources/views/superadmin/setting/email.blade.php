@extends('layouts.superadmin')

@section('title', 'Email / SMTP Setting')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Email / SMTP Setting</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
                <button type="button" class="btn btn-info" onclick="form_setting.submit()"><i class="fa fa-save"></i> Save Setting</button>
            </div>
        </div>
        <div class="row">
            <form class="form-horizontal" id="form-setting" name="form_setting" enctype="multipart/form-data" action="{{ route('superadmin.setting.email-save') }}" method="POST">
                {{ csrf_field() }}
                <div class="col-md-6 p-l-0">
                    <div class="white-box">
                        <h3 class="m-t-0">General Email</h3><hr />
                        <div class="form-group">
                            <label class="col-md-12">Subject</label> 
                            <div class="col-md-12">
                                <input type="text" name="setting[mail_name]" class="form-control" placeholder="Name Typing here .." value="{{ get_setting('mail_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Signature</label>
                            <div class="col-md-12">
                                <textarea class="form-control" name="setting[mail_signature]" style="height: 120px;" id="ckeditor"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-l-0 p-r-0">
                    <div class="white-box">
                        <h3 class="m-t-0">SMTP Setting</h3><hr />
                        <div class="form-group">
                            <label class="col-md-6">Driver</label>
                            <label class="col-md-6">Host</label>
                            <div class="col-md-6">
                                <input type="text" name="setting[mail_driver]" class="form-control" placeholder="SMTP" value="{{ get_setting('mail_driver') }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="setting[mail_host]" class="form-control" placeholder="Email Host" value="{{ get_setting('mail_host') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6">Port</label>
                            <label class="col-md-6">Encryption</label>
                            <div class="col-md-6">
                                <input type="number" name="setting[mail_port]" class="form-control" placeholder="465 / 587" value="{{ get_setting('mail_port') }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="setting[mail_encryption]" class="form-control" placeholder="SSL / TLS" value="{{ get_setting('mail_encryption') }}">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-6">Username</label>
                            <label class="col-md-6">Password</label>
                            <div class="col-md-6">
                                <input type="text" name="setting[mail_username]" class="form-control" placeholder="Username Typing here ..." value="{{ get_setting('mail_username') }}">
                            </div>
                            <div class="col-md-6">
                                <input type="password" name="setting[mail_password]" class="form-control" placeholder="Password Typing here .." value="{{ get_setting('mail_password') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>   
            <form class="form-horizontal" method="POST" action="{{ route('superadmin.setting.email-test-send') }}">
                {{ csrf_field() }}
                <div class="col-md-12 p-r-0 p-l-0">
                    <div class="white-box">
                        <h3 class="m-t-0">Testing Send Email</h3>
                        <hr />
                         <div class="form-group">
                            <div class="col-md-6">
                                <input type="email" required class="form-control" name="to" placeholder="To" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" required class="form-control" placeholder="Subject : Testing Email ... " name="subject">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea class="form-control" name="test_message" id="ckeditor_testing">Testing <br /><br />Regards,<br />Thanks</textarea>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-sm">Send Test <i class="fa fa-paper-plane"></i> </button>
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
