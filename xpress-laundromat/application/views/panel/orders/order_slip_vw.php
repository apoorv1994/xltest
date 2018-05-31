<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Order Slip</title>       
        <link href="<?=BASE?>admin/css/order-slip.css" rel="stylesheet" />
    </head>
    <body>
<div class="book">
    <?php 

        $total_order = count($orders);
        $i=3;
        foreach($orders as $order)
        {

    ?>
    <div class="page">
           <?php $slot = [1=>'Morning',2=>'Afternoon',3=>'Evening',4=>'Night'];?>
        
    
        <div class="subpage">
            <div class="row">
                <div class="col-sm-8 text-center" style="border: 1px solid black; height: 80px">
                    <div class="col-sm-12" style="margin-bottom: 10px; margin-top: 10px "><img  src="<?=BASE?>assets/img/logo.png" style="width: 25%" /></div>
                  
                    <div class="col-sm-2">UNIT:</div>
                    <div class="col-sm-8" style="text-align: left;"><b><?=$order->college_name?></b></div>
                </div>
                <div class="col-sm-4" style="border: 1px solid black; height: 80px">
                    <p>Token Number</p>
                </div>
                <div class="col-sm-12 text-center" style="border: 1px solid black; background: #e4e4e4">
                    <h4 style="margin: 5px;">Order Slip</h4>
                </div>
                <div class="col-sm-8" style="border: 1px solid black; height: 80px">
                    <div class="col-sm-6" style="padding: 0px;">
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Name </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->firstname.' '.$order->lastname?></div></div>
                   
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Phone </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->phone_no?></div></div>
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Hostel </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->hostel_name?></div></div>
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Room </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->room_no?></div></div>
                
                    </div>
                    <div class="col-sm-6" style="padding: 0px;">
                        <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-6" style="margin:2px 0px;">Order Date </div><div class="col-sm-6">: <?=$order->book_date?></div></div>
                        <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-6" style="margin:2px 0px;">Pickup Slot </div><div class="col-sm-6">: <?=$slot[$order->book_slot]?></div></div>
                        <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-6" style="margin:2px 0px;">Joint Order </div><div class="col-sm-6">:  ________</div></div>
                      <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-6" style="margin:2px 0px;">Payment type </div><div class="col-sm-6" style="margin:2px 0px;">: 
                            <?php
                            if($order->payment_type == 1)
                                echo "<span style='font-size:15px;'><b>Online</b></span>";
                            else
                                echo "<span style='font-size:15px;'><b>COD</b></span>";
                            ?>
                        </div></div>
                    </div>
                </div>
                <div class="col-sm-4" style="border: 1px solid black; height: 40px">
                    <p>Weight</p>
                </div>
                <div class="col-sm-4" style="border: 1px solid black; height: 40px">
                    <p>No of clothes</p>
                </div>
                
                 <?php $washtype = [1=>'Bulk Wash',2=>'Premium Wash',3=>'Dry Cleaning',4=>'Individual Wash',10=>'Bulk Wash & Fold',20=>'Premium Wash',30=>'Dry Cleaning',40=>'Individual Wash',11=>'Bulk Wash & Iron',21=>'Premium Wash',31=>'Dry Cleaning',41=>'Individual Iron',42=>'Individual Wash']?>
                <div class="col-sm-8 text-center" style="border: 1px solid black; background: #e4e4e4"> <h4 style="margin: 5px;">SERVICE TYPE: <?=  strtoupper($washtype[$order->order_type.$order->iron])?></h4>
                </div>
                <div class="col-sm-4" style="border: 1px solid black; background: #e4e4e4"> <h4 style="margin: 5px;">Customer Note:</h4>
                </div>
            
                <!-- for bulk wash  and individual wash-->
                 <?php if($order->order_type == 1 || $order->order_type == 4){?>
                <div class="col-sm-8" style="border: 1px solid black; height: 200px;">
                    <div class="col-sm-6" style="padding: 0px;">
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Shirt </div><div class="col-sm-8">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">T-shirt  </div><div class="col-sm-8">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Tops  </div><div class="col-sm-8">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Towels  </div><div class="col-sm-8">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Kurta </div><div class="col-sm-8">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Socks </div><div class="col-sm-8">: _______________</div></div>
                    </div>
                    <div class="col-sm-6" style="padding: 0px;">
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Pants</div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Lowers </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Shorts </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Undergarments </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Bedsheets </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Others </div><div class="col-sm-5">: _______________</div></div>
                    </div>
                </div>
                  <?php }?>


                 <!-- for premium  wash -->
                  <?php if($order->order_type == 2){?>
                <div class="col-sm-8" style="border: 1px solid black; height: 200px;">
                    <div class="col-sm-6" style="padding: 0px;">
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Shirt/T-shirt </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Ladies Top </div><div class="col-sm-5">: _______________</div></div>
                        
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Kurta  </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Seatshirt / Sweeter  </div><div class="col-sm-5">: _______________</div></div>
                         <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Pants / Trousers</div><div class="col-sm-5">: _______________</div></div>
                       
                    </div>
                    <div class="col-sm-6" style="padding: 0px;">
                       
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Towel </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Curtains </div><div class="col-sm-5">: _______________</div></div>
                        
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Bedsheets </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Others </div><div class="col-sm-5">: _______________</div></div>
                    </div>
                </div>
                <?php }?>

                <!-- for dry clean  -->
                <?php if($order->order_type == 3){?>
                <div class="col-sm-8" style="border: 1px solid black; height: 200px">
                    <div class="col-sm-6" style="padding: 0px;">
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Shirt / T-shirt </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Pants / Trousers</div><div class="col-sm-5">: _______________</div></div>
                       
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Shawl / Stole  </div><div class="col-sm-5">: _______________</div></div>
                        
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Kurta  </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Sarees</div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Blazers / Jackets</div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Suit (2 Pc.)</div><div class="col-sm-5">: _______________</div></div>
                         
                    </div>
                    <div class="col-sm-6" style="padding: 0px;">
                       
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Sweater / Sweat Shirt </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Quilt / Single Blanket </div><div class="col-sm-5">: _______________</div></div>
                        
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Curtains </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Blanket (double) </div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Ladies Dress</div><div class="col-sm-5">: _______________</div></div>
                        <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-6">Other</div><div class="col-sm-5">: _______________</div></div>
                    </div>
                </div>
                 <?php }?>
               
               
                
                <div class="col-sm-4" style="border: 1px solid black; height: 80px"> 
                </div>
                 <div class="col-sm-4" style="border: 1px solid black; background: #e4e4e4"> <h4 style="margin: 5px;">Office Note:</h4>
                </div>
                <div class="col-sm-4" style="border: 1px solid black; height: 94px"> 
                </div>
                 <div class="col-sm-4" style="border: 1px solid black; background: #e4e4e4"> <h4 style="margin: 5px;">Pickup:</h4>
                </div>
                
                 <div class="col-sm-2" style="border: 1px solid black; background: #e4e4e4"> <h4 style="margin: 5px;">QC Remark:</h4>
                </div>
                 <div class="col-sm-2" style="border: 1px solid black; background: #e4e4e4"> <h4 style="margin: 5px;">Delivery:</h4>
                </div> 
                <div class="col-sm-4" style="border: 1px solid black; background: #e4e4e4"> <h4 style="margin: 5px;">Customer Signature:</h4>
                </div>
                <div class="col-sm-4" style="border: 1px solid black; height: 60px"> 
                </div>
                <div class="col-sm-2" style="border: 1px solid black; height: 60px"> 
                </div>
                <div class="col-sm-2" style="border: 1px solid black; height: 60px"> 
                </div>
                <div class="col-sm-4" style="border: 1px solid black; height: 60px"> 
                </div>
            </div>
            
        </div>
    </div>
        <?php  $i++;}?>
</div>
        <script>
            setTimeout(function(){window.print()},1000);
//        (function () {
//            var afterPrint = function () {
//                window.close();
//            };
//
//            if (window.matchMedia) {
//                var mediaQueryList = window.matchMedia('print');
//
//                mediaQueryList.addListener(function (mql) {
//                    if (mql.matches) {
//                        //beforePrint();
//                    } else {
//                        afterPrint();
//                    }
//                });
//            }
//
//            //window.onbeforeprint = beforePrint;
////            window.onafterprint = afterPrint;
//
//        }());
        </script>
        </body>
</html>
