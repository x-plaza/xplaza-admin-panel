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
                                        <a class="nav-link inprogress-tab-content" id="inprogress-tab" data-toggle="pill" href="#tab-inprogress" role="tab" aria-controls="tab-inprogress" aria-selected="false">In-Progress</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link delivered-tab-content" id="delivered-tab" data-toggle="pill" href="#tab-delivered" role="tab" aria-controls="tab-delivered" aria-selected="false">Delivered</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="canceled-tab" data-toggle="pill" href="#tab-canceled" role="tab" aria-controls="tab-canceled" aria-selected="false">Canceled</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="tab-pending" role="tabpanel" aria-labelledby="pending-tab">
                                        @include('order.tab_pending')
                                    </div>
                                    <div class="tab-pane fade" id="tab-inprogress" role="tabpanel" aria-labelledby="inprogress-tab">
                                        @include('order.tab_inprogress')
                                    </div>
                                    <div class="tab-pane fade" id="tab-delivered" role="tabpanel" aria-labelledby="delivered-tab">
                                        @include('order.tab_delivered')
                                    </div>
                                    <div class="tab-pane fade" id="tab-canceled" role="tabpanel" aria-labelledby="canceled-tab">
{{--                                        <div class="canceled_list" style="text-align: center;">--}}
{{--                                            <img class="img-responsive" src="{{asset('admin_src/loading_img.gif')}}" style="height: 170px;">--}}
{{--                                        </div>--}}
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
    <div class="modal fade" id="edit-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
{{--                <div class="modal-header">--}}
{{--                    <h4 class="modal-title">Edit Category</h4>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="edit_response_msg_area"></div>--}}
{{--                    <div class="edit_data_content"></div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer justify-content-between">--}}
{{--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
{{--                    <button type="button" class="btn btn-primary update_category"> <span class="spinner-icon"></span> Update </button>--}}
{{--                </div>--}}
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

            function getPendingList() {
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
                        method: 'post'
                    },
                    columns: [
                        {data: 'name', name: 'name', searchable: true},
                        {data: 'description', name: 'description', searchable: true},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getPendingList();


            function getInProgressList() {
                $('#in_progress_order_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("/order/get-inprogress-list")}}',
                        method: 'post'
                    },
                    columns: [
                        {data: 'name', name: 'name', searchable: true},
                        {data: 'description', name: 'description', searchable: true},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }
            $(document).on('click', '.inprogress-tab-content', function () {
                var dataTable = $('#in_progress_order_list').dataTable();
                dataTable.fnDestroy();
                getInProgressList();
            })


            function getInDeliveredList() {
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
                        method: 'post'
                    },
                    columns: [
                        {data: 'name', name: 'name', searchable: true},
                        {data: 'description', name: 'description', searchable: true},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }
            $(document).on('click', '.delivered-tab-content', function () {
                var dataTable = $('#delivered_order_list').dataTable();
                dataTable.fnDestroy();
                getInDeliveredList();
            })



            {{--$(document).on('click', '.open_category_modal', function () {--}}

            {{--    var category_id = jQuery(this).data('category_id');--}}

            {{--    var btn = $(this);--}}
            {{--    btn.prop('disabled', true);--}}

            {{--    $.ajax({--}}
            {{--        type: "POST",--}}
            {{--        dataType: "json",--}}
            {{--        url: "{{ url('/category/get-category-info') }}",--}}
            {{--        data: {--}}
            {{--            _token: $('input[name="_token"]').val(),--}}
            {{--            category_id: category_id--}}
            {{--        },--}}
            {{--        success: function (response) {--}}
            {{--            btn.prop('disabled', false);--}}
            {{--            if(response.responseCode == 1){--}}
            {{--                $('.edit_data_content').html(response.html);--}}
            {{--                $('#edit-modal-lg').modal();--}}
            {{--            }else{--}}

            {{--            }--}}
            {{--        }--}}
            {{--    });--}}

            {{--});--}}



        });

    </script>
@endsection
