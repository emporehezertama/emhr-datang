@extends('layouts.administrator')

@section('title', 'Overtime Sheet')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title hidden-xs hidden-sm">Manage Overtime</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('administrator.overtime-custom.create') }}" class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light"> <i class="fa fa-plus"></i> ADD OVERTIME</a>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>OVERTIME SUBMISSION</th>
                                    <th>SUBMISSION STATUS</th>
                                    <th>CLAIM STATUS</th>
                                    <th>#</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>    
                                        <td>{{ date('d F Y', strtotime($item->created_at))}}</td>
                                        <td>
                                            <a href="javascript:;" onclick="detail_approval_overtimeCustom({{ $item->id }})"> 
                                                {!! status_overtime($item->status) !!}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" onclick="detail_approval_overtimeClaimCustom({{ $item->id }})"> 
                                                {!! status_overtime($item->status_claim) !!}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('administrator.overtime-custom.edit', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> detail</a>
                                        </td>
                                        <td>
                                            @if($item->status == 2)
                                                @if(empty($item->status_claim) or $item->status_claim < 1)
                                                    <a href="{{ route('administrator.overtime-custom.claim', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-book"></i> claim</a>
                                                @else
                                                    @if($item->status_claim >= 1)
                                                    <a href="{{ route('administrator.overtime-custom.claim', $item->id) }}">
                                                    <label class="btn btn-info btn-xs"><i class="fa fa-search-plus"></i> claimed detail</label></a>
                                                    @endif

                                                @endif
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
<!-- sample modal content -->
<div id="modal_detail_overtime" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">DETAIL OVERTIME</h4>
            </div>
            <div class="modal-body">
                <form method="POST" class="form_ahli_waris" action=""> </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@section('footer-script')
<script type="text/javascript">
    function modal_detail_overtime(id)
    {
        $("#modal_detail_overtime").modal('show');
    }
</script>
@endsection
@endsection