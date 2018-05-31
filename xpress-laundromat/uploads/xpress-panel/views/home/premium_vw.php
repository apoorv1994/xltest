<div class="col-sm-6 border-right no-l-pad padding-bottom-20 padding-top-20">
    <div class="col-sm-6 margin-bottom-10 bold fs-16">SHIRTS / T SHIRTS / TOPS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_shirt' />
        <input type='text' name='quantity_shirt' value='0' data-id="quantity_shirt" class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_shirt' />
        <input type="hidden" value="<?=$prices['sc_indi_shirt_price']?>" id="quantity_shirt_price" >
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_indi_shirt_price']?>/- PER CLOTH</span>
    </div>
    <div class="col-sm-6 margin-bottom-10 bold fs-16">PANTS / JEANS / LOWERS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_pants' />
        <input type='text' name='quantity_pants' value='0' data-id="quantity_pants" class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_pants' />
        <input type="hidden" value="<?=$prices['sc_indi_pant_price']?>" id="quantity_pants_price">
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_indi_pant_price']?>/- PER CLOTH</span>
    </div>
    <div class="col-sm-6 margin-bottom-10 bold fs-16">SALWAR SUIT/ KURTA PAJAMA</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_undergarments' />
        <input type='text' name='quantity_undergarments' data-id="quantity_undergarments" value='0' class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_undergarments' />
        <input type="hidden" value="<?=$prices['sc_indi_undergarment_price']?>" id="quantity_undergarments_price" >
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_indi_undergarment_price']?>/- PER CLOTH</span>
    </div>
</div>
<div class="col-sm-6 no-r-pad padding-bottom-20 padding-top-20">
    <div class="col-sm-6 margin-bottom-10 bold fs-16">TOWELS / BEDSHEETS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_towel' />
        <input type='text' name='quantity_towel' data-id="quantity_towel" value='0' class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_towel' />
        <input type="hidden" value="<?=$prices['sc_indi_towels_price']?>" id="quantity_towel_price" >
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_indi_towels_price']?>/- PER CLOTH</span>
    </div>
    <div class="col-sm-6 margin-bottom-10 bold fs-16">OTHERS</div>
    <div class="col-sm-6 margin-bottom-10">
        <input type='button' value='-' class='qtyminus' field='quantity_others' />
        <input type='text' name='quantity_others' data-id="quantity_others" value='0' class='qty' />
        <input type='button' value='+' class='qtyplus' field='quantity_others' />
        <input type="hidden" value="<?=$prices['sc_indi_others_price']?>" id="quantity_others_price" >
        <span class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$prices['sc_indi_others_price']?>/- PER CLOTH</span>
    </div>
</div>