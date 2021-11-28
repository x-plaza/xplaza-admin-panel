
<?php
//    $totalAmount= $paymentInfo->pay_amount + $paymentInfo->transaction_charge_amount + $paymentInfo->vat_amount;
$invoice = 'INVGEN'.$orderDetailsData->invoice_number;
?>
<div class="row" style="margin-bottom: 10px;">
  <div class="col-md-12" >
    <h4>INVOICE # {{$invoice}} </h4>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Customer Name <b
              style="float: right;color: black;">{{$orderDetailsData->customer_name}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Customer Mobile <b
              style="float: right;color: black;">{{$orderDetailsData->mobile_no}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Delivery Address <b
              style="float: right;color: black;">{{$orderDetailsData->delivery_address}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Additional info <b
              style="float: right;color: black;">{{$orderDetailsData->additional_info}}</b></a>
  </div>
</div>

<div class="row">
  <div class="col-md-6" >
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Shop Name <b
              style="float: right;color: black;">{{substr($orderDetailsData->shop_name,0,22)}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Order Date <b
              style="float: right;color: black;">{{$orderDetailsData->received_time}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Delivery date <b
              style="float: right;color: black;">{{$orderDetailsData->date_to_deliver}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Delivery Schedule<b
              style="float: right;color: black;">{{$orderDetailsData->allotted_time}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Coupon Code<b
              style="float: right;color: black;">{{$orderDetailsData->coupon_code}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Payment type<b
              style="float: right;color: black;">{{$orderDetailsData->payment_type_name}}</b></a>
  </div>

  <div class="col-md-6" >
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Delivery Hero <b
              style="float: right;color: black;">{{$orderDetailsData->delivery_person}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Mobile No <b
              style="float: right;color: black;">{{$orderDetailsData->contact_no}}</b></a>
    <a href="javascript:void(0)" class="list-group-item AddToInvoice">Remarks <b
              style="float: right;color: black;">{{$orderDetailsData->remarks}}</b></a>
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
      <th>Quantity (pcs)</th>
      <th>Unit Price ({{$orderDetailsData->currency_sign}})</th>
      <th>Total Price ({{$orderDetailsData->currency_sign}})</th>
      @if($orderDetailsData->status_id == 1)
      <th>Action</th>
      @endif
    </tr>
    </thead>
    <tbody>
    @foreach($orderDetailsData->orderItemLists as $singleData)
      <tr class="placedOrder">
        <td>{{$singleData->item_name}}</td>
        <td>{{$singleData->item_category}}</td>
        <td>
          @if($orderDetailsData->status_id == 1)
          <input type="text" name="order_item_quantity" class="form-control order_item_quantity" value="{{$singleData->quantity}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
          @else
            {{$singleData->quantity}}
          @endif
        </td>
        <td>{{$singleData->unit_price}}</td>
        <td>{{$singleData->item_total_price}}</td>
        @if($orderDetailsData->status_id == 1)
        <td>
          <button class="btn btn-danger btn-sm item_remove_btn" data-item_id="{{$singleData->id}}" type="button"> <span class="loading_remove"></span>Remove</button>
          <button class="btn btn-info btn-sm order_item_update" data-item_id="{{$singleData->id}}" type="button"><span class="loading_add"></span>Update</button>
        </td>
        @endif
      </tr>
    @endforeach
    <tr>
      <td colspan="4">Total</td>
      <td>{{$orderDetailsData->total_price}}</td>
    </tr>
    <tr>
      <td colspan="4">Discount</td>
      <td>{{$orderDetailsData->discount_amount}}</td>
    </tr>
    <tr>
      <td colspan="4">Coupon Amount</td>
      <td>{{$orderDetailsData->coupon_amount}}</td>
    </tr>
    <tr>
      <td colspan="4">Delivery Cost</td>
      <td>{{$orderDetailsData->delivery_cost}}</td>
    </tr>
    <tr>
      <td colspan="4"><b>Grand Total</b></td>
      <td><b>{{$orderDetailsData->grand_total_price}}</b></td>
    </tr>
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
        @if($orderDetailsData->status_id != 5)
        <option value="6" @if($orderDetailsData->status_id == 6) selected @endif>Cancelled</option>
        @endif
      </select>
      <div class="input-group-prepend">
        <button class="btn btn-info order_status_update"> <i class="fa fa-edit"></i> Update Status </button>
      </div>
    </div>

    <div class="input-group col-md-6 pull-right" >
         <a href="{{url('/order/invoice/'.$orderDetailsData->invoice_number)}}" target="_blank" class="btn btn-md btn-info"><i class="fa fa-print"></i> Print Invoice</a>
    </div>

</div>
