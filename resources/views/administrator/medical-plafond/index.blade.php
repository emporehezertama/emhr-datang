@extends('layouts.administrator')

@section('title', 'Medical Plafond')

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
                <h4 class="page-title">Setting Medical Plafond</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Medical Plafond</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                     <ul class="nav customtab nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#type" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Type </span></a></li>
                        <li role="presentation" class=""><a href="#plafond" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs"> Plafond</span></a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="type">
                            <h3 class="box-title m-b-0">Setting for Medical Type</h3>
                            <a href="{{ route('administrator.medical-plafond.create') }}" class="btn btn-success btn-sm  hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD</a>
                            <br />
                            <div class="table-responsive">
                                <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAME</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($type as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ $item->name}}</td>
                                            <td>
                                                    <a href="{{ route('administrator.medical-plafond.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                                    <form action="{{ route('administrator.medical-plafond.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
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
                        <div role="tabpanel" class="tab-pane fade" id="plafond">
                            <h3 class="box-title m-b-0">Setting for Medical Plafond</h3>
                            <a href="{{route('administrator.medical-plafond.create-medical-plafond')}}" class="btn btn-success btn-sm  hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD</a>
                            <br />
                            <div class="table-responsive">
                                <table id="data_table2_no_search" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>POSITION</th>
                                            <th>TYPE</th>
                                            <th>NOMINAL</th>
                                            <th>DESCRIPTION</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($plafond as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ isset($item->medicalType) ? $item->medicalType->name :'' }}</td>
                                            <td>{{ isset($item->position) ? $item->position->name :'' }}</td>
                                            <td>{{ number_format($item->nominal) }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                    <a href="{{ route('administrator.medical-plafond.edit-medical-plafond', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                                    <a href="{{ route('administrator.medical-plafond.destroy-medical-plafond', ['id' => $item->id]) }}"> <button class="btn btn-danger btn-xs m-r-5"><i class="fa fa-trash"></i> delete</button></a>
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
        </div>
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
@section('footer-script')
<script type="text/javascript">
    $("#btn_import").click(function(){

        $("#form-upload").submit();
        $("#form-upload").hide();
        $('.div-proses-upload').show();
    });

    $("#add-import-karyawan").click(function(){
        $("#modal_import").modal("show");
        $('.div-proses-upload').hide();
        $("#form-upload").show();
    })
</script>
@endsection

@endsection
