<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul id="nav">
    <li class="current actual"> <a href="receptionisthome"> <i class="icon-dashboard"></i> DASHBOARD </a> </li>
    <li> <a href="#"> <i class="icon-truck"></i>RAW MATERIAL MANAGEMENT <i class="arrow icon-angle-left"></i></a>
        <ul class="sub-menu">
            <li class="actual"> <a href="createrm"> <i class="icon-tags"></i> CREATE RAW MATERIAL </a> </li>
            <li class="actual"> <a href="rawmaterial"> <i class="icon-tags"></i> CONSUME RAW MATERIAL</a> </li>
            <li class="actual"> <a href="myrmconsumption"> <i class="icon-tags"></i> MY RM CONSUMPTION </a> </li>
            <li class="actual"> <a href="rawmateriallist"> <i class="icon-tags"></i> MY RM POSITION </a> </li>
        </ul>
    </li>
    <li> <a href="#"> <i class="icon-shopping-cart"></i>STOCK MANAGEMENT <i class="arrow icon-angle-left"></i></a>
        <ul class="sub-menu">
            <li class="actual"> <a href="createstock"> <i class="icon-shopping-cart"></i> CREATE STOCK </a> </li>
            <li class="actual"> <a href="uploadstock"> <i class="icon-file"></i> UPLOAD STOCK</a> </li>
            <li class="actual"> <a href="viewstock"> <i class="icon-table"></i> PRODUCED STOCK </a> </li>
            <li class="actual"> <a href="stocklist"> <i class="icon-truck"></i> SALES AREA STOCK </a> </li>
            <li class="actual"> <a href="itadminstock"> <i class="icon-truck"></i> ALL STOCK </a> </li>
        </ul>
    </li>
    <li class="actual">  <a href="expensesit"> <i class="icon-money"></i>EXPENSES</a>
    </LI>
    <li> <a href="#"> <i class="icon-user"></i>CUSTOMER MANAGEMENT <i class="arrow icon-angle-left"></i></a>
        <ul class="sub-menu">
            <li class="actual"> <a href="maintaincustomers"> <i class="icon-user"></i> CREATE CUSTOMERS </a> </li>
            <li class="actual"> <a href="customerlist"> <i class="icon-user-md"></i> VIEW CUSTOMERS </a> </li>
        </ul>
    </li>
    <li> <a href="#"> <i class="icon-money"></i>SALES <i class="arrow icon-angle-left"></i></a>
        <ul class="sub-menu">
            <li class="actual"> <a href="createsales"> <i class="icon-shopping-cart"></i>MAKE SALES </a>
            <li class="actual"> <a href="creditreturns"> <i class="icon-credit-card"></i>CASH PICKUP </a>
            <li class="actual"> <a href="saleslist"> <i class="icon-table"></i>SALES LIST </a>
        </ul>
    </li>

    <li> <a href="#"> <i class="icon-truck"></i>STOCK MOVEMENT <i class="arrow icon-angle-left"></i></a>
        <ul class="sub-menu">
            <li class="actual"> <a href="movestock"> <i class="icon-truck"></i> MOVE STOCK</a> </li>
            <li class="actual"> <a href="requeststatus"> <i class="icon-star"></i>TRACK STATUS</a> </li>
            <li class="actual"> <a href="stockmovement"> <i class="icon-truck"></i>STOCK CONFIRMATION</a>
    </li>
        </ul>
    </li>

   
<!--<li class="actual"> <a href="processrequest"> <i class="icon-dashboard"></i> PROCESS REQUEST</a> </li>-->
    

    
    
<!--        <li> <a href="createinvoice"> <i class="icon-table"></i>CREATE INVOICE</a>
    </li>-->
<!--        <li> <a href="stockcheck"> <i class="icon-table"></i>CHECK STOCK BALANCE</a>
    </li>-->
<!--        <li class="actual"> <a href="stockrequest"> <i class="icon-table"></i>STOCK REQUEST FORM</a>
    </li>-->
    


</UL>
<script src="js/jquery.js"></script> 
<script type="text/javascript">
    $(document).ready(function () {
        $('.actual').each(function () {
            $(this).removeClass('current');
        });
        $('li.actual a').each(function () {
            var url = window.location.href.toString().split("//");
            var page = url[1].toString().split('/');
            if (page.indexOf($(this).attr('href'), 0) !== -1) {
                $(this).parent().addClass('current');
                if ($(this).parent().parent().attr('class') === 'sub-menu') {
                    $(this).parent().parent().addClass('opened');
                }
            }

        });

    });
</script>