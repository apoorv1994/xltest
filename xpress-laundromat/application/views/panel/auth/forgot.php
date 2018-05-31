
			<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			  Enter your email address to recover your password.
			</div>
                    <?php if($error!=''){?>
			<div class="alert alert-danger fade in alert-dismissable">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <?=$error?>
			</div>
                    <?php }?>
                    <form role="form" action="<?=BASE?>panel/auth/forgot-password" method="post">
				<div class="form-group has-feedback lg left-feedback no-label">
                                    <input type="email" name="email" class="form-control no-border input-lg rounded" placeholder="Enter email" autofocus>
				  <span class="fa fa-envelope form-control-feedback"></span>
                                  <?php
                                    if(form_error('email')!='') echo form_error('email','<div class="text-error err">','</div>');
                                    ?>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-warning btn-lg btn-perspective btn-block">RESET PASSWORD</button>
				</div>
			</form>
			<p class="text-center"><strong><a href="<?=BASE?>panel/auth">Back to login</a></strong></p>
		