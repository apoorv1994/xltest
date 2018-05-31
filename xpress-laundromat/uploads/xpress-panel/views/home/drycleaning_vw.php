<div class="col-sm-6 border-right no-l-pad padding-bottom-20 padding-top-20">
    <div class="col-sm-6 margin-bottom-10 bold fs-16">SHIRTS / T SHIRTS / TOPS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_shirt' />
        <input type='text' name='quantity_shirt' data-id="quantity_shirt" readonly="" value='0' class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_shirt' />
        <input type="hidden" value="<?=$prices['sc_dry_shirt_price']?>" id="quantity_shirt_price">
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_dry_shirt_price']?>/- PER CLOTH</span>
    </div>
    <div class="col-sm-6 margin-bottom-10 bold fs-16">PANTS / JEANS / LOWERS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_pants' />
        <input type='text' name='quantity_pants' data-id="quantity_pants" readonly="" value='0' class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_pants' />
        <input type="hidden" value="<?=$prices['sc_dry_pant_price']?>" id="quantity_pants_price">
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_dry_pant_price']?>/- PER CLOTH</span>
    </div>
    <div class="col-sm-6 margin-bottom-10 bold fs-16">SUITS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_suit' />
        <input type='text' name='quantity_suit' data-id="quantity_suit" readonly="" value='0' class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_suit' />
        <input type="hidden" value="<?=$prices['sc_dry_suit_price']?>" id="quantity_suit_price">
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_dry_suit_price']?>/- PER CLOTH</span>
    </div>
</div>
<div class="col-sm-6 no-r-pad padding-bottom-20 padding-top-20">
    <div class="col-sm-6 margin-bottom-10 bold fs-16">BLANKETS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_blanket' />
        <input type='text' name='quantity_blanket' data-id="quantity_blanket" readonly="" value='0' class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_blanket' />
        <input type="hidden" value="<?=$prices['sc_dry_blanket_price']?>" id="quantity_blanket_price">
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_dry_blanket_price']?>/- PER CLOTH</span>
    </div>
    <div class="col-sm-6 margin-bottom-10 bold fs-16">OTHERS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_others' />
        <input type='text' name='quantity_others' data-id="quantity_others" readonly="" value='0' class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_others' />
        <input type="hidden" value="<?=$prices['sc_dry_others_price']?>" id="quantity_others_price">
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_dry_others_price']?>/- PER CLOTH</span>
    </div>
</div>