<input type="hidden" class="edit_delivery_schedule_id" value="{{$schedule_data->delivery_schedule_id}}">

<div class="form-group">
    <label for="exampleInputEmail1">Day name</label>
    <select name="day" class="form-control edit_day">
        <option value="">Please select day</option>
        @foreach($day_id as $day)
            <option value="{{$day->id}}" @if($day->id == $schedule_data->day_id) selected @endif>{{$day->name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Start Time</label>
    <select name="st_time" class="form-control edit_st_time">
        <option value="">Please select start time</option>
        @foreach($res as $st_time)
            <option value="{{$st_time}}" @if($st_time == $schedule_data->delivery_schedule_start) selected @endif>{{$st_time}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">End Time</label>
    <select name="end_time" class="form-control edit_end_time">
        <option value="">Please select end time</option>
        @foreach($res as $st_time)
            <option value="{{$st_time}}" @if($st_time == $schedule_data->delivery_schedule_end) selected @endif>{{$st_time}}</option>
        @endforeach
    </select>
</div>


