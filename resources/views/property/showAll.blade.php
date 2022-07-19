@extends('layouts.app')
@section('links')

    <link href="{{ asset('public/css/showAllProperty.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @if(isset($properties) && count($properties) > 0)
                @foreach($properties as $property)
                    <div class="col-md-6 col-lg-4  mb-4">
                        <div class="card mb-3" style="max-width: 30rem;max-height: 30em;min-height: 30em">
                            <img style="height: 14em" src="{{url('public/images/'. $property->images->source[1])}}" class="card-img-top img-thumbnail" alt="img">
                            <div class="ml-2 mt-2 properties-icon">
                                <span ><i class="fas fa-map-marker-alt"></i> {{$property->city->city_name}}</span>
                                <span><i class="fas fa-building"></i> {{$property->typeProperty->type}}</span>
                                <span><i class="fas fa-expand"></i> <bdi>{{$property->area}} {{__('property.m')}} <sup>2</sup></bdi></span>
                            </div>
                            <div class="card-body">

                                <h5 class="card-title">{{$property->des->title}}</h5>
                                <div class="row" style="height: 110px">
                                    <p class="card-text col-6"><span>{{__('property.finish')}} : </span>{{$property->finish->type}}</p>
                                    <p class="card-text col-6"><span>{{__('property.rooms')}} : </span>{{$property->num_rooms}}</p>
                                    <p class="card-text col-6"><span>{{__('property.price')}}  : </span>{{$property->price}} {{__('property.eg')}} @if($property->list_section == 'rent') / {{$property->type_rent}} @endif</p>
                                    <p class="card-text col-6"><span>{{__('property.view')}}  : </span>{{$property->view->list}}</p>
                                </div>

                                <a href="{{route('show.property',$property->id)}}" class="btn btn-primary" target="_blank">{{__('property.show_details')}}</a>
                                @include('property.favorite',['id'=>$property->id,'fav'=>$property->favorite])
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
        <div class="d-flex justify-content-center mt-2">{{$properties->links()}}</div>
        @endif
    </div>
@endsection
@section('script')

    @include('layouts.scriptFavorite')

@endsection
