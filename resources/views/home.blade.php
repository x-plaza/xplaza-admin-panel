@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')

    <!-- Ionicons -->
{{--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/jqvmap/jqvmap.min.css')}}">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/daterangepicker/daterangepicker.css')}}">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/summernote/summernote-bs4.min.css')}}">--}}
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>150</h3>

                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>53<sup style="font-size: 20px">%</sup></h3>

                                <p>Bounce Rate</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>44</h3>

                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>65</h3>

                                <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- Calendar -->

                    <!-- /.card -->
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-6 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Sales
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="canceled_list" style="text-align: center;">
                                    <img class="img-responsive" src="{{asset('admin_src/loading_img.gif')}}" style="height: 170px;">
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-lg-6 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Sales
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="canceled_list" style="text-align: center;">
                                    <img class="img-responsive" src="{{asset('admin_src/loading_img.gif')}}" style="height: 170px;">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable">

                    </section>
                    <!-- right col -->
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
