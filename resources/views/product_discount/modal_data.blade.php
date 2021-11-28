<input type="hidden" class="edit_product_discount_id" value="{{$discount_data->id}}">

<div class="form-group">
    <label for="">Product</label>
    <select name="edit_product" class="form-control select2bs4 edit_product_id" style="width: 100%;height: 20px;">
        <option value="">Please select product</option>
        @foreach($productData as $product)
            <option value="{{$product->id}}" @if($product->id == $discount_data->product_id) selected @endif>{{$product->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Currency</label>
    <select name="edit_currency" class="form-control edit_currency">
        <option value="">Please select currency</option>
        @foreach($currency_id as $currency)
            <option value="{{$currency->id}}" @if($currency->id == $discount_data->currency_id) selected @endif>{{$currency->name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Discount Amount</label>
    <input name="edit_discount_amount" type="text" value="{{$discount_data->discount_amount}}" class="form-control edit_discount_amount" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter value">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Discount type</label>
    <select name="edit_discount_type" class="form-control edit_discount_type">
        <option value="">Please select discount type</option>
        @foreach($discount_type as $discount)
            <option value="{{$discount->id}}" @if($discount->id == $discount_data->discount_type_id) selected @endif>{{$discount->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Start date</label>
    <input name="edit_start_date" type="text" value="{{date('Y-m-d',strtotime($discount_data->start_date))}}" class="form-control edit_start_date coupon_date" placeholder="Enter start date">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">End date</label>
    <input name="edit_end_date" type="text" value="{{date('Y-m-d',strtotime($discount_data->end_date))}}" class="form-control edit_end_date coupon_date" placeholder="Enter end date">
</div>


