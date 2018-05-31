<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding">
    <div class="col-sm-12 no-padding home-header">
        <div class="container m-b-40">
            <h3>Verify Your Email</h3>
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
            <label class="col-sm-3">Enter Verification Code</label>
            <div class="col-sm-4">
                <input type="text" name="code" placeholder="Enter Verification Code" class="form-control" />
                <?=  form_error('code','<div class="err">','</div>')?>
            </div>
            <div class="col-sm-5">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
            <div class="col-sm-4 m-t-10"><a href="<?=BASE?>auth/resend-to-email" title="Resend Code">Resend Code</a></div>
            </form>
        </div>
    </div>
</div>