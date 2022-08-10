<!-- Start Footer  -->
<footer class="Footer background-saknni">
    <div class="container themed-container" >
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <h2> <span class="s">S</span><span class="ak">Ak</span><span class="nni">nNi</span></h2>
                <p class="text-justify">{{__('footer.saknni_message')}}</p>
            </div>
            <div class="col-md-6 col-lg-4">
                <h5>{{__('footer.our_services')}}</h5>
                <p><a href="{{ route('add.property') }}">{{ __('navbar.add_property') }}</a></p>

            </div>

            <div  class="col-md-6 col-lg-4">
                <h5>{{__('footer.follow_us')}}</h5>
                <div class="icons-social">
                    <i class="fab fa-facebook fa-lg"></i>
                    <i class="fab fa-twitter fa-lg"></i>
                    <i class="fab fa-youtube fa-lg"></i>
                    <i class="fab fa-instagram fa-lg"></i>
                </div>
                <h5>{{__('footer.download_app')}}</h5>
                <div class="icons-app">
                    <i class="fab fa-android fa-lg"></i>
                    <i class="fab fa-apple fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer  -->
