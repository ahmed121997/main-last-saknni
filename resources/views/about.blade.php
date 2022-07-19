@extends('layouts.app')
@section('links')
    <link href="{{ asset('public/css/about.css') }}" rel="stylesheet">
@endsection
@section('content')
        <div class="container text-center">
            <h2 class="mb-3">Our Team</h2>
            <div class="row">

                @if(app()->getLocale()== 'ar')
                    <div class="col-lg-2"></div>
                @endif

                <div class="col-md-6 col-lg-4 {{app()->getLocale() == 'en'?'offset-lg-2':''}}">
                    <div class="card profile-card-1">
                        <img src="https://images.pexels.com/photos/946351/pexels-photo-946351.jpeg?w=500&h=650&auto=compress&cs=tinysrgb" alt="profile-sample1" class="background"/>
                        <img src="{{asset('public/images/admin/elkomy.jpg')}}" alt="profile-image" class="profile"/>
                        <div class="card-content">
                            <h2>Ahmed Elkomy<small>Engineer</small></h2>
                                <div class="icon-block">
                                    <a href="https://www.facebook.com/ahmed.elkomy.7902" target="_blank"><i class="fab fa-facebook"></i></a>
                                    <a href="https://twitter.com/ahmed_elk00my" target="_blank"> <i class="fab fa-twitter"></i></a>
                            </div>
                            <p class="mt-lg-3 pt-5  text-center">Backend php laravel programmer</p>
                        </div>

                    </div>

                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card profile-card-1">
                        <img src="https://images.pexels.com/photos/946351/pexels-photo-946351.jpeg?w=500&h=650&auto=compress&cs=tinysrgb" alt="profile-sample1" class="background"/>
                        <img src="{{asset('public/images/admin/karim.jpg')}}" alt="profile-image" class="profile"/>
                        <div class="card-content">
                            <h2>Karim Mohammed<small>Engineer</small></h2>
                            <div class="icon-block">
                                <a href="https://www.facebook.com/7.karim.m.abdelkarim" target="_blank"><i class="fab fa-facebook"></i></a>
                                <a href="https://twitter.com/KimmOoOz" target="_blank"> <i class="fab fa-twitter"></i></a>
                            </div>
                            <p class="mt-lg-3 pt-5  text-center">Frontend react native programmer </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
@endsection
@section('script')

@endsection
