@extends('layouts.administrator')

@section('title', 'Asset')

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
                    <ul class="nav customtab nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#asset" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Asset</span></a></li>
                        <li role="presentation" class=""><a href="#mobil" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Car</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="mobil">
                            <div class="table-responsive">
                                <table id="data_table2" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="70" class="text-center">#</th>
                                            <th>ASSET NUMBER</th>
                                            <th>ASSET NAME</th>
                                            <th>ASSET TYPE</th>
                                            <th>CAR TYPE</th>
                                            <th>YEAR</th>
                                            <th>PLAT NUMBER</th>
                                            <th>CAR STATUS</th>
                                            <th>SN</th>
                                            <th>PURCHASE DATE</th>
                                            <th>ASSET CONDITION</th>
                                            <th>ASSIGN TO</th>
                                            <th>EMPLOYEE</th>
                                            <th>HANDOVER DATE</th>
                                            <th>STATUS</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $no => $item)
                                          @if(isset($item->asset_type->name) and strtoupper($item->asset_type->name) =='MOBIL')
                                            <tr>
                                                <td class="text-center">{{ $no+1 }}</td>   
                                                <td>{{ $item->asset_number }}</td>
                                                <td>{{ $item->asset_name }}</td>
                                                <td>{{ isset($item->asset_type->name) ? $item->asset_type->name : ''  }}</td>
                                                <td>{{ $item->tipe_mobil }}</td>
                                                <td>{{ $item->tahun }}</td>
                                                <td>{{ $item->no_polisi }}</td>
                                                <td>{{ $item->status_mobil }}</td>
                                                <td>{{ $item->asset_sn }}</td>
                                                <td>{{ format_tanggal($item->purchase_date) }}</td>
                                                <td>{{ $item->asset_condition }}</td>
                                                <td>{{ $item->assign_to }}</td>
                                                <td>{{ isset($item->user->name) ? $item->user->name : '' }}</td>
                                                <td>{{ $item->handover_date != "" ?  format_tanggal($item->handover_date) : '' }}</td>
                                                <td>
                                                    @if($item->status === NULL)
                                                        <label class="btn btn-warning btn-xs">Waiting Acceptance</label>
                                                    @endif

                                                    @if($item->status == 1)
                                                        <label class="btn btn-success btn-xs">Accepted</label>
                                                    @endif

                                                    @if($item->status == 2)
                                                        <label class="btn btn-warning btn-xs">Office Inventory</label>
                                                    @endif                                                  
                                                </td>
                                                <td>
                                                    <a href="{{ route('administrator.asset.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> edit</button></a>
                                                </td>
                                            </tr>
                                          @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane active" id="asset">
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
                                            <th>STATUS</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $no => $item)
                                          @if(isset($item->asset_type->name) and strtoupper($item->asset_type->name) !='MOBIL')
                                            <tr>
                                                <td class="text-center">{{ $no+1 }}</td>   
                                                <td>{{ $item->asset_number }}</td>
                                                <td>{{ $item->asset_name }}</td>
                                                <td>{{ isset($item->asset_type->name) ? $item->asset_type->name : ''  }}</td>
                                                <td>{{ $item->asset_sn }}</td>
                                                <td>{{ format_tanggal($item->purchase_date) }}</td>
                                                <td>{{ $item->asset_condition }}</td>
                                                <td>{{ $item->assign_to }}</td>
                                                <td>{{ isset($item->user->name) ? $item->user->name : '' }}</td>
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
                                                    <a href="{{ route('administrator.asset.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> edit</button></a>
                                                </td>
                                            </tr>
                                          @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
