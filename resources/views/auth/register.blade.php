@extends('layouts.app')

@section('content')

<div class="container pt-lg-5 mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h5 background-saknni">{{ __('registers.register') }}</div>

                <div class="card-body border-saknni" style="font-size: 13px;font-weight: bold;text-align: justify;">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="offset-lg-1 col-lg-3 col-form-label">{{ __('registers.name') }}</label>

                            <div class="col-lg-7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="offset-lg-1 col-lg-3 col-form-label">{{ __('registers.email') }}</label>

                            <div class="col-lg-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="offset-lg-1 col-lg-3 col-form-label">{{ __('registers.phone') }}</label>

                            <div class="col-lg-7">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"  required autocomplete="phone" value="{{ old('phone') }}">

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="offset-lg-1 col-lg-3 col-form-label">{{ __('registers.password') }}</label>

                            <div class="col-lg-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="offset-lg-1 col-lg-3 col-form-label">{{ __('registers.confirm_password') }}</label>

                            <div class="col-lg-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-4 d-flex justify-content-center ">
                            <div class="">
                                <button type="submit" class="btn p-2 background-saknni">
                                    {{ __('registers.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
