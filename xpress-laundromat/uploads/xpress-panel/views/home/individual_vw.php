    <div class="col-sm-3 padding-bottom-20 padding-top-20 bold fs-16">ENTER THE NO OF CLOTHS</div>
    <div class="col-sm-9 padding-bottom-20 padding-top-20">
        <div class="col-sm-4">
        <input type='button' value='-' class='qtyminus1' data-p="yes" field='quantity' />
        <input type='text' name='quantity' data-id="quantity" value='1' class='qty' />
        <input type='button' value='+'  data-p="yes" class='qtyplus1' field='quantity' />
        <input type="hidden" value="<?=$price?>" id="quantity_price" >
		<br>
            <input type="radio" id="w_wash" name="wash_type" value="wash" onclick="change_amt(0)" checked> Individual Wash
            <input type="radio" id="i_iron" name="wash_type" onclick="change_amt(1)" value="iron"> Individual Iron
            <input type="text" class="hidden" id="ind_wash_price" value="<?=$price?>">
            <input type="text" class="hidden" id="ind_iron_price" value="<?=$price_iron?>">
        </div>
        <span class="col-sm-8 bold">Total Price <i class="fa fa-inr"></i> <span id="total_price"> <?=$price?></span></span>
    </div>