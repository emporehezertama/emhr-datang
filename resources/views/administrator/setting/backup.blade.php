@extends('layouts.administrator')

@section('title', 'Backup App & Database')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Backup App & Database</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
                <button type="button" class="btn btn-info" onclick="form_setting.submit()"><i class="fa fa-save"></i> Save Setting</button>
            </div>
        </div>
        <div class="row">
            <form class="form-horizontal" id="form-setting" autocomplete="off" name="form_setting" enctype="multipart/form-data" action="{{ route('administrator.setting.backup-save') }}" method="POST">
                {{ csrf_field() }}
                <div class="col-md-6 p-l-0">
                    <div class="white-box">
                        <div class="form-group">
                            <label class="col-md-2">Notification Email</label>
                            <div class="col-md-5">
                                <input type="email" class="form-control" name="setting[backup_mail]" value="{{ get_setting('backup_mail') }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-6 p-l-0">
                                    <h4>Schedule Backup</h4>
                                </div>
                                <table class="table table-stripped">
                                    <thead>
                                        <tr style="backgroud: #efefef;">
                                            <th>No</th>
                                            <th>Backup Type</th>
                                            <th>Time</th>
                                            <th>Recurring</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count(get_schedule_backup()) == 0)
                                            <tr>
                                                <td colspan="5" class="text-center"><i>empty</i></td>
                                            </tr>
                                        @endif
                                        @foreach(get_schedule_backup() as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if($item->backup_type == 1)
                                                        All Apps & Database
                                                    @elseif($item->backup_type == 2)
                                                        Database Only
                                                    @elseif($item->backup_type == 3)
                                                        Apps Only
                                                    @endif
                                                </td>
                                                <td>{{ $item->time }}</td>
                                                <td>
                                                    @if($item->recurring == 1)
                                                        Daily
                                                    @elseif($item->recurring == 2)
                                                        Weekly
                                                    @elseif($item->recurring == 3)
                                                        Monthly
                                                    @elseif($item->recurring == 4)
                                                        Custom
                                                    @endif
                                                </td>
                                                <td>{{ $item->date }}</td>
                                                <td>
                                                    <a href="{{ route('administrator.setting.delete-backup-schedule', $item->id) }}" onclick="return confirm('Delete this data?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <a href="javascript:void(0)" class="btn btn-info btn-sm btn-circle" title="Add Schedule Backup" data-toggle="modal" data-target="#modal_add_schedule_backup"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-6 p-l-0">
                <div class="white-box">
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Date</th>
                                <th>Used Storage</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php(rsort($data))
                        @foreach($data as $item)
                        <tr>
                            <td>
                                <form method="POST" action="{{ route('administrator.setting.backup-get') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="file" value="{{ $item }}">
                                    <a href="javascript:void(0)" class="text-danger" onclick="confirm_delete('Download File ?', this)">
                                        <i class="fa fa-download"></i> {{ $item }}
                                    </a>
                                </form>
                            </td>
                            <td>{{ date('d F Y H:i:s', Storage::lastModified($item)) }}</td>
                            <td>{{ floor(Storage::size($item) / 1000000) }} Mb</td>
                            <td>
                                <form method="POST" action="{{ route('administrator.setting.backup-delete') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="file" value="{{ $item }}">
                                    <a href="javascript:void(0)" class="text-danger" onclick="confirm_delete('Delete Files ?', this)"><i class="fa fa-trash"></i>
                                    </a>
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
    @include('layouts.footer')
</div>

<!-- sample modal content -->
<div class="modal fade" id="modal_add_schedule_backup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="{{ route('administrator.setting.store-backup-schedule') }}">
             {{ csrf_field() }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Schedule Backup</h4> </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-12">Backup Type</label>
                    <div class="col-md-12">
                        <select class="form-control backup_type" name="backup_type" required="">
                            <option value=""> - Select - </option>
                            <option value="1">All Apps & Database</option>
                            <option value="2">Database Only</option>
                            <option value="3">Apps Only</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-md-12">Time</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control time_picker" name="time" required/>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-md-12">Recurring</label>
                    <div class="col-md-12">
                        <select class="form-control" name="recurring" id="recurring" required>
                            <option value=""> - Select - </option>
                            <option value="1">Daily</option>
                            <option value="2">Weekly</option>
                            <option value="3">Monthly</option>
                            <option value="4">Custom</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group dateBackup" name="dateBackup" style="display: none;">
                    <label class="col-md-12">Date</label>
                    <div class="col-md-12">
                        <input type="text"class="form-control datepicker"  name="date" />
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect text-left btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success waves-effect btn-sm"><i class="fa fa-check-circle"></i> Submit Schedule</button>
            </div>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
</div>
<!-- /.modal -->

@section('js')
<style type="text/css">
    .clockpicker-popover{
        z-index: 99999 !important;
    }
</style>
<link href="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
<!-- Clock Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
<script type="text/javascript">

    $('.time_picker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $("select[name='recurring']").on('change', function(){
        var el = $(this).find(":selected");
        if($(this).val() == 4)
        {
            $('.dateBackup').show();   
        }else{
            $('.dateBackup').hide(); 
        }
    });

</script>
@endsection
@endsection
