<?php 
$spage = $this->uri->segment(1);
$s1page = $this->uri->segment(2);
?>
<nav class="page-sidebar" data-pages="sidebar">
      <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header" style="background-color: #fff;">
        <img src="<?=BASE?>assets/img/logo.png" alt="logo" class="brand" data-src="<?=BASE?>assets/img/logo.png" data-src-retina="<?=BASE?>assets/img/logo.png" width="60%">
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30 ">
            <a href="<?=BASE?>home" class="detailed">
              <span class="title">Home</span>
            </a>
            <span class="<?=$spage=='home' && $s1page==''?'bg-success':''?> icon-thumbnail"><i class="pg-home"></i></span>
          </li>
          <li>
            <a href="javascript:;"><span class="title">Book Slot</span>
            <span class=" arrow"></span></a>
            <span class="<?=$spage=='home' && ($s1page=='individual' || $s1page=='drycleaning' || $s1page=='shoelaundry')?'bg-success':''?> icon-thumbnail"><i class="pg-calender"></i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="<?=BASE?>home">Bulk Washing</a>
                <span class="icon-thumbnail">B</span>
              </li>
              <li class="">
                <a href="<?=BASE?>home/individual">Individual Wash</a>
                <span class="<?=$spage=='home' && $s1page=='individual'?'bg-success':''?> icon-thumbnail">I</span>
              </li>
              <li class="">
                <a href="<?=BASE?>home/drycleaning">Dry Cleaning</a>
                <span class="<?=$spage=='home' && $s1page=='drycleaning'?'bg-success':''?> icon-thumbnail">D</span>
              </li>
              <li class="">
                <a href="<?=BASE?>home/premium">Premium Wash</a>
                <span class="<?=$spage=='home' && $s1page=='shoelaundry'?'bg-success':''?> icon-thumbnail">P</span>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="<?=BASE?>user" class="detailed">
              <span class="title">My Account</span>
            </a>
            <span class="<?=$spage=='user' && $s1page==''?'bg-success':''?> icon-thumbnail"><i class="fa fa-user"></i></span>
          </li>
          <li class="">
            <a href="<?=BASE?>home/order-history"><span class="title">Order History</span></a>
            <span class="icon-thumbnail"><i class="pg-social"></i></span>
          </li>
          <li class="">
            <a href="<?=BASE?>user/settings" class="detailed">
              <span class="title">Settings</span>
            </a>
            <span class="<?=$spage=='user' && $s1page=='settings'?'bg-success':''?> icon-thumbnail"><i class="pg-settings"></i></span>
          </li>
          <li class=" visible-xs">
            <a href="<?=BASE?>about" class="detailed">
              <span class="title">About</span>
            </a>
            <span class="<?=$spage=='about'?'bg-success':''?> icon-thumbnail"><i class="pg-note"></i></span>
          </li>
          <li class="visible-xs">
            <a href="<?=BASE?>contact" class="detailed">
              <span class="title">Contact</span>
            </a>
            <span class="<?=$spage=='contact'?'bg-success':''?> icon-thumbnail"><i class="pg-contact_book"></i></span>
          </li>
          <li class=" visible-xs">
            <a href="<?=BASE?>how-it-works" class="detailed">
              <span class="title">How It Works</span>
            </a>
            <span class="<?=$spage=='how-it-works'?'bg-success':''?> icon-thumbnail"><i class="pg-battery"></i></span>
          </li>
          <li class="">
            <a href="<?=BASE?>auth/logout"><span class="title">Logout</span></a>
            <span class="icon-thumbnail"><i class="fa fa-sign-out"></i></span>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>