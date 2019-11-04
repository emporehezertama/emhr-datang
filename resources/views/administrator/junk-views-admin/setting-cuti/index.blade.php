@extends('layouts.administrator')

@section('title', 'Setting Approval Cuti / Izin Karyawan')

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
                <h4 class="page-title">Setting Approval Cuti / Izin Karyawan</h4> </div>
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
            <div class="col-md-6">
                <div class="white-box">
                    <h3 class="box-title m-b-0 pull-left">Approval Personalia</h3>
                    <a class="btn btn-info btn-xs pull-right add-personalia"><i class="fa fa-plus"></i> Tambah</a>
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
                                @foreach($personalia as $no =>  $item)
                                <tr>
                                    <td>{{ ($no + 1) }}</td>
                                    <td>{{ isset($item->user->name) ? $item->user->nik .' / '. $item->user->name : '' }}</td>
                                    <td>{{ isset($item->user->organisasi_job_role) ? $item->user->organisasi_job_role : '' }}</td>
                                    <td>
                                        <form action="{{ route('administrator.setting-cuti.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')" method="post" style="float: left;">
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
<div id="modal_personalia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <input type="text" class="form-control autocomplete-karyawan" />
                                <input type="hidden" class="modal_personalia_id">
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_personalia">Tambah</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- sample modal content -->
<div id="modal_atasan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Approval Atasan</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                            <label class="col-md-3">Pilih </label>
                            <div class="col-md-6">
                                <select class="form-control modal_atasan_id">
                                    <option value="">Pilih </option>
                                    @foreach(get_karyawan() as $item)
                                    <option value="{{ $item->id }}" data-kelamin="{{ $item->jenis_kelamin }}">{{ $item->nik }} / {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                       </div>
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="add_modal_atasan">Tambah</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

    $(".autocomplete-karyawan" ).autocomplete({
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
            $( ".modal_personalia_id" ).val(ui.item.id);
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });

    $('.add-atasan').click(function(){
        $('#modal_atasan').modal('show');
    });

    $('#add_modal_atasan').click(function(){

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-cuti-atasan') }}',
            data: {'id' : $('.modal_atasan_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });

    $('.add-personalia').click(function(){
        $('#modal_personalia').modal('show');
    });

    $('#add_modal_personalia').click(function(){

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.add-setting-cuti-personalia') }}',
            data: {'id' : $('.modal_personalia_id').val(), '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {
                location.reload();
            }
        });
    });
</script>
<style type="text/css">
    .ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front {
        z-index: 9999;
    }
</style>
@endsection

@endsection
