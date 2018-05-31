<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">

<div class="col-lg-12">  
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Drop Off</h1>
                <ol class="breadcrumb">
                    <li><a href="<?=BASE?>panel"> <i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li class="active">Manage Drop Off</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">

    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="padding-bottom:10px;">
            <div class="row">
            <h4 class="col-sm-8">Manage Drop Off</h4>
            <div class="col-sm-4 pull-right">
                <form method="get" id="filterFrm">
                    <select class="form-control select2" name="filter_college" id="filter_college">
                        <?php foreach($colleges as $college){?>
                        <option <?=$this->input->get('filter_setting')==$college->id?'Selected':''?> value="<?=$college->id?>"><?=$college->college_name?></option>
                        <?php }?>
                </select>
            </form>
            </div>
            </div>
        </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" class="washtype" id="bulk1" data-id="1" href="#bulkwash">Bulk Wash </a></li>
            <li><a data-toggle="tab" data-id="4" class="washtype" id="indi1" href="#shoewash">Individual Wash</a></li>
            <li><a data-toggle="tab" data-id="2" class="washtype" id="prem1" href="#indi_wash">Premium Wash</a></li>
            <li><a data-toggle="tab" data-id="3" class="washtype" id="dry1" href="#dry_clean">Dry Cleaning</a></li>
            <input type="hidden" id="washtype" value="1">
        </ul>
        <div class="col-lg-12 margin-top-20">
            <div class="panel-body">
                <div class="col-sm-12 margin-bottom-20 no-l-pad no-r-pad">
                <div class="col-sm-12  margin-bottom-20">
                    <div class="col-sm-2"><button class="btn btn-default btn-primary form-control slotBtn" value="all" type="button">All</button></div>
                    <div class="col-sm-10 no-padding">
                    <div class="col-sm-3"><button class="btn btn-default btn-default form-control slotBtn" value="1" type="button">Morning</button></div>
                    <div class="col-sm-3"><button class="btn btn-default form-control slotBtn" value="2" type="button">Afternoon</button></div>
                    <div class="col-sm-3"><button class="btn btn-default form-control slotBtn" value="3" type="button">Evening</button></div>
                    <div class="col-sm-3"><button class="btn btn-default form-control slotBtn" value="4" type="button">Night</button></div>
                    </div>
                    <input type="hidden" id="slot_type" value="all" />
                </div>
                    <div class="col-sm-4">
                    <button class="btn btn-warning" id="outdeliveryBtn" data-toggle="modal" data-target="#deliveryModal" type="button">Out to deliver</button>
                    <button class="btn btn-primary" id="completedBtn" type="button">Completed</button><br>
                    <span id="loader1" class="err"></span>
                    </div>
                <div class="col-lg-3">
                        <div class="input-group pull-left">
                      <button class="btn btn-info pull-right" id="daterange-btn">
                        <i class="fa fa-calendar"></i> Filter By date
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="col-sm-7">
                    <input name="search" id="search" class="form-control" placeholder="Search">
                    </div>
                    <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
                    <button type="button" id="clearBtn" class="btn btn-default">Clear</button>
                </div>
                
                </div>
                <?php if($this->session->flashdata('msg')!=''){?>
                <div class="col-sm-12 alert alert-success margin-top-10 margin-bottom-10"><?=$this->session->flashdata('msg')?></div>
                <?php }?>
                <?php if($this->session->flashdata('error')!=''){?>
                <div class="col-sm-12 alert alert-danger margin-top-10 margin-bottom-10"><?=$this->session->flashdata('error')?></div>
                <?php }?>
                <div class="col-sm-12"  style="overflow-x: scroll;">
                <form id="dropfrm">
                <table class="table table-striped table-hover" id="example-datatable">
                    <thead class="the-box dark full">
                        <tr>
                            <th><input type="checkbox" name="all" value="all"  id="allcheck" /></th>
                            <th>S.No</th>
                            <th>Token No</th>
                            <th>Booking Date</th>
                            <th>Payment Method</th>
                            <th>Student Detail</th>
                            <th>Drop Off Time</th>
                            <!--<th>Drop Off SMS</th>-->
                            <th>Drop Reminder Mail</th>
                            <th>Drop Reminder SMS</th>
							<th>Invoice</th>
                            <th>Completed</th>
                        </tr>
                    </thead>
                    <tbody id="order_body">

                    </tbody>
                </table>
                    
                </form>
                </div>
            </div>
        </div>  
    </div>
        
  </div>
 </div>
</div>
</div>
<!-- modal -->

<div id="reminderModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

            <!-- Modal content-->
            <div class="row modal-content">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Confirm</h4>
              </div>
                <form method="post" id="reminderFrm">
              <div class="modal-body">
                  <input type="hidden"  id="rorder_id" name="order_id">
                    <div class="form-group">
                            Are you really want to send Notification?
                    </div>


              </div>
                    <div class="modal-footer">
                        <div id="r_loader"></div>
                        <button type="button" class="btn btn-default" 
                           data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-primary" id="rBtn">
                           Confirm
                        </button>
                     </div>
                </form>
            </div>

      </div>
    </div>

<div id="deliveryModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

            <!-- Modal content-->
            <div class="row modal-content">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Confirm for Out to Delivery</h4>
              </div>
                <form method="post" id="dFrm">
              <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12 col-sm-offset-2">Select Drop off time</label>
                            <div class="col-sm-5 col-sm-offset-2">
                                <input type="text" class="form-control" id="d_date" name="d_date" />
                            </div>
                            <div class="col-sm-3">
                                <select name="d_time" id="d_time" class="form-control ">
                                    <option value="">Select Time</option>
                                    <?php foreach($dtime as $time){?>
                                    <option value="<?=$time['dtime']?>"><?=$time['dtime']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>


              </div>
                    <div class="modal-footer">
                        <span class="err" id="loader"></span>
                        <button type="button" class="btn btn-default" 
                           data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-primary" id="dBtn">
                           Confirm
                        </button>
                        
                     </div>
                </form>
            </div>

      </div>
    </div>

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
      <script src="<?=BASE?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?=BASE?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" ></script>

<script>
    $(document).ready(function(){
        $('.select2').select2();
        $('#filter_college').change(function(){fetch_orders(0);});
        $('#d_date').datepicker({format: 'dd-mm-yyyy',
                      startDate: '+0d',
                      autoclose:true})
        setTimeout(function(){
            if(localStorage.getItem('clicked1'))
            {
                $('#'+localStorage.getItem('clicked1')).click();
            }else{
            fetch_orders(0);
            }},1000);
         $('#daterange-btn').daterangepicker(
            {
              ranges: {
                  'All Upcoming' : [moment().subtract(1, 'months'), moment().add(2, 'days')],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()]
              },
              startDate: moment().subtract(1, 'months'),
              endDate: moment().add(2, 'days')
            },
        function (start, end) {
          fetch_orders(0);
        }
        );
        
        $('.washtype').click(function(){
            $('#washtype').val($(this).data('id'));
            localStorage.setItem('clicked1',$(this).attr('id'));
            fetch_orders(0);
        })
        
        $('.slotBtn').click(function(){
           $('.slotBtn').removeClass('btn-primary');
           $(this).addClass('btn-primary');
           $('#slot_type').val($(this).val());
           fetch_orders(0);
        })
        
        $('#searchBtn').click(function(){
            fetch_orders(0);
        })
        $('#clearBtn').click(function(){
            $('#search').val('');
            fetch_orders(0);
        })

          $('body').on('click','#paginate a',function(e){
            if(!$(this).parent().hasClass('active'))
            {
                e.preventDefault();
                var page = ($(this).attr("href")).split('/');
                var page_number = page[page.length-1];
                if(page_number)
                fetch_orders(page_number);
            else{
                fetch_orders(0);
            }
            }
                return false;
            
       });
       
       
       $('body').on('click','.reminder',function(){
            $('#r_loader').html('');
            $('#rorder_id').val($(this).data('id'));
            $('#reminderModal').modal();
       })
       
       $('#rBtn').click(function(){
           $('#r_loader').html('<i class="fa fa-spin fa-spinner"></i>');
           var url = '<?=BASE?>panel/orders/pickup-sms';
           var data = $('#reminderFrm').serialize();
           $.post(url,data,function(success){
               var res = JSON.parse(success);
               if(res.status)
               {
                   $('#r_loader').html('<span class="success">Reminder Sent</span>');
                   $('#reminderModal').modal('hide');
               }else{
                   $('#r_loader').html('<span class="err">Error Occured</span>')
               }
           })
       });
       
       $('body').on('click','.order_slip',function(){
            var id = $(this).data('id');
            $('#orderform_'+id).trigger('submit');
       })
       
       $('body').on('click','.completeBtn',function(){
            $('#confirm_body').text('Do you really want to mark complete this order');
            $('button.confirm').attr('id',$(this).data('href'));
            $('#confirm').modal();
       })
       
         $('body').on('click','#allcheck',function(){
            if($(this).is(':checked'))
            {
                $('.chks').prop('checked',true);
            }else{
                $('.chks').prop('checked',false);
            }
       })
       $('body').on('click','.chks',function(){
           if(!$(this).is(':checked'))
           {
               $('#allcheck').prop('checked',false);
           }
       });
       
       $('body').on('click','#completedBtn',function(){
           var data = $('#dropfrm').serialize();
           if(data!='')
            {
                if(confirm('Do you really want to mark completed these orders'))
                {
                    var url = '<?=BASE?>panel/orders/bulk-completed'
                    $.post(url,data,function(success){
                        var res = JSON.parse(success);
                        if(res.status)
                        {
                            window.location.href = '<?=  current_url()?>';
                        }else{
                            $('#loader1').html('Something went wrong, Please try again.');
                    setTimeout(function(){ $('#loader1').html('');},4000)
                        }
                    })
                }
            }else{
                    $('#loader1').html('Please select atleast one order.');
                    setTimeout(function(){ $('#loader1').html('');},4000)
                }
       })
       
       $('#dBtn').click(function(){
        var url = '<?=BASE?>panel/orders/bulk-delivery';
        var data1 = $('#dropfrm').serialize();
        var data = $('#dFrm, #dropfrm').serialize();
        if(data1!='')
        {
            if(($('#d_date').val()!='' && $('#d_time').val()=='') || ($('#d_date').val()=='' && $('#d_time').val()!=''))
            {
                $('#loader').html('Please enter date and time both.');
                setTimeout(function(){ $('#loader').html('');},4000)
            }
            else{
                $.post(url,data,function(success){
                    var res = JSON.parse(success);
                    if(res.status)
                    {
                        window.location.href = '<?=  current_url()?>';
                    }else{
                        $('#loader').html('Something went wrong, Please try again.');
                        setTimeout(function(){ $('#loader').html('');},4000)
                    }
                })
            }
        }
        else{
            $('#loader').html('Please select atleast one order.');
            setTimeout(function(){ $('#loader').html('');},4000)
            }
       })
       
    });
    
    function fetch_orders(id)
    {
        $("#order_body").empty().append('<tr><td colspan="12" style="text-align: center;"><i class="fa fa-spinner fa-pulse fa-3x"></i></td></tr>');
        var search = $('#search').val();
        var date_from = $('input[name="daterangepicker_start"]').val();
        var date_to = $('input[name="daterangepicker_end"]').val();
        var slot_type = $('#slot_type').val();
        var washtype = $('#washtype').val();
        var college_id = $('#filter_college').val();
        if(id==''){ id=0;}
        $.ajax({
       type: "POST",
       url: '<?=BASE?>panel/orders/dropoff-call/'+id,
       data:{ date_from:date_from, date_to:date_to, search: search,slot_type:slot_type,college_id:college_id,washtype:washtype},
       success: function(res){
           var data = JSON.parse(res);
           var j = parseInt(id);
           var slot = ['','Morning','Afternoon','Evening','Night'];
           if(data.res)
           {
               var userdata = '';
               var holder = data.rows;
               var length = holder.length;
               for(var i =0; i< length; i++)
               {   
                   var token_no = '';var dropoff_time='';
                   if(null !=holder[i].token_no){token_no=holder[i].token_no}
                    if(null !=holder[i].dropoff_time){dropoff_time=holder[i].dropoff_time}
                   var paym='';
                   
                    userdata += '<tr><td><input type="checkbox" name="order_action[]"  class="chks" id="acn_'+holder[i].id+'" value="'+holder[i].id+'" /></td>'+
                            '<td>'+(j+1)+'</td>'+
                            '<td ><span id="t_'+holder[i].id+'">'+token_no+'</span></td>'+
                        '<td>'+holder[i].book_date+'</td>';
                        if(holder[i].payment_type==1){paym = '<label class="label label-success">Wallet</label>';}else{paym = '<label class="label label-danger">COD</label>';}
                        userdata += '<td class="text-center">'+paym+'</td>'+
                        '<td><i class="fa fa-user"></i> <a href="<?=BASE?>panel/user/user-detail/'+holder[i].user_id+'" title="View User" target="_blank">'+holder[i].firstname+' '+holder[i].lastname+'</a><br>'+
                        '<i class="fa fa-phone"></i> '+holder[i].phone_no+'<br> <b>Hostel</b> : '+holder[i].hostel_name+'<br> <b>Room #</b> : '+holder[i].room_no+'</td>'+
                        '<td>'+dropoff_time+'</td>'+           
			'<td><button type="button" data-id="'+holder[i].id+'" class="btn btn-warning" title="Reminder" onclick="send_sms_email(\''+holder[i].user_id+'\',\''+holder[i].college_id+'\',2)"><i class="fa fa-envelope"></i></button> </td>'+
			'<td><button type="button" data-id="'+holder[i].id+'" class="btn btn-warning" title="Reminder" onclick="send_sms_email(\''+holder[i].user_id+'\',\''+holder[i].college_id+'\',1)"><i class="fa fa-comment"></i></button> </td>'+
			'<td><a target="_blank" href="<?=base_url('panel/orders/print_invoice/')?>'+holder[i].id+'" class="btn btn-warning" title="Generate Invoice">Invoice</button></td>'+
                        '<td><button type="button" data-href="<?=BASE?>panel/orders/complete/'+holder[i].id+'" class="btn btn-primary completeBtn" title="Action">Mark<br/> Completed</button></td>'+
                        '</tr>';
                    j++;
                }
                if(data.links)
                {
                    userdata +='<tr><td id="paginate" colspan="13"> <ul class="pagination">'+data.links+'</ul></td></tr>';
                }
                $('.select2').select2();
                
          }else{
                userdata += '<tr><td colspan="12">No order found.</td></tr>'
          }
          $("#order_body").html(userdata);
          $('#pagelink').html(data.links);
       }
       });
    }
	
	
	
function send_sms_email(user_id,college_id,type)
{
	$("#error_message").html("");
	var url = '<?=BASE?>panel/orders/drop-off-sms-email-template';
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