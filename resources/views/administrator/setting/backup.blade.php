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
                            <label class="col-md-5">Email Notifikasi</label>
                            <label class="col-md-5">Backup Type</label>
                            <div class="col-md-5">
                                <input type="email" class="form-control" name="setting[backup_mail]" value="{{ get_setting('backup_mail') }}" />
                            </div>
                            <div class="col-md-5">
                                <select class="form-control" name="setting[backup_type]">
                                    <option value="0"> - Select Type Backup - </option>
                                    <option value="1" {{ get_setting('backup_type') == 1 ? 'selected' : '' }}>All Apps & Database</option>
                                    <option value="2" {{ get_setting('backup_type') == 2 ? 'selected' : '' }}>Database Only</option>
                                    <option value="3" {{ get_setting('backup_type') == 3 ? 'selected' : '' }}>Apps Only</option>
                                </select>
                            </div>
                        </div>
                     
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-2 p-l-0">
                                    <label class="m-r-0">Schedule Backup</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="m-r-10"><input type="radio" value="3" name="setting[schedule]" {{ get_setting('schedule') == 3 ? 'checked' : '' }} /> Nightly / Daily</label>
                                    <label class="m-r-10"><input type="radio" value="4" name="setting[schedule]" {{ get_setting('schedule') == 4 ? 'checked' : '' }} /> Weekly</label>
                                    <label class="m-r-10"><input type="radio" value="5" name="setting[schedule]" {{ get_setting('schedule') == 5 ? 'checked' : '' }} /> Monthly</label>
                                    <div class="">
                                        <input type="text" class="form-control datepicker" name="setting[schedule_custom_date]" value="{{ get_setting('schedule_custom_date') }}" placeholder="Custom Date">
                                    </div>
                                </div>
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
@endsection
