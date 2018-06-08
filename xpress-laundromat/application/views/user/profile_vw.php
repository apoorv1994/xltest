<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg no-padding ">
<?php $this->load->view('home/wallet_vw');?>
    <div class="col-xs-12 col-sm-12 no-padding margin-top-60">
    <div class="container bg-white  margin-bottom-60 margin-top-60 padding-bottom-20">
        <div class="col-xs-12 col-sm-12 no-padding">
            <div class="col-xs-12 col-sm-3 padding-bottom-20 padding-top-20">
                <img src="<?=$details->profile_pic?>" style="max-height: 165px;" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-8 p-l-20">
                <h3 class="col-xs-12 col-sm-12"> <?=$details->firstname.' '.$details->lastname?></h3>
                <div class="col-xs-12 col-sm-6 border-right">
                    <!--<div class="col-xs-12 col-sm-12 no-padding">
                        <div class="col-xs-5 col-sm-6">Roll No.</div>
                        <div class="col-xs-7 col-sm-6">: <?=$details->roll_no?></div>
                    </div> -->
                    <div class="col-xs-12 col-sm-12 no-padding">
                        <div class="col-xs-5 col-sm-6">College Name</div>
                        <div class="col-xs-7 col-sm-6">: <?=$details->college_name?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 no-padding">
                        <div class="col-xs-5 col-sm-6">Hostel No.</div>
                        <div class="col-xs-7 col-sm-6">: <?=$details->hostel_name?></div>
                    </div>
                    <!--<div class="col-xs-12 col-sm-12 no-padding">
                        <div class="col-xs-5 col-sm-6">Room No</div>
                        <div class="col-xs-7 col-sm-6">: <?=$details->room_no?></div>
                    </div>-->
                
                
                    <div class="col-xs-12 col-sm-12 no-padding">
                        <div class="col-xs-5 col-sm-5">Phone No.</div>
                        <div class="col-xs-7 col-sm-7">: +91 <?=$details->phone_no?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 no-padding">
                        <div class="col-xs-5 col-sm-5">Email ID</div>
                        <div class="col-xs-7 col-sm-7">: <?=$details->email_id?></div>
                    </div>
                    <!--<div class="col-xs-12 col-sm-12 no-padding">
                        <div class="col-xs-5 col-sm-5">Gender</div>
                        <div class="col-xs-7 col-sm-7">: <?=$details->gender=='1'?'Male':'Female'?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 no-padding">
                        <div class="col-xs-5 col-sm-5">DOB</div>
                        <div class="col-xs-7 col-sm-7">: <?=date('d-m-Y',$details->dob)?></div>
                    </div>-->
                </div>
                <div class="col-xs-12 col-sm-8  m-t-10 upinfo">
                    <a class="form-control loginbtn" href="<?=BASE?>user/edit-profile" title="Update Info">Update Info <i class="fa fa-arrow-right pull-right" id="loader_log"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>