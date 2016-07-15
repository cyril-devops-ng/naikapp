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
        <title>NAIK FEEDS Produced Stock</title>
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
                                    <h3>STOCK - PRODUCED STOCK</h3>
                                </div>
                                <div class="widget-content">
                                    <div class="example_alt_pagination">
                                        <div id="container">
                                            <div class="full_width big"></div> 
                                            <div id="demo">
                                                <table class="table table-striped table-images dispay" id="example">
                                                    <thead>
                                                        <tr style="font-size:20px;">
                                                            <th>#</th>
                                                            <th>Stock Name</th>
                                                            <th>Stock Type</th>
                                                            <th class="hidden-xs">Quantity</th>
                                                            <th class="hidden-xs">Cost Price</th>
                                                            <th class="hidden-xs">Selling Price</th>
                                                            <th class="hidden-xs">Sales Area</th>
                                                            <th class="hidden-xs">Upload Date</th>
                                                            <th class="hidden-xs">Month</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tableBody">
                                                        <?php

                                                        function startsWith($haystack, $needle) {
                                                            // search backwards starting from haystack length characters from the end
                                                            return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
                                                        }

//                                            print '<pre>';print_r($_SESSION); print '</pre>';
                                                        $i = 1;
                                                        $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                                                        $m = explode(',', $month);
                                                        foreach ($_SESSION['producedadmin'] as $k => $v) {
                                                            if (startsWith($v['sales_area'], 'Factory')) {
                                                                if ($v['cost_price'] == '') {
                                                                    $v['cost_price'] = 0;
                                                                }
                                                                if ($v['selling_price'] == '') {
                                                                    $v['selling_price'] = 0;
                                                                }
                                                                $date = date('d-m-Y H:i:s', strtotime($v['sales_date']));
                                                                $d = explode(' ', $date)[0];
                                                                $mth = explode('-', $d)[1];
                                                                echo '<tr>' .
                                                                '<td>' . $i++ . '</td>' .
                                                                '<td>' . $v['stock_name'] . '</td>' .
                                                                '<td>' . $v['stock_type'] . '</td>' .
                                                                '<td class="hidden-xs">' . $v['quantity'] . '</td>' .
                                                                '<td class="hidden-xs">' . number_format($v['cost_price']) . '</td>' .
                                                                '<td class="hidden-xs">' . number_format($v['selling_price']) . '</td>' .
                                                                '<td class="hidden-xs">' . $v['sales_area'] . '</td>' .
                                                                '<td class="hidden-xs">' . date('d-m-Y H:i:s', strtotime($v['upload_date'])) . '</td>' .
                                                                '<td class="hidden-xs">' . $m[intval($mth) - 1] . '</td>' .
                                                                '</tr>';
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



    </body

