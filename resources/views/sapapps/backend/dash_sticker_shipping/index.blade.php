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
                                    <h5 class="m-b-10">{{ $menu }}</h5>
                                    <p class="text-muted m-b-10"><code>รายการ</code></p>
                                    <ul class="breadcrumb-title b-t-default p-t-10">
                                        <li class="breadcrumb-item">
                                            <a href="{!! url("backend/$url") !!}"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">{{ $menu }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <div class="row">
                                            <div class="col-md-8">
                                                @if($count > 0)
                                                <form class="wizard-form" id="verticle-wizard-validate" action="{{url('/backend/'.$url.'/'.$rec->id)}}" method="POST" enctype="multipart/form-data">
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">ชื่อบริษัท</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="l_company" class="form-control" id="" value="{{ old('l_company') ? old('l_company') : $rec->l_company }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">เบอร์โทรศัพท์</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="l_phone" class="form-control" id="" value="{{ old('l_phone') ? old('l_phone') : $rec->l_phone }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">ที่อยู่</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" name="l_address" id="">{{ old('l_address') ? old('l_address') : $rec->l_address }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">จังหวัด</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <select class="form-control dynamic" name="l_province" id="province_id" data-dependent="district_id">
                                                                {!! \App\Model\dashboard::province_option_html(( old('l_province') ? old('l_province') : $rec->l_province),'Select') !!}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">อำเภอ</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <select class="form-control dynamic" name="l_district" id="district_id" data-dependent="subdistrict_id">
                                                                {!! \App\Model\dashboard::district_option_html(( old('l_district') ? old('l_district') : $rec->l_district ),'Select', $rec->l_province ) !!}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">ตำบล</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="l_subdistrict" id="subdistrict_id">
                                                                {!! \App\Model\dashboard::subdistrict_option_html(( old('l_subdistrict') ? old('l_subdistrict') : $rec->l_subdistrict ),'Select', $rec->l_district ) !!}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">รหัสไปรษณีย์</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="l_postcode" value="{{ old('l_postcode') ? old('l_postcode') : $rec->l_postcode }}" id="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <button class="btn btn-primary" type="submit">ยืนยัน</button>
                                                        </div>
                                                    </div>
                                                </form> 
                                                @else
                                                <form class="wizard-form" id="verticle-wizard-validate" action="{{url('/backend/'.$url)}}" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">ชื่อบริษัท</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="l_company" class="form-control" id="" value="{{ old('l_company') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">เบอร์โทรศัพท์</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="l_phone" class="form-control" id="" value="{{ old('l_phone') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">ที่อยู่</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" name="l_address" id="">{{ old('l_address') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">จังหวัด</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <select class="form-control dynamic" name="l_province" id="province_id" data-dependent="district_id">
                                                                {!! \App\Model\dashboard::province_option_html(( old('l_province')),'Select') !!}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">อำเภอ</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <select class="form-control dynamic" name="l_district" id="district_id" data-dependent="subdistrict_id">
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">ตำบล</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="l_subdistrict" id="subdistrict_id">
                                                                    <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <label class="block">รหัสไปรษณีย์</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="l_postcode" value="{{ old('l_postcode') }}" id="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                            <button class="btn btn-primary" type="submit">ยืนยัน</button>
                                                        </div>
                                                    </div>
                                                </form> 
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                @if($count > 0)
                                                <button type="button" class="btn btn-grd-warning" onclick="printDiv('printdiv')">Print this page</button>
                                                <div  id="printdiv">
                                                <div style="height:189px;width:378px;border-style: solid;padding-top:20px;padding-left:20px;">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                ผู้ส่ง
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{ $rec->l_company }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{ $rec->l_address }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                แขวง {!! \App\Model\dashboard::subdistrict_html(( old('l_subdistrict') ? old('l_subdistrict') : $rec->l_subdistrict )) !!}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                เขต {!! \App\Model\dashboard::district_html(( old('l_district') ? old('l_district') : $rec->l_district )) !!} {!! \App\Model\dashboard::province_html(( old('l_province') ? old('l_province') : $rec->l_province)) !!}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                เบอร์ติดต่อ {{ $rec->l_phone }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                </div>
                                                @endif
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


    
