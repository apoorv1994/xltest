<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding ">
    <div class="col-sm-12 no-padding m-t-20">
        <div class="container padding-bottom-20">
            <div class="row">
                <div class="col-sm-8 m-t-20">
                    <h3 class="col-sm-12">Get in <span class="bigger">touch</span></h3>
                    <p class="col-sm-12">Need to know more about services or want to share your feedback or suggestion? Fill the form below </p>
                    <form id="contactFrm" action="<?=  current_url()?>" method="post">
                        <div class="col-sm-12 no-padding">
                            <?php if($this->session->flashdata('msg')){?>
                            <p class="col-sm-12 alert alert-success"><?=$this->session->flashdata('msg')?></p>
                            <?php }?>
                            <?php if($this->session->flashdata('error')){?>
                            <p class="col-sm-12 alert alert-danger"><?=$this->session->flashdata('error')?></p>
                            <?php }?>
                            <div class="col-sm-6 margin-top-10">
                                <input type="text" class="form-control" value="<?=  set_value('name')?>" required="" name="name" placeholder="Name*">
                                <small class="col-sm-12 no-padding err" id="name_err"><?=  form_error('name')?></small>
                            </div>
                            <div class="col-sm-6 margin-top-10">
                                <input type="email" class="form-control" value="<?=  set_value('email')?>" required="" name="email" placeholder="Email*">
                                <small class="col-sm-12 no-padding err" id="email_err"><?=  form_error('email')?></small>
                            </div>
                        </div>
                        <div class="col-sm-12 no-padding">
                            <div class="col-sm-6 margin-top-10">
                                <input type="text" class="form-control" value="<?=  set_value('phone')?>" maxlength="10" required="" name="phone" placeholder="Phone*">
                                <small class="col-sm-12 no-padding err" id="phone_err"><?=  form_error('phone')?></small>
                            </div>
                            <div class="col-sm-6 margin-top-10">
                                <select class="form-control select2" required="" id="college_id" name="college">
                                    <option value="">College Name*</option>
                                    <?php foreach($colleges1 as $college){?>
                                    <option  <?=  set_value('college')==$college->college_name?'Selected':''?> value="<?=$college->college_name?>"><?=$college->college_name?></option>
                                    <?php }?>
                                </select>
                                <small class="col-sm-12 err" id="college_id_err"><?=  form_error('college')?></small>
                            </div>
                        </div>
                        <div class="col-sm-12 no-padding">
                            <div class="col-sm-2 margin-top-10">
                                Purpose :
                            </div>
                            <div class="col-sm-3 margin-top-10">
                                <input type="radio" name="purpose" checked="" value="Sales Inquiry" /> <span class="p-l-10"> Sales inquiry</span>
                            </div>
                            <div class="col-sm-3 margin-top-10">
                                <input type="radio" name="purpose"  value="<?=  set_value('purpose')=='Customer Support'?'checked':''?>" value="Customer Support" /> <span class="p-l-10"> Customer support</span>
                            </div>
                            <small class="col-sm-12 no-padding err" id="purpose_err"><?=  form_error('purpose')?></small>
                        </div>
                        <div class="col-sm-12 no-padding">
                            <div class="col-sm-12 margin-top-10">
                                <textarea class="form-control" required="" name="message" placeholder="Message" > <?=  set_value('message')?></textarea>
                                <small class="col-sm-12 no-padding err" id="message_err"><?=  form_error('message')?></small>
                            </div>
                        </div>
                        <div class="col-sm-12 margin-top-10">
                            <button class="form-control loginbtn size40" href="javascript:void(0)" id="contactBtn" type="submit" title="Update Info">Submit Query <i class="fa fa-arrow-right pull-right" id="loader_log"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4 p-l-40">
                    <div class="col-sm-12 no-padding m-t-40">
                        <div class="col-sm-12"><i class="pull-left fa fa-map-marker fa-2x"></i> <span class="pull-left color-blue p-l-10">OUR PRESENCE</span></div>
                        <div class="col-sm-11 col-sm-offset-1">
                            <?php foreach($colleges1 as $college){?>
                            <div class="col-sm-12 margin-bottom-10"><b><?=$college->college_name?></b></div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="col-sm-12 no-padding m-t-40">
                        <div class="col-sm-12"><!--<img class="img-responsive pull-left" src="<?=BASE?>assets/img/email.png" />--><i class="pull-left fa fa-envelope-o fa-2x"></i> <span class="pull-left color-blue p-l-10">EMAIL</span></div>
                        <div class="col-sm-11 col-sm-offset-1">
                            info@xpresslaundromat.in
                        </div>
                    </div>
                    <div class="col-sm-12 no-padding m-t-40">
                        <div class="col-sm-12"><i class="pull-left fa fa-user-secret fa-2x"></i>  <span class="pull-left color-blue p-l-10">CUSTOMER CARE</span></div>
                        <div class="col-sm-11 col-sm-offset-1">
                            info@xpresslaundromat.in
                        </div>
                    </div>
                    <div class="col-sm-12 no-padding m-t-40">
                        <div class="col-sm-12"><!--<img class="img-responsive pull-left" src="<?=BASE?>assets/img/opentime.png" />--><i class="pull-left fa fa-clock-o fa-2x"></i> <span class="pull-left color-blue p-l-10">STORE TIMINGS</span></div>
                        <div class="col-sm-11 col-sm-offset-1">
                            08:00 AM - 08:00 PM
                        </div>
                    </div>
                </div>
                <div style="border-bottom: 1px solid #ccc" class="col-sm-12 m-t-10"></div>
                <?php if($colleges){foreach($colleges as $contact){?>
                <div class="col-sm-12">
                    <div class="col-sm-3 no-padding m-t-40">
                        <div class="col-sm-12"><img class="img-responsive pull-left" src="<?=BASE?>assets/img/address.png" /> <span class="pull-left color-blue p-l-10">ADDRESS</span></div>
                        <div class="col-sm-11 col-sm-offset-1">
                            <b><?=$contact->college_name?></b><br>
                            <?=  nl2br($contact->address)?>
                        </div>
                    </div>
                    <div class="col-sm-2 no-padding m-t-40">
                        <div class="col-sm-12"><img class="img-responsive pull-left" src="<?=BASE?>assets/img/phone.png" /> <span class="pull-left color-blue p-l-10">PHONES</span></div>
                        <div class="col-sm-11 col-sm-offset-1">
                            <?php $phone = explode(',', $contact->phone);?>
                            +91-<?=$phone[0]?><br>
                            <?=$phone[1]!=''?'+91-'.$phone[1]:'' ?>
                            
                        </div>
                    </div>
                    <div class="col-sm-3 m-t-40">
                        <div class="col-sm-12"><img class="img-responsive pull-left" src="<?=BASE?>assets/img/email.png" /> <span class="pull-left color-blue p-l-10">EMAIL</span></div>
                        <div class="col-sm-11 col-sm-offset-1">
                            <?=$contact->email?>
                        </div>
                    </div>
                    <div class="col-sm-3 m-t-40 p-l-46">
                        <div class="col-sm-12"><img class="img-responsive pull-left" src="<?=BASE?>assets/img/opentime.png" /> <span class="pull-left color-blue p-l-10">OPEN HOURS</span></div>
                        <div class="col-sm-11 col-sm-offset-1">
                            <?=$college->store_timing?>
                        </div>
                    </div>
                </div>
                <?php }}?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.select2').select2();
    })
    </script>