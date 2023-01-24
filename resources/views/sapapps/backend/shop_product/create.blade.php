@extends('traceon.backend.inc.template')

@push('styles')
<!--forms-wizard css-->
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/bower_components/jquery.steps/css/jquery.steps.css') !!}">
<!-- Custom css -->
<link rel="stylesheet" type="text/css" href="{!! asset('resources/css/app.css') !!}">
<style>
    .wizard.vertical > .content {
        height: 700px !important;
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
                            @include('traceon.backend.inc.alert')
                            <!-- Verticle Wizard card start -->
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="m-b-10">{{ $menu }}</h5>
                                    <p class="text-muted m-b-10"><code>เพิ่มข้อมูล</code></p>
                                    <ul class="breadcrumb-title b-t-default p-t-10">
                                        <li class="breadcrumb-item">
                                            <a href="{!! url("backend/$url") !!}""> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Frontend</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Shop</a>
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
                                                        <h3> Basic Info </h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <button class="btn btn-grd-warning" id="back" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับไปหน้ารายการ"><i class="icofont icofont-line-block-left"></i>ย้อนกลับ</button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-12">Active</label>
                                                                <div class="col-sm-12">
                                                                    <div class="form-radio">
                                                                        <div class="radio radiofill radio-primary radio-inline">
                                                                            <label>
                                                                                <input type="radio" name="product_active" value="1" data-bv-field="product_active" 
                                                                                {{ old('product_active') == '1' ? 'checked' : (!old('product_active') ? 'checked' : '') }}>
                                                                                <i class="helper"></i>On
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio radiofill radio-primary radio-inline">
                                                                            <label>
                                                                                <input type="radio" name="product_active" value="0" data-bv-field="product_active" 
                                                                                {{  old('product_active') && old('product_active') == '0' ? 'checked' : '' }}>
                                                                                <i class="helper"></i>Off
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <span class="messages"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Sort</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_sort" type="text" class="form-control" data-toggle="tooltip" data-original-title="ใส่เลขเพื่อเรียงลำดับ 1 - 99" data-placement="left"
                                                                    value="{{ old('product_sort') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Type <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select name="product_type" class="form-control">
                                                                        {!! \App\Model\front_shop::product_type_option_html(( old('product_type')),'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Category <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select name="ref_category_id" class="form-control">
                                                                        {!! \App\Model\front_shop::category_option_html(( old('ref_category_id')),'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <h3>Product Detial EN</h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Product <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_name" type="text" class="form-control" value="{{ old('product_name') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Detail <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <textarea name="product_detail" type="text" class="form-control" >{{ old('product_detail') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Ingredients <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <textarea name="product_ingredients" type="text" class="form-control">{{ old('product_ingredients') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <h3>Product Detial TH</h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ชื่อสินค้า <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_name_th" type="text" class="form-control" value="{{ old('product_name_th') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">รายละเอียด <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <textarea name="product_detail_th" type="text" class="form-control" >{{ old('product_detail_th') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ส่วนประกอบ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <textarea name="product_ingredients_th" type="text" class="form-control">{{ old('product_ingredients_th') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <h3>More Detail</h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Normal Price </label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_normal_price" type="text" class="form-control" value="{{ old('product_normal_price') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Sale Price <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_discount_price" type="text" class="form-control" value="{{ old('product_discount_price') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Attribute <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select name="product_attribute" class="form-control">
                                                                        {!! \App\Model\master::attribute_option_html(( old('product_attribute')),'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ปริมาณ/จำนวน <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_value" type="text" class="form-control" value="{{ old('product_value') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">น้ำหนัก (เป็น Kilogram) <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_weight" type="text" class="form-control" value="{{ old('product_weight') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">กว้าง (เป็น Centimeters) <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_width" type="text" class="form-control" value="{{ old('product_width') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ยาว (เป็น Centimeters) <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_long" type="text" class="form-control" value="{{ old('product_long') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">สูง (เป็น Centimeters) <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="product_height" type="text" class="form-control" value="{{ old('product_height') }}" >
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <h3>Meta</h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Title </label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <textarea name="product_meta_title" type="text" class="form-control">{{ old('product_meta_title') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Keyword </label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <textarea name="product_meta_keyword" type="text" class="form-control">{{ old('product_meta_keyword') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Description </label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <textarea name="product_meta_description" type="text" class="form-control">{{ old('product_meta_description') }}</textarea>
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
        $('button#back').click(function(e){
            e.preventDefault();
            window.location.href = '{!! url("backend/$url") !!}';
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        	

        /////////////// Event ///////////////////////

        setTimeout(function(){
            var token = '{!! csrf_token() !!}';
            var url = '{!! asset('') !!}';
            window.ckeditor(token,url,'textarea[name="product_detail"]','100%','200');
            window.ckeditor(token,url,'textarea[name="product_detail_th"]','100%','200');
            window.ckeditor(token,url,'textarea[name="product_ingredients"]','100%','200');
            window.ckeditor(token,url,'textarea[name="product_ingredients_th"]','100%','200');
        },1000);

        /////////////// Fixed ///////////////////////
        window.back('{!! url("backend/$url") !!}');
        window.validate_step('#verticle-wizard-validate');
        
    });
</script>
@endpush
    

