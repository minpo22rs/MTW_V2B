@extends('sapapps.backend.inc.template')

@push('styles')
<!--forms-wizard css-->
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/bower_components/jquery.steps/css/jquery.steps.css') !!}">
<!-- Custom css -->
<link rel="stylesheet" type="text/css" href="{!! asset('resources/css/app.css') !!}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">  
<style>
    .wizard.vertical > .content {
        height: 500px !important;
        overflow-y: scroll;
    }
</style>
@endpush

@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @include('sapapps.backend.inc.alert')
                            <!-- Verticle Wizard card start -->
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="m-b-10">{{ $menu }}</h5>
                                    <p class="text-muted m-b-10"><code>แก้ไขข้อมูล</code></p>
                                    <ul class="breadcrumb-title b-t-default p-t-10">
                                        <li class="breadcrumb-item">
                                            <a href="{!! url("backend/$url") !!}""> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">การขาย</a>
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
                                                    <form class="wizard-form" id="verticle-wizard-validate" action="{{url('/backend/'.$url.'/'.$id)}}" method="POST" enctype="multipart/form-data">
                                                        <input name="_method" type="hidden" value="PUT">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <h3> รายละเอียดผู้ใช้ </h3>
                                                        <fieldset>
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
                                                                        <option value="admin" <?php if($rec->role == 'admin') { echo 'selected'; } ?>>Admin</option>
                                                                        <option value="merchandize" <?php if($rec->role == 'merchandize') { echo 'selected'; } ?>>Merchandize</option>
                                                                        <option value="supervisor" <?php if($rec->role == 'supervisor') { echo 'selected'; } ?>>Supervisor</option>
                                                                        <option value="fulillment" <?php if($rec->role == 'fulillment') { echo 'selected'; } ?>>Fulillment</option>
                                                                        <option value="agent" <?php if($rec->role == 'agent') { echo 'selected'; } ?>>Agent</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Email <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="email" type="email" class="form-control" value="{{ old('email') ? old('email') : $rec->email }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ชื่อ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="name" type="text" class="form-control" value="{{ old('name') ? old('name') : $rec->name }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Username <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="username" type="text" class="form-control" value="{{ old('username') ? old('username') : $rec->username }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">New Password </label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="password" type="password" class="form-control" value="" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ยอดเป้าหมาย <span class="text-danger ">สำหรับ role agent เท่านั้น</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="cost_target" type="number" class="form-control" value="{{ old('cost_target') ? old('cost_target') : $rec->cost_target }}" >
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </fieldset>
                                                        <h3> รูปภาพ</h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Image </label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <img  name="img_name" style="max-height:150px; max-width:100%; display:block;" class="m-b-5" 
                                                                    src="{{ url('storage/app/public/image/profile/'.$rec->img_name)  }}">
                                                                    <input name="img_name" type="file"  class="form-control img" data-toggle="tooltip" data-original-title="เลือกไฟล์ภาพจากในเครื่อง ขนาดภาพ 1600 x 57px เพื่อให้ภาพแสดงผลได้ถูกต้อง" data-placement="left"
                                                                    value="{{ old('img_name') ? old('img_name') : $rec->img_name }}" >
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </form>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Verticle Wizard card end -->
                        </div>
                    </div>
                </div>
                <!-- Page body end -->
            </div>
        </div>
        <!-- Main-body end -->

        <div id="styleSelector">

        </div>
    </div>
</div>
@stop


@push('scripts')
<!--Forms - Wizard js-->
<script src="{!! asset('public/backend/files/bower_components/jquery.cookie/js/jquery.cookie.js') !!}"></script>
<script src="{!! asset('public/backend/files/bower_components/jquery.steps/js/jquery.steps.js') !!}"></script>
<script src="{!! asset('public/backend/files/bower_components/jquery-validation/js/jquery.validate.js') !!}"></script>
<!-- Validation js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script  src="{!! asset('public/backend/files/assets/pages/form-validation/validate.js') !!}"></script>
<!-- Custom js -->
<script src="{!! asset('public/backend/files/assets/pages/forms-wizard-validation/form-wizard.js') !!}"></script>
<script src="{!! asset('public/backend/ckeditor/ckeditor.js') !!}"></script>
<script src="{!! asset('public/backend/ckeditor/adapters/jquery.js') !!}"></script>
<script src="{!! asset('resources/js/app.js') !!}"></script>


<script type="text/javascript">
    $(document).ready(function(){
        
        
        /////////////// Event ///////////////////////
        window.browse_img_preview('img[name="img_name"]');

        setTimeout(function(){
            var token = '{!! csrf_token() !!}';
            var url = '{!! asset('') !!}';
        },1000);

        /////////////// Fixed ///////////////////////
        window.back('{!! url("backend/$url") !!}');
        window.validate_step('#verticle-wizard-validate');
        
    });
</script>
<script>
    $(document).ready(function(){
        $('.dynamic').change(function(){
            if($(this).val() != '')
            {
                var select = $(this).attr("id");
                var value = $(this).val();
                
                
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"https://sapappwork.xyz/backend/fetch-address",
                    method:"POST",
                    data:{select:select, value:value, _token:_token, dependent:dependent},
                    success:function(result)
                    {
                        console.log(result);
                        $('#'+dependent).html(result);
                    }
                })
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('.dynamic-2').change(function(){
            if($(this).val() != '')
            {
                var select = $(this).attr("id");
                var value = $(this).val();
                
                
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"https://sapappwork.xyz/backend/fetch-address",
                    method:"POST",
                    data:{select:select, value:value, _token:_token, dependent:dependent},
                    success:function(result)
                    {
                        console.log(result);
                        $('#'+dependent).html(result);
                    }
                })
            }
        });
    });
</script>
@endpush
    

