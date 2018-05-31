
                    <?php if($error!=''){?>
			<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <span style="color:red;"><?=$error?></span>
			</div>
                    <?php }?>
                    <?php if($msg!=''){?>
			<div class="alert alert-success fade in alert-dismissable">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <span style="color:red;"><?=$msg?></span>
			</div>
                    <?php }?>
                    
                    <form role="form" method="post" action="<?=BASE?>panel/auth">
				<div class="form-group has-feedback lg left-feedback no-label">
                                    <input type="text" name="email" value="<?=base64_decode($this->input->cookie('GFu'));?>" class="form-control no-border input-lg rounded" style="color: #666" placeholder="Enter username" autofocus>
				  <span class="fa fa-user form-control-feedback"></span>
                                  <?php
                                    if(form_error('email')!='') echo form_error('email','<div class="text-error err">','</div>');
                                    ?>
				</div>
				<div class="form-group has-feedback lg left-feedback no-label">
                                    <input type="password" name="password" value="<?=base64_decode($this->input->cookie('GFp'));?>" class="form-control no-border input-lg rounded" style="color: #666" placeholder="Enter password">
				  <span class="fa fa-unlock-alt form-control-feedback"></span>
                                  <?php
                                    if(form_error('email')!='') echo form_error('password','<div class="text-error err">','</div>');
                                    ?>
				</div>
				<div class="form-group">
				  <div class="checkbox">
					<label>
                                            <input type="checkbox" name="remember" value="remember" <?php if($this->input->cookie('GFu')){echo 'checked="checked"';}?> class="i-yellow-flat"> Remember me
					</label>
				  </div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-lg btn-perspective btn-block">LOGIN</button>
				</div>
			</form>
<!--			<p class="text-center"><strong><a href="<?=BASE?>panel/auth/forgot-password">Forgot your password?</a></strong></p>-->
		