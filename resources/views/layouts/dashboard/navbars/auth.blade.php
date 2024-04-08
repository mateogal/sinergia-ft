<div class="sidebar" data-color="black" data-active-color="info">
    <div class="logo">
        <a href="/" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="/images/icon.png">
            </div>
        </a>
        <a href="/" class="simple-text logo-normal">
            {{ __('Sinergia F.T') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'home') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'match_history' ? 'active' : '' }}">
                <a href="{{ route('home.match_history') }}">
                    <i class="nc-icon nc-paper"></i>
                    <p>{{ __('Historial Partidos') }}</p>
                </a>
            </li>
            {{-- <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="false" href="#laravelExamples">
                    <i class="nc-icon"><img src="{{ asset('paper/img/laravel.svg') }}"></i>
                    <p>
                            {{ __('Laravel examples') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon">{{ __('UP') }}</span>
                                <span class="sidebar-normal">{{ __(' User Profile ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}
        </ul>
    </div>
</div>
