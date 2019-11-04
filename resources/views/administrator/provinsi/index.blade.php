@extends('layouts.administrator')

@section('title', 'Province')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Province</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            
                @if(\Auth::user()->project_id == 1)
                <a href="javascript:void(0)" id="form_add_modal" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD</a>
                @endif  
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Province</li>
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
                                    <th>PROVINCE</th>
                                    <th>ALLOWANCE LEVEL</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>   
                                        <td>{{ $item->nama }}</td>
                                        <td>{{getTypeProvinsi($item->id_prov)}}</td>
                                        <td>
                                             <a href="javascript:void(0)" class="btn btn-info btn-xs" style="float: left; margin-right:5px" data-url="{{ route('administrator.provinsi.update', $item->id_prov) }}" data-nama="{{ $item->nama }}" data-type="{{getTypeProvinsi($item->id_prov)}}" onclick="edit_modal(this)"><i class="fa fa-edit"></i> edit </a>
                                             @if(\Auth::user()->project_id == 1)
                                            <form action="{{ route('administrator.provinsi.destroy', $item->id_prov) }}" method="post" style="margin-left: 5px;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="confirm_delete('Delete this data ?', this)" class="text-danger"><i class="ti-trash"></i> delete </a>
                                            </form> 
                                            @endif
                                           
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

<div id="modal_provinsi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Province</h4> </div>
                <form method="POST" class="form-horizontal" action="{{ route('administrator.provinsi.store') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">Name</label>
                            <div class="col-md-9">
                                <input type="text" name="nama" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Level</label>
                            <div class="col-md-9">
                                <select class="form-control" name="type">
                                    @foreach(get_plafond_type() as $item)
                                    <option>{{ $item }}</option>
                                    @endforeach
                                </select>
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

<div id="modal_edit_provinsi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Province</h4> </div>
                <form method="POST" class="form-horizontal" id="form-modal-edit" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">Name</label>
                            <div class="col-md-9">
                            @if(\Auth::user()->project_id != 1)
                                <input type="text" name="nama" class="form-control" readonly />
                            @else
                                <input type="text" name="nama" class="form-control" />
                            @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Level</label>
                            <div class="col-md-9">
                                <select class="form-control" name="type">
                                    @foreach(get_plafond_type() as $item)
                                    <option >{{ $item }}</option>
                                    @endforeach
                                </select>
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
        $("#modal_edit_provinsi").modal("show");
        $("#form-modal-edit").attr('action', $(el).data('url'));
        $("#form-modal-edit input[name='nama']").val($(el).data('nama'));
        $("#form-modal-edit select[name='type']").val($(el).data('type'));
    }

    $("#form_add_modal").click(function(){
        $('#modal_provinsi').modal("show");
    });
</script>
@endsection
@endsection