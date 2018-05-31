<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding">
    <div class="col-sm-12 no-padding home-header">
        <div class="container m-b-40">
            <h3>Reset Password</h3>
            <?php if($this->session->flashdata('error')){?>
            <div class="alert alert-danger">
                <?=$this->session->flashdata('error')?>
            </div>
            <?php }?>
            <form method="post" action="<?=  current_url()?>">
                <div class="col-sm-12">
                    <label class="col-sm-3">Enter New Password</label>
                    <div class="col-sm-4 margin-bottom-10">
                        <input type="password" name="password" class="form-control" value="<?=  set_value('password')?>" placeholder="New Password">
                        <?=  form_error('password')!=''?form_error('password','<div class="err">','</div>'):''?>
                    </div>
                    <div class="col-sm-5">
                        
                    </div>
                </div>
                <div class="col-sm-12 margin-bottom-10">
                    <label class="col-sm-3">Confirm Password</label>
                    <div class="col-sm-4">
                        <input type="password" name="confirm_password" class="form-control" value="<?=  set_value('confirm_password')?>" placeholder="Confirm Password">
                        <?=  form_error('confirm_password')!=''?form_error('confirm_password','<div class="err">','</div>'):''?>
                    </div>
                    <div class="col-sm-5">
                        
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-3"></label>
                    <div class="col-sm-5">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>