@extends('layouts.administrator')

@section('title', 'Employee Attendance')

@section('content')        
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Attendance</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
               <form method="POST" action="">
                    <div class="pull-right text-right">
                        <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search-plus"></i> </button>
                    </div>
                    <div class="col-md-2 pull-right text-right">
                       <div class="form-group p-b-0 m-b-0">
                            <input type="text" name="" class="form-control" placeholder="Employee" />
                       </div>
                    </div>
                    <div class="col-md-3 pull-right text-right">
                        <div class="input-group" id="date-range">
                            <input type="text" placeholder="Start Date" id="startDate" class="form-control" name="start" value="" /> 
                            <span class="input-group-addon bg-info b-0 text-white">to</span>
                            <input type="text" placeholder="End Date" id="endDate" class="form-control" name="end" value="" />
                        </div>
                    </div>

                   <!--  <div class="col-md-2 pull-right text-right">
                       <div class="form-group p-b-0 m-b-0">
                            <select class="form-control" name="state">
                                <option> State </option>
                                <option value="0">Check in</option>
                                <option value="1">Check Out</option>
                            </select>
                       </div>
                    </div> -->

               </form>
            </div>
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12 p-l-0 p-r-0">
                <div class="white-box">
                    <table class="display nowrap data_table_no_pagging" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Planned Sign In </th>
                                <th>Planned Sign Out </th>
                                <th>Sign In</th>
                                <th>Sign Out</th>
                                <th>Different Time</th>
                                <th>Late Sign In</th>
                                <th>Early Sign Out</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $item)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ isset($item->user->name) ? $item->user->name : '' }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->timetable }}</td>
                            <td>{{ $item->on_dutty }}</td>
                            <td>{{ $item->off_dutty }}</td>
                            <td>{{ $item->clock_in }}</td>
                            <td>{{ $item->clock_out }}</td>
                            <td>{{ $item->work_time }}</td>
                            <td></td>
                            <td></td>
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
@section('js')

<script type="text/javascript">
$( "#startDate" ).datepicker({
    defaultDate: "+1w",
    dateFormat: 'yy/mm/dd',
    changeMonth: true,
    changeYear: true,
    onSelect: function( selectedDate ) {
        $( "#endDate" ).datepicker( "option", "minDate", selectedDate );
    }
});
$( "#endDate" ).datepicker({
    defaultDate: "+1w",
    dateFormat: 'yy/mm/dd',
    changeMonth: true,
    changeYear: true,
    onSelect: function( selectedDate ) {
        $( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
    }
});
</script>
@endsection
@endsection
