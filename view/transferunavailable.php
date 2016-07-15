<!DOCTYPE html>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>

<!-- Mirrored from www.riaxe.com/marketplace/thin-admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Apr 2016 11:18:37 GMT -->
<head>
<title>NAIK FEEDS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/thin-admin.css" rel="stylesheet" media="screen">
<link href="css/font-awesome.css" rel="stylesheet" media="screen">
<link href="style/style.css" rel="stylesheet">
<link href="style/dashboard.css" rel="stylesheet">
<link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="container">
  <div class="top-navbar header b-b"> <a data-original-title="Toggle navigation" class="toggle-side-nav pull-left" href="#"><i class="icon-reorder"></i> </a>
      <div class="brand pull-left"> <H2>NAIK FEEDS</H2></div>
    <ul class="nav navbar-nav navbar-right  hidden-xs">
      <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-warning-sign"></i> <span class="badge">2</span> </a>
        <ul class="dropdown-menu extended notification">
          <li class="title">
            <p>You have 2 new stock movement today</p>
          </li>
          <li> <a href="#"> <span class="label label-success"><i class="icon-plus"></i></span> <span class="message"> 40 bags moved from Jos to Abuja.</span> <span class="time">1 mins</span> </a> </li>
          <li> <a href="#"> <span class="label label-danger"><i class="icon-warning-sign"></i></span> <span class="message">40 bags moved from Jos to Abuja.</span> <span class="time">5 mins</span> </a> </li>
          <li class="footer"> <a href="#">View all stock movements</a> </li>
        </ul>
      </li>
     
      <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-envelope"></i> <span class="badge">3</span> </a>
        <ul class="dropdown-menu extended notification">
          <li class="title">
            <p>You have 3 new sales</p>
          </li>
          <li> <a href="#"> <span class="label label-success"><i class="icon-plus"></i></span> <span class="message"> 40 bags sold from Jos Sales Area.</span> <span class="time">1 mins</span> </a> </li>
          <li> <a href="#"> <span class="label label-danger"><i class="icon-warning-sign"></i></span> <span class="message">40 bags sold from Abuja Sales Area.</span> <span class="time">5 mins</span> </a> </li>
          <li> <a href="#"> <span class="label label-danger"><i class="icon-warning-sign"></i></span> <span class="message">40 bags sold from Abuja Sales Area.</span> <span class="time">5 mins</span> </a> </li>
          <li class="footer"> <a href="#">View all sales</a> </li>
        </ul>
      </li>
      <li class="dropdown user  hidden-xs"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-male"></i> <span class="username">Admin</span> <i class="icon-caret-down small"></i> </a>
        <ul class="dropdown-menu">
          <li><a href="user_profile.html"><i class="icon-user"></i> My Profile</a></li>
          <li class="divider"></li>
          <li><a href="logout"><i class="icon-key"></i> Log Out</a></li>
        </ul>
      </li>
    </ul>
    <form class="pull-right" >
      <input type="search" placeholder="Search..." class="search" id="search-input">
    </form>
  </div>
</div>
<div class="wrapper">
  <div class="left-nav">
    <div id="side-nav">
      <?php require_once 'includes/factoryusermenu.php'; ?>
    </div>
  </div>
  <div class="page-content">
    <div class="content container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="page-title">Transfer Failed<small></small></h2>
        </div>
      </div>
      <div class="row">
        <div class="alert alert-danger alert-block fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert"> <i class="icon-remove"></i> </button>
                    <h4> <i class="icon-ok-sign"></i> Failure! </h4>
                    <p>Stock Transfer has failed because your current stock is not enough!</p>
                  </div>
      </div>
      
      
      
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?> 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/smooth-sliding-menu.js"></script> 
<script class="include" type="text/javascript" src="javascript/jquery191.min.js"></script> 
<script class="include" type="text/javascript" src="javascript/jquery.jqplot.min.js"></script> 
<script src="assets/sparkline/jquery.sparkline.js" type="text/javascript"></script>
<script src="assets/sparkline/jquery.customSelect.min.js" ></script>
<script src="assets/sparkline/sparkline-chart.js"></script>
<script src="assets/sparkline/easy-pie-chart.js"></script>
<script src="js/select-checkbox.js"></script> 
<script src="js/to-do-admin.js"></script> 

<!--switcher html start-->
<!-- <div class="demo_changer active" style="right: 0px;">
  <div class="demo-icon"></div>
  <div class="form_holder">
    <div class="predefined_styles"> <a class="styleswitch" rel="a" href=""><img alt="" src="images/a.jpg"></a> <a class="styleswitch" rel="b" href=""><img alt="" src="images/b.jpg"></a> <a class="styleswitch" rel="c" href=""><img alt="" src="images/c.jpg"></a> <a class="styleswitch" rel="d" href=""><img alt="" src="images/d.jpg"></a> <a class="styleswitch" rel="e" href=""><img alt="" src="images/e.jpg"></a> <a class="styleswitch" rel="f" href=""><img alt="" src="images/f.jpg"></a> <a class="styleswitch" rel="g" href=""><img alt="" src="images/g.jpg"></a> <a class="styleswitch" rel="h" href=""><img alt="" src="images/h.jpg"></a> <a class="styleswitch" rel="i" href=""><img alt="" src="images/i.jpg"></a> <a class="styleswitch" rel="j" href=""><img alt="" src="images/j.jpg"></a> </div>
  </div>
</div> -->

<!--switcher html end--> 
<script src="assets/switcher/switcher.js"></script> 
<script src="assets/switcher/moderziner.custom.js"></script>
<link href="assets/switcher/switcher.css" rel="stylesheet">
<link href="assets/switcher/switcher-defult.css" rel="stylesheet">
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/a.css" title="a" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/b.css" title="b" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/c.css" title="c" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/d.css" title="d" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/e.css" title="e" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/f.css" title="f" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/g.css" title="g" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/h.css" title="h" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/i.css" title="i" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/j.css" title="j" media="all" />



</body>

<!-- Mirrored from www.riaxe.com/marketplace/thin-admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Apr 2016 11:18:37 GMT -->
</html>

