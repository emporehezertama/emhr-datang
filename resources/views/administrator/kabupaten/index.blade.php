@extends('layouts.administrator')

@section('title', Lang::get('setting.city'))

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">@lang('setting.city')</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="javascript:void(0)" id="form_add_modal" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> @lang('general.add')</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">@lang('setting.city')</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>@lang('setting.provinsi')</th>
                                    <th>@lang('setting.city')</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>   
                                        <td>{{ isset($item->provinsi->nama) ? $item->provinsi->nama : '' }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-info btn-xs" style="float: left; margin-right:5px"data-url="{{ route('administrator.kabupaten.update', $item->id_kab) }}" data-id_prov="{{ $item->id_prov }}" data-nama="{{ $item->nama }}" onclick="edit_modal(this)"><i class="fa fa-edit"></i> edit </a>

                                            <form action="{{ route('administrator.kabupaten.destroy', $item->id_kab) }}" method="post" style="margin-left: 5px;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="confirm_delete('Delete this data ?', this)" class="text-danger"><i class="ti-trash"></i> delete </a>
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
    </div>
    @include('layouts.footer')
</div>

<div id="modal_kabupaten" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">City</h4> </div>
                <form method="POST" class="form-horizontal" action="{{ route('administrator.kabupaten.store') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">@lang('setting.provinsi')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="provinsi_id">
                                    <option value="">@lang('setting.select-provinsi')</option>
                                    @foreach(get_provinsi() as $item)
                                    <option value="{{ $item->id_prov }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Name</label>
                            <div class="col-md-9">
                                <input type="text" name="nama" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_edit_kabupaten" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">City</h4> </div>
                <form method="POST" class="form-horizontal" id="form-modal-edit" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">@lang('setting.provinsi')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="provinsi_id">
                                    <option value="">@lang('setting.select-provinsi')</option>
                                    @foreach(get_provinsi() as $item)
                                    <option value="{{ $item->id_prov }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Name</label>
                            <div class="col-md-9">
                                <input type="text" name="nama" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('js')
<script type="text/javascript">
    function edit_modal(el)
    {
        $("#modal_edit_kabupaten").modal("show");
        $("#form-modal-edit").attr('action', $(el).data('url'));
        $("#form-modal-edit input[name='nama']").val($(el).data('nama'));
        $("#form-modal-edit select[name='provinsi_id']").val($(el).data('id_prov'));
    }

    $("#form_add_modal").click(function(){
        $('#modal_kabupaten').modal("show");
    });
</script>
@endsection
@endsection
