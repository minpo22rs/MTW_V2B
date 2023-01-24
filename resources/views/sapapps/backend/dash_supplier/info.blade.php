@extends('sapapps.backend.inc.template')

@push('styles')
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/assets/pages/data-table/css/buttons.dataTables.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}">
<!-- Custom css -->
<link rel="stylesheet" type="text/css" href="{!! asset('resources/css/config_datatables.css') !!}">
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
                                    <h5 class="m-b-10">{{ $menu }} > {!! @$rec->supplier_name !!}</h5>
                                    <p class="text-muted m-b-10"><code>ข้อมูล</code></p>
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
                                        <table border="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="30%" height="20px"><button href="{!!url("backend/$url")!!}" class="btn btn-sm btn-grd-warning m-l-10 add" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับ"><i class="icofont icofont-line-block-left add"></i> ย้อนกลับไปหน้ารายการ </button></th>
                                                </tr>
                                                <tr>
                                                    <th height="20px">&nbsp;</th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <h4>รายละเอียดซัพพลายเออร์</h4>
                                                        <table border="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th><hr></th>
                                                                    <th><hr></th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>รหัสซัพพลายเออร์ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_id !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>ชื่อซัพพลายเออร์ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_name !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>เบอร์ติดต่อ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_phone !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>อีเมล์ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_email !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>เว็บไซต์ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_website !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>Assigned To :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! $rec->assigned_to !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th><hr></th>
                                                                    <th><hr></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <h4>Customer Infomation</h4>
                                                        <table border="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th><hr></th>
                                                                    <th><hr></th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>Taxpayer Name :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->taxpayer_name !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>Taxpayer ID :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->taxpayer_id !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th><hr></th>
                                                                    <th><hr></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <h4>ข้อมูลที่อยู่</h4>
                                                        <table border="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th><hr></th>
                                                                    <th><hr></th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>สถานที่ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_address !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>บ้านเลขที่ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_numhome !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>หมู่ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_swine !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>ซอย :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_alley !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>ถนน :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_road !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>แขวง/ตำบล :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! \App\Model\dashboard::name_subdistrict(@$rec->supplier_subdistrict) !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>เขต/อำเภอ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! \App\Model\dashboard::name_district(@$rec->supplier_district) !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>จังหวัด :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! \App\Model\dashboard::name_province(@$rec->supplier_province) !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>รหัสไปรษณีย์ :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_postcode !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th><hr></th>
                                                                    <th><hr></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <h4>ข้อมูลรายละเอียด</h4>
                                                        <table border="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th><hr></th>
                                                                    <th><hr></th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>รายละเอียด :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_detail !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>วันที่บันทึก :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_created_at !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>บันทึกโดย :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! \App\Model\dashboard::name_account(@$rec->supplier_created_at_ref_user_id) !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>วันที่แก้ไข :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! @$rec->supplier_updated_at !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                    <th width="50%" height="20px" style="padding-left:10px;">
                                                                        <div class="row">
                                                                            <div class="col-md-3" style="background-color:#B5B6B5;">
                                                                                <strong>แก้ไขล่าสุดโดย :</strong>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                {!! \App\Model\dashboard::name_account(@$rec->supplier_updated_at_ref_user_id) !!}
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th><hr></th>
                                                                    <th><hr></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>&nbsp;</th>
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

@endpush


    
