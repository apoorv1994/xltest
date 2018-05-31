
<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Reset your Password.
</div>
<?php if($error!=''){?>
<div class="alert alert-success fade in alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <span style="color:red;"><?=$error?></span>
</div>
<?php }?>
<form role="form" action="<?=BASE?>panel/auth/verify-code" method="post">
        <div class="form-group has-feedback lg left-feedback no-label">
            <input type="text" name="code" class="form-control no-border input-lg rounded" placeholder="Enter verification code" autofocus>
          <span class="fa fa-unlock-alt form-control-feedback"></span>
          <?php
            if(form_error('code')!='') echo form_error('code','<div class="text-error err">','</div>');
            ?>
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-warning btn-lg btn-perspective btn-block">RESET PASSWORD</button>
        </div>
</form>
<p class="text-center"><strong><a href="<?=BASE?>panel/auth">Back to login</a></strong></p>
		