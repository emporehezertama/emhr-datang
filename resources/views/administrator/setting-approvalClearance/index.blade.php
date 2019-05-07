@extends('layouts.administrator')

@section('title', 'Setting Approval Exit')

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
                <h4 class="page-title">SETTING APPROVAL EXIT CLEARANCE</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">SETTING APPROVAL EXIT CLEARANCE</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-4">
                <div class="white-box">
                    <h3 class="box-title m-b-0 pull-left">Check From HRD</h3>
                    <a class="btn btn-info btn-xs pull-right add-hrd"><i class="fa fa-plus"></i> Add</a>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>NIK / NAMA</th>
                                    <th>POSITION</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hrd as $no => $item)
                                <tr>
                                    <td>{{ ($no + 1) }}</td>
                                    <td>{{ isset($item->user->name) ? $item->user->nik .'/'. $item->user->name : '' }}</td>
                                    <td>{{ isset($item->user->structure->position) ? $item->user->structure->position->name:''}}{{ isset($item->user->structure->division) ? '-'. $item->user->structure->division->name:'' }}</td>
                                    <td>
                                        <form action="{{ route('administrator.setting-approvalClearance.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}                                               
                                            <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="white-box">
                    <h3 class="box-title m-b-0 pull-left">Check From General Affair (GA)</h3>
                    <a class="btn btn-info btn-xs pull-right add-ga"><i class="fa fa-plus"></i> Add</a>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>NIK / NAMA</th>
                                    <th>POSITION</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ga as $no => $item)
                                <tr>
                                    <td>{{ ($no + 1) }}</td>
                                    <td>{{ isset($item->user->name) ? $item->user->nik .'/'. $item->user->name : '' }}</td>
                                    <td>{{ isset($item->user->structure->position) ? $item->user->structure->position->name:''}}{{ isset($item->user->structure->division) ? '-'. $item->user->structure->division->name:'' }}</td>
                                    <td>
                                        <form action="{{ route('administrator.setting-approvalClearance.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}                                               
                                            <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="white-box">
                    <h3 class="box-title m-b-0 pull-left">Check From IT</h3>
                    <a class="btn btn-info btn-xs pull-right add-it"><i class="fa fa-plus"></i> Add</a>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>NIK / NAMA</th>
                                    <th>POSITION</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($it as $no => $item)
                                <tr>
                                    <td>{{ ($no + 1) }}</td>
                                    <td>{{ isset($item->user->name) ? $item->user->nik .'/'. $item->user->name : '' }}</td>
                                    <td>{{ isset($item->user->structure->position) ? $item->user->structure->position->name:''}}{{ isset($item->user->structure->division) ? '-'. $item->user->structure->division->name:'' }}</td>
                                    <td>
                                        <form action="{{ route('administrator.setting-approvalClearance.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}                                               
                                            <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
             <div class="col-md-4">
                <div class="white-box">
                    <h3 class="box-title m-b-0 pull-left">Check From Accounting & Finance</h3>
                    <a class="btn btn-info btn-xs pull-right add-accounting"><i class="fa fa-plus"></i> Add</a>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>NIK / NAMA</th>
                                    <th>POSITION</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounting_finance as $no => $item)
                                <tr>
                                    <td>{{ ($no + 1) }}</td>
                                    <td>{{ isset($item->user->name) ? $item->user->nik .'/'. $item->user->name : '' }}</td>
                                    <td>{{ isset($item->user->structure->position) ? $item->user->structure->position->name:''}}{{ isset($item->user->structure->division) ? '-'. $item->user->structure->division->name:'' }}</td>
                                    <td>
                                        <form action="{{ route('administrator.setting-approvalClearance.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}                                               
                                            <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i></button>
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
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
   @include('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
<!-- sample modal content -->
<div id="modal_hrd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Check By HRD</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                            <label class="col-md-3">Choose </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-hrd" >
                                <input type="hidden" class="modal_hrd_id">
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_hrd">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- sample modal content -->
<div id="modal_ga" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Check From General Affair (GA)</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                            <label class="col-md-3">Choose </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-ga">
                                <input type="hidden" class="modal_ga_id">
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_ga">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- sample modal content -->
<div id="modal_it" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Check From IT</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                            <label class="col-md-3">Choose </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-it">
                                <input type="hidden" class="modal_it_id">
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_it">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- sample modal content -->
<div id="modal_accounting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Check From Accounting & Finance</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                            <label class="col-md-3">Choose </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-accounting" />
                                <input type="hidden" class="modal_accounting_id">
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_accounting">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
    .ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front {
        z-index: 9999;
    } 
</style>
<script type="text/javascript">

    $(".autocomplete-hrd" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan-approval') }}",
              method : 'POST',
              data: {
                'name': request.term, '_token' : $("meta[name='csrf-token']").attr('content')
              },
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
            $( ".modal_hrd_id" ).val(ui.item.id);
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });


    $('.add-hrd').click(function(){
        $('#modal_hrd').modal('show');
    });

    $('#add_modal_hrd').click(function(){
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-clearance-hrd') }}',
            data: {'id' : $('.modal_hrd_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });

    $(".autocomplete-ga" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan-approval') }}",
              method : 'POST',
              data: {
                'name': request.term, '_token' : $("meta[name='csrf-token']").attr('content')
              },
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
            $( ".modal_ga_id" ).val(ui.item.id);
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });

    $('.add-ga').click(function(){
        $('#modal_ga').modal('show');
    });
    $('#add_modal_ga').click(function(){
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-clearance-ga') }}',
            data: {'id' : $('.modal_ga_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });

    $(".autocomplete-it" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan-approval') }}",
              method : 'POST',
              data: {
                'name': request.term, '_token' : $("meta[name='csrf-token']").attr('content')
              },
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
            $( ".modal_it_id" ).val(ui.item.id);
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });


    $('.add-it').click(function(){
        $('#modal_it').modal('show');
    });
    $('#add_modal_it').click(function(){
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-clearance-it') }}',
            data: {'id' : $('.modal_it_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });

$(".autocomplete-accounting" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan-approval') }}",
              method : 'POST',
              data: {
                'name': request.term, '_token' : $("meta[name='csrf-token']").attr('content')
              },
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
            $( ".modal_accounting_id" ).val(ui.item.id);
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });
    $('.add-accounting').click(function(){
        $('#modal_accounting').modal('show');
    });
    $('#add_modal_accounting').click(function(){
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-clearance-accounting') }}',
            data: {'id' : $('.modal_accounting_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });


    
</script>
@endsection

