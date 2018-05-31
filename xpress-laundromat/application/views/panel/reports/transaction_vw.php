<!-- BEGIN PAGE CONTENT -->
<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
<?php 
$college_id="";
if($this->input->get('college_id')){$college_id=base64_decode($this->input->get('college_id'));}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Transaction History
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=BASE?>panel/home"><i class="fa fa-home"></i></a></li>
            <li class="active">Transaction History</li>
        </ol>
    </div>
</div>
                <!-- /.row -->
<!-- BEGIN DATA TABLE -->
<div class="row">
<div class="col-sm-12">
    <?php $msg=$this->session->flashdata('msg'); if($msg){?>
    <div class="alert alert-success fade in ">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       <?=$msg?>
    </div>
    <?php }?>
    <?php $error=$this->session->flashdata('error'); if($error){?>
    <div class="alert alert-danger fade in ">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       <?=$error?>
    </div>
    <?php }?>
<div class="the-box">
<div class="table-responsive">
    <div class="col-sm-8 margin-bottom-20">
        <div class="col-lg-3">
                        <div class="input-group pull-left">
                      <button class="btn btn-info pull-right" id="daterange-btn">
                        <i class="fa fa-calendar"></i> Filter By date
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                </div>
        <div class="col-sm-3">
            <input type="text" id="search" class="form-control" placeholder="Search">
        </div>
        <div class="col-sm-2">
            <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
        </div>
        <div class="col-sm-4">
            <select class="form-control select2" style="height: 34px;" id="college_id" name="college_id">
                <?php if($this->session->user_type==1){?><option value="All">All College</option><?php }?>
                <?php foreach($colleges as $college){?>
                <option value="<?=$college->id?>" <?php if($college_id==$college->id){echo 'selected="selected"';}?>><?=$college->college_name?></option>
                <?php }?>
            </select>
        </div>
    </div>
            <div class="col-sm-3 margin-bottom-20">
                <select class="form-control select2" id="recharge_type">
                    <option value="All">All Recharge Type</option>
                    <option value="online">Online</option>
                    <option value="offline">offline</option>
                </select>
            </div>
    <div class="col-sm-1 margin-bottom-20">
        <form action="<?=BASE?>panel/reports/export_wallet" target="_blank" id="exportxls" method="post" >
            <button class="btn btn-success" id="exportxlsBtn" title="export" type="button"><i class="fa fa-file-excel-o"></i></button>
            <input type="hidden" id="xlssearch" name="search" />
            <input type="hidden" id="xlscollege_id" name="college_id" />
            <input type="hidden" id="xlsdate_from" name="date_from" />
            <input type="hidden" id="xlsdate_to" name="date_to" />
            <input type="hidden" id="xlsr_type" name="r_type" />
        </form>
    </div>
<table class="table table-striped table-hover" id="example-datatable">
        <thead class="the-box dark full">
                <tr>
                    <th>#</th>
                    <th>Credited to</th>
					<th>College</th>
                    <th>Transaction Date</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Payment Type</th>
                    <th>Description</th>
<!--                    <th>Fail Reason</th>-->
                </tr>
        </thead>
        <tbody id="user_body">
            
        </tbody>
</table>
</div><!-- /.table-responsive -->
</div><!-- /.the-box .default -->
<!-- END DATA TABLE -->
</div>
</div>
<script src="<?=BASE?>admin/select2/select2.min.js"></script>
<script src="<?=BASE?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?=BASE?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" ></script>
<script>
        function modal_load(val,msg)
        {
            $('#confirm_body').text(msg);
            $('button.confirm').prop('id',val);
        }
        $(function(){
            $('.select2').select2();
            setTimeout(function(){get_trans('<?=BASE?>panel/reports/ajax-transcation/0');},1000)
    
    $('body').on('click','#paginate a',function(){
        var url=$(this).attr("href");
       get_trans(url);
       return false;

       });
       $('#searchBtn').click(function(){
           get_trans('<?=BASE?>panel/reports/ajax-transcation/0');
       })
       $('#recharge_type,#college_id').change(function(){
           get_trans('<?=BASE?>panel/reports/ajax-transcation/0');
       })
       
       $('#daterange-btn').daterangepicker(
            {
              ranges: {
                  'All' : [moment().subtract(2, 'year').startOf('year'), moment()],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(2, 'year').startOf('year'),
              endDate: moment()
            },
        function (start, end) {
          get_trans('<?=BASE?>panel/reports/ajax-transcation/0');
        }
        );
    $('#exportxlsBtn').click(function(){
        $('#xlssearch').val($('#search').val());
        $('#xlsdate_from').val($('input[name="daterangepicker_start"]').val());
        $('#xlsdate_to').val($('input[name="daterangepicker_end"]').val());
        $('#xlsr_type').val($('#recharge_type').val());
        $('#xlscollege_id').val($('#college_id').val());
		setTimeout(function(){$('#exportxls').submit();},1000);
        
    })
});

function get_trans(url)
{
    $("#user_body").html('<tr><td colspan="9" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i></td></tr>');
    var search = $('#search').val();
    var date_from = $('input[name="daterangepicker_start"]').val();
        var date_to = $('input[name="daterangepicker_end"]').val();
        var r_type = $('#recharge_type').val();
        var college_id = $('#college_id').val();
     if(url!='#' && url!=''){
       $.ajax({
       type: "POST",
       url: url,
       data:{search:search,date_from:date_from, date_to:date_to,r_type:r_type,college_id:college_id},
       success: function(res){
          $("#user_body").html(res);
       }
       });
       }
}
</script>