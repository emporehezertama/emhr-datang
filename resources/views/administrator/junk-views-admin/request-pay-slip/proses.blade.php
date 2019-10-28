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
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" id="form_payment" method="POST" action="{{ route('administrator.request-pay-slip.submit', $datamaster->id) }}">
                <div class="col-md-12 p-l-0 p-r-0">
                    <div class="white-box">
                        <br />
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
                        <div class="col-md-4" style="padding-left: 0;">
                            <div class="form-group">
                                <label class="col-md-12">NIK / Name</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" value="{{ $data->user->nik }} - {{ $data->user->name }}" readonly="true" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="col-md-4" style="padding-left: 0;">
                            <div class="form-group">
                                <label class="col-md-12">Year</label>
                                <div class="col-md-12">
                                    <input type="text" name="tahun" class="form-control" value="{{ $data->tahun }}" readonly="true" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-12">Month</label>
                                <div class="col-md-10 item-bulan">
                                    <?php  $bulanArray = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Augustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];?>

                                    @foreach($dataArray as $i)
                                        <input type="checkbox" checked="true" /> {{ $bulanArray[$i->bulan] }}<br />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6" style="padding-left: 0;">
                            <div class="form-group">
                                <label class="col-md-12">Note</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="note"  {{ $datamaster->status == 2 ? 'readonly' : '' }}>{{ $datamaster->note }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <br />
                        <a href="{{ route('administrator.request-pay-slip.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        @if($datamaster->status == 1)
                        <button type="submit" class="btn btn-info btn-sm">Proses and Send</button>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
    </div>
    <!-- /.container-fluid -->
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
                        el += '<input type="checkbox" value="'+ v.id +'" name="bulan[]" /> '+ v.name +'<br />';
                        el += '<input type="checkbox" value="2" name="bulan[]" /> Februari <br />';

                    });

                    $('.item-bulan').html(el);
                }
            });
        }
    });
</script>

@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
