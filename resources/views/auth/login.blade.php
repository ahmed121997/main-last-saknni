
@extends('layouts.app')
@section('pre-links')

<link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.css"
    rel="stylesheet"/>
@endsection
@section('links')

<style>

    .gradient-custom-2 {
    /* fallback for old browsers */
    background: #fccb90;

    /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(90deg, rgb(0 88 106) 0%, rgb(55 91 124) 33%, rgb(8 108 129) 48%);

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(90deg, rgb(0 88 106) 0%, rgb(55 91 124) 33%, rgb(8 108 129) 48%);
    }

    @media (min-width: 768px) {
    .gradient-form {

    }
    }
    @media (min-width: 769px) {
    .gradient-custom-2 {
    border-top-right-radius: .3rem;
    border-bottom-right-radius: .3rem;
    }
    }
    a{
        text-decoration: none;
    }
    .Footer {
        margin-top: 0;
    }
    </style>
@endsection

@section('content')
<section class="gradient-form">
    <div class="container py-2">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black border-saknni">
                    <div class="row g-0">
                        <div class="col-lg-6" style="direction: ltr">
                            <div class="card-body p-md-3 mx-md-4">

                                <div class="text-center">
                                    <img src="{{asset('public/logo.jpg')}}"
                                        style="width: 185px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-2">We are <span class="color-saknni">The Saknni</span> Company</h4>
                                </div>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <p @if (app()->getLocale() === 'ar') style="text-align:right" @endif>{{__('logins.Please_login_to_your_account')}}</p>

                                    {{-- email inpput --}}
                                    <div class="form-outline mb-4">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                                        <label class="form-label" for="email">{{ __('logins.email') }}</label>

                                        @error('email')
                                        <span class="invalid-feedback mb-5" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- password input --}}
                                    <div class="form-outline mb-4 mt-4">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" />
                                        <label class="form-label" for="password">{{ __('logins.password') }}</label>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- remember me --}}
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('logins.remember_me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center pt-1 mb-4 pb-1">

                                        @if (Route::has('password.request'))
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                            type="submit"> {{ __('logins.login') }}</button>
                                        <a class="text-muted" href="{{ route('password.request') }}">
                                            {{ __('logins.forget_your_password') }}
                                        </a>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">{{__('logins.Dont_have_an_account?')}}</p>

                                        <a class="btn btn-outline-danger border-saknni color-saknni" href="{{ route('register') }}"> {{ __('logins.create_new') }}</a>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">We are more than just a company</h4>
                                <p class=" mb-0">{{__('footer.saknni_message')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.js"></script>
@endsection
