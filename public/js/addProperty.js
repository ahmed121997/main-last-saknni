
//jQuery time
let current_fs, next_fs, previous_fs;
let status = 0; //fieldsets
let status_submit = 0;
let errors = {};
function convertNumbers2English(string) {
    return string.replace(/[\u0660-\u0669]/g, function (c) {
        return c.charCodeAt(0) - 0x0660;
    }).replace(/[\u06f0-\u06f9]/g, function (c) {
        return c.charCodeAt(0) - 0x06f0;
    });
}
$(".next").click(function(){
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    let pre_inputs = $(this).siblings("input,select,textarea");

    for (let i=0;i<pre_inputs.length;i++) {

        if (pre_inputs[i].value == ''){
            status = 0;break;
        }
        else{
            // validate to Area input
            if(pre_inputs[i].getAttribute('name') == 'area'){
                let input = pre_inputs[i],
                    value = convertNumbers2English(input.value);
                if(value.match(/\d+/g) && value <= 5000 && value >=40){
                    status = 1;
                    input.value = value;
                }else {status =0;
                        $('.not-valid-area').show().text('area must be number and between 40 to 5000 m**2');
                        ;break;
                }
            }
            // validate to floor input
            if(pre_inputs[i].getAttribute('name') == 'floor'){
                let input = pre_inputs[i],
                    value = convertNumbers2English(input.value)
                if(value.match(/\d+/g) && value <= 100 && value >=0){
                    status = 1;
                    input.value = value;
                }else {status =0;
                    $('.not-valid-floor').show().text('floor must be number and between 0 to 100 floor');
                    ;break;
                }
            }
            // validate to rooms input
            if(pre_inputs[i].getAttribute('name') == 'rooms'){
                let input = pre_inputs[i],
                    value = convertNumbers2English(input.value);
                if(value.match(/\d+/g) && value <= 100 && value >=1){
                    status = 1;
                    input.value = value;
                }else {status =0;
                    $('.not-valid-rooms').show().text('rooms must be number and between 1 to 100 room');
                    ;break;
                }
            }
            // validate to bathrooms input
            if(pre_inputs[i].getAttribute('name') == 'bathroom'){
                let input = pre_inputs[i],
                    value = convertNumbers2English(input.value);
                if(value.match(/\d+/g) && value <= 50 && value >=1){
                    status = 1;
                    input.value = value;
                }else {status =0;
                    $('.not-valid-bathrooms').show().text('bathrooms must be number and between 1 to 50 bathroom');
                    ;break;
                }
            }

            status = 1;
            $('.not-valid').hide();
        }
    }





    if(status === 1){
        next_fs.show();
        current_fs.hide();
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        $('.error').css({display:'none',marginRight:'20px',marginLeft:'20px',marginTop:'1px',marginButton:'3px'});
        status = 0;
    }else {
        $('.error').css({display: 'block'}).text('fill this fields please');
        status = 0;
    }
});

$(".previous").click(function(){
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //de-activate current step on progressbar
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();
    current_fs.hide();
    //hide the current fieldset with style
});

$(".submit").click(function(){
    let pre_inputs = $(this).siblings("input,select,textarea");
    for (let i=0;i<pre_inputs.length;i++) {
        if (pre_inputs[i].value == ''){
            status_submit = 0;
            $('.error').css({display: 'block'}).text('fill this fields please');
            break;
        }
        else
            status_submit = 1;
    }
    if(status_submit === 0) return false;
    else return true;
});

