<link href="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">

<div class="col-lg-12">  
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Slot Type</h1>
                <ol class="breadcrumb">
                    <li><a href="<?=BASE?>panel"> <i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li class="active">List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">

    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="padding-bottom:10px;">
            <div class="row">
            <h4 class="col-sm-8">Slot Type List</h4>
            <div class="col-sm-4 pull-right">
                <form method="get" id="filterFrm">
                    <select class="form-control select2" name="filter_hostel" onchange="this.form.submit()">
                    <option value="all">All</option>
                    <?php foreach($colleges as $college){?>
                    <option <?=$this->input->get('filter_hostel')==$college->id?'Selected':''?> value="<?=$college->id?>"><?=$college->college_name?></option>
                    <?php }?>
                </select>
            </form>
            </div>
            </div>
        </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Slots Settings </a></li>
    <li><a data-toggle="tab" href="#customslot">Custom Slot Settings</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
        <button id="btnAddweight" class="btn btn-success pull-right margin-top-20" onclick="edit('Add')"><i class="fa fa-plus-circle"></i> Add Slot Type </button>
       <!--  <button id="btnEditAll" class="btn btn-warning margin-top-20" onclick="editAll()"><i class="fa fa-pencil-square"></i> Edit College Slot</button> -->
      <div class="col-xs-12 col-sm-12 margin-top-20">
            <table class="table table-striped table-hover" id="example-datatable">
                <thead class="the-box dark full">
                        <tr>
                            <th>Sl.No.</th>
                            <th>Slot Type</th>
                            <th>College Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Pick Up Time</th>
                            <th>Slot Available</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                </thead>
                <tbody id="user_body">
                    <?php if($slots){$i=1; foreach($slots as $slot){?>
                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=$slot->slot_type?></td>
                        <td><?=$slot->college_name?></td>
                        <td><?=$slot->start_time?></td>
                        <td><?=$slot->end_time?></td>
                        <td><?=$slot->pickup_time?></td>
                        <td><?=$slot->slots_available?></td>
                        <td class="dropdown"><button class="btn <?=$slot->status==1?'btn-success':'btn-danger'?> dropdown-toggle" type="button" data-toggle="dropdown"> <?=$slot->status==1?'Active':'Inactive'?>
                            <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                <li><a href="<?=BASE?>panel/home/slot-status/<?=$slot->id?>/1">Active</a></li>
                                <li><a href="<?=BASE?>panel/home/slot-status/<?=$slot->id?>/0">Inactive</a></li>
                              </ul>
                        </td>
                        <td class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Action
                            <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                  <li><a href="javascript:void(0)" onclick="edit('Edit',<?=$slot->id?>,'<?=$slot->slot_type?>','<?=$slot->start_time?>','<?=$slot->end_time?>','<?=$slot->pickup_time?>','<?=$slot->slots_available?>',<?=$slot->college_id?>)">Edit</a></li>
                                  <li><a class="del" data-href="<?=BASE?>panel/home/slot-delete/<?=$slot->id?>">Delete</a></li>
                              </ul>
                            </td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="customslot" class="tab-pane fade">
        <button id="btnAddweight" class="btn btn-success pull-right margin-top-20" onclick="cedit('Add')"><i class="fa fa-plus-circle"></i> Add Slot Type </button>
       <!--  <button id="btnCeditAll" class="btn btn-warning margin-top-20" onclick="ceditAll()"><i class="fa fa-pencil-square"></i> Edit College Custom Slot</button> -->
        <div class="col-xs-12 col-sm-12 margin-top-20">
            <table class="table table-striped table-hover" id="datatable2">
                <thead class="the-box dark full">
                        <tr>
                            <th>Sl.No.</th>
                            <th>Date</th>
                            <th>College Name</th>
                            <th>Morning Slot</th>
                            <th>Afternoon Slot</th>
                            <th>Evening Slot</th>
                            <th>Night Slot</th>
                            <th>Action</th>
                        </tr>
                </thead>
                <tbody id="user_body">
                    <?php if($cslots){$i=1; foreach($cslots as $cslot){?>
                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=date('d-m-Y',$cslot->date)?></td>
                        <td><?=$cslot->college_name?></td>
                        <td><?=$cslot->morning?></td>
                        <td><?=$cslot->afternoon?></td>
                        <td><?=$cslot->evening?></td>
                        <td><?=$cslot->night?></td>
                        <td class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Action
                            <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                  <li><a href="javascript:void(0)" onclick="cedit('Edit',<?=$cslot->id?>,'<?=$cslot->morning?>','<?=$cslot->afternoon?>','<?=$cslot->evening?>','<?=$cslot->night?>','<?=date('d-m-Y',$cslot->date)?>',<?=$cslot->college_id?>)">Edit</a></li>
                                  <li><a class="del" data-href="<?=BASE?>panel/home/cslot-delete/<?=$cslot->id?>">Delete</a></li>
                              </ul>
                            </td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
        
    </div>
    </div>
    </div>
    </div>
 
        </div>

<!-- modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
                <span id="label">Edit</span> Slot
            </h4>
         </div>
          <div class="modal-body">
            <form role="form" id="editFrm" method="post">
                <div class="form-group">
                    <label>Select College *</label>
                    <select class="form-control select2" style="width: 100%" name="college_name" id="college_name">
                        <option value="">Select College</option>
                        <?php foreach($colleges as $college){?>
                        <option value="<?=$college->id?>"><?=$college->college_name?></option>
                        <?php }?>
                    </select>
                    <div id="college_name_err"></div>
                </div>
                <!-- <div class="form-group">
                    <label>Select Hostel *</label>
                    <select class="form-control select2 disabled" style="width:100%" name="hostel_name" id="hostel_name">
                        <option value="">Select Hostel</option>
                    </select>
                    <div id="hostel_name_err"></div>
                </div> -->
            <div class="form-group">
                <label>Slot Type *</label>
                <select class="form-control select2" style="width: 100%" name="slot_name" id="slot_name">
                        <option value="">Select Slot</option>
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                        <option value="Night">Night</option>
                    </select>
                <input type='hidden'  name="slot_id" id="slot_id"  />
                <input type='hidden'  id="actiontype"  />
                <div id="slot_name_err"></div>
            </div>
            <div class="form-group">
                <label>Start Time (H:M:S) *</label>
                <input type='text'  name="start_time" id="start_time" class="form-control" />
                <div id="start_time_err"></div>
            </div>
            <div class="form-group">
                <label>End Time (H:M:S) *</label>
                <input type='text'  name="end_time" id="end_time" class="form-control" />
                <div id="end_time_err"></div>
            </div>
            <div class="form-group">
                <label>Pick UP Time (H:M:S) *</label>
                <input type='text'  name="pickup_time" id="pickup_time" class="form-control" />
                <div id="pickup_time_err"></div>
            </div>
            <div class="form-group">
                <label>Slot Available *</label>
                <input type='text'  name="slot_available" id="slot_available" class="form-control" />
                <div id="slot_available_err"></div>
            </div>
                </form>
         </div>
         <div class="modal-footer">
             <span id="loader"></span>
             <button type="button" id="editBtn" class="btn btn-primary">
               Submit
            </button>
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">Close
            </button>
             
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End modal -->
<!-- modal -->
<div class="modal fade" id="cedit" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
                <span id="clabel">Edit</span> Custom Slot
            </h4>
         </div>
          <div class="modal-body">
            <form role="form" id="ceditFrm" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Select Date*</label>
                            <div id="datepicker-slot" class="input-group date col-sm-12 datepicker">
                                <input type="text" name="slot_date" id="slot_date" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                            <div id="slot_date_err"></div>
                        </div>
                        <div class="col-sm-6" id="adds">
                            <label>Repeat Type*</label>
                            <select class="form-control select2" style="width: 100%" name="repeat_type" id="repeat_type">
                                <option value="1">For One Time</option>
                                <option value="2">Repeat Weekly</option>
                                <option value="3">Repeat Monthly</option>
                            </select>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label>Select College *</label>
                    <select class="form-control select2" style="width: 100%" name="college_name1" id="college_name1">
                        <option value="">Select College</option>
                        <?php foreach($colleges as $college){?>
                        <option value="<?=$college->id?>"><?=$college->college_name?></option>
                        <?php }?>
                    </select>
                    <div id="college_name1_err"></div>
                </div>
                <!-- <div class="form-group">
                    <label>Select Hostel *</label>
                    <select class="form-control select2 disabled" style="width:100%" name="hostel_name1" id="hostel_name1">
                        <option value="">Select Hostel</option>
                    </select>
                    <div id="hostel_name1_err"></div>
                </div> -->
            <div class="form-group">
                <label>Morning Slot*</label>
                <input type='text'  name="morning" id="morning" class="form-control" />
                <input type='hidden'  name="cslot_id" id="cslot_id"  />
                <input type='hidden'  id="cactiontype"  />
                <div id="morning_err"></div>
            </div>
            <div class="form-group">
                <label>Afternoon Slot*</label>
                <input type='text'  name="afternoon" id="afternoon" class="form-control" />
                <div id="afternoon_err"></div>
            </div>
            <div class="form-group">
                <label>Evening Slot*</label>
                <input type='text'  name="evening" id="evening" class="form-control" />
                <div id="evening_err"></div>
            </div>
            <div class="form-group">
                <label>Night Slot*</label>
                <input type='text'  name="night" id="night" class="form-control" />
                <div id="night_err"></div>
            </div>
                </form>
         </div>
         <div class="modal-footer">
             <span id="cloader"></span>
             <button type="button" id="ceditBtn" class="btn btn-primary">
               Submit
            </button>
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">Close
            </button>
             
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="editAll" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
                <span id="label">Edit All</span> Slot
            </h4>
         </div>
          <div class="modal-body">
            <form role="form" id="editAllFrm" method="post">
                <div class="form-group">
                    <label>Select College *</label>
                    <select class="form-control select2" style="width: 100%" name="college_name2" id="college_name2">
                        <option value="">Select College</option>
                        <?php foreach($colleges as $college){?>
                        <option value="<?=$college->id?>"><?=$college->college_name?></option>
                        <?php }?>
                    </select>
                    <div id="college_name2_err"></div>
                </div>
                <!-- <div class="form-group">
                    <label>All Hostel will be edited</label>
                </div> -->
            <div class="form-group">
                <label>Slot Type *</label>
                <select class="form-control select2" style="width: 100%" name="slot_name1" id="slot_name1">
                        <option value="">Select Slot</option>
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                        <option value="Night">Night</option>
                    </select>
                <div id="slot_name1_err"></div>
            </div>
            <div class="form-group">
                <label>Start Time (H:M:S) *</label>
                <input type='text'  name="start_time1" id="start_time1" class="form-control" />
                <div id="start_time1_err"></div>
            </div>
            <div class="form-group">
                <label>End Time (H:M:S) *</label>
                <input type='text'  name="end_time1" id="end_time1" class="form-control" />
                <div id="end_time1_err"></div>
            </div>
            <div class="form-group">
                <label>Pick UP Time (H:M:S) *</label>
                <input type='text'  name="pickup_time1" id="pickup_time1" class="form-control" />
                <div id="pickup_time1_err"></div>
            </div>
            <div class="form-group">
                <label>Slot Available *</label>
                <input type='text'  name="slot_available1" id="slot_available1" class="form-control" />
                <div id="slot_available1_err"></div>
            </div>
                </form>
         </div>
         <div class="modal-footer">
             <span id="ealoader"></span>
             <button type="button" id="editAllBtn" class="btn btn-primary">
               Submit
            </button>
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">Close
            </button>
             
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- modal -->
<div class="modal fade" id="cedit_all" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
                <span id="clabel">Edit</span> All Custom Slot
            </h4>
         </div>
          <div class="modal-body">
            <form role="form" id="ceditFrmAll" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Select Date*</label>
                            <div id="datepicker-slot" class="input-group date col-sm-12 datepicker">
                                <input type="text" name="slot_date1" id="slot_date1" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                            <div id="slot_date1_err"></div>
                        </div>
                        <!-- <div class="col-sm-6" id="adds">
                            <label>Repeat Type*</label>
                            <select class="form-control select2" style="width: 100%" name="repeat_type1" id="repeat_type1">
                                <option value="1">For One Time</option>
                                <option value="2">Repeat Weekly</option>
                                <option value="3">Repeat Monthly</option>
                            </select>
                        </div>  -->
                    </div>
                </div>
                <div class="form-group">
                    <label>Select College *</label>
                    <select class="form-control select2" style="width: 100%" name="college_name3" id="college_name3">
                        <option value="">Select College</option>
                        <?php foreach($colleges as $college){?>
                        <option value="<?=$college->id?>"><?=$college->college_name?></option>
                        <?php }?>
                    </select>
                    <div id="college_name1_err"></div>
                </div>
                <!-- <div class="form-group">
                    <label>All hostel will be edited</label>
                </div> -->
            <div class="form-group">
                <label>Morning Slot*</label>
                <input type='text'  name="morning1" id="morning1" class="form-control" />
                <div id="morning1_err"></div>
            </div>
            <div class="form-group">
                <label>Afternoon Slot*</label>
                <input type='text'  name="afternoon1" id="afternoon1" class="form-control" />
                <div id="afternoon1_err"></div>
            </div>
            <div class="form-group">
                <label>Evening Slot*</label>
                <input type='text'  name="evening1" id="evening1" class="form-control" />
                <div id="evening1_err"></div>
            </div>
            <div class="form-group">
                <label>Night Slot*</label>
                <input type='text'  name="night1" id="night1" class="form-control" />
                <div id="night1_err"></div>
            </div>
                </form>
         </div>
         <div class="modal-footer">
             <span id="cAloader"></span>
             <button type="button" id="ceditAllBtn" class="btn btn-primary">
               Submit
            </button>
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">Close
            </button>
             
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- End modal -->
<script src="<?=BASE?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?=BASE?>admin/select2/select2.min.js"></script>
    <script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script>
    $(document).ready(function(){
        $('.select2').select2();
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',startDate: '-0d',autoclose:true
        });
        $('#example-datatable,#datatable2').DataTable();
        $('.del').click(function(){
            $('#confirm_body').text('Do you really want to delete this hostel');
            $('button.confirm').attr('id',$(this).data('href'));
            $('#confirm').modal();
        });
        //$('#hostel_name').prop('disabled', true);
        /*$('#college_name').change(function() {
            //$('#hostel_name').prop('disabled', false);
            var clg = $('#college_name').val();
            var hostel = $('#hostel_name');
            $.get("<?=BASE?>/panel/home/get_hostel/"+clg, function(data){
                data = JSON.parse(data);
                var hostels = '<option value="">Select Hostel</option>';
                hostels+= data.reduce(function function_name(list,item) {
                    return list+'<option value="'+item.id+'">'+item.hostel_name+'</option>'
                },'');
                hostels+='<option value="0">All</option>';
                hostel.html(hostels);
            });
        });*/
        /*$('#college_name1').change(function() {
            //$('#hostel_name').prop('disabled', false);
            var clg = $('#college_name1').val();
            var hostel = $('#hostel_name1');
            $.get("<?=BASE?>/panel/home/get_hostel/"+clg, function(data){
                data = JSON.parse(data);
                var hostels = '<option value="">Select Hostel</option>';
                hostels += data.reduce(function function_name(list,item) {
                    return list+'<option value="'+item.id+'">'+item.hostel_name+'</option>'
                },'')
                hostels+='<option value="0">All</option>';
                hostel.html(hostels);
            });
        });*/
    });

    function edit(action,id,name,starttime,endtime,pickuptime,availableslot,college)
    {
        if(action=='Edit')
        {   
            /*var hostel = $('#hostel_name');
                $.get("<?=BASE?>/panel/home/get_hostel/"+college, function(data){
                    data = JSON.parse(data);
                    var hostels = '<option value="">Select Hostel</option>';
                    hostels += data.reduce(function function_name(list,item) {
                        return list+'<option value="'+item.id+'">'+item.hostel_name+'</option>'
                    },'');
                    //hostels+='<option value="0">All</option>';
                    hostel.html(hostels);
                });*/
            $('#slot_name').val(name);
            $('#college_name').val(college);
            $('#slot_id').val(id);
            $('#start_time').val(starttime);
            $('#end_time').val(endtime);
            $('#pickup_time').val(pickuptime);
            $('#slot_available').val(availableslot);
             $('.select2').select2();
        }else{
            $('#slot_name').val('');
            $('#college_name').val('');
            $('#slot_id').val('');
            $('#start_time').val('');
            $('#end_time').val('');
            $('#pickup_time').val('');
            $('#slot_available').val('');
             $('.select2').select2();
        }
        $('#label').val(action);
        $('#actiontype').val(action);
        $('#edit').modal();
    }
    
    $('#editBtn').click(function(){
        var la = $("#actiontype").val();
        var url = '<?=BASE?>panel/home/'+la.toLowerCase()+'-slot';
        var data = $('#editFrm').serialize();
        //console.log(data);
        $.post(url,data,function(success){
            //$('#hostel_name').prop('disabled', true);
            var res = JSON.parse(success);
            if(res.status)
            {
                $('#editFrm')[0].reset();
                $('#edit').modal('hide');
                //$('#hostel_name').html('<option value="">Select Hostel</option>');
                window.location.href = '<?=  current_url()?>'
            }else{
                var error = res.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#loader').html('<span class="err">Error occured</span>');
            }
        })
        })
        //for custom slot
        function cedit(action,id,morning,afternoon,evening,night,date,college)
        {
            if(action=='Edit')
            {
                /*var hostel = $('#hostel_name1');
                $.get("<?=BASE?>/panel/home/get_hostel/"+college, function(data){
                    data = JSON.parse(data);
                    var hostels = '<option value="">Select Hostel</option>';
                    hostels += data.reduce(function function_name(list,item) {
                        return list+'<option value="'+item.id+'">'+item.hostel_name+'</option>'
                    },'')
                    hostel.html(hostels);
                });*/
                $('#adds').hide();
                $('#datepicker-slot').datepicker('update',date);
                //$('#slot_date').val(date);
                $('#morning').val(morning);
                $('#college_name1').val(college);
                $('#cslot_id').val(id);
                $('#afternoon').val(afternoon);
                $('#evening').val(evening);
                $('#night').val(night);
                $('.select2').select2();
            }else{
                $('#adds').show();
                $('#datepicker-slot').datepicker('update','');
                $('#morning').val('');
                $('#college_name1').val('');
                $('#cslot_id').val('');
                $('#afternoon').val('');
                $('#evening').val('');
                $('#night').val('');
                 $('.select2').select2();
            }
            $('#clabel').val(action);
            $('#cactiontype').val(action);
            $('#cedit').modal();
        }
    
    $('#ceditBtn').click(function(){
        var la = $("#cactiontype").val();
        var url = '<?=BASE?>panel/home/'+la.toLowerCase()+'-cslot';
        var data = $('#ceditFrm').serialize();
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            if(res.status)
            {
                $('#ceditFrm')[0].reset();
                $('#cedit').modal('hide');
                window.location.href = '<?=  current_url()?>'
            }else{
                var error = res.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#cloader').html('<span class="err">Error occured</span>');
            }
        })
        });

    function editAll()
    {
        $('#slot_name1').val('');
        $('#college_name2').val('');
        $('#start_time1').val('');
        $('#end_time1').val('');
        $('#pickup_time1').val('');
        $('#slot_available1').val('');
        $('#editAll').modal();  
    }

    $('#editAllBtn').click(function(){
        var url = '<?=BASE?>panel/home/edit-all-slot';
        var data = $('#editAllFrm').serialize();
        //console.log(data);
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            console.log(success);
            if(res.status)
            {
                $('#editAllFrm')[0].reset();
                $('#editAll').modal('hide');
                window.location.href = '<?=  current_url()?>'
            }else{
                var error = res.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#eAloader').html('<span class="err">Error occured</span>');
            }
        });

    });

        function ceditAll()
        {
            $('#slot_name1').val('');
            //$('#repeat_type1').val('');
            $('#college_name3').val('');
            $('#morning1').val('');
            $('#afternoon1').val('');
            $('#evening1').val('');
            $('#night1').val('');
            $('#cedit_all').modal();
        }

    $('#ceditAllBtn').click(function(){
        var data = $('#ceditFrmAll').serialize();
        var url = '<?=BASE?>panel/home/cedit-all-slot';
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            console.log(res);
            if(res.status)
            {
                $('#ceditFrmAll')[0].reset();
                $('#cedit_all').modal('hide');
                window.location.href = '<?=  current_url()?>'
            }else{
                var error = res.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#cAloader').html('<span class="err">Error occured</span>');
            }
        })
    });


    </script>   
