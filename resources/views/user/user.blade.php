@extends('layouts.app')

@section('links')

    <link href="{{ asset('public/css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        @if(Session::has('success_update'))
            <div class="message text-success"><i class="fa fa-check-circle" aria-hidden="true"></i> {{Session::get('success_update')}}</div>

        @endif
            @if(Session::has('message'))
                <div class="message text-success"><i class="fa fa-check-circle" aria-hidden="true"></i> {{Session::get('message')}}</div>

            @endif
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{__('users.personal_information')}}
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div><span>{{__('users.name')}} : </span> {{Auth::user()->name}}</div>
                        <div><span>{{__('users.email')}} : </span> {{Auth::user()->email}}</div>
                        <div><span>{{__('users.phone')}} : </span> {{Auth::user()->phone}}</div>
                        <div><span>{{__('users.last_edit')}} : </span> {{Auth::user()->updated_at}}</div>
                        <div class="text-danger font-weight-bold"><span>{{__('users.ads_not_active')}} : </span> {{$not_active}}</div>
                        <div class="text-right">
                            <button class="btn btn-primary  mr-3 mt-3"><a href="{{route('user.edit')}}">Edit</a></button>
                            <button class="btn btn-primary mr-3 mt-3"><a href="{{route('user.change_password')}}">Change Password</a></button>
                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            {{__('users.your_properties')}}
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            @if(isset($properties) && count($properties) > 0)
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">{{__('users.type')}}</th>
                                    <th scope="col">{{__('users.view')}}</th>
                                    <th scope="col">{{__('users.area')}}</th>
                                    <th scope="col">{{__('users.price')}}</th>
                                    <th scope="col">{{__('users.#_rooms')}}</th>
                                    <th scope="col">{{__('users.#_bathrooms')}}</th>
                                    <th scope="col">{{__('users.status')}}</th>
                                    <th scope="col">{{__('users.control')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                        @foreach($properties as $property)
                                        <tr class="text-center">
                                            <th scope="row">{{$property->id}}</th>
                                            <td>{{app()->getLocale() == 'en'?$property->typeProperty->type_en : $property->typeProperty->type_ar}}</td>
                                            <td>{{app()->getLocale() == 'en'? $property->view->list_en : $property->view->list_ar}}</td>
                                            <td>{{$property->area}}</td>
                                            <td>{{$property->price}}</td>
                                            <td>{{$property->num_rooms}}</td>
                                            <td>{{$property->num_bathroom}}</td>
                                            <td class="@if($property->status === 'Not active') text-danger @endif">{{$property->status}}</td>

                                            <td>
                                                @if($property->status === 'Not active')

                                                    <abbr title="{{__('users.active')}}" ><a target="_blank" href="{{route('property.activation',$property->id)}}"><i class="fas fa-exclamation-circle text-success"></i></a></abbr>
                                                @endif
                                                    <abbr title="{{__('users.show')}}"> <a  id="btn-{{$property->id}}" href="#{{$property->id}}" class="button_show"><i class="fas fa-eye text-primary"></i></a></abbr>

                                                    <abbr title="{{__('users.edit')}}"> <a href="{{route('edit.property',$property->id)}}" target="_blank"><i class="fas fa-edit text-secondary"></i></a></abbr>

                                                    <abbr title="{{__('users.delete')}}"><a class="property-delete" href="{{route('delete.property',$property->id)}}" ><i class="far fa-trash-alt text-danger"></i></a></abbr>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="text-danger text-center">{{__('users.no_properties')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-------- end accordion--------------->
        <div class="container show-property">
            <div class="row">

                @if(isset($properties) && count($properties) > 0)
                    @foreach($properties as $property)
                        <div id="{{$property->id}}" class="col col-12 property property-{{$property->id}}  mt-lg-5 alert alert-info">
                            <h3 class="text-gray-600 ">{{__('users.property')}} # {{$property->id}}</h3>
                            <hr class="mb-5"/>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.type_property')}} :  </span> {{app()->getLocale() == 'en'?$property->typeProperty->type_en : $property->typeProperty->type_ar}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" ><span>{{__('users.view')}} :  </span> {{app()->getLocale() == 'en'? $property->view->list_en : $property->view->list_ar}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.usage')}} :  </span> {{$property->list_section}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.floor')}} :  </span> {{$property->num_floor}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.number_of_rooms')}} :  </span> {{$property->num_rooms}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.number_of_bathrooms')}} :  </span> {{$property->num_bathroom}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.type_finish')}} :  </span> {{app()->getLocale() == 'en'? $property->finish->type_en:$property->finish->type_ar}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.city')}} :  </span> {{$property->city->city_name_en}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.type_pay')}} :  </span> {{$property->payment->type}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.price')}} :  </span> {{$property->price}}</div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.link_youtube')}} :  </span><a class="link-youtube" href="{{$property->link_youtube}}">Youtube link</a></div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><span>{{__('users.location')}} :  </span> {{$property->location}}</div>

                                <div class="col-12"><span>{{__('users.images')}}:  </span>
                                    @if(isset($property->images->source) && count($property->images->source))
                                        <div class="row">
                                            @for($i = 0; $i< count($property->images->source);$i++)
                                                <div class="col-sm-12 col-md-6 col-lg-4">
                                                    <img style="width: 20em;height: 20em;" class="img-thumbnail" src="{{url('public/images/'. $property->images->source[$i])}}" alt=""/>
                                                </div>
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
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
