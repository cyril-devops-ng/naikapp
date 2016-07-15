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
        <title>NAIK FEEDS Completed Stock List</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/thin-admin.css" rel="stylesheet" media="screen">
        <link href="css/font-awesome.css" rel="stylesheet" media="screen">
        <link href="style/style.css" rel="stylesheet">
        <link href="style/dashboard.css" rel="stylesheet">
        <link href="css/demo_page.css" rel="stylesheet">
        <link href="css/demo_table.css" rel="stylesheet">
        <!--<link href="assets/jquery-easy-pie-chart/jquery.js-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="../../assets/js/html5shiv.js"></script>
              <script src="../../assets/js/respond.min.js"></script>
            <![endif]-->
        
    </head>
    <body>
        <?php require_once 'detailsmodal.php'; ?>
        <div class="container">
            <?php
            $request_count = 0;
            foreach ($_SESSION['requestlist'] as $k => $v) {
                if ($v['status'] == 'Pending') {
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
                                    <h3>RECEIVED STOCK</h3>
                                </div>
                                <div class="widget-content">
                                    <div class="example_alt_pagination">
                                        <div id="container">
                                            <div class="full_width big"></div> 
                                             <div id="demo">
                                                <table class="table table-striped display" id="example"> 
                                                    <thead>
                                                        <tr style="font-size:20px;"> 
                                                             <th>#</th>  
                                                            <th>Transfer Number</th> 
                                                             <th>Stock Name </th>
                                                            <th class="hidden-xs">Quantity</th>
                                                            <th class="hidden-xs">Movement Date</th>
                                                             <th class="hidden-xs">Movement Status</th>
                                                            <th class="hidden-xs">Movement From</th>
                                                            <th class="hidden-xs">Movement To</th>
                                                            <th class="hidden-xs">Actions</th>
                                                        </tr> 
                                                     </thead> 
                                                    <tbody> 
                                                         <?php    
                                                        $i = 0;
                                                        foreach ($_SESSION['requestlist'] as $k => $v) {
                                                            if ($v['status'] == 'Completed') {
                                                                $img = '<img src="img/complete.png" width="40px" height="30px">&nbsp;';
                                                                $i+=1;
                                                                echo '<tr>';
                                                                echo '<td>' . $i . '</td>';
                                                                echo '<td>' . $v['request_no'] . '</td>';
                                                                echo '<td>' . $v['stock_name'] . '</td>';
                                                                echo '<td>' . $v['quantity'] . '</td>';
                                                                echo '<td>' . date('d-m-Y H:i:s', strtotime($v['request_date'])) . '</td>';
                                                                echo '<td>' . $img . $v['status'] . '</td>';
                                                                echo '<td>' . $v['requester'] . '</td>';
                                                                echo '<td>' . $v['sales_area'] . '</td>';

                                                                if ($v['status'] == 'Pending') {
                                                                    echo '<td class="hidden-xs"><button class="btn btn-sm btn-success approve" id="' . $v['request_no'] . '"> Approve </button>&nbsp;' .
                                                                    '<button data-toggle="button" class="btn btn-sm btn-danger reject" id="' . $v['request_no'] . '"> Reject </button></td>';
                                                                } else {
                                                                    echo '<td class="hidden-xs"><button data-target="#myModal" data-toggle="modal" class="btn btn-sm btn-primary view" id="' . $v['request_no'] . '"> View Details </button>&nbsp;';
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
                var perform = function (request, action) {
                    $.post('myrequestlist', {'requestno': request, 'action': action}, function (msg, stat, xhr) {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                if (JSON.parse($.trim(msg)) === 'success') {
                                    setTimeout(function () {
                                        window.location.href = 'myrequestlist';
                                    }, 2000);
                                }
                            }
                        }
                    });
                };
                $('body').on('click', '.approve', function () {
                    var request = $(this).attr('id');
                    perform(request, 'approve');
                });
                $('body').on('click', '.reject', function () {
                    var request = $(this).attr('id');
                    perform(request, 'reject');
                });
                $('body').on('click', '.view', function () {
                    var salesid = $(this).attr('id');
                    $.post('rejectrequest', {details: true, salesid: salesid}, function (msg, stat, xhr) {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                var requestD = JSON.parse($.trim(msg));
                                $('#requestno').html(salesid);
                                for (var a in requestD) {
                                    $('#' + a).html(requestD[a]);
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
			$(document).ready(function() {
				$('#example').dataTable( {
					"sPaginationType": "full_numbers"
				} );
			} );
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

