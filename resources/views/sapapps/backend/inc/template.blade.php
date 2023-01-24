<!-- Header -->
@include('sapapps.backend.inc.header')
<!-- #END# Header -->
@stack('styles')

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    <!-- Preload -->
    @include('sapapps.backend.inc.preload')
    <!-- #END# Preload -->
    <!-- Top Body -->
    @include('sapapps.backend.inc.top_body')
    <!-- #END# Top Body -->

    <!-- Sidebar inner chat end-->
    @include('sapapps.backend.inc.left_menu')
    <!-- #END# Left Menu -->
    @yield('content')

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


    <!-- Footer -->
    @include('sapapps.backend.inc.footer')
    <!-- #END# Footer -->
    @stack('scripts')
</body>

</html>
