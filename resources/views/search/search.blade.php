@extends('layouts.app')
@section('links')
    <link rel="stylesheet" href="{{asset('public/css/search.css')}}"/>
@endsection
@section('content')
    <div class="container-fluid search">
        <div class="row h-100">
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 control background-saknni h-100 pt-5 pb-5">
                <h3>{{__('property.search_control')}}</h3>
                <hr/>
                <form id="search-form">
                    @csrf
                    <label>{{__('property.gov')}}:</label>
                    <select id="gov" class="custom-select input-search" name="gov">
                        <option value="" selected>Open this select menu</option>
                        @if(isset($govs) && count($govs) > 0)
                            @foreach($govs as $gov)
                                <option value="{{$gov->id}}">{{$gov->governorate_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr/>
                    <label class="city-label none">{{__('property.city')}}:</label>
                    <select id="city" class="custom-select input-search none" name="city">
                        <option value="" selected>Open this select menu</option>
                        <optgroup label="cities">

                        </optgroup>
                    </select>
                    <hr class="none"/>
                    <label>{{__('property.type_property')}}:</label>
                    <select id="type_property" class="custom-select input-search" name="type_property">
                        <option value="" selected>Open this select menu</option>
                        @if(isset($type_properties) && count($type_properties) > 0)
                            @foreach($type_properties as $type_property)
                                <option value="{{$type_property->id}}">{{$type_property->type}}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr/>

                    <label>{{__('property.finish')}}:</label>
                    <select class="custom-select input-search" name="type_finish">
                        <option value="" selected>Open this select menu</option>
                        @if(isset($type_finishes) && count($type_finishes) > 0)
                            @foreach($type_finishes as $type_finish)
                                <option value="{{$type_finish->id}}">{{$type_finish->type}}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr/>
                    <label>{{__('property.type_pay')}}:</label>
                    <select class="custom-select input-search" name="type_payment">
                        <option value="" selected>Open this select menu</option>
                        @if(isset($type_payments) && count($type_payments) > 0)
                            @foreach($type_payments as $type_payment)
                                <option value="{{$type_payment->id}}">{{$type_payment->type}}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr/>
                    <div class="text-center"><button id="search" class="btn btn-secondary mb-2">{{__('property.search')}}</button></div>
                </form>
            </div>
            <div class="col-sm-6 col-md-8 col-lg-9 col-xl-10 results">
                <h3 class="h3 mb-0 text-gray-800">{{__('property.results')}}</h3>
                <hr/>
                <div class="row">
                    <div class="lds-ripple"><div></div><div></div></div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
        $("#search").click(function(e){
            e.preventDefault();
            let data = new FormData($('#search-form')[0]);
            $.ajax({
                type: 'post',
                url: '{{route("process.search")}}',
                data: data,
                processData:false,
                contentType:false,
                beforeSend: function() {
                    $(".lds-ripple").show();
                },
                success: function(data) {
                    if(data.length > 0){
                        let wrapper,wrapper_card,img,card_body,all ="";
                        let url ="{{url('public/images/')}}";
                        let type = '{{__("property.type_property")}}';
                        let rooms = '{{__("property.number_of_rooms")}}';
                        let price = '{{__("property.price")}}';
                        let area = '{{__("property.area")}}';
                        let current_url = "{{url('property/show/')}}";
                        $.each(data,function (key,value) {
                            wrapper = "<div class=' col-lg-6 mb-3 col-xl-4'>";
                            wrapper_card = "<div class='card' style='max-width: 30rem;max-height: 30em'>";
                            img = "<img style='height: 12em' src="+ url +"/"+value.images.source[0]+" class='card-img-top img-thumbnail' alt='img'>";
                            card_body = "<div class='card-body'><h4 class='card-title'>"+value.des.title+
                                "</h4><div class='row'><p class='card-text col-6'><span>"+type +": </span>"+ value.type_property.type +
                                "</p><p class='card-text col-6'><span>"+rooms+" : </span>"+ value.num_rooms +
                                "</p><p class='card-text col-6'><span>"+price+" : </span>"+ value.price +
                                "</p><p class='card-text col-6'><span>"+area+" : </span>"+ value.area +
                                "</p> </div><a target='_blank' href='"+current_url+"/"+value.id+"' class='btn btn-primary'>Show details</a></div></div></div>";
                            all += wrapper + wrapper_card + img + card_body;
                        });
                        $('.results .row').html(all);
                        $(".lds-ripple").hide();
                    }else{
                        $('.results .row').html('<h3 class="m-auto mt-lg-5 text-gray-600 alert alert-danger">There no data</h3>');
                        $(".lds-ripple").hide();
                    }

                    },
                error: function(reject) {

                },
            });
        });
    </script>
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
                    $('.none').show();
                    $("#city > optgroup").html(all_opt);
                },
                error: function(reject) {

                },
            });
        });

    </script>

@endsection
