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
        <title>NAIK FEEDS Add Expense</title>
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
                    <?php
                       $e_id = $_SESSION['edit_expense'];
                        foreach($_SESSION['expenses_in'] as $k=>$v){
                            if($v['id'] == $e_id){
                                $selectexpense = $v;
                            }

                        }
                    ?>
                </div>
            </div>
            <div class="page-content">
                <div class="content container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget">
                                <div class="widget-header"> <i class="icon-file-alt"></i>
                                    <h3><?= isset($_SESSION['editexp'])&&$_SESSION['editexp']== true?'EDIT EXPENSE':'ADD EXPENSE' ?></h3>
                                </div>
                                <div class="widget-content" >
                                    
                                    <div class="panel-body" >
                                        <center><img src="img/expense.png" width="250px" height="250px" align="top|left"/><h2><?= isset($_SESSION['editexp'])&&$_SESSION['editexp']== true?'Edit an Expense':'Add an Expense' ?></h2></center>
                                        <form id="expenseForm" action="addexpense" method="post" class="form-horizontal row-border" />
                                        <input type="hidden" id="descr" name="descr" value='<?= $selectexpense['description'] ?>'/>
                                        <div class="form-group lable-padd">
                                            <?php
                                                
                                            ?>
                                            <label class="col-sm-3">Description:</label>
                                            <div class="col-sm-6">
                                                <select id="description" class="form-control" name="description">
                                                    <option class='item'>--Select--</option>
                                                    <option  class='item'> Big Generator Maintenance</option>
                                                    <option  class='item'>Mercedes Maintenance</option>
                                                    <option  class='item'>BUS JJN Renewal Paper</option>
                                                    <option  class='item'>Mercedes Maintenance</option>
                                                    <option  class='item'>Fork Lift Maintenance</option>
                                                    <option  class='item'>BUS BUU Fuel</option>
                                                    <option  class='item'>BUS BUU Maintenance</option>
                                                    <option  class='item'>Mgr. Phone cards</option>
                                                    <option  class='item'>First Aid</option>
                                                    <option  class='item'>Stationaries</option>
                                                    <option  class='item'>Machine Maintenance</option>
                                                    <option  class='item'>External Labor</option>
                                                    <option  class='item'>Staff Canteen</option>
                                                    <option  class='item'>Sewing Machine Maintainance</option>
                                                    <option  class='item'>Data Subscription (modem)</option>
                                                    <option  class='item'>fan belt ( 6) p.s</option>
                                                    <option  class='item'>Scel maintainace</option>
                                                    <option  class='item'>Mr Chidi airtime</option>
                                                    <option  class='item'>Mr Chidi transport</option>
                                                    <option  class='item'>Package to Abuja </option>
                                                    <option  class='item'>Package to Kano</option>
                                                    <option  class='item'>Data Subscription for Agwom</option>
                                                    <option  class='item'>--Others--</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                        <div class="form-group lable-padd" id="otherExpense" >
                                           <label class="col-sm-3">Other Expense:</label>
                                            <div class="col-sm-6">
                                               
                                                <input type="text" class="form-control" placeholder="" name="expense" />
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block">Other Expense</p>
                                            </div> 
                                        </div>
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Amount:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="" name="amount" id="amount" value='<?= $selectexpense['expense_amount']?>' required/>
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block">60,000</p>
                                            </div>
                                        </div>
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Date:</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" placeholder="" name="date" id="date" value='<?= $selectexpense['date']?>'required/>
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block">22/06/2016</p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="expense_id" value="<?= $e_id ?>"/>
                                        <?php print_r($selectexpense); ?>
                                        <div class="form-group lable-padd">
                                            <label class="col-sm-3">Expense for :</label>
                                            <div class="col-sm-6">
                                                
                                            <select id="salesarea" class="form-control" name="salesarea">
                                             <?php
                                                switch($selectexpense['sales_area']){
                                                    case 'Abuja':
                                                        echo '<option>--Select--</option>'.
                                                            '<option selected>Abuja</option>'.
                                                            '<option>Lagos</option>'.
                                                            '<option>Jos</option>';
                                                        break;
                                                    case 'Lagos':
                                                            echo '<option>--Select--</option>'.
                                                            '<option >Abuja</option>'.
                                                            '<option selected>Lagos</option>'.
                                                            '<option>Jos</option>';
                                                        break;
                                                            
                                                    case 'Jos':
                                                            echo '<option>--Select--</option>'.
                                                            '<option >Abuja</option>'.
                                                            '<option>Lagos</option>'.
                                                            '<option selected>Jos</option>';
                                                    default:
                                                            echo '<option selected>--Select--</option>'.
                                                            '<option >Abuja</option>'.
                                                            '<option>Lagos</option>'.
                                                            '<option>Jos</option>';
                                                }
                                            ?>
                                            </select>
                                            </div>
                                            <div class="col-sm-3 left-align">
                                                <p class="help-block">Abuja</p>
                                            </div>
                                        </div>
                                        
                                        <div class="form-actions">
                                            <div>
                                                <button id="addUserBtn" class="btn btn-primary" type="submit">Save</button>
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

        <div class="bottom-nav footer"> 2016 &copy; Powered By Sleek Konsult. </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
        <script src="js/jquery.js"></script> 
        <script type="text/javascript">
            $(document).ready(function () {
                $('#otherExpense').hide();
                $('#clearBtn').click(function () {
                    $('#fullname').val('');
                    $('#username').val('');
                    $('#password').val('');
                    $('#confirmpassword').val('');
                    $('#phoneno').val('');
                    $('#usertype').val('');
                    $('#email').val('');
                });
                
                $('#description').change(function(){
                    if($(this).val() === '--Others--'){
                        $('#otherExpense').slideDown('slow');
                    }else{
                        $('#otherExpense').slideUp('slow');
                    }
                });
                
                $('form#expenseForm').submit(function(){
                    var desc = $('#description').val();
                    if(desc.indexOf('Add an Expense')>=0){
                        alert('Choose an Expense');
                        return false;
                    }
                    
                    var salesarea = $('#salesarea').val();
                    if(salesarea.indexOf('Select')>=0){
                        alert('Select a Sales Area');return false;
                    }
                });
                
                $('.item').each(function(){
                    var itemsel = $('#descr').val();
                    if($(this).val() == itemsel){
                        $(this).attr('selected','');
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

