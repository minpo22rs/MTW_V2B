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
                                                        <h3> ข้อมูลร้านอาหาร </h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <button class="btn btn-grd-warning" id="back" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับไปหน้ารายการ"><i class="icofont icofont-line-block-left"></i>ย้อนกลับ</button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ชื่อร้านอาหาร <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="restaurant_name" type="text" class="form-control" value="{{ old('restaurant_name') ? old('restaurant_name') : $rec->restaurant_name }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ชื่อซัพพลายเออร์ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name="restaurant_supplier">
                                                                        {!! \App\Model\dashboard::supplier_option_html(( old('restaurant_supplier') ? old('restaurant_supplier') : $rec->restaurant_supplier) ,'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ประเภทร้านอาหาร <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name="restaurant_type">
                                                                        {!! \App\Model\dashboard::type_option_html(( old('restaurant_type') ? old('restaurant_type') : $rec->restaurant_type) ,'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">หมวดร้านอาหาร <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name="restaurant_category">
                                                                        {!! \App\Model\dashboard::category_option_html(( old('restaurant_category') ? old('restaurant_category') : $rec->restaurant_category) ,'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ลิ้งร้านอาหาร</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="restaurant_url" type="text" class="form-control" value="{{ old('restaurant_url') ? old('restaurant_url') : $rec->restaurant_url }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ผู้ดูแลร้านอาหาร <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name="restaurant_ref_admin">
                                                                        {!! \App\Model\dashboard::merchandize_option_html(( old('restaurant_ref_admin') ? old('restaurant_ref_admin') : $rec->restaurant_ref_admin) ,'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </fieldset>
                                                        <h3> ข้อมูลราคา </h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">หน่วยนับ</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name="restaurant_attribute">
                                                                        {!! \App\Model\dashboard::attribute_option_html(( old('restaurant_attribute') ? old('restaurant_attribute') : $rec->restaurant_attribute) ,'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ราคาขายต่อหน่วย</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="restaurant_unit_price" type="text" class="form-control" value="{{ old('restaurant_unit_price') ? old('restaurant_unit_price') : $rec->restaurant_unit_price }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ระดับแจ้งเตือนใกล้หมด</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="restaurant_noti_few" type="text" class="form-control" value="{{ old('restaurant_noti_few') ? old('restaurant_noti_few') : $rec->restaurant_noti_few }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ระยะเวลาการใช้/Dose</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="restaurant_round_use" type="text" class="form-control" value="{{ old('restaurant_round_use') ? old('restaurant_round_use') : $rec->restaurant_round_use }}" >
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <h3> ข้อมูลอื่นๆ</h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">วันที่เปิดขาย</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="restaurant_open" type="date" class="form-control" value="{{ old('restaurant_open') ? old('restaurant_open') : $rec->restaurant_open }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">วันที่ปิดขาย</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="restaurant_end" type="date" class="form-control" value="{{ old('restaurant_end') ? old('restaurant_end') : $rec->restaurant_end }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">SKU Code</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="restaurant_barcode" type="text" class="form-control" value="{{ old('restaurant_barcode') ? old('restaurant_barcode') : $rec->restaurant_barcode }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">สถานะการขาย</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-radio">
                                                                        <div class="radio radiofill radio-primary radio-inline">
                                                                            <label>
                                                                                <input type="radio" name="restaurant_active" value="1" data-bv-field="restaurant_active"
                                                                                {{ old('restaurant_active') == 1 ? 'checked' : ($rec->restaurant_active == '1' ? 'checked' : '') }}>
                                                                                <i class="helper"></i>On
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio radiofill radio-primary radio-inline">
                                                                            <label>
                                                                                <input type="radio" name="restaurant_active" value="0" data-bv-field="restaurant_active"
                                                                                {{  old('restaurant_active') && old('restaurant_active') == 0 ? 'checked' : ($rec->restaurant_active == '0' ? 'checked' : '') }}>
                                                                                <i class="helper"></i>Off
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <span class="messages"></span>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </fieldset>
                                                        <h3> ข้อมูลรูปร้านอาหาร </h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">รูปร้านอาหาร </label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <img  name="restaurant_img_name" style="max-height:150px; max-width:100%; display:block;" class="m-b-5"
                                                                    src="{{ url('storage/app/public/image/restaurants/'.$rec->restaurant_img_name)  }}">
                                                                    <input name="restaurant_img_name" type="file"  class="form-control img"
                                                                    value="{{ old('restaurant_img_name') ? old('restaurant_img_name') : $rec->restaurant_img_name }}" >
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
        window.browse_img_preview('img[name="restaurant_img_name"]');

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
                    url:"fetch-address",
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


