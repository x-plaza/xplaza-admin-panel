<input type="hidden" class="edit_coupon_id" value="{{$coupon_data->id}}">

<div class="form-group">
    <label for="">Shop</label>
    <select class="select2 edit_shop_id" name="edit_shop_id" multiple="multiple" data-placeholder="Select shop" style="width: 100%;">
        @foreach($shops as $shop)
            <option value="{{$shop->shop_id}}" @if(in_array($shop->shop_id,$shopArr)) selected @endif>{{$shop->shop_name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Amount</label>
    <input name="edit_amount" type="text" value="{{$coupon_data->amount}}" class="form-control edit_amount" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter amount">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Coupon code</label>
    <input name="edit_coupon_code" type="text" value="{{$coupon_data->coupon_code}}" class="form-control edit_coupon_code"  placeholder="Enter coupon_code">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Currency</label>
    <select name="edit_currency" class="form-control edit_currency">
        <option value="">Please select currency</option>
        @foreach($currency_id as $currency)
            <option value="{{$currency->id}}" @if($currency->id ==  $coupon_data->currency_id) selected @endif >{{$currency->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Discount type</label>
    <select name="edit_discount_type" class="form-control edit_discount_type">
        <option value="">Please select discount type</option>
        @foreach($discount_type as $discount)
            <option value="{{$discount->id}}" @if($discount->id ==  $coupon_data->discount_type_id) selected @endif>{{$discount->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Start date</label>
    <input name="edit_start_date" type="text" value="{{date('Y-m-d',strtotime($coupon_data->start_date))}}" class="form-control edit_start_date coupon_date" placeholder="Enter start date">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">End date</label>
    <input name="edit_end_date" type="text" value="{{date('Y-m-d',strtotime($coupon_data->end_date))}}" class="form-control edit_end_date coupon_date" placeholder="Enter end date">
</div>
<div class="form-group max_discount_type_section" @if($coupon_data->discount_type_id == 1)style="display: none" @endif >
    <label for="exampleInputEmail1">Max discount amount</label>
    <input name="edit_max_amount" type="text" value="{{$coupon_data->max_amount}}" class="form-control edit_max_amount" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter max amount">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Min shopping amount</label>
    <input name="edit_min_amount" type="text" value="{{$coupon_data->min_shopping_amount}}" class="form-control edit_min_amount" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter min amount">
</div>

