<!-- BEGIN PAGE CONTENT -->
<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
<link href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Bookdate Wise Setup Report
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=BASE?>panel/home"><i class="fa fa-home"></i></a></li>
            <li class="active">Bookdate Wise Setup Report </li>
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
        <div class="col-sm-4 margin-bottom-20">
        <form action="<?=BASE?>panel/reports/downloadbookdatewise-report" target="_blank" id="exportxls" method="post" >
            <button class="btn btn-success" id="exportxlsBtn" title="export" type="button"><i class="fa fa-file-excel-o"></i> Download Excel</button>
            <input type="hidden" id="xlsdate_from" name="date_from" />
            <input type="hidden" id="xlsdate_to" name="date_to" />
        </form>
    </div>
    </div>
    
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
        $(function(){
            $('.select2').select2();
       
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
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {

        }
        );
    $('#exportxlsBtn').click(function(){
        $('#xlsdate_from').val($('input[name="daterangepicker_start"]').val());
        $('#xlsdate_to').val($('input[name="daterangepicker_end"]').val());
        $('#exportxls').submit();
    })
});

</script>