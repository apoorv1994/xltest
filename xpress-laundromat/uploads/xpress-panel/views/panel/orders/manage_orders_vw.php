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
                    <div class="col-lg-3">
                        <form action="<?=BASE?>panel/orders/order-slip" method="post" id="bulkFrm" target="_blank">
                            <button id="bulkselect" type="button" class="btn btn-danger">Generate Order Slip</button>
                        <input type="hidden" name="order_id" id="orderslip_ids" />
                        </form>
                    </div>
                <div class="col-lg-3">
                        <div class="input-group pull-left">
                      <button class="btn btn-info pull-right" id="daterange-btn">
                        <i class="fa fa-calendar"></i> Filter by date
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                </div>
                <div class="col-sm-3">
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
                            <th>Reminder</th>
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
                  <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="row modal-content">
                          <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center">Add Cloth Details</h4>
                          </div>
                            <form method="post" id="clothFrm">
                          <div class="modal-body">
                                <div class="form-group">
                                        <label for="concept" class="col-sm-3 control-label">Token No</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="token_no" name="token_no" required="">
                                            <div id="token_no_err"></div>
                                        </div>
                                </div>
                              <p style="visibility:hidden; margin-bottom: -6px;">hidden</p>
                              <div class="form-group">
                                        <label for="concept" class="col-sm-3 control-label">Weight</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="weight" name="weight" required="">
                                            <div id="weight_err"></div>
                                        </div>
                                </div>
                                <p style="visibility:hidden; margin-bottom: -6px;">hidden</p>
                                <div class="form-group">
                                        <label for="concept" class="col-sm-3 control-label">No of Items</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="no_of_items" required=""  name="no_of_items">
                                                <input type="hidden"  id="order_id" name="order_id">
                                                <div id="no_of_items_err"></div>
                                        </div>
                                </div>
                                <p style="visibility:hidden; margin-bottom: -6px;">hidden</p>
                                <div class="col-md-5 col-md-offset-6">
                                    <div id="loader"></div>
                                    <button type="button" id="clothBtn" class="btn btn-success">Submit</button><br><br>
                                </div>

                          </div>
                            </form>
                        </div>

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
           var token_no = '';var weight = '0'; var no_of_items = '0';
           if(null !=$(this).data('token')){token_no=$(this).data('token')}
           if(null !=$(this).data('weight')){weight=$(this).data('weight')}
           if(null !=$(this).data('item')){no_of_items=$(this).data('item')}
           $('#token_no').val(token_no);
           $('#weight').val(weight);
           $('#no_of_items').val(no_of_items);
           $('#clothsmodal').modal();
       })
       
       $('#clothBtn').click(function(){
           var url = '<?=BASE?>panel/orders/cloth-detail';
           var data = $('#clothFrm').serialize();
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
        if(id==''){ id=0;}
        $.ajax({
       type: "POST",
       url: '<?=BASE?>panel/orders/order-call/'+id,
       data:{ date_from:date_from, date_to:date_to, search: search,slot_type:slot_type,college_id:college_id,washtype:washtype},
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
                   if(null !=holder[i].token_no){token_no=holder[i].token_no}
                   if(null !=holder[i].weight){weight=holder[i].weight}
                   if(null !=holder[i].no_of_items){no_of_items=holder[i].no_of_items}
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
                        '<td><button type="button" data-id="'+holder[i].id+'" class="btn btn-warning reminder" title="Reminder"><i class="fa fa-bell"></i></button> </td>'+
                        '<td><form method="post" id="orderform_'+holder[i].id+'" target="_blank" action="<?=BASE?>panel/orders/order-slip"><input type="hidden" name="order_id" value="'+holder[i].id+'"></form><button type="button" data-id="'+holder[i].id+'" class="btn btn-default order_slip" title="Print Order Slip"><i class="fa fa-print"></i></button> </td>'+
                        '<td><button data-id="'+holder[i].id+'" id="cd_'+holder[i].id+'" type="button" data-token="'+token_no+'" data-weight="'+weight+'" data-item="'+no_of_items+'" class="btn btn-primary cloth_detail" title="Clothes Details">Details</a></td>'+
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
    </script>