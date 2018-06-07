<?php 
if($this->uri->segment(2)!='')
{
    $page = $this->uri->segment(2);
}else{
    $page ='bulkwashing';
}
$afternoon=$evening=$night=$morning = [];
foreach($slots as $slot)
{
    switch($slot->slot_type)
    {
        case 'Morning':
            $morning = $slot;
            break;
        case 'Afternoon':
            $afternoon = $slot;
            break;
        case 'Evening':
            $evening = $slot;
            break;
        case 'Night':
            $night = $slot;
            break;
    }
}
//echo "<pre>";
//print_r($last_order);
$finalAmount="0";

if($last_order->status=='2' || $last_order->status=='4' || $last_order->status=='5')
{
	$finalAmount= $last_order->final_amount;
}
else
{ 	
	$finalAmount= $last_order->total_amount+$last_order->sc_SGST+$last_order->sc_CGST+$last_order->sc_IGST-$last_order->discount;
}


?>
<link rel="stylesheet" href="<?=BASE?>assets/css/circle.css">
<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding">
    <div class="container">
        <div class="col-xs-12 col-sm-6 slottop">
            <div class="col-xs-12 col-sm-3 padding-bottom-20 padding-top-20 hidden-xs hidden-sm">
                <img src="<?=$details->profile_pic?>" style="max-height: 165px;" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-8 no-padding p-l-20 pdata">
            <h3 class="col-xs-8 col-sm-8 no-padding">Hi <?=$details->firstname?></h3>
                <div class="col-xs-12 col-sm-12 no-padding">
                    <div class="col-xs-6 col-sm-6 no-padding">Phone No.</div>
                    <div class="col-xs-6 col-sm-6 no-padding">: +91 <?=$details->phone_no?></div>
                </div>
                <div class="col-xs-12 col-sm-12 no-padding">
                    <div class="col-xs-6 col-sm-6 no-padding">Room No</div>
                    <div class="col-xs-6 col-sm-6 no-padding">: <?=$details->room_no?></div>
                </div>
                <div class="col-xs-12 col-sm-12 no-padding ">
                    <div class="col-xs-6 col-sm-6 no-padding">Wallet Balance</div>
                    <div class="col-xs-6 col-sm-6 no-padding">: <i class="fa fa-inr"></i> <?=$details->wallet_balance?></div>
                </div>
                <div class="col-xs-12 col-sm-12 no-padding">
                    <div class="col-xs-6 col-sm-6 no-padding">Last Order</div>
                    <div class="col-xs-6 col-sm-6 no-padding">: <i class="fa fa-inr"></i> <?php echo $finalAmount;?></div>
                </div>
                <div class="col-xs-12 col-sm-12  m-t-10 no-padding">
                    <a class="form-control rechargeBtn" href="<?=BASE?>user" title="Recharge Wallet">Recharge Wallet</a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 padding-top-10 border-left hidden-sm hidden-xs" id="statusbar">
            
            <?php if($last_order)
            {
                switch ($last_order->status)
                {
                    case 1:
                        $val=20;
                        $text = 'Order recieved'; $bclass = 'default';
                        break;
                    case 2:
                        $val= 60;
                        $text = 'Order processed'; $bclass='warning';
                        break;
                    case 3:
                        $val=40;
                        $text ='Clothes collected'; $bclass= 'info';
                        break;
                    case 4:
                        $val= 80;
                        $text = 'Out/Ready for Delivery'; $bclass = 'primary';
                        break;
                    case 5:
                        $val=100;
                        $text = 'Completed'; $bclass = 'success';
                        break;
                }
                ?>
            <div class="col-xs-12 col-sm-12 text-center hidden-sm hidden-xs">
            <label class=" label margin-bottom-10 label-<?=$bclass?>"><?=$text?></label>
            </div>
            <div class="col-xs-6 col-sm-4 text-center no-padding p-t-20 p-b-40">
                <img class=" text-center" src="<?=BASE?>assets/img/loc.png" />
                <span class="bold col-sm-12 col-xs-12 m-t-10">PICK UP</span>
                <div class="col-sm-12"><?=date('d/m/Y',$last_order->book_date)?></div>
                <div  class="col-sm-12 no-padding"><?=$u_pickup_t[$last_order->book_slot]?></div>
            </div>
            <div class="col-xs-12 col-sm-4 p-t-10 p-b-10 text-center">
                <label class=" label margin-bottom-10 label-<?=$bclass?> visible-sm visible-xs"><?=$text?></label>
                <div class="c100 p<?=$val?> mid" id="profile-progress">
                    <span id="progress_text"><i class="fa fa-check"></i></span>
                  <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                  </div>
                </div>
                <a href="<?=BASE?>home/order-history" class="p-t-10 col-sm-12 no-padding">View Previous Order</a>

                <?php
                    $time = explode(' ',$hslots[$last_order->book_slot]);
                    $ptime = strtotime($time[0]);
                    $full =date('Y-m-d',$last_order->book_date).' '.date('H:i',$ptime - (2*3600));
                    if(strtotime($full)>time()){?>
                <a class="btn btn-danger del" data-href="<?=BASE?>home/order-cancel/<?=$last_order->id?>" title="Cancel">Cancel</a>
                <?php }?>
            </div>
            <div class="col-sm-4 text-center no-padding p-t-20 p-b-40">
                <img class=" text-center" src="<?=BASE?>assets/img/bus.png" />
                <span class="bold col-sm-12">DELIVERY</span>
                <div class="col-sm-12"><?=date('d/m/Y',$u_delivery_date)?></div>
                <div  class="col-sm-12 no-padding"><?=$u_pickup_t[$last_order->book_slot]?></div>
            </div>
            <?php }else{?>
                <h3 class="col-sm-12 text-center  p-t-80 p-b-80"> Welcome to Xpress Laundromat </h3>
            <?php }?>
        </div>
        <div class="col-xs-12 col-sm-6  border-left visible-xs visible-sm" id="statusbar">
            
            <?php if($last_order)
            {
                switch ($last_order->status)
                {
                    case 1:
                        $val=20;
                        $text = 'Order recieved'; $bclass = 'default';
                        break;
                    case 2:
                        $val= 60;
                        $text = 'Order processed'; $bclass='warning';
                        break;
                    case 3:
                        $val=40;
                        $text ='Clothes collected'; $bclass= 'info';
                        break;
                    case 4:
                        $val= 80;
                        $text = 'Out/Ready for Delivery'; $bclass = 'primary';
                        break;
                    case 5:
                        $val=100;
                        $text = 'Completed'; $bclass = 'success';
                        break;
                }
                ?>
            <div class="col-xs-12 col-sm-12 text-center">
                <h4>Last order status</h3>
            <label class=" label margin-bottom-10 label-<?=$bclass?>"><?=$text?></label>
            </div>
            <div class="col-xs-6 col-sm-4 text-center no-padding p-t-20 p-b-10">
                <img class=" text-center" src="<?=BASE?>assets/img/loc.png" />
                <span class="bold col-sm-12 col-xs-12 m-t-10">PICK UP</span>
                <div class="col-sm-12"><?=date('d/m/Y',$last_order->book_date)?></div>
                <div  class="col-sm-12 no-padding"><?=$hslots[$last_order->book_slot]?></div>
            </div>
        
            <div class="col-sm-4  col-xs-6 text-center no-padding p-t-20 p-b-10">
                <img class=" text-center" src="<?=BASE?>assets/img/bus.png" />
                <span class="bold col-sm-12 col-xs-12 ">DELIVERY</span>
                <div class="col-sm-12"><?=$last_order->dropoff_time?date('d/m/Y',$last_order->dropoff_time):date('d/m/Y',($last_order->book_date + 48*60*60))?></div>
                <div  class="col-sm-12 no-padding"><?=$last_order->dropoff_time?date('h:i A',$last_order->dropoff_time).' - '.date('h:i A',$last_order->dropoff_time + 3*3600):$hslots[$last_order->book_slot]?></div>
            </div>
            <?php }else{?>
                <h3 class="col-sm-12 text-center  p-t-80 p-b-80"> Welcome to Xpress Laundromat </h3>
            <?php }?>
        </div>
    </div>
        
                <div class="col-sm-12 no-padding bg-white-custom" id="service">
                    <h3>Make a new Booking</h3>
                    <h4 class="visible-sm visible-xs text-center options">1. SELECT A SERVICE</h4>
                    <div class="container" style="">
                        <div data-href="<?=BASE?>home" class="col-sm-3 bookmenu <?=$bulk?> first-slot">
                            <img src="<?=BASE?>assets/img/box.png" class="" />
                            <span class="col-sm-12">Bulk Washing</span>
                            <p>Rates Per KG. (Rs. 100/4Kg)</p>
                        </div>
                        <div data-href="<?=BASE?>home/individual" class="col-sm-3 bookmenu <?=$shoelaundry?> last-slot">
                            <img src="<?=BASE?>assets/img/shirt.png" class="" />
                            <span class="col-sm-12">Individual Washing</span>
                            <p>Rates Per Piece (Rs. 7/Cloth)</p>
                        </div>
                        <div data-href="<?=BASE?>home/premium" class="col-sm-3 bookmenu <?=$individual?>">
                            <img src="<?=BASE?>assets/img/washing.png" class="" />
                            <span class="col-sm-12">Premium Washing</span>
                            <p>Special Outfits/Stain Removal.</p>
                        </div>
                        <div data-href="<?=BASE?>home/drycleaning" class="col-sm-3 bookmenu <?=$drycleaning?>">
                            <img src="<?=BASE?>assets/img/brush.png" class="" />
                            <span class="col-sm-12">Dry Cleaning</span>
                            <p>Chemical and Dry Wash.</p>
                        </div>
                    </div>
                </div>
            
                <div class="col-sm-12 no-padding " id="day">
                    
                    <div class="container">
                        <form method="post" id="orderFrm">
                        <div class="col-sm-12 m-t-40 no-padding box ">
                            <h4 class="visible-sm visible-xs text-center options" >2. SELECT DATE</h4>
                            <div class="col-sm-12 no-padding days">
                                <div class="col-sm-3 slotday slotcurrent" id="<?=date('Y-m-d')?>"  data-date="<?=date('Y-m-d')?>">
                                    Today
                                    <span class="col-sm-12 bold"><?=date('d D')?></span>
                                    <input type="radio" class="hidden" name="slotday" value="<?=date('Y-m-d')?>" />
                                </div>
                                <div class="col-sm-3 slotday" id="<?=date('Y-m-d',strtotime(' +1 day'))?>" data-date="<?=date('Y-m-d',strtotime(' +1 day'))?>">
                                    Tomorrow
                                    <span class="col-sm-12 bold"><?=date('d D',strtotime(' +1 day'))?></span>
                                    <input type="radio" class="hidden" name="slotday" value="<?=date('Y-m-d',strtotime(' +1 day'))?>" />
                                </div>
                                <div class="col-sm-3 slotday" id="<?=date('Y-m-d',strtotime(' +2 day'))?>" data-date="<?=date('Y-m-d',strtotime(' +2 day'))?>">
                                    Day After Tomorrow
                                    <span class="col-sm-12 bold"><?=date('d D',strtotime(' +2 day'))?></span>
                                    <input type="radio" class="hidden" name="slotday" value="<?=date('Y-m-d',strtotime(' +2 day'))?>" />
                                </div>
                                <div class="col-sm-3 noslotday last no-r-pad" style="<?=$individual=='current-slot' || $drycleaning=='current-slot'?'':'padding:30px;'?>">
                                    <span class="col-sm-12 text-right p-t-10 p-b-10">
                                        <?php if($individual=='current-slot' || $drycleaning=='current-slot'){?>
                                        <span class="col-sm-12 bold">Total Price <i class="fa fa-inr"></i><span id="total_price"> <?=$price?></span></span>
                                        <?php }?>
                                    </span>
                                </div>
                            </div>
                            <div id="dayopen" class="col-sm-12 no-padding bg-book">
                    <h4 class="visible-sm visible-xs text-center options" >3. SELECT PICKUP TIME</h4>

                                <div class="col-sm-3 text-center p-t-40 p-b-40 border-right slot" id="slot1">
                                    <span class="bold col-sm-12 p-b-10 hidden"><input type="radio" checked="" value="1" name="slotInput" /></span>
                                    <img class=" text-center" src="<?=BASE?>assets/img/morning.png" />
                                    <span class="bold col-sm-12 p-t-10">MORNING</span>
                                    <div  class="col-sm-12">
                                       <!--  <?=date('h:i a', strtotime($morning->start_time)).' To '.date('h:i a', strtotime($morning->end_time))?><br> -->
                                        Pickup time: <?php 
                                        if($hostel_details->morning)
                                            echo $hostel_details->morning;
                                        else
                                            echo date('h:i a', strtotime($morning->pickup_time));
                                        ?><br>
                                        <?php if($page=='bulkwashing'){?>
                                        <span id="m_slot"></span>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center p-t-40 p-b-40 border-right slot" id="slot2">
                                    <span class="bold col-sm-12 p-b-10 hidden"><input type="radio" value="2" name="slotInput" /></span>
                                    <img class=" text-center" src="<?=BASE?>assets/img/afternoon.png" />
                                    <span class="bold col-sm-12 p-t-10">AFTERNOON</span>
                                    <div  class="col-sm-12">
                                        <!-- <?=date('h:i a', strtotime($afternoon->start_time)).' To '.date('h:i a', strtotime($afternoon->end_time))?><br> -->
                                        Pickup time: <?php 
                                        if($hostel_details->afternoon)
                                            echo $hostel_details->afternoon;
                                        else
                                            echo date('h:i a', strtotime($afternoon->pickup_time));
                                        ?><br>
                                        <?php if($page=='bulkwashing'){?>
                                        <span id="a_slot"></span>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center p-t-40 p-b-40 border-right slot" id="slot3">
                                    <span class="bold col-sm-12 p-b-10 hidden"><input type="radio" value="3" name="slotInput" /></span>
                                    <img class=" text-center" src="<?=BASE?>assets/img/evening.png" />
                                    <span class="bold col-sm-12 p-t-10">EVENING</span>
                                    <div  class="col-sm-12">
                                       <!--  <?=date('h:i a', strtotime($evening->start_time)).' To '.date('h:i a', strtotime($evening->end_time))?><br> -->
                                        Pickup time: <?php 
                                        if($hostel_details->evening)
                                            echo $hostel_details->evening;
                                        else
                                            echo date('h:i a', strtotime($evening->pickup_time));
                                        ?><br>
                                        <?php if($page=='bulkwashing'){?>
                                        <span id="e_slot"></span>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center p-t-40 p-b-40 slot" id="slot4">
                                    <span class="bold col-sm-12 p-b-10 hidden"><input type="radio" value="4" name="slotInput" /></span>
                                    <img class=" text-center" src="<?=BASE?>assets/img/night.png" />
                                    <span class="bold col-sm-12 p-t-10">NIGHT</span>
                                    <div  class="col-sm-12">
                                       <!--  <?=date('h:i a', strtotime($night->start_time)).' To '.date('h:i a', strtotime($night->end_time))?><br> -->
                                        Pickup time: <?php 
                                        if($hostel_details->night)
                                            echo $hostel_details->night;
                                        else
                                            echo date('h:i a', strtotime($night->pickup_time));
                                        ?><br>
                                        <?php if($page=='bulkwashing'){?>
                                        <span id="n_slot"></span>
                                        <?php }?>
                                    </div>
                                </div>
                                
                            </div>
                            <div id="dayclose" class="col-sm-12 slotbox text-center mx-auto" style="padding-top:20px;padding-bottom:20px;">
                                    <h2>Laundry services are Closed for this day!</h2>
                            </div>
                        </div>
                        <div class="col-sm-12  qtybox no-padding">
                             <h4 class="visible-sm visible-xs text-center options" >4. OTHER OPTIONS</h4>
                                    <input type="hidden" value="<?=$page?>" name="order_type" />
                                    <?php $this->load->view('home/'.$page.'_vw')?>
                                </div>
                        <div class="col-sm-12 qtybox no-padding margin-top-5 m-b-40">
                            <div class="col-sm-4 bold fs-16  padding-bottom-20 padding-top-20">
                                <div class="col-sm-6">
                                    <input type="radio" name="pickup" value="self_pickup"> SELF PICKUP
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" checked="" name="pickup" value="avail_pickup"> AVAIL PICKUP
                                </div>
                            </div>
                            <div class="col-sm-4 padding-bottom-20 padding-top-20">
                                Avail Pickup, sit back and experience seamless service
                            </div>
                            <div class="col-sm-4 no-l-pad text-center proceed padding-bottom-20 padding-top-20" id="orderBtn">
                                <span>CONFIRM & MAKE PAYMENT</span>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
        
</div>
<?php if($this->session->flashdata('msg')!=''){?>
<div class="modal fade" id="msg" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                <h4 class="modal-title custom_align" id="Heading">Message</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-success"><span class="glyphicon glyphicon-warning-sign"></span> <?=$this->session->flashdata('msg')?></div>
                   
                  </div>
                    <div class="modal-footer ">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"> OK</button>
                  </div>
                                </form>
            </div>
                <!-- /.modal-content --> 
              </div>
                  <!-- /.modal-dialog --> 
                </div>
<?php }?>
<?php if($this->session->flashdata('error')!=''){?>
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                <h4 class="modal-title custom_align" id="Heading">Message</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?=$this->session->flashdata('error')?></div>
                   
                  </div>
                    <div class="modal-footer ">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"> OK</button>
                  </div>
                                </form>
            </div>
                <!-- /.modal-content --> 
              </div>
                  <!-- /.modal-dialog --> 
                </div>
<?php }?>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

        <!-- Modal content-->
        <div class="row modal-content">
          <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title text-center">Review Our Service</h4>
          </div>
            <form method="post" id="reviewFrm">
          <div class="modal-body m-t-15">
              <div class="form-group">
                  <div class="row">
                      <div for="concept" class="col-sm-6 control-label"><p class="col-sm-6">Order Date:</p> <label class="col-sm-6" id="o_date"></label></div>
                      <div class="col-sm-6"><p class="col-sm-6">Order Type:</p> <label class="col-sm-6" id="o_type"></label></div>
                  </div>
                </div>
                <p style="visibility:hidden; margin-bottom: -6px;">hidden</p>
                <div class="form-group">
                    <div class="row">
                        <div for="concept" class="col-sm-6 control-label"><p class="col-sm-6">Order Slot:</p> <label class="col-sm-6" id="o_slot"></label></div>
                        <label class="col-sm-6"></label>
                    </div>
                </div>
                <p style="visibility:hidden; margin-bottom: -6px;">hidden</p>
                <div class="form-group">
                    <div class="row">
                        <label for="concept" class="col-sm-3 control-label">Rating</label>
                        <div class="col-sm-9">
                                <svg style="display: none;">
                                  <symbol id="star" viewBox="0 0 98 92">
                                  <title>star</title>
                                  <path stroke='#000' stroke-width='5' d='M49 73.5L22.55 87.406l5.05-29.453-21.398-20.86 29.573-4.296L49 6l13.225 26.797 29.573 4.297-21.4 20.86 5.052 29.452z' fill-rule='evenodd'/>
                                </svg>

                                <div class="rating products-rating">
                                    <a href="javascript:;" class="rating__button" onclick="dset(1)" href="#"><svg class="rating__star"><use xlink:href="#star"></use></svg></a>
                                        <a href="javascript:;" class="rating__button" onclick="dset(2)" href="#"><svg class="rating__star"><use xlink:href="#star"></use></svg></a>
                                        <a href="javascript:;" class="rating__button" onclick="dset(3)" href="#"><svg class="rating__star"><use xlink:href="#star"></use></svg></a>
                                        <a href="javascript:;" class="rating__button" onclick="dset(4)" href="#"><svg class="rating__star"><use xlink:href="#star"></use></svg></a>
                                        <a href="javascript:;" class="rating__button" onclick="dset(5)" href="#"><svg class="rating__star"><use xlink:href="#star"></use></svg></a>
                                </div>
                                <input type="hidden" name="rating" id="rating">
                                <input type="hidden" name="order" id="r_order_id" />
                                <div class="err" id="rating_err"></div>
                        </div>
                    </div>
                </div>
                <p style="visibility:hidden; margin-bottom: -6px;">hidden</p>
                <div class="form-group">
                    <div class="row">
                        <label for="concept" class="col-sm-3 control-label">Write a Review</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="review" name="review"></textarea>
                            <div class="err" id="review_err"></div>
                        </div>
                    </div>
                </div>
                <p style="visibility:hidden; margin-bottom: -6px;">hidden</p>
                <div class="col-md-5 col-md-offset-6">
                     <div id="main_err"></div>
                     <button type="button" class="btn btn-success" id="review_submit">Submit</button><br><br>
                </div>

          </div>
            </form>
        </div>

  </div>
</div>
<script src="<?=BASE?>assets/js/quantity.js" ></script>
<script>
    $(document).ready(function(){

        $('#w_fold').on('click', function(e){
            $('#total_price').html(<?=$price_fold?> +' per '+ <?=$weight?>+'KG');
        });
        $('#w_iron').on('click', function(e){
            $('#total_price').html(<?=$price_iron?> +' per '+ <?=$weight?>+'KG');
        });

        
        $('.rating__button').on('click', function(e)
        {
            var $t = $(this), // the clicked star
            $ct = $t.parent(); // the stars container
            // add .is--active to the user selected star 
            $t.siblings().removeClass('is--active').end().toggleClass('is--active');
            // add .has--rating to the rating container, if there's a star selected. remove it if there's no star selected.
            $ct.find('.rating__button.is--active').length ? $ct.addClass('has--rating') : $ct.removeClass('has--rating');
        });
        <?php if($this->session->flashdata('msg')!=''){?>
               setTimeout(function(){$('#msg').modal();},1000) 
        <?php }?>
            <?php if($this->session->flashdata('error')!=''){?>
                setTimeout(function(){$('#errorModal').modal();},1000);
        <?php }?>
        setTimeout(function(){get_pendingrating()},3000)
        setTimeout(function(){$('.slotday:first').trigger('click');},1000)
        $('.bookmenu').click(function(){
            window.location.href = $(this).data('href');
        });
        $('.slotday').click(function(){
            if(!$(this).hasClass('disable'))
            {   
                $('#dayclose').hide();
                $('#dayopen').show();
                get_slot_availability($(this).data('date'),'<?=$page?>');
                $('.slotday').removeClass('slotcurrent');
                $(this).addClass('slotcurrent');
                $(this).children('input[type=radio]').prop('checked',true);

                    var url = '<?=BASE?>home/check_close';
                    var data = 'date='+$(this).data('date')+'&college_id='+<?=$details->college_id?>;
                    $.post(url,data,function(success){
                        var res = JSON.parse(success);
                        if(res.shop)
                        {
                            $('#dayclose').show();
                            $('#dayopen').hide();
                        }
                        else
                        {
                            $('#dayclose').hide();
                            $('#dayopen').show();
                        }
                    })
            }
        });
        
        $('#orderBtn').click(function(){
            var url = '<?=BASE?>home/order';
            var data = $('#orderFrm').serialize();
			var quantity_shirt =parseInt($("input[name=quantity_shirt]").val());
			var quantity_pants =parseInt($("input[name=quantity_pants]").val());
			var quantity_undergarments =parseInt($("input[name=quantity_undergarments]").val());
			var quantity_towel =parseInt($("input[name=quantity_towel]").val());
			var quantity_others =parseInt($("input[name=quantity_others]").val());
			var quantity_suit =parseInt($("input[name=quantity_suit]").val());
			var quantity_blanket =parseInt($("input[name=quantity_blanket]").val());
			var order_type =$("input[name=order_type]").val();
			var drycleaningTotalCloTh=quantity_shirt+quantity_pants+quantity_others+quantity_suit+quantity_blanket;
			var premiumTotalCloTh=quantity_shirt+quantity_pants+quantity_undergarments+quantity_towel+quantity_others;
			if(order_type=='drycleaning' || order_type=='premium')
			{
				
				var total_qty = 0;
				$('.qty').each(function(){
				   var qty = $(this).val();
				   total_qty +=parseInt(qty);
				});
				if(total_qty<1)
				{
					alert("Cloth Quantity should Be Greater Than Zero");
					return false;
				}
			}
			if(order_type=='drycleaning' || order_type=='premium' || order_type=='individual')
			{
				if($("#total_price").text()<100)
				{
					alert("Order Amount should Be Greater Than 100");
					return false;
				}
			}
			
            $.get('<?=BASE?>home/get_user', function(dat){
                dat = JSON.parse(dat);
                data += '&college_id='+dat.college_id;
                data += '&hostel_id='+dat.hostel_id;
                $.post(url,data,function(success){
                    var res = JSON.parse(success);
                    if(res.status)
                    {
                        window.location.href = '<?=BASE?>home/order_summary';
                    }else{
                        
                        var error = res.error;
                    $.each( error, function( i, val ) 
                    {
                        if(val!='')
                        {
                            $('body').pgNotification({
                            style: 'simple',
                            message: val,
                            position: 'top-right',
                            timeout: 2000,
                            type: 'danger'
                            }).show();
                        }
                    });
                         
                    }
                });
            });
            
        })
        
        $('.slot').click(function(){
            var id = $(this).attr('id');
            if(!$('#'+id+' input[type=radio]').is(':disabled'))
            {
                $('#'+id+' input[type=radio]').prop('checked',true);
                select_slot(id);
            }else{
                alert('Cannot Select this Slot');
            }
        })
        
        $('#review_submit').click(function(){
            $('#main_err').html('<i class="fa fa-spin fa-spinner"><i>');
            var url = '<?=BASE?>home/save-rating';
            var data = $('#reviewFrm').serialize();
            $.post(url,data,function(success){
                var res = JSON.parse(success);
                if(res.status)
                {
                    $('#main_err').html('<span class="success">Your Review saved.</span>');
                    setTimeout(function(){
                        $('#main_err').html('');
                        $('#reviewFrm')[0].reset();
                        $('#myModal .close').click();
                    },1500);   
                }else{
                    var error = res.error;
                    $.each( error, function( i, val ) 
                    {
                        $('#'+i).html(val);
                    });
                    setTimeout(function(){
                        $('#main_err').html('');
                    },3000);
                }
            })
        })
        
        $('.del').click(function(){
            if(confirm('Do you really want to cancel this order?'))
            {
                window.location.href = $(this).data('href');
            }
        })
    });
    
    function get_slot_availability(day,service)
    {
        var url = '<?=BASE?>home/check-slot';
        var college_id,hostel_id;
        $.get('<?=BASE?>home/get_user', function(dat){
            dat = JSON.parse(dat);
            college_id = dat.college_id;
            //hostel_id = dat.hostel_id;
        
        var data = {
                    day:day,
                    service:service,
                    college_id:college_id,
                    //hostel_id:hostel_id
                   };
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            if(res.status)
            {   
                var u ='yes';
                if(parseInt(res.morning) > 0)
                {
                    $('#slot1').removeClass('disable');
                    $('#slot1 input').removeAttr('disabled');
                    $('#slot1').attr('title','Book Slot');
                    $('#slot1 input').prop('checked',true);
                    select_slot('slot1');
                    u = 'no';
                    <?php if($page=='bulkwashing'){?>
                    $('#m_slot').text('Available Slot: '+res.morning);
                    <?php }?>
                }else{
                    $('#slot1').addClass('disable');
                    $('#slot1').removeClass('selected_slot');
                    $('#slot1 input').removeAttr('checked');
                    $('#slot1 input').attr('disabled',true);
                    $('#slot1').attr('title','Slot Full or time up');
                    $('#m_slot').text('Slot Full');
                }
                
                if(parseInt(res.afternoon) > 0)
                {
                    $('#slot2').removeClass('disable');
                    $('#slot2 input').removeAttr('disabled');
                    $('#slot2').attr('title','Book Slot');
                    if(u=='yes')
                    {
                        $('#slot2 input').prop('checked',true);
                        select_slot('slot2');
                    }
                    u = 'no';
                    <?php if($page=='bulkwashing'){?>
                    $('#a_slot').text('Available Slot: '+res.afternoon);
                    <?php }?>
                }else{
                    $('#slot2').addClass('disable');
                    $('#slot2').removeClass('selected_slot');
                    $('#slot2 input').removeAttr('checked');
                    $('#slot2 input').attr('disabled',true);
                    $('#slot2').attr('title','Slot Full or time up');
                    $('#a_slot').text('Slot Full');
                }
                
                if(parseInt(res.evening) > 0)
                {
                    $('#slot3').removeClass('disable');
                    $('#slot3 input').removeAttr('disabled');
                    $('#slot3').attr('title','Book Slot');
                    if(u=='yes')
                    {
                        $('#slot3 input').prop('checked',true);
                        select_slot('slot3');
                    }
                    u = 'no';
                    <?php if($page=='bulkwashing'){?>
                    $('#e_slot').text('Available Slot: '+res.evening);
                    <?php }?>
                }else{
                    $('#slot3').addClass('disable');
                    $('#slot3').removeClass('selected_slot');
                    $('#slot3 input').removeAttr('checked');
                    $('#slot3 input').attr('disabled',true);
                    $('#slot3').attr('title','Slot Full or time up');
                    $('#e_slot').text('Slot Full');
                }
                
                if(parseInt(res.night) > 0)
                {
                    $('#slot4').removeClass('disable');
                    $('#slot4 input').removeAttr('disabled');
                    $('#slot4').attr('title','Book Slot');
                    if(u=='yes')
                    {
                        $('#slot4 input').prop('checked',true);
                        select_slot('slot4');
                    }
                    u = 'no';
                    <?php if($page=='bulkwashing'){?>
                    $('#n_slot').text('Available Slot: '+res.night);
                    <?php }?>
                }else{
                    $('#slot4').addClass('disable');
                    $('#slot4').removeClass('selected_slot');
                    $('#slot4 input').removeAttr('checked');
                    $('#slot4 input').attr('disabled',true);
                    $('#slot4').attr('title','Slot Full or time up');
                    $('#n_slot').text('Slot Full');
                }
                
                if(res.night==0 && res.evening==0 && res.afternoon==0 && res.morning==0)
                {
                    $('#'+service).addClass('disable');
                }else{
                    $('#'+service).removeClass('disable');
                }
            }
        });
        });
    }
    
    function select_slot(slotname)
    {
        $('.slot').removeClass('selected_slot');
        $('#'+slotname).addClass('selected_slot');
    }
    
    function get_pendingrating()
    {
        var url = '<?=BASE?>home/get-pending-rating';
        $.get(url,function(success){
            var res = JSON.parse(success);
            if(res.status)
            {
                $('#r_order_id').val(res.data.id);
                $('#o_date').text(res.data.book_date);
                $('#o_type').text(res.data.order_type);
                $('#o_slot').text(res.data.slot_type);
                $('#myModal').modal();
            }
        })
    }
    function dset(id)
    {
        $('#rating').val(id);
    }
    
    function change_amt($val)
    {
        var wash = $('#ind_wash_price').val();
        var iron = $('#ind_iron_price').val();
        if($val == 0){
            $('#total_price').val(wash);
            $('#total_price').text(wash);
        }
        else{
            $('#total_price').val(iron);
            $('#total_price').text(iron);
        }
    }
</script>
