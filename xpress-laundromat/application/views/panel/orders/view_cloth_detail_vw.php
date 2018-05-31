<?php 
//echo "<pre>";
$rows=$rows[0];
$slot_weight=$rows->settings['slot_weight'];
$extra_charge=$rows->settings['extra_charge'];
$iron_price = $rows->settings['iron_price'];
//print_r($rows);
?>
<div class="row modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Add Cloth Details [<?=$rows->wash_type?>]</h4>
            </div>
            <form method="post" id="clothFrm">
			  <input type="hidden"  id="order_id" name="order_id" value="<?=$order_id?>">
			<input type="hidden"  id="orderType" name="orderType" value="<?=$rows->order_type?>">
                <div class="modal-body">
                    <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Token No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="token_no" name="token_no" required="" value="<?=$rows->token_no?>" autocomplete="off">
                                <div id="token_no_err"></div>
                            </div>
                    </div>
                     
                     <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Weight</label>
                            <div class="col-sm-9">
								<?php if($rows->order_type==1){?>
                                <input type="number" class="form-control" id="weight" name="weight" required="" value="<?=$rows->weight!=''?$rows->weight:0?>" autocomplete="off" onchange="manage_cloth_price(4,1,'weight','',this.value,'');">
								<input type="hidden" id="slot_weight" value="<?=$slot_weight?>"/>
								<input type="hidden" id="extra_charge" value="<?=$extra_charge?>"/>
								<input type="hidden" id="new_price" value="<?=$rows->extra_amount!=''?$rows->extra_amount:0?>"/>
								<input type="hidden" id="new_extra_amount" value="<?=$rows->extra_amount!=''?$rows->extra_amount:0?>"/>
								<?php } else { ?>
								 <input type="number" class="form-control" id="weight" name="weight" required="" value="<?=$rows->weight?>" autocomplete="off">
								<?php } ?>
                                <div id="weight_err"></div>
                            </div>
                    </div>
                   <?php if($rows->order_type!=4){?>
                    <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">No of Items</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_of_items" required=""  name="no_of_items" value="<?=$rows->no_of_items?>" autocomplete="off">
                                  
                                    <div id="no_of_items_err"></div>
                            </div>
                    </div>
				   <?php } ?>
                    
                   
                    <!-- New details section -->
                              
                    <label style="margin: 6px;" class="control-label">Clothes Details: (quantity / price)</p>

                    <?php
					$item_data=[];
					foreach($rows->items as $item)
					{
						$item_data[strtolower($item['item'])] = ['quantity'=>$item['quantity'],'rate'=>$item['rate'],'cost'=>$item['cost'],'singlePrice'=>$item['singlePrice']];
					}
					//print_r($item_data);
					if($rows->order_type==2){
						
				    ?>
                    <div class="col-sm-12" style="border: 1px solid #e3e3e3; padding: 0px; ">
                        <div class="col-sm-6" style="padding: 0px; border-right: 1px solid #e3e3e3">
						
                            <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">SHIRTS / T SHIRTS</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_shirt_t_shirt' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_shirt_t_shirt' value='<?=$item_data['shirts']['quantity']?>' data-id="sc_indi_shirt_t_shirt" onclick="manage_cloth_price(6,<?=$item_data['shirts']['quantity']?>,'',<?=$rows->settings['sc_indi_shirt_t_shirt']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_shirt_t_shirt1' value='<?=$item_data['shirts']['quantity']?>'/>
							<input type='button' style="display:none;" value='+' class='qtyplus' field='sc_indi_shirt_t_shirt' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_shirt_t_shirt']?>" id="sc_indi_shirt_t_shirt_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_shirt_t_shirt']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">PANTS / TROUSERS</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_pant_trouser' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_pant_trouser' value='<?=$item_data['pants']['quantity']?>' data-id="sc_indi_pant_trouser" class='qty' onchange="manage_cloth_price(6,<?=$item_data['pants']['quantity']?>,'',<?=$rows->settings['sc_indi_pant_trouser']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_pant_trouser1' value='<?=$item_data['pants']['quantity']?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_indi_pant_trouser' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_pant_trouser']?>" id="sc_indi_pant_trouser_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_pant_trouser']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">KURTA</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_kurta' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_kurta' data-id="sc_indi_kurta" value='<?=$item_data['kurta']['quantity']?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['kurta']['quantity']?>,'',<?=$rows->settings['sc_indi_kurta']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_kurta1' data-id="sc_indi_kurta" value='<?=$item_data['kurta']['quantity']?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_indi_kurta' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_kurta']?>" id="sc_indi_kurta_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_kurta']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">SWEATSHIRT / SWEATERS</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_sweater' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_sweater' data-id="sc_indi_sweater" value='<?=$item_data['sweatshirt']['quantity']?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['sweatshirt']['quantity']?>,'',<?=$rows->settings['sc_indi_sweater']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_sweater1' data-id="sc_indi_sweater" value='<?=$item_data['sweatshirt']['quantity']?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_indi_sweater' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_sweater']?>" id="sc_indi_sweater_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_sweater']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">TOWEL</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_towel' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_towel' data-id="sc_indi_towel" value='<?=$item_data['towel']['quantity']?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['towel']['quantity']?>,'',<?=$rows->settings['sc_indi_towel']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_towel1' data-id="sc_indi_towel" value='<?=$item_data['towel']['quantity']?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_indi_towel' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_towel']?>" id="sc_indi_towel_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_towel']?>/- PER CLOTH</span>
							</div>
							
                        </div>
						<div class="col-sm-6" style="padding: 0px; border-right: 1px solid #e3e3e3">
						
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">BEDSHEET</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_bedsheet' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_bedsheet' data-id="sc_indi_bedsheet" value='<?=$item_data['bedsheet']['quantity']?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['bedsheet']['quantity']?>,'',<?=$rows->settings['sc_indi_bedsheet']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_bedsheet1' data-id="sc_indi_bedsheet" value='<?=$item_data['bedsheet']['quantity']?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_indi_bedsheet' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_bedsheet']?>" id="sc_indi_bedsheet_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_bedsheet']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">CURTAINS</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_curtains' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_curtains' data-id="sc_indi_curtains" value='<?=$item_data['curtains']['quantity']?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['curtains']['quantity']?>,'',<?=$rows->settings['sc_indi_curtains']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_curtains1' data-id="sc_indi_curtains" value='<?=$item_data['curtains']['quantity']?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_indi_curtains' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_curtains']?>" id="sc_indi_curtains_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_curtains']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">LADIES TOP</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_ladies_top' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_ladies_top' data-id="sc_indi_ladies_top" value='<?=$item_data['ladies top']['quantity']?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['ladies top']['quantity']?>,'',<?=$rows->settings['sc_indi_ladies_top']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_ladies_top1' data-id="sc_indi_ladies_top" value='<?=$item_data['ladies top']['quantity']?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_indi_ladies_top' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_ladies_top']?>" id="sc_indi_ladies_top_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_ladies_top']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">OTHER</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_indi_other_item' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_indi_other_item' data-id="sc_indi_other_item" value='<?=$item_data['other']['quantity']?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['other']['quantity']?>,'',<?=$rows->settings['sc_indi_other_item']?>,this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_indi_other_item1' data-id="sc_indi_other_item" value='<?=$item_data['other']['quantity']?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_indi_other_item' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_indi_other_item']?>" id="sc_indi_other_item_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_indi_other_item']?>/- PER CLOTH</span>
							</div>
						
                        </div>
                    </div>
					<?php } else if($rows->order_type==3){?>
					<div class="col-sm-12" style="border: 1px solid #e3e3e3; padding: 0px; ">
                        <div class="col-sm-6" style="padding: 0px; border-right: 1px solid #e3e3e3">
						
                            <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">SHIRTS / T SHIRTS</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_shirt_t_shirt' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_shirt_t_shirt' data-id="sc_dry_shirt_t_shirt" value='<?=$item_data['shirts']['quantity']!=''?$item_data['shirts']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['shirts']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_shirt_t_shirt1' data-id="sc_dry_shirt_t_shirt" value='<?=$item_data['shirts']['quantity']!=''?$item_data['shirts']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_shirt_t_shirt' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_shirt_t_shirt']?>" id="sc_dry_shirt_t_shirt_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_shirt_t_shirt']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">PANTS / TROUSERS</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_pant_trouser' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_pant_trouser' data-id="sc_dry_pant_trouser" value='<?=$item_data['pants']['quantity']!=''?$item_data['pants']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['pants']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_pant_trouser1' data-id="sc_dry_pant_trouser" value='<?=$item_data['pants']['quantity']!=''?$item_data['pants']['quantity']:0?>' class='qty'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_pant_trouser' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_pant_trouser']?>" id="sc_dry_pant_trouser_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_pant_trouser']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">SHAWL / STOLE</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_shawl_stole' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_shawl_stole' data-id="sc_dry_shawl_stole" value='<?=$item_data['shawl']['quantity']!=''?$item_data['shawl']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['shawl']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_shawl_stole1' data-id="sc_dry_shawl_stole" value='<?=$item_data['shawl']['quantity']!=''?$item_data['shawl']['quantity']:0?>' class='qty'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_shawl_stole' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_shawl_stole']?>" id="sc_dry_shawl_stole_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_shawl_stole']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">KURTA</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_kurta' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_kurta' data-id="sc_dry_kurta" value='<?=$item_data['kurta']['quantity']!=''?$item_data['kurta']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['kurta']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_kurta1' data-id="sc_dry_kurta" value='<?=$item_data['kurta']['quantity']!=''?$item_data['kurta']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_kurta' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_kurta']?>" id="sc_dry_kurta_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_kurta']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">SAREES</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_sarees' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_sarees' data-id="sc_dry_sarees" value='<?=$item_data['sarees']['quantity']!=''?$item_data['sarees']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['sarees']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_sarees1' data-id="sc_dry_sarees" value='<?=$item_data['sarees']['quantity']!=''?$item_data['sarees']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_sarees' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_sarees']?>" id="sc_dry_sarees_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_sarees']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">BLAZERS / JACKETS</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_blazer_jacket' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_blazer_jacket' data-id="sc_dry_blazer_jacket" value='<?=$item_data['blazers']['quantity']!=''?$item_data['blazers']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['blazers']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_blazer_jacket1' data-id="sc_dry_blazer_jacket" value='<?=$item_data['blazers']['quantity']!=''?$item_data['blazers']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_blazer_jacket' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_blazer_jacket']?>" id="sc_dry_blazer_jacket_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_blazer_jacket']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">SUIT (2 Pc.)</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_suit' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_suit' data-id="sc_dry_suit" value='<?=$item_data['suit']['quantity']!=''?$item_data['suit']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['suit']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_suit1' data-id="sc_dry_suit" value='<?=$item_data['suit']['quantity']!=''?$item_data['suit']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_suit' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_suit']?>" id="sc_dry_suit_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_suit']?>/- PER CLOTH</span>
							</div>
							
                        </div>
						<div class="col-sm-6" style="padding: 0px; border-right: 1px solid #e3e3e3">
						
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">SWEATERS / SWEATSHIRT</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_sweater' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_sweater' data-id="sc_dry_sweater" value='<?=$item_data['sweaters']['quantity']!=''?$item_data['sweaters']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['sweaters']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_sweater1' data-id="sc_dry_sweater" value='<?=$item_data['sweaters']['quantity']!=''?$item_data['sweaters']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_sweater' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_sweater']?>" id="sc_dry_sweater_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_sweater']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">QUILT / SINGLE BLANKET</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_quilt_blanket' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_quilt_blanket' data-id="sc_dry_quilt_blanket" value='<?=$item_data['quilt']['quantity']!=''?$item_data['quilt']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['quilt']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_quilt_blanket1' data-id="sc_dry_quilt_blanket" value='<?=$item_data['quilt']['quantity']!=''?$item_data['quilt']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_quilt_blanket' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_quilt_blanket']?>" id="sc_dry_quilt_blanket_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_quilt_blanket']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">CURTAINS</div> 
							 <input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_curtain' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_curtain' data-id="sc_dry_curtain" value='<?=$item_data['curtains']['quantity']!=''?$item_data['curtains']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['curtains']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_curtain1' data-id="sc_dry_curtain" value='<?=$item_data['curtains']['quantity']!=''?$item_data['curtains']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_curtain' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_curtain']?>" id="sc_dry_curtain_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_curtain']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">BLANKET (DOUBLE)</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_blanket_double' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_blanket_double' data-id="sc_dry_blanket_double" value='<?=$item_data['blanket']['quantity']!=''?$item_data['blanket']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['blanket']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_blanket_double1' data-id="sc_dry_blanket_double" value='<?=$item_data['blanket']['quantity']!=''?$item_data['blanket']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_blanket_double' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_blanket_double']?>" id="sc_dry_blanket_double_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_blanket_double']?>/- PER CLOTH</span>
							</div>
							
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">LADIES DRESS</div> 
							 <input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_ladies_dress' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_ladies_dress' data-id="sc_dry_ladies_dress" value='<?=$item_data['ladies dress']['quantity']!=''?$item_data['ladies dress']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['ladies dress']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_ladies_dress1' data-id="sc_dry_ladies_dress" value='<?=$item_data['ladies dress']['quantity']!=''?$item_data['ladies dress']['quantity']:0?>'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_ladies_dress' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_ladies_dress']?>" id="sc_dry_ladies_dress_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_ladies_dress']?>/- PER CLOTH</span>
							</div>
							<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">OTHER</div> 
							<input style="display:none;" type='button' value='-' class='qtyminus' field='sc_dry_ohter_item' />
							<input class="col-sm-3 qtys" type='number' min="0" name='sc_dry_ohter_item' data-id="sc_dry_ohter_item"value='<?=$item_data['other']['quantity']!=''?$item_data['other']['quantity']:0?>' class='qty' onchange="manage_cloth_price(6,<?=$item_data['other']['quantity']?>,'','',this.value,'');"/>
							<input class="col-sm-3" type='hidden' min="0" name='sc_dry_ohter_item1' data-id="sc_dry_ohter_item" value='<?=$item_data['other']['quantity']!=''?$item_data['other']['quantity']:0?>' class='qty'/>
							<input style="display:none;" type='button' value='+' class='qtyplus' field='sc_dry_ohter_item' />
							<input class="col-sm-3" type="text" value="<?=$rows->settings['sc_dry_ohter_item']?>" id="sc_dry_ohter_item_price" readonly>
							<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$rows->settings['sc_dry_ohter_item']?>/- PER CLOTH</span>
							</div>
							
						
                        </div>
                    </div>
					
					<?php } else if($rows->order_type==4){ $washPrice=$rows->settings['sc_shoe_price']+$rows->settings['iron_price'];if($rows->iron==1){$washPrice=$rows->settings['sc_shoe_price_iron'];}?>
					 <div class="col-sm-12" style="border: 1px solid #e3e3e3; padding: 0px; ">
                        <div class="col-sm-12" style="padding: 0px; border-right: 1px solid #e3e3e3">
						
						<div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Total Clothes</div> 
						
						<input style="display:none;" type='button' value='-' class='qtyminus' field='no_of_items' />
						<input class="col-sm-3" type='number' min="0" name='no_of_items' data-id="no_of_items" value='<?=$item_data['no of clothes']['quantity']!=''?$item_data['no of clothes']['quantity']:0?>' class='qty' onchange="manage_cloth_price(2,1,'no_of_items',<?=$washPrice?>,this.value,'');" autocomplete="off"/>
						<input style="display:none;" type='button' value='+' class='qtyplus' field='no_of_items' />
						<input class="col-sm-3" type="text" value="<?=$washPrice?>" id="no_of_items_price" readonly>
						<span style="display:none;" class="fs-12">  <i class="fa fa-inr p-l-10"></i> <?=$washPrice?>/- PER CLOTH</span>
						</div>
							
						<div id="no_of_items_err"></div>
						 </div>
                    </div>
				   <?php }?>
                   
					<div class="form-group" >
                            <label for="concept" class="col-sm-6 control-label">Items Ironed </label>
                            <div class="col-sm-6">
                                <input min="0" autocomplete="off" type="number" name="ironed" id="ironed" class="form-control" value="<?=$rows->ironeQuantity!=''?$rows->ironeQuantity:0?>" onchange="manage_cloth_price(5,1,'ironed',this.value,'','');">
                                  
                            </div>
                    </div>
					
					<div class="form-group " >
                            <label for="concept" class="col-sm-6 control-label">Comments </label>
                            <div class="col-sm-6">
                                <input type="text" name="comment" id="comment" class="form-control" value="<?=$rows->comment?>">
                                  
                            </div>
                    </div>

                   
                    <div class="form-group " >
                            <label for="concept" class="col-sm-6 control-label">Extra Amount Adjustments </label>
                            <div class="col-sm-6">
                                <input autocomplete="off" type="number" name="extra_amount" id="extra_amount" class="form-control" value="<?=$rows->extra_amount_for_adjustment!=""?$rows->extra_amount_for_adjustment:0?>" onchange="manage_cloth_price(1,1,'extra_amount',this.value,'','');"  min="-1000">
                                  
                            </div>
                    </div>
                     
                    
                     <div class="form-group" >
                            <label for="concept" class="col-sm-6 control-label">Total Amount to be charged: </label> 
							<?php if($rows->order_type==1){?>
                            <label id="label_extra_amount">Rs <?=$rows->total_amount+$rows->extra_amount_for_adjustment+$rows->extra_amount+$rows->ironed?></label>
							<?php } else {?>
							<label id="label_extra_amount">Rs <?=$rows->total_amount+$rows->extra_amount_for_adjustment+$rows->ironed+$rows->extra_amount?></label>
							<?php } ?>
							 <input type="hidden" name="total_amount" id="total_amount" class="form-control" value="<?=$rows->total_amount?>" >
                     </div>
					 
					<div class="col-md-5 col-md-offset-5 ">
                        <div id="loader"></div>
						<button type="button" id="saveBtn" class="btn btn-success">Save</button>
                        <button type="button" id="clothBtn" class="btn btn-success">Save & Send SMS</button><br><br>
                        
                    </div>


                    


                </div>
            </form>
        </div>
		
		
<script>	
function manage_cloth_price(type,sum,id,price,qnt,totP)
{
	var total_amount=$("#total_amount").val();
	var orderType=$("#orderType").val();
	var iron_price = '<?=$iron_price;?>';
	var subTotal=0;
	if(type=='1')
	{
		 var ironed=$("#ironed").val();
		 if(orderType=='1')
		 {
			 var new_price=$("#new_price").val();
			 var subTotal=parseInt(price);
			 var total=subTotal+parseInt(total_amount)+parseInt(new_price)+(parseInt(ironed)*parseInt(iron_price));
			 $("#label_extra_amount").html("Rs "+total);
		 }
		 else
		 {
			 var subTotal=parseInt(price);
			 var total=subTotal+parseInt(total_amount)+(parseInt(ironed)*parseInt(iron_price));
			 $("#label_extra_amount").html("Rs "+total);
		 }
		 
	}
	else if(type=='2')
	{
	 var extra_amount=$("#extra_amount").val();
	 var ironed=$("#ironed").val();
	 var subTotal=parseInt(price)*parseInt(qnt);
	 var total=parseInt(extra_amount)+subTotal+(parseInt(ironed)*parseInt(iron_price));
	 $("#total_amount").val(subTotal);
	 $("#label_extra_amount").html("Rs "+total);
		
	}
	else if(type=='3')
	{
		
		var extra_amount=$("#extra_amount").val();	
		var subTotal=parseInt(price)*parseInt(qnt);
		var newSubT=parseInt(totP)+subTotal;
		var total=parseInt(extra_amount)+newSubT;
		$("#total_amount").val(newSubT);
		$("#label_extra_amount").html("Rs "+total);
	}
	else if(type=='4')
	{
		var slot_weight=$("#slot_weight").val();
		var extra_charge=$("#extra_charge").val();
		var extra_amount=$("#extra_amount").val();
		var new_extra_amount=$("#new_extra_amount").val();
		var ironed=$("#ironed").val();
		if(qnt<10)
		{
			if(qnt>slot_weight)
			{
				var price = (parseInt(qnt) - parseInt(slot_weight)) * parseInt(extra_charge);
				var total=price+parseInt(total_amount)+parseInt(extra_amount)+(parseInt(ironed)*parseInt(iron_price));
				$("#new_price").val(price);
				$("#label_extra_amount").html("Rs "+total);
			}
			else
			{
				var price = parseInt(new_extra_amount);
				var total=parseInt(total_amount)+parseInt(extra_amount)+(parseInt(ironed)*parseInt(iron_price));
				$("#new_price").val(0);
				$("#label_extra_amount").html("Rs "+total);
			}
			
		}
	}
	else if(type=='5')
	{
		 var extra_amount=$("#extra_amount").val();
		 
		 if(orderType=='1')
		 {
			 var new_price=$("#new_price").val();
			
			 var subTotal=parseInt(price)*parseInt(iron_price);
			 
			 var total=subTotal+parseInt(total_amount)+parseInt(new_price)+parseInt(extra_amount);
			
			 $("#label_extra_amount").html("Rs "+total);
		 }
		 else
		 {
			 var subTotal=parseInt(price)*parseInt(iron_price);
			 var total=subTotal+parseInt(total_amount)+parseInt(extra_amount);
			 $("#label_extra_amount").html("Rs "+total);
		 }
		 
	}
	else if(type=='6')
	{
		var total = 0;
		var total_qty = 0;
		var extra_amount = parseInt($('#extra_amount').val());
		var ironed=$("#ironed").val();
		$('.qtys').each(function(){
		   var qty = $(this).val();
		   total_qty +=parseInt(qty);
		   var id = $(this).data('id');
		   var price = $('#'+id+'_price').val();
		   var sum = parseInt(qty)*parseInt(price);
		   total = parseInt(total) + parseInt(sum);
		});
		//alert(total);
		 var extAmt=extra_amount+total+(parseInt(ironed)*parseInt(iron_price));
		 //alert(extAmt);
         $('#label_extra_amount').html("Rs "+ extAmt);
         $('#total_amount').val(total);
	}

}

	
		
		
		
		
		$('#clothBtn').click(function(){
		   var order_id =$("#order_id").val();
		   var weight =$("#weight").val();
		   var no_of_items =$("#no_of_items").val();
		   var orderType=$("#orderType").val();
		   var token_no=$("#token_no").val();
		   var ironed=$("#ironed").val();
		   var comment=$("#comment").val();
		   var extra_amount=$("#extra_amount").val();
		   if(orderType=='1' && weight>=10.5)
		   {
			   alert("Cloth weight should be less than 10 kg");
			   return false;
		   }
		   else if(orderType=='4' && no_of_items>15)
		   {
			   alert("No Of Item should be less than 15");
			   return false;
		   }
		   else
		   {
			   var url = '<?=BASE?>panel/orders/cloth-detail';
			   var data = $('#clothFrm').serialize();
			   //alert(data);
			   $('#loader').html('<i class="fa fa-spin fa-spinner"></i>');
			   $.post(url,data,function(success){
				   
				   var res = JSON.parse(success);
				  console.log(res);
				   if(res.status)
				   {
					   $('#t_'+res.data.order_id).text(res.data.token_no);
					   $('#w_'+res.data.order_id).text(res.data.weight);
					   $('#n_'+res.data.order_id).text(res.data.no_of_items);
					   $('#cd_'+res.data.order_id).data('token',res.data.token_no);
					   $('#cd_'+res.data.order_id).data('weight',res.data.weight);
					   $('#cd_'+res.data.order_id).data('item',res.data.no_of_items);
					   $('#loader').html('<span class="success">Cloth Details Added</span>')
					   $('#clothFrm')[0].reset();
					   $('#clothsmodal').modal('hide');
					   $('#to_'+res.data.order_id).val(res.data.token_no);
					   $('#total_'+res.data.order_id).val(res.data.no_of_items);
					   //$('#college_name_'+res.data.order_id).val(res.data.college_name);
					   //$('#wash_type_'+res.data.order_id).val(res.data.wash_type);
					   $('#form_'+res.data.order_id).trigger('submit');
					   $('#btn_'+res.data.order_id).removeAttr('disabled');
				   }
				   else{
					var error = res.error;
					$.each( error, function( i, val ) 
					{
						$('#'+i).html(val);
						setTimeout(function(){$('#'+i).html('');},2000);
					});
					$('#loader').html('<span class="err">Error occured</span>');
				}
			   })
			}
       })
	   
	   $('#saveBtn').click(function(){
		   var order_id =$("#order_id").val();
		   var weight =$("#weight").val();
		   var no_of_items =$("#no_of_items").val();
		   var orderType=$("#orderType").val();
		   var token_no=$("#token_no").val();
		   var ironed=$("#ironed").val();
		   var comment=$("#comment").val();
		   var extra_amount=$("#extra_amount").val();
		   if(orderType=='1' && weight>=10.5)
		   {
			   alert("Cloth weight should be less than 10 kg");
			   return false;
		   }
		   else if(orderType=='4' && no_of_items>15)
		   {
			   alert("No Of Item should be less than 15");
			   return false;
		   }
		   else
		   {
			   var url = '<?=BASE?>panel/orders/update-cloth-details';
			   var data = $('#clothFrm').serialize();
			   //alert(data);
			   $('#loader').html('<i class="fa fa-spin fa-spinner"></i>');
			   $.post(url,data,function(success){
				   
				   var res = JSON.parse(success);
				  console.log(res);
				   if(res.status)
				   {
					   $('#t_'+res.data.order_id).text(res.data.token_no);
					   $('#w_'+res.data.order_id).text(res.data.weight);
					   $('#n_'+res.data.order_id).text(res.data.no_of_items);
					   $('#cd_'+res.data.order_id).data('token',res.data.token_no);
					   $('#cd_'+res.data.order_id).data('weight',res.data.weight);
					   $('#cd_'+res.data.order_id).data('item',res.data.no_of_items);
					   $('#loader').html('<span class="success">Cloth Details Added</span>')
					   $('#clothFrm')[0].reset();
					   $('#clothsmodal').modal('hide');
					   $('#to_'+res.data.order_id).val(res.data.token_no);
					   $('#total_'+res.data.order_id).val(res.data.no_of_items);
					   //$('#college_name_'+res.data.order_id).val(res.data.college_name);
					   //$('#wash_type_'+res.data.order_id).val(res.data.wash_type);
					   $('#form_'+res.data.order_id).trigger('submit');
					   $('#btn_'+res.data.order_id).removeAttr('disabled');
				   }
				   else{
					var error = res.error;
					$.each( error, function( i, val ) 
					{
						$('#'+i).html(val);
						setTimeout(function(){$('#'+i).html('');},2000);
					});
					$('#loader').html('<span class="err">Error occured</span>');
				}
			   })
			}
       })
	   
		</script>
