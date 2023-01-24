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
                                        <li class="breadcrumb-item"><a href="#!">ประวัติการสั่งซื้อ</a>
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
                                                            <a class="btn btn-grd-primary" onclick="navigatorFunc({!! $rec->customer_phone !!},{!! $rec->customer_id !!})" style="color:white;">โทร</a>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">ลูกค้า</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <p>{!! $rec->customer_name !!} {!! $rec->customer_lastname !!} ({!! $rec->customer_mem_id !!})</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">ชื่อใบกำกับภาษี</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <p>{!! $rec->customer_i_name !!} {!! $rec->customer_i_lastname !!}</p>
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
                                                                    <p>{!! $rec->customer_s_name !!} {!! $rec->customer_s_lastname !!}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                            <label for="username">เบอร์โทรศัพท์</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <p>{!! $rec->customer_phone !!}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-2">
                                                            <label for="username">หมายเหตุลูกค้า</label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            {!! $rec->customer_remark !!}
                                                        </div>
                                                    </div>
                                                    <br>
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
                                                                    <p>ที่อยู่ {!! $rec->customer_i_address !!}</p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p>
                                                                        จังหวัด {!! \App\Model\dashboard::province_html(( old('customer_i_province') ? old('customer_i_province') : $rec->customer_i_province),'Select') !!}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>
                                                                        อำเภอ {!! \App\Model\dashboard::district_html(( old('customer_i_district') ? old('customer_i_district') : $rec->customer_i_district ),'Select', $rec->customer_i_province ) !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p>
                                                                        ตำบล {!! \App\Model\dashboard::subdistrict_html(( old('customer_i_subdistrict') ? old('customer_i_subdistrict') : $rec->customer_i_subdistrict ),'Select', $rec->customer_i_district ) !!}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>เลขไปรษณีย์ {!! $rec->customer_i_postcode !!}</p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-5 border-form">
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <p>ที่อยู่ {!! $rec->customer_s_address !!}</p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p>
                                                                        จังหวัด {!! \App\Model\dashboard::province_html(( old('customer_s_province') ? old('customer_s_province') : $rec->customer_s_province),'Select') !!}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>
                                                                        อำเภอ {!! \App\Model\dashboard::district_html(( old('customer_s_district') ? old('customer_s_district') : $rec->customer_s_district ),'Select', $rec->customer_s_province ) !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p>
                                                                        ตำบล {!! \App\Model\dashboard::subdistrict_html(( old('customer_s_subdistrict') ? old('customer_s_subdistrict') : $rec->customer_s_subdistrict ),'Select', $rec->customer_s_district ) !!}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>เลขไปรษณีย์ {!! $rec->customer_s_postcode !!}</p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
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
    function navigatorFunc(num,cusId) {
        document.location.href = "tel:+66"+num;
        var _token = $('input[name="_token"]').val();
        
        $.ajax({
            url:"/backend/dash_customer/log_call",
            method:"POST",
            data:{id:cusId, _token:_token},
            success:function(success)
            {
                console.log(success);
                document.location.href = "/backend/dash_sale/"+cusId+"/create/"+success;
            }
        })
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        
        
        /////////////// Event ///////////////////////

        setTimeout(function(){
            var token = '{!! csrf_token() !!}';
            var url = '{!! asset('') !!}';
        },1000);

        /////////////// Fixed ///////////////////////
        window.back('{!! url("backend/dash_customer") !!}');
        window.validate_step('#verticle-wizard-validate');
        
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('button#back').click(function(e){
            e.preventDefault();
            window.location.href = '{!! url("backend/dash_customer") !!}';
        });
    });
</script>
@endpush
    

