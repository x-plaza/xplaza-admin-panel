@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')

    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">--}}

    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />

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
                        <h1 class="m-0">Item List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Item</li>
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
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#add-modal-lg">
                                            Add Item
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="delete_response_msg_area"></div>
                                <div class="table-responsive">
                                    <table id="item_list"
                                           class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Buying Price</th>
                                            <th>Selling Price</th>
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

    <div class="modal fade" id="add-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="add_response_msg_area"></div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Item Name</label>
                        <input name="item_name" type="text" class="form-control item_name"  placeholder="Enter Item Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea name="description" class="form-control description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Shop</label>
                        <select name="shop_id" class="form-control shop_id">
                            @foreach($shops as $shop)
                                <option value="{{$shop->id}}">{{$shop->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Brand</label>
                        <select name="brand_id" class="form-control brand_id">
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category</label>
                        <select name="category_id" class="form-control category_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Buying price</label>
                        <input name="buying_price" type="text" class="form-control buying_price" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter Buying price">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Selling price</label>
                        <input name="selling_price" type="text" class="form-control selling_price" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Enter Selling price">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary store_new_item"> <span class="spinner-icon"></span> Save </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('scripts')
    @include('layouts.admin_common_js')

    <script src="{{ asset("admin_src/datatable/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/responsive.bootstrap.min.js") }}"></script>

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

    <script language="javascript">

        $(document).ready(function() {

            function getItemList() {
                $('#item_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("item/get-list")}}',
                        method: 'post'
                    },
                    columns: [
                        {data: 'name', name: 'name', searchable: true},
                        {data: 'description', name: 'description', searchable: true},
                        {data: 'buying_price', name: 'buying_price', searchable: true},
                        {data: 'selling_price', name: 'selling_price', searchable: true},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getItemList();

            $(document).on('click', '.store_new_item', function () {
                $('.add_response_msg_area').empty();
                var item_name = $('.item_name').val();
                var description = $('.description').val();
                var shop_id = $('.shop_id').val();
                var brand_id = $('.brand_id').val();
                var category_id = $('.category_id').val();
                var buying_price = $('.buying_price').val();
                var selling_price = $('.selling_price').val();
                var currency_id = 1;
                var product_var_type_id = 1;
                var product_var_type_option = 0;

                if (description == '') {
                    alert("please insert description");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/item/add-new-item') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        item_name: item_name,
                        description: description,
                        shop_id: shop_id,
                        brand_id: brand_id,
                        category_id: category_id,
                        buying_price: buying_price,
                        selling_price: selling_price,
                        currency_id: currency_id,
                        product_var_type_id: product_var_type_id,
                        product_var_type_option: product_var_type_option
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.add_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');


                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            var dataTable = $('#item_list').dataTable();
                            dataTable.fnDestroy();
                            getItemList();

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


            $(document).on('click', '.open_item_modal', function () {

                var category_id = jQuery(this).data('category_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/category/get-category-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        category_id: category_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            // $('.edit_shop_name').val(response.data.name);
                            // $('.edit_shop_description').val(response.data.name);
                            // $('.edit_shop_address').val(response.data.name);
                            // $('.shop_id').val(response.data.name);

                            $('#edit-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });


            $(document).on('click', '.deleteItem', function () {

                var result = confirm("Want to delete?");
                if (!result) {
                    return false;
                }

                var item_id = jQuery(this).data('item_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/delete-item') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        item_id: item_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.delete_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');


                            $('.alert-success').fadeOut(3000);

                            var dataTable = $('#item_list').dataTable();
                            dataTable.fnDestroy();
                            getItemList();
                        }else{

                        }
                    }
                });

            });

        });

    </script>
@endsection
