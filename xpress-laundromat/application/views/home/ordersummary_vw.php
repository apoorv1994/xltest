<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding ">
<?php $this->load->view('home/wallet_vw');?>
    <div class="col-xs-12 col-sm-12 no-padding margin-top-60">
    <div class="container">
            <div class="col-xs-12 col-lg-offset-3 col-lg-6 well m-t-30 no-padding">
    <h3 class="text-center">Booking Confirmation</h3><br>
    <div class="panel panel-default">
      
        <div class="panel-body">
            <form name="booking_form" id="booking_form" action="<?=current_url()?>" method="post">
                <div class="form-group">
                    <div class="row">
                    <label for="inputEmail" class="control-label col-xs-6">Pickup Date</label>
                    <div class="col-xs-6">
                        <?=date('d-m-Y',$orders->book_date)?> 
						<input type="hidden" name="order_id" id="order_id" value="<?=$orders->id?>">
                    </div>
                </div>
                </div>
                
                <div class="form-group ">
                    <div class="row">
                    <label for="inputEmail" class="control-label col-xs-6">Slot</label>
                    <div class="col-xs-6">
                        <?php 
						
                            switch($orders->book_slot)
                            {
                                case 1:
                                    echo 'Morning';
                                    break;
                                case 2:
                                    echo 'Afternoon';
                                    break;
                                case 3:
                                    echo 'Evening';
                                    break;
                                case 4:
                                    echo 'Night';
                                    break;
                            }
                        ?>
                    </div>
                </div>
                </div>
               
                <div class="form-group ">
                     <div class="row">
                    <div class="row">
                        <label for="inputEmail" class="control-label col-xs-6">Pickup Time</label>
                        <div class="col-xs-6">
                            <?php 
                                $time = $this->londury->get_pickup_time($orders->book_slot,$details->college_id);
                                echo date('H:i A',strtotime($time));
                            ?>        
                        </div>
                    </div>
                </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <label for="inputEmail" class="control-label col-xs-6">Order Type</label>
                        <div class="col-xs-6">
                            <span>
                                <?php 
                                switch($orders->order_type)
                                {
                                    case 1:
                                        echo 'Bulk Washing';
                                        break;
                                    case 2:
                                        echo 'Premium Washing';
                                        break;
                                    case 3:
                                        echo 'Dry Cleaning';
                                        break;
                                    case 4:
										
                                    if($orders->iron=='1')
                                    {
                                             echo 'Individual Iron';
                                    }
                                    else{echo 'Individual Washing';}

                                        break;
                                }
                            ?>
                            </span>        
                        </div>
                    </div>
                </div>
                

                
                     <div class="form-group">
                         <div class="row">
                        <label for="inputEmail" class="control-label col-xs-6">Pickup</label>
                        <div class="col-xs-6">
                           <?=$orders->order_type===1?'Self Pickup':'Avail Pickup'?>
                            <input type="hidden" id="totalAmount" name="total" value="<?=$orders->total_amount?>" />
							<input type="hidden" id="iron" name="iron" value="<?=$orders->iron?>" />
							
                        </div>
                         </div>
                    </div>
                
                
                    <table class="table">
                        <thead>
                        <th class="text-center">Items</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price per cloth</th>
                        <th class="text-center">Total</th>
                        </thead>
                        <tbody>
                            <?php 
                            $total=0;
                            
                            foreach($orders->items as $item){
                                $subtotal = 0;
                                $check=TRUE;
                                if($orders->order_type!=1){
                                    $check = $item->quantity>0;
                                }
                                if($check){
                            ?>
                            <tr>
                                <td class="text-center"><?=$item->items?></td>
                                <td class="text-center"><?=$item->quantity?></td>
                                <td class="text-center"><i class="fa fa-inr"></i> <?php 
                                if($orders->order_type==1)
                                {
                                    echo $item->cost;
                                    $subtotal=$total = $item->cost;
                                }else{
                                    echo $item->cost;
                                    $subtotal = $item->quantity*$item->cost;
                                    $total +=$subtotal;
                                }
								
                                ?></td>
                                <td class="text-center"><i class="fa fa-inr"></i> <?=$subtotal?></td>
                            </tr>
							
							<input type="hidden" id="perclothcost" name="cost" value="<?=$item->cost?>" />
                            <?php }}?>
							<tr>
                                <td class="text-center">GST</td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
								
                                <td class="text-center"><i class="fa fa-inr"></i> 
								<?php
								$GST=0;
								$totalSGST=number_format($total*$sc_SGST/100,2);
				
								$totalCGST=number_format($total*$sc_CGST/100,2);
								
								$totalIGST=number_format($total*$sc_IGST/100,2);
								echo $GST=$totalSGST+$totalCGST+$totalIGST;
								?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Total Amount</td>
                                <td class="text-center"><i class="fa fa-inr"></i> <?=$total+$GST?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="col-sm-12" id="couponCntnr">
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="coupon" name="coupon" placeholder="Coupon Code" />
                                            <div class="err" id="coupon_err"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-info " id="couponBtn" type="button">Apply</button>
                                        </div>

                                    </div>
                                   
                                    <div class="col-sm-12" style="color: green;" id="coupon_text">
                                        
                                    </div>
                                </td>
                                
                                <td class="text-center" style="color: green" id="discount_amount"></td>
                            </tr>
                            
                           
                            <tr>
                                <td colspan="3" class="text-center"><b>Amount to pay</b></td>
                                <td class="text-center"><i class="fa fa-inr"></i> <span  id="final_amount"><?=$total+$GST?></span></td>
                            </tr>
                            <tr>
                                <td>
                                    Select Payment Method
                                </td>
                                <td  colspan="3" class="text-center">
                                    <div class="col-sm-6">
                                        <input type="radio" value="wallet" checked="" name="payment_method" /> Wallet
                                    </div>
                                    <div class="col-sm-6">
                                        <?php if($cod=='On'){?>
                                        <input type="radio" value="cod" name="payment_method" /> COD
                                        <?php }?>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                
                  <?php if($error!=''){?>
                  <div class="row">
                    <div class="col-xs-12 alert alert-danger p-l-10 p-r-10">
                        <?=$error?>
                    </div>
                </div>
                  <?php }?>
                <div class="row">
                    <div class="col-xs-12">
                        <a href="<?=BASE?>home" class="btn btn-danger pull-right m-l-10">Cancel</a> 
                        <input type="button" id="orderBtn" class="btn btn-primary pull-right" value="Confirm">
                        <div id="loader"></div>
                    </div>
                </div>

                    
<div class="row">
            <div class="col-xs-12 col-sm-12" style="display:block;">

                    <h4 class="title"><i class="fa fa-warning"></i> Disclaimer</h4>
                    In case you chose to deliver the clothes yourself and miss your slot, we are still incurring operational costs and thus deduct half the booking amount to off-set our losses. In order to optimize your experience with us and avoid the above situation, we strongly recommend our Pick-Up service. 


             </div>
</div>
                </div>
            </form>

        </div>
    </div>
 </div>
    </div>
</div>
</div>
<script>
var GST='<?php echo $GST;?>';
    $(document).ready(function(){
        $('#couponBtn').click(function(){
            var url = '<?=BASE?>home/check-coupon';
            var total_a= $('#totalAmount').val();
            var data = {coupon:$('#coupon').val()}
            $.post(url,data,function(success){
                var res = JSON.parse(success);
                if(res.status)
                {   //console.log(parseInt(total_a));
                    var discount = ($('#totalAmount').val()*res.discount_percent)/100;
                    var final_amount = 0;
                    if(parseInt(total_a) > discount)
                    {
                        final_amount = $('#totalAmount').val()-discount+parseInt(GST);
                        $('#totalAmount').val(final_amount);
                    }else{
                        discount = parseInt(total_a);
                    }
					var tAmount=parseInt(final_amount)+parseInt(GST);
                    $('#couponCntnr').hide();
                    $('#coupon_text').html('Coupon code <b>'+$('#coupon').val()+'</b> applied. <a id="remove_coupon" href="javascript:void(0)">Remove Coupon</a>').show();
                    $('#final_amount').html(final_amount);
                    $('#discount_amount').html('-'+discount);
                }else{
                    $('#coupon_err').html(res.error);
                }
            });
        });
        $('body').on('click','#remove_coupon',function(){
            $('#coupon_text').html('').hide();
            $('#final_amount').html(<?=$total+$GST?>);
            $('#couponCntnr').show();
            $('#coupon').val('');
            $('#discount_amount').html('');
        })

        $('#Iron').change(function(){
            if($(this).val()==1)
            {
                $('#totalAmount').val(<?=$orders->total_amount + 4*$orders->items[0]->quantity ?>);
                 $('#final_amount').html(<?=$orders->total_amount + 4*$orders->items[0]->quantity?>);
            }else{
                $('#totalAmount').val(<?=$orders->total_amount ?>);
                 $('#final_amount').html(<?=$orders->total_amount ?>)
            }
        })
        
        $('#orderBtn').click(function(){
            $('#loader').html('<i class="fa fa-spin fa-spinner"></i>');
            var url = '<?=BASE?>home/place-order';
            var data = $('#booking_form').serialize();
			 //console.log(data);
			//alert(data);
           
            $.post(url,data,function(success){
				//console.log(success);
				//alert(success);
               var res = JSON.parse(success);
                if(res.status)
                {
                    $('#loader').html(res.msg);
                    setTimeout(function(){window.location.href = '<?=BASE?>home';},1500)
                }else{
                    $('#loader').html(res.error);
                }
            })
        })
    })
</script>