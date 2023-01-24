@extends('sapapps.backend.inc.template')

@push('styles')
<!-- radial chart.css -->
<link rel="stylesheet" href="{!! asset('public/backend/files/assets/pages/chart/radial/css/radial.css') !!}" type="text/css" media="all">
<!-- Custom css -->
<link rel="stylesheet" type="text/css" href="{!! asset('resources/css/config_datatables.css') !!}">
@endpush

@section('content')   
<div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    @if($rank != '[]')
                                        <div class="col-md-12 col-xl-12">
                                            <div class="card" style="background: linear-gradient(0.25turn, #85603F, #9E7540, #BD9354,#E3D18A);">
                                                <div class="card-block text-center">
                                                    <i class="ti-crown text-c-black d-block f-40"></i>
                                                    @if(\App\Model\dashboard::img_account($rank[0]->id) != '') 
                                                        <img src="{!! url('storage/app/public/image/profile/'.\App\Model\dashboard::img_account($rank[0]->id))  !!}" width="100px" class="img-radius" alt="User-Profile-Image">
                                                    @else
                                                        <img src="{!! asset('public/backend/files/assets/images/logo ev9.png') !!}" width="100px" class="img-radius" alt="User-Profile-Image">
                                                    @endif
                                                    <h4 class="m-t-20" style="color: black;"><span class="text-c-black">{!! \App\Helpers\General::number_format_($rank[0]->product_price) !!}</span> ฿</h4>
                                                    <p class="m-b-20" style="color: black;">{!! \App\Model\dashboard::name_account($rank[0]->id) !!}</p>
                                                    <span class="label label-danger" style="color: white;">อันดับที่ 1</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if($rank->count() > 1)
                                        <div class="col-md-12 col-xl-6">
                                            <div class="card" style="background: linear-gradient(0.25turn, #E8ECF1, #B5CFD8, #7393A7);">
                                                <div class="card-block text-center">
                                                    @if(\App\Model\dashboard::img_account($rank[1]->id) != '') 
                                                        <img src="{!! url('storage/app/public/image/profile/'.\App\Model\dashboard::img_account($rank[1]->id))  !!}" width="50px" class="img-radius" alt="User-Profile-Image">
                                                    @else
                                                        <img src="{!! asset('public/backend/files/assets/images/logo ev9.png') !!}" width="50px" class="img-radius" alt="User-Profile-Image">
                                                    @endif
                                                    <h4 class="m-t-20" style="color: white;"><span class="text-c-white">{!! \App\Helpers\General::number_format_($rank[1]->product_price) !!}</span> ฿</h4>
                                                    <p class="m-b-20" style="color: white;">{!! \App\Model\dashboard::name_account($rank[1]->id) !!}</p>
                                                    <span class="label label-warning" style="color: white;">อันดับที่ 2</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($rank->count() > 2)
                                        <div class="col-md-12 col-xl-6">
                                            <div class="card" style="background: linear-gradient(0.25turn, #7393A7, #6C737E, #424874);">
                                                <div class="card-block text-center">
                                                    @if(\App\Model\dashboard::img_account($rank[2]->id) != '') 
                                                        <img src="{!! url('storage/app/public/image/profile/'.\App\Model\dashboard::img_account($rank[2]->id))  !!}" width="50px" class="img-radius" alt="User-Profile-Image">
                                                    @else
                                                        <img src="{!! asset('public/backend/files/assets/images/logo ev9.png') !!}" width="50px" class="img-radius" alt="User-Profile-Image">
                                                    @endif
                                                    <h4 class="m-t-20" style="color: white;"><span class="text-c-white">{!! \App\Helpers\General::number_format_($rank[2]->product_price) !!}</span> ฿</h4>
                                                    <p class="m-b-20" style="color: white;">{!! \App\Model\dashboard::name_account($rank[2]->id) !!}</p>
                                                    <span class="label label-warning" style="color: white;">อันดับที่ 3</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($rank->count() > 3)
                                        <div class="col-md-12 col-xl-4">
                                            <div class="card" style="background: linear-gradient(0.25turn, #F8B595, #F67280);">
                                                <div class="card-block text-center">
                                                    @if(\App\Model\dashboard::img_account($rank[3]->id) != '') 
                                                        <img src="{!! url('storage/app/public/image/profile/'.\App\Model\dashboard::img_account($rank[3]->id))  !!}" width="40px" class="img-radius" alt="User-Profile-Image">
                                                    @else
                                                        <img src="{!! asset('public/backend/files/assets/images/logo ev9.png') !!}" width="40px" class="img-radius" alt="User-Profile-Image">
                                                    @endif
                                                    <h4 class="m-t-20" style="color: white;"><span class="text-c-white">{!! \App\Helpers\General::number_format_($rank[3]->product_price) !!}</span> ฿</h4>
                                                    <p class="m-b-20" style="color: white;">{!! \App\Model\dashboard::name_account($rank[3]->id) !!}</p>
                                                    <span class="label label-primary" style="color: white;">อันดับที่ 4</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($rank->count() > 4)
                                        <div class="col-md-12 col-xl-4">
                                            <div class="card" style="background: linear-gradient(0.25turn, #F67280, #C06C84);">
                                                <div class="card-block text-center">
                                                    @if(\App\Model\dashboard::img_account($rank[4]->id) != '') 
                                                        <img src="{!! url('storage/app/public/image/profile/'.\App\Model\dashboard::img_account($rank[4]->id))  !!}" width="40px" class="img-radius" alt="User-Profile-Image">
                                                    @else
                                                        <img src="{!! asset('public/backend/files/assets/images/logo ev9.png') !!}" width="40px" class="img-radius" alt="User-Profile-Image">
                                                    @endif
                                                    <h4 class="m-t-20" style="color: white;"><span class="text-c-white">{!! \App\Helpers\General::number_format_($rank[4]->product_price) !!}</span> ฿</h4>
                                                    <p class="m-b-20" style="color: white;">{!! \App\Model\dashboard::name_account($rank[4]->id) !!}</p>
                                                    <span class="label label-primary" style="color: white;">อันดับที่ 5</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($rank->count() > 5)
                                        <div class="col-md-12 col-xl-4">
                                            <div class="card" style="background: linear-gradient(0.25turn, #C06C84, #6C5B7C);">
                                                <div class="card-block text-center">
                                                    @if(\App\Model\dashboard::img_account($rank[5]->id) != '') 
                                                        <img src="{!! url('storage/app/public/image/profile/'.\App\Model\dashboard::img_account($rank[5]->id))  !!}" width="40px" class="img-radius" alt="User-Profile-Image">
                                                    @else
                                                        <img src="{!! asset('public/backend/files/assets/images/logo ev9.png') !!}" width="40px" class="img-radius" alt="User-Profile-Image">
                                                    @endif
                                                    <h4 class="m-t-20" style="color: white;"><span class="text-c-white">{!! \App\Helpers\General::number_format_($rank[5]->product_price) !!}</span> ฿</h4>
                                                    <p class="m-b-20" style="color: white;">{!! \App\Model\dashboard::name_account($rank[5]->id) !!}</p>
                                                    <span class="label label-primary" style="color: white;">อันดับที่ 6</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-md-12 col-xl-12 text-center"><h4>ยังไม่มีการจัดลำดับ</h4></div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>อันดับสะสมในเดือน</h5>
                                                <div class="card-header-right">
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa-chevron-left"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-times close-card"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-block p-0">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th class="text-center">อันดับ</th>
                                                            <th class="text-center">รูป</th>
                                                            <th class="text-center">ชื่อ</th>
                                                            <th class="text-center">ยอดโทร</th>
                                                            <th class="text-center">ยอดขาย</th>
                                                        </tr>
                                                        @forelse($rank_month as $k => $r)
                                                        <tr>
                                                            <td class="text-center">
                                                                @if(($k+1) == 1)
                                                                    <i class="ti-crown"></i>
                                                                @else
                                                                    {!! $k+1 !!}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if(\App\Model\dashboard::img_account($r->id) != '') 
                                                                    <img src="{!! url('storage/app/public/image/profile/'.\App\Model\dashboard::img_account($r->id))  !!}" width="40px" class="img-radius" alt="User-Profile-Image">
                                                                @else
                                                                    <img src="{!! asset('public/backend/files/assets/images/logo ev9.png') !!}" width="40px" class="img-radius" alt="User-Profile-Image">
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{!! \App\Model\dashboard::name_account($r->id) !!}</td>
                                                            <td class="text-center">{!! \App\Model\analytics::list_call_customer_per_month_id($r->id) !!}</td>
                                                            <td class="text-center">{!! \App\Helpers\General::number_format_($r->product_price) !!} ฿</td>
                                                        </tr>
                                                        @empty
                                                        @endforelse
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="styleSelector">

                </div>
            </div>
        </div>
</div>
@stop
               

@push('scripts')
<!-- Required Jquery -->
<script src="{!! asset('public/backend/files/assets/pages/widget/excanvas.js') !!}"></script>
<!-- slimscroll js -->
<script src="{!! asset('public/backend/files/assets/js/SmoothScroll.js') !!}"></script>
<!-- Chart js -->
<script src="{!! asset('public/backend/files/bower_components/chart.js/js/Chart.js') !!}"></script>
<!-- amchart js -->
<script src="{!! asset('public/backend/files/assets/pages/widget/amchart/amcharts.js') !!}"></script>
<script src="{!! asset('public/backend/files/assets/pages/widget/amchart/gauge.js') !!}"></script>
<script src="{!! asset('public/backend/files/assets/pages/widget/amchart/serial.js') !!}"></script>
<script src="{!! asset('public/backend/files/assets/pages/widget/amchart/ammap.js') !!}"></script>
<script src="{!! asset('public/backend/files/assets/pages/widget/amchart/continentsLow.js') !!}"></script>
<script src="{!! asset('public/backend/files/assets/pages/widget/amchart/light.js') !!}"></script>
<!-- custom js -->
<script src="{!! asset('public/backend/files/assets/pages/dashboard/ecommerce-dashboard.js') !!}"></script>
<script>
    window.setTimeout( function() {
        window.location.reload();
    }, 30000);
</script>
@endpush