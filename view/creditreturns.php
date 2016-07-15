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
        <title>NAIK FEEDS CREDIT RETURNS</title>
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
        <?php require_once 'creditdetailsmodal.php'; ?>
        <div class="container">
            <?php
                require_once 'includes/itmanagertopbar.php';
            ?>

        </div>
        <div class="wrapper">
            <div class="left-nav">
                <div id="side-nav">
                    <?php require_once 'includes/itmanagermenu.php'; ?>
                </div>
            </div>
            <div class="page-content">
                <div class="content container">
                     <?php 
                        $allsorted = array();
                        rsort($_SESSION['previous_balance']);
                        $bal = array();
                        
                        $previousBal = $_SESSION['previous_balance'][0];
                        $lastDate = $previousBal['remit_date'];
                        $total = 0;
                        foreach($_SESSION['previous_balance'] as $a=>$b){
                            if( $b['remit_date'] == $lastDate ){
                                array_push($bal, array( $b['stock_name']=> $b['quantity'] ));
                                $total += intval($b['quantity']);
                            }
//                            else{
//                                $lastDate = $b['remit_date'];
//                                array_push($allsorted, array($b['sales_id']=>$bal));
//                                $bal = array();
//                                array_push($bal, array( $b['stock_name']=> $b['quantity'] ));
//                            }
                        }
                        
                        $salesdoc = array();
                        $mostrecentdate = array();
                        $totalquantity = array();
                        $complete = array();
                        rsort($_SESSION['previous']);
                        $total = 0;
                        foreach($_SESSION['previous'] as $a=>$b){
                            if( !in_array($b['sales_id'], $salesdoc)){
                                array_push($salesdoc, $b['sales_id']);
                           }
                        }
                        
                        foreach($_SESSION['previous'] as $a=>$b){
                            for($l=0;$l<count($salesdoc);$l++){
                                if( $b['sales_id'] == $salesdoc[$l] && $b['sales_id'] != $salesdoc[count($mostrecentdate) -1]){
                                   array_push($mostrecentdate,$b['remit_date']); 
                                }
                            }
                        }
                        
                        $in = array();
                        foreach($_SESSION['previous'] as $a=>$b){
                            
                            for($l=0;$l<count($mostrecentdate);$l++){
                                
                            }
                        }
                        
                        function checkBalance($salesid){
                            //print'<pre>'; print_r($_SESSION['previous']); print'</pre>';
                            $connect = mysqli_connect('localhost', 'riffwork_admin', 'admin@1234', 'riffwork_naikfeeds');
                            
                            $query = mysqli_query($connect, 'select * from `cash_returns` where `sales_id` = "'.$salesid.'" ');
                            $query1 = mysqli_query($connect,'select remit_date from `cash_returns` where `sales_id`="'.$salesid.'" order by remit_date desc limit 1');
                            $recent = mysqli_fetch_row($query1 )[0];
                            $query2 = mysqli_query($connect, 'select sum(quantity) from `cash_returns` where `sales_id` = "'.$salesid.'"  and remit_date = "'.$recent.'"');
                            $balance = mysqli_fetch_row($query2 )[0];
//                            print_r($balance.'<br/>');
                            return $balance;
                        }
                        
                        function checkPrevious($salesid){
                             $connect = mysqli_connect('localhost', 'riffwork_admin', 'admin@1234', 'riffwork_naikfeeds');
                            
                            $query = mysqli_query($connect, 'select * from `cash_returns` where `sales_id` = "'.$salesid.'" ');
                            $query1 = mysqli_query($connect,'select remit_date from `cash_returns` where `sales_id`="'.$salesid.'" order by remit_date desc limit 1');
                            $recent = mysqli_fetch_row($query1 )[0];
                            $query2 = mysqli_query($connect, 'select quantity from `cash_returns` where `sales_id` = "'.$salesid.'"  and remit_date = "'.$recent.'"');
                            $previousqty = array();
                            while( $result = mysqli_fetch_row($query2 )){
                                array_push($previousqty,$result[0]);
                            }
                            return $previousqty;
                        }
//                        $salesid = '601076';
//                        checkBalance($salesid);
//                      
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget">
                                <div class="widget-header"> <i class="icon-table"></i>
                                    <h3>CASH PICKUP</h3>
                                </div>
                                <div class="widget-content">
                                    <?php 
                                    //credit_sales_return
                                    ?>
                                    <div class="example_alt_pagination">
                                            <div id="container">
                                                <div class="full_width big"></div> 
                                                <div id="demo">
                                    <table class="table table-striped table-images display" id="example">
                                        <thead>
                                            <tr style="font-size:19px;font-weight: bold;">
                                                <th>#</th>
                                                <th>Sales Document Number</th>
                                                <th>Depot</th>
                                                <th class="hidden-xs">Sales Area</th>
                                                <th class="hidden-xs">Last Remitted Date</th>
                                                <th class="hidden-xs">Status</th>
                                                <th class="hidden-xs"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 1;
                                                $list = array();
                                                $remitted_date = '';
                                                $customer = '';
                                                
                                                //my credit sales
                                                foreach( $_SESSION['credits'] as $k=>$v){
                                                    $remitted_date = 'YYYY-MM-DD';
                                                    foreach( $_SESSION['s_customers'] as $a=>$b){
                                                        if($b['cust_id'] == $v['cust_id']){
                                                            $customer = $b['cust_name']; 
                                                        }
                                                    }
                                                    
//                                                    print'<pre>';print_r($_SESSION['creditreturns']);print'</pre>';
                                                    foreach($_SESSION['creditreturns'] as $c=>$d){
                                                        if($d['sales_id'] == $v['sales_doc_no']){
                                                            $remitted_date = $d['remit_date'];
                                                        }
                                                    }
                                                    
//                                                    print $remitted_date;
                                                    if(!in_array($v['sales_doc_no'], $list)){
//                                                        print($v['sales_doc_no'].'<br/>');
                                                        $remitted_date =  $remitted_date != 'YYYY-MM-DD'?date( 'd-m-Y H:i:s', strtotime($remitted_date)):'';
                                                        $_check = checkBalance($v['sales_doc_no']);
                                                        $prv = checkPrevious($v['sales_doc_no']);
                                                        $_ = '';
                                                        echo '<tr>';
                                                        echo '<td>'.$i++.'</td>';
                                                        echo '<td>'.$v['sales_doc_no'].'</td>';
                                                        echo '<td class="customer">'.$customer.'</td>';
                                                        echo '<td>'.$v['sales_area'].'</td>';
                                                        echo '<td>'.  $remitted_date.'</td>';
                                                        echo $_check == '0' ? '<td>Completed</td>':
                                                                '<td>Not Completed</td>';
                                                        echo $_check =='0' ? '<td><button class="btn btn-danger complete" id="'.$v['sales_doc_no'].'">COMPLETED</button>':'<td><button class="btn btn-success remit" id="'.$v['sales_doc_no'].'">REMIT</button>';
                                                        echo '&nbsp;&nbsp;<button data-target="#myModal" data-toggle="modal" class="btn btn-primary details" id="'.$v['sales_doc_no'].'">DETAILS</button></td>';
                                                        echo '</tr>';
                                                    }
                                                    array_push($list, $v['sales_doc_no']);
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
        <?php require_once 'includes/footer.php'; ?> 

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
        <script src="js/jquery.js"></script> 
        <script type="text/javascript">
            $(document).ready(function () {
                var getPrevious = function(stockName , quantity){
                    return 0;
                };
                var contains = function(needle) {
                    // Per spec, the way to identify NaN is that it is not equal to itself
                    var findNaN = needle !== needle;
                    var indexOf;

                    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
                        indexOf = Array.prototype.indexOf;
                    } else {
                        indexOf = function(needle) {
                            var i = -1, index = -1;

                            for(i = 0; i < this.length; i++) {
                                var item = this[i];

                                if((findNaN && item !== item) || item === needle) {
                                    index = i;
                                    break;
                                }
                            }

                            return index;
                        };
                    }

                    return indexOf.call(this, needle) > -1;
                };


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
                $('body').on('click', '.details', function () {
                    var salesid = $(this).attr('id');
                    var customer = $(this).parent().parent().find('.customer').html();
                    $('#outlet_name').html(customer);
                    $.post('creditreturns',{s_doc:salesid , 'returns':'returns'},function(msg,stat,xhr){
                        if(xhr.readyState === 4){
                            if(xhr.status === 200){
                                    var res = JSON.parse($.trim(msg));
                                    window.localStorage.setItem('res',res);
                                    var entry = [];
                                    var row = '';
                                    var qty = [];
                                    var stock = [];
                                    var sold = 0;
                                    $('#modalInfo').html('');
                                    
                                    for( var i=0;i<res.length;i++){
                                        sold =  Math.abs( parseInt(res[i]['current_balance']) - parseInt(res[i]['quantity']) );
                                       if( contains.call(entry,res[i]['remit_date'])){
                                           row += '<tr>';
                                            row += '<td></td><td>'+res[i]['stock_name']+'</td><td>'+res[i]['shipped']+'</td><td>'+res[i]['current_balance']+'</td><td>'+res[i]['quantity']+'</td><td>'+sold+'</td><td>&#8358;'+( sold * parseFloat(res[i]['amount']))+'</td>';
                                            row += '</tr>';
                                            if( i < res.length-1 && res[i]['remit_date'] === res[i+1]['remit_date'] ){
                                            }else{
                                                row += '</table>';
                                            }
                                        }else{
                                            stock.push(res[i]['stock_name']);
                                            qty.push(res[i]['quantity']);
                                            row += '<p><center>'+ res[i]['remit_date'] +'</center></p>';
                                            row += '<table class="table table-bordered table-striped">';
                                            row += '<tr>';
                                            row += '<th>Sales ID</th><th>Stock Items</th><th>Shipped</th><th>Previous Balance</th><th>Balance</th><th>Sold</th><th>Value Sold</th>';
                                            row += '</tr>';
                                            row += '<tr>';
                                            row += '<td>'+res[i]['sales_id']+'</td><td>'+res[i]['stock_name']+'</td><td>'+res[i]['shipped']+'</td><td>'+res[i]['current_balance']+'</td><td>'+res[i]['quantity']+'</td><td>'+sold+'</td><td>&#8358;'+ (sold * parseFloat(res[i]['amount']) )+'</td>';
                                            row += '</tr>';
                                            entry.push(res[i]['remit_date']);
                                            
                                         }
                                    }
                                    $('#modalInfo').append(row);
                                     
                            }
                        }
                    });
                });
                
                $('body').on('click','.remit',function(){
                    var salesid = $(this).attr('id');
                    $.post('creditreturns',{sales_doc:salesid},function(msg,stat,xhr){
                        if(xhr.readyState === 4){
                            if(xhr.status === 200){
                                window.location.href = 'creditremit';
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

