<input type="hidden" class="edit_shop_id" value="{{$shop_data->id}}">
<div class="form-group">
    <label for="">Location</label>
    <select name="edit_location_id" class="form-control edit_location_id">
        <option value="">Please select location</option>
        @foreach($locations as $location)
            <option value="{{$location->id}}" @if($location->id == $shop_data->location_id) selected @endif>{{$location->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Shop Name</label>
    <input name="edit_shop_name" value="{{$shop_data->name}}" type="text" class="form-control edit_shop_name" placeholder="Enter Shop Name">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Owner name</label>
    <input name="edit_owner" type="text" value="{{$shop_data->owner}}" class="form-control edit_owner" placeholder="Enter owner Name">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Address</label>
    <textarea name="edit_shop_address" class="form-control edit_shop_address">{{$shop_data->address}}</textarea>
</div>