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
                                    <h5 class="m-b-10">ที่อยู่ผู้รับ</h5>
                                    <p class="text-muted m-b-10"><code>รายการ</code></p>
                                    <ul class="breadcrumb-title b-t-default p-t-10">
                                        <li class="breadcrumb-item">
                                            <a href="{!! url("backend/$url") !!}"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">ที่อยู่ผู้รับ</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="padding-bottom:20px;">
                                                    <button class="btn btn-grd-warning" id="back" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับไปหน้ารายการ"><i class="icofont icofont-line-block-left"></i>ย้อนกลับ</button>
                                                    <button type="button" class="btn btn-grd-warning" onclick="printDiv('printdiv')">Print this page</button>
                                                </div>
                                                <br>
                                                <div  id="printdiv">
                                                <div style="height:189px;width:378px;border-style: solid;padding-top:20px;padding-left:20px;">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                ผู้รับ
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{ $customer->customer_name }} {{ $customer->customer_lastname }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{ $customer->customer_i_address }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                แขวง {!! \App\Model\dashboard::subdistrict_html(( old('customer_i_subdistrict') ? old('customer_i_subdistrict') : $customer->customer_i_subdistrict )) !!}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                เขต {!! \App\Model\dashboard::district_html(( old('customer_i_district') ? old('customer_i_district') : $customer->customer_i_district )) !!} {!! \App\Model\dashboard::province_html(( old('customer_i_province') ? old('customer_i_province') : $customer->customer_i_province)) !!}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                เบอร์ติดต่อ {{ $customer->customer_phone }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                </div>
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
                    url:"https://drjell.sapappwork.xyz/backend/fetch-address",
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


    
