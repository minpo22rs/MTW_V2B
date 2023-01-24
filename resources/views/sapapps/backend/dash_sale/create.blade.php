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
                                                <form action="{{url('/backend/'.$url)}}" method="POST">
                                                    {{csrf_field()}}
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-grd-warning" id="back" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อย้อนกลับไปหน้ารายการ"><i class="icofont icofont-line-block-left"></i>ย้อนกลับ</button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <h5>หมายเหตุ</h5>
                                                        </div>
                                                        <div class="col-md-12">
                                                            {!! $customer->customer_remark !!}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            {!! $customer->customer_name !!} {!! $customer->customer_lastname !!} ({!! $customer->customer_mem_id !!})
                                                        </div>
                                                        <div class="col-md-12">
                                                            เบอร์โทรศัพท์ : {!! $customer->customer_phone !!}
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="cr_customer_id" value="{!! $_id !!}">
                                                    <input type="hidden" name="cr_log_id" value="{!! $logId !!}">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="username">สถานะการติดต่อ</label>
                                                            <select class="form-control" name="cr_status" id="cr_status">
                                                                {!! \App\Model\dashboard::status_call_option_html(( old('cr_status')),'Select') !!}
                                                            </select>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label for="cr_detail">รายละเอียด</label>
                                                            <input type="text" class="form-control" id="cr_detail" name="cr_detail">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="datetime">วันที่นัดโทรกลับ</label>
                                                                    <input type="datetime-local" id="cr_date" class="form-control" name="cr_date" disabled>
                                                                </div>
                                                            </div><br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="datetime">เตือนก่อนถึงเวลานัด</label><br>
                                                                    <label for="">วัน</label>
                                                                    <input type="number" id="cr_day" class="form-control" min="0" name="cr_day" disabled value="0"> 
                                                                </div>
                                                            </div><br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="">ชั่วโมง</label>
                                                                    <input type="number" id="cr_hour" class="form-control" min="0" name="cr_hour" disabled value="0"> 
                                                                </div>
                                                            </div><br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="">นาที</label>
                                                                    <input type="number" id="cr_minute" class="form-control" min="0" name="cr_minute" disabled value="0"> 
                                                                </div>
                                                            </div><br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <tr>
                                                                        <th width="10">#</th>
                                                                        <th>สถานะ</th>
                                                                        <th>ประเภท</th>
                                                                        <th>หมายเหตุ</th>
                                                                        <th>ชื่อ</th>
                                                                        <th>วันที่</th>
                                                                    </tr>
                                                                    @forelse($call as $r)
                                                                    <tr>
                                                                        <td>{!! $r->id !!}</td>
                                                                        <td>{!! $r->sts_text !!}</td>
                                                                        <td>{!! $r->sts_type !!}</td>
                                                                        <td>{!! $r->cr_detail !!}</td>
                                                                        <td>{!! $r->customer_name !!}</td>
                                                                        <td>{!! $r->cr_created_at !!}</td>
                                                                    </tr>
                                                                    @empty
                                                                    @endforelse
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-grd-success">บันทึก</button>
                                                        </div>
                                                    </div>
                                                    <!-- <a href="tel:0982563450">text</a> -->
                                                </form>
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

<script>
    $(document).ready(function(){
        $('#cr_status').change(function(){
            //Selected value
            var inputValue = $(this).val();
            if(inputValue == 2) {
                $('#cr_date').prop('disabled', false);
                $('#cr_day').prop('disabled', false);
                $('#cr_hour').prop('disabled', false);
                $('#cr_minute').prop('disabled', false);
            }else {
                $('#cr_date').prop('disabled', true);
                $('#cr_day').prop('disabled', true);
                $('#cr_hour').prop('disabled', true);
                $('#cr_minute').prop('disabled', true);
            }
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
                    url:"https://sapappwork.xyz/backend/fetch-address",
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
                    url:"https://sapappwork.xyz/backend/fetch-address",
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
    

