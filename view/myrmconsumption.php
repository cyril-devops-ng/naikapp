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
        <title>NAIK FEEDS Raw Material Consumption</title>
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
                                    <h3>My Raw Material Consumption List</h3>
                                </div>
                                <div class="widget-content">
                                    <div class="body">
                                        <div class="example_alt_pagination">
                                            <div id="container">
                                                <div class="full_width big"></div> 
                                                <div id="demo">
                                                    <table class="table table-striped table-bordered display" id="example">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Stock Name</th>
                                                                        <th>In(Kg)</th>
                                                                        <th>Value/Kg</th>
                                                                        <th class="hidden-xs">Total Value</th>
                                                                        <th class="hidden-xs">Out(Kg)</th>
                                                                        <th class="hidden-xs">Value/(Kg)</th>
                                                                        <th class="hidden-xs">Total Value</th>
                                                                        <th class="hidden-xs">Date Time</th>
                                                                        <th class="hidden-xs">Month</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th colspan="2" style="text-align:right">Total:</th>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                                                                    $mmmm = explode(',', $month);
//                                            print '<pre>';print_r($_SESSION); print '</pre>';
                                                                    foreach ($_SESSION['myraw_materials'] as $k => $v) {
                                                                        $date = date('d-m-Y H:i:s', strtotime($v['movement_date']));
                                                                        $d = explode(' ', $date)[0];
                                                                        $mth = explode('-', $d)[1];
                                                                        foreach ($_SESSION['rm_value'] as $a => $b) {
                                                                            if ($v['stock_name'] == $b['stock_name']) {
                                                                                $unitprice = $b['cost_price'];
                                                                            }
                                                                        }
                                                                        echo '<tr>';
                                                                        echo '<td>' . $i++ . '</td>';
                                                                        echo '<td>' . $v['stock_name'] . '</td>';
                                                                        echo '<td>' . ($v['movement_type'] == 'IN' ? $v['quantity'] : 0) . '</td>';
                                                                        echo '<td>' . ($v['movement_type'] == 'IN' ? $unitprice : 0) . '</td>';
                                                                        echo '<td>' . ($v['movement_type'] == 'IN' ? floatval($v['quantity']) * $unitprice : 0) . '</td>';
                                                                        echo '<td>' . ($v['movement_type'] == 'OUT' ? $v['quantity'] : 0) . '</td>';
                                                                        echo '<td>' . ($v['movement_type'] == 'OUT' ? $unitprice : 0) . '</td>';
                                                                        echo '<td>' . ($v['movement_type'] == 'OUT' ? floatval($v['quantity']) * $unitprice : 0) . '</td>';
                                                                        echo '<td>' . date('d-m-Y H:i:s', strtotime($v['movement_date'])) . '</td>';
                                                                        echo '<td>' . $mmmm[intval($mth) - 1] . '</td>';
                                                                        echo '</tr>';
                                                                    }
                                                                    ?>

                                                                </tbody>

                                                            </table>
                                                </div> </div></div>

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
                $('body').on('click', '.delete', function () {
                    var stock = $(this).attr('id');
                    var selected = this;
                    var c = confirm("Are you sure you want to delete?")
                    if (c) {

                        $.post('viewstock', {pleasedelete: true, stock: stock}, function (msg, stat, xhr) {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    $(selected).parent().parent().remove();
                                }
                            }
                        });
                    }

                });

                $('body').on('click', '.edit', function () {
                    var stock = $(this).attr('id');
                    $.post('viewstock', {editstock: stock}, function (msg, stat, xhr) {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                window.location.href = 'createstock';
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
       <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.12.3.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                $('#example').DataTable({
//            "sPaginationType": "full_numbers",
                    "footerCallback": function (row, data, start, end, display) {
//                alert('hello');
                        var api = this.api();

                        // Remove the formatting to get integer data for summation
                        var intVal = function (i) {
                            return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                    i : 0;
                        };

                        // Total over all pages
                        total = api
                                .column(7)
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                        // Total over this page
                        pageTotal = api
                                .column(7, {page: 'current'})
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                        pageTotal2 = api
                                .column(6, {page: 'current'})
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                        pageTotal3 = api
                                .column(5, {page: 'current'})
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                        pageTotal4 = api
                                .column(4, {page: 'current'})
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                        pageTotal5 = api
                                .column(3, {page: 'current'})
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                        pageTotal6 = api
                                .column(2, {page: 'current'})
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                        // Update footer
                        $(api.column(7).footer()).html(
                                pageTotal

                                );
                        $(api.column(6).footer()).html(
                                pageTotal2

                                );$(api.column(6).footer()).html(
                                pageTotal2

                                );
                        $(api.column(5).footer()).html(
                                pageTotal3

                                );
                        $(api.column(4).footer()).html(
                                pageTotal4

                                );
                        $(api.column(3).footer()).html(
                                pageTotal5

                                );
                        $(api.column(2).footer()).html(
                                pageTotal6

                                );
                    }

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

