<link href="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">

<div class="col-lg-12">  
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Hostel<button id="btnAddweight" class="btn btn-success pull-right" onclick="edit('','','','Add')"><i class="fa fa-plus-circle"></i> Add Hostel </button></h1>
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
            <h4 class="col-sm-8">Hostel List</h4>
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
        <div class="col-lg-10 col-lg-offset-1">
            <table class="table table-striped table-hover" id="example-datatable">
                <thead class="the-box dark full">
                        <tr>
                            <th>Sl.No.</th>
                            <th>Hostel Name</th>
                            <th>College Name</th>
                            <th>Morning</th>
                            <th>Afternoon</th>
                            <th>Evening</th>
                            <th>Night</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                </thead>
                <tbody id="user_body">
                    <?php if($hostels){$i=1; foreach($hostels as $hostel){?>
                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=$hostel->hostel_name?></td>
                        <td><?=$hostel->college_name?></td>
                        <td><?=$hostel->morning?></td>
                        <td><?=$hostel->afternoon?></td>
                        <td><?=$hostel->evening?></td>
                        <td><?=$hostel->night?></td>
                        <td class="dropdown"><button class="btn <?=$hostel->status==1?'btn-success':'btn-danger'?> dropdown-toggle" type="button" data-toggle="dropdown"> <?=$hostel->status==1?'Active':'Inactive'?>
                            <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                <li><a href="<?=BASE?>panel/home/hostel-status/<?=$hostel->id?>/1">Active</a></li>
                                <li><a href="<?=BASE?>panel/home/hostel-status/<?=$hostel->id?>/0">Inactive</a></li>
                              </ul>
                        </td>
                        <td class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Action
                            <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                  <li><a href="javascript:void(0)" onclick="edit(<?=$hostel->id?>,'<?=$hostel->hostel_name?>',<?=$hostel->college_id?>,'Edit','<?=$hostel->morning?>','<?=$hostel->afternoon?>','<?=$hostel->evening?>','<?=$hostel->night?>')">Edit</a></li>
                                  <li><a class="del" data-href="<?=BASE?>panel/home/hostel-delete/<?=$hostel->id?>">Delete</a></li>
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
                <span id="label">Edit</span> Hostel
            </h4>
         </div>
          <div class="modal-body">
            <form role="form" id="editFrm" method="post">
                <div class="form-group">
                    <label>Select College *</label>
                    <select class="form-control" name="college_name" id="college_name">
                        <option value="">Select College</option>
                        <?php foreach($colleges as $college){?>
                        <option value="<?=$college->id?>"><?=$college->college_name?></option>
                        <?php }?>
                    </select>
                    <div id="college_name_err"></div>
                </div>
            <div class="form-group">
                <label>Hostel Name *</label>
                <input type='text'  name="hostel_name" id="hostel_name" class="form-control" />
                <input type='hidden'  name="hostel_id" id="hostel_id"  />
                <input type='hidden'  id="actiontype"  />
                <div id="hostel_name_err"></div>
            </div>
            <div class="form-group">
                <label>Pickup Morning *</label>
                <input type='text'  name="pickup_morning" id="pickup_morning" class="form-control" />
                <div id="pickup_morning_err"></div>
            </div>
            <div class="form-group">
                <label>Pickup Afternoon *</label>
                <input type='text'  name="pickup_afternoon" id="pickup_afternoon" class="form-control" />
                <div id="pickup_afternoon_err"></div>
            </div>
            <div class="form-group">
                <label>Pickup Evening *</label>
                <input type='text'  name="pickup_evening" id="pickup_evening" class="form-control" />
                <div id="pickup_evening_err"></div>
            </div>
            <div class="form-group">
                <label>Pickup Night *</label>
                <input type='text'  name="pickup_night" id="pickup_night" class="form-control" />
                <div id="pickup_night_err"></div>
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
<script src="<?=BASE?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?=BASE?>admin/select2/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('.select2').select2();
        $('#example-datatable').DataTable();
        $('.del').click(function(){
            $('#confirm_body').text('Do you really want to delete this hostel');
            $('button.confirm').attr('id',$(this).data('href'));
            $('#confirm').modal();
        });
    });
    function edit(id,name,college,action,morning,afternoon,evening,night)
    {
        if(action=='Edit')
        {
            $('#hostel_name').val(name);
            $('#college_name').val(college);
            $('#hostel_id').val(id);
            $('#pickup_morning').val(morning);
            $('#pickup_afternoon').val(afternoon);
            $('#pickup_evening').val(evening);
            $('#pickup_night').val(night);
        }else{
            $('#hostel_name').val('');
            $('#college_name').val('');
            $('#hostel_id').val('');
            $('#pickup_morning').val();
            $('#pickup_afternoon').val();
            $('#pickup_evening').val();
            $('#pickup_night').val();
        }
        $('#label').val(action);
        $('#actiontype').val(action);
        $('#edit').modal();
    }
    
    $('#editBtn').click(function(){
        var la = $("#actiontype").val();
        var url = '<?=BASE?>panel/home/'+la.toLowerCase()+'-hostel';
        var data = $('#editFrm').serialize();
        //console.log(data);
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            //console.log(res);
            if(res.status)
            {
                $('#editFrm')[0].reset();
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
    </script>