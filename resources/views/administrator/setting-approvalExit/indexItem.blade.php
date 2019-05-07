@extends('layouts.administrator')

@section('title', 'Setting Approval Exit Interview & Clearance')

@section('sidebar')

@endsection

@section('content')
<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-md-6">
                <h4 class="page-title">Setting Approval Exit Interview & Clearance</h4> </div>
            <div class="col-md-6">
               <a href="{{ route('administrator.setting-approvalExit.createItem', ['id' => $data->id]) }}" class="btn btn-sm btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD APPROVAL</a>
                <a href="{{ route('administrator.setting-approvalExit.index') }}" class="btn btn-sm btn-default pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-arrow-left"></i> BACK</a>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>LEVEL</th>
                                    <th>POSITION APPROVAL</th>
                                    <th>DESCRIPTION</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataItem as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $item->ApprovalLevel->name }}</td>
                                        <td>{{ isset($item->structureApproval->position) ? $item->structureApproval->position->name:''}}{{ isset($item->structureApproval->division) ? '-'. $item->structureApproval->division->name:''}}
                                    </td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <a href="{{ route('administrator.setting-approvalExit.editItem', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> edit</button></a>
                                            
                                            <form action="{{ route('administrator.setting-approvalExit.destroyItem',['id' => $item->id])}}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                                {{ csrf_field() }}                                              
                                                <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> Delete</button>
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
@endsection

