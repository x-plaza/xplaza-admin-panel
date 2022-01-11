<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>

<?php
//    $totalAmount= $paymentInfo->pay_amount + $paymentInfo->transaction_charge_amount + $paymentInfo->vat_amount;
$invoice = $orderDetailsData->invoice_number;
?>

<section class="content" id="applicationForm" style="font-size: 5px !important;">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">

                <img src="{{ asset('admin_src/logo.png' )}}" style="height: 50px;margin-left: 37%;" alt="singnature"/>

                <h2>INVOICE  {{$invoice}} </h2>

                <div class="header_div">
                    <div class="left_content">
                        <table class="header_tbl">
                            <tr>
                                <td>Shop Name </td>
                                <td>: {{$orderDetailsData->shop_name}}</td>
                            </tr>
                            <tr>
                                <td>Order Date </td>
                                <td>: {{$orderDetailsData->received_time}}</td>
                            </tr>
                            <tr>
                                <td>Delivery date </td>
                                <td>: {{$orderDetailsData->date_to_deliver}}</td>
                            </tr>
                            <tr>
                                <td>Delivery Schedule</td>
                                <td>: {{$orderDetailsData->allotted_time}}</td>
                            </tr>
                            <tr>
                                <td>Coupon Code </td>
                                <td>: {{$orderDetailsData->coupon_code}}</td>
                            </tr>
                            <tr>
                                <td>Payment type </td>
                                <td>: {{$orderDetailsData->payment_type_name}}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="right_content">
                        <table class="header_tbl">
                            <tr>
                                <td>Customer Name</td>
                                <td>: {{$orderDetailsData->customer_name}} </td>
                            </tr>
                            <tr>
                                <td>Customer Mobile </td>
                                <td>: {{$orderDetailsData->mobile_no}}</td>
                            </tr>
                            <tr>
                                <td>Delivery Address </td>
                                <td>: {{$orderDetailsData->delivery_address}}</td>
                            </tr>
                            <tr>
                                <td>Additional info </td>
                                <td>: {{$orderDetailsData->additional_info}}</td>
                            </tr>

                            <tr>
                                <td>Remarks </td>
                                <td>: {{$orderDetailsData->remarks}}</td>
                            </tr>
                        </table>
                    </div>
                </div>


                <br>
                <h3>Order Details</h3>
                <table class="order_details" >
                    <tr>
                        <th> Item Name </th>
                        <th> Quantity (pcs)</th>
                        <th> Unit Price	({{$orderDetailsData->currency_sign}})</th>
                        <th> Total Price ({{$orderDetailsData->currency_sign}})</th>
                    </tr>
                    @foreach($orderDetailsData->orderItemLists as $singleData)
                        <tr>
                            <td>{{$singleData->item_name}}</td>
                            <td>{{$singleData->quantity}}</td>
                            <td>{{$singleData->unit_price}}</td>
                            <td>{{$singleData->item_total_price}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Total</td>
                        <td> {{$orderDetailsData->total_price}}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Discount</td>
                        <td> {{$orderDetailsData->discount_amount}}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Coupon Amount</td>
                        <td> {{$orderDetailsData->coupon_amount}}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Delivery Cost</td>
                        <td> {{$orderDetailsData->delivery_cost}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Grand Total</b></td>
                        <td> <b>{{$orderDetailsData->grand_total_price}}</b></td>
                    </tr>
                </table>



                <br/>


            </div>
        </div>
    </div>
</section>
</body>
</html>
