
/// hide messages after 7 seconds
if($('.message')[0]){
    setTimeout(function () {
        $('.message').fadeOut();
    },7000);
}
if($('.status-payment')[0]){
    setTimeout(function () {
        $('.status-payment').fadeOut();
    },7000);
}

$('.nav-item').click(function () {
    $(this).addClass('active').siblings('li').removeClass('active');
});
$('.property-delete').click(function () {
   return confirm('Are you sure ?');
});



// favorite button/*
$('.icon-love').click(function(e){
    e.preventDefault();
    if($(this).hasClass('far')){
        $(this).removeClass('far').addClass('fas').style({color:'#b60d0d'});
    }

    if($(this).hasClass('fas')){
        $(this).removeClass('fas').addClass('far');
    }
});
