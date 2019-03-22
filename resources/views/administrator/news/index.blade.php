@extends('layouts.administrator')

@section('title', 'News')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage News</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('administrator.news.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD NEWS</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">News</li>
                </ol>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="data_table_no_pagging" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>TITLE</th>
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
                                    <td>{{ $item->created_at }}</td>
                                    <td>{!! $item->status == 1 ? '<label class="btn btn-success btn-xs">Publish</label>' : '<label class="btn btn-danger btn-xs">Draft</label>' !!}</td>
                                    <td>
                                        <a href="{{ route('administrator.news.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> edit</button></a>
                                            <form action="{{ route('administrator.news.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete</button>
                                            </form>
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                        <div class="col-m-6 pull-left text-left">Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries</div>
                        <div class="col-md-6 pull-right text-right">{{ $data->appends($_GET)->render() }}</div><div class="clearfix"></div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    @include('layouts.footer')
</div>
@endsection
