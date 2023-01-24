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
                            @include('sapapps.backend.inc.alert')                                            
                            <!-- Scroll - Vertical, Dynamic Height table start -->
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="m-b-10">{{ $menu }}</h5>
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="wizardb">
                                                <section>
                                                    <form class="wizard-form" id="verticle-wizard-validate" action="{{url('/backend/'.$url)}}" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <button class="btn btn-grd-warning" id="back" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับไปหน้ารายการ"><i class="icofont icofont-line-block-left"></i>ย้อนกลับ</button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Role<span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name="role">
                                                                        <option value="admin">Admin</option>
                                                                        <option value="merchandize">Merchandize</option>
                                                                        <option value="supervisor">Supervisor</option>
                                                                        <option value="fulillment">Fulillment</option>
                                                                        <option value="agent">Agent</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Email <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="email" type="email" class="form-control" value="{{ old('email') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ชื่อ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="name" type="text" class="form-control" value="{{ old('name') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Username <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="username" type="text" class="form-control" value="{{ old('username') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Password <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="password" type="password" class="form-control" value="{{ old('password') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ยอดเป้าหมาย <span class="text-danger ">สำหรับ role agent เท่านั้น</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="cost_target" type="number" class="form-control" value="{{ old('cost_target') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">รูปผู้ใช้</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <img  name="img_name" style="max-height:150px; max-width:100%; display:block;" class="m-b-5">
                                                                    <input name="img_name" type="file"  class="form-control img required" data-toggle="tooltip" data-original-title="เลือกไฟล์ภาพจากในเครื่อง ขนาดภาพ ratio 1:1 เพื่อให้ภาพแสดงผลได้ถูกต้อง" data-placement="left">
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <button class="btn btn-primary" type="submit">ยืนยัน</button>
                                                                </div>
                                                            </div>
                                                            <br>
                                                    </form>
                                                </section>
                                            </div>
                                        </div>
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
        $('button#back').click(function(e){
            e.preventDefault();
            window.location.href = '{!! url("backend/$url") !!}';
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        	

        /////////////// Event ///////////////////////
        window.browse_img_preview('img[name="img_name"]');

        /////////////// Fixed ///////////////////////
        window.back('{!! url("backend/$url") !!}');
        window.validate_step('#verticle-wizard-validate');
        
    });
</script>
@endpush


    
