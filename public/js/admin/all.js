
/// hide messages after 7 seconds
if($('.message')[0]){
    setTimeout(function () {
        $('.message').fadeOut();
    },7000);
}