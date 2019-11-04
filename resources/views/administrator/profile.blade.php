@extends('layouts.administrator')

@section('title', 'Profile')

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

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Home</a></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="p-30">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4">
                                @if(empty(Auth::user()->foto))
                                <img src="{{ asset('admin-css/images/user.png') }}" alt="varun" class="img-circle img-responsive">
                                @else
                                <img src="{{ asset('storage/foto/'. Auth::user()->foto) }}" alt="varun" class="img-circle img-responsive">
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <h2 class="m-b-0">{{ Auth::user()->name }}</h2>
                                <h4>{{ empore_jabatan(Auth::user()->id) }}</h4>
                                <a class="btn btn-info btn-xs" id="change_password">Change Password <i class="fa fa-key"></i></a>
                                @if(Auth::user()->last_change_password !== null) 
                                    <p>Last Update :  {{ date('d F Y H:i', strtotime(Auth::user()->last_change_password)) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-20 text-center">
                        <div class="col-md-5">
                          <form method="POST" action="{{ route('administrator.update-profile') }}">
                            {{ csrf_field() }}
                            <table class="table table-hover">
                                <tr>
                                    <th width="200">NIK / User Login</th>
                                    <th width="300"><input type="text" name="nik" class="form-control" value="{{ Auth::user()->nik }}" /></th>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th><input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}" /> </th>
                                </tr>
                            </table>
                            <hr />
                            <br />
                            <button type="submit" class="btn btn-info btn-sm pull-left"><i class="fa fa-save"></i> Save</button>
                          </form>
                        </div>
                        <div class="clearfix"></div>
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
@section('footer-script')
     <div class="modal fade" id="modal_reset_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="exampleModalLabel1">Change Password !</h4> 
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Current Password:</label>
                        <input type="password" name="currentpassword"class="form-control" placeholder="Password"> 
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">New Password:</label>
                        <input type="password" name="password"class="form-control" placeholder="Password"> 
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Confirm New Password:</label>
                        <input type="password" name="confirm"class="form-control" placeholder="Konfirmasi Password"> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="submit_password">Submit Password <i class="fa fa-arrow-right"></i></button>
                </div>
              </form>
            </div>
        </div>
    </div> 
    <script type="text/javascript">
        $("#change_password").click(function(){
            $("#modal_reset_password").modal("show");
        });

        $("#submit_password").click(function(){

            var password    = $("input[name='password']").val();
            var confirm     = $("input[name='confirm']").val();
            var currentpassword  = $("input[name='currentpassword']").val();

            if(password == "" || confirm == "")
            {
                bootbox.alert('Password atau Konfirmasi Password harus diisi !');
                return false;
            }

            if(password != confirm)
            {
                bootbox.alert('Password tidak sama');
            }
            else
            {
                 $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.update-password-administrator') }}',
                    data: {'id' : {{ Auth::user()->id }}, 'currentpassword' : currentpassword,  'password' : password, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {
                        if(data.message == 'error')
                        {
                            alert(data.data);
                        }
                        else
                        {
                            location.reload();                            
                        }
                    }
                });
            }
        });
    </script>
@endsection
@endsection