@extends('layouts.administrator')

@section('title', 'Section')

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
                <h4 class="page-title">Form Section</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Section</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.section.store') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Data Section</h3>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-12">Directorate</label>
                                <div class="col-md-10">
                                   <select class="form-control" name="directorate_id" required>
                                        <option value=""> Pilih Directorate</option>
                                        @foreach($directorate as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Division</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="division_id">
                                        <option value=""> Pilih Division</option>
                                        @foreach($division as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Department</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="department_id" required>
                                        <option value=""> Pilih Department</option>
                                        @foreach($department as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Name Section</label>
                                <div class="col-md-10">
                                    <input type="text" name="name" class="form-control form-control-line" value="{{ old('name')}}">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <a href="{{ route('administrator.department.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Simpan Data</button>
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
<script type="text/javascript">
    $("select[name='directorate_id']").on('change', function(){

        var id = $(this).val();

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-division-by-directorate') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                var html_ = '<option value=""> Pilih Division</option>';

                $(data.data).each(function(k, v){
                    html_ += "<option value=\""+ v.id +"\">"+ v.name +"</option>";
                });

                $("select[name='division_id'").html(html_);
            }
        });
    });

    $("select[name='division_id']").on('change', function(){

        var id = $(this).val();

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-department-by-division') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                var html_ = '<option value=""> Pilih Department</option>';

                $(data.data).each(function(k, v){
                    html_ += "<option value=\""+ v.id +"\">"+ v.name +"</option>";
                });

                $("select[name='department_id'").html(html_);
            }
        });
    });
</script>
@endsection

@endsection
