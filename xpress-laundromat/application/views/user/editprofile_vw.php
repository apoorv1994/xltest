<!-- START CONTAINER FLUID -->
<link rel="stylesheet" href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" />
<div class="container-fluid container-fixed-lg no-padding ">
<?php $this->load->view('home/wallet_vw');?>
    <div class="col-xs-12 col-sm-12 no-padding margin-top-60">
    <div class="container bg-white  margin-bottom-60 margin-top-60 padding-bottom-20">
        <div class="col-xs-12 col-sm-12 no-padding">
            <div class="col-sm-2 padding-bottom-20 padding-top-20">
                <img src="<?=$details->profile_pic?>" id="myimg" style="max-height: 165px;" class="img-responsive img-circle" />
                <button type="button" id="up_image" class="btn btn-info m-t-20 ">Change Image</button>
                <input type="file" class="m-t-20 hidden" id="profile_upload"  name="profile_pic" >
                <div id="editbtn"></div>
            </div>
            <div class="col-sm-9 p-l-20">
                <h3 class="col-sm-12"> Update Profile</h3>
                <form id="updateFrm">
                    <div class="col-sm-6 border-right" >
                    <div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">Name*</div>
                        <div class="col-sm-7">
                            <input type="text" name="firstname" class="form-control" value="<?=$details->firstname?>" />
                            <small class="col-sm-12 no-padding" id="firstname_err"></small>
                        </div>
                    </div>
                    <!--<div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">Roll No.*</div>
                        <div class="col-sm-7">
                            <input type="text" name="rollnumber" class="form-control" value="<?=$details->roll_no?>" />
                            <small class="col-sm-12 no-padding" id="rollnumber_err"></small>
                        </div>
                    </div> -->
                    <div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">College Name*</div>
                        <div class="col-sm-7">
                            <select class="form-control select2" id="college_id" disabled="" name="college_id">
                                    <option value="">College Name</option>
                                    <?php foreach($colleges as $college){?>
                                    <option <?=$details->college_id==$college->id?'Selected':''?> value="<?=$college->id?>"><?=$college->college_name?></option>
                                    <?php }?>
                                </select>
                            <small class="col-sm-12 no-padding" id="college_id_err"></small>
                        </div>
                    </div>
                    <div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">Hostel Name*</div>
                        <div class="col-sm-7">
                            <select class="form-control select2" id="hostel_id" name="hostel_id">
                                <option value="">Hostel Block</option>
                            </select>
                            <small class="col-sm-12 no-padding" id="hostel_id_err"></small>
                        </div>
                    </div>
                    <!--<div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">Room No*</div>
                        <div class="col-sm-7">
                            <input type="text" name="roomnumber" class="form-control" value="<?=$details->room_no?>" />
                            <small class="col-sm-12 no-padding" id="roomnumber_err"></small>
                        </div>
                    </div>-->
                </div>
                <div class="col-sm-6">
                    <!--<div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">Last Name*</div>
                        <div class="col-sm-7">
                            <input type="text" name="lastname" class="form-control" value="<?=$details->lastname?>" />
                            <small class="col-sm-12 no-padding" id="lastname_err"></small>
                        </div>
                    </div> -->
                    <div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">Phone No.*</div>
                        <div class="col-sm-7">
                            <input type="text" name="phonenumber" class="form-control" value="<?=$details->phone_no?>" />
                            <small class="col-sm-12 no-padding" id="phonenumber_err"></small>
                        </div>
                    </div>
                    <div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">Email ID*</div>
                        <div class="col-sm-7"><input type="text" readonly="" class="form-control" value="<?=$details->email_id?>" /></div>
                    </div>
                    <!--<div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">Gender*</div>
                        <div class="col-sm-7">
                            <select class="form-control select2" name="gender">
                                <option value="">Gender</option>
                                <option <?=$details->gender==1?'Selected':''?>  value="1">Male</option>
                                <option <?=$details->gender==2?'Selected':''?>  value="2">Female</option>
                            </select>
                            <small class="col-sm-12 no-padding" id="gender_err"></small>
                        </div>
                    </div>
                    <div class="col-sm-12 no-padding m-t-10">
                        <div class="col-sm-5">DOB*</div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="dob" value="<?=date('d-m-Y',$details->dob)?>" name="dob" placeholder="Date Of Birth*">
                            <small class="col-sm-12 no-padding" id="dob_err"></small>
                        </div>
                    </div>
                </div>-->
                <div class="col-sm-8  m-t-10 upinfo">
                    <a class="form-control loginbtn" id="update_profile" href="javascript:void(0)" title="Update Info">Update Info <i class="fa fa-arrow-right pull-right" id="loader"></i></a>
                    <small id="main_err"></small>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" ></script>
          <script src="<?=BASE?>assets/plugins/moment/moment.min.js"></script>
<script>
    $(document).ready(function(){
    $('#dob').datepicker({
                      format: 'dd-mm-yyyy',
                      endDate: '-3650d',
                      autoclose:true
                  });
                  $('.select2').select2();
                  
                  $('#college_id').change(function(){
                        var id = $(this).val();
                        var url = '<?=BASE?>auth/get-hostel/'+id;
                        $.get(url,function(success){
                            var opt ='';
                            var res = JSON.parse(success);
                            if(res.status)
                            {
                                var len = res.data.length;
                                for(var i=0;i<len;i++)
                                {
                                    opt+='<option value="'+res.data[i].id+'">'+res.data[i].hostel_name+'</option>';
                                }
                                $('#hostel_id').html(opt);
                            }
                      })
                  });
                  setTimeout(function(){$('#college_id').change();},500);
                  setTimeout(function(){$('#hostel_id').val(<?=$details->hostel_id?>).change();},1500);
                  
                  $('#update_profile').click(function(){
                      $('#loader').addClass('fa-spin fa-spinner');
                      $('#main_err').html('');
                      var url = '<?=BASE?>user/update-profile';
                      var data = $('#updateFrm').serialize();
                      $.post(url,data,function(success){
                            var res = JSON.parse(success);
                            if(res.status)
                            {
                                $('#loader').removeClass('fa-spin fa-spinner');
                                $('#loader').addClass('fa-arrow-right');
                                $('#main_err').html('<span class="success">Updated successfully</span>');
                                window.location.href = '<?=BASE?>'+res.rdir;
                            }
                            else
                            {
                                var error = res.error;
                                $.each( error, function( i, val ) 
                                {
                                    $('#'+i).html(val);
                                });
                                $('#loader').removeClass('fa-spin fa-spinner');
                                $('#loader').addClass('fa-arrow-right');
                                $('#main_err').html('<span class="err">Error occured.</span>');
                            }
                      })
                  });
                  
                  $('#up_image').click(function(){$('#profile_upload').trigger('click');})
                  $('#profile_upload').on('change', function() {
    $('#editbtn').html('<i class="fa fa-spin fa-spinner"></i>');
    var file_data = $('#profile_upload').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                          
    $.ajax({
                url: '<?=BASE?>user/upload-profile', // point to server-side PHP script 
                 // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                async:false,
                data: form_data,                         
                type: 'post',
                success: function(res){
                    var obj=jQuery.parseJSON(res);
                   if(obj.status)
                   {
                       $('#myimg').attr('src',obj.data);
                       $('#editbtn').html('');
                   }
                   else{
                       $('#editbtn').html('<span class="err">'+obj.data+'</span>');
                   }
                }
     });
});
                  });
    </script>