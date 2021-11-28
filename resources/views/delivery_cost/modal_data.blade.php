<input type="hidden" class="edit_delivery_cost_id" value="{{$cost_data->id}}">

<div class="form-group">
    <label for="">Cost</label>
    <input name="edit_cost" type="text" class="form-control edit_cost" value="{{$cost_data->cost}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter value">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Currency</label>
    <select name="edit_currency" class="form-control edit_currency">
        <option value="">Please select currency</option>
        @foreach($currency_id as $currency)
            <option value="{{$currency->id}}" @if($currency->id == $cost_data->currency_id) selected @endif>{{$currency->name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Start Range</label>
    <input name="edit_start_range" type="text" class="form-control edit_start_range" value="{{$startRange}}" placeholder="Enter value">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">End Range</label>
    <input name="edit_end_range" type="text" class="form-control edit_end_range" value="{{$endRange}}" placeholder="Enter value">
</div>


