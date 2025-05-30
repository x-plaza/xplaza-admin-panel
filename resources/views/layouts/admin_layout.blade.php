<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>xwinkel</title>

    @section('styles')
    @show
    <!-- Google Font: Source Sans Pro -->

    <style>
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #17a2b8 !important;
        }
        .card-primary.card-outline {
            border-top: 3px solid #0d0e0e;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <a href="index3.html" class="nav-link">Home</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <a href="#" class="nav-link">Contact</a>--}}
{{--            </li>--}}
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" data-widget="navbar-search" href="#" role="button">--}}
{{--                    <i class="fas fa-search"></i>--}}
{{--                </a>--}}
{{--                <div class="navbar-search-block">--}}
{{--                    <form class="form-inline">--}}
{{--                        <div class="input-group input-group-sm">--}}
{{--                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
{{--                            <div class="input-group-append">--}}
{{--                                <button class="btn btn-navbar" type="submit">--}}
{{--                                    <i class="fas fa-search"></i>--}}
{{--                                </button>--}}
{{--                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">--}}
{{--                                    <i class="fas fa-times"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </li>--}}

            <!-- Notifications Dropdown Menu -->
{{--            <li class="nav-item dropdown">--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <i class="far fa-bell"></i>--}}
{{--                    <span class="badge badge-warning navbar-badge">15</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
{{--                    <span class="dropdown-header">15 Notifications</span>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-envelope mr-2"></i> 4 new messages--}}
{{--                        <span class="float-right text-muted text-sm">3 mins</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-users mr-2"></i> 8 friend requests--}}
{{--                        <span class="float-right text-muted text-sm">12 hours</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-file mr-2"></i> 3 new reports--}}
{{--                        <span class="float-right text-muted text-sm">2 days</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
{{--                </div>--}}
{{--            </li>--}}


            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
{{--                    <a href="#" class="dropdown-item dropdown-footer">Profile</a>--}}
                    <a href="#" class="">
                        <a href="{{url('/user/profile')}}" class="dropdown-item" style="width: 100%;text-align: center;"> <i class="fas fa-user"></i> Profile </a>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="">
                        {{--                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout--}}
                        {{--                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                        {{--                                {{ csrf_field() }}--}}
                        {{--                            </form>--}}
                        {{--                        </a>--}}
                        <a href="{{url('/apiBasedLogOut')}}" class="dropdown-item" style="width: 100%;text-align: center;"> <i class="fas fa-power-off"></i> Log Out</a>
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{url('/home')}}" class="brand-link">
{{--            <img src="{{asset('admin_src/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
            <span class="brand-text font-weight-light">Xwinkel</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
{{--                    <img src="{{asset('admin_src/img/profile/profile.png')}}d" class="img-circle elevation-2" alt="User Image">--}}
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{App\Libraries\AclHandler::getUserName()}}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
{{--            <div class="form-inline">--}}
{{--                <div class="input-group" data-widget="sidebar-search">--}}
{{--                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">--}}
{{--                    <div class="input-group-append">--}}
{{--                        <button class="btn btn-sidebar">--}}
{{--                            <i class="fas fa-search fa-fw"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="#" class=" {{ (Request::is('/home') ? 'active' : '') }}">
                            <a href="{{url('/home')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </a>
                    </li>

                    <div class="user-panel mt-1 pb-1 mb-2 d-flex"> </div>
                    <li class="nav-item">
                        <a href="{{url('/order/list')}}" class="nav-link {{ (Request::is('order/*') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <div class="user-panel mt-1 pb-1 mb-1 d-flex"> </div>
                    @if(App\Libraries\AclHandler::hasAccess('Location','full') == true)
                        <li class="nav-item">
                            <a href="{{url('/location/list')}}" class="nav-link {{ (Request::is('location/*') ? 'active' : '') }}">
                                <i class="nav-icon fas fa-map-marker"></i>
                                <p>Locations</p>
                            </a>
                        </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Shop','full') == true)
                    <li class="nav-item">
                        <a href="{{url('/shop/shop-list')}}" class="nav-link {{ (Request::is('shop/*') ? 'active' : '') }}">
                            <i class="nav-icon fas  fa-home"></i>
                            <p>Shops</p>
                        </a>
                    </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('User Creation','full') == true)
                        <li class="nav-item">
                            <a href="{{url('/admin-user/list')}}" class="nav-link {{ (Request::is('admin-user/*') ? 'active' : '') }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Admin Users</p>
                            </a>
                        </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Brand','full') == true)
                    <li class="nav-item">
                        <a href="{{url('/brand/brand-list')}}" class="nav-link {{ (Request::is('brand/*') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Brands</p>
                        </a>
                    </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Category','full') == true)
                    <li class="nav-item">
                        <a href="{{url('/category/category-list')}}" class="nav-link {{ (Request::is('category/*') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Product Var Type','full') == true)
                    <li class="nav-item">
                        <a href="{{url('/product-var-type/list')}}" class="nav-link {{ (Request::is('product-var-type/*') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-align-center"></i>
                            <p>Product Variations</p>
                        </a>
                    </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Product','full') == true)
                        <li class="nav-item">
                            <a href="{{url('/item/item-list')}}" class="nav-link {{ (Request::is('item/*') ? 'active' : '') }}">
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>Products</p>
                            </a>
                        </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('City','full') == true)
                    <li class="nav-item">
                        <a href="{{url('/city/list')}}" class="nav-link {{ (Request::is('city/*') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-map-pin"></i>
                            <p>Cities</p>
                        </a>
                    </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Coupon','full') == true)
                        <li class="nav-item">
                            <a href="{{url('/coupon/list')}}" class="nav-link {{ (Request::is('coupon/*') ? 'active' : '') }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Coupons</p>
                            </a>
                        </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Product Discount','full') == true)
                        <li class="nav-item">
                            <a href="{{url('/product-discount/list')}}" class="nav-link {{ (Request::is('product-discount/*') ? 'active' : '') }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Product Discount</p>
                            </a>
                        </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Delivery Cost','full') == true)
                        <li class="nav-item">
                            <a href="{{url('/delivery-cost/list')}}" class="nav-link {{ (Request::is('delivery-cost/*') ? 'active' : '') }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Delivery Cost</p>
                            </a>
                        </li>
                    @endif
                    @if(App\Libraries\AclHandler::hasAccess('Delivery Schedule','full') == true)
                    <li class="nav-item">
                        <a href="{{url('/delivery-schedule/list')}}" class="nav-link {{ (Request::is('delivery-schedule/*') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Delivery Schedule</p>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>


    @section('content')
    @show


    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">

        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy;{{date('Y')}} <a href="">Xwinkel</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

@section('scripts')
@show
</body>
</html>
