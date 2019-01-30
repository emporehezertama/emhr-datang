@extends('layouts.app')

@section('title', 'User -Tridarma System')

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
                <h4 class="page-title">Form User</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">User</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
    <div class="row">
        <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('user.store') }}" method="POST">
            <div class="col-md-6">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Data User</h3>
                    <br />
                
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
                                <label class="col-md-12">Name</label>
                                <div class="col-md-12">
                                    <input type="text" name="nama" class="form-control form-control-line" value="{{ old('nama')}}"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Gender</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value=""> - Choose Gender - </option>
                                        @foreach(['Laki-laki', 'Perempuan'] as $item)
                                            <option>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input type="email" value="{{ old('email') }}" class="form-control form-control-line" name="email" id="example-email"> </div>
                            </div>

                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Password</label>
                                <div class="col-md-12">
                                    <input type="password" class="form-control form-control-line" name="password"> </div>
                            </div>

                             <div class="form-group">
                                <label for="example-email" class="col-md-12">Confirm Password</label>
                                <div class="col-md-12">
                                    <input type="password" class="form-control form-control-line" name="confirmation"> </div>
                            </div>
                            
                            
                           
                        <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="white-box form-horizontal">
                    <div class="form-group">
                        <label class="col-md-12">Telephone</label>
                        <div class="col-md-12">
                            <input type="number" value="{{ old('telepon') }}" name="telepon" class="form-control form-control-line"> </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-12">Religion</label>
                        <div class="col-md-12">
                            <?php $agama = ['Islam', 'Kristen', 'Budha', 'Hindu']; ?>
                            <select class="form-control" name="agama">
                                <option value=""> - Religion - </option>
                                @foreach($agama as $item)
                                    <option value="{{ $item }}"> {{ $item }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-12">Place of Birth</label>
                        <div class="col-md-12">
                            <input type="text" value="{{ old('tempat_lahir') }}" name="tempat_lahir" class="form-control form-control-line"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Date of Birth</label>
                        <div class="col-md-12">
                            <input type="text" value="{{ old('tanggal_lahir') }}"  name="tanggal_lahir" class="form-control form-control-line datepicker"> </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-md-6">
                            <label> <input type="checkbox" name="status" value="1" /> Aktif User</label>
                        </div>
                    </div>

                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Simpan Data User</button>
                    <br style="clear: both;" />
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
@section('footer-script')
<!-- Date picker plugins css -->
<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Date Picker Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
   
    jQuery('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });
</script>
@endsection

@endsection
