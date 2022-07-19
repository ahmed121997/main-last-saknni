$('.replay').click(function(e){
   e.preventDefault();
    $(this).next().toggle();
});
$('.show-replay').click(function(e){
    e.preventDefault();
    $(this).siblings('.display-comment').toggle();
});
$('.show-number').click(function () {
    $(this).hide();
    $('.number-phone').fadeIn();
});
$('.show-email').click(function () {
    $(this).hide();
    $('.email').fadeIn();
});

