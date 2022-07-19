<form method="get" action="{{route('main.search')}}">
    <div class="container mt-lg-4">
        <div class="row mt-3">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <select name="sell_rent" class="form-control form-control-lg sell-rent">
                    <option @if(request('sell_rent') == 'sell') selected @endif value="sell">{{__('property.sell')}}</option>
                    <option @if(request('sell_rent') == 'rent') selected @endif value="rent">{{__('property.rent')}}</option>
                </select>
            </div>
            <div class="col-sm-6 d-none d-sm-block  d-md-none ">
                <input type="submit" class="btn btn-warning d-block w-100  form-control-lg" value="{{__('property.search')}}"/>
            </div>

            <div class="col-md-4">
                <select name="gov" id="gov" class="form-control  form-control-lg">
                    <option value="" selected disabled>{{__('property.choose_governorate')}}</option>
                    @if(isset($govs) && count($govs) > 0)
                        @foreach($govs as $gov)
                            <option value="{{$gov->id}}">{{$gov->governorate_name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-4">
                <select name="city" id="city" class="form-control  form-control-lg">
                    <option  value="" selected disabled>{{__('property.choose_city')}}</option>
                    <optgroup label="all cities in this gov">

                    </optgroup>
                </select>
            </div>

            <div class="col-lg-1 d-none d-lg-block">
                <input type="submit" class="btn btn-warning d-block  form-control-lg" value="{{__('property.search')}}"/>
            </div>


            <div class="col-sm-6 col-md-4 col-lg-3 type-property">
                <select name="type_property" class="form-control  form-control-lg ">
                    <option value="">{{__('property.type_property')}}</option>
                    @if(isset($type_properties) && count($type_properties) > 0)
                        @foreach($type_properties as $type_property)
                            <option @if(request('type_property') == $type_property->id) selected @endif value="{{$type_property->id}}">{{$type_property->type}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <select name="min_price" class="form-control  form-control-lg select-min-price">


                </select>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <select name="max_price" class="form-control  form-control-lg select-max-price">
                </select>
            </div>
            <div  class="col-sm-6 col-md-4 col-lg-2">
                <select name="min_area" class="form-control  form-control-lg">
                    <option value="">{{__('property.min_area')}}</option>
                    @for($i = 50 ; $i <=1000; $i = $i +50)
                    <option  @if(request('min_area') == $i) selected @endif value="{{$i}}">{{$i}} {{__('property.m')}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <select name="max_area" class="form-control  form-control-lg">
                    <option value="">{{__('property.max_area')}}</option>
                    @for($i = 50 ; $i <=1000; $i = $i +50)
                        <option @if(request('max_area') == $i) selected @endif value="{{$i}}">{{$i}} {{__('property.m')}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <select name="type_pay" class="form-control  form-control-lg">
                    <option value="">{{__('property.type_pay')}}</option>
                    @if(isset($type_payments) && count($type_payments) > 0)
                        @foreach($type_payments as $type_payment)
                            <option @if(request('type_pay') == $type_payment->id) selected @endif value="{{$type_payment->id}}">{{$type_payment->type}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-lg-2 d-lg-none d-sm-none d-md-block">
                <input type="submit" class="btn btn-warning d-block w-100  form-control-lg" value="{{__('property.search')}}"/>
            </div>
        </div>
    </div>
</form>
