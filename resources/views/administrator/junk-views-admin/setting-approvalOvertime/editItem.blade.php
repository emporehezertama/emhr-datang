@extends('layouts.administrator')

@section('title', 'Setting Approval Overtime')

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
                <h4 class="page-title">SETTING APPROVAL OVERTIME</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Approval Overtime</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.setting-approvalOvertime.updateItem', $data->id) }}" method="POST">
               <!-- <input type="hidden" name="_method" value="PUT">-->
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Update Approval Overtime</h3>
                        <hr />
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
                            <input type="hidden" value="{{$data->setting_approval_leave_id}}" name="setting_approval_leave_id">
                            <div class="form-group">
                                <label class="col-md-12">Level</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="setting_approval_level_id" disabled="true">
                                        <option value=""> - choose - </option>
                                        @foreach($level as $item)
                                         <option value="{{ $item->id }}" {{ $item->id== $data->setting_approval_level_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Approval Position</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="structure_organization_custom_id">
                                        <option value=""> - choose - </option>
                                        @foreach($structure as $item)
                                        <option value="{{ $item["id"] }}" {{ $item["id"]== $data->structure_organization_custom_id ? 'selected' : '' }}>{{ $item["name"] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Description</label>
                                <div class="col-md-10">
                                    <input type="text" name="description" class="form-control form-control-line" value="{{ $data->description }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('administrator.setting-approvalOvertime.indexItem',['id' => $data->setting_approval_leave_id] ) }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                            <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
                            <br style="clear: both;" />
                        </div>
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
@endsection
