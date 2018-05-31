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
                                                    <img alt="XpressLaundroMat" src="<?=BASE?>assets/img/logo.png" title="XpressLaundroMat" width="100%"><br>
                                                    <br><?=$college_name?><br>
                                                    <?=  nl2br($college_address)?><br>
                                                    <?php $phone = explode(',', $college_phone);?>
                                                    Ph: +91-<?=$phone[0]?><?=$phone[1]!=''?'+91-'.$phone[1]:'' ?><br>
                                                    Email: <?=$college_email?><br> 
                                                </td>
                                                <td style="width: 46.66%"><br>
                                                    GSTIN No. :<?=$college_service?><br>
<!--                                                    Service Tax Category: <br>
                                                    Pan No:-->
                                                </td>
                                            </tr>
                                            <tr style="background: #FEFCEC">
                                                <td style="width: 53.33%;padding: 10px 50px;">
                                                    Bill of Service No: <?=$invoice_id?><br>
                                                    Order Number: <?=$order_no?>
                                                </td>
                                                <td style="width: 46.66%">
                                                    Bill of Service Date: <?=$invoice_date?><br>
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
                                                                    $bdata['rate']= $settings['sc_bulk_price'];
                                                                    $bdata['cost'] = $order_amount+$extra_amt;
                                                                    $data = [$bdata];
                                                                }elseif($order_type==4)
                                                                {
                                                                    $bdata =[];
                                                                    $bdata['quantity'] = $order_data[0]['quantity']; 
                                                                    $bdata['rate']= $order_data[0]['cost'];
                                                                    $bdata['cost'] = $order_data[0]['cost']*$order_data[0]['quantity'];
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
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$order_type==1 || $order_type==4?'Wash':$washdata['item']?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['quantity']?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['rate']?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$washdata['cost']?></td>
                                                            </tr>
                                                                       <?php }}?>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Iron</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_qty?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_rate?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$iron_amount?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Pick Drop</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">1</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$pick_rate?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$pick_cost?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">GST</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$gst?></td>
                                                            </tr>
                                                            <?php if($coupon_applied){?>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Total</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$o_total+$pick_cost+$iron_amount?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Coupon Applied</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$coupon_applied?></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">-<?=$discount?></td>
                                                            </tr>
                                                            <?php }?>
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;border-bottom: 1px solid #666; padding: 18px; height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"></td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;">Total</td>
                                                                <td style="text-align: center;border-bottom: 1px solid #666; padding: 10px;"><?=$total?></td>
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