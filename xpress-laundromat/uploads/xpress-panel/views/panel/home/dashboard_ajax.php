<?php $url="";$url1="";if($college_id!="0"){ $url="&college_id=".base64_encode($college_id);$url1="?college_id=".base64_encode($college_id);}?>
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
                                    <a href="<?=BASE?>panel/user<?=$url1?>">
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
                                    <a href="<?=BASE?>panel/orders?nday=today<?=$url?>">
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
                                    <a href="<?=BASE?>panel/orders/search-order<?=$url1?>">
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
                            <a href="<?=BASE?>panel/reports/wallet-report<?=$url1?>">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>