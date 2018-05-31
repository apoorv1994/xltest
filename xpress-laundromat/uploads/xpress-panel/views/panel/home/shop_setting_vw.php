<link href="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">

<div class="col-lg-12">  
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Shop Setting</h1>
                <ol class="breadcrumb">
                    <li><a href="<?=BASE?>panel"> <i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li class="active">Shop Setting</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">

    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="padding-bottom:10px;">
            <div class="row">
            <h4 class="col-sm-8">Shop Settings</h4>
            <div class="col-sm-4 pull-right">
                <form method="get" id="filterFrm">
                    <select class="form-control select2" name="filter_setting" onchange="this.form.submit()">
                    <?php foreach($colleges as $college){?>
                    <option <?=$this->input->get('filter_setting')==$college->id?'Selected':''?> value="<?=$college->id?>"><?=$college->college_name?></option>
                    <?php }?>
                </select>
            </form>
            </div>
            </div>
        </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">General Settings </a></li>
    <li><a data-toggle="tab" href="#indi_wash">Premium Wash</a></li>
    <li><a data-toggle="tab" href="#dry_clean">Dry Cleaning</a></li>
    <li><a data-toggle="tab" href="#shop_close">Shop Close</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="col-lg-12 margin-top-20">
            <form action="" method="post" name="frmShop" id="frmShop">
	   <div class="panel-body">
              <table class="table">
             <tbody>
                 <tr>
                    <td><strong>Shop Status<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                    <td>
                        <select name="shop_status" id="shop_status" style="width: 50%" class="form-control select2">
                                <option <?=$settings['shop_status']==0?'Selected':''?> value="0">Open</option>
                                <option <?=$settings['shop_status']==1?'Selected':''?> value="1">Close</option>
                        </select>
                        <div id="shop_status_err"></div>
                        <input type="hidden" name="college_id" value="<?=$college_id?>" name="college_id" />
                    </td>
                 </tr>
                  <tr>
                    <td><strong>Pickup Status<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                    <td>
                        <select name="pickup_status" id="pickup_status" style="width: 50%" class="form-control select2">
                            <option <?=$settings['pickup_status']==0?'Selected':''?>  value="0">On</option>
                            <option <?=$settings['pickup_status']==1?'Selected':''?>  value="1">Off</option>
                        </select>
                        <div id="pickup_status_err"></div>
                    </td>
                 </tr>
                   <tr>
                        <td><strong>Dropoff Status<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                        <td>
                                <select name="dropoff_status" id="dropoff_status" style="width: 50%" class="form-control select2">
                                        <option <?=$settings['dropoff_status']==0?'Selected':''?>   value="0">On</option>
                                        <option <?=$settings['dropoff_status']==1?'Selected':''?>   value="1">Off</option>
                                </select>
                            <div id="dropoff_status_err"></div>
                        </td>
                 </tr>
                  <tr> 
                        <td><strong>College Email Suffix<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                        <td><input name="email_suffix" type="text" class="form-control text-input" id="email_suffix" placeholder="@email.com" value="<?=$settings['email_suffix']!=''?$settings['email_suffix']:''?>">
                        <div id="email_suffix_err"></div>
                        </td>
                  </tr>
                  <tr>
                        <td><strong>Iron Price<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                        <td><input name="iron_price" type="text" id="sc_iron_price" class="form-control" value="<?=$settings['iron_price']!=''?$settings['iron_price']:0.00?>">
                        <div id="iron_price_err"></div>
                        </td>
                  </tr>
                  <tr>
                        <td><strong>Slot Weight<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                        <td><input name="slot_weight" type="text" id="sc_slot_weight" value="<?=$settings['slot_weight']!=''?$settings['slot_weight']:0?>" class="form-control ">
                        <div id="slot_weight_err"></div>
                        </td>
                  </tr>
                  <tr>
                        <td><strong>Perslot Bulk Wash Price (IRON)<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                        <td><input name="sc_bulk_price_iron" type="text" id="sc_perslot_price" value="<?=$settings['sc_bulk_price_iron']!=''?$settings['sc_bulk_price_iron']:0.00?>" class="form-control">
                            <div id="sc_bulk_price_err"></div>
                        </td>
                  </tr>
                   <tr>
                        <td><strong>Perslot Bulk Wash Price (FOLD)<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                        <td><input name="sc_bulk_price_fold" type="text" id="sc_perslot_price_fold" value="<?=$settings['sc_bulk_price_fold']!=''?$settings['sc_bulk_price_fold']:0.00?>" class="form-control">
                            <div id="sc_bulk_price_err"></div>
                        </td>
                  </tr>
                    <tr>
                        <td><strong>Extra Charge per kg<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                        <td><input name="extra_charge" type="text" id="sc_extra_charge" value="<?=$settings['extra_charge']!=''?$settings['extra_charge']:0.00?>" class="form-control">
                        <div id="extra_charge_err"></div>
                        </td>
                  </tr>
                    <tr>
                            <td><strong>Pick &amp; Drop Off Charges<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="pickdrop" type="text" id="sc_pickdrop" value="<?=$settings['pickdrop']!=''?$settings['pickdrop']:0.00?>" class="form-control">
                            <div id="pickdrop_err"></div>
                            </td>
                  </tr>
                  <tr>
                            <td><strong>Individual Wash Charges (per cloth)<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="sc_shoe_price" type="text" id="sc_shoe_price" value="<?=$settings['sc_shoe_price']!=''?$settings['sc_shoe_price']:0.00?>" class="form-control">
                            <div id="sc_shoe_price_err"></div>
                            </td>
                  </tr>
				  <tr>
                            <td><strong>Individual Iron Charges (per cloth)<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="sc_shoe_price_iron" type="text" id="sc_shoe_price_iron" value="<?=$settings['sc_shoe_price_iron']!=''?$settings['sc_shoe_price_iron']:0.00?>" class="form-control">
                            <div id="sc_shoe_price_iron_err"></div>
                            </td>
                  </tr>
                  <tr>
                            <td><strong>COD<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="cod" checked="" type="radio" id="cod_off" value="Off" > Off 
                                <input name="cod" type="radio" <?=$settings['cod']=='On'?'Checked':''?> id="cod_on" value="On"> On 
                            <div id="sc_shoe_price_err"></div>
                            </td>
                  </tr>
                  <tr>
                            <td><strong>Pick UP Reminder Message<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><textarea name="sc_pickup_reminder" maxlength="160" id="sc_pickup_reminder" class="form-control"><?=$settings['sc_pickup_reminder']!=''?$settings['sc_pickup_reminder']:""?></textarea>
                                <small>max 160 characters</small><small class="pull-right" id="pcounter"><?=160-  strlen($settings['sc_pickup_reminder'])?></small>
                            <div id="sc_pickup_reminder_err"></div>
                            </td>
                  </tr>
                  <tr>
                            <td><strong>Drop off Reminder Message<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><textarea name="sc_dropoff_reminder" maxlength="140" id="sc_dropoff_reminder" class="form-control"><?=$settings['sc_dropoff_reminder']!=''?$settings['sc_dropoff_reminder']:""?></textarea>
                                <small>max 140 characters</small><small class="pull-right" id="dcounter"><?=140-  strlen($settings['sc_dropoff_reminder'])?></small>
                            <div id="sc_dropoff_reminder_err"></div>
                            </td>
                  </tr>
                  <tr>
                            <td><strong>Complete Order Message<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><textarea name="sc_complete_msg" maxlength="160" id="sc_complete_msg" class="form-control"><?=$settings['sc_complete_msg']!=''?$settings['sc_complete_msg']:""?></textarea>
                                <small>max 160 characters</small><small class="pull-right" id="ccounter"><?=160-  strlen($settings['sc_complete_msg'])?></small>
                            <div id="sc_complete_msg_err"></div>
                            </td>
                  </tr>
                </tbody>
             </table> 
 
 

<div class="pull-right">
    <div id="loader"></div>
    <input name="btnModify" type="button" id="frmShopBtn" value="Save" class="btn btn-primary">
</div>
</div></form>
        </div>
    </div>
    <div id="indi_wash" class="tab-pane fade">
        <div class="col-lg-12 margin-top-20">
            <form method="post" name="frmShop" id="indi_washFrm">
              <div class="panel-body">
                 <table class="table">
                 <tbody>
                      <tr> 
                            <td><strong>PANTS / JEANS / LOWERS PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="sc_indi_pant_price" type="text" class="form-control text-input" id="sc_indi_pant_price" value="<?=$settings['sc_indi_pant_price']!=''?$settings['sc_indi_pant_price']:0.00?>">
                                <div id="sc_indi_pant_price_err"></div>
                                <input type="hidden" name="college_id" value="<?=$college_id?>" name="college_id" />
                            </td>
                      </tr>
                      <tr>
                            <td><strong>SALWAR SUIT/ KURTA PAJAMA PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="sc_indi_undergarment_price" type="text" id="sc_indi_undergarment_price" class="form-control" value="<?=$settings['sc_indi_undergarment_price']!=''?$settings['sc_indi_undergarment_price']:0.00?>">
                                <div id="sc_indi_undergarment_price_err"></div>
                            </td>
                      </tr>
                      <tr>
                            <td><strong>TOWELS / BEDSHEETS PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="sc_indi_towels_price" type="text" id="sc_indi_towels_price" class="form-control" value="<?=$settings['sc_indi_towels_price']!=''?$settings['sc_indi_towels_price']:0.00?>">
                                <div id="sc_indi_towels_price_err"></div>
                            </td>
                      </tr>
                      <tr>
                            <td><strong>SHIRTS / T SHIRTS / TOPS PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="sc_indi_shirt_price" type="text" id="sc_indi_shirt_price" value="<?=$settings['sc_indi_shirt_price']!=''?$settings['sc_indi_shirt_price']:0.00?>" class="form-control">
                                <div id="sc_indi_shirt_price_err"></div>
                            </td>
                      </tr>
                      <tr>
                            <td><strong>OTHER PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td><input name="sc_indi_others_price" type="text" id="sc_indi_others_price" value="<?=$settings['sc_indi_others_price']!=''?$settings['sc_indi_others_price']:0.00?>" class="form-control ">
                                <div id="sc_indi_others_price_err"></div>
                            </td>
                      </tr>
                    </tbody>
                 </table>
                <div class="pull-right">
                    <div id="loader1"></div>
                    <input name="btnModify" type="button" id="indi_washBtn" value="Save" class="btn btn-primary">
                </div>
              </div>
            </form>
        </div>
    </div>
      <!-- Dry clean Section-->
      <div id="dry_clean" class="tab-pane fade">
          <form method="post" name="frmShop" id="dry_cleanFrm">
              <div class="panel-body">
                 <table class="table">
                 <tbody>
                      <tr> 
                            <td><strong>PANTS / JEANS / LOWERS PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td>
                                <input name="sc_dry_pant_price" type="text" class="form-control text-input" id="sc_dry_pant_price" value="<?=$settings['sc_dry_pant_price']!=''?$settings['sc_dry_pant_price']:0.00?>">
                                <div id="sc_dry_pant_price_err"></div>
                                <input type="hidden" name="college_id" value="<?=$college_id?>" name="college_id" />
                            </td>
                      </tr>
                      <tr>
                            <td><strong>BLANKETS PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td>
                                <input name="sc_dry_blanket_price" type="text" id="sc_dry_blanket_price" class="form-control" value="<?=$settings['sc_dry_blanket_price']!=''?$settings['sc_dry_blanket_price']:0.00?>">
                                <div id="sc_dry_blanket_price_err"></div>
                            </td>
                      </tr>
                      <tr>
                            <td><strong>SUITS PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td>
                                <input name="sc_dry_suit_price" type="text" id="sc_dry_suit_price" class="form-control" value="<?=$settings['sc_dry_suit_price']!=''?$settings['sc_dry_suit_price']:0.00?>">
                                <div id="sc_dry_suit_price_err"></div>
                            </td>
                      </tr>
                      <tr>
                            <td><strong>SHIRTS / T SHIRTS / TOPS PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td>
                                <input name="sc_dry_shirt_price" type="text" id="sc_dry_shirt_price" value="<?=$settings['sc_dry_shirt_price']!=''?$settings['sc_dry_shirt_price']:0.00?>" class="form-control">
                                <div id="sc_dry_shirt_price_err"></div>
                            </td>
                      </tr>
                      <tr>
                            <td><strong>OTHER PRICE<span class="text-red dk-font-18">*</span>&nbsp;</strong></td>
                            <td>
                                <input name="sc_dry_others_price" type="text" id="sc_dry_others_price" value="<?=$settings['sc_dry_others_price']!=''?$settings['sc_dry_others_price']:0.00?>" class="form-control ">
                                <div id="sc_dry_others_price_err"></div>
                            </td>
                      </tr>
                    </tbody>
                 </table>
                <div class="pull-right">
                    <div id="loader2"></div>
                    <input name="btnModify" type="button" id="dry_cleanBtn" value="Save" class="btn btn-primary">
                </div>
              </div>
            </form>
      </div>
      <!-- Shop closee settings -->
      <div id="shop_close" class="tab-pane fade">
        <div class="col-lg-12 col-sm-12 col-md-12">
          <form action="post" name="close" id="frmshop">
            <input type="date" name="date_close" id="close_date">
            <input type="hidden" name="college_id" value="<?=$college_id?>" name="college_id" />
            <input type="button" value="Close Shop" id="shopbtn" class="btn btn-warning">
          </form>
        </div>
        <table class="table">
          <tbody>
            <tr><td><strong>Date</strong></td><td><strong>Options</strong></td></tr>
            <?php foreach($shop_close as $shop) { ?>
              <tr><td><?= $shop->value ?></td><td><button onClick="deleteShop(<?= $shop->id ?>)" class="btn btn-danger">Delete</button></td></tr>
            <?php }?>
          </tbody>
        </table>
      </div>



  </div>
</div>
        
    </div>
    </div>
    </div>
    </div>

    <script src="<?=BASE?>admin/select2/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('.select2').select2();
    });

    function deleteShop(id)
    {
      var data = 'id='+id;
      var url = '<?=BASE?>panel/home/deleteclose';
      $.post(url,data,function(success){
        var res = JSON.parse(success);
        if(res.status)
        {
          window.location.href = '<?=  current_url()?>';
        }
      })
    }

    
    $('#frmShopBtn').click(function(){
        $('#loader').html('<i class="fa fa-spin fa-spinner"></i>');
        var url = '<?=BASE?>panel/home/gensetting';
        var data = $('#frmShop').serialize();
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            if(res.status)
            {
                $('#loader').html('<span class="success">Setting Updated</span>');
                setTimeout(function(){$('#loader').html('');},1000);
            }else{
                var error = res.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#loader').html('<span class="err">Error occured</span>');
            }
        })
        })
        
        $('#sc_pickup_reminder').keyup(function(){
            var co = 160-$(this).val().length;
            $('#pcounter').html(co);
        })
        $('#sc_dropoff_reminder').keyup(function(){
            var co = 140-$(this).val().length;
            $('#dcounter').html(co);
        })
        $('#sc_complete_msg').keyup(function(){
            var co = 140-$(this).val().length;
            $('#ccounter').html(co);
        })
    
    $('#indi_washBtn').click(function(){
        $('#loader1').html('<i class="fa fa-spin fa-spinner"></i>');
        var url = '<?=BASE?>panel/home/indisetting';
        var data = $('#indi_washFrm').serialize();
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            if(res.status)
            {
                $('#loader1').html('<span class="success">Setting Updated</span>');
                setTimeout(function(){$('#loader1').html('');},1000);
            }else{
                var error = res.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#loader1').html('<span class="err">Error occured</span>');
            }
        })
        })

    $('#shopbtn').click(function(){
      var data = $('#frmshop').serialize();
      var url = '<?=BASE?>panel/home/closeshop';
      $.post(url,data,function(success){
        var res=JSON.parse(success);
        //console.log(res.id);
        if(res.status)
        {
          window.location.href = '<?=  current_url()?>';
        }
      })
    })
        
        $('#dry_cleanBtn').click(function(){
        $('#loader2').html('<i class="fa fa-spin fa-spinner"></i>');
        var url = '<?=BASE?>panel/home/drysetting';
        var data = $('#dry_cleanFrm').serialize();
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            if(res.status)
            {
                $('#loader2').html('<span class="success">Setting Updated</span>');
                setTimeout(function(){$('#loader2').html('');},1000);
            }else{
                var error = res.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#loader2').html('<span class="err">Error occured</span>');
            }
        })
        })
        
    
    </script>