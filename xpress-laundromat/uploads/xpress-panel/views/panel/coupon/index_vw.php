<link href="<?=BASE?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css">
<?php $page = $this->uri->segment(3);?>
<div class="col-lg-12">
          
<div class="row">
	<div class="col-lg-12">
		<div class="page-title">
					<h1>Coupon<button id="btnAddweight" class="btn btn-success pull-right" onclick="edit('Add')"><i class="fa fa-plus-circle"></i> Add Coupons </button>

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
<div class="panel-heading" style="padding-bottom:10px;"><h4>Coupon List</h4></div>
<div class="panel-body">
    <div class="col-lg-12" style="overflow-x: scroll;">
        <table class="table table-striped table-hover" id="example-datatable">
        <thead class="the-box dark full">
                <tr>
                    <th>Sl.No.</th>
                    <th>Coupon Code</th>
<!--                    <th>Description</th>-->
                    <th>% discount</th>
                    <th>Max Discount</th>
                    <th>Use time</th>
                    <th>Valid From</th>
                    <th>Expire On</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody id="user_body">
            <?php if($coupons){$i=1; foreach($coupons as $coupon){?>
            <tr>
                <td><?=$i++;?></td>
                <td><?=$coupon->coupon_code?></td>
<!--                <td><?=$coupon->description?></td>-->
                <td><?=$coupon->percent_discount?></td>
                <td><?=$coupon->max_discount?></td>
                <td><?=$coupon->repeat_times?></td>
                <td><?=date('d-m-Y',$coupon->valid_from)?></td>
                <td><?=date('d-m-Y',$coupon->valid_upto)?></td>
                <td >
                    <div  class="dropdown">
                    <button class="btn <?=$coupon->status==1?'btn-success':'btn-danger'?> dropdown-toggle" type="button" data-toggle="dropdown"> <?=$coupon->status==1?'Active':'Inactive'?>
                    <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="<?=BASE?>panel/coupon/status/<?=$coupon->id?>/1">Active</a></li>
                        <li><a href="<?=BASE?>panel/coupon/status/<?=$coupon->id?>/0">Inactive</a></li>
                      </ul>
                    </div>
                </td>
                <td>
                    <div  class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Action
                    <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                          <li><a href="javascript:void(0)" onclick="edit('Edit','<?=$coupon->id?>')">Edit</a></li>
                          <li><a class="del" data-href="<?=BASE?>panel/coupon/delete/<?=$coupon->id?>">Delete</a></li>
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
                <span id="label">Edit</span> Coupon
            </h4>
         </div>
          <div class="modal-body">
            <form role="form" id="editFrm" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Coupon Code</label>
                            <input type='text'  name="coupon_code" id="coupon_code" class="form-control" />
                            <input type='hidden'  name="coupon_id" id="coupon_id"  />
                            <input type='hidden'  id="actiontype"  />
                            <div id="coupon_code_err"></div>
                        </div>
                        <div class="col-sm-6">
<!--                            <label>Description</label>
                            <textarea name="description" id="description" class="form-control" ></textarea>
                            <div id="description_err"></div>-->
                        </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>% Discount</label>
                            <input type='text'  name="percent_discount" id="percent_discount" class="form-control" />
                            <div id="percent_discount_err"></div>
                        </div>
                        <div class="col-sm-6">
                            <label>Max Discount</label>
                            <input type='text'  name="max_discount" id="max_discount" class="form-control" />
                            <div id="max_discount_err"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Valid From</label>
                            <div class='input-group date datetimepicker' id="start_date">
                            <input type='text' value="" id="validfrom" name="validfrom" class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
<!--                            <input type='text'  name="validfrom" id="validfrom" class="form-control" />-->
                            <div id="validfrom_err"></div>
                        </div>
                        <div class="col-sm-6">
                            <label>Valid UpTo</label>
                            <div class='input-group date datetimepicker' id="end_date">
                            <input type='text' id="validto" name="validto" class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
<!--                            <input type='text'  name="valifto" id="validto" class="form-control" />-->
                            <div id="validto_err"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Max Use time</label>
                            <input type='number'  name="use_time" id="use_time" class="form-control" />
                            <div id="use_time_err"></div>
                        </div>
                        <div class="col-sm-6">
                            
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
<script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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
        
        $('#start_date').datepicker({
        format: 'dd/mm/yyyy',
        startDate: '-0d',
        autoclose: true
    }).on('changeDate', function(ev) {
    $('#end_date').datepicker('remove');
    $('#end_date').datepicker({ 
                format: 'dd/mm/yyyy',
                startDate: ev.date
                });
    var d = $('#validfrom').val();
       $('#end_date').datepicker('update',d);
});
$('#end_date').datepicker({format: 'dd/mm/yyyy',autoclose: true});
    });
    function edit(action,id)
    {
        if(action=='Edit')
        {
            var url = '<?=BASE?>panel/coupon/get_coupon/'+id;
             $.get(url,function(success){
                 var res = JSON.parse(success);
                 if(res.status)
                 {
                    $('#coupon_code').val(res.data.coupon_code);
                    $('#percent_discount').val(res.data.percent_discount);
                    $('#max_discount').val(res.data.max_discount);
                    $('#use_time').val(res.data.repeat_times);
                    
                    $('#coupon_id').val(res.data.id);
                    $('#start_date').datepicker('update',res.data.valid_from);
                    $('#end_date').datepicker('update',res.data.valid_upto);
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
        var url = '<?=BASE?>panel/coupon/'+la.toLowerCase();
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