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
                                    <li class="breadcrumb-item"><a href="index.html">ร้านอาหาร</a>
                                    </li>
                                    <li class="breadcrumb-item active">แก้ไขข้อมูล
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
                <form action="{{url('/backend/'.$url.'/'.$id)}}" method="POST" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <section class="vertical-wizard">
                        <div class="bs-stepper vertical vertical-wizard-example">
                            <div class="bs-stepper-header">
                                <div class="step" data-target="#account-details-vertical" role="tab" id="account-details-vertical-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">1</span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">ข้อมูลร้านอาหาร</span>
                                            <span class="bs-stepper-subtitle">รายละเอียดของร้านอาหาร</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="step" data-target="#personal-info-vertical" role="tab" id="personal-info-vertical-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">2</span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">ข้อมูลราคาร้านอาหาร</span>
                                            <span class="bs-stepper-subtitle">สกุลเงินบาทไทย</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="step" data-target="#address-step-vertical" role="tab" id="address-step-vertical-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">3</span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">รูปภาพร้านอาหาร</span>
                                            <span class="bs-stepper-subtitle">รูปปกและรูปสไลด์</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <div id="account-details-vertical" class="content" role="tabpanel" aria-labelledby="account-details-vertical-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">ข้อมูลร้านอาหาร</h5>
                                        <small class="text-muted">กรอกรายละเอียดร้านอาหาร</small>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-category">ประเภทร้านอาหาร</label>
                                            <select class="form-select" name="category" id="vertical-category">
                                                {!! \App\Model\dashboard::category_option_html(( old('category') ? old('category') : $rec->category),'Select','restaurant') !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-restaurant-name">ชื่อร้านอาหาร</label>
                                            <input type="text" name="restaurant_name" id="vertical-restaurant-name" class="form-control" value="{{ old('restaurant_name') ? old('restaurant_name') : $rec->restaurant_name }}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-short-descrip">รายละเอียดของร้านอาหารโดยย่อ</label>
                                            <textarea name="short_descrip" id="vertical-short-descrip" class="form-control">{{ old('short_descrip') ? old('short_descrip') : $rec->short_descrip }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-ful-descrip">รายละเอียดของร้านอาหาร</label>
                                            <textarea name="full_descrip" id="vertical-ful-descrip" class="form-control">{{ old('full_descrip') ? old('full_descrip') : $rec->full_descrip }}</textarea>
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
                                        <h5 class="mb-0">ข้อมูลราคาร้านอาหาร</h5>
                                        <small>กรอกรายละเอียดราคาร้านอาหาร</small>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-unit-price">ราคาร้านอาหารต่อหน่วย</label>
                                            <input type="text" name="unit_price" id="vertical-unit-price" class="form-control" value="{{ old('unit_price') ? old('unit_price') : $rec->unit_price }}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-sale-price">ราคาขายร้านอาหาร</label>
                                            <input type="text" name="sale_price" id="vertical-sale-price" class="form-control" value="{{ old('sale_price') ? old('sale_price') : $rec->sale_price }}">
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
                                        <h5 class="mb-0">รูปภาพร้านอาหาร</h5>
                                        <small>ลงรูปภาพร้านอาหาร</small>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <img src="{{ asset('storage/app/public/image/restaurants/'.$rec->restaurant_img_name) }}" title="{{ $rec->restaurant_img_name }}" width="20%">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="vertical-cover-img">รูปปกร้านอาหาร</label>
                                            <input type="file" name="restaurant_img_name" id="vertical-cover-img" class="form-control" value="{{ old('restaurant_img_name') ? old('restaurant_img_name') : $rec->restaurant_img_name }}">
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
@endpush


