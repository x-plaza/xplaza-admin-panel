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
                        <select class="form-control shop_id col-md-6">
                            @foreach(Session::get('shopList') as $shop)
                                <option value="{{$shop->shop_id}}">{{$shop->shop_name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" class="first_shop_id" value="{{$firstShop}}">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <select class="form-control shop_id month_id col-md-6">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                        </select>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="dashboard_loader" style="background-color: white;display: none;">
            <div class="canceled_list" style="text-align: center;">
                <img class="img-responsive" src="{{asset('admin_src/loading_img.gif')}}" >
            </div>
        </div>
        <div class="dashboard_content">

        </div>
        <!-- Main content -->

        <!-- /.content -->
    </div>


@endsection

@section('scripts')
    @include('layouts.admin_common_js')

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

    <script language="javascript">

        function dashboardContent(shop_id,monthId){

            $('.dashboard_loader').css({"display":"block"});
            $('.dashboard_content').empty();
            $.ajax({
                url: '{{ url('/dashboard/gate-content') }}',
                type: "POST",
                //dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    shop_id: shop_id,
                    monthId: monthId
                },
                success: function (response) {

                    $('.dashboard_loader').css({"display":"none"});

                    if (response.responseCode == 1) {
                        $('.dashboard_content').html(response.html);
                    } else {
                        $('.dashboard_content').html('<div class="alert alert-danger">\n' +
                            '                                <strong>Error!</strong> ' + response.message + '\n' +
                            '                            </div>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        }

        var first_shop_id = $('.first_shop_id').val();
        var month_id = $('.month_id').val();
        dashboardContent(first_shop_id,month_id);

        $(document).on('change', '.shop_id', function () {
            var shop_id = $('.shop_id').val();
            var monthId = $('.month_id').val();
            dashboardContent(shop_id,monthId);
        });
    </script>
@endsection
