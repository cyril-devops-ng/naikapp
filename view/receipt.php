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
        <title>NAIK FEEDS Receipt</title>
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
           <?php require_once 'includes/receptionisttopbar.php'; ?>
        </div>
        <div class="wrapper">
            <div class="left-nav">
                <div id="side-nav">
                    <?php require_once 'includes/receptionistmenu.php'; ?>
                </div>
            </div>
            <div class="page-content" id="receipt">
                <div class="content container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget">
                                <div class="widget-header"> <i class="icon-table"></i>
                                    <h3>NAIK SALES DOCUMENT</h3>
                                </div>
                                <div class="widget-content">
                                    <?php
                                     
                                    $customers = $_SESSION['customers'];
                                    $document = $_SESSION['salesDoc'];
//                                    echo $_SESSION['salesdocno'];
                                    
//                                  print '<pre>'; print_r($document); print '</pre>'; //exit();
                                    foreach ($document as $k => $v) {
                                        if ($v['sales_doc_no'] == $_SESSION['salesdocno']) {
                                            $customer = $v['cust_id'];
                                            $document_date = $v['sales_date'];
                                            foreach ($customers as $c => $d) {
                                                if ($d['cust_id'] == $customer) {
                                                    $customername = $d['cust_name'];
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="widget">
                                                <div class="widget-header"> <i class="icon-align-left"></i>
                                                    <h3>Header Info 1 </h3>
                                                </div>
                                                <div class="widget-content">
                                                    <?php
//                                                        print '<pre>'; print_r($_SESSION['sales_stock']);print'</pre>';
                                                    ?>
                                                    <form method="post" class="form-horizontal">
                                                        <input type="hidden" id="sales_area" value="<?= $_SESSION['user']['sales_area'] ?>"/>
                                                        <fieldset>
                                                            <legend class="section">Sold-to-Party</legend>

                                                            <div class="control-group">
                                                                <div class="col-md-3">
                                                                    <label for="normal-field" class="control-label">Customer Name</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <select id="customernumber" class="form-control" name="customernumber">
                                                                            <?php
                                                                            echo '<option>'.$customername . '</option>';
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="widget">
                                                <div class="widget-header"> <i class="icon-ok-sign"></i>
                                                    <h3> Header Info 2</h3>
                                                </div>
                                                <div class="widget-content">
                                                    <form method="post" class="form-horizontal">
                                                        <fieldset>
                                                            <legend class="section">Date Information</legend>

                                                            <div class="control-group">
                                                                <div class="col-md-3">
                                                                    <label for="normal-field" class="control-label">Document Date</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <input id="documentdate" type="date" name="documentdate" placeholder="" class="form-control" id="documentdate" value="<?= $document_date ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="widget">
                                                <div class="widget-header"> <i class="icon-table"></i>
                                                    <h3>SALES ITEMS</h3>
                                                </div>
                                                <div class="widget-content">
                                                    <div class="body">
                                                        <table class="table table-striped table-images">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Stock Name</th>
                                                                    <th>Quantity</th>
                                                                    <th class="hidden-xs">Selling Price</th>
                                                                    <th class="hidden-xs">Sub total</th>
                                                                    <th class="hidden-xs"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="">
               <?php
                                                                            $a = 0;
                                                                            $i = 1;
                                                                            $list = array();
                                                                            $total = '';
                                                                            
                                                                            foreach ($document as $k => $v) {
                                                                                $remitted_date = 'YYYY-MM-DD';
                                                                               
                                                                                    echo '<tr>';
                                                                                    echo '<td>' . $i++ . '</td>';
                                                                                    echo '<td>' . $v['stock_name'] . '</td>';
                                                                                    echo '<td>' . $v['quantity'] . '</td>';
                                                                                    echo '<td>' . $v['unit_price'] . '</td>';
                                                                                    echo '<td>' . $v['total_price'] . '</td>';
                                                                                    echo '</tr>';
                                                                                    $total += floatval($v['total_price']);
                                                                                            
                                                                            }
                                                                            ?>
                                                            

                                                            </tbody>
                                                        </table>
                                                        <div class="clearfix">
                                                            <div class="pull-right">
                                                                <div class="btn-group">
                                                                    <h3>Total: &#8358; <?php echo  $total; ?></h3>
                                                                </div>
                                                                

                                                            </div>
                                                            <center> <button class="btn btn-success btn-large" id="print" style="width:300px;height:50px;">PRINT</button></center>
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



                </div>
            </div>
        </div>
<?php require_once 'includes/footer.php'; ?> 
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
        <script src="js/jquery.js"></script> 
        <script type="text/javascript">
        <script type="text/javscript" src="http://code.jquery.com/jquery-1.4.1-vsdoc.js"></script>
        <script type="text/javascript">
            Date.prototype.toDateInputValue = (function () {
                var local = new Date(this);
                local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                return local.toJSON().slice(0, 10);
            });
            ;
            (function () {
                var eachLine = $('#tableBody').html();
                var counter = 1;
                $('#documentdate').val(new Date().toDateInputValue());
                $('#addLine').click(function () {
                    counter = 1;
                    $('#tableBody').append(eachLine);
                    $('.firstRow').each(function () {
                        $(this).find('.index').html(counter++);
                    });
                });
                //disable key press on type number
                $('body').on('keypress', "[type='number']", function (evt) {
                    evt.preventDefault();
                });
                $('body').on('click', '.removeBtn', function () {
                    $(this).parent().parent().remove();
                    counter = 1;
                    $('.firstRow').each(function () {
                        $(this).find('.index').html(counter++);
                    });
                });

                $('body').on('change', '.stockName', function () {
                    var selected = this;
                    var cost_price = '';
                    var sell_price = '';
                    var qty = '';
                    $.post('createsales', {stock: $(this).val(), retrieve: 'true'}, function (msg, stat, xhr) {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                var returnVal = JSON.parse($.trim(msg));
                                cost_price = returnVal[0];
                                sell_price = returnVal[1];
                                qty = returnVal[2];
                                $(selected).parent().parent().parent().find('.costPrice').html(cost_price);
                                $(selected).parent().parent().find('.sellPrice').html(sell_price);
                                $(selected).parent().parent().find('input.quantity').attr('max', qty);
                            }
                        }
                    });
                });

                $('#post').click(function () {
                    var customername = $('#customernumber').val();
                    var documentdate = $('#documentdate').val();
                    var salesarea = $('#sales_area').val();
                    var row = '';
                    var cp = '';
                    var sp = '';
                    $('.firstRow').each(function () {
                        var stockName = $(this).find('.stockName').val();
                        var qty = $(this).find('.quantity').val();
                        cp = $(this).find('.costPrice').html();
                        sp = $(this).find('.sellPrice').html();
                        row += stockName + ':' + qty + ':' + cp + ':' + sp + ',';
                    });
                    row = row.substring(0, row.length - 1);
                    var data = {
                        'makesale': true,
                        'customer': customername,
                        'docdate': documentdate,
                        lines: row,
                        sales_area: salesarea,
                    };

                    $.post('receipt', data, function (msg, stat, xhr) {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                if (JSON.parse($.trim(msg)) === 'success') {
                                    window.location.href = 'salessuccess';
                                }
                            }
                        }
                    });
                });
                
                
                $('body').on('click','#print',function(){
//                    $('#receipt').printElement();
                       window.print();
                });
            })();
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

