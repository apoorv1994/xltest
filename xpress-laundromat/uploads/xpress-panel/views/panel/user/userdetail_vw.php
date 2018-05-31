<!-- Page Heading -->
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           User
                        </h1>
                        <ol class="breadcrumb">
                           <li><a href="<?=BASE?>panel/home"><i class="fa fa-home"></i></a></li>
                           <li><a href="<?=BASE?>panel/user">User</a></li>
                           <li class="active">User Details</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
 
        
        
        <div class="row">
            <?php if($msg){?>
    <div class="alert alert-success fade in ">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       <?=$msg?>
    </div>
    <?php }?>
    <?php if($error){?>
    <div class="alert alert-danger fade in ">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       <?=$error?>
    </div>
    <?php }?>
            <div class="col-lg-12">
                <div class="panel panel-green ">
                    <div class="panel-heading green white ">
                        <h4>User Details<button class="btn btn-danger pull-right" onclick="load_walllet_modal(<?=$details->id?>)"><i class="fa fa-plus"></i> Wallet</button>
                        <button class="btn btn-warning pull-right" onclick="load_update_modal(<?=$details->id?>)"><i class="fa fa-plus"></i> Update User</button>
                        </h4>
                    </div>
                    <div class="panel-body">

                    <div class="col-lg-6">
                        <div class="col-sm-12 no-pad">
                            <div class="col-xs-11 col-md-5">
                            <strong>Student ID </strong>
                            </div>
                            <div class="col-xs-1"><strong>:</strong></div>
                            <div class="col-xs-12 col-md-5"><?=$details->id?> </div>
                        </div>
                        <div class="col-sm-12 no-pad">
                            <div class="col-xs-11 col-md-5">
                            <strong>Name </strong></div>
                            <div class="col-xs-1"><strong>:</strong></div>
                            <div class="col-xs-12 col-md-5"><?=$details->firstname.' '.$details->lastname?></div> 
                        </div>
                        <div class="col-sm-12 no-pad">
                            <div class="col-xs-11 col-md-5">
                            <strong>Roll No.  </strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5"><?=$details->roll_no?></div> <br>
                        </div>
                        <div class="col-sm-12 no-pad">
                            <div class="col-xs-11 col-md-5">
                            <strong>Gender    </strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5"><?=$details->gender==1?'Male':'Female'?></div> <br>
                        </div>
                        <div class="col-sm-12 no-pad">
                            <div class="col-xs-11 col-md-5">
                            <strong>Email ID  </strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5"><?=$details->email_id?> </div><br>
                        </div>
                        <div class="col-sm-12 no-pad">
                            <div class="col-xs-11 col-md-5">
                            <strong>Phone No.  </strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5"><?=$details->phone_no?></div> <br>
                        </div>       
                    </div>
                    <div class="col-lg-6">
                            <div class="row">
                                <div class="col-sm-12 no-pad">
                    <div class="col-xs-11 col-md-5"><strong>Wallet Amount(Rs.)</strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5"><strong> </strong><span style="color:<?=$details->wallet_balance<=0?'red':'green'?>"><?=$details->wallet_balance?><span></span></span></div>
                                </div>
                                <div class="col-sm-12 no-pad">
                    <div class="col-xs-11 col-md-5"><strong>Hostel</strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5"><strong> </strong><?=$details->hostel_name?></div>
                                </div>
                                <div class="col-sm-12 no-pad">
                    <div class="col-xs-11 col-md-5"><strong>Room No</strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5"><strong> </strong><?=$details->room_no?></div>
                                </div>
                                <div class="col-sm-12 no-pad">
                    <div class="col-xs-11 col-md-5">
                    <strong>Registration Date  </strong></div><div class="col-xs-1"><strong>:</strong></div><strong> </strong><div class="col-xs-12 col-md-5"><?=date('d-m-Y H:s A',$details->created)?></div>
                                </div>
                                <div class="col-sm-12 no-pad">
                    <div class="col-xs-11 col-md-5"><strong>College Name </strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5"><strong> </strong><?=$details->college_name?></div>
                                </div>
                                <div class="col-sm-12 no-pad">
                    <div class="col-xs-11 col-md-5"><strong>Status</strong></div><div class="col-xs-1"><strong>:</strong></div><div class="col-xs-12 col-md-5 dropdown"> 
                                    <button class="btn <?=$details->status==1?'btn-success':'btn-danger'?> dropdown-toggle" type="button" data-toggle="dropdown"> <?=$details->status==1?'Active':'Inactive'?>
                    <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="<?=BASE?>panel/user/user-status/<?=$details->id?>/1">Active</a></li>
                        <li><a href="<?=BASE?>panel/user/user-status/<?=$details->id?>/2">Inactive</a></li>
                      </ul>
                                    </div>
                                </div>
                    </div>
                    </div>
                        <div class="col-sm-12 margin-top-10">
                            <p class="col-sm-12" style="font-weight: bold">NO OF DAYS SINCE LAST ORDER : <?php if($last_order){
                                    $diff = time()-$last_order;
                                    echo floor($diff/(3600*24)).' Days';
                                }
                            else{
                                echo 'No any order placed till now.';
                            }?></p>
<!--                            <p class="col-sm-6">Last Order Date: <?=$last_order?date('d-m-Y',$last_order):'NA'?>
                                </p>-->
                        </div>
                    </div>
                </div>
                
                
                <div class="panel panel-green ">
                    <div class="panel-heading green white ">
                    <h4>Order History</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                            <th>Sl. No.</th>
                            <th>Order ID</th>
                            <th>Pickup Date</th>
                            <th>Pickup Time</th>
                            <th>Slot Type</th>
                            <th>Status</th>
                            <th>Payment Type</th>
                            <th>Total Bill</th>
                            </thead>
                            <tbody>
                                <?php if($order_history){ $i=1; $sum = 0; $cod=0;$online=0;
                                    foreach($order_history as $order)
                                    {?>
                                <tr>
                                    <td><span title="View Details" class="vdetail" style="cursor: pointer; margin-right: 10px;" data-id="<?=$order->id?>"><i class="fa fa-plus"></i></span> <?=$i++?><?php //echo "<pre>";print_r($order_history);?></td>
                                    <td><?=$order->id?></td>
                                    <td><?=date('d-m-Y',$order->book_date)?>  </td>
                                    <td><?=date('h:i A',  strtotime("+15 minutes",strtotime($slots[$order->book_slot])))?></td>
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
                                        switch($order->status)
                                        {
                                            case "6":
                                                $text = 'Cancelled'; $bclass = 'danger';
                                                break;
                                            case "5":
                                                $text = 'Completed'; $bclass = 'success';
                                                break;
                                            case "1":
                                                $text = 'Order recieved'; $bclass = 'default';
                                                break;
                                            case "2":
                                                $text = 'Order processed'; $bclass='warning';
                                                break;
                                            case "3":
                                                $text ='Clothes collected'; $bclass= 'info';
                                                break;
                                            case "4":
                                                $text = 'Out/Ready for Delivery'; $bclass = 'primary';
                                        }
                                        ?>
                                        <label class="label label-<?=$bclass?>"><?=$text?></label>
                                    </td>
                                    <td>
                                        <?php 
                                         if($order->payment_type ==1)
                                            echo "Online";
                                         if($order->payment_type ==2)
                                            echo "COD";
                                         ?>
                                    </td>
                                    <td><i class="fa fa-inr"></i> <?php
                                        if($order->final_amount)
                                            {
                                                echo $order->final_amount;
                                                
                                                if($order->payment_type==1 && $order->status!=6){
                                                    $online+=$order->final_amount;
                                                    $sum+=$order->final_amount;
                                                }
                                                
                                                else if($order->payment_type==2 && $order->status!=6){
                                                    $cod+=$order->final_amount;
                                                    $sum+=$order->final_amount;

                                                }
                                            }
                                        else
                                            {
                                                echo $order->total_amount;
                                                if($order->payment_type==1 && $order->status!=6){
                                                  
                                                        $online+=$order->total_amount;
                                                $sum+=$order->total_amount;

                                                }
                                                else if($order->payment_type==2 && $order->status!=6){
                                                    $cod+=$order->total_amount;
                                                $sum+=$order->total_amount;
                                                }

                                            }

                                    ?></td>
                                </tr>
                                <tr class="toggle" id="detail_<?=$order->id?>">
                                    <td colspan="7">
                                        <div class="col-sm-12" style="border-bottom: 1px solid; padding-top: 15px">
                                            <div class="col-sm-6">
                                                <div class="col-sm-6">
                                                    <label>Order Type</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?=$booktype[$order->order_type]?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="col-sm-6">
                                                    <label>Order Date</label>
                                                </div>
                                                <div class="col-sm-6">
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
                                                if($order->order_type==1)
                                                {
                                                    $chk_status = TRUE;
                                                }else{
                                                    $chk_status = $items->quantity > 0;
                                                }
                                                if($chk_status){?>
                                                <tr>
                                                    <td>
                                                        <label><?=$items->items?></label>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if($order->order_type==1)
                                                            {
                                                                if($order->no_of_items == null)
                                                                    echo $items->quantity;
                                                                else
                                                                    echo $order->no_of_items;
                                                            }
                                                        else
                                                            echo $items->quantity;?>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-inr"></i> <?=$order->order_type!=1?$price=$items->cost*$items->quantity:$price=$items->cost?>
                                                        <?php $totalprice +=$price;?>
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                                <tr>
                                                    <td></td>
                                                    <td><label>Extra amount</label></td>
                                                    <td><i class="fa fa-inr"></i> <?=$order->extra_amount?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><label>Iron Cost</label></td>
                                                    <td><i class="fa fa-inr"></i> <?php $icost = json_decode($order->iron_cost); echo $icost->total_iron_price;?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><label>Pick Up Cost</label></td>
                                                    <td><i class="fa fa-inr"></i> <?=$order->pickup_cost?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><label>Total</label></td>
                                                    <td><i class="fa fa-inr"></i> <?=$totalprice+$order->extra_amount+$icost->total_iron_price+$order->pickup_cost?></td>
                                                </tr>
                                        </tbody>
                                       </table>
                                        </div>
                                    </td>
                                </tr>
                                  <?php  }
                                  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total (COD):</b></td><td>".$cod."</td></tr>";
                                   echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total (Online):</b></td><td>".$online."</td></tr>";
                                    echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total :</b></td><td>".$sum."</td></tr>";
                                }else{?>
                                <tr>
                                    <td colspan="7">No order found</td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-green ">
                    <div class="panel-heading green white ">
                    <h4>Recharge History</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <h4>Online Recharge</h4>
                            <table class="table table-responsive">
                                <thead>
                                <th>Transaction ID</th>
                                <th>Credited Date</th>
                                <th>Amount</th>
                                </thead>
                                <tbody>
                                    <?php if($online_recharge){ $i=1; $online_r=0;
                                        foreach($online_recharge as $order)
                                        {?>
                                    <tr>
                                        <td><?=$order->transcation_id?></td>
                                        <td><?=date('d-m-Y H:s A',$order->created)?></td>
                                        <td><?php echo $order->amount;$online_r+=$order->amount;?>  </td>
                                    </tr>  
                                      <?php  }
                                      echo "<tr><td></td><td><b>Total</b></td><td>".$online_r."</td></tr>";
                                    }else{?>
                                    <tr>
                                        <td colspan="3">No Recharge found</td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                             <h4>Offline Recharge</h4>
                            <table class="table table-responsive">
                                <thead>
                                <th>Credited By</th>
                                <th>Credited Date</th>
                                <th>Amount</th>
                                </thead>
                                <tbody>
                                    <?php if($offline){ $i=1; $offline_r=0;
                                        foreach($offline as $order)
                                        {?>
                                    <tr>
                                        <td><?=$order->name?></td>
                                        <td><?=date('d-m-Y H:s A',$order->created)?></td>
                                        <td><?php echo $order->amount;$offline_r+=$order->amount;?>  </td>
                                    </tr>  
                                      <?php  }
                                      echo "<tr><td></td><td><b>Total</b></td><td>".$offline_r."</td></tr>";
                                    }else{?>
                                    <tr>
                                        <td colspan="3">No recharge found</td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
                
                <!-- Modal wallet -->
<div class="modal fade" id="wallet_modal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
               Credit Amount
            </h4>
         </div>
          <form id="w_from">
          <div class="modal-body">
              <div class="row">
                  
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Enter Wallet Amount <i class="fa fa-inr"></i> * </label>
                        <div class="col-sm-6">
                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount">
                            <input type="hidden" id="w_user_id" name="user_id">
                            <div id="amount_err"></div>
                        </div>
                    </div>
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">MR No * </label>
                        <div class="col-sm-6">
                            <input type="text" name="transaction_no" class="form-control" placeholder="Enter Money Reciept No">
                            <div id="transaction_no_err"></div>
                        </div>
                    </div>
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Transaction Date </label>
                        <div class="col-sm-6">
                            <input type="text" name="transaction_date" class="form-control" id="tdate">
                            <div id="transaction_date_err"></div>
                        </div>
                    </div>
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Description  </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="description" ></textarea>
                            <div id="description_err"></div>
                        </div>
                    </div>
                  
                  
              </div>
         </div>
         <div class="modal-footer">
             <div id="w_loader" class="col-sm-7 text-right"></div>
             <div class="col-sm-5">
             <button type="button" class="btn btn-primary" id="wBtn">
               Add Amount
            </button>
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">Close
            </button>
             </div>
            
         </div>
              </form>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="user_modal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
               Update user details
            </h4>
         </div>
          <form id="u_form">
          <div class="modal-body">
              <div class="row">
                  
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">First Name  * </label>
                        <div class="col-sm-6">
                            <input type="text" name="firstname" class="form-control" value="<?=$details->firstname?>" placeholder="Enter First Name">
                            <input type="hidden" value="<?=$details->id?>" id="u_user_id" name="u_user_id">
                            <div id="firstname_err"></div>
                        </div>
                    </div>
                <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Last Name  * </label>
                        <div class="col-sm-6">
                            <input type="text" name="lastname" class="form-control" value="<?=$details->lastname?>" placeholder="Enter Last Name">
                            <div id="lastname_err"></div>
                        </div>
                    </div>
                <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Email Id  * </label>
                        <div class="col-sm-6">
                            <input type="email" name="emailid" class="form-control" value="<?=$details->email_id?>" placeholder="Enter Email Id">
                            <div id="emailid_err"></div>
                        </div>
                    </div>
                <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Phone no. * </label>
                        <div class="col-sm-6">
                            <input type="number" name="phone_no" class="form-control" value="<?=$details->phone_no?>" placeholder="Enter Contact no.">
                            <div id="phone_no_err"></div>
                        </div>
                    </div>
                <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Room no.  * </label>
                        <div class="col-sm-6">
                            <input type="text" name="room_no" class="form-control" value="<?=$details->room_no?>" placeholder="Enter Room no.">
                            <div id="room_no_err"></div>
                        </div>
                    </div>
					
					<div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Hostel  * </label>
                        <div class="col-sm-6">
							<select name="hostel_id" class="form-control" id="hostel_id"> 
							<option value="">--select a hostel--</option>
							<?php if(!empty($hostel_details)){ foreach($hostel_details as $v){?>
							<option value="<?php echo $v->id;?>" <?php if($details->hostel_id==$v->id){echo 'selected="selected"';}?> ><?php echo $v->hostel_name;?></option>
							<?php } } ?>
							</select>
                            <div id="hostel_id_err"></div>
                        </div>
                    </div>

                
                  
              </div>
         </div>
         <div class="modal-footer">
             <div id="u_loader" class="col-sm-7 text-right"></div>
             <div class="col-sm-5">
             <button type="button" class="btn btn-primary" id="userBtn">
               Update User
            </button>
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">Close
            </button>
             </div>
            
         </div>
              </form>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


            <script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" ></script>
        <script src="<?=BASE?>assets/plugins/moment/moment.min.js"></script>
<script>
        function load_walllet_modal(id)
    {
       $('#w_user_id').val(id); 
       $('#wallet_modal').modal();
       $('#w_loader').html('');
       $('#amount_err').html('');
    }

    function load_update_modal(id)
    {
        $("#hostel_id").val('<?php echo $details->hostel_id;?>');
        $('#u_user_id').val(id);
        $('#user_modal').modal();
        $('#u_loader').html('');
    }
    
    $(function(){
        
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
     $('#tdate').datepicker({
                      format: 'dd-mm-yyyy',
                      autoclose:true,
                      todayBtn: true
                  });
    
    $('#wBtn').click(function(){
        $('#w_loader').html('<i class="fa fa-spin fa-spinner"></i>');
        var url = '<?=BASE?>panel/user/add-wallet';
        var data = $('#w_from').serialize();
        $.ajax({
       type: "POST",
       url: url,
       async: false,
       data:data,
       success: function(res){
           var sus = JSON.parse(res);
             if(sus.status)
             {
                 $('#w_loader').html('<span class="success">Amount Added Successfully</span>');
                 $('#w_from')[0].reset();
                 setTimeout(function(){$('#w_loader').html('');},3000)
                 window.location.href = '<?=  current_url()?>';
             }else{
                 var error = sus.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#w_loader').html('<span class="err">Error occured.</span>');
                setTimeout(function(){$('#w_loader').html('');},3000)
             }
        }
       });
    });

    $('#userBtn').click(function(){
        $('#u_loader').html('<i class="fa fa-spin fa-spinner"></i>');
        var data = $('#u_form').serialize();
        var url = '<?=BASE?>panel/user/update-user';
        $.ajax({
            type: "POST",
            url: url,
            async: false,
            data:data,
            success: function(res){
                var sus = JSON.parse(res);
                if(sus.status)
                {   
                    $('#u_loader').html('<span class="success">User Updated Successfully</span>');
                    $('#u_form')[0].reset();
                    setTimeout(function(){$('#u_loader').html('');},3000)
                    window.location.href = '<?=  current_url()?>';

                }else{
                    var error = sus.error;
                    $.each( error, function( i, val ) 
                    {
                        $('#'+i).html(val);
                    });
                    $('#u_loader').html('<span class="err">Error occured.</span>');
                    setTimeout(function(){$('#w_loader').html('');},3000)
                }
            }
        });
    });



    });
    </script>