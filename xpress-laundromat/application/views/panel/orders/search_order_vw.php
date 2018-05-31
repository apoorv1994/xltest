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
                <h1>Search Order</h1>
                <ol class="breadcrumb">
                    <li><a href="<?=BASE?>panel"> <i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li class="active">Search Order</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">

    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="padding-bottom:10px;">
            <div class="row">
			
            <h4 class="col-sm-4">Search Order</h4>
			 <div class="col-sm-2">
				<div class="input-group pull-right" style="margin-left: 10px;">
					<a href="javascript://" id="exportExcel" class="btn btn-success" onclick="download_excel_report();" title="Export Excel"><i class="fa fa-file-excel-o"></i></a>
				</div>
			</div>
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
            <li class="active"><a data-toggle="tab" class="washtype" id="bulk2" data-id="1" href="#bulkwash">Bulk Wash </a></li>
            <li><a data-toggle="tab" data-id="4" class="washtype" id="indi2" href="#shoewash">Individual Wash</a></li>
            <li><a data-toggle="tab" data-id="2" class="washtype" id="prem2" href="#indi_wash">Premium Wash</a></li>
            <li><a data-toggle="tab" data-id="3" class="washtype" id="dry2" href="#dry_clean">Dry Cleaning</a></li>
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
                        <div class="input-group pull-left">
                      <button class="btn btn-info pull-right" id="daterange-btn">
                        <i class="fa fa-calendar"></i> Filter by Date
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                </div>
				<div class="col-sm-2">
				<select class="form-control" name="payment_type" id="payment_type">                     
					<option value="0">All</option>
					<option value="2">COD</option>						
                </select>
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
                            <th>S.No</th>
                            <th>Token No</th>
                            <th>Booking Date</th>
                            <th>Student Detail</th>
                            <th>Pickup slot time</th>
                            <th>Pickup</th>
                            <?php if($this->session->user_type==1){?>
                            <th>Invoice</th>
                            <?php }?>
                            <th>Payment Method</th>
                            <th>Cancel</th>
							<!--<th>Print</th>-->
							<th>Status</th>
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
                            Are you really want to cancel this order?
                    </div>


              </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" 
                           data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-primary" id="rBtn">
                           Confirm
                        </button>
                        <div id="r_loader"></div>
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
            if(localStorage.getItem('clicked2'))
            {
                $('#'+localStorage.getItem('clicked2')).click();
            }else{
            fetch_orders(0);
            }},1000);
        $('#filter_college').change(function(){fetch_orders(0);});
		$('#payment_type').change(function(){fetch_orders(0);});
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
            localStorage.setItem('clicked2',$(this).attr('id'));
            fetch_orders(0);
        })
        
        $('.slotBtn').click(function(){
           $('.slotBtn').removeClass('btn-primary');
           $(this).addClass('btn-primary');
           $('#slot_type').val($(this).val());
           fetch_orders(0);
        })
		
		$('.CODBtn').click(function(){
			$('.CODBtn').removeClass('btn-primary');
           $(this).addClass('btn-primary');
           $('#payment_type').val($(this).val());
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
                if(page_number){
                fetch_orders(page_number);
                }
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
           var url = '<?=BASE?>panel/orders/cancel';
           var data = $('#reminderFrm').serialize();
           $.post(url,data,function(success){
               var res = JSON.parse(success);
               if(res.status)
               {
                   $('#r_loader').html('<span class="success">Order Cancelled</span>');
                   $('#reminderModal').modal('hide');
               }else{
                   $('#r_loader').html('<span class="err">'+res.error+'</span>')
               }
           })
       });
       
       $('body').on('click','.order_slip',function(){
            var id = $(this).data('id');
            $('#orderform_'+id).trigger('submit');
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
		var payment_type = $('#payment_type').val();
		var phone_no = $('#phone_no').val();
        if(id==''){ id=0;}
        $.ajax({
       type: "POST",
       url: '<?=BASE?>panel/orders/search-call/'+id,
       data:{ date_from:date_from, date_to:date_to, search: search,slot_type:slot_type,college_id:college_id,washtype:washtype,payment_type:payment_type,phone_no:phone_no},
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
                   var token_no = '';var weight = ''; var no_of_items = '';
                   var paym ='';
                   if(null !=holder[i].token_no){token_no=holder[i].token_no}
                   if(null !=holder[i].weight){weight=holder[i].weight}
                   if(null !=holder[i].no_of_items){no_of_items=holder[i].no_of_items}
                   var text = '';var bclass = '';var disa='';
                    userdata += '<tr id="DivIdToPrint_'+i+'"><td>'+(j+1)+'</td>'+
                            '<td ><span id="t_'+holder[i].id+'">'+token_no+'</span></td>'+
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
                        userdata += '</td>';
                        <?php if($this->session->user_type==1){?>
                            userdata +='<td class="text-center"><a href="<?=base_url('panel/orders/invoice/')?>'+holder[i].id+'?from=search" id="btn_'+holder[i].id+'" data-id="'+holder[i].id+'" class="btn btn-warning" title="Generate Invoice">Invoice</button></td>';
                        <?php }?>
                        if(holder[i].status=="6" || holder[i].status=="5" || holder[i].status=="4"){disa = 'disabled'; }
                        if(holder[i].payment_type==1){paym = '<label class="label label-success">Wallet</label>';}else{paym = '<label class="label label-danger">COD</label>';}
                        userdata += '<td class="text-center">'+paym+'</td>';
                        userdata += '<td class="text-center"><button type="button" data-id="'+holder[i].id+'" '+disa+' class="btn btn-danger reminder" title="Cancel Order"><i class="fa fa-trash"></i></button> </td>';
						//userdata += '<td class="text-center" onclick="printDiv('+i+');"><i class="fa fa-print"></i></td>';
                        
                        switch(holder[i].status)
                        {
                            case "6":
                                text = 'Cancelled'; bclass = 'danger';
                                break;
                            case "5":
                                text = 'Completed'; bclass = 'success';
                                break;
                            case "1":
                                text = 'Order recieved'; bclass = 'default';
                                break;
                            case "2":
                                text = 'Order processed'; bclass='warning';
                                break;
                            case "3":
                                text ='Clothes collected'; bclass= 'info';
                                break;
                            case "4":
                                text = 'Out/Ready for Delivery'; bclass = 'primary';
                        }
                        userdata +='<td><button type="button" data-id="'+holder[i].id+'" class="btn btn-'+bclass+'" title="Action">'+text+'</button></td>'+
                        '</tr>';
                    j++;
                }
                if(data.links)
                {
                    userdata +='<tr><td id="paginate" colspan="13"> <ul class="pagination">'+data.links+'</ul></td></tr>';
                }
                $('.select2').select2();
                
          }else{
                userdata += '<tr><td colspan="13">No order found.</td></tr>';
          }
          $("#order_body").html(userdata);
          $('#pagelink').html(data.links);
       }
       });
    }
	
	function download_excel_report()
	{
		var search = $('#search').val();
        var date_from = $('input[name="daterangepicker_start"]').val();
        var date_to = $('input[name="daterangepicker_end"]').val();
        var slot_type = $('#slot_type').val();
        var washtype = $('#washtype').val();
        var college_id = $('#filter_college').val();
		var payment_type = $('#payment_type').val();
        var id=0;
       var data="date_from="+date_from+"&date_to="+date_to+"&search="+search+"&slot_type="+slot_type+"&college_id="+college_id+"&washtype="+washtype+"&payment_type="+payment_type+"&id="+id;
	   window.location.href="<?=BASE?>panel/orders/export-search-oder?"+data;
	}
	
	function printDiv(id) 
	{

	  var divToPrint=document.getElementById('DivIdToPrint_'+id);

	  var newWin=window.open('','Print-Window');

	  newWin.document.open();

	  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

	  newWin.document.close();

	  setTimeout(function(){newWin.close();},10);

	}
    </script>