@extends('layouts.karyawan')

@section('title', 'Find Karyawan - PT. Arthaasia Finance')

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
                <h4 class="page-title">Dashboard</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Find Karyawan</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Find Karyawan</h3>
                    <br />
                    <form method="GET" action="">
                        <div class="form-group">
                            <div class="col-md-2" style="padding-left:0">
                                <input type="text" name="name" placeholder="Nama" class="form-control" value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">   
                            </div>
                            <div class="col-md-2" style="padding-left:0">
                                <input type="text" name="nik" placeholder="NIK" class="form-control" value="{{ isset($_GET['nik']) ? $_GET['nik'] : '' }}">   
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm">FIND</button>
                    </form>
                    <div class="clearfix"></div>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap"  cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>TELEPON</th>
                                    <th>EMAIL</th>
                                    <th>DEPARTMENT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->telepon }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ (isset($item->department->name) ? $item->department->name : '') }}</td>
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