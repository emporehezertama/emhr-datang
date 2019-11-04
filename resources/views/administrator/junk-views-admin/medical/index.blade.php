@extends('layouts.administrator')

@section('title', 'Medical Reimbursement')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title" style="overflow: inherit;">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Medical Reimbursement</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <form method="POST" action="{{ route('administrator.training.index') }}" id="filter-form">
                    {{ csrf_field() }}
                    <div style="padding-left:0; float: right;">
                        <div class="btn-group m-l-10 m-r-10 pull-right">
                            <a href="javascript:void(0)" aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">Action 
                                <i class="fa fa-gear"></i>
                            </a>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="javascript:void(0)" onclick="submit_filter_download()"><i class="fa fa-download"></i> Download Excel</a></li>
                            </ul>
                        </div>
                        <button type="button" id="filter_view" class="btn btn-default btn-sm pull-right btn-outline"><i class="fa fa-search-plus"></i></button>
                    </div>
                    <div class="col-md-2" style="padding-left:0; float: right;">
                        <div class="form-group m-b-0">
                            <select class="form-control  form-control-line" name="jabatan">
                                <option value="">- Position - </option>
                                <option {{ (request() and request()->jabatan == 'Staff') ? 'selected' : '' }}>Staff</option>
                                <option {{ (request() and request()->jabatan == 'Manager') ? 'selected' : '' }}>Manager</option>
                                <option {{ (request() and request()->jabatan == 'Direktur') ? 'selected' : '' }}>Director</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2" style="padding-left:0; float: right;">
                        <div class="form-group m-b-0">
                            <select class="form-control form-control-line" name="employee_status">
                                <option value="">- Employee Status - </option>
                                <option {{ (request() and request()->employee_status == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                <option {{ (request() and request()->employee_status == 'Contract') ? 'selected' : '' }}>Contract</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="view">
                </form>
            </div>
            <!-- /.col-lg-12 -->
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
                                    <th>NIK</th>
                                    <th>EMPLOYEE NAME</th>
                                    <th>POSITION</th>
                                    <th>CLAIM DATE</th>
                                    <th>STATUS</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <?php if(!isset($item->user->name)) { continue; } ?>
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td> 
                                        <td>{{ $item->user->nik }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ empore_jabatan($item->user->id) }}</td>
                                        <td>{{ date('d F Y', strtotime($item->tanggal_pengajuan)) }}</td>
                                        <td>
                                            <a onclick="status_approval_medical({{ $item->id }})"> 
                                            {!! status_medical($item->status) !!}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('administrator.medical.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> detail</button></a>
                                            <form action="{{ route('administrator.medical.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')" method="post">
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
@section('footer-script')
<script type="text/javascript">
    $("#filter_view").click(function(){
        $("#filter-form input[name='action']").val('view');
        $("#filter-form").submit();

    });

    var submit_filter_download = function(){
        $("#filter-form input[name='action']").val('download');
        $("#filter-form").submit();
    }
</script>
@endsection
@endsection