    <!-- <div class="col-sm-3 padding-bottom-20 padding-top-20 bold fs-16">ENTER THE NO OF CLOTHES</div> -->
    <div class="col-sm-12 padding-bottom-20 padding-top-20">
       
        <div class="col-sm-4 bold fs-16">
	       <!--  <input type='button' value='-' class='qtyminus1' data-p="no"  field='quantity' /> -->
	        <input type='text' class="hidden" name='quantity' value='1' class='qty' />
	        <!-- <input type='button' value='+' data-p="no" class='qtyplus1' field='quantity' /> -->
	        <input type="radio" id="w_iron" name="wash_type" value="iron" checked> Wash &amp; Iron &nbsp;&nbsp;&nbsp;
	        <input type="radio" id="w_fold" name="wash_type" value="fold"> Wash &amp; Fold
        </div>
        <span class="col-sm-12 col-lg-12 col-md-12 bold text-right" style="font-size:20px;">Total Price <i class="fa fa-inr"></i> <span id="total_price"> <?=$price_iron?> per <?=$weight?> KG</span></span>
    </div>