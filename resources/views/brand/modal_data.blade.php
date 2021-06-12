<input type="hidden" class="edit_brand_id" value="{{$brand_data->id}}">
<div class="form-group">
    <label for="exampleInputEmail1">Brand Name</label>
    <input name="edit_brand_name" type="text" value="{{$brand_data->name}}" class="form-control edit_brand_name" placeholder="Enter Brand Name">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Description</label>
    <textarea name="edit_description" class="form-control edit_description">{{$brand_data->description}}</textarea>
</div>