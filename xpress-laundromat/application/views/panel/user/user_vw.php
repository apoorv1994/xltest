<!-- BEGIN PAGE CONTENT -->
<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
<?php 
$college_id="";
if($this->input->get('college_id')){$college_id=base64_decode($this->input->get('college_id'));}
?>
           <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Users
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=BASE?>panel/home"><i class="fa fa-home"></i></a></li>
                        <li class="active">User</li>
                    </ol>
                </div>
            </div>
                <!-- /.row -->
<!-- BEGIN DATA TABLE -->
<div class="row">
<div class="col-sm-12">
    
    <?php if($msg){?>
    <div class="alert alert-success fade in ">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       <?=$msg?>
    </div>
    <?php }?>
    <?php if($error){?>
    <div class="alert alert-danger fade in ">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       <?=$error?>
    </div>
    <?php }?>
    <div class="panel panel-default tmargin30">
  <div class="panel-heading">
    <h4>Import User </h4>
<!--    <h5><strong>Note :</strong> Admin can <strong>Add/Deduct</strong> Amount <strong>to/from</strong> Wallet</h5>-->
  </div>
  <div class="panel-body">
    <form enctype="multipart/form-data" action="<?=BASE?>panel/user/import-users" method="post">
    <div class="col-lg-12">
        <div class="col-sm-4">
            <select class="form-control select2" required="" name="college_id">
                <option value="">College Name*</option>
                <?php foreach($colleges as $college){?>
                <option value="<?=$college->id?>"><?=$college->college_name?></option>
                <?php }?>
            </select>
        </div>
        <div class="col-sm-6">
            <input name="fwallet" id="fwallet" required="" type="file">
        </div>
    
    </div>
     <div class="pull-right">
     <input value="Upload" class="btn btn-primary" type="Submit">
     <a href="<?=BASE?>admin/csv/example.csv" target="_blank" class="btn btn-default">Get Template</a>
     </div>
     </form>
  </div>

</div>
<div class="panel panel-default tmargin30">
  <div class="panel-heading">
    <h4>User List </h4>
  </div>
  <div class="panel-body">
      <div class="col-sm-4">
          <select class="form-control select2" style="height: 34px;" id="college_id" name="college_id">
                <?php if($this->session->user_type==1){?><option value="">All College</option><?php }?>
                <?php foreach($colleges as $college){?>
                <option value="<?=$college->id?>" <?php if($college_id==$college->id){echo 'selected="selected"';}?>><?=$college->college_name?></option>
                <?php }?>
            </select>
      </div>
	   <div class="col-sm-4">
         <input type="text" id="phone_no" name="phone_no" class="form-control" placeholder="Phone Number">
      </div>
    <div class="col-sm-4 margin-bottom-20">
        <div class="col-sm-6">
            <input type="text" id="search" class="form-control" placeholder="Search">
        </div>
        <div class="col-sm-6">
            <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
        </div>
    </div>
    <div class="col-sm-2 margin-bottom-20">
        <div class="input-group pull-right" style="margin-left: 10px;">
            <a href="<?=BASE?>panel/user/export" id="exportExcel" class="btn btn-success" target="_blank" title="Export Excel"><i class="fa fa-file-excel-o"></i></a>
        </div>
    </div>
<table class="table table-striped table-hover" id="example-datatable">
        <thead class="the-box dark full">
                <tr>
                    <th>Name <i class="fa fa-sort sort" data-sort="" id="firstname"></i></th>
                    <th>College Name</th>
                    <th>Roll No</th>
                    <th>Email ID</th>
                    <th>Wallet Balance <i class="fa fa-sort sort" data-sort="" id="created"></i></th>
                    <th>Action</th>
					<th>SMS</th>
					<th>Email</th>
                </tr>
        </thead>
        <tbody id="user_body">
            
        </tbody>
</table>
</div><!-- /.the-box .default -->
<!-- END DATA TABLE -->
</div>
</div>
    <!-- Button trigger modal -->

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

<!-- Modal reset password -->
<div class="modal fade" id="reset_modal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
                Reset Password of <span id="r_user"></span>
            </h4>
         </div>
          <form id="r_from">
          <div class="modal-body">
              <div class="row">
                  
                  <div class="col-sm-12">
                      <label class="col-sm-6 margin-bottom-10">Enter New Password * </label>
                        <div class="col-sm-6 margin-bottom-10">
                            <input type="password" name="password" class="form-control">
                            <input type="hidden" id="r_user_id" name="user_id">
                            <div id="password_err"></div>
                        </div>
                      <label class="col-sm-6">Confirm Password * </label>
                        <div class="col-sm-6">
                            <input type="password" name="cpassword" class="form-control">
                            <div id="cpassword_err"></div>
                        </div>
                    </div>
                  
              </div>
         </div>
         <div class="modal-footer">
             <div id="r_loader" class="col-sm-7 text-right"></div>
             <div class="col-sm-5">
             <button type="button" class="btn btn-primary" id="rBtn">
               Submit
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

<div class="modal fade" id="smsEmailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="smsEmailModalLabel">New Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form enctype="multipart/form-data" action="" method="post" name="auotMsg" id="auotMsg">
      <div class="modal-body" id="messageBody">
      </div>
      <div class="modal-footer">
		<p id="error_message" style="color:red;display:none;"></p>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="return check_validation();">Send</button>
      </div>
	  </form>
    </div>
  </div>
</div>
    
    <script src="<?=BASE?>admin/select2/select2.min.js"></script>
            <script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" ></script>
        <script src="<?=BASE?>assets/plugins/moment/moment.min.js"></script>
<script>
    
    function load_walllet_modal(id)
    {
       $('#w_user_id').val(id); 
       $('#wallet_modal').modal();
       $('#w_loader').html('');
       $('#amount_err').html('');
    }
    
    function load_reset_modal(id,name)
    {
       $('#r_user_id').val(id); 
       $('#r_loader').html('');
       $('#r_user').html(name);
       $('#password_err').html('');
       $('#cpassword_err').html('');
       $('#reset_modal').modal();
    }
    
    function modal_load(val,msg)
    {
        $('#confirm_body').text(msg);
        $('button.confirm').prop('id',val);
    }
</script>
<script>
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
                 get_user('<?=BASE?>panel/user/user_ajax/0','','');
                 $('.close').click();
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
    
    $('#rBtn').click(function(){
        $('#r_loader').html('<i class="fa fa-spin fa-spinner"></i>');
        var url = '<?=BASE?>panel/user/change-user-password';
        var data = $('#r_from').serialize();
        $.ajax({
       type: "POST",
       url: url,
       async: false,
       data:data,
       success: function(res){
           var sus = JSON.parse(res);
             if(sus.status)
             {
                 $('#r_loader').html('<span class="success">Password changed Successfully</span>');
                 $('#r_from')[0].reset();
                 $('.close').click();
             }else{
                 var error = sus.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#r_loader').html('<span class="err">Error occured.</span>');
             }
        }
       });
    })
    $('body').on('click','.del',function(){
    if(confirm('do you really want to delete this user?'))
    {
        window.location.href = $(this).data('href');
    }
    })
    
    $('.select2').select2();
    get_user('<?=BASE?>panel/user/user_ajax/0','','');
    $('body').on('click','#paginate a',function(){
        var sortby = '';
        var sortas = '';
        $('.sort').each(function(){
            if($(this).data('sort')=='asc' || $(this).data('sort')=='asc')
            {
                sortby = $(this).attr('id');
                sortas = $(this).data('sort');
                return false;
            }
        })
        var url=$(this).attr("href");
       get_user(url,sortby,sortas);
       return false;

       });
       $('#college_id').change(function(){
           get_user('<?=BASE?>panel/user/user_ajax/0','','');
       });
       $('#searchBtn').click(function(){
           get_user('<?=BASE?>panel/user/user_ajax/0','','');
       });
       $('body').on('click','.sort',function(){
           var sort = $(this).data('sort');
           var sortby = $(this).attr('id');
           var sortas = 'asc';
           if(sort == 'asc')
           {
               sortas = 'desc';
           }
           get_user('<?=BASE?>panel/user/user_ajax/0',sortby,sortas);
       })
    
});

function get_user(url,sortby,sortas)
{
    $("#user_body").html('<tr><td colspan="6" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i></td></tr>');
    var search = $('#search').val();
    var college_id = $('#college_id').val();
	var phone_no = $('#phone_no').val();
     if(url!='#' && url!=''){
       $.ajax({
       type: "POST",
       url: url,
       data:{search:search,sort:sortby,sortas:sortas,college:college_id,phone_no:phone_no},
       success: function(res){
          $("#user_body").html(res);
          $('#name,#created').removeAttr('class')
          
          if(sortby=='name')
          {
              $('#'+sortby).data('sort',sortas)
              $('#'+sortby).addClass('sort fa fa-sort-'+sortas);
              $('#created').addClass('fa fa-sort sort');
            }
          else if(sortby=='created'){
              $('#'+sortby).data('sort',sortas)
              $('#name').addClass('fa fa-sort sort');
              $('#'+sortby).addClass('sort fa fa-sort-'+sortas);
          }else{
              $('#created,#name').data('sort','');
              $('#created').addClass('fa fa-sort sort');
              $('#name').addClass('sort fa fa-sort');
          }
              
        }
       });
       }
}

function send_sms_email(user_id,college_id,type)
{
	$("#error_message").html("");
	var url = '<?=BASE?>panel/user/sms-email-template';
	$.ajax({
	type: "POST",
	url: url,
	data:{user_id:user_id,college_id:college_id,type:type},
	success: function(res){
		$("#messageBody").html(res);
	}
	});
	 $('#auotMsg')[0].reset();
	$('#smsEmailModal').modal();
}

function check_validation()
{
	$("#error_message").html("");
	var isChecked = $("input[name=message_type]:checked").val();
     if(!isChecked){
		 $("#error_message").show();
         $("#error_message").html("Please Select a Option");
		 return false;
     }else{
		 var option_no=$("input[name=message_type]:checked").val();
		 var type=$("#type").val();
		 if(type=='2' && (option_no=='1' || option_no=='2' || option_no=='3' || option_no=='4'))
		 {
			if($("#subject").val()=='')
			{
				 $("#error_message").html("Please Enter Subject");
				 return false;
			}
			else if($("#message_"+option_no).val()=='')
			{
				 $("#error_message").html("Please Enter Message");
				 return false;
			}
			else
			{
				$("#error_message").hide();
				$("#error_message").html("");
				save_form();
			}
		 }
		 else if(type=='2' && option_no=='5')
		 {
			if($("#subject").val()=='')
			{
				 $("#error_message").html("Please Enter Subject");
				 return false;
			}
			else if($("#message_"+option_no).val()=='')
			{
				 $("#error_message").html("Please Enter Message");
				 return false;
			}
			else if($("#photo").val()=='')
			{
				 $("#error_message").html("Please Upload a File");
				 return false;
			}
			else
			{
				$("#error_message").hide();
				$("#error_message").html("");
				save_form();
			}
		 }
		 else if(type=='1')
		 {
			if($("#message_"+option_no).val()=='')
			{
				 $("#error_message").html("Please Enter Message");
				 return false;
			}
			else
			{
				$("#error_message").hide();
				$("#error_message").html("");
				save_form();
			}
		 }
		 else
		 {
			 $("#error_message").hide();
			 $("#error_message").html("");
			 save_form();
		 }
	 }
}

function show_option_data(id,type)
{
	if(id=='1')
	 {
		 $("#message_1").show();
		 $("#message_2").hide();
		 $("#message_3").hide();
		 $("#message_4").hide();
		 $("#message_5").hide();
		 $("#photo").hide();
		 if(type=='2')
		 {
			 $("#subject").show();
		 }
		 else
		 {
			 $("#subject").hide();
		 }
		 
	 }
	 else if(id=='2')
	 {
		 $("#message_1").hide();
		 $("#message_2").show();
		 $("#message_3").hide();
		 $("#message_4").hide();
		 $("#message_5").hide();
		 $("#photo").hide();
		 if(type=='2')
		 {
			 $("#subject").show();
		 }
		 else
		 {
			 $("#subject").hide();
		 }
	 }
	 else if(id=='3')
	 {
		 $("#message_1").hide();
		 $("#message_2").hide();
		 $("#message_3").show();
		 $("#message_4").hide();
		 $("#message_5").hide();
		 $("#photo").hide();
		 if(type=='2')
		 {
			 $("#subject").show();
		 }
		 else
		 {
			 $("#subject").hide();
		 }
	 }
	 else if(id=='4')
	 {
		 $("#message_1").hide();
		 $("#message_2").hide();
		 $("#message_3").hide();
		 $("#message_4").show();
		 $("#message_5").hide();
		 $("#photo").hide();
		 $("#subject").show();
	 }
	 else if(id=='5')
	 {
		 $("#message_1").hide();
		 $("#message_2").hide();
		 $("#message_3").hide();
		 $("#message_4").hide();
		 $("#message_5").show();
		 $("#photo").show();
		 $("#subject").show();
	 }
}

function save_form()
{
	
	 var url = '<?=BASE?>panel/user/send-auto-mail';
	 //var data = $('#auotMsg').serialize();
	 var data = new FormData($('#auotMsg')[0]);
	 //console.log(data);
	 //alert(data);
	 $.ajax({
	 type: "POST",
	 url: url,
	 data:data,
	 async: false,
	 success: function(res){
		 //console.log(res);
		 //alert(res);
		 var sus = JSON.parse(res);
		 console.log(sus);
		 alert(sus['data']);
		 $('#smsEmailModal').modal('hide');
		 },
		 cache: false,
		 contentType: false,
		 processData: false,
		 error: function(){
			  alert('error handing here');
		 }
 
 
	});
}
	
</script>