@extends('layouts.app')
@section('links')

<link href="{{ asset('public/css/welcome.css') }}" rel="stylesheet">

@endsection
@section('content')
<div class="container welcome">
    <h3 class="mt-lg-3"> <i class="fa fa-home" aria-hidden="true"></i> {{__('property.favorite_properties')}}</h3>
    <hr/>
    <div class="row">
        @if(isset($properties) && count($properties) > 0)
            @foreach($properties as $property)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card " style="max-width: 30rem;max-height: 30em;min-height: 30em">
                        <img style="height: 14em" src="{{url('public/images/'. $property->images->source[0])}}" class="card-img-top img-thumbnail" alt="img">
                        <div class="ml-2 mt-2 properties-icon">
                            <span ><i class="fas fa-map-marker-alt"></i>@if(app()->getLocale() == 'en') {{$property->city->city_name_en}} @else {{$property->city->city_name_ar}} @endif</span>
                            <span><i class="fas fa-building"></i> {{$property->typeProperty->type_en}}</span>
                            <span> <i class="fas fa-expand"></i> <bdi>{{$property->area}} {{__('property.m')}} <sup>2</sup></bdi></span>
                        </div>
                        <div class="card-body">

                            <h4 class="card-title mt-1">{{$property->des->title}}</h4>
                            <div class="row" style="height: 110px">
                                <p class="card-text col-6"><span>{{__('property.finish')}} : </span> @if(app()->getLocale() == 'en') {{$property->finish->type_en}} @else {{$property->finish->type_ar}} @endif</p>
                                <p class="card-text col-6"><span>{{__('property.rooms')}} : </span>{{$property->num_rooms}}</p>
                                <p class="card-text col-6"><span>{{__('property.price')}}  : </span>{{$property->price}} {{__('property.eg')}}@if($property->list_section == 'rent') / {{$property->type_rent}} @endif</p>
                                <p class="card-text col-6"><span>{{__('property.view')}}  : </span> @if(app()->getLocale() == 'en') {{$property->view->list_en}} @else {{$property->view->list_ar}} @endif</p>
                            </div>

                            <a href="{{route('show.property',$property->id)}}" class="btn btn-primary" target="_blank">{{__('property.show_details')}}</a>

                            @include('property.favorite',['id'=>$property->id,'fav'=>$property->favorite])
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>
@endsection
@section('script')

@include('layouts.scriptFavorite')
@endsection
