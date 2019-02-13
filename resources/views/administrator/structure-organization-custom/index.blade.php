@extends('layouts.administrator')

@section('title', 'Dashboard')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Organization Structure</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Organization Structure</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <div id="orgChart" style="overflow: scroll;"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>

@section('footer-script')
<div id="modal_structure_organization" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="title_structure_organization"></h4> </div>
                <form method="POST" class="form-horizontal" action="{{ route('administrator.organization-structure-custom.store') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="parent_id" class="form-control" />
                        <div class="form-group">
                            <label class="col-md-3">Name</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('admin-css/js/jquery.orgchart/jquerysctipttop.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin-css/js/jquery.orgchart/jquery.orgchart.css') }}" media="all" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin-css/js/jquery.orgchart/jquery.orgchart.js') }}?v={{ date('YmdHis') }}"></script>
<script type="text/javascript">

    function confirm_delete_structure(id, org_chart)
    {
        bootbox.confirm({
            title : "<i class=\"fa fa-warning\"></i> EMPORE SYSTEM",
            message: 'Delete Structure ?',
            closeButton: false,
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-sm btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn btn-sm btn-danger'
                }
            },
            callback: function (result) {
              if(result)
              { 
                 $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.structure-custome-delete') }}',
                    data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                    success: function (data) {
                         org_chart.deleteNode(id);
                    }
                });
              }
            }
        });
    }

    function add_structure(id, title)
    {
        $("input[name='parent_id']").val(id);
        $("#title_structure_organization").html(title);

        $("#modal_structure_organization").modal("show");
    }

    $(function(){
         $.ajax({
            type: 'GET',
            url: '{{ route('ajax.get-stucture-custome') }}',
            dataType: 'json',
            success: function (data) {

                org_chart = $('#orgChart').orgChart({
                    data: data,
                    showControls: true,
                    allowEdit: true,
                    newNodeText : 'Add',
                    onAddNode: function(node){ 
                        add_structure(node.data.id, node.data.name);
                    },
                    onDeleteNode: function(node){
                        confirm_delete_structure(node.data.id, org_chart);
                    },
                    onClickNode: function(node){

                    }
                });
               
            }
        })
    });
    </script>
@endsection

@endsection
