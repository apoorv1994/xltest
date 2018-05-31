<!DOCTYPE html>
<html>
<body onload="getLocation()">
  <head>
    <style>
    img {
        float: left;
        border: 1px dotted black;
        margin: 0px 0px 15px 20px;
    }
    </style>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=BASE?>pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=BASE?>pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=BASE?>pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="<?=BASE?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE?>assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE?>assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?=BASE?>assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?=BASE?>assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?=BASE?>pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="<?=BASE?>pages/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE?>assets/css/style.css" rel="stylesheet" type="text/css">
    <!--[if lte IE 9]>
  <link href="assets/plugins/codrops-dialogFx/dialog.ie.css" rel="stylesheet" type="text/css" media="screen" />
  <![endif]-->
    <script src="<?=BASE?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="<?=BASE?>assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src=“https://www.googletagmanager.com/gtag/js?id=UA-109341189-1“></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag(‘js’, new Date());

    gtag(‘config’, ‘UA-109341189-1’);
    </script>



  </head>
  <body class="fixed-header ">
    <!-- BEGIN SIDEBPANEL-->
    
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container " >
      <!-- START HEADER -->
      <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <div class="container-fluid container-fixed-lg">
        <div class="container-fluid relative">
          <!-- LEFT SIDE -->
          <!-- <div class="pull-left full-height visible-sm visible-xs">
          
            <div class="header-inner">
              <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
                <span class="icon-set menu-hambuger"></span>
              </a>
            </div>
          
          </div> -->
          <div class="pull-center hidden-md hidden-lg" style="width: auto;">
            <div class="header-inner">
              <div class="brand inline">
                  <a href="<?=BASE?>" title=""><img src="<?=BASE?>assets/img/logo.png" alt="logo" data-src="<?=BASE?>assets/img/logo.png" data-src-retina="<?=BASE?>assets/img/logo.png"  width="78" height="22"></a>
              </div>
            </div>
          </div>
          <!-- RIGHT SIDE -->
          <div class="pull-right full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
<!--            <div class="header-inner">
              <a href="#" class="btn-link visible-sm-inline-block visible-xs-inline-block" data-toggle="quickview" data-toggle-element="#quickview">
                <span class="icon-set menu-hambuger-plus"></span>
              </a>
            </div>-->
            <!-- END ACTION BAR -->
          </div>
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table hidden-xs hidden-sm">
          <div class="header-inner">
            <div class="brand inline">
                <a href="<?=BASE?>" title=""><img src="<?=BASE?>assets/img/logo.png" alt="logo" style="width: 80%;" data-src="<?=BASE?>assets/img/logo.png" data-src-retina="<?=BASE?>assets/img/logo.png" width="78" height="50"></a>
            </div>
            <!-- START NOTIFICATION LIST -->
            <ul class="notification-list no-margin hidden-sm hidden-xs b-grey b-l b-r no-style p-l-30 p-r-20">
              <li class="p-r-15 inline">
                <a href="<?=BASE?>" class=" ">Home</a>
              </li>
              <li class="p-r-15 inline">
                <a href="<?=BASE?>about" class=" ">About</a>
              </li>
              <li class="p-r-15 inline">
                <a href="<?=BASE?>how-it-works" class=" ">How it works</a>
              </li>
            </ul>
            <!-- END NOTIFICATIONS LIST -->
             </div>
        </div>
        <div class=" pull-right">
          <!-- START User Info-->
          <div >

            <div class="pull-left p-r-20 p-t-10 fs-16 font-heading <?php if($this->session->user_id){echo 'visible-lg visible-md m-t-10'; }else{echo 'ss';}?>">
                <a  id='locate_id'>  </a>
                <a href="<?=BASE?>" title=""><img src="<?=BASE?>assets/img/location.png" alt="location" data-src="<?=BASE?>assets/img/location.png" data-src-retina="<?=BASE?>assets/img/location.png" width="20" height="20"></a>
            </div>
            <p id="demo">DEMO</p>
            <div class="pull-left p-r-20 p-t-10 fs-16 font-heading <?php if($this->session->user_id){echo 'visible-lg visible-md m-t-10'; }else{echo 'ss';}?>">
                <a href="<?=BASE?>faqs" title="Faq">FAQ</a>
            </div>
 <div class="pull-left p-r-20 p-t-10 fs-16 font-heading <?php if($this->session->user_id){echo 'visible-lg visible-md m-t-10'; }else{echo 'ss';}?>">
                <a href="https://xlinfoprise.wordpress.com/" target="_blank" title="blog">Blog</a>
            </div>
<div class="pull-left p-r-20 p-t-10 fs-16 font-heading <?php if($this->session->user_id){echo 'visible-lg visible-md m-t-10'; }else{echo 'ss';}?>">
                <a href="https://goo.gl/forms/quNz7BCt0mToYTyH2" target="_blank" title="blog">Careers</a>
            </div>
              <div class="pull-left p-r-20 p-t-10 fs-16 font-heading <?php if($this->session->user_id){echo 'visible-lg visible-md m-t-10'; }else{echo 'ss';}?>">
                  <a href="<?=BASE?>contact" class="" title="Contact Us">Contact</a>
            </div>
              <?php if(!$this->session->user_id ){if( $this->uri->segment(1)!=''){?>
              <div class="pull-left p-r-20 p-t-10 fs-16 font-heading">
                <a href="<?=BASE?>" title="Login">Login</a>
            </div>
              <?php }}else{?>
              <div class="pull-left p-r-20 p-t-10 fs-16 font-heading">
                <div class="dropdown">
  <button  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    My Profile
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a href="<?=BASE?>home" title="Book Now">Book Now</a>
    <a href="<?=BASE?>user" class="detailed">
              <span class="title">My Account</span>
            </a>
            <a href="<?=BASE?>home/order-history"><span class="title">Order History</span></a>
    <a href="<?=BASE?>user/settings" class="detailed">
              <span class="title">Change Password</span>
            </a>
            <a href="<?=BASE?>auth/logout" title="Logout">Logout</a>
  </div>
</div>
            </div>
              <?php }
              if($this->uri->segment(1)!=''){
              ?>

          
              <?php }?>
          </div>
          
          <!-- END User Info-->
        </div>
        </div>
      </div>
      <!-- END HEADER -->
      
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">


    <script>
    var x = document.getElementById("locate_id");
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }
    function showPosition(position) {

        var longitude_val = position.coords.latitude;
        var latitude_val = position.coords.longitude;
        var url = '<?=BASE?>auth/getCollegeId';

        //var college_id = ;      
        //print(college_info);
        var lat;
        var long;
        var dis;
   
        document.getElementById("demo").innerHTML = clg_id;
        x.innerHTML = clg_id;
    }
    function calcDistance(lat1, lon1, lat2, lon2) 
    {
      var R = 6371; // km
      var dLat = toRad(lat2-lat1);
      var dLon = toRad(lon2-lon1);
      var lat1 = toRad(lat1);
      var lat2 = toRad(lat2);

      var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
      var d = R * c;
      return d;
    }

    // Converts numeric degrees to radians
    function toRad(Value) 
    {
        return Value * Math.PI / 180;
    }
    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                break;
        }
    }

    function showLocation(){

    }
    </script>