<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Change Password
                        </h1>
                        <ol class="breadcrumb">
                           <li><a href="<?=BASE?>panel/home"><i class="fa fa-home"></i></a></li>
                           <li><a href="<?=BASE?>panel/home/settings">Settings</a></li>
                           <li class="active">Change Password</li>
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
            <form role="form" action="<?=BASE?>panel/home/settings" method="post">
            <div class="col-sm-8">
                <div class="the-box">
                          <div class="form-group">
                                <label> Current password</label>
                                <input type="password" name="current_password" required="" value="<?=set_value('current_password')?>" class="form-control">
                                <?php
                                    if(form_error('current_password')!='') echo form_error('current_password','<div class="text-error err">','</div>');
                                ?>
                          </div>
                          <div class="form-group">
                                <label> New password</label>
                                <input type="password" name="new_password" required="" value="<?=set_value('new_password')?>" class="form-control">
                                <?php
                                    if(form_error('new_password')!='') echo form_error('new_password','<div class="text-error err">','</div>');
                                ?>
                          </div>
                            <div class="form-group">
                                <label> Confirm password</label>
                                <input type="password" name="confirm_password" required="" value="<?=set_value('confirm_password')?>" class="form-control">
                                <?php
                                    if(form_error('confirm_password')!='') echo form_error('confirm_password','<div class="text-error err">','</div>');
                                ?>
                          </div>
                          
                         <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Save</button>
                        
                </div><!-- /.the-box -->
            </div>
                </form>
        </div>
