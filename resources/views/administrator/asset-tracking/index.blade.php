@extends('layouts.administrator')

@section('title', 'Asset Tracking')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage List of Asset Tracking</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Asset Tracking</li>
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
                    
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>ASSET NUMBER</th>
                                    <th>ASSET NAME</th>
                                    <th>ASSET TYPE</th>
                                    <th>SN</th>
                                    <th>PURCHASE DATE</th>
                                    <th>ASSET CONDITION</th>
                                    <th>ASSIGN TO</th>
                                    <th>EMPLOYEE</th>
                                    <th>HANDOVER DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    @if(!isset($item->asset->asset_number))
                                        {{ $item->delete() }}
                                        <?php continue; ?>
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>   
                                        <td>{{ $item->asset->asset_number }}</td>
                                        <td>{{ $item->asset_name }}</td>
                                        <td>{{ isset($item->asset_type->name) ? $item->asset_type->name : ''  }}</td>
                                        <td>{{ $item->asset_sn }}</td>
                                        <td>{{ format_tanggal($item->purchase_date) }}</td>
                                        <td>{{ $item->asset_condition }}</td>
                                        <td>{{ $item->assign_to }}</td>
                                        <td>{{ isset($item->user->name) ? $item->user->name : '' }}</td>
                                        <td>{{ $item->handover_date != "" ?  format_tanggal($item->handover_date) : '' }}</td>
                                       
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
