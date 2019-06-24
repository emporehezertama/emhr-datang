@extends('layouts.administrator')

@section('title', 'Setting Approval Training')

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
                <h4 class="page-title">Setting Approval Training</h4> </div>
            <div class="col-md-6">
               <a href="{{ route('administrator.setting-approvalTraining.createItem', ['id' => $data->id]) }}" class="btn btn-sm btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD APPROVAL</a>
                <a href="{{ route('administrator.setting-approvalTraining.index') }}" class="btn btn-sm btn-default pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-arrow-left"></i> BACK</a>
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
                                            <a href="{{ route('administrator.setting-approvalTraining.editItem', ['id' => $item->id]) }}" style="float: left; margin-right:5px"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                            
                                            <form action="{{ route('administrator.setting-approvalTraining.destroyItem',['id' => $item->id])}}" onsubmit="return confirm('Delete this data?')" method="post" style="margin-left: 5px;">
                                                {{ csrf_field() }}                                              
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

