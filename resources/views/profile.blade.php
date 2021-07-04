@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')


@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
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
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    My profile
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-12" >
                                        <a href="javascript:void(0)" class="list-group-item AddToInvoice">Name <b
                                                    style="float: right;color: black;">{{Session::get('authData')->user_name}}</b></a>
                                        <a href="javascript:void(0)" class="list-group-item AddToInvoice">Role <b
                                                    style="float: right;color: black;">{{Session::get('authData')->role_name}}</b></a>
                                    </div>
                                </div>

                                <b>Shop:</b>

                                <table class="table table-bordered table-sm">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Shop ID</th>
                                        <th style="text-align: center;">Shop Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(Session::get('shopList') as $shop)
                                    <tr>
                                        <td style="text-align: center;">{{$shop->shop_id}}</td>
                                        <td style="text-align: center;">{{$shop->shop_name}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </section>

                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


@endsection

@section('scripts')
    @include('layouts.admin_common_js')
{{--    <script src="{{asset('admin_src/plugins/jquery-ui/jquery-ui.min.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/sparklines/sparkline.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/jqvmap/jquery.vmap.min.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/jquery-knob/jquery.knob.min.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/moment/moment.min.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/daterangepicker/daterangepicker.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/summernote/summernote-bs4.min.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/dist/js/adminlte.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/dist/js/demo.js')}}"></script>--}}
{{--    <script src="{{asset('admin_src/dist/js/pages/dashboard.js')}}"></script>--}}
{{--    <script>--}}
{{--       --}}
{{--    </script>--}}
@endsection
