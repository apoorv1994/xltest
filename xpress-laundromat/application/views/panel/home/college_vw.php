<link href="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<div class="col-lg-12">
          
<div class="row">
	<div class="col-lg-12">
		<div class="page-title">
					<h1>College<button id="btnAddweight" class="btn btn-success pull-right" onclick="edit('Add')"><i class="fa fa-plus-circle"></i> Add College </button>

			</h1>
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
<div class="panel-heading" style="padding-bottom:10px;"><h4>College List</h4></div>
<div class="panel-body">
    <div class="col-lg-12" style="overflow-x: scroll;">
        <table class="table table-striped table-hover" id="example-datatable">
        <thead class="the-box dark full">
                <tr>
                    <th>Sl.No.</th>
                    <th>College Name</th>
                    <th>Manager Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone No</th>
                    <th>Store Timing</th>
                    <th>Service Tax No</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody id="user_body">
            <?php if($colleges){$i=1; foreach($colleges as $college){?>
            <tr>
                <td><?=$i++;?></td>
                <td><?=$college->college_name?></td>
                <td><?=$college->name?></td>
                <td><?=$college->email?></td>
                <td><?=$college->address?></td>
                <td><?=$college->phone?></td>
                <td><?=$college->store_timing?></td>
                <td><?=$college->service_tax_no?></td>
                <td >
                    <div  class="dropdown">
                    <button class="btn <?=$college->status==1?'btn-success':'btn-danger'?> dropdown-toggle" type="button" data-toggle="dropdown"> <?=$college->status==1?'Active':'Inactive'?>
                    <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="<?=BASE?>panel/home/college-status/<?=$college->id?>/1">Active</a></li>
                        <li><a href="<?=BASE?>panel/home/college-status/<?=$college->id?>/0">Inactive</a></li>
                      </ul>
                    </div>
                </td>
                <td>
                    <div  class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Action
                    <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                          <li><a href="javascript:void(0)" onclick="edit('Edit','<?=$college->id?>')">Edit</a></li>
                          <li><a class="del" data-href="<?=BASE?>panel/home/college-delete/<?=$college->id?>">Delete</a></li>
                      </ul>
                    </div>
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
                <span id="label">Edit</span> College
            </h4>
         </div>
          <div class="modal-body">
            <form role="form" id="editFrm" method="post">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label>College Name</label>
                        <input type='text'  name="college_name" id="college_name" class="form-control" />
                        <input type='hidden'  name="college_id" id="college_id"  />
                        <input type='hidden'  id="actiontype"  />
                        <div id="college_name_err"></div>
                    </div>
                    <div class="col-sm-6">
                        <label>Manager Name</label>
                        <input type='text'  name="name" id="name" class="form-control" />
                        <div id="name_err"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label>Manager Email</label>
                        <input type='email'  name="email" id="email" class="form-control" />
                        <div id="email_err"></div>
                    </div>
                    <div class="col-sm-6">
                        <label>Phone No</label>
                        <input type='text'  name="phone" maxlength="21" id="phone" class="form-control" />
                        <div id="phone_err"></div>
                    </div>
                </div>
                    
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea class="form-control" name="address" id="address"></textarea>
                <div id="address_err"></div>
            </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Store Timings</label>
                            <textarea class="form-control" name="store_time"  id="store_time"></textarea>
                            <div id="store_time_err"></div>
                        </div>
                        <div class="col-sm-6">
                            <label>Service Tax No</label>
                            <input type='text'  name="service_tax" id="service_tax" class="form-control" />
                            <div id="service_tax_err"></div>
                        </div>
                    </div>
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

<script>
    $(document).ready(function(){
        $('#example-datatable').DataTable();
        $('.del').click(function(){
            $('#confirm_body').text('Do you really want to delete this college');
            $('button.confirm').attr('id',$(this).data('href'));
            $('#confirm').modal();
        });
    });
    function edit(action,id)
    {
        if(action=='Edit')
        {
            var url = '<?=BASE?>panel/home/get_college/'+id;
             $.get(url,function(success){
                 var res = JSON.parse(success);
                 if(res.status)
                 {
                    $('#college_name').val(res.data.college_name);
                    $('#name').val(res.data.name);
                    $('#email').val(res.data.email);
                    $('#address').val(res.data.address);
                    $('#phone').val(res.data.phone);
                    $('#college_id').val(res.data.id);
                    $('#service_tax').val(res.data.service_tax_no);
                    $('#store_time').val(res.data.store_timing);
                 }
            })
            
        }else{
            $('#college_name').val('');
            $('#college_id').val('');
        }
        $('#label').html(action);
        $('#actiontype').val(action);
        $('#edit').modal();
    }
    
    $('#editBtn').click(function(){
        $('#loader').html('<i class="fa fa-spin fa-spinner"></i>');
        var la = $("#actiontype").val();
        var url = '<?=BASE?>panel/home/'+la.toLowerCase()+'-college';
        var data = $('#editFrm').serialize();
        $.post(url,data,function(success){
            var res = JSON.parse(success);
            if(res.status)
            {
                $('#editFrm')[0].reset();
                window.location.href = '<?=  current_url()?>';
            }else{
                var error = res.error;
                $.each( error, function( i, val ) 
                {
                    $('#'+i).html(val);
                });
                $('#loader').html('<span class="err">Error occured</span>');
                setTimeout(function(){$('#loader').html('');},2000);
            }
        })
    })
    </script>