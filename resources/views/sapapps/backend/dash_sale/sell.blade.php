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
    .border-form{
        border:2px solid ;
        border-radius:5px;
    }
    .check:hover {
  background-color: #DCEBE0;
    }
    input[type="text"]:disabled {
        background: #8A8688;
        color: #000;
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
                                            <form action="{{url('/backend/'.$url.'/'.$id)}}" method="post">
                                                <input name="_method" type="hidden" value="PUT">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div id="wizardb">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-grd-warning" id="back" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับไปหน้ารายการ"><i class="icofont icofont-line-block-left"></i>ย้อนกลับ</button>
                                                        </div>
                                                    </div>
                                                    <h4>เพิ่มข้อมูลการขาย</h4>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2" style="padding-left:15px;">
                                                                    <label for="username">พนักงาน</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="text" name="so_agent" value="{!! \App\Model\dashboard::name_account($sale->so_created_at_ref_user_id) !!}" class="form-control" id="username" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                                    <label for="username">วันที่ขาย</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="date" name="so_date" value="{!! $sale->so_date !!}" class="form-control" id="username">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">ลูกค้า</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                            <input type="text" name="ref_customer_id" class="form-control" id="username" value="{!! $customer->customer_name !!} {!! $customer->customer_lastname !!} ({!! $customer->customer_mem_id !!})" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">ชื่อใบกำกับภาษี</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                            <input type="text" name="i_name" class="form-control"  value="{!! $customer->customer_i_name !!} {!! $customer->customer_i_lastname !!}" id="username">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">ชื่อผู้รับสินค้า</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                            <input type="text" name="s_name" class="form-control" id="username" value="{!! $customer->customer_s_name !!} {!! $customer->customer_s_lastname !!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">เบอร์โทรศัพท์</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                            <input type="text" name="customer_phone" class="form-control" id="username" value="{!! $customer->customer_phone !!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">ขนส่ง</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <select class="form-control" name="so_shipping_type">
                                                                        <option value="">select</option>
                                                                        <option value="flash" <?php if($sale->so_shipping_type == "flash") { echo "selected"; } ?>>Flash Express</option>
                                                                        <option value="j&t" <?php if($sale->so_shipping_type == "j&t") { echo "selected"; } ?>>J&T Express</option>
                                                                        <option value="ems" <?php if($sale->so_shipping_type == "ems") { echo "selected"; } ?>>ไปรษณีย์ไทย</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">Tracking Number</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                            <input type="text" name="so_tracking" class="form-control" id="username" value="{!! $sale->so_tracking !!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-2">
                                                            <label for="username">หมายเหตุการขาย</label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <textarea name="so_remark" class="form-control">{!! $sale->so_remark !!}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-2">
                                                            <label for="username">หมายเหตุลูกค้า</label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <textarea name="customer_remark" class="form-control">{!! $customer->customer_remark !!}</textarea>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">วันที่ออกอินวอยซ์</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                            <input type="date" name="so_inv_date" class="form-control" id="username" <?php if(Auth::user()->role == 'agent' || Auth::user()->role == 'supervisor') { echo 'disabled'; } ?> value="{!! @$sale->so_inv_date !!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">เลขที่อินวอยซ์</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                            <input type="text" name="so_inv_num" class="form-control" id="username" <?php if(Auth::user()->role == 'agent' || Auth::user()->role == 'supervisor') { echo 'disabled'; } ?> value="{!! @$sale->so_inv_num !!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <label for="username">ที่อยู่สำหรับ Invoice</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="username">ที่อยู่สำหรับ Shipping</label>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding-left:20px;">
                                                        <div class="col-md-5 border-form">
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    ที่อยู่
                                                                    <textarea name="customer_i_address" class="form-control">{!! $customer->customer_i_address !!}</textarea>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    จังหวัด
                                                                    <select class="form-control dynamic" name="customer_i_province" id="province_id" data-dependent="district_id">
                                                                        {!! \App\Model\dashboard::province_option_html(( old('customer_i_province') ? old('customer_i_province') : $customer->customer_i_province),'Select') !!}
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    อำเภอ
                                                                    <select class="form-control dynamic" name="customer_i_district" id="district_id" data-dependent="subdistrict_id">
                                                                        {!! \App\Model\dashboard::district_option_html(( old('customer_i_district') ? old('customer_i_district') : $customer->customer_i_district ),'Select', $customer->customer_i_province ) !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    ตำบล
                                                                    <select class="form-control" name="customer_i_subdistrict" id="subdistrict_id">
                                                                        {!! \App\Model\dashboard::subdistrict_option_html(( old('customer_i_subdistrict') ? old('customer_i_subdistrict') : $customer->customer_i_subdistrict ),'Select', $customer->customer_i_district ) !!}
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    เลขไปรษณีย์
                                                                    <input type="text" name="customer_i_postcode" class="form-control" id="username" value="{!! $customer->customer_i_postcode !!}">
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-5 border-form">
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    ที่อยู่
                                                                    <textarea name="customer_s_address" class="form-control">{!! $customer->customer_s_address !!}</textarea>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    จังหวัด
                                                                    <select class="form-control dynamic-2" name="customer_s_province" id="province_s_id" data-dependent="district_s_id">
                                                                        {!! \App\Model\dashboard::province_option_html(( old('customer_s_province') ? old('customer_s_province') : $customer->customer_s_province),'Select') !!}
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    อำเภอ
                                                                    <select class="form-control dynamic-2" name="customer_s_district" id="district_s_id" data-dependent="subdistrict_s_id">
                                                                        {!! \App\Model\dashboard::district_option_html(( old('customer_s_district') ? old('customer_s_district') : $customer->customer_s_district ),'Select', $customer->customer_s_province ) !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    ตำบล
                                                                    <select class="form-control" name="customer_s_subdistrict" id="subdistrict_s_id">
                                                                        {!! \App\Model\dashboard::subdistrict_option_html(( old('customer_s_subdistrict') ? old('customer_s_subdistrict') : $customer->customer_s_subdistrict ),'Select', $customer->customer_s_district ) !!}
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    เลขไปรษณีย์
                                                                    <input type="text" name="customer_s_postcode" class="form-control" id="username" value="{!! $customer->customer_s_postcode !!}">
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="username">รายละเอียดสินค้า</label>
                                                        </div>
                                                    </div>
                                                    <div class="row border-form" style="padding-left:60px;padding-right:60px;">
                                                        <div class="col-md-12">
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    @if(Auth::user()->role == 'agent')
                                                                        @if($sale->so_status == 'สร้างคำสั่งซื้อ')
                                                                            <a data-toggle="modal" data-target="#productModal" style="color:white;" class="btn btn-grd-success">เพิ่มสินค้า</a>
                                                                        @endif
                                                                    @elseif(Auth::user()->role == 'supervisor')
                                                                        @if($sale->so_status == 'รอตรวจสอบ')
                                                                            <a data-toggle="modal" data-target="#productModal" style="color:white;" class="btn btn-grd-success">เพิ่มสินค้า</a>
                                                                        @endif
                                                                    @elseif(Auth::user()->role == 'fulillment')
                                                                            <a data-toggle="modal" data-target="#productModal" style="color:white;" class="btn btn-grd-success">เพิ่มสินค้า</a>
                                                                    @endif
                                                                        <div class="modal" id="productModal">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header" style="">
                                                                                        <h5 class="modal-title">เพิ่มสินค้า</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        @csrf
                                                                                        @forelse($product as $p)
                                                                                            <li data-id="{!! $p->product_id !!}" data-dependent="{!! $id !!}" class="form-group row check" style="padding:5px">
                                                                                                <div class="col-md-6">
                                                                                                    <img src="{!! asset('storage/app/public/image/products/'.$p->product_img_name)!!}" width="60px" max-height="60px" alt="">
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <p>{!! $p->product_name !!}</p>
                                                                                                </div>
                                                                                            </li>
                                                                                        @empty
                                                                                        @endforelse
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-grd-danger mobtn" data-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="dt-responsive table-responsive">
                                                                        <table id="DOM-dt" class="table table-striped table-bordered nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th width="5%">#</th>
                                                                                    <th>สินค้า</th>
                                                                                    <th width="10%">จำนวน</th>
                                                                                    <th width="10%">ราคา/หน่วย</th>
                                                                                    <th width="15%">ส่วนลด(บาท)</th>
                                                                                    <th width="10%">จำนวนเงิน</th>
                                                                                    <th width="10%"></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="productresult">
                                                                                @forelse($cart as $k => $c)
                                                                                <tr>
                                                                                    <td>{!! $k+1 !!}</td>
                                                                                    <td>{!! $c->product_name !!}</td>
                                                                                    <td>
                                                                                        @if(Auth::user()->role == 'agent')
                                                                                            @if($sale->so_status == 'สร้างคำสั่งซื้อ')
                                                                                            <input type="hidden" name="order_id" value="{!! $id !!}">
                                                                                            <div class="row sp-quantity">
                                                                                                <div class="col-1 qty" data-id="{!! $c->id !!}" data-dependent="minus">-</div>
                                                                                                <div class="col-5 px-1">
                                                                                                    <input class="quntity-input" id="num" disabled type="text" min="1" style="width:100%" value="{!! $c->product_qty !!}" />
                                                                                                </div>
                                                                                                <div class="col-1 px-0 qty" data-id="{!! $c->id !!}" data-dependent="plus">+</div>
                                                                                            </div>
                                                                                            @else
                                                                                            {!! $c->product_qty !!}
                                                                                            @endif
                                                                                        @elseif(Auth::user()->role == 'supervisor')
                                                                                            @if($sale->so_status == 'รอตรวจสอบ')
                                                                                            <input type="hidden" name="order_id" value="{!! $id !!}">
                                                                                            <div class="row sp-quantity">
                                                                                                <div class="col-1 qty" data-id="{!! $c->id !!}" data-dependent="minus">-</div>
                                                                                                <div class="col-5 px-1">
                                                                                                    <input class="quntity-input" id="num" disabled type="text" min="1" style="width:100%" value="{!! $c->product_qty !!}" />
                                                                                                </div>
                                                                                                <div class="col-1 px-0 qty" data-id="{!! $c->id !!}" data-dependent="plus">+</div>
                                                                                            </div>
                                                                                            @else
                                                                                            {!! $c->product_qty !!}
                                                                                            @endif
                                                                                        @elseif(Auth::user()->role == 'fulillment')
                                                                                            <input type="hidden" name="order_id" value="{!! $id !!}">
                                                                                            <div class="row sp-quantity">
                                                                                                <div class="col-1 qty" data-id="{!! $c->id !!}" data-dependent="minus">-</div>
                                                                                                <div class="col-5 px-1">
                                                                                                    <input class="quntity-input" id="num" disabled type="text" min="1" style="width:100%" value="{!! $c->product_qty !!}" />
                                                                                                </div>
                                                                                                <div class="col-1 px-0 qty" data-id="{!! $c->id !!}" data-dependent="plus">+</div>
                                                                                            </div>
                                                                                        @endif
                                                                                    </td>
                                                                                    <!-- <td><input class="form-control qty" type="number" name="product_qty" min="1" id="" value="{!! $c->product_qty !!}" data-id="{!! $c->product_id !!}" data-dependent="{!! $id !!}"></td> -->
                                                                                    <td>{!! General::number_format_($c->product_unit_price) !!}</td>
                                                                                    <td>
                                                                                        <div class="row sp-discount">
                                                                                            <div class="col-8">
                                                                                                <input class="form-control discount-input" type="number" min="0" value="{!! $c->product_discount !!}">
                                                                                            </div>
                                                                                            @if(Auth::user()->role == 'agent')
                                                                                                @if($sale->so_status == 'สร้างคำสั่งซื้อ')
                                                                                                <div class="col-4 px-0">
                                                                                                    <button type="button" class="btn-grd-info discount" data-id="{!! $id !!}" data-dependent="{!! $c->id !!}">+</button>
                                                                                                </div>
                                                                                                @endif
                                                                                            @elseif(Auth::user()->role == 'supervisor')
                                                                                                @if($sale->so_status == 'รอตรวจสอบ')
                                                                                                <div class="col-4 px-0">
                                                                                                    <button type="button" class="btn-grd-info discount" data-id="{!! $id !!}" data-dependent="{!! $c->id !!}">+</button>
                                                                                                </div>
                                                                                                @endif
                                                                                            @elseif(Auth::user()->role == 'fulillment')
                                                                                                <div class="col-4 px-0">
                                                                                                    <button type="button" class="btn-grd-info discount" data-id="{!! $id !!}" data-dependent="{!! $c->id !!}">+</button>
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>{!! General::number_format_(($c->product_unit_price * $c->product_qty) - $c->product_discount) !!}</td>
                                                                                    <td>
                                                                                        @if(Auth::user()->role == 'agent')
                                                                                            @if($sale->so_status == 'สร้างคำสั่งซื้อ')
                                                                                                <button type="button" class="btn-grd-danger del-cart" data-id="{!! $c->product_id !!}" data-dependent="{!! $id !!}"> - </button>
                                                                                            @endif
                                                                                        @elseif(Auth::user()->role == 'supervisor')
                                                                                            @if($sale->so_status == 'รอตรวจสอบ')
                                                                                                <button type="button" class="btn-grd-danger del-cart" data-id="{!! $c->product_id !!}" data-dependent="{!! $id !!}"> - </button>
                                                                                            @endif
                                                                                        @elseif(Auth::user()->role == 'fulillment')
                                                                                                <button type="button" class="btn-grd-danger del-cart" data-id="{!! $c->product_id !!}" data-dependent="{!! $id !!}"> - </button>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                @empty
                                                                                @endforelse
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="username">ข้อมูลการชำระเงิน</label>
                                                        </div>
                                                    </div>
                                                    <div class="row border-form" style="padding-left:60px;">
                                                        <div class="col-md-12">
                                                            <br>
                                                            <div class="row">
                                                                <input type="hidden" id="price_r" name="so_price" value="{!! $price - $tax !!}">
                                                                <input type="hidden" id="tax_r" name="so_tax" value="{!! $tax !!}">
                                                                <input type="hidden" name="so_tax_per" value="7">
                                                                <input type="hidden" name="ref_customer_id" value="{!! $customer->customer_id !!}">
                                                                <input type="hidden" id="sum_r" name="so_sum_price" value="{!! $price !!}">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label>ราคาก่อนรวมภาษี</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input id="price" name="so_price" value="{!! General::number_format_($price - $tax) !!}" type="text" class="form-control" id="username" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label>ภาษีมูลค่าเพิ่ม</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input id="tax" name="so_tax" value="{!! General::number_format_($tax) !!}" type="text" class="form-control" id="username" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label>ราคารวมภาษี</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input id="sum" name="so_sum_price" value="{!! General::number_format_($price) !!}" type="text" class="form-control" id="username" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label>ช่องทางชำระเงิน</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <select class="form-control" name="so_pay_type">
                                                                                <option value="">select</option>
                                                                                <option value="cod" <?php if($sale->so_pay_type == "cod") { echo "selected"; } ?>>เก็บเงินปลายทาง</option>
                                                                                <option value="transfer" <?php if($sale->so_pay_type == "transfer") { echo "selected"; } ?>>โอนเงิน</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label>วันที่ชำระเงิน</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="date" name="so_pay_date" class="form-control" id="username" value="{{ old('so_pay_date') ? old('so_pay_date') : $sale->so_pay_date }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label>ภาษีมูลค่าเพิ่ม</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="so_tax_per" value="7" class="form-control" id="username" disabled>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <label>%</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-10">
                                                            @if(Auth::user()->role == 'fulillment')
                                                                <select class="form-control" name="so_status">
                                                                    <option value="อนุมัติคำสั่งซื้อ" <?php if($sale->so_status == "อนุมัติคำสั่งซื้อ") { echo "selected"; } ?>>อนุมัติคำสั่งซื้อ</option>
                                                                    <option value="หยิบสินค้า" <?php if($sale->so_status == "หยิบสินค้า") { echo "selected"; } ?>>หยิบสินค้า</option>
                                                                    <option value="ออกอินวอยซ์" <?php if($sale->so_status == "ออกอินวอยซ์") { echo "selected"; } ?>>ออกอินวอยซ์</option>
                                                                    <option value="กำลังจัดส่ง" <?php if($sale->so_status == "กำลังจัดส่ง") { echo "selected"; } ?>>กำลังจัดส่ง</option>
                                                                    <option value="ลูกค้ารับสินค้า" <?php if($sale->so_status == "ลูกค้ารับสินค้า") { echo "selected"; } ?>>ลูกค้ารับสินค้า</option>
                                                                    <option value="ลูกค้าปฏิเสธการรับสินค้า" <?php if($sale->so_status == "ลูกค้าปฏิเสธการรับสินค้า") { echo "selected"; } ?>>ลูกค้าปฏิเสธการรับสินค้า</option>
                                                                    <option value="refun" <?php if($sale->so_status == "refun") { echo "selected"; } ?>>refun</option>
                                                                    <option value="ยกเลิกออเดอร์" <?php if($sale->so_status == "ยกเลิกออเดอร์") { echo "selected"; } ?>>ยกเลิกออเดอร์</option>
                                                                </select>
                                                            @endif
                                                            @if(Auth::user()->role == 'admin')
                                                                <select class="form-control" name="so_status">
                                                                    <option value="{{$sale->so_status}}">{{$sale->so_status}}</option>
                                                                    <option value="ยกเลิกออเดอร์" <?php if($sale->so_status == "ยกเลิกออเดอร์") { echo "selected"; } ?>>ยกเลิกออเดอร์</option>
                                                                </select>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2">
                                                            @if(Auth::user()->role == 'agent')
                                                                @if($sale->so_status == 'สร้างคำสั่งซื้อ')
                                                                <button type="submit" class="btn btn-grd-success" >บันทึก</button>
                                                                @else
                                                                <span class="btn btn-grd-primary">สร้างคำสั่งซื้อสำเร็จแล้ว</span>
                                                                @endif
                                                            @elseif(Auth::user()->role == 'supervisor')
                                                                @if($sale->so_status == 'รอตรวจสอบ')
                                                                    <button type="submit" name="button_name" value="check" class="btn btn-grd-success" >ตรวจสอบ</button>
                                                                    <button type="submit" name="button_name" value="cc" class="btn btn-grd-danger" >ยกเลิกออเดอร์</button>
                                                                @endif
                                                            @elseif(Auth::user()->role == 'fulillment' || Auth::user()->role == 'admin')
                                                                <button type="submit" class="btn btn-grd-success" >บันทึก</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
<script>
    $(document).ready(function() {
        $(document).on('click','button.discount',function () {
            var dataId = $(this).attr("data-id");
            var id = $(this).data('dependent');
            var $button = $(this);
            $button.addClass('disable-div');
            var _token = $('input[name="_token"]').val();
            var value = $button.closest('.sp-discount').find("input.discount-input").val();
            $.ajax({
                url:"discount",
                method:"POST",
                data:{_token:_token,dataId:dataId,id:id,value:value},
                success:function(result){
                    console.log(result);
                    $('#productresult').html(result.result);
                    $('#price').val(result.price);
                    $('#tax').val(result.tax);
                    $('#sum').val(result.sum);
                    $('#price_r').val(result.price_r);
                    $('#tax_r').val(result.tax);
                    $('#sum_r').val(result.sum_r);
                }
            });
        });
    });
    // function discount(id,dataId) {
    //     var value = document.getElementById('dis'+id).value;
    //     var _token = $('input[name="_token"]').val();
    //         $.ajax({
    //             url:"discount",
    //             method:"POST",
    //             data:{_token:_token,dataId:dataId,id:id,value:value},
    //             success:function(result){
    //                 console.log(result);
    //                 $('#productresult').html(result.result);
    //                 $('#price').val(result.price);
    //                 $('#tax').val(result.tax);
    //                 $('#sum').val(result.sum);
    //                 $('#price_r').val(result.price);
    //                 $('#tax_r').val(result.tax);
    //                 $('#sum_r').val(result.sum);
    //             }
    //         });
    // }
</script>
<script>
    function checkDupValue(group, currentValue) {
        var allowAppend = true;
        $(group).each(function (i, newValue) {
            
            if($(newValue).data('value') == currentValue) {
                allowAppend = false;
                return false;
            }

        });

        return allowAppend;
    }


    $(document).ready(function() {
        $(document).on('click','div.qty',function () {
            var type = 'qty';
            var $button = $(this);
            $button.addClass('disable-div');
            var oldValue = $button.closest('.sp-quantity').find("input.quntity-input").val();
            var _token = $('input[name="_token"]').val();
            var dataId = $(this).attr("data-id");
            var dataRefId = $(":input[name='order_id']").val();
            var ssss = $(this).data('dependent');
            if(ssss == 'minus') {
                var o_value = parseFloat(oldValue) -1;
                if(o_value < 1) {
                    value = 1;
                }else {
                    value = o_value;
                }
            }else if(ssss == 'plus') {
                var value = parseFloat(oldValue) +1;
            }
            if(value > 0) {
                $.ajax({
                    url:"add-cart",
                    method:"POST",
                    data:{_token:_token,id:dataId,refId:dataRefId,type:type,value:value},
                    success:function(result){
                        console.log(result);
                        $('#productresult').html(result.result);
                        $('#price').val(result.price);
                        $('#tax').val(result.tax);
                        $('#sum').val(result.sum);
                        $('#price_r').val(result.price_r);
                        $('#tax_r').val(result.tax);
                        $('#sum_r').val(result.sum_r);
                    }
                })
            }
        });
    });
    
    $(document).ready(function() {
        $(document).on('click','button.del-cart',function () {
            var type = 'del';
            var _token = $('input[name="_token"]').val();
            var dataId = $(this).attr("data-id");
            var dataRefId = $(this).data('dependent');
            var value = 0;
            $.ajax({
                url:"add-cart",
                method:"POST",
                data:{_token:_token,id:dataId,refId:dataRefId,type:type,value:value},
                success:function(result){
                    console.log(result);
                    $('#productresult').html(result.result);
                    $('#price').val(result.price);
                    $('#tax').val(result.tax);
                    $('#sum').val(result.sum);
                        $('#price_r').val(result.price_r);
                        $('#tax_r').val(result.tax);
                        $('#sum_r').val(result.sum_r);
                }
            })
        });
    });

    $('li.check').click(function () {
        var type = 'cart';
        var _token = $('input[name="_token"]').val();
        var dataId = $(this).attr("data-id");
        var dataRefId = $(this).data('dependent');
        var value = 0;
        $.ajax({
            url:"add-cart",
            method:"POST",
            data:{_token:_token,id:dataId,refId:dataRefId,type:type,value:value},
            success:function(result){
                console.log(result);
                $('#productresult').html(result.result);
                $('#price').val(result.price);
                $('#tax').val(result.tax);
                $('#sum').val(result.sum);
                        $('#price_r').val(result.price_r);
                        $('#tax_r').val(result.tax);
                        $('#sum_r').val(result.sum_r);
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function(){
        
        
        /////////////// Event ///////////////////////

        setTimeout(function(){
            var token = '{!! csrf_token() !!}';
            var url = '{!! asset('') !!}';
        },1000);

        /////////////// Fixed ///////////////////////
        window.back('{!! url("backend/dash_sale") !!}');
        window.validate_step('#verticle-wizard-validate');
        
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('button#back').click(function(e){
            e.preventDefault();
            window.location.href = '{!! url("backend/dash_sale") !!}';
        });
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
    

