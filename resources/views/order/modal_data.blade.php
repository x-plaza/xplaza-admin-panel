<input type="hidden" class="edit_category_id" value="{{$category_data->id}}">
<div class="form-group">
    <label for="exampleInputEmail1">Parent Category</label>
    <select name="edit_parent_category" class="form-control edit_parent_category">
        <option value="">Please select parent</option>
        @foreach($categories as $category)
            <option value="{{$category->id}}" @if($category->id ==  $category_data->parent_category_id) selected @endif>{{$category->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Category Name</label>
    <input name="edit_category_name" type="text" value="{{$category_data->name}}" class="form-control edit_category_name" placeholder="Enter Category Name">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Description</label>
    <textarea name="edit_description" class="form-control edit_description">{{$category_data->description}}</textarea>
</div>