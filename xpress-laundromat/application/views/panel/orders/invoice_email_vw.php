<table border="0" cellpadding="0" cellspacing="0" style="line-height:100%!important;margin: 0 auto;padding:0;width:100%">
    <tbody>
        <tr>
            <td>
            <figure>
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="background:#f4f4f4;width:600px">
                <tbody>
                    <tr>
                        <td>
                        <figure>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" style="background:#fcfcfc;width:560px;margin:10px 20px;">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top">
                                    
                                        <table align="center" border="0" style="font-size: .8rem;" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td style="width: 53.33%; font-size: .8rem;padding: 10px 50px;">
                                                     <img alt="XpressLaundroMat" src="<?php echo 
													"http://xpresslaundromat.in/assets/img/logo.png";?>" title="XpressLaundroMat" width="100%"><br>
                                                    <br><?=$college_name?><br>
                                                    <?=  nl2br($college_address)?><br>
                                                   
                                                    Ph: +91-<?=$phone ?><br>
                                                    Email: <?=$college_email?><br> 
                                                </td>
                                                <td style="width: 46.66%"><br>
                                                    GSTIN No. :<?=$sc_GST_Number?><br>
<!--                                                    Service Tax Category: <br>
                                                    Pan No:-->
                                                </td>
                                            </tr>
                                            <tr style="background: #FEFCEC">
                                                <td style="width: 53.33%;padding: 10px 50px;">
													<?php $clg=explode(" ",$college_name);
													$f3=substr($clg[0], 0, 3);
													?>
                                                    Bill of Service No: <?=date("mdy",strtotime($book_date)).strtoupper($f3).substr($clg[1], 0, 1).$order_no?><br>
                                                    Order Number: <?=$order_no?>
                                                </td>
                                                <td style="width: 46.66%">
                                                    Book Date: <?=$book_date?><br>
                                                    Order Date: <?=$order_date?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                            <table align="center" border="0" style="font-size: .8rem;width: 100%" cellpadding="0" cellspacing="0"><tbody>
                                            <tr>
                                                <td colspan="2" style="height: 6px">
                                                    
                                                </td>
                                            </tr>
                                            
                                            <tr style="background: #F7ECF4">
                                                <td style="width: 64%;padding: 10px 50px;">
                                                    Service Receivers Name: <b><?=$customer_name?></b>
                                                </td>
                                                <td style="width: 36%">Mobile No: <b><?=$mobile?></b></td>
                                            </tr>
                                            <tr style="background: #F7ECF4">
                                                <td colspan="2" style="padding: 10px 50px;">
                                                    Service Receivers Address: <b><?=$room_no?>, <?=$hostel_name?></b>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="height: 6px">
                                                    
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                            <table align="center" border="0" style="font-size: .8rem;width: 100%" cellpadding="0" cellspacing="0"><tbody>
                                            <tr style="background: #003fdb">
                                                <td colspan="3" style="text-align: center;color: #fff; padding: 6px;">
                                                    <h3 style="margin: 0px;">Thank you for choosing us!</h3>
                                                    
                                                </td>
                                            </tr>
                                            <tr style="background: #6363FC">
                                                <td style="text-align: center;color: #fff;width: 25%; padding: 10px;">
                                                    <h2 style="margin: 0px;"><?=$no_of_clothes?></h2>
                                                    CLOTHES
                                                    
                                                </td>
                                                 <td style="text-align: center;width: 50%;color: #fff; padding: 6px;">
                                                     <h1 style="margin: 0px;"><?=  strtoupper($washtype)?></h1>
                                                    
                                                </td>
                                                 <td style="text-align: center;color: #fff;width: 25%; padding: 6px;">
                                                     <h2 style="margin: 0px;"><?=$weight?></h2>kg<br>WEIGHT
                                                    
                                                </td>
                                            </tr>
                                            <tr style="background:  #003fdb">
                                                <td colspan="3" style="height: 20px;">
                                                    
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table align="center" style="margin-top: 20px; width: 100%;padding: 20px;" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align:top">
                                                    Description
                                                </td>
                                                <td style="vertical-align:top">
                                                
                                                </td>
                                                <td style="vertical-align:top; text-align: right;">
                                                    Amount(INR)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px dashed #666;height: 10px;" colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <table align="center" style="margin-top: 20px; width: 100%" border="0" cellpadding="0" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="border-bottom: 1px solid #666;text-align: center; padding: 10px;">Particular</th>
                                                                <th style="border-bottom: 1px solid #666;text-align: center; padding: 10px;">Qty</th>
                                                                <th style="border-bottom: 1px solid #666;text-align: center; padding: 10px;">Rate</th>
                                                                <th style="border-bottom: 1px solid #666;text-align: center; padding: 10px;">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                if($order_type==1)
                                                                {
                                                                    $bdata =[];
                                                                    $bdata['quantity'] = $weight.'kg'; 
																	$bdata['rate']= $settings['sc_bulk_price_fold'];
																	if($iron=='1')
																	{
																		
																		$bdata['rate']= $settings['sc_bulk_price'];
																		
																	}
                                                                    $bdata['cost'] = $order_amount+$extra_amt;
                                                                    $data = [$bdata];
                                                                }elseif($order_type==4)
                                                                {
                                                                    $bdata =[];
                                                                    $bdata['quantity'] = $order_data[0]['quantity'];
																	if($iron=='1')
																	{
																		$bdata['rate']= $order_data[0]['singlePrice'];
																	}
																	else
																	{
																		$bdata['rate']= $order_data[0]['singlePrice']-$settings['iron_price'];
																	}
                                                                    $bdata['cost'] = $bdata['rate']*$bdata['quantity'];
                                                                    $data = [$bdata];
                                                                }else{
                                                                    $data = $order_data;
                                                                }
                                                                $o_total = 0;
                                                                   foreach($data as $washdata){ 
                                                                       $check=TRUE;
                                                                       if($order_type!=1)
                                                                       {
                                                                           $check = $washdata['quantity']>0;
                                                                       }
                                                                       if($check){
                                                                           $o_total +=$washdata['cost'];
                                                                        ?>
															<?php if($order_type==4 && $iron=='1'){?>				
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Iron</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['quantity']?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['rate']?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['cost']?></td>
                                                            </tr>
															<?php } else {?>
															 <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$order_type==1 || $order_type==4?'Wash':$washdata['item']?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['quantity']?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['rate']?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['cost']?></td>
                                                            </tr>
															
                                                            <?php } } }?>
															<?php if($order_type==4){ if($iron!='1'){?>		   
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Iron</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_qty?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_rate?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_amount?></td>
                                                            </tr>
															<?php } } else { if($iron_qty>0){?>
															 <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Iron</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_qty?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_rate?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_amount?></td>
                                                            </tr>
															<?php } }?>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Pick Drop</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">1</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$pick_rate?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$pick_cost?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">SGST</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$sc_SGST+$other_sc_SGST?></td>
                                                            </tr>
															<tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">CGST</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$sc_CGST+$other_sc_CGST?></td>
                                                            </tr>
															<tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">IGST</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$sc_IGST+$other_sc_IGST?></td>
                                                            </tr>
															
															
                                                            <?php if($coupon_applied){?>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Total</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=round($o_total+$pick_cost+$iron_amount+$sc_SGST+$sc_CGST+$sc_IGST+$other_sc_SGST+$other_sc_CGST+$other_sc_IGST+$extra_amount_for_adjustment)?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Coupon Applied</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$coupon_applied?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">-<?=$discount+$other_discount?></td>
                                                            </tr>
                                                            <?php }?>
															
															 <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Any Additional Amount / Discount</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$extra_amount_for_adjustment?></td>
                                                            </tr>
                                                            <?php if($ironed>0){?>
								<tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Items Ironed</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_rate?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$ironed?></td>
                                                               </tr>
								 <?php }?>							<tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Comments</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$comment?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;border-bottom: 1px solid #666; padding: 18px; height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Total</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=round($total)?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" style="text-align: center; font-size: .6rem; padding: 20px;">
                                                                    Note: This is an electronically generated Bill of Service and does not require a physical signature.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;  padding: 20px;">
                                                                    <a href="#" style="padding: 10px 30px; background: #00ADEE;color: #fff;text-decoration: none;">Rate Us</a> 
                                                                    <a href="<?=BASE?>contact" style="padding: 10px 30px; background: #F6921E;color: #fff;text-decoration: none;">Give Us a Feedback</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                       
                        </td>
                    </tr>
                </tbody>
            </table>
            </figure>
            </td>
        </tr>
    </tbody>
</table>