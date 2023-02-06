@extends('sapapps.backend.inc.template')

@push('styles')
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<!-- Custom css -->
<link rel="stylesheet" type="text/css" href="{!! asset('resources/css/config_datatables.css') !!}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">
@endpush


@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{$menu}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">ร้านอาหาร</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">{{$restaurant}}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">รูปภาพร้านอาหาร</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">เพิ่มรูปภาพร้านอาหาร</h4>
                        </div>
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{url('/backend/'.$url.'/'.$id.'/imageslide')}}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="type" value="restaurant">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="mb-1 row">
                                            <div class="col-sm-12">
                                                <label class="col-form-label" for="slide_img_name">รูปภาพร้านอาหาร</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="file" id="slide_img_name" class="form-control" name="slide_img_name" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="mb-1 row form-group">
                                            <div class="col-sm-12 py-1">
                                                <button type="submit" class="btn btn-primary me-1">Submit</button>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table id="data-estate" class="datatables-basic table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>รูปภาพร้านอาหาร</th>
                                            <th>วันที่ลงข้อมูล</th>
                                            <th>วันที่อัพเดตข้อมูล</th>
                                            <th>ผู้ลงข้อมูล</th>
                                            <th>การจัดการ</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->

            </div>
        </div>
    </div>
@stop


@push('scripts')

<!-- BEGIN: Vendor JS-->
<script src="{!! asset('public/backend/app-assets/vendors/js/vendors.min.js') !!}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') !!}"></script>
<!-- <script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') !!}"></script> -->
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/jszip.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/pdfmake.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/vfs_fonts.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/buttons.print.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') !!}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{!! asset('public/backend/app-assets/js/core/app-menu.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/js/core/app.js') !!}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{!! asset('public/backend/app-assets/js/scripts/tables/table-datatables-basic.js') !!}"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var ajax = {
            "url": '{!! route($url.'.datatables_image') !!}',
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{!! csrf_token() !!}'
            },
            'data': {
                'id' : '{!! $id !!}'
            }
        };
        $('#data-estate').dataTable({
            paging: true,
            searching: true,
            scrollX: false,
            scrollํY: true,
            autoWidth: false,
            order: [[0, "asc"],[0, "desc"]],
            fixedHeader: {
                "header": false,
                "footer": false
            },
            dom: '<"html5buttons"B>lTfgtipr',
            buttons: [],
            ajax: ajax,
            columns: [
                { data: 'id',
                    render: function(data) {
                        return data;
                    },
                },
                { data: 'slide_img_name',
                    render: function(data) {
                        return data;
                    },
                },
                { data: 'created_at',
                    render: function(data) {
                        return data;
                    },
                },
                { data: 'updated_at',
                    render: function(data) {
                        return data;
                    },
                },
                { data: 'updated_at_ref_admin_id',
                    render: function(data) {
                        return data;
                    },
                },
                { data: 'manage',
                    render: function(data) {
                        return data;
                    },
                },
            ],
        });

    });
</script>
@endpush



