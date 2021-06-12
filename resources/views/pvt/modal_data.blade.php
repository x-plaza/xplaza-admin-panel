<input type="hidden" class="edit_pvt_id" value="{{$pvt_info->id}}">

<div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input name="edit_pvt_name" value="{{$pvt_info->name}}" type="text" class="form-control edit_pvt_name" placeholder="Enter Name">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Description</label>
    <textarea name="edit_pvt_description" class="form-control edit_pvt_description">{{$pvt_info->description}}</textarea>
</div>
