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
        <title>NAIK FEEDS Sales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/thin-admin.css" rel="stylesheet" media="screen">
        <link href="css/font-awesome.css" rel="stylesheet" media="screen">
        <link href="style/style.css" rel="stylesheet">
        <link href="style/dashboard.css" rel="stylesheet">
        <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
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
                                    <h3>SALES AREA REPORT</h3>
                                </div>
                                <div class="widget-content" style="font-size:22px;">
                                    <img src="img/report.png" width="250px" height="150px" align="right" style="margin-right:100px;">
                                    <p style="font-size:22px;">Report Title: Profit By Sales Area Report</p>
                                    <p style="font-size:22px;">Report Date: <?= date("d/m/Y") ?></p>
                                    
<!--                                    <br/><br/>
                                    <form method="post" action=""/>
                                    <p style="font-size:22px;">From: <input type="date" name="from" value="2016-06-01">
                                        
                                        To: <input type="date" value="<?= date('Y-m-d') ?>" name="to"/>&nbsp;&nbsp;<button type="submit" class="btn btn-default">DISPLAY</button>
                                        &nbsp;&nbsp;<button type="button" id="print" class="btn btn-default">PRINT</button></p>
                                    </form>-->
                                </div>
                                <div class="widget">
                                <div class="widget-header"> <i class="icon-arrow-down"></i>
                                    <h3>CLICK ON THE SALES AREA TAB </h3>
                                </div>
                                <div class="widget-content">
                                  <ul class="nav nav-tabs" id="myTab">
                                      <li class="active"><a data-toggle="tab" href="#abuja"><span style="font-size: 22px;">SALES AREA REPORT</span></a></li>
                                  </ul>
                                  <div class="tab-content" id="myTabContent">
                                      <?php // print'<pre>'; print_r($_SESSION['admin_sales']); print '</pre>'; ?>
                                    
                                    <div id="abuja" class="tab-pane fade active in">
                                        <table class="table table-striped table-bordered display" id="abujatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Sales ID</th>
                                                <th>Stock Name</th>
                                                <th class="hidden-xs">Quantity</th>
                                                <th class="hidden-xs">Selling Price</th>
                                                <th class="hidden-xs">Total Price</th>
                                                <th class="hidden-xs">Profit</th>
                                                <th class="hidden-xs">Sales Area</th>
                                                <th class="hidden-xs">Sales Date</th>
                                                <th class="hidden-xs">Month</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" style="text-align:right">Total:</th>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                           <?php
                                           $i = 1;
                                           $month = 'January,February,March,April,May,June,July,August,September,October,November,December';
                                            $m = explode(',',$month);
                                            foreach($_SESSION['admin_sales'] as $k=>$v){
                                                    $date = date('d-m-Y H:i:s', strtotime($v['sales_date']));
                                                    $d =  explode(' ',$date)[0] ;
                                                    $mth = explode('-',$d)[1];
                                                    echo '<tr>';
                                                        echo '<td>'.$i++.'</td>';
                                                        echo '<td>'.$v['sales_doc_no'].'</td>';
                                                        echo '<td>'.$v['stock_name'].'</td>';
                                                        echo '<td>'.$v['quantity'].'</td>';
                                                        echo '<td>'.number_format($v['unit_price']).'</td>';
                                                        echo '<td>'.number_format($v['total_price']).'</td>';
                                                        echo '<td>'.number_format( floatval($v['total_price']) - $v['quantity'] * floatval($v['cost_price']) ).'</td>';
                                                        echo '<td>'.$v['sales_area'].'</td>';
                                                        echo '<td>'.date( 'd-m-Y H:i:s' , strtotime($v['sales_date'])).'</td>';
                                                        echo '<td>'.$m[intval($mth)-1] .'</td>';
                                                    echo '</tr>';
                                                    $abujatotal += floatval($v['total_price']) - $v['quantity'] * floatval($v['cost_price']);
                                               
                                            }
                                           ?>

                                        </tbody>
                                        
                                    </table>
                                    <!--<p style="font-size:22px;text-align: right;">Total Profit: &#8358 <?= number_format($abujatotal) ?></p>-->
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
                
                $('body').on('click','#print',function(){
                    window.print();
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
        <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.12.3.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $.fn.digits = function(){ 
            return this.each(function(){ 
                $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
            })
        }
        $('#abujatable').DataTable({
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
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                // Total over this page
               pageTotal = api
                        .column(6, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                // Update footer
                $(api.column(6).footer()).html(
                         pageTotal 
                        
                        ).digits();
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

