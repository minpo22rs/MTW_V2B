@extends('sapapps.backend.inc.template')

@push('styles')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{!! asset('public/backend/app-assets/vendors/css/vendors.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('public/backend/app-assets/vendors/css/forms/wizard/bs-stepper.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('public/backend/app-assets/vendors/css/forms/select/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/backend/app-assets/vendors/css/forms/form-validation.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/backend/app-assets/vendors/css/forms/form-wizard.css') !!}">
    <!-- END: Vendor CSS-->
@endpush

@section('content')
    <div class="app-content content ">
                            @include('sapapps.backend.inc.alert')
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{!! $menu !!}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">{!! $_title !!}</a>
                                    </li>
                                    <li class="breadcrumb-item active">เพิ่มข้อมูล
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Horizontal Wizard -->
                <!-- /Horizontal Wizard -->

                <!-- Vertical Wizard -->
                <form action="{{url('/backend/'.$url)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <section class="vertical-wizard">
                        <div class="bs-stepper vertical vertical-wizard-example">
                            <div class="bs-stepper-header">
                                <div class="step" data-target="#account-details-vertical" role="tab" id="account-details-vertical-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">1</span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">ข้อมูลสถานที่ท่องเที่ยว</span>
                                            <span class="bs-stepper-subtitle">รายละเอียดของสถานที่ท่องเที่ยว</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="step" data-target="#personal-info-vertical" role="tab" id="personal-info-vertical-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">2</span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">ข้อมูลภูมิภาค</span>
                                            <span class="bs-stepper-subtitle">รายละเอียดภูมิภาคของสถานที่ท่องเที่ยว</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="step" data-target="#address-step-vertical" role="tab" id="address-step-vertical-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">3</span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">รูปภาพสถานที่ท่องเที่ยว</span>
                                            <span class="bs-stepper-subtitle">รูปปก</span>
                                        </span>
                                    </button>
                                </div>
                                <!-- <div class="step" data-target="#social-links-vertical" role="tab" id="social-links-vertical-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">4</span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">Social Links</span>
                                            <span class="bs-stepper-subtitle">Add Social Links</span>
                                        </span>
                                    </button>
                                </div> -->
                            </div>
                            <div class="bs-stepper-content">
                                <div id="account-details-vertical" class="content" role="tabpanel" aria-labelledby="account-details-vertical-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">ข้อมูลสถานที่ท่องเที่ยว</h5>
                                        <small class="text-muted">กรอกรายละเอียดสถานที่ท่องเที่ยว</small>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-product-name">ชื่อสถานที่ท่องเที่ยว</label>
                                            <input type="text" name="att_name" id="vertical-product-name" class="form-control" value="{!! old('att_name') !!}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-short-descrip">รายละเอียดของสถานที่โดยย่อ</label>
                                            <textarea name="short_descrip" id="vertical-short-descrip" class="form-control">{!! old('short_descrip') !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-ful-descrip">รายละเอียดของสถานที่</label>
                                            <textarea name="full_descrip" id="vertical-ful-descrip" class="form-control">{!! old('full_descrip') !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary btn-prev" disabled>
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="personal-info-vertical" class="content" role="tabpanel" aria-labelledby="personal-info-vertical-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">ข้อมูลภูมิภาค</h5>
                                        <small>กรอกรายละเอียดภูมิภาค</small>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-unit-price">จังหวัด</label>
                                            <select class="form-select dynamic" name="att_province" id="province_id" data-dependent="district_id">
                                                {!! \App\Model\dashboard::province_option_html(( old('att_province')),'Select') !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-sale-price">อำเภอ</label>
                                            <select class="form-select dynamic" name="att_district" id="district_id" data-dependent="subdistrict_id">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-sale-price">ตำบล</label>
                                            <select class="form-select" name="att_subdistrict" id="subdistrict_id">
                                                    <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-product-name">URL Google map</label>
                                            <input type="text" name="location" id="vertical-product-name" class="form-control" value="{!! old('location') !!}">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-primary btn-prev">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="address-step-vertical" class="content" role="tabpanel" aria-labelledby="address-step-vertical-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">รูปภาพสถานที่ท่องเที่ยว</h5>
                                        <small>ลงรูปภาพสถานที่ท่องเที่ยว</small>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-cover-img">รูปปกสถานที่ท่องเที่ยว</label>
                                            <input type="file" name="cover_img_name" id="vertical-cover-img" class="form-control" value="{!! old('cover_img_name') !!}">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-primary btn-prev">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button type="submit" class="btn btn-success btn-submit">Submit</button>
                                    </div>
                                </div>
                                <!-- <div id="social-links-vertical" class="content" role="tabpanel" aria-labelledby="social-links-vertical-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Social Links</h5>
                                        <small>Enter Your Social Links.</small>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="vertical-twitter">Twitter</label>
                                            <input type="text" id="vertical-twitter" class="form-control" placeholder="https://twitter.com/abc" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="vertical-facebook">Facebook</label>
                                            <input type="text" id="vertical-facebook" class="form-control" placeholder="https://facebook.com/abc" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="vertical-google">Google+</label>
                                            <input type="text" id="vertical-google" class="form-control" placeholder="https://plus.google.com/abc" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="vertical-linkedin">Linkedin</label>
                                            <input type="text" id="vertical-linkedin" class="form-control" placeholder="https://linkedin.com/abc" />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-primary btn-prev">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button type="submit" class="btn btn-success btn-submit">Submit</button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </section>
                </form>
                <!-- /Vertical Wizard -->

                

            </div>
        </div>
    </div>
@stop


@push('scripts')

<!-- BEGIN: Page Vendor JS-->
<script src="{!! asset('public/backend/app-assets/vendors/js/forms/wizard/bs-stepper.min.js') !!}"></script>
<script src="{!! asset('public/backend/app-assets/vendors/js/forms/select/select2.full.min.js') !!}"></script>
<!-- <script src="{!! asset('public/backend/app-assets/vendors/js/forms/validation/jquery.validate.min.js') !!}"></script> -->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="{!! asset('public/backend/app-assets/js/scripts/forms/form-wizard.js') !!}"></script>
<!-- END: Page JS-->

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
                    url:"https://fti77.sapappwork.xyz/backend/fetch-address",
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
    

