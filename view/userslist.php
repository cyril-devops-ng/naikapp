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
  <?php 
        $request_count = 0;
        foreach( $_SESSION['requestlist'] as $k=>$v){
            if($v['status'] == 'Pending'){
                ++$request_count;
            }
        }
        require_once 'includes/topbar.php';
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
      <div class="row">
        <div class="col-lg-12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-table"></i>
              <h3>NAIK FEED EMPLOYEES</h3>
            </div>
            <div class="widget-content">
              <div class="body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Fullname</th>
                      <th>Email</th>
                      <th class="hidden-xs">Phone Number</th>
                      <th class="hidden-xs">User Type</th>
                      <th class="hidden-xs">Sales Area</th>
                      <th class="hidden-xs">Monthly Pay</th>
                      <th class="hidden-xs"></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      $totalpay = 0;
                      $i = 0;
                        foreach( $_SESSION['userslist'] as $k=>$v){
                            $i+=1;
                            $pay = floatval(str_replace(',', '', $v['pay']))  ;
                            $totalpay += floatval($pay);
                            echo '<tr>';
                            echo '<td>'.$i.'</td>';
                            echo '<td>'.$v['username'].'</td>';
                            echo '<td>'.$v['fullname'].'</td>';
                            echo '<td>'.$v['email'].'</td>';
                            echo '<td>'.$v['phoneno'].'</td>';
                            echo '<td>'.$v['usertype'].'</td>';
                            echo '<td>'.$v['sales_area'].'</td>';
                            echo '<td>'.$v['pay'].'</td>';
                            echo '<td class="hidden-xs"><button class="btn btn-sm btn-primary editBtn" id="edit#'.$v['username'].'"> Edit </button>&nbsp;'.
                        '<button data-toggle="button" class="btn btn-sm btn-warning deleteBtn" id="del#'.$v['username'].'"> Delete </button></td>';
                        }
                      ?>
                 </tbody>
                </table>
               <p style="font-size:25px;text-align: right;">Total Salary: &#8358 <?= number_format($totalpay) ?></p>
                                     
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?> 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery.js"></script> 
<script type="text/javascript">
    $(document).ready(function(){
        $('.editBtn').click(function(){
            var id = $(this).attr('id').toString().split('#')[1];
            
            $.post('userslist',{'id':id , 'edit':'edit'},function(msg,stat,xhr){
                if(xhr.readyState === 4){
                    if(xhr.status === 200){
                        window.location.href = 'usermanagement';
                    }
                }
            });
        });
        
        $('.deleteBtn').click(function(){
            var delBtn = $(this);
            var id = $(this).attr('id').toString().split('#')[1];
            var y_n = confirm('Are you sure you want to delete?');
            if(y_n){
                $.post('userslist',{'id':id , 'delete':'delete'},function(msg,stat,xhr){
                    if(xhr.readyState === 4){
                        if(xhr.status === 200){
                            delBtn.parent().parent().remove();
                        }
                    }
                });
            }
            
        });
    });
    
</script>
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

