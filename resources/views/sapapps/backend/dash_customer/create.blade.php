@extends('sapapps.backend.inc.template')

@push('styles')
<!--forms-wizard css-->
<link rel="stylesheet" type="text/css" href="{!! asset('public/backend/files/bower_components/jquery.steps/css/jquery.steps.css') !!}">
<!-- Custom css -->
<link rel="stylesheet" type="text/css" href="{!! asset('resources/css/app.css') !!}">
<style>
    .wizard.vertical > .content {
        height: 400px !important;
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
                                    <p class="text-muted m-b-10"><code>เพิ่มข้อมูล</code></p>
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
                                                    <form class="wizard-form" id="verticle-wizard-validate" action="{{url('/backend/'.$url)}}" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <input type="hidden" name="customer_order" value="0">
                                                        <h3> รายละเอียดลูกค้า </h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <button class="btn btn-grd-warning" id="back" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับไปหน้ารายการ"><i class="icofont icofont-line-block-left"></i>ย้อนกลับ</button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ชื่อ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_name" type="text" class="form-control" value="{{ old('customer_name') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">นามสกุล <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_lastname" type="text" class="form-control" value="{{ old('customer_lastname') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">เบอร์ติดต่อ</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_phone" type="text" class="form-control" value="{{ old('customer_phone') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">แหล่งที่มาข้อมูล</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_ref_data" type="text" class="form-control" value="{{ old('customer_ref_data') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ประเภทข้อมูล</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_contact_type" type="text" class="form-control" value="{{ old('customer_contact_type') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">หมายเหตุ</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_remark" type="text" class="form-control" value="{{ old('customer_remark') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">Assigned To <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name="ref_sale_id">
                                                                        {!! \App\Model\dashboard::assigned_option_html(( old('assigned_to')),'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </fieldset>
                                                        <h3> ที่อยู่สำหรับ Invoice </h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ชื่อ Invoice<span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_i_name" type="text" class="form-control" value="{{ old('customer_i_name') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">นามสกุล Invoice<span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_i_lastname" type="text" class="form-control" value="{{ old('customer_i_lastname') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">สถานที่</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <Textarea class="form-control" name="customer_i_address" value="{{ old('customer_i_address') }}"></Textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">จังหวัด <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control dynamic" name="customer_i_province" id="province_id" data-dependent="district_id">
                                                                        {!! \App\Model\dashboard::province_option_html(( old('customer_i_province')),'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">เขต/อำเภอ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control dynamic" name="customer_i_district" id="district_id" data-dependent="subdistrict_id">
                                                                        <option value="">Select</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">แขวง/ตำบล <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                <select class="form-control" name="customer_i_subdistrict" id="subdistrict_id">
                                                                        <option value="">Select</option>
                                                                </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">รหัสไปรษณีย์ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_i_postcode" type="text" class="form-control" value="{{ old('customer_i_postcode') }}" >
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </fieldset>
                                                        <h3> ที่อยู่สำหรับ Shipping </h3>
                                                        <fieldset>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">ชื่อ Shipping<span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_s_name" type="text" class="form-control" value="{{ old('customer_s_name') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">นามสกุล Shipping<span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_s_lastname" type="text" class="form-control" value="{{ old('customer_s_lastname') }}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">สถานที่</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <Textarea class="form-control" name="customer_s_address" value="{{ old('customer_s_address') }}"></Textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">จังหวัด <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control dynamic-2" name="customer_s_province" id="province_s_id" data-dependent="district_s_id">
                                                                        {!! \App\Model\dashboard::province_option_html(( old('faq_tag_id')),'Select') !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">เขต/อำเภอ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control dynamic-2" name="customer_s_district" id="district_s_id" data-dependent="subdistrict_s_id">
                                                                        <option value="">Select</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">แขวง/ตำบล <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                <select class="form-control" name="customer_s_subdistrict" id="subdistrict_s_id">
                                                                        <option value="">Select</option>
                                                                </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="block">รหัสไปรษณีย์ <span class="text-danger ">*</span></label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input name="customer_s_postcode" type="text" class="form-control" value="{{ old('customer_s_postcode') }}" >
                                                                </div>
                                                            </div>
                                                            <br>
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
                    url:"https://ev9.sapappwork.xyz/backend/fetch-address",
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
                    url:"https://ev9.sapappwork.xyz/backend/fetch-address",
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
    

