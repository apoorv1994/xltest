<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="<?=BASE?>panel/home/"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?=BASE?>panel/home/slotlist"><i class="fa fa-fw fa-gavel"></i> Slot Type</a>
                    </li>
                    <li>
                        <a href="<?=BASE?>panel/home/shop-setting"><i class="fa fa-fw fa-gear"></i> Shop Settings</a>
                    </li>
                    <?php if($this->session->user_type==1){?>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> <span>College & Hostel</span> <i class="fa fa-fw fa-caret-down pull-right"></i></a>
                        <ul id="demo" class="collapse">
                            <li><a href="<?=BASE?>panel/home/college-list"><i class="fa fa-fw fa-users"></i> College</a></li>
                            <li><a href="<?=BASE?>panel/home/hostel-list"><i class="fa fa-fw fa-building"></i> Hostel</a></li>
                        </ul>
                    </li>
                    <?php }?>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#ordermenu"><i class="fa fa-fw fa-shopping-bag"></i> <span>Orders</span> <i class="fa fa-fw fa-caret-down pull-right"></i></a>
                        <ul id="ordermenu" class="collapse">
                            <li><a href="<?=BASE?>panel/orders/"><i class="fa fa-fw fa-paper-plane"></i> Order manage</a></li>
                            <li><a href="<?=BASE?>panel/orders/manage-dropoff"><i class="fa fa-fw fa-arrow-circle-down"></i> Manage Drop Off</a></li>
                            <li><a href="<?=BASE?>panel/orders/search-order"><i class="fa fa-fw fa-search"></i> Search Order</a></li>
                            
                        </ul>
                    </li>
                    <li><a href="<?=BASE?>panel/orders/create-order"><i class="fa fa-fw fa-plus"></i> Create Order</a></li>
                    <li>
                        <a href="<?=BASE?>panel/user"><i class="fa fa-fw fa-users"></i> Users</a>
                    </li>
                    <li><a href="<?=BASE?>panel/user/add-user"><i class="fa fa-fw fa-user-plus"></i> Add user</a></li>
                    <li>
                        <a href="<?=BASE?>panel/reports"><i class="fa fa-fw fa-line-chart"></i> Reports</a>
                    </li>
                    <?php if($this->session->user_type==1){?>
                    <li>
                        <a href="<?=BASE?>panel/user/adminlist"><i class="fa fa-fw fa-users"></i> Manage Admin</a>
                    </li>
                    <li>
                        <a href="<?=BASE?>panel/coupon"><i class="fa fa-fw fa-tag"></i> Manage Coupon</a>
                    </li>
			<li>
                        <a href="http://xpresslaundromat.in/auth/wallet_correct"  target="_blank"><i class="fa fa-fw fa-tag"></i> Correct wallet</a>
                    </li>
                    <?php }?>
<!--                    <li>
                        <a href="<?=BASE?>panel/home/transaction-history"><i class="fa fa-fw fa-dollar"></i> Transaction History</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
