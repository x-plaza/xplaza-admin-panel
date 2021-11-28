@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')

    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">--}}

    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/croppie.css") }}" />

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
                                        @if(App\Libraries\AclHandler::hasAccess('Product','add') == true)
                                        <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#add-modal-lg">
                                            Add Item
                                        </button>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control shop_id_top col-md-8">
                                            @foreach(Session::get('shopList') as $shop)
                                                <option value="{{$shop->shop_id}}">{{$shop->shop_name}}</option>
                                            @endforeach
                                        </select>
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
                                            <th>Image</th>
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

    <!-- add modal -->
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

                    <div style="text-align: center">
                        <img id="image_preview" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAYAAABccqhmAAAACXBIWXMAAAsTAAALEwEAmpwYAABCQWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMwMTQgNzkuMTU2Nzk3LCAyMDE0LzA4LzIwLTA5OjUzOjAyICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgICAgICAgICAgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iCiAgICAgICAgICAgIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiCiAgICAgICAgICAgIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIgogICAgICAgICAgICB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICAgICAgICAgICB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyI+CiAgICAgICAgIDx4bXA6Q3JlYXRlRGF0ZT4yMDE1LTExLTIxVDA1OjM0OjMxWjwveG1wOkNyZWF0ZURhdGU+CiAgICAgICAgIDx4bXA6TW9kaWZ5RGF0ZT4yMDE1LTExLTIxVDEyOjQwOjEwKzA1OjMwPC94bXA6TW9kaWZ5RGF0ZT4KICAgICAgICAgPHhtcDpNZXRhZGF0YURhdGU+MjAxNS0xMS0yMVQxMjo0MDoxMCswNTozMDwveG1wOk1ldGFkYXRhRGF0ZT4KICAgICAgICAgPHhtcDpDcmVhdG9yVG9vbD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxNCAoTWFjaW50b3NoKTwveG1wOkNyZWF0b3JUb29sPgogICAgICAgICA8ZGM6Zm9ybWF0PmltYWdlL3BuZzwvZGM6Zm9ybWF0PgogICAgICAgICA8eG1wTU06SGlzdG9yeT4KICAgICAgICAgICAgPHJkZjpTZXE+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGltYWdlL3BuZyB0byBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDozQ0FDNjg0QzEwMjA2ODExODIyQUEwNjcyQ0Y4NjgyMzwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxNS0xMS0yMVQxMjoxMDoyMSswNTozMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGltYWdlL3BuZyB0byBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDozREFDNjg0QzEwMjA2ODExODIyQUEwNjcyQ0Y4NjgyMzwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxNS0xMS0yMVQxMjoxMDoyMSswNTozMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPnNhdmVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6OTg1YTVjMTAtNTQ0Ny00MGE4LWE3ODEtYmIzMjcwZDVlNDY4PC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE1LTExLTIxVDEyOjQwOjEwKzA1OjMwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxNCAoTWFjaW50b3NoKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+ZGVyaXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5jb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZzwvc3RFdnQ6cGFyYW1ldGVycz4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPnNhdmVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6ODc5ZDY5NTEtZDk1ZS00ZTQyLWE1YzQtY2VkMjYwODRlOTNlPC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE1LTExLTIxVDEyOjQwOjEwKzA1OjMwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxNCAoTWFjaW50b3NoKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOlNlcT4KICAgICAgICAgPC94bXBNTTpIaXN0b3J5PgogICAgICAgICA8eG1wTU06RGVyaXZlZEZyb20gcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICA8c3RSZWY6aW5zdGFuY2VJRD54bXAuaWlkOjk4NWE1YzEwLTU0NDctNDBhOC1hNzgxLWJiMzI3MGQ1ZTQ2ODwvc3RSZWY6aW5zdGFuY2VJRD4KICAgICAgICAgICAgPHN0UmVmOmRvY3VtZW50SUQ+eG1wLmRpZDozQ0FDNjg0QzEwMjA2ODExODIyQUEwNjcyQ0Y4NjgyMzwvc3RSZWY6ZG9jdW1lbnRJRD4KICAgICAgICAgICAgPHN0UmVmOm9yaWdpbmFsRG9jdW1lbnRJRD54bXAuZGlkOjNDQUM2ODRDMTAyMDY4MTE4MjJBQTA2NzJDRjg2ODIzPC9zdFJlZjpvcmlnaW5hbERvY3VtZW50SUQ+CiAgICAgICAgIDwveG1wTU06RGVyaXZlZEZyb20+CiAgICAgICAgIDx4bXBNTTpEb2N1bWVudElEPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDo1M2FjZTU1Mi1kMGFkLTExNzgtOGU3OS04ZjUxMjZiM2FlYjU8L3htcE1NOkRvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpJbnN0YW5jZUlEPnhtcC5paWQ6ODc5ZDY5NTEtZDk1ZS00ZTQyLWE1YzQtY2VkMjYwODRlOTNlPC94bXBNTTpJbnN0YW5jZUlEPgogICAgICAgICA8eG1wTU06T3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6M0NBQzY4NEMxMDIwNjgxMTgyMkFBMDY3MkNGODY4MjM8L3htcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHRpZmY6T3JpZW50YXRpb24+MTwvdGlmZjpPcmllbnRhdGlvbj4KICAgICAgICAgPHRpZmY6WFJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj43MjAwMDAvMTAwMDA8L3RpZmY6WVJlc29sdXRpb24+CiAgICAgICAgIDx0aWZmOlJlc29sdXRpb25Vbml0PjI8L3RpZmY6UmVzb2x1dGlvblVuaXQ+CiAgICAgICAgIDxleGlmOkNvbG9yU3BhY2U+NjU1MzU8L2V4aWY6Q29sb3JTcGFjZT4KICAgICAgICAgPGV4aWY6UGl4ZWxYRGltZW5zaW9uPjI1NjwvZXhpZjpQaXhlbFhEaW1lbnNpb24+CiAgICAgICAgIDxleGlmOlBpeGVsWURpbWVuc2lvbj4yNTY8L2V4aWY6UGl4ZWxZRGltZW5zaW9uPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAKPD94cGFja2V0IGVuZD0idyI/PpEaPkIAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAADNZJREFUeNrs3XuwVVUdwPHvBQW8PARBk7xi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" alt="image" width="120" height="100" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Item Image</label>
                        <input type="hidden" name="base64_image" class="form-control base64_image">
                        <input type="file" name="item_image" class="form-control item_image" id="upload_image" accept="image/*" />
                    </div>
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
                        <label for="exampleInputEmail1">Currency</label>
                        <select name="currency_id" class="form-control currency_id">
                            @foreach($currencies as $currency)
                                <option value="{{$currency->id}}">{{$currency->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Product Var Type</label>
                        <select name="prodvartype_id" class="form-control prodvartype_id">
                            @foreach($prodvartypes as $prodvartype)
                                <option value="{{$prodvartype->id}}">{{$prodvartype->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Product Var Type Value</label>
                        <input name="prodvartype_value" type="text" class="form-control prodvartype_value" placeholder="Enter value">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input name="quantity" type="text" class="form-control quantity" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="Enter quantity">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Buying price</label>
                        <input name="buying_price" type="text" class="form-control buying_price"   placeholder="Enter Buying price">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Selling price</label>
                        <input name="selling_price" type="text" class="form-control selling_price"  placeholder="Enter Selling price">
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

    <!-- edit modal -->
    <div class="modal fade" id="edit-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Item</h4>
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
                    <button type="button" class="btn btn-primary update_item"> <span class="spinner-icon"></span> Update </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- view modal -->
    <div class="modal fade" id="view-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="view_response_msg_area"></div>
                    <div class="view_data_content"></div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>




    <div id="uploadimageModal" class="modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 text-center">
                            <div id="image_demo" style="width:350px; margin-top:30px"></div>
                        </div>
                        <div class="col-md-2" style="padding-top:30px;">
                            <br />
                            <br />
                            <br/>
                            <button class="btn btn-success crop_image">Crop image</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.admin_common_js')

    <script src="{{ asset("admin_src/datatable/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/responsive.bootstrap.min.js") }}"></script>
    <script src="{{ asset("admin_src/croppie.js") }}"></script>

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

    <script language="javascript">

        $(document).ready(function(){

            $image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                    width:500,
                    height:500,
                    type:'square' //circle
                },
                boundary:{
                    width:520,
                    height:520
                }
            });

            $('#upload_image').on('change', function(){
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').modal('show');
            });

            $('.crop_image').click(function(event){
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response){
                    // alert(response);
                    $('.base64_image').val(response);
                    $('#image_preview').attr('src',response);
                    $('#uploadimageModal').modal('hide');
                    $('.modal').css('overflow-y', 'auto');
                    // $.ajax({
                    //     url:"upload.php",
                    //     type: "POST",
                    //     data:{"image": response},
                    //     success:function(data)
                    //     {
                    //         $('#uploadimageModal').modal('hide');
                    //         $('#uploaded_image').html(data);
                    //     }
                    // });
                })
            });

        });

        function encodeImgtoBase64(element) {
            document.getElementById('image_preview').src = window.URL.createObjectURL(element.files[0]);
            var file = element.files[0];
            var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    $('.base64_image').val(reader.result);
                  //  console.log(reader.result);
                };
        }

        function encodeImgtoBase64ForEdit(element) {
            document.getElementById('edit_image_preview').src = window.URL.createObjectURL(element.files[0]);
            var file = element.files[0];
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                $('.edit_base64_image').val(reader.result);
                //  console.log(reader.result);
            };
        }


        $(document).ready(function() {

            var image_base64 = '';
            function getItemList() {
                var shop_id = $('.shop_id_top').val();

                $('#item_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    lengthChange: false,
                    serverSide: true,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("item/get-list")}}',
                        method: 'post',
                        data: function (d) {
                            d._token = $('input[name="_token"]').val();
                            d.shop_id = shop_id;
                        }
                    },
                    columns: [
                        {data: 'image', name: 'image', searchable: false,orderable: false},
                        {data: 'name', name: 'name', searchable: true,orderable: false},
                        {data: 'description', name: 'description', searchable: true,orderable: false},
                        {data: 'buying_price', name: 'buying_price', searchable: true,orderable: false},
                        {data: 'selling_price', name: 'selling_price', searchable: true,orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getItemList();

            $(document).on('change', '.shop_id_top', function () {
                var dataTable = $('#item_list').dataTable();
                dataTable.fnDestroy();
                getItemList();
            })

            $(document).on('click', '.store_new_item', function () {
                $('.add_response_msg_area').empty();
                var item_name = $('.item_name').val();
                var description = $('.description').val();
                var shop_id = $('.shop_id').val();
                var brand_id = $('.brand_id').val();
                var category_id = $('.category_id').val();
                var buying_price = $('.buying_price').val();
                var selling_price = $('.selling_price').val();
                var currency_id = $('.currency_id').val();
                var product_var_type_id = $('.prodvartype_id').val();
                var product_var_type_value = $('.prodvartype_value').val();
                var item_image = $('.base64_image').val();
                var quantity = $('.quantity').val();

               // getBase64(item_image);
              //  console.log(image_base64);
                // var data = new FormData();
                // data.append('file', $('.item_image')[0].files[0]);
                // var size  =  $('.item_image')[0].files[0].size;
                // console.log(data);

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
                   // enctype: 'multipart/form-data',
                   // contentType: false,
                   // processData: false,
                   // dataType: 'json',
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
                        item_image: item_image,
                        quantity: quantity,
                        product_var_type_value: product_var_type_value
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

                            $('.item_name').val('');
                            $('.description').val('');
                            $('.shop_id').val('');
                            $('.brand_id').val('');
                            $('.category_id').val('');
                            $('.buying_price').val('');
                            $('.selling_price').val('');
                            $('.currency_id').val('');
                            $('.prodvartype_id').val('');
                            $('.prodvartype_value').val('');
                            $('.base64_image').val('');
                            $('.quantity').val('');

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

                var item_id = jQuery(this).data('item_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/get-item-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        item_id: item_id
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


            $(document).on('click', '.open_item_view_modal', function () {

                var item_id = jQuery(this).data('item_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/view-item-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        item_id: item_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.view_data_content').html(response.html);
                            $('#view-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });


            $(document).on('click', '.update_item', function () {
                $('.add_response_msg_area').empty();
                var item_name = $('.edit_item_name').val();
                var item_id = $('.edit_item_id').val();
                var description = $('.edit_description').val();
                var shop_id = $('.edit_shop_id').val();
                var brand_id = $('.edit_brand_id').val();
                var category_id = $('.edit_category_id').val();
                var buying_price = $('.edit_buying_price').val();
                var selling_price = $('.edit_selling_price').val();
                var quantity = $('.edit_quantity').val();
                var currency_id = $('.edit_currency_id').val();
                var product_var_type_id = $('.edit_prodvartype_id').val();
                var product_var_type_value = $('.edit_prodvartype_value').val();
                var item_image = $('.edit_base64_image').val();
                var item_image_id = $('.edit_image_id').val();
                var edit_image_name_hidden = $('.edit_image_name_hidden').val();

                if (description == '') {
                    alert("please insert description");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/item/update-item') }}',
                    type: "POST",
                    // dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        item_name: item_name,
                        item_id: item_id,
                        description: description,
                        shop_id: shop_id,
                        brand_id: brand_id,
                        category_id: category_id,
                        buying_price: buying_price,
                        selling_price: selling_price,
                        currency_id: currency_id,
                        quantity: quantity,
                        product_var_type_id: product_var_type_id,
                        item_image: item_image,
                        item_image_id: item_image_id,
                        edit_image_name_hidden: edit_image_name_hidden,
                        product_var_type_value: product_var_type_value
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

                            var dataTable = $('#item_list').dataTable();
                            dataTable.fnDestroy();
                            getItemList();

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
                        } else {
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
