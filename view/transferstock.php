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
        <title>NAIK FEEDS Transfer Stock</title>
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
            <?php require_once 'includes/factoryusertopbar.php'; ?>
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
                            <div class="widget">
                                <div class="widget-header"> <i class="icon-file-alt"></i>
                                    <h3>Stock Transfer</h3>
                                </div>
                                <div class="widget-content">
                                    <div class="panel-body">
                                        <center><img src="img/truck.png" width="250px" height="250px" align="top|left"/><h2>Routine Transfer</h2></center>
                                        <form id="transferForm" action="transferstock" method="post" class="form-horizontal row-border" />
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Stock Name:</label>
                                            <div class="col-sm-6">
                                               <select name="stockname" class="form-control" id="stockname">
                                                   <option>--Select Stock--</option> 
                                                   <?php
                                                        foreach($_SESSION['transferstock'] as $k=>$v){
                                                            echo '<option>'.$v['stock_name'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Quantity:</label>
                                            <div class="col-sm-6">
                                                <input type="number" min="0" value="0" class="form-control" placeholder="1" name="quantity" id="quantity" required />
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Movement Date:</label>
                                            <div class="col-sm-6">
                                                <input type="date"  class="form-control"  name="date" id="quantity" required />
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Sales Area:</label>
                                            <div class="col-sm-6">
                                               <select name="salesarea" class="form-control" id="salesarea">
                                                    <option>--Select Sales Area--</option>
                                                    <option>Abuja</option>
                                                    <option>Lagos</option>
                                                    <option>Jos</option>
                                                </select>
                                            
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                         
                                        
                                        <div class="form-actions">
                                            <div>
                                                <button id="addUserBtn" class="btn btn-primary" type="submit">Transfer</button>
                                                <button id="clearBtn" class="btn btn-default" type="button">Clear</button>
                                            </div>
                                        </div>
                                        </form>
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
            $(document).ready(function () {
                $('#clearBtn').click(function () {
                    $('#fullname').val('');
                    $('#username').val('');
                    $('#password').val('');
                    $('#confirmpassword').val('');
                    $('#phoneno').val('');
                    $('#usertype').val('');
                    $('#email').val('');
                });
                
                $('form#transferForm').submit(function(){
                    var stockname = $('#stockname').val();
                    var salesarea = $('#salesarea').val();
                    var errormsg  = 'Error\n';
                    var error = 0;
                    if(stockname.indexOf('Select')>=0){
                        errormsg += '**Select a stock';
                        error += 1;
                    }
                    if(salesarea.indexOf('Select')>=0){
                        errormsg += '\n**Specify the Sales Area';
                        error += 1;
                    }
                    if(error > 0){
                        alert(errormsg);
                        return false;
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
        <script type='text/javascript' src='assets/plugins/form-inputmask/jquery.inputmask.min.js'></script> 
        <script type='text/javascript' src='assets/js/demo-mask.js'></script> 
        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
        <!-- polyfiller file to detect and load polyfills -->
        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
        <script>
          webshims.setOptions('waitReady', false);
          webshims.setOptions('forms-ext', {types: 'date'});
          webshims.polyfill('forms forms-ext');
        </script>
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

