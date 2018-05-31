<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding">
    <div class="col-sm-12 no-padding home-header">
        <div class="container m-b-40">
            <h3>Verify Code</h3>
            <?php if($this->session->flashdata('err')){?>
            <div class="alert alert-danger">
                <?=$this->session->flashdata('err')?>
            </div>
            <?php }?>
            <?php if($this->session->flashdata('msg')){?>
            <div class="alert alert-success">
                <?=$this->session->flashdata('msg')?>
            </div>
            <?php }?>
            <form method="post" action="<?=  current_url()?>">
                <div class="col-sm-12 alert alert-success">An Email with the verification code has been sent to your Id, Please enter the code to Reset your Password </div>
            <label class="col-sm-3">Enter Verification Code</label>
            <div class="col-sm-4">
                <input type="text" name="code" class="form-control" value="<?=  set_value('code')?>" placeholder="Enter Code">
                    <?=  form_error('code')!=''?form_error('code','<div class="err">','</div>'):''?>
            </div>
            <div class="col-sm-5">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
            <div class="col-sm-12">
            <label class="col-sm-3"></label><div class="col-sm-4 m-t-10"><a href="<?=BASE?>auth/resend" title="Resend Code">Resend Code</a></div>
            </div>
            </form>
        </div>
    </div>
</div>