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
                                    <h5 class="m-b-10">เอกสาร Invoice</h5>
                                    <p class="text-muted m-b-10"><code>เอกสาร</code></p>
                                    <ul class="breadcrumb-title b-t-default p-t-10">
                                        <li class="breadcrumb-item">
                                            <a href="{!! url("backend/$url") !!}""> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">การขาย</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">เอกสาร Invoice</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-block" >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{url('/backend/'.$url.'/'.$id)}}" method="post">
                                                <input name="_method" type="hidden" value="PUT">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div id="wizardb">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-grd-warning" id="back" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับไปหน้ารายการ"><i class="icofont icofont-line-block-left"></i>ย้อนกลับ</button>
                                                            <button type="button" class="btn btn-grd-warning" onclick="printDiv('printdiv')">Print this page</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block" style="background-color:white;" id="printdiv">
                                    <div class="dt-responsive table-responsive">
                                        <table class="nowrap" width="100%">
                                            <tr>
                                                <td>
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="35%" style="text-align:center;"><img class="img-fluid" width="100px" src="{!! asset('public/backend/files/assets/images/logo ev9.png') !!}" alt="Theme-Logo" /></td>
                                                            <td width="75%">
                                                                <table border="0" width="100%">
                                                                    <tr>
                                                                        <td><b>บริษัท อีวีไนน์ แลบอราทอรีย์ จำกัด (สำนักงานใหญ่)</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>EV9 Laboratory Co.,LTD Head office</b> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>สำนักงานใหญ่ : 46/265 ซอยนวมินทร์ 74 แขวงคลองกุ่ม เขตบึงกุ่ม กรุงเทพมหานคร 10230</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>โทร 096-396-4915   เลขประจำตัวผู้เสียภาษีอากร  0105563020311</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center;padding: top 20px;">
                                                    <p>ใบกำกับภาษี/ ใบส่งสืนค้า/ ใบเสร็จรับเงิน</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="59%">
                                                                <table style="height:250px;" width="100%">
                                                                    <tr>
                                                                        <td style="padding: left 100px;">
                                                                            <table border="0" width="100%">
                                                                                <tr>
                                                                                    <td>
                                                                                        <table border="0" width="100%">
                                                                                            <tr>
                                                                                                <td width="20%">
                                                                                                    <p>นามลูกค้า</p>
                                                                                                    <p>Name</p>
                                                                                                </td>
                                                                                                <td width="80%">
                                                                                                    <p>{!! $customer->customer_name !!} {!! $customer->customer_lastname !!}</p>
                                                                                                    <p>&nbsp;</p>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="20%">
                                                                                                    <p>ที่อยู่</p>
                                                                                                    <p>Address</p>
                                                                                                </td>
                                                                                                <td width="80%"><p>{!! $customer->customer_i_address !!} จังหวัด {!! \App\Model\dashboard::province_html(( old('customer_i_province') ? old('customer_i_province') : $customer->customer_i_province)) !!} 
                                                                                                    อำเภอ {!! \App\Model\dashboard::district_html(( old('customer_i_district') ? old('customer_i_district') : $customer->customer_i_district )) !!} </p>
                                                                                                    <p> ตำบล {!! \App\Model\dashboard::subdistrict_html(( old('customer_i_subdistrict') ? old('customer_i_subdistrict') : $customer->customer_i_subdistrict )) !!} 
                                                                                                    เลขไปรษณีย์ {!! $customer->customer_i_postcode !!}</p>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table border="0" width="100%">
                                                                                            <tr>
                                                                                                <td width="50%">
                                                                                                    <table>
                                                                                                        <tr>
                                                                                                            <td width="20%">
                                                                                                                <p>เลขประจำตัวผู้เสียภาษี</p>
                                                                                                                <p>Tax ID.</p>
                                                                                                            </td>
                                                                                                            <td style="text-align:center;padding: top 20px;" width="80%">
                                                                                                                <p>-</p>
                                                                                                                <p>&nbsp;</p>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td width="50%">
                                                                                                    <input type="checkbox" name="" id="">  สำนักงานใหญ่
                                                                                                    <br>
                                                                                                    <input type="checkbox" name="" id="">  สาขาที่
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td width="2%"></td>
                                                            <td width="29%">
                                                                <table  style="height:250px;" width="100%">
                                                                    <tr>
                                                                        <td>
                                                                            <table border="0" width="100%">
                                                                                <tr>
                                                                                    <td width="20%">
                                                                                        <p>เลขที่</p>
                                                                                        <p>NO.</p>
                                                                                    </td>
                                                                                    <td width="80%">
                                                                                        <p>{!! @$sale->so_inv_date !!}</p>
                                                                                        <p>&nbsp;</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="20%">
                                                                                        <p>วันที่</p>
                                                                                        <p>Date</p>
                                                                                    </td>
                                                                                    <td width="80%">
                                                                                        <p>{!! @$sale->so_inv_num !!}</p>
                                                                                        <p>&nbsp;</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="20%">&nbsp;</td>
                                                                                    <td width="80%">&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="20%">&nbsp;</td>
                                                                                    <td width="80%">&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="20%">&nbsp;</td>
                                                                                    <td width="80%">&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table border="1" width="100%" style="padding-top:100px;">
                                                        <tr>
                                                            <th width="10%" style="text-align:center;padding:5px;">
                                                                <p>ลำดับ</p>
                                                                <p>NO.</p>
                                                            </th>
                                                            <th width="30%" style="text-align:center;padding:5px;">
                                                                <p>รายการ</p>
                                                                <p>DESCRIPTION</p>
                                                            </th>
                                                            <th width="10%" style="text-align:center;padding:5px;">
                                                                <p>จำนวน</p>
                                                                <p>(ชิ้น)</p>
                                                            </th>
                                                            <th width="10%" style="text-align:center;padding:5px;">
                                                                <p>ราคาขาย</p>
                                                                <p>(บาท)</p>
                                                            </th>
                                                            <th width="30%" style="text-align:center;padding:5px;">
                                                                <p>ส่วนลด</p>
                                                                <p>(บาท)</p>
                                                            </th>
                                                            <th width="10%" style="text-align:center;padding:5px;">
                                                                <p>จำนวนเงิน</p>
                                                                <p>AMOUNT</p>
                                                            </th>
                                                        </tr>
                                                        @forelse($cart as $k => $c)
                                                        <tr>
                                                            <td style="text-align:center;padding:5px">{!! $k+1 !!}</td>
                                                            <td style="text-align:center;padding:5px">{!! $c->product_name !!}</td>
                                                            <td style="text-align:center;padding:5px">{!! $c->product_qty !!}</td>
                                                            <td style="text-align:center;padding:5px">{!! General::number_format_($c->product_unit_price) !!}</td>
                                                            <td style="text-align:center;padding:5px">{!! General::number_format_($c->product_discount) !!}</td>
                                                            <td style="text-align:center;padding:5px">{!! General::number_format_(($c->product_unit_price * $c->product_qty) - $c->product_discount) !!}</td>
                                                        </tr>
                                                        @empty
                                                        @endforelse
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%">
                                                                <table border="1" width="100%">
                                                                    <tr>
                                                                        <td>
                                                                            <table border="0" width="100%">
                                                                                <tr>
                                                                                    <td width="20%">ตัวอักษร</td>
                                                                                    <td width="80%">({!! General::num2thai($price) !!})</td>
                                                                                </tr>
                                                                                @if($sale->so_pay_type == 'cod')
                                                                                <tr>
                                                                                    <td width="20%"><input type="checkbox" name="" id=""> เงินสด</td>
                                                                                    <td width="80%">{!! General::number_format_($price) !!} บาท</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="20%">&nbsp;</td>
                                                                                    <td width="80%">&nbsp;</td>
                                                                                </tr>
                                                                                @elseif($sale->so_pay_type == 'transfer')
                                                                                <tr>
                                                                                    <td width="20%"><input type="checkbox" name="" id=""> เงินโอน</td>
                                                                                    <td width="80%">{!! General::number_format_($price) !!} บาท</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="20%">&nbsp;</td>
                                                                                    <td width="80%">&nbsp;</td>
                                                                                </tr>
                                                                                @endif
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td width="50%">
                                                                <table border="0" width="100%">
                                                                    <tr>
                                                                        <td style="text-align:right;" width="80%">รวมเงิน (Total)</td>
                                                                        <td style="text-align:right;" width="20%">{!! General::number_format_($price - $tax) !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align:right;" width="80%">ภาษีมูลค่าเพิ่ม (Vat) 7%</td>
                                                                        <td style="text-align:right;" width="20%">{!! General::number_format_($tax) !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align:right;" width="80%">จำนวนเงินทั้งสิ้น (Subtotal)</td>
                                                                        <td style="text-align:right;" width="20%">{!! General::number_format_($price) !!}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="36%">
                                                                <table border="1" width="100%" height="100px">
                                                                    <tr>
                                                                        <td>
                                                                            <table border="0" width="100%">
                                                                                <tr>
                                                                                    <td width="25%">ผู้รับเงิน / ผู้ส่งของ</td>
                                                                                    <td width="75%" style="text-align:center;"><img class="img-fluid" width="70px" src="{!! asset('public/backend/files/assets/images/ผู้ส่งของ.jpg') !!}" alt="Theme-Logo" /></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="25%">วันที่</td>
                                                                                    <td width="75%"></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td width="2%"></td>
                                                            <td width="30%">
                                                                <table border="1" width="100%" height="100px">
                                                                    <tr>
                                                                        <td>
                                                                            <table border="0" width="100%">
                                                                                <tr>
                                                                                    <td width="25%">ผู้รับ</td>
                                                                                    <td width="75%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="25%">วันที่</td>
                                                                                    <td width="75%"></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td width="2%"></td>
                                                            <td width="30%" style="text-align:center;">
                                                                <table border="1" width="100%" height="100px">
                                                                    <tr>
                                                                        <td>
                                                                            <table border="0" width="100%">
                                                                                <tr>
                                                                                    <td width="100%">ในนาม บริษัท อีวีไนน์ แลบอราทอรีย์ จำกัด (สำนักงานใหญ่)</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="100%"><img class="img-fluid" width="70px" src="{!! asset('public/backend/files/assets/images/ผู้มีอำนาจลงนาม.jpg') !!}" alt="Theme-Logo" /></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="100%">ผู้มีอำนาจลงนาม</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
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
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;

     window.location.reload();
}
</script>
@endpush
    

