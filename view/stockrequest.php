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
        <title>NAIK FEEDS Stock Request</title>
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
            <div class="page-content">
                <div class="content container">
                    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Delivery Details</h3>
                        </div>
                        <div class="modal-body">
                            <div>

                            </div>
                            <center>
                                <br/>NAIK FEEDS<br/>
                                <div id="requestdetails">

                                </div>
                            </center>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget">
                                <div class="widget-header"> <i class="icon-table"></i>
                                    <h3>NAIK STOCK REQUEST FORM</h3>
                                </div>
                                <input type="hidden" id="sales_area" value="<?php echo $_SESSION['user']['sales_area']; ?>"/>
                                <input type="hidden" id="requester" value="<?php echo $_SESSION['user']['username']; ?>"/>
                                <div class="widget-content">
                                    <?php // print'<pre>';print_r($_SESSION['request_stock']); print'</pre>'; ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="widget">
                                                <div class="widget-header"> <i class="icon-align-left"></i>
                                                    <h3>Stock</h3>
                                                </div>
                                                <div class="widget-content">
                                                    <div class="alert alert-info fade in">
                                                    <button type="button" class="close close-sm" data-dismiss="alert"> <i class="icon-remove"></i> </button>
                                                    <strong>Heads up!</strong> 
                                                        Choose a stock and enter the quantity you need, then add to the Request cart by the right.
                                                        Once your list is completed, click on submit request to send for approval.
                                                    </div>
                                                    <?php
//                                                        print '<pre>'; print_r($_SESSION['sales_stock']);print'</pre>';
                                                    ?>
                                                    <form method="post" class="form-horizontal">
                                                        <fieldset>
                                                            <legend class="section">Stock Details</legend>

                                                            <div class="control-group">
                                                                <div class="col-md-3">
                                                                    <label for="normal-field" class="control-label">Stock Name</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <select id="stockname" class="form-control" name="stockname" required>
                                                                          <?php
                                                                            foreach($_SESSION['request_stock'] as $k=>$v){
                                                                                echo '<option value="'.$v['stock_name'].'">'. $v['stock_name'].'</option>';
                                                                            }
                                                                          
                                                                          ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <div class="col-md-3">
                                                                    <label for="normal-field" class="control-label">Quantity</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <input id="quantity" min="0" type="number" name="quantity" required/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <div class="col-md-3">
                                                                    <label for="normal-field" class="control-label"></label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <button class="form-control additem btn-primary" type="button">Add Item</button>
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
                                                    <h3> Request Cart</h3>
                                                </div>
                                                <div class="widget-content">
                                                    <form method="post" class="form-horizontal">
                                                        <fieldset>
                                                            <legend class="section">Request List</legend>
                                                            <table class="table table-striped table-images">
                                                                <thead>
                                                                    <tr>
                                                                      <th>#</th>
                                                                      <th>Stock Name</th>
                                                                      <th>Requested Quantity</th>
                                                                      <!--<th class="hidden-xs">Cost Price</th>-->
                                                                      <th class="hidden-xs"></th>
                                                                    </tr>
                                                                  </thead>
                                                                  <tbody id="tableBody">
                                                                  </tbody>
                                                            </table>
                                                            <button id="submitrequest" type="button" class="form-control btn-success">Submit Request</button>
                                                            <br/>
                                                            <center>
                                                            <img src="img/loading.gif"  id="preloader"/>
                                                            </center>
                                                            <div class="alert alert-success fade in">
                                                            <button type="button" class="close close-sm" data-dismiss="alert"> <i class="icon-remove"></i> </button>
                                                            <strong>Track your request easily</strong> 
                                                                All stock movement request can be easily tracked.
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                        </div>
                                        <div class="col-lg-6">
                                        
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
        <script src="js/bootstrap.min.js"></script> 
        <script type="text/javascript">
            $(document).ready(function(){
                $('#preloader').hide();
                window.index_c = 1;
                $('body').on('click','.remove',function(){
                    $(this).parent().parent().remove();
                });
                $('.additem').click(function(){
                    var stockname  = $('#stockname').val();
                    var qty = $('#quantity').val();
                    $('#tableBody').append(
                        '<tr>'+
                        '<td>'+(window.index_c++)+'</td>'+
                        '<td class="stockname">'+stockname+'</td>'+
                        '<td class="quantity">'+qty+'</td>'+ 
                        '<td><button type="button" class="form-control btn-small btn-danger remove" style="width:100px;">Remove</button></td>'+
                        '</tr>'
                    );
                });
                
                $('#submitrequest').click(function(){
                    var stocklist = '';
                    var quantitylist = '';
                    $('.stockname').each(function(){
                        stocklist += $(this).html()+',';
                    });
                    $('.quantity').each(function(){
                        quantitylist += $(this).html()+',';
                    });
                    var data = {
                      'stock': stocklist.toString().substring(0,stocklist.length-1),
                      'quantity' : quantitylist.toString().substring(0,quantitylist.length-1),
                      'sales_area':$('#sales_area').val(),
                      'requester':$('#requester').val()
                    };
                    
                    $('#preloader').show();
                    $.post('stockrequest',data,function(msg,stat,xhr){
                        if(xhr.readyState === 4){
                            if(xhr.status === 200){
                                $('#preloader').hide();
                                window.location.href = 'requestsent';
                            }
                        }
                            
                    });
                });
            });
        </script>
            
        
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

