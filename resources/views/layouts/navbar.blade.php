@php
    $locale = App::getLocale();
    $margin = $locale === 'en' ? true : false;
@endphp
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand ml-5" href="{{ url('/') }}">
            <span class="s">S</span><span class="ak">Ak</span><span class="nni">nNi</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav {{$margin ? 'mr-auto': 'ml-auto'}}">
                <li class="nav-item {{ Route::currentRouteNamed('add.property') ? 'active' : '' }}">
                    <a class="nav-link"  href="{{ route('add.property') }}">{{ __('navbar.add_property') }}</a>
                </li>
                <li class="nav-item {{ Route::currentRouteNamed('show.all.properties') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('show.all.properties') }}">{{ __('navbar.properties') }}</a>
                </li>
                <li class="nav-item {{ Route::currentRouteNamed('index.search') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('index.search') }}">{{ __('navbar.search') }}</a>
                </li>

                <li class="nav-item {{ Route::currentRouteNamed('about') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('about') }}">{{ __('navbar.about') }}</a>
                </li>

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav {{$margin ? 'ml-auto': 'mr-auto'}}">

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('navbar.login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('navbar.register') }}</a>
                        </li>
                    @endif
                @else

                <!-- Nav Item - Alerts -->
                    {{--<li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">4+</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>--}}

                   {{-- <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>

                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>
                    --}}

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown" >
                            <a class="dropdown-item font-weight-bold" href="{{ route('user.index') }}">
                                {{ __('navbar.profile') }}
                            </a>

                            <a class="dropdown-item font-weight-bold" href="{{ route('user.favorite') }}">
                                {{ __('navbar.favorite') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('navbar.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest

                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    @if(app()->getLocale() !== $localeCode)
                        <li  class="nav-item mr-lg-3 ml-lg-3" >
                            <a class="nav-link" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
