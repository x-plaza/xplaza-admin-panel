@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')

    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
{{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">--}}

    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("plugins/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/plugins/select2/css/select2.min.css") }}" />

    <style>
        .select2-selection__choice{
            background-color: #0f6674 !important;
        }
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
                        <h1 class="m-0">Product Discount List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product Discount</li>
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
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4 ">
                                        @if(App\Libraries\AclHandler::hasAccess('Product Discount','add') == true)
                                        <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#add-modal-lg">
                                            Add Product Discount
                                        </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="delete_response_msg_area"></div>
                                <div class="table-responsive">
                                    <table id="product_discount_list"
                                           class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Discount Type</th>
                                            <th>Discount Amount</th>
                                            <th>currency</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
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

    <!-- /.Add Shop Modal -->
    <div class="modal fade" id="add-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Product Discount</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="add_response_msg_area"></div>

                    <div class="form-group">
                        <label for="">Product</label>
                        <select name="product" class="form-control select2bs4 product_id" style="width: 100%;height: 20px !important;">
                            <option value="">Please select product</option>
                            @foreach($productData as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Currency</label>
                        <select name="currency" class="form-control currency">
                            <option value="">Please select currency</option>
                            @foreach($currency_id as $currency)
                                <option value="{{$currency->id}}">{{$currency->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Discount Amount</label>
                        <input name="discount_amount" type="text" class="form-control discount_amount" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter value">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Discount type</label>
                        <select name="discount_type" class="form-control discount_type">
                            <option value="">Please select discount type</option>
                            @foreach($discount_type as $discount)
                                <option value="{{$discount->id}}">{{$discount->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Start date</label>
                        <input name="start_date" type="text" class="form-control start_date coupon_date" placeholder="Enter start_date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">End date</label>
                        <input name="end_date" type="text" class="form-control end_date coupon_date" placeholder="Enter end_date">
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary store_new_discount"> <span class="spinner-icon"></span> Save </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.Edit Shop Modal -->
    <div class="modal fade" id="edit-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Product Discount</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="edit_response_msg_area"></div>
                    <div class="edit_data_content"></div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_product_discount"> <span class="spinner-icon"></span> Update </button>
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
    <script src="{{ asset("admin_src/plugins/select2/js/select2.full.min.js") }}"></script>

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

    <script language="javascript">

        $(document).ready(function() {

            $('.select2').select2()

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            var today = new Date();
            var yyyy = today.getFullYear();
            var calDate = new Date();
            calDate.setDate( calDate.getDate() - 20 );
            $('.coupon_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            function getProductDiscountList() {
                $('#product_discount_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("product-discount/get-list")}}',
                        method: 'post'
                    },
                    columns: [
                        {data: 'product_name', name: 'product_name', searchable: true ,orderable: false},
                        {data: 'discount_type_name', name: 'discount_type_name', searchable: true ,orderable: false},
                        {data: 'discount_amount', name: 'discount_amount', searchable: true ,orderable: false},
                        {data: 'currency_name', name: 'currency_name', searchable: true ,orderable: false},
                        {data: 'start_date', name: 'discount_amount', searchable: true ,orderable: false},
                        {data: 'end_date', name: 'discount_amount', searchable: true ,orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getProductDiscountList();

            $(document).on('click', '.store_new_discount', function () {
                $('.add_response_msg_area').empty();
                var currency = $('.currency').val();
                var discount_type = $('.discount_type').val();
                var start_date = $('.start_date').val();
                var end_date = $('.end_date').val();
                var discount_amount = $('.discount_amount').val();
                var product = $('.product_id').val();

                if (discount_amount == '') {
                    alert("please enter amount");
                    return false;
                }
                if (currency == '') {
                    alert("please insert currency");
                    return false;
                }
                if (discount_type == '') {
                    alert("please insert discount type");
                    return false;
                }
                if (start_date == '') {
                    alert("please insert start date");
                    return false;
                }
                if (end_date == '') {
                    alert("please insert end date");
                    return false;
                }
                if (product == '') {
                    alert("please insert product");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/product-discount/add-new-product-discount') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        discount_amount: discount_amount,
                        currency: currency,
                        discount_type: discount_type,
                        start_date: start_date,
                        end_date: end_date,
                        product: product
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.add_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');


                           $('.discount_amount').val('');
                           $('.currency').val('');
                           $('.discount_type').val('');
                           $('.start_date').val('');
                           $('.end_date').val('');
                           $('.product').val('');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            var dataTable = $('#product_discount_list').dataTable();
                            dataTable.fnDestroy();
                            getProductDiscountList();

                        } else {
                            $('.add_response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });


            $(document).on('click', '.open_discount_modal', function () {

                var product_discount_id = jQuery(this).data('product_discount_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/product-discount/get-product-discount-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        product_discount_id: product_discount_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.edit_data_content').html(response.html);
                            $('.coupon_date').datetimepicker({
                                format: 'YYYY-MM-DD'
                            });
                            $('.select2').select2()
                            $('.select2bs4').select2({
                                theme: 'bootstrap4'
                            })
                            $('#edit-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });


            $(document).on('click', '.update_product_discount', function () {
                $('.edit_response_msg_area').empty();
                var edit_product_discount_id = $('.edit_product_discount_id').val();
                var edit_product_id = $('.edit_product_id').val();
                var edit_currency = $('.edit_currency').val();
                var edit_discount_amount = $('.edit_discount_amount').val();
                var edit_discount_type = $('.edit_discount_type').val();
                var edit_start_date = $('.edit_start_date').val();
                var edit_end_date = $('.edit_end_date').val();

                if (edit_product_id == '') {
                    alert("please enter product");
                    return false;
                }
                if (edit_currency == '') {
                    alert("please insert currency");
                    return false;
                }
                if (edit_discount_amount == '') {
                    alert("please insert amount");
                    return false;
                }
                if (edit_discount_type == '') {
                    alert("please insert discount type");
                    return false;
                }
                if (edit_start_date == '') {
                    alert("please insert start date");
                    return false;
                }
                if (edit_end_date == '') {
                    alert("please insert end date");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/product-discount/update-product-discount') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        product_discount_id: edit_product_discount_id,
                        product: edit_product_id,
                        discount_amount: edit_discount_amount,
                        currency: edit_currency,
                        discount_type: edit_discount_type,
                        start_date: edit_start_date,
                        end_date: edit_end_date
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.edit_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#edit-modal-lg').modal('hide');
                            }, 3200);

                            var dataTable = $('#product_discount_list').dataTable();
                            dataTable.fnDestroy();
                            getProductDiscountList();

                        } else {
                            $('.edit_response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });


            $(document).on('click', '.deleteDiscount', function () {

                var result = confirm("Want to delete?");
                if (!result) {
                    return false;
                }

                var product_discount_id = jQuery(this).data('product_discount_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/product-discount/delete-product-discount') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        product_discount_id: product_discount_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.delete_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            var dataTable = $('#product_discount_list').dataTable();
                            dataTable.fnDestroy();
                            getProductDiscountList();
                        }else{
                            $('.delete_response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    }
                });

            });

        });

    </script>
@endsection
