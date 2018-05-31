    <!-- Morris Charts CSS -->
    <link href="<?=BASE?>assets/plugins/morris/morris.css" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reports
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=BASE?>panel/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?=BASE?>panel/reports"><i class="fa fa-line-chart"></i> Reports</a></li>
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
                                                <div class="huge"></div>
                                                <div>Customers Report!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?=BASE?>panel/reports/user_report">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Report</span>
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
                                        <i class="fa fa-dollar fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"></div>
                                        <div>Transaction Report!</div>
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
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-dollar fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$total_order?></div>
                                        <div>User <100 Balance</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/reports/wallet-less">
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
                                        <i class="fa fa-truck fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"></div>
                                        <div>COD Report</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/reports/cod-report">
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
                                        <i class="fa fa-shopping-bag fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$total_order?></div>
                                        <div>Bookdate Wise Sales Report </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/reports/salesbookdate-report">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                      <?php if($this->session->user_type==1){?>
                      <div class="col-lg-3 col-md-6">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-institution fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$total_order?></div>
                                        <div>Bookdate Wise Setup Report </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/reports/adminbookdate-report">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-institution fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$total_order?></div>
                                        <div>Setup Wise Report</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/reports/admin-report">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>  
                      
                      <?php }?>
		<div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-bag fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$total_order?></div>
                                        <div>Sales Report</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?=BASE?>panel/reports/sales-report">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>			  
                    
                </div>
          </div><!-- /.row -->
             </div><!-- /.box-body -->
              </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->