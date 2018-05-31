<div class="col-sm-12 no-padding bg-voilet">

    <div class="container bg-white wallet-panel">
        <div class="row">
		
            <?php /*<form action="<?=BASE?>payments" method="post">*/?>
		
                <div class="col-xs-12 col-sm-12 padding-top-20 padding-bottom-20">
                    <div class="col-xs-12 col-sm-3 border-right" id="walletcnt">
                        <div class="col-xs-4 col-sm-4">
                            <img class="img-responsive" src="<?=BASE?>assets/img/bus.png" />
                        </div>
                        <div class="col-xs-8 col-sm-8 no-padding linehieght-30">
                            <div class="col-sm-12 fs-16">Rs. <span class="wallet-price"><?=$details->wallet_balance?></span></div>
                            <small class="col-sm-12">Your Wallet Ballance</small>
                        </div>
                    </div>
					 
					 <div id="paymenType_1" class="col-xs-12 col-md-9">
						<form action="<?=BASE?>payments" method="post" id="payments">
						<div class="col-xs-12 col-sm-3 padding-top-10">
									<input type="number" class="form-control" placeholder="Enter Amount" name="amount" id="amount1"  required="" />
								</div>
								<div class="col-xs-12 col-sm-6 " style="font-size: 16px;padding-top: 10px;">
									<span>Pay using : </span>
									 <input type="radio" name="paytm_type" onchange="change_payment_type(1)" checked><img src="<?=BASE?>assets/img/payu-logo.png" style="height: 35px;width: 80px;margin-top: -15px;margin-left: 10px;">
									 <input type="radio" name="paytm_type" onchange="change_payment_type(2)" style="margin-left: 10px;"> <img src="<?=BASE?>assets/img/paytm.jpeg" style="height: 35px;width: 80px;margin-top: -15px;margin-left: 10px;"> 
								 </div>
								<div class="col-xs-12 col-sm-3 no-l-pad padding-top-10" id="walletbtn">
									<button class="btn btn-info btn-wallet" type="button" onclick="chack_amount(1,'payments')">ADD MONEY TO WALLET</button>
								</div>

						 </form>
					 </div>
					 <div id="paymenType_2" style="display:none;" class="col-xs-12 col-md-9">
						<form action="<?=BASE?>payments/make_payment" method="post" id="make_payment">
						
							<div class="col-xs-12 col-sm-3 padding-top-10">
							
								
								<input type="number" class="form-control" placeholder="Enter Amount" name="amount" id="amount2" required="" />
								<input type="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo  rand(10000,99999999)."-".$this->session->user_id;?>">
								<input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?php echo  $this->session->user_id;?>">
								<input type="hidden" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail109">
								<input type="hidden" id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
							</div>
							<div class="col-xs-12 col-sm-6 " style="font-size: 16px;padding-top: 10px;">
									<span>Pay using : </span>
									 <input type="radio" name="paytm_type" onchange="change_payment_type(1)" ><img src="<?=BASE?>assets/img/payu-logo.png" style="height: 35px;width: 80px;margin-top: -15px;margin-left: 10px;"> 
									 <input type="radio" name="paytm_type" onchange="change_payment_type(2)" style="margin-left: 10px;" checked> <img src="<?=BASE?>assets/img/paytm.jpeg" style="height: 35px;width: 80px;margin-top: -15px;margin-left: 10px;"> 
								 </div>
							<div class="col-xs-12 col-sm-3 no-l-pad padding-top-10" id="walletbtn">

							
								<button class="btn btn-info btn-wallet" type="button" onclick="chack_amount(2,'make_payment')">ADD MONEY TO WALLET</button>
													</div>
						 </form>
					 </div>
                </div>
           
        </div>
    </div>
</div>

<script>
function change_payment_type(id)
{
	if(id=='2')
	{
		$("#paymenType_1").hide();
		$("#paymenType_2").show();
		$("#make_payment")[0].reset();
		$("#payments")[0].reset();
	}
	else
	{
		$("#paymenType_2").hide();
		$("#paymenType_1").show();
		$("#make_payment")[0].reset();
		$("#payments")[0].reset();
	}
}

function chack_amount(aid,fid)
{
	var amount=$("#amount"+aid).val();
	if(amount<100)
	{
		alert("Recharge amount should be greater than 100");
		return false;
	}
	else
	{
		 $( "#"+fid ).submit();
	}
}
</script>