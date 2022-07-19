@extends('layouts.app')

@section('links')

    <link href="{{ asset('public/css/addProperty.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- MultiStep Form -->

    <div class="container justify-content-center">
        <div class="row">

            @if(Session::has('fail_add'))
                <div class="message text-danger">{{Session::get('fail_add')}}
                    <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                </div>

            @endif

            @if(Session::has('success_add'))
                <div class="message text-success">{{Session::get('success_add')}}
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>
            @endif
                @if(app()->getLocale() == 'ar')
                    <div class="col-md-1 col-lg-2"></div>
                    @endif
            <div class="col-sm-12 col-md-10 col-lg-8 offset-md-1 offset-lg-2">
                <form id="msform" method="post" action="{{route('store.property')}}" enctype="multipart/form-data">
                    @csrf
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active">{{__('property.get_started')}}</li>
                        <li>{{__('property.details_for_property')}}</li>
                        <li>{{__('property.your_location')}}</li>
                        <li>{{__('property.title')}} </li>
                        <li>{{__('property.property_price')}}</li>
                        <li>{{__('property.description')}}</li>
                    </ul>
                    <!-- start fieldset one -->
                    <fieldset>
                        <h2 class="fs-title">{{__('property.get_started_add_your_property')}}</h2>
                        <h3 class="fs-subtitle">{{__('property.build_info_about_your_property')}}</h3>

                        <label>{{__('property.type_property')}}:</label>
                        <select name="typeProperty" id="typeProperty">
                            <option disabled selected value="">{{__('property.choose_type_property')}}</option>
                            @if(isset($type_properties) && count($type_properties) > 0)
                                    @foreach($type_properties as $type_property)
                                        <option value="{{$type_property->id}}">{{$type_property->type}}</option>
                                    @endforeach
                                @endif
                        </select>

                        <label>{{__('property.list_section')}}:</label>
                        <select name="listSection" id="listSection">
                            <option value="" selected disabled>{{__('property.choose_list_section')}}</option>
                            <option value="sell">{{__('property.sell')}}</option>
                            <option value="rent">{{__('property.rent')}}</option>
                        </select>

                        <label>{{__('property.area')}}:</label>
                        <input type="text" name="area" id="area" placeholder="{{__('property.area')}}  - 40-5000 "  autoComplete="off"/>
                        <p class="not-valid not-valid-area text-danger" > </p>

                        <label>{{__('property.view_list')}}:</label>
                        <select name="listView" id="listView">
                            <option value="" selected disabled>{{__('property.choose_listing_view')}}</option>

                        @if(isset($list_views) && count($list_views) > 0)
                                @foreach($list_views as $list_view)
                                    <option value="{{$list_view->id}}">{{$list_view->list}}</option>
                                @endforeach
                            @endif
                        </select>

                        <input  type="button" name="next" class="next action-button btn" value="{{__('property.next')}}"/>
                    </fieldset>
                        <!-- end fieldset one -->
                        <!-- Start fieldset two -->
                        <fieldset>
                            <h2 class="fs-title">{{__('property.details_for_Property')}}</h2>
                            <h3 class="fs-subtitle">{{__('property.tell_us_details_about_your_property')}}</h3>

                        <label>{{__('property.floor')}}:</label>
                        <input   type="text" name="floor" id="floor" placeholder="{{__('property.floor')}} 0 - 100" autoComplete="off"/>
                            <p class="not-valid not-valid-floor text-danger" ></p>

                        <label>{{__('property.rooms')}}:</label>
                        <input   type="text" name="rooms" id="rooms" placeholder="{{__('property.number_of_rooms')}} 1 - 100" autoComplete="off"/>
                            <p class="not-valid not-valid-rooms text-danger" ></p>

                        <label>{{__('property.bathrooms')}}:</label>
                        <input   type="text" name="bathroom" id="bathroom" placeholder="{{__('property.number_of_bathrooms')}} 1 - 50" autoComplete="off"/>
                            <p class="not-valid not-valid-bathrooms text-danger" ></p>

                        <label>{{__('property.type_finish')}}:</label>
                        <select name="typeFinish" id="typeFinish">
                            <option value="" selected disabled>{{__('property.choose_type_of_finish')}}</option>
                            @if(isset($type_finishes) && count($type_finishes) > 0)
                                @foreach($type_finishes as $type_finish)
                                    <option value="{{$type_finish->id}}">{{$type_finish->type}}</option>
                                @endforeach
                            @endif
                        </select>

                        <input type="button" name="previous" class="previous action-button-previous" value="{{__('property.previous')}}"/>
                        <input type="button" name="next" class="next action-button" value="{{__('property.next')}}"/>
                    </fieldset>
                    <!-- End fieldset two -->

                    <!-- Start fieldset three -->
                    <fieldset>
                        <h2 class="fs-title">{{__('property.your_location')}}</h2>
                        <h3 class="fs-subtitle">{{('property.tell_us_about_location_of_property')}}</h3>
                        <!--choose your governorate for your property -->

                        <label>{{__('property.gov')}}:</label>
                        <select name="gov" id="gov">
                            <option value="" selected disabled>{{__('property.choose_governorate')}}</option>
                            @if(isset($govs) && count($govs) > 0)
                                @foreach($govs as $gov)
                                    <option value="{{$gov->id}}">{{$gov->governorate_name}}</option>
                                @endforeach
                            @endif
                        </select>

                        <label>{{__('property.city')}}:</label>
                        <select name="city" id="city">
                            <option  value="" selected disabled>{{__('property.choose_city')}}</option>
                            <optgroup label="all cities in this gov">

                            </optgroup>
                        </select>

                        <label>{{__('property.location')}}:</label>
                        <input type="text" name="location" id="landMark" placeholder="{{__('property.location_by_details')}}" autoComplete="off"/>

                        <input type="button" name="previous" class="previous action-button-previous" value="{{__('property.previous')}}"/>
                        <input type="button" name="next" class="next action-button" value="{{__('property.next')}}"/>
                    </fieldset>
                    <!-- End fieldset three -->

                    <!-- Start fieldset four -->
                    <fieldset>
                        <h2 class="fs-title">{{__('property.title_your_ads.')}}</h2>
                        <h3 class="fs-subtitle">{{__('property.tell_us_what_Title_you_want_to_be_show')}}</h3>

                        <label>{{__('property.title')}}:</label>
                        <input type="text" name="title" id="titleAr" placeholder="{{__('property.title')}}"/>

                        <label>{{__('property.details')}}:</label>
                        <textarea name="details" id="details" placeholder="{{__('property.details')}}"></textarea>


                        <input type="button" name="previous" class="previous action-button-previous" value="{{__('property.previous')}}"/>
                        <input type="button" name="next" class="next action-button" value="{{__('property.next')}}"/>
                    </fieldset>
                    <!-- End fieldset four -->

                    <!-- Start fieldset five -->
                    <fieldset>
                        <h2 class="fs-title">{{__('property.property_price')}}</h2>
                        <h3 class="fs-subtitle">{{__('property.tell_us_about_your_price_you_want')}}</h3>

                        <label>{{__('property.type_pay')}}:</label>
                        <select name="typePay" id="typePay">
                            <option value="" selected disabled>{{__('property.choose_type_pay')}}</option>
                            @if(isset($type_payments) && count($type_payments) > 0)
                                @foreach($type_payments as $type_payment)
                                    <option value="{{$type_payment->id}}">{{$type_payment->type}}</option>
                                @endforeach
                            @endif
                        </select>

                        <label>{{__('property.price')}}:</label>
                        <input type="text" name="price" id="price" placeholder="{{__('property.price')}}" autocapitalize="off"/>


                        <input type="button" name="previous" class="previous action-button-previous" value="{{__('property.previous')}}"/>
                        <input type="button" name="next" class="next action-button" value="{{__('property.next')}}"/>
                    </fieldset>
                    <!-- End fieldset five -->

                    <!-- Start fieldset six -->
                    <fieldset>
                        <h2 class="fs-title">{{__('property.description')}}</h2>
                        <h3 class="fs-subtitle">{{__('property.describe_your_property_by_images_or_youtube')}}</h3>

                        <label>{{__('property.link_youtube')}}:</label>
                        <input type="text" name="linkYoutube" id="linkYoutube" placeholder="{{__('property.link_youtube')}}"/>


                        <label>{{__('property.images')}}:</label>
                        <input type="file" name="images[]" id="images" multiple placeholder="{{__('property.images')}}"/>

                        <input type="button" name="previous" class="previous action-button-previous" value="{{__('property.previous')}}"/>
                        <input type="submit" name="submit" class="submit action-button" value="{{__('property.submit')}}"/>
                    </fieldset>
                    <!-- End fieldset six -->

                    <div style="margin: 10px auto;width:80%" class="alert alert-danger error"></div>
                        @if($errors->any())
                            <div class="alert alert-danger mt-3">
                                @foreach ($errors->all() as $error)
                                    <p>{{$error}}</p>
                                @endforeach
                            </div>
                        @endif

                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
<script  src="{{asset('public/js/addProperty.js')}}"></script>
<script>
    $("#gov").change(function(){
        $.ajax({
            type: 'post',
            url: '{{route("get.cities")}}',
            data: {
                '_token' : '{{csrf_token()}}',
                'id' : this.value,
            },
            success: function(data) {
                let all_opt = "";
                $.each(data,function (key,value) {
                    all_opt += " <option value=" + value.id+ ">" + value.city_name + "</option> ";
                });
                $("#city > optgroup").html(all_opt);
            },
            error: function(reject) {

            },
        });
    });



    $("#listSection").click(function () {
        let type_rent = '{{__("property.type_rent")}}';
        let daily = '{{__("property.daily")}}';
        let monthly = '{{__("property.monthly")}}';
        if($(this).val() === 'rent') {
            if(!$(".type-rent")[0]){
                $(this).after('<label class="type-rent">'+type_rent+':</label>' +
                    '<select name="type_rent" class="type-rent""">' +
                    '<option value="daily">'+daily+'</option>' +
                    '<option value="monthly">'+monthly+'</option>' +
                    '</select>');
            }
        }else{
            $(".type-rent").remove();
        }
    });


</script>
@endsection
