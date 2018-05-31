<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
<?php 
$college_id="";
if($this->input->get('college_id')){$college_id=base64_decode($this->input->get('college_id'));}
?>
<div class="col-lg-12">  
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Manage Orders</h1>
                <ol class="breadcrumb">
                    <li><a href="<?=BASE?>panel"> <i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li class="active">Manage Orders</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">

    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="padding-bottom:10px;">
            <div class="row">
            <h4 class="col-sm-8">Manage Orders</h4>
            <div class="col-sm-4 pull-right">
                <form method="get" id="filterFrm">
                    <select class="form-control select2" name="filter_college" id="filter_college">
                        <?php foreach($colleges as $college){?>
                        <option <?=$this->input->get('filter_setting')==$college->id?'Selected':''?> value="<?=$college->id?>" <?php if($college_id==$college->id){echo 'selected="selected"';}?>><?=$college->college_name?></option>
                        <?php }?>
                </select>
            </form>
            </div>
            </div>
        </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" class="washtype" id="bulk" data-id="1" href="#bulkwash">Bulk Wash </a></li>
            <li><a data-toggle="tab" data-id="4" class="washtype" id="indi" href="#shoewash">Individual Wash</a></li>
            <li><a data-toggle="tab" data-id="2" class="washtype" id="prem" href="#indi_wash">Premium Wash</a></li>
            <li><a data-toggle="tab" data-id="3" class="washtype" id="dry" href="#dry_clean">Dry Cleaning</a></li>
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
                    <div class="col-lg-2">
                        <form action="<?=BASE?>panel/orders/order-slip" method="post" id="bulkFrm" target="_blank">
                            <button id="bulkselect" type="button" class="btn btn-danger">Generate Order Slip</button>
                        <input type="hidden" name="order_id" id="orderslip_ids" />
                        </form>
                    </div>
                <div class="col-lg-3">
                        <div class="input-group pull-left">
                      <button class="btn btn-info pull-right" id="daterange-btn">
                        <i class="fa fa-calendar"></i> Filter by oder date
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                </div>
				<div class="col-sm-2">
					<input type="text" id="phone_no" name="phone_no" class="form-control" placeholder="Phone Number">
				</div>
                <div class="col-sm-2">
                    <input name="search" id="search" class="form-control" placeholder="Search">
                </div>
                    <div class="col-sm-3">
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
                <table class="table table-striped table-hover" id="example-datatable">
                    <thead class="the-box dark full">
                        <tr>
                            <th><input type="checkbox" id="allcheck" ></th>
                            <th>S.No</th>
                            <th>Booking Date</th>
                            <th>Student Detail</th>
                            <th>Slot Time</th>
                            <th>Pick UP</th>
                            <!--<th>Reminder</th>-->
							<th>Reminder Mail</th>
							<th>Reminder SMS</th>
                            <th>Order Slip</th>
                            <th>Cloths Details</th>
                            <th>Token No</th>
                            <th>Weight</th>
                            <th>No of Cloths</th>
                            <th>Iron</th>
                            <th>Invoice</th>
							
                        </tr>
                    </thead>
                    <tbody id="order_body">

                    </tbody>
                </table>
            </div>
        </div>  
    </div>
        
  </div>
 </div>
</div>
</div>
<!-- modal -->

<div id="clothsmodal" class="modal fade" role="dialog">
    <div class="modal-dialog" id="clothdata">
               <!-- Modal content-->
       
    </div>
</div>


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
                                        Are you really want to send reminder?
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

<script>
    $(document).ready(function(){
        $('.select2').select2();
        setTimeout(function(){
            if(localStorage.getItem('clicked'))
            {
                $('#'+localStorage.getItem('clicked')).click();
            }else{
            fetch_orders(0);
            }
        },1000);
        $('#filter_college').change(function(){fetch_orders(0);});
         $('#daterange-btn').daterangepicker(
            {
              ranges: {
                  'All Upcoming' : [moment().subtract(1, 'months'), moment().add(2, 'days')],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()]
              },
              <?php if($this->input->get('nday')=='today'){?>
              startDate: moment(),
              endDate: moment()
                <?php }else{?>
                    startDate: moment().subtract(1, 'months'),
              endDate: moment().add(2, 'days')
                <?php }?>
            },
        function (start, end) {
          fetch_orders(0);
        }
        );
        
        $('.washtype').click(function(){
            $('#washtype').val($(this).data('id'));
            localStorage.setItem('clicked',$(this).attr('id'));
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
			$('#phone_no').val('');
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
                return false;
            }
       });
       
       $('body').on('click','.cloth_detail',function(){
           var o_id = $(this).data('id');
           $('#order_id').val(o_id);
           $('#loader').html('');
           var token_no = '';var weight = '0'; var no_of_items = '0';var ordertype = '0'
           if(null !=$(this).data('token')){token_no=$(this).data('token')}
           if(null !=$(this).data('weight')){weight=$(this).data('weight')}
           if(null !=$(this).data('item')){no_of_items=$(this).data('item')}
		   if(null !=$(this).data('ordertype')){ordertype=$(this).data('ordertype')}
           $('#token_no').val(token_no);
           $('#weight').val(weight);
           $('#no_of_items').val(no_of_items);
		   $('#orderType').val(ordertype);
           //$('#clothsmodal').modal();
		   view_cloth_detail(token_no,weight,no_of_items,ordertype,o_id);
		   
       })
	   
	   function view_cloth_detail(token_no,weight,no_of_items,ordertype,o_id)
	   {
		   var url = '<?=BASE?>panel/orders/view-cloth-detail';
		   var data = "token_no="+token_no+"&weight="+weight+"&no_of_items="+no_of_items+"&ordertype="+ordertype+"&order_id="+o_id;
		   
		   $.post(url,data,function(success){
			   //alert(success);
			   $("#clothdata").html(success);
			   $('#clothsmodal').modal();
			   $('#clothFrm')[0].reset();
			})
	   }
       
       $('#clothBtn3').click(function(){
		   var order_id =$("#order_id").val();
		   var weight =$("#weight").val();
		   var no_of_items =$("#no_of_items").val();
		   var orderType=$("#orderType").val();
		   var token_no=$("#token_no").val();
		   if(orderType=='1' && weight>=10.5)
		   {
			   alert("Cloth weight should be less than 10 kg");
			   return false;
		   }
		   else if(orderType=='4' && no_of_items>15)
		   {
			   alert("No Of Item should be less than 15");
			   return false;
		   }
		   else
		   {
			   var url = '<?=BASE?>panel/orders/cloth-detail';
			   //var data = $('#clothFrm').serialize();
			   var data = "token_no="+token_no+"&weight="+weight+"&no_of_items="+no_of_items+"&order_id="+order_id;
			   $('#loader').html('<i class="fa fa-spin fa-spinner"></i>');
			   $.post(url,data,function(success){
				   
				   var res = JSON.parse(success);
				  // console.log(res);
				   if(res.status)
				   {
					   $('#t_'+res.data.order_id).text(res.data.token_no);
					   $('#w_'+res.data.order_id).text(res.data.weight);
					   $('#n_'+res.data.order_id).text(res.data.no_of_items);
					   $('#cd_'+res.data.order_id).data('token',res.data.token_no);
					   $('#cd_'+res.data.order_id).data('weight',res.data.weight);
					   $('#cd_'+res.data.order_id).data('item',res.data.no_of_items);
					   $('#loader').html('<span class="success">Cloth Details Added</span>')
					   $('#clothFrm')[0].reset();
					   $('#clothsmodal').modal('hide');
					   $('#to_'+res.data.order_id).val(res.data.token_no);
					   $('#total_'+res.data.order_id).val(res.data.no_of_items);
					   //$('#college_name_'+res.data.order_id).val(res.data.college_name);
					   //$('#wash_type_'+res.data.order_id).val(res.data.wash_type);
					   $('#form_'+res.data.order_id).trigger('submit');
					   $('#btn_'+res.data.order_id).removeAttr('disabled');
				   }
				   else{
					var error = res.error;
					$.each( error, function( i, val ) 
					{
						$('#'+i).html(val);
						setTimeout(function(){$('#'+i).html('');},2000);
					});
					$('#loader').html('<span class="err">Error occured</span>');
				}
			   })
			}
       })
       
       $('body').on('click','.reminder',function(){
            $('#r_loader').html('');
            $('#rorder_id').val($(this).data('id'));
            $('#reminderModal').modal();
       })
       
       $('#rBtn').click(function(){
           $('#r_loader').html('<i class="fa fa-spin fa-spinner"></i>');
           var url = '<?=BASE?>panel/orders/pickup-reminder';
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
       $('body').on('click','#allcheck',function(){
            if($(this).is(':checked'))
            {
                $('.chks').prop('checked',true);
                bulkcall()
            }else{
                $('.chks').prop('checked',false);
                bulkcall()
            }
       })
       $('body').on('click','.chks',function(){
           if(!$(this).is(':checked'))
           {
               $('#allcheck').prop('checked',false);
           }
           bulkcall()
       });
       
       $('#bulkselect').click(function(){
           if($('#orderslip_ids').val()!='')
           {
               $('#bulkFrm').submit();
               $('#orderslip_ids').val('');
           }
           else($('#orderslip_ids').val()=='')
           {
               //alert('Please select atleast one order.')
           }
       })
    });
    
    function bulkcall()
    {
        var val = [];var i=0;
           $('.chks').each(function(){
               if($(this).is(':checked'))
               {
                   val[i] = $(this).val();
                   i++;
               }
           });
           $('#orderslip_ids').val(val);
    }
    
    function fetch_orders(id)
    {
        $("#order_body").empty().append('<tr><td colspan="12" style="text-align: center;"><i class="fa fa-spinner fa-pulse fa-3x"></i></td></tr>');
        var search = $('#search').val();
        var date_from = $('input[name="daterangepicker_start"]').val();
        var date_to = $('input[name="daterangepicker_end"]').val();
        var slot_type = $('#slot_type').val();
        var washtype = $('#washtype').val();
        var college_id = $('#filter_college').val();
		var phone_no = $('#phone_no').val();
        if(id==''){ id=0;}
        $.ajax({
       type: "POST",
       url: '<?=BASE?>panel/orders/order-call/'+id,
       data:{ date_from:date_from, date_to:date_to, search: search,slot_type:slot_type,college_id:college_id,washtype:washtype,phone_no:phone_no},
       success: function(res){
		 
           var data = JSON.parse(res);
           var j = parseInt(id);
           var slot = ['','Morning','Afternoon','Evening','Night'];
           if(data.res)
           {
               var userdata = '';
               var holder = data.rows;
               //console.log(holder);
               var length = holder.length;
               for(var i =0; i< length; i++)
               {
                   var token_no = '';var weight = ''; var no_of_items = '';var inv = '';
				   if(null !=holder[i].order_type){order_type=holder[i].order_type}
                   if(null !=holder[i].token_no){token_no=holder[i].token_no}
                   if(null !=holder[i].weight){weight=holder[i].weight}
                   if(null !=holder[i].no_of_items){no_of_items=holder[i].no_of_items} else {no_of_items=holder[i].quantity}
                   if(token_no==''){inv = 'disabled';}
                   
                    userdata += '<tr><th><input type="checkbox" name="order_id[]" class="chks" value="'+holder[i].id+'" /></th><td>'+(j+1)+'</td>'+
                        '<td>'+holder[i].book_date+'</td>'+
                        '<td><i class="fa fa-user"></i> <a href="<?=BASE?>panel/user/user-detail/'+holder[i].user_id+'" title="View User" target="_blank">'+holder[i].firstname+' '+holder[i].lastname+'</a><br>'+
                        '<i class="fa fa-phone"></i> '+holder[i].phone_no+'<br> <b>Hostel</b> : '+holder[i].hostel_name+'<br> <b>Room #</b> : '+holder[i].room_no+'</td>'+
                        '<td>'+slot[holder[i].book_slot]+'</td>'+
                        '<td>';
                                if(holder[i].pickup_type == '1')
                                {
                                    userdata += 'No';
                                }else{
                                    userdata += 'Yes';
                                }
                        userdata += '</td>'+
			'<td><button type="button" data-id="'+holder[i].id+'" class="btn btn-warning" title="Reminder" onclick="send_sms_email(\''+holder[i].user_id+'\',\''+holder[i].college_id+'\',2)"><i class="fa fa-envelope"></i></button> </td>'+
			'<td><button type="button" data-id="'+holder[i].id+'" class="btn btn-warning" title="Reminder" onclick="send_sms_email(\''+holder[i].user_id+'\',\''+holder[i].college_id+'\',1)"><i class="fa fa-comment"></i></button> </td>'+
                        '<td><form method="post" id="orderform_'+holder[i].id+'" target="_blank" action="<?=BASE?>panel/orders/order-slip"><input type="hidden" name="order_id" value="'+holder[i].id+'"></form><button type="button" data-id="'+holder[i].id+'" class="btn btn-default order_slip" title="Print Order Slip"><i class="fa fa-print"></i></button> </td>'+
                        '<td><button data-id="'+holder[i].id+'" id="cd_'+holder[i].id+'" type="button" data-token="'+token_no+'" data-weight="'+weight+'" data-item="'+no_of_items+'" data-ordertype="'+holder[i].order_type+'" class="btn btn-primary cloth_detail" title="Clothes Details">Details</a></td>'+
                        '<td ><form method="post" id="form_'+holder[i].id+'" target="_blank" action="<?=BASE?>panel/orders/generate-token"><input type="hidden" name="name" value="'+holder[i].firstname+'"><input type="hidden" name="token_no" id="to_'+holder[i].id+'" value=""><input type="hidden" name="total" id="total_'+holder[i].id+'"><input type="hidden" name="wash_type" id="wash_type_'+holder[i].id+'" value="'+holder[i].wash_type+'"><input type="hidden" name="college_name" id="college_name_'+holder[i].id+'" value="'+holder[i].college_name+'"><input type="hidden" name="iron" id="iron_'+holder[i].id+'" value="'+holder[i].iron+'"><input type="hidden" name="order_type" id="order_type_'+holder[i].id+'" value="'+holder[i].order_type+'"></form>'+
                        '<span id="t_'+holder[i].id+'">'+token_no+'</span></td>'+
                        '<td id="w_'+holder[i].id+'">'+weight+'</td>'+
                        '<td id="n_'+holder[i].id+'">'+no_of_items+'</td>'+
                        '<td id="i_'+holder[i].id+'">';
                        if(holder[i].iron==0)
                        {
                          userdata += 'No';
                        }else{
                          userdata += 'Yes';
                        }

                        userdata +='</td>'+
                        '<td><a href="<?=base_url('panel/orders/invoice/')?>'+holder[i].id+'" id="btn_'+holder[i].id+'" data-id="'+holder[i].id+'" '+inv+' class="btn btn-warning" title="Generate Invoice">Invoice</button></td>'+
                        '</tr>';
                    j++;
                }
                if(data.links)
                {
                    userdata +='<tr><td id="paginate" colspan="13"> <ul class="pagination">'+data.links+'</ul></td></tr>';
                }
                
          }else{
                userdata += '<tr><td colspan="13">No order found.</td></tr>'
          }
          $("#order_body").html(userdata);
          $('#pagelink').html(data.links);
       }
       });
    }
	
function send_sms_email(user_id,college_id,type)
{
	$("#error_message").html("");
	var url = '<?=BASE?>panel/orders/order-sms-email-template';
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