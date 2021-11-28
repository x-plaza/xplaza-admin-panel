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
                        <h1 class="m-0">Delivery Cost List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Delivery Cost</li>
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
                                        @if(App\Libraries\AclHandler::hasAccess('Delivery Cost','add') == true)
                                        <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#add-modal-lg">
                                            Add Delivery Cost
                                        </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="delete_response_msg_area"></div>
                                <div class="table-responsive">
                                    <table id="delivery_cost_list"
                                           class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>Delivery Slab Range</th>
                                            <th>Cost</th>
                                            <th>currency</th>
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
                    <h4 class="modal-title">New Delivery Cost</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="add_response_msg_area"></div>

                    <div class="form-group">
                        <label for="">Cost</label>
                        <input name="cost" type="text" class="form-control cost" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter value">
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
                        <label for="exampleInputEmail1">Start Range</label>
                        <input name="start_range" type="text" class="form-control start_range"  placeholder="Enter value">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">End Range</label>
                        <input name="end_range" type="text" class="form-control end_range"  placeholder="Enter value">
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
                    <h4 class="modal-title">Edit Delivery Cost</h4>
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
                    <button type="button" class="btn btn-primary update_delivery_cost"> <span class="spinner-icon"></span> Update </button>
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
                $('#delivery_cost_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("delivery-cost/get-list")}}',
                        method: 'post'
                    },
                    columns: [
                        {data: 'delivery_slab_range', name: 'delivery_slab_range', searchable: true ,orderable: false},
                        {data: 'cost', name: 'cost', searchable: true ,orderable: false},
                        {data: 'currency_name', name: 'currency_name', searchable: true ,orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getProductDiscountList();

            $(document).on('click', '.store_new_discount', function () {
                $('.add_response_msg_area').empty();
                var cost = $('.cost').val();
                var currency = $('.currency').val();
                var start_range = $('.start_range').val();
                var end_range = $('.end_range').val();

                if (cost == '') {
                    alert("please enter cost");
                    return false;
                }
                if (currency == '') {
                    alert("please insert currency");
                    return false;
                }
                if (start_range == '') {
                    alert("please insert start range");
                    return false;
                }
                if (end_range == '') {
                    alert("please insert end range");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/delivery-cost/add-new-delivery-cost') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        cost: cost,
                        currency: currency,
                        start_range: start_range,
                        end_range: end_range
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.add_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');


                           $('.cost').val('');
                           $('.currency').val('');
                           $('.start_range').val('');
                           $('.end_range').val('');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            var dataTable = $('#delivery_cost_list').dataTable();
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


            $(document).on('click', '.open_delivery_cost_modal', function () {

                var delivery_cost_id = jQuery(this).data('delivery_cost_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/delivery-cost/get-delivery-cost-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        delivery_cost_id: delivery_cost_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.edit_data_content').html(response.html);

                            $('#edit-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });


            $(document).on('click', '.update_delivery_cost', function () {
                $('.edit_response_msg_area').empty();
                var edit_delivery_cost_id = $('.edit_delivery_cost_id').val();
                var cost = $('.edit_cost').val();
                var currency = $('.edit_currency').val();
                var start_range = $('.edit_start_range').val();
                var end_range = $('.edit_end_range').val();

                if (cost == '') {
                    alert("please enter cost");
                    return false;
                }
                if (currency == '') {
                    alert("please insert currency");
                    return false;
                }
                if (start_range == '') {
                    alert("please insert start range");
                    return false;
                }
                if (end_range == '') {
                    alert("please insert end range");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/delivery-cost/update-delivery-cost') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        delivery_cost_id: edit_delivery_cost_id,
                        cost: cost,
                        currency: currency,
                        start_range: start_range,
                        end_range: end_range
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

                            var dataTable = $('#delivery_cost_list').dataTable();
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


            $(document).on('click', '.deleteDeliveryCost', function () {

                var result = confirm("Want to delete?");
                if (!result) {
                    return false;
                }

                var delivery_cost_id = jQuery(this).data('delivery_cost_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/delivery-cost/delete-delivery-cost') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        delivery_cost_id: delivery_cost_id
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

                            var dataTable = $('#delivery_cost_list').dataTable();
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
