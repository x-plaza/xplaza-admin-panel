

<div class="row" style="margin-bottom: 10px;">
  <div class="col-md-12" >
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Customer Name <b
              style="float: right;color: black;">{{$orderDetailsData->customer_name}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Delivery Address <b
              style="float: right;color: black;">{{$orderDetailsData->delivery_address}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Customer Mobile <b
              style="float: right;color: black;">{{$orderDetailsData->mobile_no}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Delivery Hero <b
              style="float: right;color: black;">{{$orderDetailsData->delivery_person}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Mobile No <b
              style="float: right;color: black;">{{$orderDetailsData->contact_no}}</b></a>
  </div>
</div>

<div class="row">
  <div class="col-md-6" >
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Invoice Number <b
              style="float: right;color: black;">INVGEN{{$orderDetailsData->invoice_number}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Discount <b
              style="float: right;color: black;">{{$orderDetailsData->discount_amount}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Delivery Cost <b
              style="float: right;color: black;">{{$orderDetailsData->delivery_cost}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Coupon Code <b
              style="float: right;color: black;">{{$orderDetailsData->coupon_code}}</b></a>
  </div>

  <div class="col-md-6" >
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Total Price <b
              style="float: right;color: black;">{{$orderDetailsData->total_price}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Grand Total <b
              style="float: right;color: black;">{{$orderDetailsData->grand_total_price}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Payment Type <b
              style="float: right;color: black;">{{$orderDetailsData->payment_type_name}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Coupon Amount <b
              style="float: right;color: black;">{{$orderDetailsData->coupon_amount}}</b></a>
  </div>

</div>


<div class="clearfix"></br></div>
<div style="overflow-x: auto;">
  <table id="showDataTable"
         class="table table-sm table-hover table-striped table-bordered"
         cellspacing="0" width="100%">
    <thead>
    <tr style="background-color: #0f6674;color: white;font-weight: bold;">
      <th>Item Name</th>
      <th>Category</th>
      <th>Quantity</th>
      <th>Quantity Type</th>
      <th>Unit Price</th>
      <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderDetailsData->orderItemLists as $singleData)
      <tr class="placedOrder">
        <td>{{$singleData->item_name}}</td>
        <td>{{$singleData->item_category}}</td>
        <td>{{$singleData->quantity}}</td>
        <td>{{$singleData->quantity_type}}</td>
        <td>{{$singleData->unit_price}}</td>
        <td>{{$singleData->item_total_price}}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
<div class="clearfix"></br></div>

<input type="hidden" class="invoice_number" value="{{$orderDetailsData->invoice_number}}">
<input type="hidden" class="current_status_id" value="{{$orderDetailsData->status_id}}">

<div class="row">

    <div class="input-group col-md-5 pull-left" >
      <select class="form-control order_status_id">
        <option value="">Select Status</option>
        <option value="1" @if($orderDetailsData->status_id == 1) selected @endif>Pending</option>
        <option value="2" @if($orderDetailsData->status_id == 2) selected @endif>Confirmed</option>
        <option value="3" @if($orderDetailsData->status_id == 3) selected @endif>Picked for delivery</option>
        <option value="5" @if($orderDetailsData->status_id == 5) selected @endif>Delivered</option>
        <option value="6" @if($orderDetailsData->status_id == 6) selected @endif>Cancelled</option>
      </select>
      <div class="input-group-prepend">
        <button class="btn btn-info order_status_update"> <i class="fa fa-edit"></i> Update </button>
      </div>
    </div>

    <div class="input-group col-md-6 pull-right" >
      <a href="{{url('/order/invoice/'.$orderDetailsData->invoice_number)}}" target="_blank" class="btn btn-md btn-info"><i class="fa fa-print"></i> Print Invoice</a>
    </div>

</div>
