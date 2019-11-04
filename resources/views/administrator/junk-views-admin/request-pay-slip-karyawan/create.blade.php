@extends('layouts.karyawan')

@section('title', 'Request Pay Slip')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Request Pay Slip</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Request Pay Slip</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" id="form_payment" enctype="multipart/form-data" action="{{ route('karyawan.request-pay-slip.store') }}" method="POST">
                <div class="col-md-12 p-l-0 p-r-0">
                    <div class="white-box">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        {{ csrf_field() }}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-12">Choose Year</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="tahun">
                                        <option value="">- Year -</option>
                                        @foreach(pay_slip_tahun_history(\Auth::user()->id) as $i)
                                            <option>{{ $i->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 bulan" style="display: none;">
                            <div class="form-group">
                                <label class="col-md-12">Choose Month</label>
                                <div class="col-md-10 item-bulan">

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <br />
                        <a href="{{ route('karyawan.request-pay-slip.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="submit_payment"><i class="fa fa-save"></i> Submit Request</button>
                        <br style="clear: both;" />
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
    </div>
    @include('layouts.footer')
</div>
@section('footer-script')
<script type="text/javascript">
    $("select[name='tahun']").on('change', function(){

        var tahun = $(this).val();

        if($(this).val() != "")
        {
            $(".bulan").show("slow");

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-bulan-pay-slip') }}',
                data: {'tahun': tahun, 'user_id': {{ \Auth::user()->id }}, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    var el = '';
                    console.log(data);
                    $.each(data, function(k, v){
                        el += '<label><input type="checkbox" value="'+ v.id +'" name="bulan[]" /> '+ v.name +'</label> &nbsp; ';

                    });

                    $('.item-bulan').html(el);
                }
            });
        }
    });
</script>
@endsection
@endsection
