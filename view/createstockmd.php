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
        <title>NAIK FEEDS Create Stock</title>
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
            <?php require_once 'includes/topbar.php'; ?>
        </div>
        <div class="wrapper">
            <div class="left-nav">
                <div id="side-nav">
                    <?php require_once 'includes/menu.php'; 
                        $edit = $_SESSION['edit'];
                    ?>
                </div>
            </div>
            <div class="page-content">
                <div class="content container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget">
                                <div class="widget-header"> <i class="icon-file-alt"></i>
                                    <h3><?= isset($edit) && $edit == true ? "Edit Stock":"Add New Stock" ?></h3>
                                </div>
                                <div class="widget-content">
                                    <div class="panel-body">
                                        <center><img src="img/stock.png" width="250px" height="250px" align="top|left"/><h2><?= isset($edit) && $edit == true ? "Edit Stock":"Add New Stock" ?></h2></center>
                                        <form id="rmform" action="createstockmd" method="post" class="form-horizontal row-border" />
                                        <?php 
//                                            print'<pre>';
//                                            print_r($_SESSION['edit_stock']);
//                                            print'</pre>';
                                        ?>
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Stock Name:</label>
                                            <div class="col-sm-6">
                                                <select class='form-control' name='stock' id='stock' required>
                                                    <option>--Select--</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='Broiler Starter'?'selected':''; ?> >Broiler Starter</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='Broiler Finisher'?'selected':''; ?> >Broiler Finisher</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='Chick Mash'?'selected':''; ?>>Chick Mash</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='Growers Mash'?'selected':''; ?>>Growers Mash</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='Layers Mash'?'selected':''; ?>>Layers Mash</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='HBC 30%'?'selected':''; ?>>HBC 30%</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='HLC 20%'?'selected':''; ?>>HLC 20%</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='HLC 5%'?'selected':''; ?>>HLC 5%</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='HBC 10%'?'selected':''; ?>>HBC 10%</option>
                                                    <option<?php echo $_SESSION['edit_stock'][0]['stock_name']=='PRE-STARTER'?'selected':''; ?> >PRE-STARTER</option>
<!--                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='MAIZE'?'selected':''; ?>>MAIZE</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='MAIZE OFFAL'?'selected':''; ?> >MAIZE OFFAL</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='SOYA MEAL'?'selected':''; ?> >SOYA MEAL</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='WHEAT'?'selected':''; ?> >WHEAT</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='P K C'?'selected':''; ?> >P K C</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='Lime Stone'?'selected':''; ?> >Lime Stone</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='SALT'?'selected':''; ?> >SALT</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='CASSAVA'?'selected':''; ?> >CASSAVA</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='B/S SACKS'?'selected':''; ?> >B/S SACKS</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='B/F SACKS'?'selected':''; ?> >B/F SACKS</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='C/M SACKS'?'selected':''; ?> >C/M SACKS</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='G/M SACKS'?'selected':''; ?> >G/M SACKS</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='L/M SACKS'?'selected':''; ?> >L/M SACKS</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='CONCENTRATE SACKS'?'selected':''; ?> >CONCENTRATE SACKS</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='PETROL'?'selected':''; ?> >PETROL</option>
                                                    <option <?php echo $_SESSION['edit_stock'][0]['stock_name']=='DIESEL'?'selected':''; ?> >DIESEL</option>-->
                                                    
                                                </select>
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Stock Type:</label>
                                            <div class="col-sm-6">
                                                <?php 
                                                  
                                                ?>
                                                <select name="stocktype" class="form-control" id="stocktype" required>
                                                    
                                                    
                                                    <?php
                                                    if(isset($edit) && $edit == true){
                                                        switch($_SESSION['edit_stock'][0]['stock_type']){
                                                            case 'Concentrates':
                                                                echo '<option>--Select--</option>';
                                                                echo '<option value="Concentrates" selected>Concentrates(BAG)</option>';
                                                                echo '<option value="Complete Feed">Complete Feed(BAG)</option>';
//                                                                echo '<option value="Raw Materials">Raw Materials(KG)</option>';
                                                                break;
                                                            case 'Complete Feed':
                                                                echo '<option>--Select--</option>';
                                                                echo '<option value="Concentrates">Concentrates(BAG)</option>';
                                                                echo '<option value="Complete Feed" selected>Complete Feed(BAG)</option>';
//                                                                echo '<option value="Raw Materials" >Raw Materials(KG)</option>';
                                                                break; 
                                                            case 'Raw Materials': 
                                                                echo '<option>--Select--</option>';
                                                                echo '<option value="Concentrates">Concentrates(BAG)</option>';
                                                                echo '<option value="Complete Feed">Complete Feed(BAG)</option>';
//                                                                echo '<option value="Raw Materials" selected>Raw Materials(KG)</option>';
                                                            default:
                                                        }
                                                    }else{
                                                        echo '<option>--Select--</option>';
                                                                echo '<option value="Concentrates">Concentrates(BAG)</option>';
                                                                echo '<option value="Complete Feed">Complete Feed(BAG)</option>';
//                                                                echo '<option value="Raw Materials">Raw Materials(KG)</option>';
                                                    }
                                                        
                                                    ?>
<!--                                                    <option>Concentrates</option>
                                                    <option>Raw Materials</option>
                                                    <option>Complete Feed</option>-->
                                                </select>
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block">Concentrates, Raw Materials or Complete Feed</p>
                                            </div>
                                        </div>
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Quantity:</label>
                                            <div class="col-sm-6">
                                                <input value='<?= $_SESSION['edit_stock'][0]['quantity'] ?>' type="number" min="0" class="form-control" placeholder="Enter Quantity" name="quantity" id="quantity" required />
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
<!--                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Cost Price</label>
                                            <div class="col-sm-6">
                                              <input value='<?= $_SESSION['edit_stock'][0]['cost_price'] ?>' type="text" name="costprice" class="form-control mask" data-inputmask="'mask':'N 999,999,999.99', 'greedy' : false, 'rightAlignNumerics' : false" required/>
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Selling Price</label>
                                            <div class="col-sm-6">
                                                <input id="sellprice" value='<?= $_SESSION['edit_stock'][0]['selling_price'] ?>' type="text" name="sellprice" class="form-control mask" data-inputmask="'mask':'N 999,999,999.99', 'greedy' : false, 'rightAlignNumerics' : false" />
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>-->
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Upload Date</label>
                                            <div class="col-sm-6">
                                                <input id="upload_date" value='<?= $_SESSION['edit_stock'][0]['upload_date'] ?>' type="date" name="upload_date" class="form-control mask" data-inputmask="'mask':'N 999,999,999.99', 'greedy' : false, 'rightAlignNumerics' : false" required/>
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                         
                                        
                                        <div class="form-actions">
                                            <div>
                                                <button id="addUserBtn" class="btn btn-primary" type="submit"><?= isset($edit) && $edit == true ? "Save":"Add Stock" ?></button>
                                                <img class="preloader" src="img/preload.gif" width="30px" height="25px">    
<!--                                                <button id="clearBtn" class="btn btn-default" type="button">Clear</button>-->
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
                $('.preloader').hide();
                $('#rmform').submit(function(){
                    if($('#stock').val().indexOf('Select') > -1 || $('#stocktype').val().indexOf('Select') > -1  ){
                        alert('Some Fields have not been selected!');
                        return false;
                    }else{
                        $('#addUserBtn').prop('disabled',true);
                        $('.preloader').show();
                    }
                    
                });
                
                $('#stocktype').change(function(){
                    if($(this).val() == 'Raw Materials'){
                        $('#sellprice').val('0');
                        $('#sellprice').prop('disabled',true);
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

