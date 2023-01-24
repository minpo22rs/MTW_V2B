@extends('sapapps.backend.inc.template')

@push('styles')
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/assets/pages/data-table/css/buttons.dataTables.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}">
<!-- Custom css -->
<link rel="stylesheet" type="text/css" href="{!! asset('resources/css/config_datatables.css') !!}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">  
@endpush


@section('content')  
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">                                                
                            <!-- Scroll - Vertical, Dynamic Height table start -->
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="m-b-10">{{ $menu }}</h5>
                                    <p class="text-muted m-b-10"><code>รายการ</code></p>
                                    <ul class="breadcrumb-title b-t-default p-t-10">
                                        <li class="breadcrumb-item">
                                            <a href="{!! url("backend/$url") !!}"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">การขาย</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">{{ $menu }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="data-table_{{$url}}" class="table table-bordered table-hover table-striped table-condensed nowrap">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <th width="10">#</th>
                                                    <th>Manage</th>
                                                    <th>สถานะ</th>
                                                    <th>เลขที่ใบสั่งซื้อ</th>
                                                    <th>ชื่อ</th>
                                                    <th>นามสกุล</th>
                                                    <th>รวม</th>
                                                    <th>พนักงาน</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Scroll - Vertical, Dynamic Height table end -->
                        </div>
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
        <!-- Main-body end -->
        <div id="styleSelector">

        </div>
    </div>
</div>
@stop


@push('scripts')
<!-- data-table js -->
<script src="{!! asset('public/backend/files/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('public/backend/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') !!}"></script>
<script src="{!! asset('public/backend/files/assets/pages/data-table/js/jszip.min.js') !!}"></script>
<script src="{!! asset('public/backend/files/assets/pages/data-table/js/pdfmake.min.js') !!}"></script>
<script src="{!! asset('public/backend/files/assets/pages/data-table/js/vfs_fonts.js') !!}"></script>
<script src="{!! asset('public/backend/files/bower_components/datatables.net-buttons/js/buttons.print.min.js') !!}"></script>
<script src="{!! asset('public/backend/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js') !!}"></script>
<script src="{!! asset('public/backend/files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('public/backend/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') !!}"></script>
<script src="{!! asset('public/backend/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') !!}"></script>
<!-- Custom js -->
<script src="{!! asset('resources/js/config_datatables.js') !!}"></script>
<script src="{!! asset('resources/js/app.js') !!}"></script>

<script type="text/javascript">
    $(document).ready(function(){

        var sorting = [[ 0, 'desc' ], [ 0, 'desc' ]];
        var tbl_id = 'data-table_{{$url}}';
        var ajax = {
            "url": '{!! route($url.'.datatables') !!}', 
            "type": "POST",
            'headers': {
                'X-CSRF-TOKEN': '{!! csrf_token() !!}'
            },
            'data': {
                
            }
        }; 

        var table = $('#'+tbl_id).DataTable({
            scrollY: '350px',
            scrollX: true,
            autoWidth: true,

            processing: true,
            serverSide: true,
            stateSave: true,
            iDisplayLength: window.iDisplayLength,
            aLengthMenu: window.aLengthMenu,
            ajax: ajax,
            columns: [
                { data: 'id', 
                    name: 'id', 
                        class: 'text-center', searchable: false, orderable: true, width: '50px' 
                },
                { data: 'manage', 
                    name: 'manage',
                        class: 'text-center', searchable: false, orderable: false, width: '70px'  
                },
                { data: 'so_status', 
                    name: 'so.so_status',
                        class: 'text-left info', searchable: true, orderable: false, width: '10%'  
                },
                { data: 'so_num_id', 
                    name: 'so.so_num_id',
                        class: 'text-left info', searchable: true, orderable: false, width: '25%'  
                },
                { data: 'customer_name', 
                    name: 'c.customer_name',
                        class: 'text-left success', searchable: true, orderable: false, width: '40%'  
                },
                { data: 'customer_lastname', 
                    name: 'c.customer_lastname',
                        class: 'text-left success', searchable: true, orderable: false, width: '40%'  
                },
                { data: 'so_sum_price', 
                    name: 'so.so_sum_price',
                        class: 'text-left', searchable: true, orderable: false, width: '17%'  
                },
                { data: 'so_created_at_ref_user_id', 
                    name: 'so.so_created_at_ref_user_id',
                        class: 'text-left info', searchable: true, orderable: false, width: '17%'  
                },
            ],
            aaSorting: sorting,
            oLanguage: window.lang_dt,
            select: window.select_dt,
            dom: '<"html5buttons"B>lTfgtipr',
            buttons: ['excel', 'print'], /*['copy', 'csv', 'excel', 'pdf', 'print']*/
            fnInitComplete : function(oSettings, json) {
                var dts = $(this).parents('.dataTables_scroll').find('table:first thead:first tr:first th');
                window.dt_show_search(oSettings, json, dts);

                //Tooltip Init
                $('[data-toggle="tooltip"]').tooltip();

                //Hide Duplicate thead
                $('.dataTables_scrollBody thead tr').css({visibility:'collapse'});
            },
            drawCallback : function(oSettings) {
                //Hide Duplicate thead
                $('.dataTables_scrollBody thead tr').css({visibility:'collapse'});
            }
        });


        var dt = $('#'+tbl_id).parents('.dataTables_scroll').find('table:first thead:first tr:first th');
        var hide = [0,1]; //นับจาก Column
        var class_input = 'input_search';
        var clear_id = 'reset_datatables';
        var tbl = table;
        var select = {
            
        };
        //Show Input Search By Column
        window.dt_gen_input(dt, hide, class_input, select);

        //Keyup Search By Column
        window.dt_key_search(class_input, tbl);

        // Clear Search
        window.dt_clear_search(clear_id, class_input, tbl, sorting);

        // ปุ่มล้างข้อมูล State Save
        var button_add = '<button href="{!!url("backend/$url/create")!!}" class="btn btn-sm btn-grd-primary m-l-10 add" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเพิ่มข้อมูลรายการใหม่"><i class="icofont icofont-plus add"></i> เพิ่มข้อมูล</button>';
        var button_update = '<button url="{!!url("backend/$url")!!}" class="btn btn-sm btn-grd-primary m-l-10 edit" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อแก้ไขข้อมูลจากรายการที่เลือก"><i class="icofont icofont-edit"></i> แก้ไขข้อมูล</button>';
        var button_delete = '<button url="{!!url("backend/$url")!!}" class="btn btn-sm btn-grd-danger m-l-10 delete" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อลบข้อมูลจากรายการที่เลือก"><i class="icofont icofont-eraser"></i> ลบข้อมูล</button>';
        var button_clear = '<button type="button" id="'+clear_id+'" class="btn btn-sm btn-grd-danger m-l-10" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อล้างการค้นหาที่เคยค้นหาไว้ ในทุกคอลัมน์"><i class="fa fa-refresh"></i> ล้างการค้นหาข้อมูล</button>';

        // ปุ่ม - ด้านซ้าย
        $('#'+tbl_id+'_length').append();
        // ปุ่มล้างข้อมูล state_save - ด้านขวา
        $('#'+tbl_id+'_filter').append(button_clear);


        var route = '{!! route('ajax.store') !!}';
        var token = '{!! csrf_token() !!}';

    });
</script>
@endpush


    
