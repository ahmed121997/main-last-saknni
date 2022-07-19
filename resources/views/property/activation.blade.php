@extends('layouts.app')
@section('links')

    <link href="{{ asset('public/css/activation.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container justify-content-center activation">
    <div class="icons-payment">
        <img src="{{asset('public/images/activation/visa.png')}}" alt="Visa" />
        <img src="{{asset('public/images/activation/mastercard.png')}}" alt="Mastercard" />
        <img src="{{asset('public/images/activation/american-express.png')}}" alt="American-express" />
    </div>
    <button class="btn btn-primary d-block ">
        <a href="#" class="d-flex justify-content-center" id="activation-btn" style="color:#FFF;text-decoration: none;">
            <div>Activation now</div>
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </a>

    </button>
    <p>activation for one ads. you have to pay 10$</p>
    <div id="showForm">

    </div>
    <div class="status-payment">
        @if(isset($success_payment))
            <div class="alert alert-success">{{$success_payment}}</div>
        @endif
        @if(isset($fail_payment))
            <div class="alert alert-danger">{{$fail_payment}}</div>
        @endif
    </div>


</div>
@endsection

@section('script')
    <script>
        $("#activation-btn").click(function(e){
            e.preventDefault();
            $.ajax({
                type: 'get',
                url: '{{route("get.check.id")}}',
                data: {
                    'id' : {{$id}},
                },
                beforeSend:function(){
                    $('.lds-ring').show();
                },
                success: function(data) {
                   if(data.status == true){
                       $('#showForm').empty().html(data.content);
                       $('.lds-ring').fadeOut(5000);
                   }else{
                       $('#showForm').empty().html('<h3>Something wrong!!!</h3>');
                   }

                },
                error: function(reject) {

                },
            });
        });
    </script>
@endsection
