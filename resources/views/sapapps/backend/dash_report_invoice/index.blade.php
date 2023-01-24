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
                                        <li class="breadcrumb-item"><a href="#!">{{ $menu }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="data-table_{{$url}}" class="table table-bordered table-hover table-striped table-condensed nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Invoic No.</th>
                                                    <th>Invoicedate</th>
                                                    <th>Saleorderdate</th>
                                                    <th>Invoicestatus</th>
                                                    <th>Carrier</th>
                                                    <th>Paymenttype</th>
                                                    <th>Paymentmethod</th>
                                                    <th>Total amount</th>
                                                    <th>Tracking No.</th>
                                                    <th>Sales No.</th>
                                                    <th>Sales Name</th>
                                                    <th>Customer No.</th>
                                                    <th>Customer Name</th>
                                                    <th>Leadsource</th>
                                                    <th>Product No.</th>
                                                    <th>Product Name</th>
                                                    <th>ราคาขาย</th>
                                                    <th>Quantity</th>
                                                    <th>Discount amount</th>
                                                    <th>Amount</th>
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
            scrollY: '550px',
            scrollX: true,
            autoWidth: true,

            processing: true,
            serverSide: true,
            stateSave: true,
            iDisplayLength: window.iDisplayLength,
            aLengthMenu: window.aLengthMenu,
            ajax: ajax,
            columns: [
                { data: 'so_inv_num', 
                    name: 'so.so_inv_num',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                },
                { data: 'so_inv_date', 
                    name: 'so.so_inv_date',
                        class: 'text-left success', searchable: true, orderable: false, width: '100px'  
                },
                { data: 'so_date', 
                    name: 'so.so_date',
                        class: 'text-center', searchable: true, orderable: false, width: '100px'  
                },
                { data: 'so_status', 
                    name: 'so.so_status',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                },
                { data: 'so_shipping_type', 
                    name: 'so.so_shipping_type',
                        class: 'text-left info', searchable: true, orderable: false, width: '50px'  
                },
                { data: 'paymenttype', 
                    name: 'paymenttype',
                        class: 'text-left info', searchable: false, orderable: false, width: '100px'  
                }    ,
                { data: 'so_pay_type', 
                    name: 'so.so_pay_type',
                        class: 'text-left info', searchable: true, orderable: false, width: '50px'  
                },
                { data: 'so_sum_price', 
                    name: 'so.so_sum_price',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }     ,
                { data: 'so_tracking', 
                    name: 'so.so_tracking',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }     ,
                { data: 'username', 
                    name: 'ad.username',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }     ,
                { data: 'name', 
                    name: 'ad.name',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }     ,
                { data: 'customer_mem_id', 
                    name: 'c.customer_mem_id',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }     ,
                { data: 'customer_name', 
                    name: 'c.customer_name',
                        class: 'text-left info', searchable: false, orderable: false, width: '100px'  
                }     ,
                { data: 'customer_ref_data', 
                    name: 'c.customer_ref_data',
                        class: 'text-left info', searchable: true, orderable: false, width: '50px'  
                }     ,
                { data: 'product_no', 
                    name: 'p.product_no',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }     ,
                { data: 'product_name', 
                    name: 'p.product_name',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }          ,
                { data: 'product_unit_price', 
                    name: 'p.product_unit_price',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }        ,
                { data: 'product_qty', 
                    name: 'po.product_qty',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }        ,
                { data: 'product_discount', 
                    name: 'po.product_discount',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }        ,
                { data: 'product_sum_price', 
                    name: 'po.product_sum_price',
                        class: 'text-left info', searchable: true, orderable: false, width: '100px'  
                }         
            ],
            aaSorting: sorting,
            oLanguage: window.lang_dt,
            select: window.select_dt,
            dom: '<"html5buttons"B>lTfgtipr',
            buttons: ['excel'], /*['copy', 'csv', 'excel', 'pdf', 'print']*/
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
        window.dt_key_search(class_input, tbl);

        // Clear Search
        window.dt_clear_search(clear_id, class_input, tbl, sorting);
        var button_clear = '<button type="button" id="'+clear_id+'" class="btn btn-sm btn-grd-danger m-l-10" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อล้างการค้นหาที่เคยค้นหาไว้ ในทุกคอลัมน์"><i class="fa fa-refresh"></i> ล้างการค้นหาข้อมูล</button>';

        // ปุ่มล้างข้อมูล state_save - ด้านขวา
        $('#'+tbl_id+'_filter').append(button_clear);

    });
</script>
@endpush


    
