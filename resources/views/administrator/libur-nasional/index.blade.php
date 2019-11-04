@extends('layouts.administrator')

@section('title', 'Public Holiday')

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
                <h4 class="page-title">Manage Public Holiday</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('administrator.libur-nasional.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD PUBLIC HOLIDAY</a>
                <a class="btn btn-info btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light" id="add-import-libur-nasional"> <i class="fa fa-upload"></i> IMPORT</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Public Holiday</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>DATE</th>
                                    <th>DESCRIPTION</th>
                                    <th>CREATED</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>   
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('administrator.libur-nasional.edit', ['id' => $item->id]) }}" style="float: left; margin-right:5px" > <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                            <form action="{{ route('administrator.libur-nasional.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="margin-left: 5px;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>

<!-- modal content education  -->
<div id="modal_import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <form method="POST" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('administrator.libur-nasional.import') }}">
                    {{ csrf_field() }}
                    <h4 class="modal-title" id="myModalLabel">Import Data</h4> </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">File (xls)</label>
                            <div class="col-md-9">
                                <input type="file" name="file" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm">Import</button>
                    </div>
                </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


@section('footer-script')
<script type="text/javascript">
    $("#add-import-libur-nasional").click(function(){
        $("#modal_import").modal("show");
    })
</script>
@endsection

@endsection
