@extends('layouts.app')
@php
$src = $properties->images->source;
@endphp
@section('links')
<link rel="stylesheet" href="{{asset('public/css/showProperty.css')}}"/>
@endsection

@section('content')
    <div class="container">
        <h2 class="h2">{{$properties->des->title}}</h2>
        <div class="mb-2 properties-icon">
            <span ><i class="fas fa-map-marker-alt"></i> {{$properties->city->city_name}}</span>
            <span><i class="fas fa-building"></i> {{$properties->typeProperty->type}}</span>
            <span><i class="fas fa-expand"></i> <bdi>{{$properties->area}} {{__('property.m')}} <sup>2</sup></bdi></span>
            <span style="float: {{app()->getLocale() == 'en'?'right ;margin-right: 5em;':'left;margin-left:5em'}} ;font-weight: bold;font-size: large;color:#F89406">{{$properties->price}} {{__('property.eg')}} @if($properties->list_section == 'rent') / {{$properties->type_rent}} @endif</span>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @if(isset($src) && count($src) > 0)
                    @for($i=0;$i<count($src);$i++)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="@if($i === 0) active @endif"></li>
                    @endfor
                @endif
            </ol>
            <div class="carousel-inner" style="height: 30em;position: relative;">
                @if(isset($src) && count($src) > 0)
                    @for($i=0;$i<count($src);$i++)
                        <div class="carousel-item @if($i === 0) active @endif position-relative">
                            <img class="d-block w-100 img-thumbnail" style="height: 30em;" src="{{url('public/images/' .$properties->images->source[$i])}}" alt="First slide">
                        </div>
                    @endfor
                @endif
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="container show-property">
            <div class="row">
                @if(isset($properties))
                    <div id="{{$properties->id}}" class="col-sm-12 col-md-8 mt-3 alert alert-info">
                        <div class="row">
                            <div class="col-12"><h4>{{__('property.information_about_Property')}} :</h4></div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.type_property')}} :  </span> {{$properties->typeProperty->type}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 " ><span>{{__('property.view')}} :  </span> {{$properties->view->list}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.use_for')}} :  </span> {{$properties->list_section}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.floor')}} :  </span> {{$properties->num_floor}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.number_of_rooms')}} :  </span> {{$properties->num_rooms}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.number_of_bathrooms')}}:  </span> {{$properties->num_bathroom}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.finish')}} :  </span> {{$properties->finish->type}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.city')}} :  </span> {{$properties->city->city_name}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.type_pay')}} :  </span> {{$properties->payment->type}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4" style="color:#F89406"><span>{{__('property.price')}} :  </span > {{$properties->price}} {{__('property.eg')}}@if($properties->list_section == 'rent') / {{$properties->type_rent}} @endif </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.link_youtube')}} :  </span><button class="btn btn-primary background-saknni"><a href="{{$properties->link_youtube}}" target="_blank">Youtube link</a></button> </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.location')}} :  </span> {{$properties->location}}</div>
                            <div class="col-12"><hr/></div>
                            <div class="col-12 "><span class="text-dark font-weight-bold">{{__('property.details_property')}} :  </span>
                                <p class="text-secondary ">
                                    {{$properties->des->details}}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="co-sm-12 col-md-4 text-center contact mt-md-5">
                        <div >
                            <div class="mt-5 mb-3">
                                <button class="btn btn-primary w-75  show-number btn-lg background-saknni"><i class="fas fa-phone"></i>{{__('property.show_number')}}</button>
                                <a class="btn btn-primary btn-lg number-phone mb-3 background-saknni" href="tel:{{$properties->user->phone}}">{{$properties->user->phone}}</a>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary w-75 show-email btn-lg background-saknni"><i class="fas fa-envelope-square"></i>{{__('property.show_email')}}</button>
                                <div class="mt-4"></div>
                                <a class="btn btn-primary email btn-lg mt-3 background-saknni" href="mailto:{{$properties->user->email}}">{{$properties->user->email}}</a>
                            </div>

                        </div>
                    </div>

                @endif
            </div>
        </div>
        <div class="container mt-3" id="display_comment">
            <h3>{{__('property.comments')}}</h3>
            @include('property.commentsDisplay', ['comments' => $properties->comments, 'property_id' => $properties->id])
        </div>
        <div class="container">
            <hr />
            @auth()
            <h4>{{__('property.add_comment')}}</h4>
            <form class="add-comment">
                @csrf
                <div class="form-group">
                    <textarea  class="form-control" name="body" id="comment_body"></textarea>
                    <input type="hidden" name="property_id" value="{{ $properties->id }}" />
                    <p class="text-danger error"></p>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success btn-add-comment background-saknni" value="{{__('property.add_comment')}}" />
                </div>
            </form>
              @else
                <div class="text-primary text-center"> {{__('property.to_add_comment')}} <a class="btn btn-sm btn-primary background-saknni" href="{{route('login')}}">{{__('property.login')}}</a></div>
            @endauth
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('public/js/showProperty.js')}}"></script>
    {{--<script src="{{asset('public/js/addComment.js')}}"></script>--}}
    @auth()
    <script>
        $(".btn-add-comment").click(function(e){
            let property_id = $('.add-comment input[name="property_id"]')[0].value;
            let body = $('.add-comment #comment_body')[0].value;
            e.preventDefault();
            if(body  != ""){
                $('.error').show().text("");
                $.ajax({
                    type: 'post',
                    url: '{{route("comments.store")}}',
                    data: {
                        '_token' : "{{csrf_token()}}",
                        'property_id' : property_id,
                        'body' :  body,
                    },
                    success: function(data) {
                        if(data.status == true){
                            $('#display_comment ').append(
                                '<div class="display-comment">'+

                                '        <strong>{{Auth::user()->name}}</strong>\n' +
                                '        <p>'+ body +'</p>\n' +
                                '        </div>'
                                );
                            $('#comment_body')[0].value = "";
                        }
                    },
                    error: function(reject) {

                    },
                });
            }else{
                $('.error').show().text('comment body is required');
            }

        });
        </script>
    @endauth
        {{--
        $(".add-replay").click(function(e){
            e.preventDefault();
            //let dataForm= new FormData($(this.parent()));
            let body = this.parentNode.previousElementSibling.children[0].value;
            let property_id = this.parentNode.previousElementSibling.children[1].value;
            let parent_id = this.parentNode.previousElementSibling.children[2].value;
            if(body  != ""){
                $('.error').show().text("");
                $.ajax({
                    type: 'post',
                    url: '{{route("comments.store")}}',
                    data: {
                        '_token': "{{csrf_token()}}",
                        'property_id': property_id,
                        'body': body,
                        'parent_id': parent_id,
                    },
                    success: function (data) {
                        if(data.status == true) {
                            $(this).parentsUntil('.display-comment').append(
                                '<div class="display-comment">' +

                                '        <strong>{{Auth::user()->name}}</strong>\n' +
                                '        <p>' + body + '</p>\n' +
                                '        <a class=\"replay\" href=\"\" id=\"reply\">replay</a>\n' +
                                '        <form class=\"comment\" method=\"post\" action=\"{{ route('comments.store') }}\">\n' +
                                '            @csrf \n' +
                                '            <div class=\"form-group custom-control-inline w-75\">\n' +
                                '                <input type="text" name="body" class="form-control" />\n' +
                                '                <input type="hidden" name="property_id" value="{{ $properties->id }}" />\n' +
                                '                <input type="hidden" name="parent_id" value="' + data.id + ' />\n' +
                                '            </div>\n' +
                                '            <div class="form-group custom-control-inline w-20">\n' +
                                '                <input type="submit" class="btn btn-warning" value="Reply" />\n' +
                                '            </div>\n' +
                                '        </form></div>'
                            );
                            $('input[name="body"]').val("");
                        }
                    },
                });
            }else{
                    $(this).parent().next('p.error-replay').show().text('comment body is required');
                }
            });
    </script> -->--}}

    @include('layouts.scriptFavorite')
@endsection
