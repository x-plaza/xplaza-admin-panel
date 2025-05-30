@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')

    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("plugins/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}" />
    <style>
        .paginate_button.previous{
            background-color: #17a2b8;
            color: white;
            padding: 2px;
            border-radius: 2px;
            cursor: pointer;
        }
        .paginate_button.next{
            background-color: #17a2b8;
            color: white;
            padding: 2px;
            border-radius: 2px;
            cursor: pointer;
        }

        .paginate_button.current{
            background-color: #1a525a;
            color: white;
            padding: 2px;
            border-radius: 2px;
            cursor: no-drop;
        }
        .paginate_button{
            background-color: #17a2b8;
            color: white;
            padding: 2px;
            border-radius: 2px;
            cursor: pointer;
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Order</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1" style="background-color: #343a40;">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active pending-tab-content" id="pending-tab" data-toggle="pill" href="#tab-pending" role="tab" aria-controls="tab-pending" aria-selected="true">Pending</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link confirmed-tab-content" id="inprogress-tab" data-toggle="pill" href="#tab-confirmed" role="tab" aria-controls="tab-inprogress" aria-selected="false">Confirmed</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link picked_for_delivery-tab-content" id="delivered-tab" data-toggle="pill" href="#tab-picked_for_delivery" role="tab" aria-controls="tab-picked_for_delivery" aria-selected="false">Picked For Delivery</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link delivered-tab-content" id="delivered-tab" data-toggle="pill" href="#tab-delivered" role="tab" aria-controls="tab-delivered" aria-selected="false">Delivered</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link canceled-tab-content" id="canceled-tab" data-toggle="pill" href="#tab-canceled" role="tab" aria-controls="tab-canceled" aria-selected="false">Cancelled</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="tab-pending" role="tabpanel" aria-labelledby="pending-tab">
                                        @include('order.tab_pending')
                                    </div>
                                    <div class="tab-pane fade" id="tab-confirmed" role="tabpanel" aria-labelledby="confirmed-tab">
                                        @include('order.tab_confirmed')
                                    </div>
                                    <div class="tab-pane fade" id="tab-picked_for_delivery" role="tabpanel" aria-labelledby="picked_for_delivery-tab">
                                        @include('order.tab_picked_for_delivery')
                                    </div>
                                    <div class="tab-pane fade" id="tab-delivered" role="tabpanel" aria-labelledby="delivered-tab">
                                        @include('order.tab_delivered')
                                    </div>
                                    <div class="tab-pane fade" id="tab-canceled" role="tabpanel" aria-labelledby="canceled-tab">
                                        @include('order.tab_canceled')
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>



                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


    <!-- Order Details Modal -->
    <div class="modal fade" id="pending-order-modal-xl">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Order Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pending_response_msg_area"></div>
                    <div class="order_status_update_msg"></div>
                    <div class="pending_order_details_data_content"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
{{--                    <button type="button" class="btn btn-primary update_category"> <span class="spinner-icon"></span> Update </button>--}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('scripts')
    @include('layouts.admin_common_js')

    <script src="{{ asset("plugins/moment.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/responsive.bootstrap.min.js") }}"></script>
    <script src="{{ asset("plugins/datepicker-oss/js/bootstrap-datetimepicker.js") }}"></script>

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

    <script language="javascript">

        $(document).ready(function() {

            var today = new Date();
            var yyyy = today.getFullYear();

            var calDate = new Date();
            calDate.setDate( calDate.getDate() - 5 );

            $('.pending_datepicker').datetimepicker({
             //   viewMode: 'years',
                format: 'DD-MM-YYYY',
                maxDate: (new Date()),
              //  minDate: calDate
            });
            $('.pending_datepicker').val('');

            function getPendingList() {
                var date =$('.pending_datepicker').val();
                $('#pending_order_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("/order/get-pending-order-list")}}',
                        method: 'post',
                        data: function (d) {
                            d._token = $('input[name="_token"]').val();
                            d.date = date;
                        }
                    },
                    columns: [
                        {data: 'invoice_number', name: 'order_id', searchable: false, orderable: false},
                        {data: 'shop_name', name: 'shop_name', searchable: true , orderable: false},
                        {data: 'grand_total_price', name: 'grand_total_price', searchable: true, orderable: false},
                        {data: 'mobile_no', name: 'mobile_no', searchable: true, orderable: false},
                        {data: 'date_to_deliver', name: 'date_to_deliver', searchable: true, orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false, orderable: false}
                    ],
                    "aaSorting": []
                });
            }

            getPendingList();

            $(document).on('click', '.pending_search', function () {
                var dataTable = $('#pending_order_list').dataTable();
                dataTable.fnDestroy();
                getPendingList();
            })

            $(document).on('click', '.pending-tab-content', function () {
                var dataTable = $('#pending_order_list').dataTable();
                dataTable.fnDestroy();
                getPendingList();
            })

            $(document).on('click', '.view_order_details', function () {

                $('.order_status_update_msg').html('');
                var order_id = jQuery(this).data('order_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    //  dataType: "json",
                    url: "{{url("/order/get-order-details")}}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        order_id: order_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.pending_order_details_data_content').html(response.html);
                            $('#pending-order-modal-xl').modal();
                        }else{
                            alert(response.message);
                        }
                    }
                });

            });

            //*************** confirmed ***************************************

            $('.confirmed_datepicker').datetimepicker({
                //   viewMode: 'years',
                format: 'DD-MM-YYYY',
                maxDate: (new Date()),
              //  minDate: calDate
            });
            $('.confirmed_datepicker').val('');

            function getConfirmedList() {
                var date =$('.confirmed_datepicker').val();
                $('#confirmed_order_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("/order/get-confirmed-list")}}',
                        method: 'post',
                        data: function (d) {
                            d._token = $('input[name="_token"]').val();
                            d.date = date;
                        }
                    },
                    columns: [
                        {data: 'invoice_number', name: 'order_id', searchable: false, orderable: false},
                        {data: 'shop_name', name: 'shop_name', searchable: true , orderable: false},
                        {data: 'grand_total_price', name: 'grand_total_price', searchable: true, orderable: false},
                        {data: 'mobile_no', name: 'mobile_no', searchable: true, orderable: false},
                        {data: 'date_to_deliver', name: 'date_to_deliver', searchable: true, orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false, orderable: false}
                    ],
                    "aaSorting": []
                });
            }
            $(document).on('click', '.confirmed-tab-content', function () {
                var dataTable = $('#confirmed_order_list').dataTable();
                dataTable.fnDestroy();
                getConfirmedList();
            })

            $(document).on('click', '.confirmed_search', function () {
                var dataTable = $('#confirmed_order_list').dataTable();
                dataTable.fnDestroy();
                getConfirmedList();
            })

            //*************** picked_for_delivery ***************************************

            $('.picked_for_delivery_datepicker').datetimepicker({
                //   viewMode: 'years',
                format: 'DD-MM-YYYY',
                maxDate: (new Date()),
               // minDate: calDate
            });
            $('.picked_for_delivery_datepicker').val('');

            function getPicked_for_deliveryList() {
                var date =$('.picked_for_delivery_datepicker').val();

                $('#picked_for_delivery_order_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("/order/get-picked_for_delivery-list")}}',
                        method: 'post',
                        data: function (d) {
                            d._token = $('input[name="_token"]').val();
                            d.date = date;
                        }
                    },
                    columns: [
                        {data: 'invoice_number', name: 'order_id', searchable: false, orderable: false},
                        {data: 'shop_name', name: 'shop_name', searchable: true , orderable: false},
                        {data: 'grand_total_price', name: 'grand_total_price', searchable: true, orderable: false},
                        {data: 'mobile_no', name: 'mobile_no', searchable: true, orderable: false},
                        {data: 'date_to_deliver', name: 'date_to_deliver', searchable: true, orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false, orderable: false}
                    ],
                    "aaSorting": []
                });
            }

            $(document).on('click', '.picked_for_delivery-tab-content', function () {
                var dataTable = $('#picked_for_delivery_order_list').dataTable();
                dataTable.fnDestroy();
                getPicked_for_deliveryList();
            })

            $(document).on('click', '.picked_for_delivery_search', function () {
                var dataTable = $('#picked_for_delivery_order_list').dataTable();
                dataTable.fnDestroy();
                getPicked_for_deliveryList();
            })

            //*************** Delivered ***************************************

            $('.delivered_datepicker').datetimepicker({
                //   viewMode: 'years',
                format: 'DD-MM-YYYY',
                maxDate: (new Date()),
               // minDate: calDate
            });
            $('.delivered_datepicker').val('');

            function getDeliveredList() {
                var date =$('.delivered_datepicker').val();
                $('#delivered_order_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("/order/get-delivered-list")}}',
                        method: 'post',
                        data: function (d) {
                            d._token = $('input[name="_token"]').val();
                            d.date = date;
                        }
                    },
                    columns: [
                        {data: 'invoice_number', name: 'order_id', searchable: false, orderable: false},
                        {data: 'shop_name', name: 'shop_name', searchable: true , orderable: false},
                        {data: 'grand_total_price', name: 'grand_total_price', searchable: true, orderable: false},
                        {data: 'mobile_no', name: 'mobile_no', searchable: true, orderable: false},
                        {data: 'date_to_deliver', name: 'date_to_deliver', searchable: true, orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false, orderable: false}
                    ],
                    "aaSorting": []
                });
            }
            $(document).on('click', '.delivered-tab-content', function () {
                var dataTable = $('#delivered_order_list').dataTable();
                dataTable.fnDestroy();
                getDeliveredList();
            })

            $(document).on('click', '.delivered_search', function () {
                var dataTable = $('#delivered_order_list').dataTable();
                dataTable.fnDestroy();
                getDeliveredList();
            })

            //*************** Canceled ***************************************

            $('.canceled_datepicker').datetimepicker({
                //   viewMode: 'years',
                format: 'DD-MM-YYYY',
                maxDate: (new Date()),
              //  minDate: calDate
            });
            $('.canceled_datepicker').val('');

            function getCanceledList() {
                var date =$('.canceled_datepicker').val();
                $('#canceled_order_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("/order/get-canceled-list")}}',
                        method: 'post',
                        data: function (d) {
                            d._token = $('input[name="_token"]').val();
                            d.date = date;
                        }
                    },
                    columns: [
                        {data: 'invoice_number', name: 'order_id', searchable: false, orderable: false},
                        {data: 'shop_name', name: 'shop_name', searchable: true , orderable: false},
                        {data: 'grand_total_price', name: 'grand_total_price', searchable: true, orderable: false},
                        {data: 'mobile_no', name: 'mobile_no', searchable: true, orderable: false},
                        {data: 'date_to_deliver', name: 'date_to_deliver', searchable: true, orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false, orderable: false}
                    ],
                    "aaSorting": []
                });
            }
            $(document).on('click', '.canceled-tab-content', function () {
                var dataTable = $('#canceled_order_list').dataTable();
                dataTable.fnDestroy();
                getCanceledList();
            })

            $(document).on('click', '.canceled_search', function () {
                var dataTable = $('#canceled_order_list').dataTable();
                dataTable.fnDestroy();
                getCanceledList();
            })

            //***********************************************************************

            $(document).on('click', '.order_status_update', function () {
                var status_id =$('.order_status_id').val();
                var invoice_number =$('.invoice_number').val();
                var current_status_id =$('.current_status_id').val();

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    //  dataType: "json",
                    url: "{{url("/order/update-status")}}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        status_id: status_id,
                        invoice_number: invoice_number
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.order_status_update_msg').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            setTimeout(function () {
                                $('.order_status_update_msg').html('');
                                $('#pending-order-modal-xl').modal('hide');
                            }, 3200);

                            if (current_status_id == 1){
                                var dataTable = $('#pending_order_list').dataTable();
                                dataTable.fnDestroy();
                                getPendingList();
                            }else if(current_status_id == 2){
                                var dataTable = $('#confirmed_order_list').dataTable();
                                dataTable.fnDestroy();
                                getConfirmedList();
                            }else if(current_status_id == 3){
                                var dataTable = $('#picked_for_delivery_order_list').dataTable();
                                dataTable.fnDestroy();
                                getPicked_for_deliveryList();
                            }else if(current_status_id == 5){
                                var dataTable = $('#delivered_order_list').dataTable();
                                dataTable.fnDestroy();
                                getInDeliveredList();
                            }else if(current_status_id == 6){
                                var dataTable = $('#canceled_order_list').dataTable();
                                dataTable.fnDestroy();
                                getCanceledList();
                            }


                        }else{
                            $('.order_status_update_msg').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    }
                });
            })

            //***************************************************

            $(document).on('click', '.order_item_update', function () {

                var result = confirm("Want to update?");
                if (!result) {
                    return false;
                }

                var invoice_number =$('.invoice_number').val();
                var order_item_id  = jQuery(this).data('item_id');
                var order_item_quantity  = jQuery(this).closest('tr').find('.order_item_quantity').val();

                jQuery(this).closest('tr').find('.order_item_update').prop('disabled', true);
                jQuery(this).closest('tr').find('.loading_add').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    type: "POST",
                    //  dataType: "json",
                    url: "{{url("/order/update-item-quantity")}}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        invoice_number: invoice_number,
                        order_item_id: order_item_id,
                        order_item_quantity: order_item_quantity
                    },
                    success: function (response) {
                        $('.order_item_update').prop('disabled', false);
                        $('.loading_add').html('');

                        if(response.responseCode == 1){
                            $('.order_status_update_msg').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');


                        }else{
                            $('.order_status_update_msg').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    }
                });
            })

            $(document).on('click', '.item_remove_btn', function () {

                var result = confirm("Want to delete?");
                if (!result) {
                    return false;
                }

                var invoice_number =$('.invoice_number').val();
                var order_item_id  = jQuery(this).data('item_id');

                var tbl = $(this);
                jQuery(this).closest('tr').find('.item_remove_btn').prop('disabled', true);
                jQuery(this).closest('tr').find('.loading_remove').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    type: "POST",
                    //  dataType: "json",
                    url: "{{url("/order/remove-item")}}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        invoice_number: invoice_number,
                        order_item_id: order_item_id
                    },
                    success: function (response) {
                        $('.item_remove_btn').prop('disabled', false);
                        $('.loading_remove').html('');

                        if(response.responseCode == 1){
                            tbl.parents('tr').remove();
                            $('.order_status_update_msg').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');


                        }else{
                            $('.order_status_update_msg').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    }
                });
            })


        });

    </script>
@endsection
