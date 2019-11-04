@extends('layouts.administrator')

@section('title', 'Facilities')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage List of Asset</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{ route('administrator.asset.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD LIST OF ASSET</a>
                <a href="{{ route('administrator.asset-tracking.index') }}" class="btn btn-info btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-history"></i> ASSET TRACKING</a>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">List of Asset</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <form method="GET">
                        <div class="col-md-2" style="padding-left: 0;">
                            <select name="asset_type_id" class="form-control">
                                <option value="">- Asset Type -</option>
                                @foreach(asset_type() as $i)
                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="col-md-2">
                            <select name="asset_condition" class="form-control">
                                <option value="">- Asset Condition -</option>
                                <option value="Good">Good</option>
                                <option value="Malfunction">Malfunction</option>
                                <option value="Lost">Lost</option>
                            </select>  
                        </div>
                        <div class="col-md-2">
                            <select name="assign_to" class="form-control">
                                <option value="">- Assign To -</option>
                                <option>Employee</option>
                                <option>Office Facility</option>
                                <option>Office Inventory/idle</option>
                            </select>  
                        </div>
                        <div class="col-md-2" style="padding-left:0;">
                            <button type="submit" class="btn btn-info ">Filter</button>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                    </form>
                    <hr style="margin-top:0;margin-bottom:6px;" />
                    <div class="table-responsive">
                                <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="70" class="text-center">#</th>
                                            <th>ASSET NUMBER</th>
                                            <th>ASSET NAME</th>
                                            <th>ASSET TYPE</th>
                                            <th>SERIAL/PLAT NUMBER</th>
                                            <th>PURCHASE/RENTAL DATE</th>
                                            <th>ASSET CONDITION</th>
                                            <th>STATUS ASSET</th>
                                            <th colspan="2">PIC / STATUS</th>
                                            <th>HANDOVER DATE</th>
                                            <th>STATUS</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $no => $item)
                                            <tr>
                                                <td class="text-center">{{ $no+1 }}</td>   
                                                <td>{{ $item->asset_number }}</td>
                                                <td>{{ $item->asset_name }}</td>
                                                <td>{{ isset($item->asset_type->name) ? $item->asset_type->name : ''  }}</td>
                                                <td>{{ $item->asset_sn }}</td>
                                                <td>{{ format_tanggal($item->purchase_date) }}</td>
                                                <td>{{ $item->asset_condition }}</td>
                                                <td>{{ $item->assign_to }}</td>
                                                <td>{{ isset($item->user->name) ? $item->user->name : '' }}
                                                </td>
                                                <td>
                                                     @if(isset($item->user->resign_date))
                                                        <label class="btn btn-danger btn-xs" style="text-align: center;" title="{{$item->user->resign_date}}">R</label>
                                                    @endif
                                                </td>
                                                <td>{{ $item->handover_date != "" ?  format_tanggal($item->handover_date) : '' }}</td>
                                                <td>
                                                    @if($item->handover_date === NULL)
                                                        <label class="btn btn-warning btn-xs">Waiting Acceptance</label>
                                                    @endif

                                                    @if($item->handover_date !== NULL)
                                                        <label class="btn btn-success btn-xs">Accepted</label>
                                                    @endif                                                  
                                                </td>
                                                <td>
                                                    <a href="{{ route('administrator.asset.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
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
