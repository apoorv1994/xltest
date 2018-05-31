
<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Enter your verification code.
</div>
<?php if($error!=''){?>
<div class="alert alert-success fade in alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <span style="color:red;"><?=$error?></span>
</div>
<?php }?>
<form role="form" action="<?=BASE?>panel/auth/reset-password" method="post">
    <div class="form-group has-feedback lg left-feedback no-label">
        <input type="password" name="password" class="form-control no-border input-lg rounded" placeholder="Enter Password" value="<?=$this->form_validation->set_value('password')?>" autofocus>
      <i class="fa fa-unlock-alt form-control-feedback"></i>
      <?php
        if(form_error('password')!='') echo form_error('password','<div class="text-error err">','</div>');
        ?>
    </div>
    <div class="form-group has-feedback lg left-feedback no-label">
        <input type="password" name="confirm_password" class="form-control no-border input-lg rounded" placeholder="Confirm Password" value="<?=$this->form_validation->set_value('confirm_password')?>" autofocus>
      <i class="fa fa-unlock-alt form-control-feedback"></i>
      <?php
        if(form_error('confirm_password')!='') echo form_error('confirm_password','<div class="text-error err">','</div>');
        ?>
    </div>
    <div class="form-group">
            <button type="submit" class="btn btn-warning btn-lg btn-perspective btn-block">RESET PASSWORD</button>
    </div>
</form>
<p class="text-center"><strong><a href="<?=BASE?>panel/auth">Back to login</a></strong></p>