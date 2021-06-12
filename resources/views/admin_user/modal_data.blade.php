<input type="hidden" class="edit_admin_id" value="{{$admin_data->id}}">

<div class="form-group">
    <label for="">Role</label>
    <select name="edit_role_id" class="form-control edit_role_id">
        <option value="">Please select role</option>
        @foreach($roles as $role)
            <option value="{{$role->id}}" @if($role->id == $admin_data->role_id) selected @endif>{{$role->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Shop</label>
    <select name="edit_shop_id" class="form-control edit_shop_id">
        <option value="">Please select shop</option>
        @foreach($shops as $shop)
            <option value="{{$shop->id}}" @if($shop->id == $admin_data->shop_id) selected @endif>{{$shop->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input name="edit_name" type="text" value="{{$admin_data->name}}" class="form-control edit_name" placeholder="Enter Name">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Password</label>
    <input name="edit_password" type="text" value="{{$admin_data->password}}" class="form-control edit_password" placeholder="Enter password">
</div>
{{--<div class="form-group">--}}
{{--    <label for="exampleInputEmail1">Salt</label>--}}
{{--    <input name="edit_salt" type="text" value="{{$admin_data->salt}}" class="form-control edit_salt" placeholder="Enter salt">--}}
{{--</div>--}}