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
                <div class="col-sm-4 text-center"><img src="<?=BASE?>assets/img/logo.png" style="width: 100%" /><br><b><?=$order->college_name?></b></div>
                <div class="col-sm-4" style="height: 70px;">Slot: <?=$slot[$order->book_slot]?></div>
                <div class="col-sm-4"><div class="col-sm-10 col-sm-offset-1 text-center" style="background: #eaeaea; height: 70px; border: 1px solid #ccc"><h3 class="col-sm-12" style="margin-top: 10px;">TOKEN NO</h3></div></div>
            <div class="col-sm-12" style="background: #eaeaea; padding: 5px; text-align: center;font-weight: bold;text-transform: uppercase">Order Slip</div>
            <div class="col-sm-12" style="margin:5px 0px; padding: 0px; ">
                <div class="col-sm-6" style="padding: 0px;">
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Name </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->firstname.' '.$order->lastname?></div></div>
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Roll number </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->roll_no?></div></div>
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Phone </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->phone_no?></div></div>
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Hostel </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->hostel_name?></div></div>
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Room </div><div class="col-sm-8" style="margin:2px 0px;">: <?=$order->room_no?></div></div>
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Payment type </div><div class="col-sm-8" style="margin:2px 0px;">: 
                        <?php
                        if($order->payment_type == 1)
                            echo "<span style='font-size:15px;'><b>Online</b></span>";
                        else
                            echo "<span style='font-size:15px;'><b>COD</b></span>";
                        ?>
                    </div></div>
                </div>
                <div class="col-sm-6" style="padding: 0px;">
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Order Date </div><div class="col-sm-6">: <?=$order->book_date?></div></div>
                    <div class="col-sm-12" style="padding: 0px;"><div class="col-sm-4" style="margin:2px 0px;">Order No </div><div class="col-sm-6">: <?=$order->id?></div></div>
                    <div class="col-sm-12" style="padding: 0px;margin:5px 0px;">
                        <div class="col-sm-4" style="padding-top: 10px;">Weight :</div><div class="col-sm-6"><input class="form-control" style="height: 30px;" value="&nbsp;&nbsp;&nbsp;&nbsp;" disabled="" /></div>
                    </div>
                    <div class="col-sm-12" style="padding: 0px;margin:5px 0px;">
                    <div class="col-sm-4" style="padding-top: 10px;">Clothes :</div><div class="col-sm-6"><input class="form-control" style="height: 30px;" value="&nbsp;&nbsp;&nbsp;&nbsp;" disabled="" /></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="margin-bottom:10px; padding: 0px;">
                <?php $washtype = [1=>'Bulk Wash',2=>'Premium Wash',3=>'Dry Cleaning',4=>'Individual Wash']?>
                <div class="col-sm-12 text-center" style="background: #eaeaea; padding:5px 10px; border: 1px solid #ddd7d7;font-weight: bolder;"><?=  strtoupper($washtype[$order->order_type])?></div>

            </div>
            <div class="col-sm-12" style="margin-bottom:10px; padding: 0px; border-bottom: 3px solid #ccc;">
                <div class="col-sm-6" style="padding: 0px;">
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-2">Shirt </div><div class="col-sm-10">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-2">T-shirt  </div><div class="col-sm-10">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-2">Kurta  </div><div class="col-sm-10">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-2">Tops  </div><div class="col-sm-10">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-2">Socks </div><div class="col-sm-10">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-2">Towels </div><div class="col-sm-10">: _______________</div></div>
                </div>
                <div class="col-sm-6" style="padding: 0px;">
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Pants / Jeans </div><div class="col-sm-8">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Lowers </div><div class="col-sm-8">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Shorts </div><div class="col-sm-8">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Undergarments </div><div class="col-sm-8">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Bedsheets </div><div class="col-sm-8">: _______________</div></div>
                    <div class="col-sm-12" style="margin:5px 0px;"><div class="col-sm-4">Others </div><div class="col-sm-8">: _______________</div></div>
                </div>
            </div>
            <div class="col-sm-12" style="margin-bottom:10px; height: 100px;">
                <div class="col-sm-6 text-center">Customer Signature</div>
                <div class="col-sm-6 text-center">Checked By</div>
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
