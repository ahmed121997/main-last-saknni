@extends('layouts.app')

@section('content')
    <div class="container">
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="message text-danger"><i class="fa fa-check-circle" aria-hidden="true"></i> {{$error}}</div>
                @endforeach
            
            @endif

        

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('users.update_your_profile') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.store_change_password', $user->id) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="old_password" class="col-md-4 col-form-label text-md-center">{{ __('users.old_password') }}</label>

                                <div class="col-md-6">
                                    <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password"  required  autofocus>

                                    @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_password" class="col-md-4 col-form-label text-md-center">{{ __('users.new_password') }}</label>

                                <div class="col-md-6">
                                    <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password"  required >

                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="confirm_new_password" class="col-md-4 col-form-label text-md-center">{{ __('users.confirm_new_password') }}</label>

                                <div class="col-md-6">
                                    <input id="confirm_new_password" type="password" class="form-control @error('confirm_new_password') is-invalid @enderror" name="confirm_new_password"  required >

                                    @error('confirm_new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 text-right">
                                    <button type="submit" class="btn btn-primary  ">
                                        {{ __('users.update') }}
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
@section('script')
<script>
    $('.button_show').click(function (e) {
    let btn_id = this.getAttribute('id');
    let id = btn_id.search("-");
    $('.property-'+btn_id.slice(id+1)).fadeToggle().siblings('.property').hide();
    });
</script>
@endsection
