<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding">
    <div class="col-sm-12 no-padding home-header">
        <div class="container m-b-40">
            <h3>Forgot Password</h3>
            <?php if($this->session->flashdata('error')){?>
            <div class="alert alert-danger">
                <?=$this->session->flashdata('error')?>
            </div>
            <?php }?>
            <form method="post" action="<?=  current_url()?>">
            <label class="col-sm-3">Enter registered Email ID</label>
            <div class="col-sm-4">
                <input type="text" name="email" class="form-control" value="<?=  set_value('email')?>" placeholder="Enter Email ID">
                    <?=  form_error('email')!=''?form_error('email','<div class="err">','</div>'):''?>
            </div>
            <div class="col-sm-5">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>