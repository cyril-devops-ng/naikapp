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
<style type="text/css">
.scroll-left {
 height: 50px;	
 overflow: hidden;
 position: relative;
}
.scroll-left p {
 position: absolute;
 width: 100%;
 height: 100%;
 margin: 0;
 line-height: 50px;
 text-align: center;
 /* Starting position */
 -moz-transform:translateX(100%);
 -webkit-transform:translateX(100%);	
 transform:translateX(100%);
 /* Apply animation to this element */	
 -moz-animation: scroll-left 15s linear infinite;
 -webkit-animation: scroll-left 15s linear infinite;
 animation: scroll-left 15s linear infinite;
}
/* Move it (define the animation) */
@-moz-keyframes scroll-left {
 0%   { -moz-transform: translateX(100%); }
 100% { -moz-transform: translateX(-100%); }
}
@-webkit-keyframes scroll-left {
 0%   { -webkit-transform: translateX(100%); }
 100% { -webkit-transform: translateX(-100%); }
}
@keyframes scroll-left {
 0%   { 
 -moz-transform: translateX(100%); /* Browser bug fix */
 -webkit-transform: translateX(100%); /* Browser bug fix */
 transform: translateX(100%); 		
 }
 100% { 
 -moz-transform: translateX(-100%); /* Browser bug fix */
 -webkit-transform: translateX(-100%); /* Browser bug fix */
 transform: translateX(-100%); 
 }
}
</style>
</head>
<body>
<div class="container">
  <?php 
        $request_count = 0;
        foreach( $_SESSION['requestlist'] as $k=>$v){
            if($v['status'] == 'Pending'){
                ++$request_count;
            }
        }
        require_once 'includes/topbar.php';
        $lagostotal = 0.00;
        $abujatotal = 0.00;
        $jostotal = 0.00;
        $grossprofit = 0.00;
        
        
        $hlc = 0;
        $hbc = 0;
        $prestarter = 0;
        $broilerstarter = 0;
        $broilerfinisher = 0;
        $chickmash = 0;
        $growersmash = 0;
        $layersmash = 0;
        $hbc30 = 0;
        $hlc20 = 0;
        $blank = 0;
        foreach($_SESSION['admin_sales'] as $k=>$v){
            if($v['sales_date'] == date("Y-m-d")){
                if($v['sales_area'] == 'Jos'){
                    $jostotal += floatval(str_replace(',', '', $v['total_price']));
                }

                if($v['sales_area'] == 'Abuja'){
                    $abujatotal += floatval(str_replace(',', '', $v['total_price']));
                }

                if($v['sales_area'] == 'Lagos'){
                    $lagostotal += floatval(str_replace(',', '', $v['total_price']));
                }
            }
        }
    ?>
</div>
<div class="wrapper">
  <div class="left-nav">
    <div id="side-nav">
      <?php require_once 'includes/menu.php'; ?>    
    </div>
  </div>
    
  <div class="page-content">
      
    <div class="content container">
<!--        <div class="scroll-left" >
            <p><span style="font-size:28px;color:#d8e503;">TODAY</span>:<span style="font-size:28px;color:white;">SALES IN ABUJA: <span style="font-size:28px;color:#d8e503;">&#8358 <?= number_format($abujatotal)?></span></span> <span style="color:white;font-size: 28px;">SALES IN LAGOS: <span style="font-size:28px;color:#d8e503;">&#8358 <?= number_format($lagostotal)?></span></span>
                <span style="color:white;font-size: 28px;">SALES IN JOS: <span style="font-size:28px;color:#d8e503;">&#8358 <?= number_format($jostotal)?></span></span></p>
            </div>-->
      <div class="row">
        <div class="col-lg-12">
          <h2 class="page-title">MD's OFFICE <small>Dashboard</small></h2>
        </div>
      </div>
      <div class="row">
          <?php // print '<pre>'; print_r($_SESSION); print '</pre>';
            foreach ($_SESSION['stockrm_value'] as $k=>$v){
                $date = date('Y-m-d');
                $m = explode('-',$date);
                $mm = $m[1];
                
                $rawmaterial += ( floatval(str_replace(',', '', $v['cost_price'])) * floatVal($v['quantity']) );
               
            }
            foreach($_SESSION['stock_value'] as $k=>$v){
                $date = date('Y-m-d');
                $m = explode('-',$date);
                $mm = $m[1];
                
                
                $v['selling_price'] = 0;
                 $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $m = explode(',',$month);
                $y = explode('-',$v['upload_date'])[0];
                $_m = explode('-',$v['upload_date'])[1];
                $_m = intval($mm);
//                $_m = intval($_m);
                $_m -= 1;
                
//                echo  $v['upload_date'];
                $this->model->set_query('select * from prices where stock_name= ? and month = ? and year = ? order by year DESC, month DESC LIMIT 1');
                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name'],$m[$_m],$y));

                $v['selling_price'] = $th[0]['selling_price'];
                $v['cost_price'] = $th[0]['cost_price'];
                
                
                if($v['stock_type'] == 'Concentrates'){
                    if($v['stock_name'] == 'HLC 5%'){
                       $hlc += $v['quantity'];
                    }
                    if($v['stock_name'] == 'HBC 10%'){
                        $hbc += $v['quantity'];
                    }
                    if($v['stock_name'] == 'PRE-STARTER'){
                        $prestarter += $v['quantity'];
                    }
                    $total += ( floatval(str_replace(',', '', $v['selling_price'])) * floatVal($v['quantity']) );
                }
                if($v['stock_type'] == 'Raw Materials'){
                    $rawmaterial += ( floatval(str_replace(',', '', $v['cost_price'])) * floatVal($v['quantity']) );
                }
                if($v['stock_type'] == 'Complete Feed'){
                    if($v['stock_name'] == 'Broiler Starter'){
                       $broilerstarter += $v['quantity'];
                    }
                    if($v['stock_name'] == 'Broiler Finisher'){
                       $broilerfinisher += $v['quantity'];
                    }
                    if($v['stock_name'] == 'Chick Mash'){
                       $chickmash += $v['quantity'];
                    }
                    if($v['stock_name'] == 'Growers Mash'){
                       $growersmash += $v['quantity'];
                    }
                    if($v['stock_name'] == 'Layers Mash'){
                       $layersmash += $v['quantity'];
                    }
                    if($v['stock_name'] == 'HBC 30%'){
                       $hbc30 += $v['quantity'];
                    }
                    if($v['stock_name'] == 'HLC 20%'){
                       $hlc20 += $v['quantity'];
                    }
                    $completefeed += ( floatval(str_replace(',', '', $v['selling_price'])) * floatVal($v['quantity']) );
                }
//                $total += $subtotal;
            }
            $date = date('Y-m-d');
            $m = explode('-',$date);
            $month = $m[1];
             
            //RESET
//            $total = 0;
//            $rawmaterial = 0;
//            $completefeed = 0;
            
            foreach( $_SESSION['expense_details'] as $e=>$f){
                $expensedate = $f['date'];
                $e_d = explode('-',$expensedate);
                $e_month = $e_d[1];

                if( $e_month == $month){
                    $subexpense = floatval( str_replace(',', '', $f['expense_amount']));
                    $expense += $subexpense;
                }
            }
//                print_r($_SESSION['sales_details']);
            foreach($_SESSION['sales_details'] as $k=>$v){
//                $this->model->set_query('select * from prices where stock_name= ? order by year DESC, month DESC LIMIT 1');
//                $th = $this->model->map_request('raw_query', '', '', '', '', array($v['stock_name']));
//                $v['selling_price'] = $th[0]['selling_price'];
                
                $s_m = $v['sales_date'];
                $s_month = explode('-',$s_m);
                $smonth = $s_month[1];
                
                
                //get expenses 
                
                if( $v['trans_type'] == 'Cash'  &&  $smonth == $month){//&&  $smonth == $month
//                print_r($v) .'<br/>';
                  $subsales +=  floatval(str_replace(',', '', $v['total_price']))  ;
                  $totalsales += $subsales;  
                  $subprofit = $subsales - (  floatval(str_replace(',','' ,$v['cost_price'])) * floatval($v['quantity']));
                  $totalprofit += $subprofit;
                  $grossprofit += $subprofit;
                }
                
            }
            
            //get employee basic pay
            if(is_array($_SESSION['userslist']) || is_object($_SESSION['userslist'])){
            foreach($_SESSION['userslist'] as $k=>$v){
                $pay = floatval(str_replace(',', '', $v['pay']))  ;
                $totalsalary += $pay;
            }
            }
            
            $grossprofit -= $expense;
//            $totalprofit -= $expense;
            $totalprofit -= $totalsalary;
          ?>
        <div class="col-md-12">
          <div class="row">
              <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Profit</div>
              <div class="stats-body-alt"> 
               
                <div class="text-center"><span class="text-top">&#8358</span> <?= number_format($totalprofit) ?></div>
                <small>Profit for this month</small> </div>
              <div class="stats-footer">more info</div>
              </a> </div>
              <div class="col-md-3 col-xs-12 col-sm-6"> <a href="grossprofit" class="stats-container">
              <div class="stats-heading">Gross Profit</div>
              <div class="stats-body-alt"> 
             
                <div class="text-center"><span class="text-top">&#8358</span> <?= $expense > 0.00 ? number_format($grossprofit): 0.00 ?></div>
                <small>Gross Profit for current Month</small> </div>
              <div class="stats-footer">itemize</div>
              </a> </div>
            
            <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Sales</div>
              <div class="stats-body-alt"> 
               
                <div class="text-center"><span class="text-top">&#8358</span> <?= number_format($totalsales) ?></div>
                <small>Sales for this month</small> </div>
              <div class="stats-footer">go to account</div>
              </a> </div>
            
            
            <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Concentrates</div>
              <div class="stats-body-alt"> 
             
                <div class="text-center"><span class="text-top">&#8358</span> <?= number_format($total) ?></div>
                <small>Current stock value</small> </div>
              <div class="stats-footer">itemize</div>
              </a> </div>
               
               
              <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Customers</div>
              <div class="stats-body-alt"> 
               
                  <div class="text-center"><span class="text-top"></span> <?= count($_SESSION['all_naik_customers']) ?></div>
                <small>All customers</small> </div>
              <div class="stats-footer">view them</div>
              </a> </div>
              <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">HLC 5%</div>
              <div class="stats-body-alt"> 
               
                  <div class="text-center"><span class="text-top"></span> <?= $hlc; ?></div>
                <small>Concentrates</small> </div>
              <div class="stats-footer">view them</div>
              </a> </div>
              <div class="col-md-6 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Raw Material</div>
              <div class="stats-body-alt"> 
             
                <div class="text-center"><span class="text-top">&#8358</span> <?= number_format($rawmaterial) ?></div>
                <small>Raw Materials</small> </div>
              <div class="stats-footer">View them</div>
              </a> </div>
          </div>
            <div class='row'>
                <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Pre-starter</div>
              <div class="stats-body-alt"> 
               
                  <div class="text-center"><span class="text-top"></span> <?= $prestarter ?></div>
                <small>Concentrates</small> </div>
              <div class="stats-footer">view them</div>
              </a> </div>
                <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">HBC 10%</div>
              <div class="stats-body-alt"> 
               
                  <div class="text-center"><span class="text-top"></span> <?= $hbc ?></div>
                <small>Concentrates</small> </div>
              <div class="stats-footer">view them</div>
              </a> </div>
            <div class="col-md-6 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Complete Feed</div>
              <div class="stats-body-alt"> 
             
                <div class="text-center"><span class="text-top">&#8358</span> <?= number_format($completefeed) ?></div>
                <small>Current stock value</small> </div>
              <div class="stats-footer">itemize</div>
              </a> </div>
            </div>
            
            <!-- Complete feed -->
            <div class='row'>
                <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Broiler Starter</div>
              <div class="stats-body-alt"> 
               
                  <div class="text-center"><span class="text-top"></span> <?= $broilerstarter ?></div>
                <small>Complete Feed</small> </div>
              <div class="stats-footer">view them</div>
              </a> </div>
                <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Broiler Finisher</div>
              <div class="stats-body-alt"> 
               
                  <div class="text-center"><span class="text-top"></span> <?= $broilerfinisher ?></div>
                <small>Complete Feed</small> </div>
              <div class="stats-footer">view them</div>
              </a> </div>
            <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Chick Mash</div>
              <div class="stats-body-alt"> 
             
                <div class="text-center"><span class="text-top"></span> <?= $chickmash ?></div>
                <small>Complete Feed</small> </div>
              <div class="stats-footer">View them</div>
              </a> </div>
            <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Growers Mash</div>
              <div class="stats-body-alt"> 
             
                <div class="text-center"><span class="text-top"></span> <?= $growersmash ?></div>
                <small>Complete Feed</small> </div>
              <div class="stats-footer">View them</div>
              </a> </div>
            </div>
            <div class='row'>
                <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Layers Mash</div>
              <div class="stats-body-alt"> 
               
                  <div class="text-center"><span class="text-top"></span> <?= $layersmash ?></div>
                <small>Complete Feed</small> </div>
              <div class="stats-footer">view them</div>
              </a> </div>
                <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">HBC 30%</div>
              <div class="stats-body-alt"> 
               
                  <div class="text-center"><span class="text-top"></span> <?= $hbc30 ?></div>
                <small>Complete Feed</small> </div>
              <div class="stats-footer">view them</div>
              </a> </div>
            <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">HLC 20%</div>
              <div class="stats-body-alt"> 
             
                <div class="text-center"><span class="text-top"></span> <?= $hlc20 ?></div>
                <small>Complete Feed</small> </div>
              <div class="stats-footer">View them</div>
              </a> </div>
            <div class="col-md-3 col-xs-12 col-sm-6"> <a href="#" class="stats-container">
              <div class="stats-heading">Blank</div>
              <div class="stats-body-alt"> 
             
                <div class="text-center"><span class="text-top"></span><?= $blank ?></div>
                <small>Blank</small></div>
              <div class="stats-footer"> view them</div>
              </a> </div>
            </div>
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

