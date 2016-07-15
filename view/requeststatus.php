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
        <title>NAIK FEEDS Movement Status</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/thin-admin.css" rel="stylesheet" media="screen">
        <link href="css/font-awesome.css" rel="stylesheet" media="screen">
        <link href="style/style.css" rel="stylesheet">
        <link href="style/dashboard.css" rel="stylesheet">
        <link href="css/demo_page.css" rel="stylesheet">
        <link href="css/demo_table.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="../../assets/js/html5shiv.js"></script>
              <script src="../../assets/js/respond.min.js"></script>
            <![endif]-->

    </head>
    <body>
        <?php require_once 'detailsmodal.php'; ?>
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
                                <div class="widget-header"> <i class="icon-table"></i>
                                    <h3>MOVEMENT STATUS</h3>
                                </div>
                                <div class="widget-content">
                                    <div class="body">
                                        <?php // print'<pre>'; print_r($_SESSION['factoryrequest']); print '</pre>'; ?>
                                        <div class="example_alt_pagination">
                                            <div id="container">
                                                <div class="full_width big"></div> 
                                                <div id="demo">
                                        <table class="table table-striped display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Stock Name</th>
                                                    <th>Quantity </th>
                                                    <th>Transfer Number</th>
                                                    <th>Sales Area</th>
                                                    <!--<th class="hidden-xs">Cost Price</th>-->
                                                    <th class="hidden-xs">Movement Date</th>
                                                    <th class="hidden-xs">Month</th>
                                                    <th class="hidden-xs">Status</th>
                                                    <th class="hidden-xs">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php
                                                rsort($_SESSION['factoryrequest']);
                                                $i = 0;
                                                $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                                                $m = explode(',',$month);
                                                foreach ($_SESSION['factoryrequest'] as $k => $v) {
                                                    if($v['status'] == 'Rejected'){
                                                        $img = '<img src="img/rejected.png" width="30px" height="5px">&nbsp;';
                                                    }
                                                    if($v['status'] == 'Pending'){
                                                        $img = '<img src="img/pending.png" width="30px" height="5px">&nbsp;';
                                                    }
                                                    if($v['status'] == 'Approved'){
                                                        $img = '<img src="img/approved.png" width="30px" height="5px">&nbsp;';
                                                    }
                                                    if($v['status'] == 'In Transit'){
                                                        $img = '<img src="img/transit.png" width="30px" height="5px">&nbsp;';
                                                    }
                                                    if($v['status'] == 'Completed'){
                                                        $img = '<img src="img/complete.png" width="30px" height="5px">&nbsp;';
                                                    }
                                                    $i+=1;
                                                    $date = date('d-m-Y H:i:s', strtotime($v['request_date']));
                                                    $d =  explode(' ',$date)[0] ;
                                                    $mth = explode('-',$d)[1];
                                                    echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    echo '<td>' . $v['stock_name'] . '</td>';
                                                    echo '<td>' . $v['quantity'] . '</td>';
                                                    echo '<td>' . $v['request_no'] . '</td>';
                                                    echo '<td>' . $v['sales_area'] . '</td>';
                                                    echo '<td>' . date('d-m-Y H:i:s' , strtotime($v['request_date']))  . '</td>';
                                                    echo '<td>'. $m[intval($mth) - 1].'</td>';
                                                    echo '<td>' .  $v['status'] . '</td>';
                                                    echo '<td class="hidden-xs"><button id="'.$v['request_no'].'" data-target="#myModal" data-toggle="modal" class="btn btn-sm btn-primary view"> View Details </button>&nbsp;';
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                                </div></div></div>
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
                $('body').on('click', '.view', function () {
                   var requestno = $(this).attr('id');
                    $.post('requeststatus',{_req:requestno,'_fetch':true},function(msg,stat,xhr){
                        if(xhr.readyState === 4){
                            if(xhr.status === 200){
                                var requestD = JSON.parse($.trim(msg));
                                $('#requestno').html(requestno);
                                for(var a in requestD){
                                    $('#'+a).html(requestD[a]);
                                }
                            }
                        }
                    });
                });
                $('body').on('click', '.process', function () {
                    var request = $(this).attr('id');
                    $.post('processrequest',{'request':request},function(msg,stat,xhr){
                        if(xhr.readyState === 4){
                            if(xhr.status === 200){
                                if(JSON.parse($.trim(msg)) === 'success'){
                                    setTimeout(function(){
                                        window.location.href = 'processrequest';
                                    },2000);
                                }
                            }
                        }
                    });
                });
            });

        </script>
        <script src="js/bootstrap.min.js"></script> 
        <script type="text/javascript" src="js/smooth-sliding-menu.js"></script> 
        <script class="include" type="text/javascript" src="javascript/jquery191.min.js"></script> 
        <script class="include" type="text/javascript" src="javascript/jquery.jqplot.min.js"></script> 
        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                $('#example').dataTable({
                    "sPaginationType": "full_numbers"
                });
            });
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

