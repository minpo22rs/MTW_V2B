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
                            <h2 class="content-header-title float-start mb-0">DataTables</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Datatable</a>
                                    </li>
                                    <li class="breadcrumb-item active">Basic
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="app-todo.html"><i class="me-1" data-feather="check-square"></i><span class="align-middle">Todo</span></a><a class="dropdown-item" href="app-chat.html"><i class="me-1" data-feather="message-square"></i><span class="align-middle">Chat</span></a><a class="dropdown-item" href="app-email.html"><i class="me-1" data-feather="mail"></i><span class="align-middle">Email</span></a><a class="dropdown-item" href="app-calendar.html"><i class="me-1" data-feather="calendar"></i><span class="align-middle">Calendar</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <p>Read full documnetation <a href="https://datatables.net/" target="_blank">here</a></p>
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
                                            <th>2</th>
                                            <th>1</th>
                                            <th>id</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal to add new record -->
                    <div class="modal modal-slide-in fade" id="modals-slide-in">
                        <div class="modal-dialog sidebar-sm">
                            <form class="add-new-record modal-content pt-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">New Record</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-post">Post</label>
                                        <input type="text" id="basic-icon-default-post" class="form-control dt-post" placeholder="Web Developer" aria-label="Web Developer" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Email</label>
                                        <input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="john.doe@example.com" aria-label="john.doe@example.com" />
                                        <small class="form-text"> You can use letters, numbers & periods </small>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-date">Joining Date</label>
                                        <input type="text" class="form-control dt-date" id="basic-icon-default-date" placeholder="MM/DD/YYYY" aria-label="MM/DD/YYYY" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="basic-icon-default-salary">Salary</label>
                                        <input type="text" id="basic-icon-default-salary" class="form-control dt-salary" placeholder="$12000" aria-label="$12000" />
                                    </div>
                                    <button type="button" class="btn btn-primary data-submit me-1">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
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
            "url": '{!! route($url.'.datatables') !!}', 
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{!! csrf_token() !!}'
            },
            'data': {
                
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
                { data: 'product_no',
                    render: function(data) {
                        return '<span><b>'+data+'</b></span>';
                    },
                },
                { data: 'images',
                    render: function(data) {
                        return '<img src="https://kw-thailand.com/images'+data+'" title="'+data+'" width="400px">';
                    },
                },   
                { data: 'product_no',
                    render: function(data) {
                        return '<button href="{!!url("backend/home_imageSlider/'+data+'")!!}" class="btn btn-sm btn-grd-info m-l-10 add" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเพิ่มรูปภาพ"><i class="icofont icofont-plus add"></i> Gallery Images</button>'+
                        '<br><br><button href="{!!url("backend/home_descrip/'+data+'")!!}" class="btn btn-sm btn-grd-info m-l-10 add" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเพิ่มรายละเอียด"><i class="icofont icofont-plus add"></i> Description </button>'+
                        '<br><br><button href="{!!url("backend/home_position/'+data+'")!!}" class="btn btn-sm btn-grd-info m-l-10 add" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเพิ่มสถานที่ตั้ง"><i class="icofont icofont-plus add"></i> Latitude & Longitude</button>';
                    },
                },        
            ],
        });
        
    });
</script>
@endpush


    
