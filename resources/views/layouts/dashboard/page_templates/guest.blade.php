@include('layouts.dashboard.navbars.navs.guest')

<div class="wrapper wrapper-full-page ">
    <div class="full-page section-image" filter-color="black" data-image="{{ '/' . ($backgroundImagePath ?? "images/bg2.jpg") }}">
        @yield('content')
        @include('layouts.dashboard.footer')
    </div>
</div>
