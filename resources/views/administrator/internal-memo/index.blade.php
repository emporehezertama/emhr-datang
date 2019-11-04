@extends('layouts.administrator')

@section('title', 'Internal Memo')

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
                <h4 class="page-title">Manage Internal Memo</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('administrator.internal-memo.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD INTERNAL MEMO</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Internal Memo / Info Marketing</li>
                </ol>
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
                                    <th width="70" class="text-center">#</th>
                                    <th>TITLE</th>
                                    <th>FILE</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        @if(!empty($item->file))
                                            <a href="{{ asset('storage/internal-memo/'.$item->file) }}" target="_blank"><i class="fa fa-link"></i></a></td>
                                        @else
                                            <label><i>empty</i></label>
                                        @endif
                                    <td>{{ $item->created_at }}</td>
                                    <td>{!! $item->status == 1 ? '<label class="btn btn-success btn-xs">Publish</label>' : '<label class="btn btn-danger btn-xs">Draft</label>' !!}</td>
                                    
                                    <td>
                                        <a href="{{ route('administrator.internal-memo.edit', ['id' => $item->id]) }}" style="float: left; margin-right:5px"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                            <form action="{{ route('administrator.internal-memo.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="margin-left: 5px;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete </button>
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
@endsection
