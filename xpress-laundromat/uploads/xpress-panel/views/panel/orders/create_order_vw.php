<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">

<div class="col-lg-12">  
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Create Order</h1>
                <ol class="breadcrumb">
                    <li><a href="<?=BASE?>panel"> <i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li class="active">Create Order</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding-bottom:10px;">
                    <div class="row">
                        <h4 class="col-sm-8">Create Order</h4>
                        <div class="col-sm-4 pull-right" id="wallet">

                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-lg-12 margin-top-20">
                        <div class="panel-body">
                            <div class="col-sm-12" id="select_user">
                                <div class="col-sm-12">
                                    <div class="col-sm-3"><input type="radio" checked="" class="option" name="user" value="existing" /> Search Existing User</div>
                                    <div class="col-sm-3"><input type="radio" name="user" class="option" value="new" /> Add New User</div>
                                </div>
                                <div class="col-sm-12" id="searchuser">
                                <div class="col-sm-12 margin-top-20">
                                    <div class="col-sm-3">
                                        <select class="form-control select2" name="filter_setting" id="scollege_id">
                                            <?php foreach($colleges as $college){?>
                                            <option <?=$this->input->get('filter_setting')==$college->id?'Selected':''?> value="<?=$college->id?>"><?=$college->college_name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Search user" />
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" id="searchBtn" class="btn btn-primary"  >Search</button>
                                    </div>
                                </div>
                                <div class="col-sm-12 margin-top-20">
                                    <table class="table table-striped table-hover" style="display: none;" id="usertable">
                                        <thead class="the-box dark full">
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Name</th>
                                                    <th>College Name</th>
                                                    <th>Hostel Name</th>
                                                    <th>Roll No</th>
                                                    <th>Email ID</th>
                                                    <th>Wallet Balance</th>
                                                </tr>
                                        </thead>
                                        <tbody id="user_body">

                                        </tbody>
                                    </table>
                                </div>
                                </div>
                                <div class="col-sm-6 margin-top-20 padding-bottom-20" id="newuser" style="display: none; border: 1px solid #ccc;">
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
                            <div class="col-sm-12" id="orderform" style="display: none;">
                                <form id="orderFrm">
                                <div class="col-sm-7">
                                    <button type="button" id="back" class="btn btn-warning margin-bottom-10"><i class="fa fa-arrow-left"></i> Back</button>
                                <div class="form-group row">
                                        <label class="col-sm-4">User Detail</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="user_name" readonly="" class="form-control" />
                                            <input type="hidden" id="user_id" name="user_id" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Select Wash Type</label>
                                        <div class="col-sm-8">
                                            <select class="select2" name="order_type" id="washtype" style="width:100%">
                                                <option value="">Select</option>
                                                <option value="bulkwashing">Bulk Wash</option>
                                                <option value="premium">Premium Wash</option>
                                                <option value="drycleaning">Dry Cleaning</option>
                                                <option value="individual">Individual Wash</option>
                                            </select>
                                            <input type="hidden" value="" id="slotcollege_id" name="college_id" />
                                            <!-- <input type="hidden" value="" id="slothostel_id" name="shostel_id"> -->
                                            <small class="col-sm-12 no-padding" id="order_type_err"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Select Date</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="date" name="slotday" placeholder="Date Of Booking">
                                            <small class="col-sm-12 no-padding" id="slotday_err"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Select Slot</label>
                                        <div class="col-sm-8">
                                            <select class="select2" name="slotInput" id="slotInput" style="width:100%">
                                                <option value="">Select</option>
                                                
                                            </select>
                                            <small class="col-sm-12 no-padding" id="slotInput_err"></small>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-4">Coupon</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" />
											<small class="col-sm-12 no-padding" id="coupon_code_err" style="display:none;"><div class="err">You Have Enter Wrong Coupon Code.</div></small>
                                        </div>
                                    </div>
                                
                                </div>
                                    <div class="col-sm-12" id="load_data">
                                        
                                    </div>
                                    <div class="col-sm-7" >
                                        <div class="form-group row">
                                        <label class="col-sm-4">Amount to Pay</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="total_price" class="form-control" style="width: 50%" id="total_price" />
                                            <small class="col-sm-12 no-padding" id="total_price_err"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 no-padding margin-top-5 m-b-40">
                                        <label class="col-sm-12">Select Payment Method</label>
                                        <div class="col-sm-6">
                                            <input type="radio" checked="" name="payment_type" value="1"> Wallet
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="radio" name="payment_type" value="2"> COD
                                        </div>
                                    </div>
                                    <div class="col-sm-12 no-padding margin-top-5 m-b-40">
                                        <div class="col-sm-6">
                                            <input type="radio" checked="" name="pickup" value="self_pickup"> SELF PICKUP
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="radio" name="pickup" value="avail_pickup"> AVAIL PICKUP
                                        </div>
                                    </div>
                                        <div class="col-sm-12 no-padding margin-top-20">
                                            <button type="button" id="orderBtn" class="btn btn-primary">Place Order</button>
                                            <div id="result"></div>
                                            <div id="error"></div>
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

                <!-- Modal wallet -->
<div class="modal fade" id="wallet_modal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
               Credit Amount
            </h4>
         </div>
          <form id="w_from">
          <div class="modal-body">
              <div class="row">
                  
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Enter Wallet Amount <i class="fa fa-inr"></i> * </label>
                        <div class="col-sm-6">
                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount">
                            <input type="hidden" id="w_user_id" name="user_id">
                            <div id="amount_err"></div>
                        </div>
                    </div>
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">MR No * </label>
                        <div class="col-sm-6">
                            <input type="text" name="transaction_no" class="form-control" placeholder="Enter Money Reciept No">
                            <div id="transaction_no_err"></div>
                        </div>
                    </div>
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Transaction Date </label>
                        <div class="col-sm-6">
                            <input type="text" name="transaction_date" class="form-control" id="tdate">
                            <div id="transaction_date_err"></div>
                        </div>
                    </div>
                  <div class="col-sm-12 margin-bottom-10">
                      <label class="col-sm-6">Description  </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="description" ></textarea>
                            <div id="description_err"></div>
                        </div>
                    </div>
                  
                  
              </div>
         </div>
         <div class="modal-footer">
             <div id="w_loader" class="col-sm-7 text-right"></div>
             <div class="col-sm-5">
             <button type="button" class="btn btn-primary" id="wBtn">
               Add Amount
            </button>
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">Close
            </button>
             </div>
            
         </div>
              </form>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


        <script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" ></script>
        <script src="<?=BASE?>assets/plugins/moment/moment.min.js"></script>
        <script src="<?=BASE?>admin/select2/select2.min.js"></script>
        <script src="<?=BASE?>assets/js/quantity.js" ></script>

<script>
    $(document).ready(function(){
        
        $('.option').click(function(){
            var d = $(this).val();
            if(d=='new')
            {
                $('#newuser').show();
                $('#searchuser').hide();
            }else{
                 $('#newuser').hide();
                $('#searchuser').show();
                $('#signupFrm')[0].reset();
                $('.err').remove();
            }
        });
        
        $('#back').click(function(){
            $('#orderFrm')[0].reset();
            $('#orderform').hide();
            $('#select_user').show();
            $('#wallet').html('');
            $('.option').each(function(){
                if($(this).is(':checked'))
                {
                    if($(this).val()=='user')
                    {
                        $('#usertable').show();
                    }
                    if($(this).val()=='new')
                    {
                        $('#signupFrm')[0].reset();
                        $('#newuser').show();
                    }
                }
            })
        })
        
        $('body').on('click','.user_check',function(){
            $('#orderform').show();
            $('#user_name').val($(this).data('name'));
            $('#user_id').val($(this).val());
            $('#slotcollege_id').val($(this).data('college'));
            //$('#slothostel_id').val($(this).data('hostel'));
            $('#select_user').hide();
            $('#wallet').html('<span style="color:green;padding-top:10px;float:left;">Wallet Balance: <i class="fa fa-inr"></i> <b id="wallet_b">'+$(this).data('balance')+'</b></span> <button class="btn btn-danger pull-right" onclick="load_walllet_modal('+$(this).val()+')"><i class="fa fa-plus"></i> Wallet</button>');
        })
        
        $('.select2').select2();
        
        $('#orderBtn').click(function(){
			$("#coupon_code_err").hide();
			var data = $('#orderFrm').serialize();
			var url1 = '<?=BASE?>panel/orders/checkCouponCode';
			$.post(url1,data,function(success){
               if(success=="1")
			   {
				   $("#coupon_code_err").hide();
					var url = '<?=BASE?>panel/orders/place-order';
					//console.log(data);
					$.post(url,data,function(success){
						var res = JSON.parse(success);
						if(res.status)
						{
							$('#result').html('<p class="success">Order Placed Successfully</p>');
							$('#error').html('');
							setTimeout(function(){window.location.href = '<?=BASE?>panel/orders/create-order';},1500);
						}else{
							var error = res.error;
							$.each( error, function( i, val ) 
							{
								$('#'+i).html(val);
							});
						}
					})
			   }
			   else
			   {
				   $("#coupon_code_err").show();
			   }
            })
            
        })
        
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
        $('#searchBtn').click(function(){
            
            if($('#search').val()!=''){
                $('#usertable').show();
                get_user('<?=BASE?>panel/orders/user_ajax/0')
            }else{
                alert('Please enter name');
                $('#search').focus();
            }
        })
        
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
                                $('#orderform').show();
                                $('#user_name').val(res.name);
                                $('#user_id').val(res.id);
                                $('#slotcollege_id').val(res.college);
                                //$('#slothostel_id').val(res.hostel);
                                $('#select_user').hide();
                                $('#wallet').html('<span style="color:green;padding-top:10px;float:left;">Wallet Balance: <i class="fa fa-inr"></i> <b id="wallet_b">0.00</b></span> <button class="btn btn-danger pull-right" onclick="load_walllet_modal('+res.id+')"><i class="fa fa-plus"></i> Wallet</button>')
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
                  
                  $('#washtype,#date').change(function(){
                        //console.log('Hey'+<?php echo $bprice_iron ?>);
                        var service = $('#washtype').val();
                        var day = $('#date').val();
                        var college_id = $('#slotcollege_id').val();
                        //var hostel_id = $('#slothostel_id').val();
                        //console.log(college_id);
                        //console.log(hostel_id);
                        if(service!='' && day!='')
                        {
                            var url = '<?=BASE?>panel/orders/check-slot-create';
                            $.post(url,{service:service,day:day,college:college_id},function(success){
                                var res = JSON.parse(success);
                                //console.log(res);
                                if(res.status)
                                {
                                    var m1='';var a1='';var e1='';var n1='';
                                    if(res.morning==0){m1='disabled';}
                                    if(res.afternoon==0){a1='disabled';}
                                    if(res.evening==0){e1='disabled';}
                                    if(res.night==0){n1='disabled';}
                                    var opt = '<option value="">Select Slot</option><option value="1" '+m1+'>Morning ('+res.morning+')</option><option value="2" '+a1+'>Afternoon ('+res.afternoon+')</option><option value="3" '+e1+'>Evening ('+res.evening+')</option><option value="4" '+n1+'>Night ('+res.night+')</option>';
                                    $('#slotInput').html(opt);
                                    $('.select2').select2();
                                    $('#load_data').html(res.data);
                                    if(service=='bulkwashing')
                                    {
                                        //console.log(res.bulk_price_iron);
                                        $('#total_price').val(res.bulk_price_iron);
                                    }
									else if(service=='individual')
                                    {
                                        //console.log(res.bulk_price_iron);
                                        $('#total_price').val(res.ind_wash);
                                    }
                                }else{
                                    $('#slotInput').html('<option value="">Select Slot</option>');
                                    $('.select2').select2();
                                    $('#load_data').html('');
                                }
                            })
                        }
                  })
    });

    function toggle_amt($val)
    {
        var iron = $('#def_iron_price').val();
        var fold = $('#def_fold_price').val();
        if($val == 0)
            $('#total_price').val(fold);
        else
            $('#total_price').val(iron);
    }
	
	function change_amt($val)
    {
        var wash = $('#ind_wash_price').val();
        var iron = $('#ind_iron_price').val();
		if($val == 0)
            $('#total_price').val(wash);
        else
            $('#total_price').val(iron);
    }
    
    
    function get_user(url)
    {
        $("#user_body").html('<tr><td colspan="6" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i></td></tr>');
        var search = $('#search').val();
        var college_id = $('#scollege_id').val();
         if(url!='#' && url!=''){
           $.ajax({
           type: "POST",
           url: url,
           data:{search:search,college:college_id},
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
    <script>
    function load_walllet_modal(id)
    {
       $('#w_user_id').val(id); 
       $('#wallet_modal').modal();
       $('#w_loader').html('');
       $('#amount_err').html('');
    }
    
    $(function(){
     $('#tdate').datepicker({
                      format: 'dd-mm-yyyy',
                      autoclose:true,
                      todayBtn: true
                  });
    
    $('#wBtn').click(function(){
        $('#w_loader').html('<i class="fa fa-spin fa-spinner"></i>');
        var url = '<?=BASE?>panel/user/add-wallet';
        var data = $('#w_from').serialize();
        $.ajax({
       type: "POST",
       url: url,
       async: false,
       data:data,
       success: function(res){
           var sus = JSON.parse(res);
             if(sus.status)
             {
                 $('#w_loader').html('<span class="success">Amount Added Successfully</span>');
                 setTimeout(function(){$('#w_loader').html('');},3000)
                 $('#w_from')[0].reset();
                 $('.close').click();
                 $('#wallet_b').html(sus.balance);
             }else{
                 var error = sus.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#w_loader').html('<span class="err">Error occured.</span>');
                setTimeout(function(){$('#w_loader').html('');},3000)
             }
        }
       });
    })
    });
    </script>