@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')

    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
{{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">--}}

    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("plugins/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}" />

    <style>
        .paginate_button{
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
                        <h1 class="m-0">Coupon List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Coupon</li>
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
                                    <div class="col-md-2 ">
                                        @if(App\Libraries\AclHandler::hasAccess('Coupon','add') == true)
                                        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#add-modal-lg">
                                            Add Coupon
                                        </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="delete_response_msg_area"></div>
                                <div class="table-responsive">
                                    <table id="coupon_list"
                                           class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Amount</th>
                                            <th>Max_amount</th>
                                            <th>Currency</th>
                                            <th>Discount_type</th>
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
                    <h4 class="modal-title">New Coupon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="add_response_msg_area"></div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Amount</label>
                        <input name="amount" type="text" class="form-control amount" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter amount">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Coupon code</label>
                        <input name="coupon_code" type="text" class="form-control coupon_code"  placeholder="Enter coupon_code">
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
                    <div class="form-group">
                        <label for="exampleInputEmail1">Max Amount</label>
                        <input name="max_amount" type="text" class="form-control max_amount" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter max_amount">
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary store_new_coupon"> <span class="spinner-icon"></span> Save </button>
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
                    <h4 class="modal-title">Edit Coupon</h4>
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
                    <button type="button" class="btn btn-primary update_coupon"> <span class="spinner-icon"></span> Update </button>
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
            calDate.setDate( calDate.getDate() - 20 );
            $('.coupon_date').datetimepicker({
                //   viewMode: 'years',
                format: 'YYYY-MM-DD'
               // maxDate: (new Date()),
               // minDate: calDate
            });
            //$('.pending_datepicker').val('');

            function getCouponList() {
                $('#coupon_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("coupon/get-list")}}',
                        method: 'post'
                    },
                    columns: [
                        {data: 'coupon_code', name: 'coupon_code', searchable: true ,orderable: false},
                        {data: 'amount', name: 'amount', searchable: true ,orderable: false},
                        {data: 'max_amount', name: 'max_amount', searchable: true ,orderable: false},
                        {data: 'currency_name', name: 'currency_name', searchable: true ,orderable: false},
                        {data: 'discount_type_name', name: 'discount_type_name', searchable: true ,orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getCouponList();

            $(document).on('click', '.store_new_coupon', function () {
                $('.add_response_msg_area').empty();
                var amount = $('.amount').val();
                var coupon_code = $('.coupon_code').val();
                var currency = $('.currency').val();
                var discount_type = $('.discount_type').val();
                var start_date = $('.start_date').val();
                var end_date = $('.end_date').val();
                var max_amount = $('.max_amount').val();
                var is_active = true;

                if (amount == '') {
                    alert("please enter amount");
                    return false;
                }
                if (coupon_code == '') {
                    alert("please insert coupon_code");
                    return false;
                }
                if (currency == '') {
                    alert("please insert currency");
                    return false;
                }
                if (discount_type == '') {
                    alert("please insert discount_type");
                    return false;
                }
                if (start_date == '') {
                    alert("please insert start_date");
                    return false;
                }
                if (end_date == '') {
                    alert("please insert end_date");
                    return false;
                }
                if (max_amount == '') {
                    alert("please insert max_amount");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/coupon/add-new-coupon') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        amount: amount,
                        coupon_code: coupon_code,
                        currency: currency,
                        discount_type: discount_type,
                        start_date: start_date,
                        end_date: end_date,
                        max_amount: max_amount,
                        is_active: is_active
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.add_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');


                           $('.amount').val('');
                           $('.coupon_code').val('');
                           $('.currency').val('');
                           $('.discount_type').val('');
                           $('.start_date').val('');
                           $('.end_date').val('');
                           $('.max_amount').val('');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            var dataTable = $('#coupon_list').dataTable();
                            dataTable.fnDestroy();
                            getCouponList();

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


            $(document).on('click', '.open_coupon_modal', function () {

                var coupon_id = jQuery(this).data('coupon_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/coupon/get-coupon-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        coupon_id: coupon_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.edit_data_content').html(response.html);
                            $('.coupon_date').datetimepicker({
                                format: 'YYYY-MM-DD'
                            });
                            $('#edit-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });


            $(document).on('click', '.update_coupon', function () {
                $('.edit_response_msg_area').empty();
                var edit_coupon_id = $('.edit_coupon_id').val();
                var edit_amount = $('.edit_amount').val();
                var edit_coupon_code = $('.edit_coupon_code').val();
                var edit_currency = $('.edit_currency').val();
                var edit_discount_type = $('.edit_discount_type').val();
                var edit_start_date = $('.edit_start_date').val();
                var edit_end_date = $('.edit_end_date').val();
                var edit_max_amount = $('.edit_max_amount').val();
                var edit_is_active = true;

                if (edit_amount == '') {
                    alert("please enter amount");
                    return false;
                }
                if (edit_coupon_code == '') {
                    alert("please insert coupon_code");
                    return false;
                }
                if (edit_currency == '') {
                    alert("please insert currency");
                    return false;
                }
                if (edit_discount_type == '') {
                    alert("please insert discount_type");
                    return false;
                }
                if (edit_start_date == '') {
                    alert("please insert start_date");
                    return false;
                }
                if (edit_end_date == '') {
                    alert("please insert end_date");
                    return false;
                }
                if (edit_max_amount == '') {
                    alert("please insert max_amount");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/coupon/update-coupon') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        coupon_id: edit_coupon_id,
                        amount: edit_amount,
                        coupon_code: edit_coupon_code,
                        currency: edit_currency,
                        discount_type: edit_discount_type,
                        start_date: edit_start_date,
                        end_date: edit_end_date,
                        max_amount: edit_max_amount,
                        is_active: edit_is_active
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

                            var dataTable = $('#coupon_list').dataTable();
                            dataTable.fnDestroy();
                            getCouponList();

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


            $(document).on('click', '.deleteCoupon', function () {

                var result = confirm("Want to delete?");
                if (!result) {
                    return false;
                }

                var coupon_id = jQuery(this).data('coupon_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/coupon/delete-coupon') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        coupon_id: coupon_id
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

                            var dataTable = $('#coupon_list').dataTable();
                            dataTable.fnDestroy();
                            getCouponList();
                        }else{

                        }
                    }
                });

            });

        });

    </script>
@endsection
