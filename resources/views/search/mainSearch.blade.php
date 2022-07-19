@extends('layouts.app')
@section('links')

    <link href="{{ asset('public/css/welcome.css') }}" rel="stylesheet">

@endsection
@section('content')

    <div class="text-center h2  welcome-message p-4 ">

        @include('search.formMainSearch',['type_properties'=>$type_properties,'type_payments'=>$type_payments,'govs'=>$govs])

    </div>
    <div class="container welcome">
    <h3 class="mt-lg-3"> <i class="fa fa-home" aria-hidden="true"></i>
         {{__('property.property_for')}} {{$sell_rent == 'rent'? __('property.rent'):__('property.sell')}}
    @if($city_name != null) {{__('property.in')}} {{$city_name->city_name}}@endif </h3>
        <hr/>
        <div class="row">
            @if(isset($properties) && count($properties) > 0)
                @foreach($properties as $property)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card " style="max-width: 30rem;max-height: 30em;min-height: 30em">
                            <img style="height: 14em" src="{{url('public/images/'. $property->images->source[0])}}" class="card-img-top img-thumbnail" alt="img">
                            <div class="ml-2 mt-2 properties-icon">
                                <span ><i class="fas fa-map-marker-alt"></i> {{$property->city->city_name}}</span>
                                <span><i class="fas fa-building"></i> {{$property->typeProperty->type}}</span>
                                <span> <i class="fas fa-expand"></i> <bdi>{{$property->area}} {{__('property.m')}} <sup>2</sup></bdi></span>
                            </div>
                            <div class="card-body">

                                <h4 class="card-title mt-1">{{$property->des->title}}</h4>
                                <div class="row" style="height: 110px">
                                    <p class="card-text col-6"><span>{{__('property.finish')}} : </span>{{$property->finish->type}}</p>
                                    <p class="card-text col-6"><span>{{__('property.rooms')}} : </span>{{$property->num_rooms}}</p>
                                    <p class="card-text col-6"><span>{{__('property.price')}}  : </span>{{$property->price}} {{__('property.eg')}}@if($property->list_section == 'rent') / {{$property->type_rent}} @endif</p>
                                    <p class="card-text col-6"><span>{{__('property.view')}}  : </span>{{$property->view->list}}</p>
                                </div>
                                <a href="{{route('show.property',$property->id)}}" class="btn btn-primary" target="_blank">{{__('property.show_details')}}</a>
                                @include('property.favorite',['id'=>$property->id,'fav'=>$property->favorite])
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
        <div class="d-flex justify-content-center mt-2">
        </div>
        @endif

    </div>
@endsection

@section('script')

    @include('search.scriptMainSearch')
    @include('layouts.scriptFavorite')
@endsection
