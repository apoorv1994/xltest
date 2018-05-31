<link href="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<div class="col-lg-12">
          
<div class="row">
	<div class="col-lg-12">
		<div class="page-title">
                    <h1>Admin <button id="btnAddweight" onclick="addadmin('Add')" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Add Admin </button>

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
<div class="panel-heading" style="padding-bottom:10px;"><h4>Admin List</h4></div>
<div class="panel-body">
    <div class="col-lg-12">
	<table class="table table-striped table-hover" id="example-datatable">
        <thead class="the-box dark full">
                <tr>
                    <th>Sl.No.</th>
                    <th>Admin Name</th>
                    <th>Admin Type</th>
                    <th>College</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody id="user_body">
            <?php if($admins){$i=1; foreach($admins as $admin){?>
            <tr>
                <td><?=$i++;?></td>
                <td><?=$admin->name?></td>
                <td><?=$admin->user_type==1?'Super Admin':'Sub Admin'?></td>
                <td><?=$admin->college_name?></td>
                <td class="dropdown">
                    <?php if($admin->id!=$this->session->admin_id){?>
                    <button class="btn <?=$admin->status==1?'btn-success':'btn-danger'?> dropdown-toggle" type="button" data-toggle="dropdown"> <?=$admin->status==1?'Active':'Inactive'?>
                    <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="<?=BASE?>panel/user/admin-status/<?=$admin->id?>/1">Active</a></li>
                        <li><a href="<?=BASE?>panel/user/admin-status/<?=$admin->id?>/0">Inactive</a></li>
                      </ul>
                    <?php }else{?>
                        <button class="btn <?=$admin->status==1?'btn-success':'btn-danger'?>" type="button" > <?=$admin->status==1?'Active':'Inactive'?></button>
                        <?php }?>
                </td>
                
                <td class="dropdown">
                    <?php if($admin->id!=$this->session->admin_id){?>
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Action
                    <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                          <li><a href="javascript:void(0)" onclick="addadmin('Edit',<?=$admin->id?>,'<?=$admin->name?>','<?=$admin->email?>','<?=$admin->user_type?>','<?=$admin->college_id?>')"><i class="fa fa-pencil"></i> Edit</a></li>
                          <li><a class="del" data-href="<?=BASE?>panel/user/admin-delete/<?=$admin->id?>"><i class="fa fa-trash"></i> Delete</a></li>
                          <li><a href="javascript:void(0)" onclick="load_reset_modal(<?=$admin->id?>,'<?=$admin->name?>')"><i class="fa fa-gear"></i> Reset Password</a></li>
                      </ul>
            <?php }else{ echo 'NA';}?>
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


<div class="modal fade" id="admin_modal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" 
               aria-hidden="true">×
            </button>
            <h4 class="modal-title">
                <span id="label"></span> Admin
            </h4>
         </div>
          <form id="admin_from">
          <div class="modal-body">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="col-sm-12">
                      <label class="col-sm-6 margin-bottom-10">Name * </label>
                        <div class="col-sm-6 margin-bottom-10">
                            <input type="text" name="name" id="name" class="form-control">
                            <div id="name_err"></div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                      <label class="col-sm-6 margin-bottom-10">Email * </label>
                        <div class="col-sm-6 margin-bottom-10">
                            <input type="text" name="email" id="email" class="form-control">
                            <div id="email_err"></div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <label class="col-sm-6 margin-bottom-10">Admin Type * </label>
                        <div class="col-sm-6 margin-bottom-10">
                            <select name="admin_type" id="admin_type" style="width:100%;" class="form-control select2">
                                <option value="">Select</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Sub Admin</option>
                            </select>
                            <input type='hidden'  id="actiontype"  />
                            
                            <div id="admin_type_err"></div>
                        </div>
                      </div>
                      <div class="col-sm-12"  id="college_con" >
                      <label class="col-sm-6 margin-bottom-10">Select College* </label>
                        <div class="col-sm-6 margin-bottom-10">
                            <select class="form-control select2" id="college_id" style="width:100%;" name="college_id">
                                <option value="">Select College</option>
                                <?php foreach($colleges as $college){?>
                                <option value="<?=$college->id?>"><?=$college->college_name?></option>
                                <?php }?>
                            </select>
                             <input type='hidden'  id="actiontype"  />
                            <input type='hidden'  id="admin_id" name="admin_id"  />
                            <div id="college_id_err"></div>
                        </div>
                      </div>
                      <div id="pass">
                        <div class="col-sm-12">
                            <label class="col-sm-6 margin-bottom-10">Password * </label>
                            <div class="col-sm-6 margin-bottom-10">
                                <input type="password" name="password" class="form-control">
                                <div id="password1_err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-6">Confirm Password * </label>
                            <div class="col-sm-6">
                                <input type="password" name="cpassword" class="form-control">
                                <div id="cpassword1_err"></div>
                            </div>
                        </div>
                      </div>
                  </div>
                  
              </div>
         </div>
         <div class="modal-footer">
             <div id="ad_loader" class="col-sm-7 text-right"></div>
             <div class="col-sm-5">
             <button type="button" class="btn btn-primary" id="adminBtn">
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


<script src="<?=BASE?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?=BASE?>admin/select2/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('.select2').select2();
    });
    
    function addadmin(action,id,name,email,user_type,college_id)
    {
        if(action=='Edit')
        {
            $('#name').val(name);
            $('#email').val(email);
            $('#admin_type').val(user_type).change();
            setTimeout(function(){$('#college_id').val(college_id).change();},1000)
            $('#admin_id').val(id);
            $('#pass').hide();
        }else{
            $('#name').val('');
            $('#email').val('');
            $('#admin_type').val('');
            $('#college_id').val('');
            $('#pass').show();
        }
        $('#label').text(action);
        $('#actiontype').val(action);
        $('#admin_modal').modal();
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
    $(document).ready(function(){
       $('#admin_type').change(function(){
           if($(this).val()==2)
           {
               $('#college_con').show();
           }else{
               $('#college_con').val('').hide();
           }
       })
        
        $('#example-datatable').DataTable();
        $('.del').click(function(){
            $('#confirm_body').text('Do you really want to delete this admin user');
            $('button.confirm').attr('id',$(this).data('href'));
            $('#confirm').modal();
        });
        
        $('#rBtn').click(function(){
            $('#r_loader').html('<i class="fa fa-spin fa-spinner"></i>');
            var url = '<?=BASE?>panel/user/change-admin-password';
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
        });
        
        $('#adminBtn').click(function()
        {
            $('#ad_loader').html('<i class="fa fa-spin fa-spinner"></i>');
            var la = $("#actiontype").val();
            var url = '<?=BASE?>panel/user/'+la.toLowerCase()+'-admin';
            var data = $('#admin_from').serialize();
            //console.log(url);
            $.post(url,data,function(success){
                var res = JSON.parse(success);
                if(res.status)
                {
                    $('#admin_from')[0].reset();
                    window.location.href = '<?=  current_url()?>'
                }else{
                    var error = res.error;
                    $.each( error, function( i, val ) 
                    {
                        $('#'+i).html(val);
                    });
                    $('#ad_loader').html('<span class="err">Error occured</span>');
                }
            })
        })
    });
    </script>