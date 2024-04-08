<div class="wrapper">

    @include('layouts.dashboard.navbars.auth')

    <div class="main-panel">
        @include('layouts.dashboard.navbars.navs.auth')
        @yield('content')
        @include('layouts.dashboard.footer')
    </div>
</div>
