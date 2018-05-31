<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
<div class="col-lg-12">  
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Create Invoice</h1>
                <ol class="breadcrumb">
                    <li><a href="<?=BASE?>panel"> <i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="<?=BASE?>panel/orders">Orders</a></li>
                    <li class="active">Create Bill of Service</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row" id="printable">

    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="padding-bottom:10px;">
            <div class="row">
			<?php $clg=explode(" ",$invoice->college_name);
			$f3=substr($clg[0], 0, 3);
			?>
           <h4 class="col-sm-12">Bill of Service for order : <?=date("mdy",strtotime($invoice->book_date)).strtoupper($f3).substr($clg[1], 0, 1).$this->uri->segment(4)?> | GST Number : <?=$invoice->sc_GST_Number?> | Book Date : <?=$invoice->book_date?></h4>
            
            </div>
        </div>
    <div class="panel-body">
        <div class="col-lg-12 margin-top-20">
            <div class="panel-body">
                <form action="<?=current_url()?>?from=<?=$this->input->get('from')?>" method="post" name="genrateinvoice" id="genrateinvoice">

                    <div class="row" >

                        <!-- invoicedetails -->
                        <div class="col-lg-6">
                            <div class="portlet portlet-green" style="border-bottom: 1-x solid #e3e3e3">
                                <div class="portlet-heading">
                                    <div class="portlet-title">
                                       <h4><i class="fa fa-exchange fa-fw"></i> Invoice Details</h4>
                                    </div>
                                    <!-- <div class="portlet-widgets">
                                       <a data-toggle="collapse" data-parent="#accordion11" href="#invoicedetails"><i class="fa fa-chevron-down"></i></a>
                                     </div> -->
                                      <div class="clearfix"></div>
                                </div>
                                <div id="invoicedetails" class="panel-collapse" >
                                    <div class="portlet-body">
                                        <table class="table" style="background: #e3e3e3">
                                            <tbody>
                                                <tr>
                                                    <td>Invoice Number</td>
                                                    <td align="right">
                                                        <?=date("mdy",strtotime($invoice->book_date)).strtoupper($f3).substr($clg[1], 0, 1).$this->uri->segment(4)?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Service Type</td>
                                                    <td align="right">
                                                        <?php
                                                
                                                        if($invoice->order_type == 1)
                                                        {
                                                            if($invoice->iron==1)
                                                                echo $booktype[$invoice->order_type]." + Iron";
                                                            else
                                                                echo $booktype[$invoice->order_type]." + Fold";
                                                        }
                                                        else if($invoice->order_type == 4)
                                                        {
                                                            if($invoice->iron==1)
                                                                echo "Individual Iron";
                                                            else
                                                                echo $booktype[$invoice->order_type];
                                                        }
                                                        else{
                                                            echo $booktype[$invoice->order_type];
                                                        }        
                                                        ?>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Customer Name</td>
                                                    <td align="right"><?=$invoice->firstname.' '.$invoice->lastname?></td>
                                                </tr>
                                                <tr>
                                                    <td>Phone Number</td>
                                                    <td align="right"><?=$invoice->phone_no?></td>
                                                </tr>
                                        
                                        
                                                <tr>
                                                    <td>Wallet Balance</td>
                                                                    <td align="right"><?=  number_format($invoice->wallet_balance,2)?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- booking Detail -->

                        <div class="col-lg-6">
                            <div class="portlet portlet-green">
                                <div class="portlet-heading">
                                    <div class="portlet-title">
                                        <h4><i class="fa fa-exchange fa-fw"></i> Booking Details</h4>
                                    </div>
                                    <!-- <div class="portlet-widgets">
                                       <a data-toggle="collapse" data-parent="#accordion" href="#bookingdetails"><i class="fa fa-chevron-down"></i></a>
                                    </div> -->
                                    <div class="clearfix"></div>
                                </div>
                                <div id="bookingdetails" class="panel-collapse collapse in">
                                    <div class="portlet-body">
                                        <table class="table" style="background: #e3e3e3">
                                            <tbody>
                                                <tr>
                                                    <td>Token No</td>
                                                    <td><?=$invoice->token_no?></td>
                                                </tr>
                                                <tr>
                                                    <td>Booking Id</td>
                                                    <td><?=$invoice->id?></td>
                                                </tr>
                                                <tr>
                                                    <td>Booking Date</td>
                                                    <td><?=$invoice->book_date?></td>
                                                </tr>
                                                <tr>
                                                    <td>Slot Type</td>
                                                    <td>
                                                        <?php 
                                                            $slot = [1=>'Morning',2=>'Afternoon',3=>'Evening',4=>'Night'];
                                                            echo $slot[$invoice->book_slot];
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pickup Date</td>
                                                    <td><?=date('d-m-Y',strtotime($invoice->book_date, ' +1 day'))?></td>
                                                </tr>
                                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                        <div class="col-md-6 col-lg-6">

                            <!-- cloth Details -->

                            <div class="portlet portlet-green">
                                <div class="portlet-heading">
                                    <div class="portlet-title">
                                       <h4><i class="fa fa-exchange fa-fw"></i> Clothes Details</h4>
                                    </div>
                                    <div class="portlet-widgets">
                                       <a data-toggle="collapse" data-parent="#accordion11" href="#clothdetails"><i class="fa fa-chevron-down"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="clothdetails" class="panel-collapse">
                                      <div class="portlet-body">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Clothes Weight</td>
                                                        <td>
                                                            <label id="weight1" style="width: 20px;" name="weight1"><?=$invoice->weight?> </label><label>KG</label>
															<input type="hidden" class="form-control" id="weight" style="width: 80px;" name="weight" value="<?=$invoice->weight?>" size="3" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No of Clothes</td>
                                                        <td>
                                                            <label id="weight" style="width: 20px;" name="weight"><?=$invoice->no_of_items?> </label>
															<input type="hidden" class="form-control" style="width: 80px;" value="<?=$invoice->no_of_items?>" id="total_cloths" name="no_of_items" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            
                                                                    <?php
                                                    $item_data=[];
                                                        foreach($invoice->items as $item)
                                                        {
                                                            $item_data[strtolower($item['item'])] = ['quantity'=>$item['quantity'],'rate'=>$item['rate'],'cost'=>$item['cost']];
                                                        }
                                                    if($invoice->order_type==2 || $invoice->order_type==3){
                                                        ?>
                                                    <?php if($item_data['shirt']['cost']>0){?>          
                                                    <tr id="shirt">
                                                        <td><div class="col-sm-12">SHIRTS / T SHIRTS / TOPS<input type="hidden" name="items[]" value="Shirt" /></div>
                                                            <div class="col-sm-7 margin-top-10">rate per cloth <input disabled  name="rate[]" data-id='shirt' class="calculate rate" value="<?=$item_data['shirt']['rate']!=''?$item_data['shirt']['rate']:'0.00'?>" style="width: 40px;" /></div>
                                                            <div class="col-sm-5 pull-right  margin-top-10">quantity <input disabled  data-id='shirt' name="quantity[]" class="calculate quantity" value="<?=$item_data['shirt']['quantity']!=''?$item_data['shirt']['quantity']:'0'?>" style="width: 40px;" /></div></td>
                                                        <td class="text-right">
                                                            <input type="hidden" class="total" value="<?=$item_data['shirt']['cost']!=''?number_format($item_data['shirt']['cost'],2):'0.00'?>">
                                                            <i class="fa fa-inr"></i> <span class="total_text"><?=$item_data['shirt']['cost']!=''?number_format($item_data['shirt']['cost'],2):'0.00'?></span></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if($item_data['pant']['cost']>0){?>   
                                                    <tr id="pant">
                                                        <td><div class="col-sm-12">PANTS / JEANS / LOWERS<input type="hidden" name="items[]" value="Pant" /></div>
                                                            <div class="col-sm-7 margin-top-10">rate per cloth <input disabled   data-id='pant' name="rate[]" class="calculate rate" value="<?=$item_data['pant']['rate']!=''?$item_data['pant']['rate']:'0'?>" style="width: 40px;" /></div>
                                                            <div class="col-sm-5 pull-right  margin-top-10">quantity <input disabled   data-id='pant' name="quantity[]" class="calculate quantity" value="<?=$item_data['pant']['quantity']!=''?$item_data['pant']['quantity']:'0'?>" style="width: 40px;" /></div>
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="hidden" class="total" value="<?=$item_data['pant']['cost']!=''?number_format($item_data['pant']['cost'],2):'0.00'?>">
                                                            <i class="fa fa-inr"></i> <span class="total_text"><?=$item_data['pant']['cost']!=''?number_format($item_data['pant']['cost'],2):'0.00'?></span></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if($item_data['salwar suit or kurta pajama']['cost']>0 || $item_data['suit']['cost']>0){?>
                                                    <tr id="suit">
                                                        <td><div class="col-sm-12"><?=$invoice->order_type==2?'SUIT/PAJAMA':'SUIT'?><input type="hidden" name="items[]" value="<?=$invoice->order_type==2?'Salwar Suit or Kurta Pajama':'Suit'?>" /> 
                                                            </div>
                                                            <div class="col-sm-7 margin-top-10">rate per cloth <input disabled   data-id='suit' name="rate[]" class="calculate rate" value="<?=$item_data[$invoice->order_type==2?'salwar suit or kurta pajama':'suit']['rate']!=''?$item_data[$invoice->order_type==2?'salwar suit or kurta pajama':'suit']['rate']:'0'?>" style="width: 40px;" /></div>
                                                            <div class="col-sm-5 pull-right  margin-top-10">quantity <input disabled   data-id='suit' name="quantity[]" class="calculate quantity" value="<?=$item_data[$invoice->order_type==2?'salwar suit or kurta pajama':'suit']['quantity']?$item_data[$invoice->order_type==2?'salwar suit or kurta pajama':'suit']['quantity']:'0'?>" style="width: 40px;" /></div>
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="hidden" class="total" value="<?=$item_data[$invoice->order_type==2?'salwar suit or kurta pajama':'suit']['cost']!=''?number_format($item_data[$invoice->order_type==2?'salwar suit or kurta pajama':'suit']['cost'],2):'0.00'?>">
                                                            <i class="fa fa-inr"></i> <span class="total_text"><?=$item_data[$invoice->order_type==2?'salwar suit or kurta pajama':'suit']['cost']!=''?number_format($item_data[$invoice->order_type==2?'salwar suit or kurta pajama':'suit']['cost'],2):'0.00'?></span></td>
                                                    </tr>
                                                    <?php } ?>
                                                  
													<?php if($item_data['towel']['cost']>0 || $item_data['blanket']['cost']>0){?>
                                                    <tr id="towels">
                                                        <td><div class="col-sm-12"><?=$invoice->order_type==2?'TOWELS / BEDSHEETS':'BLANKET'?><input type="hidden" name="items[]" value="<?=$invoice->order_type==2?'Towel':'Blanket'?>" /></div>
                                                            <div class="col-sm-7 margin-top-10">rate per cloth <input disabled   data-id='towels' name="rate[]" class="calculate rate" value="<?=$item_data[$invoice->order_type==2?'towel':'blanket']['rate']!=''?$item_data[$invoice->order_type==2?'towel':'blanket']['rate']:'0'?>" style="width: 40px;" /></div>
                                                            <div class="col-sm-5 pull-right  margin-top-10">quantity <input disabled   data-id='towels' name="quantity[]" class="calculate quantity" value="<?=$item_data[$invoice->order_type==2?'towel':'blanket']['quantity']?$item_data[$invoice->order_type==2?'towel':'blanket']['quantity']:0?>" style="width: 40px;" /></div>
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="hidden" class="total" value="<?=$item_data[$invoice->order_type==2?'towel':'blanket']['cost']!=''?number_format($item_data[$invoice->order_type==2?'towel':'blanket']['cost'],2):'0.00'?>">
                                                            <i class="fa fa-inr"></i> <span class="total_text"><?=$item_data[$invoice->order_type==2?'towel':'blanket']['cost']!=''?number_format($item_data[$invoice->order_type==2?'towel':'blanket']['cost'],2):'0.00'?></span>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if($item_data['others']['cost']>0){?>
                                                    <tr id="others">
                                                        <td><div class="col-sm-12">OTHERS<input type="hidden" name="items[]" value="Other" /></div>
                                                            <div class="col-sm-7 margin-top-10">rate per cloth <input disabled   data-id='others' name="rate[]" class="calculate rate" value="<?=$item_data['others']['rate']!=''?$item_data['others']['rate']:'0'?>" style="width: 40px;" /></div>
                                                            <div class="col-sm-5 pull-right  margin-top-10">quantity <input disabled   data-id='others' name="quantity[]" class="calculate quantity" value="<?=$item_data['others']['quantity']?$item_data['others']['quantity']:'0'?>" style="width: 40px;" /></div>
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="hidden" class="total" value="<?=$item_data['others']['cost']!=''?number_format($item_data['others']['cost'],2):'0.00'?>">
                                                            <i class="fa fa-inr"></i> <span class="total_text"><?=$item_data['others']['cost']!=''?number_format($item_data['others']['cost'],2):'0.00'?></span></td>
                                                    </tr>
                                                    <?php } ?>
                                                        <?php } elseif($invoice->order_type==4){
                                                        ?>
                                                    <tr id="dryclean">
                                                        <td><div class="col-sm-12">Total Clothes<input type="hidden" name="items[]" value="No of clothes" /></div>
                                                            <div class="col-sm-7 margin-top-10">rate per cloth <input disabled   data-id='dryclean' class="calculate rate" name="rate[]" value="<?=$item_data['no of clothes']['rate']!=''?$item_data['no of clothes']['rate']:'0'?>" style="width: 40px;" /></div>
                                                            <div class="col-sm-5 pull-right  margin-top-10">quantity <input disabled   data-id='dryclean' name="quantity[]" class="calculate quantity" value="<?=$item_data['no of clothes']['quantity']?>" style="width: 40px;" /></div>
                                                        </td>
                                                        <td class="text-right">
                                                           
                                                            <i class="fa fa-inr"></i> <span class="total_text"><?=number_format($item_data['no of clothes']['cost'],2)?></span></td>
                                                    </tr>
                                                        <?php }?>
                                            
                                            </table>
                                        </div>
                                </div>             
                            </div>
                        </div>
                    <?php if($invoice->weight > $invoice->settings['slot_weight'] && $invoice->order_type==1)
                    {
                        $price = ceil($invoice->weight - $invoice->settings['slot_weight'])*$invoice->settings['extra_charge'];
                    }else{
                        $price = 0;
                    }
                        if($invoice->extra_amount>0 && $invoice->extra_amount!=NULL)
                        {
                            $price = $invoice->extra_amount;
                        }
                    ?>

                        <div class="col-md-6  col-lg-6">
                             <!-- invoice -->
                            <div class="portlet portlet-green">
                                <div class="portlet-heading">
                                    <div class="portlet-title">
                                       <h4><i class="fa fa-exchange fa-fw"></i>Invoice</h4>
                                    </div>
                                    <div class="portlet-widgets">
                                       <a data-toggle="collapse" data-parent="#accordion11" href="#invoice"><i class="fa fa-chevron-down"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="invoice" class="panel-collapse">
                                        <div class="portlet-body">
                                                <table class="table">
                                                    <tbody>
                                                        
                                                       <tr>
                                                            <td>
                                                               Service Base Amount
                                                            </td>
                                                            <td align="right">
                                                                 <label class="total3"><?= number_format($invoice->total_amount,2)?></label>
                                                            </td>

                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Additional amount due to extra weight <?php if($invoice->order_type==1){?><small>(<i class="fa fa-inr"></i><?=$invoice->settings['extra_charge']?> per kg)</small><?php }?></td>
                                                            <td align="right">
                                                                
                                                                <label class="total3" <?php if($invoice->order_type!=1){?>readonly=""<?php }?> style="width: 80px;" class="form-control" ><?=  number_format($price,2)?></label>
																  <input name="extra_amt" id="extra_amt" type="hidden"  class="form-control total" <?php if($invoice->order_type!=1){?>readonly=""<?php }?> style="width: 80px;" class="form-control" value="<?=  number_format($price,2)?>">
                                                            </td>
                                                        </tr>
                                                        <?php if($invoice->iron==0) { ?>
                                                        <tr>
                                                            <?php $iron_price='0.00';$ironno=0; if(strlen($invoice->iron_cost)>0){ $ironvar = json_decode($invoice->iron_cost);$ironno =$ironvar->iron_no;$iron_price = $ironvar->total_iron_price; }?>
                                                            <td>Iron <b>(not Included)</b> <small>(<i class="fa fa-inr"></i><?=$invoice->settings['iron_price']?> per pcs)</small>
															<input type="hidden" class="form-control" style="width: 60px; float: right" id="iron_no" value="<?=$ironno?>" name="iron_no" />
															</td>
                                                            <td align="right">
                                                                <input type="hidden" id="iron_price" value="<?=$invoice->settings['iron_price']?>">
                                                                <label style="width: 80px;"><?=$iron_price?></label> 
																	
																 <input name="total_iron_price" id="total_iron_price" type="hidden" class="form-control total" style="width: 80px;" value="<?=$iron_price?>">	
                                                            </td>
                                                        </tr>
                                                        <?php } else if($invoice->iron==2 && $invoice->order_type==4){ ?>
                                                            <tr>
                                                            <?php $ironno=$item_data['no of clothes']['quantity'];$iron_price=$invoice->settings['iron_price']; $total_iron_price = $ironno * $iron_price;?>
                                                                <input class="hidden" id="iron_no" name="iron_no" value="<?=$ironno?>">
                                                                <input class="hidden" id="total_iron_price" name="total_iron_price" value="<?=$total_iron_price?>">

                                                                <td><b>Iron Cost already included</b></td>
                                                            </tr>
                                                        <?php }else{ ?>
                                                            <tr>
                                                                <input class="hidden" id="iron_no" name="iron_no" value="0">
                                                                <input class="hidden" id="total_iron_price" name="total_iron_price" value="0.00">

                                                                <td><b>Iron Cost already included</b></td>
                                                            </tr>
                                                           <?php }?>
                                                        <tr>
                                                            <td>Pick &amp; Drop Off</td>
                                                            <td align="right">
                                                                <?php if($invoice->pickup_type==2)
                                                                    {
                                                                        $pick_cost = $invoice->settings['pickdrop'];

                                                                    }else{$pick_cost='0.00';}
                                                                    if($invoice->pickup_cost > 0 && $invoice->pickup_cost!=NULL)
                                                                    {
                                                                        $pick_cost = $invoice->pickup_cost;
                                                                    }
                                                                    ?>
                                                                <label   style="width: 80px;"><?=  number_format($pick_cost,2);?></label>
																  <input type="hidden" class="form-control total" style="width: 80px;" value="<?=  number_format($pick_cost,2);?>" name="pickdrop" id="pickdrop_chk1">
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Coupon Discount <br>
                                                                <small><b><?=$invoice->coupon_applied?></b> 
                                                            </td>
                                                            <td align="right">                    
                                                                <label style="color:green;">-  <?=number_format($invoice->discount,2)?></label> 
																<input type="hidden" class="form-control totalD" style="width: 80px;" value="<?=  number_format($invoice->discount,2);?>">			
                                                            </td>
                                                        </tr>
                                                         <tr>
                                                            <td>Any Additional Amount / Discount</td>
                                                            <td align="right">                    
                                                                <label style="width: 80px;" >0.00</label> 
																
																 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>SGST</td>
                                                            <td align="right">                    
                                                                <label style="width: 80px;" value="" name="sc_SGST" id="sc_SGST"><?=  number_format($invoice->sc_SGST,2);?></label>   <input type="hidden" class="form-control total" style="width: 80px;" value="<?=  number_format($invoice->sc_SGST,2);?>">  
                                                            </td>
                                                        </tr>
                                                         <tr>
                                                            <td>CGST</td>
                                                            <td align="right">                    
                                                                <label style="width: 80px;" ><?=  number_format($invoice->sc_CGST,2);?></label>  
																 <input type="hidden" class="form-control total" style="width: 80px;" value="<?=  number_format($invoice->sc_CGST,2);?>">
                                                            </td>
                                                        </tr>
                                                         <tr>
                                                            <td>IGST</td>
                                                            <td align="right">                    
                                                                <label style="width: 80px;" ><?=  number_format($invoice->sc_IGST,2);?> </label> 
																 <input type="hidden" class="form-control total" style="width: 80px;" value="<?=  number_format($invoice->sc_IGST,2);?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Amount</td>

                                                            <td class="text-right">
                                                                <?php $total = $invoice->total_amount +$price+$pick_cost+$invoice->sc_SGST+$invoice->sc_CGST+$invoice->sc_IGST-$invoice->discount; ?>
                                                            <input type="hidden" name="total_price" id="total_price" value="<?=$total?>">
                                                            <i class="fa fa-inr"></i> <span id="total_price_txt"><?=  number_format($total,2)?></span></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                        </div>
                                </div>             
                            </div>


                            <!-- amountdetails -->

                            <div class="portlet portlet-green">
                                <div class="portlet-heading">
                                    <div class="portlet-title">
                                       <h4><i class="fa fa-exchange fa-fw"></i> Amount Details</h4>
                                    </div>
                                    <div class="portlet-widgets">
                                       <a data-toggle="collapse" data-parent="#accordion11" href="#amountdetails"><i class="fa fa-chevron-down"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="amountdetails" class="panel-collapse">
                                      <div class="portlet-body">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                                <td>Payment Type</td>
                                                                <td><?php 
                                                                if($invoice->payment_type==1)
                                                                    echo "Online";
                                                                else
                                                                    echo "COD";
                                                                ?></td>
                                                            </tr>
                                                   
                                                    
                                                   
                                                   <tr>
                                                       <td>Amount Collected at the time of booking</td>
                                                        <td class="text-right">
														<?php if($invoice->payment_type==1) {
                                                             
																	echo $totalCollectedAmt=number_format($invoice->total_amount,2)+$invoice->sc_SGST+$invoice->sc_CGST+$invoice->sc_IGST-$invoice->discount;
																
															} else { echo "0";}?>	
															 <?php if($invoice->order_type==1 || $invoice->order_type==4) {?>
															  <input type="hidden" class="total" value="<?=$invoice->total_amount?>">
															 <?php } ?>
															 
															
                                                        </td>
                                                    </tr>
                                                
                                                
                                                        <tr>
                                                            
                                                            <td>Amount to be collected</td>
                                                            <td class="text-right">
															<?php if($invoice->payment_type==1) {?>
                                                              <?php echo $total - $totalCollectedAmt;?>
															<?php } else { echo number_format($total,2) ;}?>	
                                                            
                                                            </td>
                                                        </tr>
                                                  
                                                    <tr>
                                                        <td>Total Amount</td>
                                                        <td class="text-right"><i class="fa fa-inr"> <?php echo number_format($total,2) ;?></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>             
                            </div>	
                        </div>

                        <div class="col-lg-12" id="hideDiv"><br>
                            <div class="pull-right">
							<?php if($invoiceType!='view'){?>
                              <input name="btnGenrateinvoice" type="submit" id="btnGenrateinvoice" value="Create Invoice" class="btn btn-success btn-green">
							  <?php } ?>
                              <input name="printInvoice" type="button" id="printInvoice" value="Print" class="btn btn-success btn-yellow" onclick="printDiv('printable')">
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
</div>
<script>
    $(document).ready(function(){
		
		 setTimeout(function(){$("#hideDiv").show();},500);
        setTimeout(function(){$('.total').keyup()},500);
        $('.total').keyup(function(){
            var total = 0;
			var totalD = 0;
            $('.total').each(function(){
                //console.log($(this).val())
                total += parseFloat($(this).val());
				
            })
			$('.totalD').each(function(){
                //console.log($(this).val())
                totalD += parseFloat($(this).val());
            })
			
			var totalPrice=total - totalD;
			
			//alert(total +"-"+ totalD);
			
            $('#total_price').val(totalPrice);
            $('#total_price_txt').text(totalPrice.toFixed(2));
        })
        <?php 
            if($invoice->order_type==1)
            {?>
        $('#weight').keyup(function(){
            var extra_charge = parseInt($('#extra_charge').val());
            var slot_weight = parseInt($('#slot_weight').val());
            var extra_price = 0;
            var extra_weight = 0;
            var new_weight = parseInt($(this).val());
            if(new_weight > slot_weight)
            {
                extra_weight = new_weight-slot_weight;
                $('#extra_amt').val(extra_charge*Math.ceil(extra_weight)).keyup();
            }else{
                $('#extra_amt').val('0.00').keyup();
            }
        })
            <?php }else{?>
                $('.calculate').change(function(){
                    var id = $(this).data('id');
                    var rate = $('#'+id+' .rate').val();
                    var quantity = $('#'+id+' .quantity').val();
                    var total = parseFloat(rate)*parseFloat(quantity);
                    $('#'+id+' .total').val(total);
                    $('#'+id+' .total_text').html(total);
                    $('.total').keyup();
                })
            <?php }?>
        $('#iron_no').keyup(function(){
            if($(this).val()>0)
            {
                var iron_total = $('#iron_price').val()*$(this).val();
                $('#total_iron_price').val(iron_total).keyup();
            }else{
                $('#total_iron_price').val('0.00').keyup();
            }
        })

        $('#btnGenrateinvoice').click(function(){
            var data = $('#genrateinvoice').serialize();
            console.log(data);
        })

    })
	
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
    </script>