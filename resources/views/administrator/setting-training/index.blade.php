@extends('layouts.administrator')

@section('title', 'Setting Approval Kegiatan Training & Perjalanan Dinas')

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
                <h4 class="page-title">Setting Approval Kegiatan Training & Perjalanan Dinas</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Setting</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-4">
                <div class="white-box">
                    <h3 class="box-title m-b-0 pull-left">Approval HRD</h3>
                    <a class="btn btn-info btn-xs pull-right add-hrd"><i class="fa fa-plus"></i> Tambah</a>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>NIK / NAMA</th>
                                    <th>JABATAN</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hrd as $no =>  $item)
                                <tr>
                                    <td>{{ ($no + 1) }}</td>
                                    <td>{{ isset($item->user->name) ? $item->user->nik .' / '. $item->user->name : '' }}</td>
                                    <td>{{ isset($item->user->organisasiposition->name) ? $item->user->organisasiposition->name : '' }}</td>
                                    <td>
                                        <form action="{{ route('administrator.setting-training.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')" method="post" style="float: left;">
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
                    <h3 class="box-title m-b-0 pull-left">Mengetahui GA Department / Head Ops</h3>
                    <a class="btn btn-info btn-xs pull-right add-ga-department"><i class="fa fa-plus"></i> Tambah</a>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>NIK / NAMA</th>
                                    <th>JABATAN</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ga_department as $no =>  $item)
                                <tr>
                                    <td>{{ ($no + 1) }}</td>
                                    <td>{{ isset($item->user->name) ? $item->user->nik .' / '. $item->user->name : '' }}</td>
                                    <td>{{ isset($item->user->organisasiposition->name) ? $item->user->organisasiposition->name : '' }}</td>
                                    <td>
                                        <form action="{{ route('administrator.setting-training.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')" method="post" style="float: left;">
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
                    <h3 class="box-title m-b-0 pull-left">Approval Finance</h3>
                    <a class="btn btn-info btn-xs pull-right add-finance"><i class="fa fa-plus"></i> Tambah</a>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table class="table display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>NAMA</th>
                                    <th>JABATAN</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($finance as $no =>  $item)
                                <tr>
                                    <td>{{ ($no + 1) }}</td>
                                    <td>{{ isset($item->user->name) ? $item->user->nik .' / '. $item->user->name : '' }}</td>
                                    <td>{{ isset($item->user->organisasiposition->name) ? $item->user->organisasiposition->name : '' }}</td>
                                    <td>
                                        <form action="{{ route('administrator.setting-training.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')" method="post" style="float: left;">
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
<div id="modal_finance" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Approval Finance</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                            <label class="col-md-3">Pilih </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-finance" />
                                <input type="hidden" class="modal_finance_id" />
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_finance">Tambah</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- sample modal content -->
<div id="modal_ga_department" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Approval Personalia</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                            <label class="col-md-3">Pilih </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-ga-department" />
                                <input type="hidden" class="modal_ga_department_id" />
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_ga_department">Tambah</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- sample modal content -->
<div id="modal_hrd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Approval HR</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                            <label class="col-md-3">Pilih </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-hrd" />
                                <input type="hidden" class="modal_hrd_id" />
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_hrd">Tambah</button>
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

    $(".autocomplete-finance" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan') }}",
              method : 'POST',
              data: {
                'name': request.term,'_token' : $("meta[name='csrf-token']").attr('content')
              },
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
            $( ".modal_finance_id" ).val(ui.item.id);
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });

    $(".autocomplete-ga-department" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan') }}",
              method : 'POST',
              data: {
                'name': request.term,'_token' : $("meta[name='csrf-token']").attr('content')
              },
              success: function( data ) {
                response( data );
              }
            });
        },
        select: function( event, ui ) {
            $( ".modal_ga_department_id" ).val(ui.item.id);
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });

    $(".autocomplete-hrd" ).autocomplete({
        minLength:0,
        limit: 25,
        source: function( request, response ) {
            $.ajax({
              url: "{{ route('ajax.get-karyawan') }}",
              method : 'POST',
              data: {
                'name': request.term,'_token' : $("meta[name='csrf-token']").attr('content')
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


    $('.add-finance').click(function(){
        $('#modal_finance').modal('show');
    });
    $('#add_modal_finance').click(function(){
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-training-finance') }}',
            data: {'id' : $('.modal_finance_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });

    $('.add-hrd').click(function(){
        $('#modal_hrd').modal('show');
    });
    $('#add_modal_hrd').click(function(){
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-training-hrd') }}',
            data: {'id' : $('.modal_hrd_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });


    $('.add-ga-department').click(function(){
        $('#modal_ga_department').modal('show');
    });
    $('#add_modal_ga_department').click(function(){
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-training-ga-department-mengetahui') }}',
            data: {'id' : $('.modal_ga_department_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });
</script>
@endsection
@endsection

