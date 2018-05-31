<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">

<div class="col-lg-12">  
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Add User</h1>
                <ol class="breadcrumb">
                    <li><a href="<?=BASE?>panel"> <i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li class="active">Add User</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding-bottom:10px;">
                    <div class="row">
                        <h4 class="col-sm-8">Add User</h4>
                        
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-lg-12 margin-top-20">
                        <div class="panel-body">
                            <div class="col-sm-12" id="select_user">
                                
                             
                                <div class="col-sm-6 margin-top-20 padding-bottom-20" id="newuser" style=" border: 1px solid #ccc;">
                                    <form id="signupFrm" >
                                        <div class="col-sm-12">
                                            <div class="col-sm-12 no-padding">
                                                <div class="col-sm-6 no-padding margin-top-10">
                                                    <input type="text" class="form-control" name="firstname" placeholder="First Name*">
                                                    <small class="col-sm-12 no-padding" id="firstname_err"></small>
                                                </div>
                                                <div class="col-sm-6 no-padding margin-top-10">
                                                    <input type="text" class="form-control" name="lastname" placeholder="Last Name*">
                                                    <small class="col-sm-12 no-padding" id="lastname_err"></small>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 no-padding">
                                                <div class="col-sm-6 no-padding margin-top-10">
                                                    <input type="text" class="form-control" id="dob" name="dob" placeholder="Date Of Birth*">
                                                    <small class="col-sm-12 no-padding" id="dob_err"></small>
                                                </div>
                                                <div class="col-sm-6 no-padding margin-top-10">
                                                    <select class="form-control select2" style="width: 100%" name="gender">
                                                    <option value="">Gender*</option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                    </select>
                                                    <small class="col-sm-12 no-padding" id="gender_err"></small>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 no-padding">
                                                <div class="col-sm-6 no-padding margin-top-10">
                                                    <input type="text" class="form-control" name="rollnumber" placeholder="Roll Number*">
                                                    <small class="col-sm-12 no-padding" id="rollnumber_err"></small>
                                                </div>
                                                <div class="col-sm-6 no-padding margin-top-10">
                                                    <input type="text" class="form-control" name="phonenumber" placeholder="Phone Number*">
                                                    <small class="col-sm-12 no-padding" id="phonenumber_err"></small>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 no-padding margin-top-10">
                                                <select class="form-control select2" id="college_id" style="width: 100%" name="college_id">
                                                    <option value="">College Name*</option>
                                                    <?php foreach($colleges as $college){?>
                                                    <option value="<?=$college->id?>"><?=$college->college_name?></option>
                                                    <?php }?>
                                                </select>
                                                <small class="col-sm-12" id="college_id_err"></small>
                                            </div>
                                            <div class="col-sm-12 no-padding margin-top-10">
                                                <select class="form-control select2" style="width: 100%" id="hostel_id" name="hostel_id">
                                                    <option value="">Hostel Block*</option>
                                                </select>
                                                <small class="col-sm-12" id="hostel_id_err"></small>
                                            </div>
                                            <div class="col-sm-12 no-padding margin-top-10">
                                                <input type="text" class="form-control" name="roomnumber" placeholder="Room Number*">
                                                <small class="col-sm-12 no-padding" id="roomnumber_err"></small>
                                            </div>
                                            <div class="col-sm-12 no-padding margin-top-10">
                                                <input type="text" class="form-control" name="emailid" placeholder="Collage Email*">
                                                <small class="col-sm-12 no-padding" id="emailid_err"></small>
                                            </div>
                                            <div class="col-sm-12 no-padding margin-top-10">
                                                <button type="button" class="btn btn-primary signupbtn" id="signupbtn" name="signup">SIGN UP <i class="fa fa-arrow-right " id="loader"></i></button>
                                                <small id="main_err"></small>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    
 <script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" ></script>
        <script src="<?=BASE?>assets/plugins/moment/moment.min.js"></script>
        <script src="<?=BASE?>admin/select2/select2.min.js"></script>
        <script src="<?=BASE?>assets/js/quantity.js" ></script>

<script>
    $(document).ready(function(){
        
        $('.option').click(function(){
            var d = $(this).val();
            
                $('#signupFrm')[0].reset();
                $('.err').remove();
            
        });
        
        
        
        
        $('.select2').select2();
        
      
        
        
        
         $('#date').datepicker({
                      format: 'dd-mm-yyyy',
                      startDate: '+0d',
                      autoclose:true,
                      onSelect: function(dateText, inst) { do_action(dateText) }
                  });
         $('#dob').datepicker({
                      format: 'dd-mm-yyyy',
                      endDate: '-3650d',
                      autoclose:true
                  });
        
        
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
                            }else{
                                $('#hostel_id').html('<option value="">Select Hostel*</option>');
                                $('.select2').select2();
                            }
                      })
                  });
                  //for registration 
                  $('.signupbtn').click(function(){
                      $('#loader').addClass('fa-spin fa-spinner');
                      $('#main_err').html('');
                      var url = '<?=BASE?>panel/orders/signup';
                      var data = $('#signupFrm').serialize();
                      console.log(data);
                      $.post(url,data,function(success){
                            var res = JSON.parse(success);
                            if(res.status)
                            {
                                $('#loader').removeClass('fa-spin fa-spinner');
                                $('#loader').addClass('fa-arrow-right');
                                $('#main_err').html('<span class="success">Registered successfully</span>');
                                setTimeout(function(){$('#main_err').html('');},1000)
                                $('#signupFrm')[0].reset(); 

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
                  
                  
    });

   
    
    function get_user(url)
    {
        $("#user_body").html('<tr><td colspan="6" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i></td></tr>');
        var search = $('#search').val();
        var college_id = $('#scollege_id').val();
        var phone_no = $('#phone_no').val();
         if(url!='#' && url!=''){
           $.ajax({
           type: "POST",
           url: url,
           data:{search:search,college:college_id,phone_no:phone_no},
           success: function(res){
              $("#user_body").html(res);
            }
           });
           }
    }
    
    $('body').on('click','#paginate a',function(){
        var url=$(this).attr("href");
       get_user(url);
       return false;

       });
        
    
    </script>
    