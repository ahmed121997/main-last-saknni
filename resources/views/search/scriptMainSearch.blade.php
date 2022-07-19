
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<!-- Latest compiled and minified CSS -->

<!-- Latest compiled and minified JavaScript -->

<script>

    let eg = '{{__('property.eg')}}',
        daily = '{{__('property.daily')}}',
        monthly = '{{__('property.monthly')}}',
        ele_sell_rent = $('.sell-rent'),
        ele_min_price = $('.select-min-price'),
        ele_max_price = $('.select-max-price');
    function sell_price(type){
        let price;
        if(type === 'min. price'){
             price = '{{request('min_price')}}';
        }else {
             price = '{{request('max_price')}}';
        }
        let selected = '';
        let out = '<option value="">'+type+'</option>';
        for (let i = 100000;i<=20000000;){
            selected = price == i ? 'selected' : '';
            out += ' <option '+ selected +' value='+i+'>'+numeral(i).format('0,0')+' '+ eg+'</option>';
            if(i >= 1000000)
                i = i + 3000000
            else
                i = i + 100000;
        }
        return out;
    }
    function rent_price_daily(type){
        let price;
        if(type === 'min. price'){
            price = '{{request('min_price')}}';
        }else {
            price = '{{request('max_price')}}';
        }
        let selected = '';
        let out = '<option value="">'+type+'</option>';
        for (let i = 2500;i<=15000;){
            selected = price == i ? 'selected' : '';
            out += ' <option '+ selected +' value='+i+'>'+numeral(i).format('0,0')+' '+ eg+'</option>';
            if(i >= 10000)
                i = i + 2000
            else
                i = i + 1000;
        }
        return out;

    }
    function rent_price_monthly(type){

        let price;
        if(type === 'min. price'){
            price = '{{request('min_price')}}';
        }else {
            price = '{{request('max_price')}}';
        }
        let selected = '';
        let out = '<option value="">'+type+'</option>';
        for (let i = 5000;i<=100000;){
            selected = price == i ? 'selected' : '';
            out += ' <option '+ selected +' value='+i+'>'+numeral(i).format('0,0')+' '+ eg+'</option>';
            if(i >= 10000)
                i = i + 10000
            else
                i = i + 5000;
        }
        return out;

    }

    if(ele_sell_rent.val() === 'sell'){
        ele_min_price.html(sell_price('{{__('property.min_price')}}'));


        ele_max_price.html(sell_price('{{__('property.max_price')}}'));
    }else{
        /*add daily monthly*/
        if(!$('.daily-monthly')[0]){
            let data = '{{request('daily_monthly')}}',
                m_selected = data == 'monthly' ? 'slected': '',
                d_selected = data == 'daily' ? 'selected' : '';
            $('.type-property').after('<div class="col-sm-6 col-md-4 col-lg-2 daily-monthly">' +
                '<select name="daily_monthly" class="form-control form-control-lg select-daily-monthly">' +
                '<option '+m_selected+' value="monthly">' + monthly + '</option>' +
                '<option '+d_selected+' value="daily">' + daily + '</option>' +
                '</select>' +
                '</div>');
        }
        if($('.select-daily-monthly').val() === 'daily'){
            ele_min_price.html(rent_price_daily('{{__('property.min_price')}}'));
            ele_max_price.html(rent_price_daily('{{__('property.max_price')}}'));
        }else{
            ele_min_price.html(rent_price_monthly('{{__('property.min_price')}}'));
            ele_max_price.html(rent_price_monthly('{{__('property.max_price')}}'));
        }
    }

    ele_sell_rent.change(function () {
        if(ele_sell_rent.val() === 'sell'){
            ele_min_price.html(sell_price('{{__('property.min_price')}}'));

            ele_max_price.html(sell_price('{{__('property.max_price')}}'));
            $('.daily-monthly')[0].remove();
        }else{
            /*add daily monthly*/
            if(!$('.daily-monthly')[0]){
                let data = '{{request('daily_monthly')}}',
                    m_selected = data == 'monthly' ? 'slected': '',
                    d_selected = data == 'daily' ? 'selected' : '';
                $('.type-property').after('<div class="col-sm-6 col-md-4 col-lg-2 daily-monthly">' +
                    '<select name="daily_monthly" class="form-control form-control-lg select-daily-monthly">' +
                    '<option '+m_selected+' value="monthly">' + monthly + '</option>' +
                    '<option '+d_selected+' value="daily">' + daily + '</option>' +
                    '</select>' +
                    '</div>');
            }
            if($('.select-daily-monthly').val() === 'daily'){
                ele_min_price.html(rent_price_daily('{{__('property.min_price')}}'));
                ele_max_price.html(rent_price_daily('{{__('property.max_price')}}'));
            }else{
                ele_min_price.html(rent_price_monthly('{{__('property.min_price')}}'));
                ele_max_price.html(rent_price_monthly('{{__('property.max_price')}}'));
            }
        }
        $('.select-daily-monthly').change(function () {
            if($(this).val() == 'daily'){
                ele_min_price.html(rent_price_daily('{{__('property.min_price')}}'));
                ele_max_price.html(rent_price_daily('{{__('property.max_price')}}'));
            }else{
                ele_min_price.html(rent_price_monthly('{{__('property.min_price')}}'));
                ele_max_price.html(rent_price_monthly('{{__('property.max_price')}}'));
            }
        });
    });
    /* change daily or monthly*/

    $('.select-daily-monthly').change(function () {
        if($(this).val() == 'daily'){
            ele_min_price.html(rent_price_daily('{{__('property.min_price')}}'));
            ele_max_price.html(rent_price_daily('{{__('property.max_price')}}'));
        }else{
            ele_min_price.html(rent_price_monthly('{{__('property.min_price')}}'));
            ele_max_price.html(rent_price_monthly('{{__('property.max_price')}}'));
        }
    });


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


</script>
