jQuery(document).ready(function(){
    // This button will increment the value
    $('body').on('click','.qtyplus',function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
            fieldName = $(this).attr('field');
        if($('input[name='+fieldName+']').val()<15)
        {
            // Get its current value
            var currentVal = parseInt($('input[name='+fieldName+']').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                $('input[name='+fieldName+']').val(currentVal + 1);
            } else {
                // Otherwise put a 0 there
                $('input[name='+fieldName+']').val(0);
            }
            total_price('nbulk');
            $(this).siblings('span').children('span.count').text($('input[name='+fieldName+']').val());
        }else{
            $('input[name='+fieldName+']').val(15);
            total_price('nbulk');
        }
    });
    // This button will decrement the value till 0
    $('body').on('click',".qtyminus",function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        var price = $('#total_price').val();
        var newprice=0;
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
        total_price('nbulk');
        $(this).siblings('span').children('span.count').html($('input[name='+fieldName+']').val());
    });
    
    $('body').on('click','.qtyplus1',function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
            fieldName = $(this).attr('field');
            var r_type=$("input[name='wash_type']:checked").val();
			if(r_type=='iron')
		   {
				var price = $('#ind_iron_price').val();
		   }
		   else if(r_type=='wash')
		   {
				var price = $('#ind_wash_price').val();
		   }
            // Get its current value
            var currentVal = parseInt($('input[name='+fieldName+']').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                $('input[name='+fieldName+']').val(currentVal + 1);
            } else {
                // Otherwise put a 0 there
                $('input[name='+fieldName+']').val(0);
            }
            if($(this).data('p')=='yes')
            {
                new_total_price('nbulk',r_type,price);
            }else{
                new_total_price('bulk',r_type,price);
            }
            $(this).siblings('span').children('span.count').text($('input[name='+fieldName+']').val());
    });
    // This button will decrement the value till 0
    $('body').on('click',".qtyminus1",function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
		var r_type=$("input[name='wash_type']:checked").val();
		if(r_type=='iron')
	   {
			var price = $('#ind_iron_price').val();
	   }
	   else if(r_type=='wash')
	   {
			var price = $('#ind_wash_price').val();
	   }
		   
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
        if($(this).data('p')=='yes')
        {
           new_total_price('nbulk',r_type,price);
        }else{
           new_total_price('bulk',r_type,price);
        }
        $(this).siblings('span').children('span.count').html($('input[name='+fieldName+']').val());
    });
});

function total_price(type)
{
    var total = 0;
    var total_qty = 0;
    $('.qty').each(function(){
       var qty = $(this).val();
       total_qty +=parseInt(qty);
       var id = $(this).data('id');
       var price = $('#'+id+'_price').val();
       var sum = parseInt(qty)*parseInt(price);
       total = parseInt(total) + parseInt(sum);
    });
    if(type!='bulk')
    {
        $('#total_price').text(total);
        $('#total_price').val(total);
    }
    if(type!='bulk' && total_qty>15)
    {
        alert('Please choose Bulk Washing');
    }
}

function new_total_price(type,rtype,rprice)
{
	//alert(rtype+"=="+rprice);
    var total = 0;
    var total_qty = 0;
    $('.qty').each(function(){
       var qty = $(this).val();
       total_qty +=parseInt(qty);
       var id = $(this).data('id');
       var sum = parseInt(qty)*parseInt(rprice);
       total = parseInt(total) + parseInt(sum);
    });
    if(type!='bulk')
    {
        $('#total_price').text(total);
        $('#total_price').val(total);
    }
    if(type!='bulk' && total_qty>15)
    {
        alert('Please choose Bulk Washing');
    }
}

