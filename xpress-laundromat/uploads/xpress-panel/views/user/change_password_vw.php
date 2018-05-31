<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding ">
<?php $this->load->view('home/wallet_vw');?>
    <div class="col-xs-12 col-sm-12 no-padding margin-top-60">
    <div class="container  margin-bottom-60 margin-top-60 padding-bottom-20">
        <div class="col-xs-12 col-sm-offset-3 col-sm-6 bg-white">
                    <div class="box">
                        <h3> Change Password</h3>
                        <?php if($this->session->flashdata('msg')){?>
                            <div class="alert alert-success"><?=$this->session->flashdata('msg')?></div>
                        <?php }?>
                            <?php if($this->session->flashdata('error')){?>
                            <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
                        <?php }?>
                            <form action="<?=  current_url()?>" method="post">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" class="form-control"  name="current_password" data-validate="required">
                        <?=  form_error('current_password')!=''?form_error('current_password','<div class="err">','</div>'):''?>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control"  name="new_password" data-validate="required">
                        <?=  form_error('new_password')!=''?form_error('new_password','<div class="err">','</div>'):''?>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control"  name="confirm_password" data-validate="required">
                        <?=  form_error('confirm_password')!=''?form_error('confirm_password','<div class="err">','</div>'):''?>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"> Submit</button>
                    </div>
                </form>
                    </div>
                </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function(){
       $('#showhistory').click(function(){
           $('#order_history').show();
       }) 
    });
    </script>