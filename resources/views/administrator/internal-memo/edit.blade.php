@extends('layouts.administrator')

@section('title', 'Internal Memo')

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
                <h4 class="page-title">Form Internal Memo</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Internal Memo</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.internal-memo.update', $data->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Internal Memo</h3>
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
                            <label class="col-md-12">Title</label>
                            <div class="col-md-12">
                                <input type="text" required class="form-control" name="title" value="{{ $data->title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">File (PDF)</label>
                            <div class="col-md-12">
                                <input type="file" name="file" class="form-control" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                    
                        <a href="{{ route('administrator.internal-memo.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        <button type="submit"  class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_submit"><i class="fa fa-save"></i> Save Data</button>
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
@section('footer-script')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'ckeditor' );
    </script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
