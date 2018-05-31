    <!-- Morris Charts CSS -->
    <link href="<?=BASE?>assets/plugins/morris/morris.css" rel="stylesheet">
    <link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            DASHBOARD
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=BASE?>panel/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
              <div class="box-body">
                  <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$u_count?></div>
                                        <div>Total Users!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/user">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                      <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-calendar fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$to_count?></div>
                                        <div>Today Orders!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/orders?nday=today">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-shopping-bag fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?=$total_order?></div>
                                                <div>Total Orders!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?=BASE?>panel/orders/search-order">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-inr fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$t_count?></div>
                                        <div>Total Transaction</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/reports/wallet-report">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                       <?php if($this->session->user_type==1){?>
                      <div class="col-sm-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-search"></i> College Specific numbers</h3>
                            </div>
                            <div class="panel-body">
                                <form id="search">
                                <div class="row">
                                    <div class="col-sm-12" style="min-height: 300px;">
                                        <div class="col-sm-3 col-sm-offset-4" >
                                            <label>Select College</label>
                                            <select class="form-control select2" name="college_id" id="filter_college" onchange="get_ajax_data(this.value);">
                                                <option value="0">All</option>
                                                <?php foreach($colleges as $college){?>
                                                <option <?=$this->input->get('filter_setting')==$college->id?'Selected':''?> value="<?=$college->id?>"><?=$college->college_name?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        
                                    
										<div class="col-sm-12" id="dashboard_data" style="margin-top: 50px;"></div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                      
                      <!-- Charts-->
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-line-chart"></i> Transaction Graph</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-line-chart"></div>
                                <div class="text-right">
<!--                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div><!-- /.row -->
             </div><!-- /.box-body -->
              </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
          <!-- Morris Charts JavaScript -->
    <script src="<?=BASE?>assets/plugins/morris/raphael.min.js"></script>
    <script src="<?=BASE?>assets/plugins/morris/morris.min.js"></script>
    <script src="<?=BASE?>admin/select2/select2.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#byname').keyup(function(){
                $('#byroll,#bytoken').val('');
                get_data()
            })
            $('#byroll').keyup(function(){
                $('#byname,#bytoken').val('');
                get_data()
            })
            $('#bytoken').keyup(function(){
                $('#byroll,#byname').val('');
                get_data()
            })
            $('#filter_college').change(function(){
                get_data()
            })
            
            get_graph();
            $('.select2').select2();
            function get_graph()
            {
                var url = '<?=BASE?>panel/home/get-transaction-total-modify';
                $.get(url,function(success){
                    var res= JSON.parse(success);
                     Morris.Line({
                        // ID of the element in which to draw the chart.
                        element: 'morris-line-chart',
                        // Chart data records -- each entry in this array corresponds to a point on
                        // the chart.
                        data: res,
                        // The name of the data record attribute that contains x-visitss.
                        xkey: 'd',
                        // A list of names of data record attributes that contain y-visitss.
                        ykeys: ['amount','online','offline','orders'],
                        // Labels for the ykeys -- will be displayed when you hover over the
                        // chart.
                        labels: ['Amount','Online','Offline','Orders'],
                        // Disables line smoothing
                        smooth: false,
                        resize: true
                    });
                })
            }
           
        })
        
        function get_data()
        {
            if($('#byname').val()!='' || $('#byroll').val()!='' || $('#bytoken').val()!='' )
            {
                var data = $('#search').serialize();
                var url = '<?=BASE?>panel/home/search';
                $.post(url,data,function(success){
                    $('#order_body').html(success);
                    $('#searchdata').show();
                })
            }else{
                $('#order_body').html('');
                    $('#searchdata').hide();
            }
        }
		
		function get_ajax_data(id)
		{
			
			 var data = "college_id="+id;
                var url = '<?=BASE?>panel/home/get_dashboard_data';
                $.post(url,data,function(success){
                    $('#dashboard_data').html(success);
                })
		}
        </script>