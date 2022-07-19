@section('main')
    <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$res['id']}}"></script>
    <form action="{{route('property.activation',$id)}}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
@endsection
