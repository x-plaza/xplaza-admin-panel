<input type="hidden" class="edit_city_id" value="{{$city_data->id}}">

<div class="form-group">
    <label for="exampleInputEmail1">State</label>
    <select name="edit_state_id" class="form-control edit_state_id">
        <option value="">Please select state</option>
        @foreach($states as $state)
            <option value="{{$state->id}}" @if($state->id ==  $city_data->state_id) selected @endif>{{$state->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">City Name</label>
    <input name="edit_city_name" type="text" value="{{$city_data->name}}" class="form-control edit_city_name" placeholder="Enter City Name">
</div>