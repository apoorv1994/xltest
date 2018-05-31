<?php 
//echo "<pre>";
//print_r($settings);
?>
<div class="row"> 
<div class="col-sm-12">
	<input name="message_type" id="message_type_1" value="1" type="radio" onchange="show_option_data(1,<?php echo $type;?>);"/> Option 1
	<input name="message_type" id="message_type_2" value="2" type="radio" onchange="show_option_data(2,<?php echo $type;?>);"/> Option 2
	<input name="message_type" id="message_type_3" value="3" type="radio" onchange="show_option_data(3,<?php echo $type;?>);"/> Option 3
	<input name="message_type" id="message_type_4" value="4" type="radio" onchange="show_option_data(4,<?php echo $type;?>);"/> Custom
	<?php if($type=='2'){?>
	<input name="message_type" id="message_type_5" value="5" type="radio" onchange="show_option_data(5,<?php echo $type;?>);"/> Upload File<br>
	<br><input style="display:none;" name="subject" id="subject" type="text" class="form-control" placeholder="Subject"/><br>
	<?php } ?>
	<textarea readonly style="display:none;" name="message_1" id="message_1" class="form-control" placeholder="Message"><?=$settings['sc_email_sms_msg_1']!=''?$settings['sc_email_sms_msg_1']:""?></textarea>
	<textarea readonly style="display:none;" name="message_2" id="message_2" class="form-control" placeholder="Message"><?=$settings['sc_email_sms_msg_2']!=''?$settings['sc_email_sms_msg_2']:""?></textarea>
	<textarea readonly style="display:none;" name="message_3" id="message_3" class="form-control" placeholder="Message"><?=$settings['sc_email_sms_msg_3']!=''?$settings['sc_email_sms_msg_3']:""?></textarea>
	<textarea style="display:none;" name="message_4" id="message_4" class="form-control" placeholder="Message"></textarea>
	
	<?php if($type=='2'){?>
	<textarea style="display:none;" name="message_5" id="message_5" class="form-control" placeholder="Message"></textarea>
	<br><input style="display:none;" name="photo" id="photo" type="file"/>
	<?php } ?>
	
	<input name="user_id" id="user_id" type="hidden" value="<?=$user_id?>"/>
	<input name="college_id" id="college_id" type="hidden" value="<?=$college_id?>"/>
	<input name="type" id="type" type="hidden" value="<?=$type?>"/>
</div>
</div>
    