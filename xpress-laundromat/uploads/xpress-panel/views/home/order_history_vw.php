<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding ">
<?php $this->load->view('home/wallet_vw');?>
    <div class="col-xs-12 col-sm-12 no-padding margin-top-60">
    <div class="container  margin-bottom-60 margin-top-60 padding-bottom-20">
        <?php if($this->session->flashdata('error')){?>
        <div class="col-xs-12 col-sm-12 alert alert-danger"><?=$this->session->flashdata('error')?></div>
        <?php } ?>
        <div class="col-xs-12 col-sm-12 no-padding" id="historyTbl">
            <h3 class="col-xs-12 col-sm-12">Recent Order Details</h3>
            
            <table class="table table-responsive">
                <thead>
                <th>Sl. No.</th>
                <th>Order ID</th>
                <th>Wash Type</th>
                <th>Slot Date / Time</th>
                <th>Slot Type</th>
                <th>Status</th>
                <th>Total Bill</th>
                </thead>
                <tbody>
                    <?php
                    $wash = [1=>'Bulk Wash',2=>'Premium Wash',3=>'Dry Cleaning',4=>'Individual Wash'];
                    if($recent_order){ $i=1;
                        foreach($recent_order as $order)
                        {?>
                    <tr>
                        <td><span title="View Details" class="vdetail" style="cursor: pointer; margin-right: 10px;" data-id="<?=$order->id?>"><i class="fa fa-plus"></i></span> <?=$i++?></td>
                        <td>#<?=$order->id?></td>
                        <td><?=$wash[$order->order_type]?></td>
                        <td><?=date('d-m-Y',$order->book_date)?> /  <?=date('h:i A',strtotime($slots[$order->book_slot]))?>  </td>
                        <td>
                            <?php 
                            switch($order->book_slot)
                            {
                                case 1:
                                    echo 'Morning';
                                    break;
                                case 2:
                                    echo 'Afternoon';
                                    break;
                                case 3:
                                    echo 'Evening';
                                    break;
                                case 4:
                                    echo 'Night';
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            switch ($order->status)
                            {
                                case 1:
                                    echo 'Order Received';break;
                                case 2:
                                    echo 'Order processed';break;
                                case 3:
                                    echo 'Clothes collected';break;
                                case 4:
                                    echo 'Out/Ready for Delivery';break;
                            }
                            ?>
                        </td>
                        <td><i class="fa fa-inr"></i> <?php if($order->final_amount){echo $order->final_amount.' <a href="'.BASE.'home/view-invoice/'.$order->id.'"  style="float:right;">View Invoice</a>';}else{echo $order->total_amount-$order->discount;}?></td>
                    </tr>
                    <tr class="toggle" id="detail_<?=$order->id?>">
                                    <td colspan="7">
                                        <div class="col-xs-12 col-sm-12" style="border-bottom: 1px solid; padding-top: 15px; padding-bottom: 15px;">
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="col-xs-6 col-sm-6">
                                                    <b>Order Type</b>
                                                </div>
                                                <div class="col-xs-6 col-sm-6">
                                                    <?=$wash[$order->order_type]?>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="col-xs-6 col-sm-6">
                                                    <b>Order Date</b>
                                                </div>
                                                <div class="col-xs-6 col-sm-6">
                                                    <?=date('d-m-Y',$order->created)?>
                                                </div>
                                            </div>
                                             </div>
                                        <div class="col-sm-12">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Items</th>
                                                    <th>Quantity</th>
                                                    <th>Total Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $totalprice=$price=0;foreach($order->items as $items){
                                                $check=TRUE;
                                                if($order->order_type!=1)
                                                {
                                                    $check=$items->quantity>0;
                                                }
                                                if($check){?>
                                                <tr>
                                                    <td>
                                                        <label><?=$items->items?></label>
                                                    </td>
                                                    <td>
                                                        <?=$items->quantity?>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-inr"></i> <?=$order->order_type!=1?$price=$items->cost*$items->quantity:$price=$items->cost?>
                                                        <?php $totalprice +=$price;?>
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                                <?php if($order->coupon_applied){?>
                                                <tr>
                                                    <td></td>
                                                    <td><b>Total</b></td>
                                                    <td><i class="fa fa-inr"></i> <?=$totalprice?></td>
                                                </tr>
                                                <tr>
                                                    <td>Coupon code <b><?=$order->coupon_applied?></b> applied</td>
                                                    <td>Discount Amount</td>
                                                    <td class="success"> - <i class="fa fa-inr"></i> <?=$order->discount?></td>
                                                </tr>
                                                <?php }?>
                                                <tr>
                                                    <td></td>
                                                    <td><b>Total</b></td>
                                                    <td><i class="fa fa-inr"></i> <?=$totalprice-$order->discount?></td>
                                                </tr>
                                        </tbody>
                                       </table>
                                        </div>
                                    </td>
                                </tr>
                      <?php  }
                    }else{?>
                    <tr>
                        <td colspan="7">No order found</td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="upinfo">
                <a class="form-control loginbtn" href="javascript:void(0)" id="showhistory" title="Update Info">View Order History <i class="fa fa-arrow-right pull-right" id="loader_log"></i></a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 no-padding" id="order_history">
            <h3 class="col-xs-12 col-sm-12">Order History</h3>
            
            <table class="table table-responsive">
                <thead>
                <th>Sl. No.</th>
                <th>Order ID</th>
                <th>Wash Type</th>
                <th>Pickup Date</th>
                <th>Pickup Time</th>
                <th>Slot Type</th>
                <th>Status</th>
                <th>Total Bill</th>
                </thead>
                <tbody>
                    <?php if($order_history){ $i=1;
                        foreach($order_history as $order)
                        {?>
                    <tr>
                        <td><span title="View Details" class="vdetail1" style="cursor: pointer; margin-right: 10px;" data-id="<?=$order->id?>"><i class="fa fa-plus"></i></span> <?=$i++?></td>
                        <td>#<?=$order->id?></td>
                        <td><?=$wash[$order->order_type]?></td>
                        <td><?=date('d-m-Y',$order->book_date)?>  </td>
                        <td><?=date('h:i A',strtotime("+15 minutes",strtotime($slots[$order->book_slot])))?></td>
                        <td>
                            <?php 
                            switch($order->book_slot)
                            {
                                case 1:
                                    echo 'Morning';
                                    break;
                                case 2:
                                    echo 'Afternoon';
                                    break;
                                case 3:
                                    echo 'Evening';
                                    break;
                                case 4:
                                    echo 'Night';
                                    break;
                            }
                            ?>
                        </td>
                        <td><?php 
                            switch ($order->status)
                            {
                                case 1:
                                    echo 'Order Received';break;
                                case 2:
                                    echo 'Order processed';break;
                                case 3:
                                    echo 'Clothes collected';break;
                                case 4:
                                    echo 'Out/Ready for Delivery';break;
                                case 5:
                                    echo 'Delivered';break;
                                case 4:
                                    echo 'Cancelled';break;
                            }
                            ?></td>
                        <td><i class="fa fa-inr"></i> <?php if($order->final_amount){echo $order->final_amount.' <a href="'.BASE.'home/view-invoice/'.$order->id.'" style="float:right;">View Invoice</a>';}else{echo $order->total_amount;}?></td>
                    </tr>
                    <tr class="toggle1" id="detail1_<?=$order->id?>">
                                    <td colspan="8">
                                        <div class="col-xs-12 col-sm-12" style="border-bottom: 1px solid; padding-top: 15px; padding-bottom: 15px;">
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="col-xs-6 col-sm-6">
                                                    <b>Order Type</b>
                                                </div>
                                                <div class="col-xs-6 col-sm-6">
                                                    <?=$wash[$order->order_type]?>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="col-xs-6 col-sm-6">
                                                    <b>Order Date</b>
                                                </div>
                                                <div class="col-xs-6 col-sm-6">
                                                    <?=date('d-m-Y',$order->created)?>
                                                </div>
                                            </div>
                                             </div>
                                        <div class="col-sm-12">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Items</th>
                                                    <th>Quantity</th>
                                                    <th>Total Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $totalprice=$price=0;foreach($order->items as $items){
                                                $check=TRUE;
                                                if($order->order_type!=1)
                                                {
                                                    $check=$items->quantity>0;
                                                }
                                                if($check){?>
                                                <tr>
                                                    <td>
                                                        <label><?=$items->items?></label>
                                                    </td>
                                                    <td>
                                                        <?=$items->quantity?>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-inr"></i> <?=$order->order_type!=1?$price=$items->cost*$items->quantity:$price=$items->cost?>
                                                        <?php $totalprice +=$price;?>
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                                <?php if($order->coupon_applied){?>
                                                <tr>
                                                    <td></td>
                                                    <td><b>Total</b></td>
                                                    <td><i class="fa fa-inr"></i> <?=$totalprice?></td>
                                                </tr>
                                                <tr>
                                                    <td>Coupon code <b><?=$order->coupon_applied?></b> applied</td>
                                                    <td><b>Discount Amount</b></td>
                                                    <td class="success"> - <i class="fa fa-inr"></i> <?=$order->discount?></td>
                                                </tr>
                                                <?php }?>
                                                <tr>
                                                    <td></td>
                                                    <td><b>Total</b></td>
                                                    <td><i class="fa fa-inr"></i> <?=$totalprice-$order->discount?></td>
                                                </tr>
                                        </tbody>
                                       </table>
                                        </div>
                                    </td>
                                </tr>
                      <?php  }
                    }else{?>
                    <tr>
                        <td colspan="8">No order found</td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function(){
               $('.vdetail').click(function(){
            var id = $(this).data('id');         
            $('i','.vdetail').removeClass('fa-minus').addClass('fa-plus');
            $('i',this).removeClass('fa-plus').addClass('fa-minus');
            if($('#detail_'+id).css('display')=='none')
            {
                $('.toggle').hide();
                $('#detail_'+id).show();
            }else{
                $('i','.vdetail').removeClass('fa-minus').addClass('fa-plus');
                $('#detail_'+id).hide();
            }
            
        })
        
           $('.vdetail1').click(function(){
            var id = $(this).data('id');         
            $('i','.vdetail1').removeClass('fa-minus').addClass('fa-plus');
            $('i',this).removeClass('fa-plus').addClass('fa-minus');
            if($('#detail1_'+id).css('display')=='none')
            {
                $('.toggle1').hide();
                $('#detail1_'+id).show();
            }else{
                $('i','.vdetail').removeClass('fa-minus').addClass('fa-plus');
                $('#detail1_'+id).hide();
            }
            
        })
       $('#showhistory').click(function(){
           $('#order_history').show();
       }) 
    });
    </script>