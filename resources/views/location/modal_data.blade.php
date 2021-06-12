<input type="hidden" class="edit_location_id" value="{{$location_data->id}}">

<div class="form-group">
    <label for="exampleInputEmail1">City</label>
    <select name="edit_city_id" class="form-control edit_city_id">
        <option value="">Please select city</option>
        @foreach($cities as $city)
            <option value="{{$city->id}}" @if($city->id ==  $location_data->city_id) selected @endif >{{$city->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Location Name</label>
    <input name="edit_location_name" type="text" value="{{$location_data->name}}" class="form-control edit_location_name" placeholder="Enter Location Name">
</div>