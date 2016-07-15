<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<ul id="nav">
        <li class="actual current"> <a href="home"> <i class="icon-dashboard"></i> Dashboard </a> </li>
        <li > <a href="#"> <i class="icon-envelope"></i> STOCK MOVEMENT<i class="arrow icon-angle-left"></i> </a> 
          <ul class="sub-menu">
            <li class="actual"> <a href="rejectrequest"> <i class="icon-angle-right"></i> REJECTED STOCK</a> </li>
<!--            <li class="actual"> <a href="pendingrequest"> <i class="icon-angle-right"></i> PENDING REQUESTS</a> </li>
            <li class="actual"> <a href="approvedrequest"> <i class="icon-angle-right"></i> APPROVED REQUESTS </a> </li>-->
            <li class="actual"> <a href="intransitrequest"> <i class="icon-angle-right"></i> IN TRANSIT STOCK </a> </li>
            <li class="actual"> <a href="completedrequest"> <i class="icon-angle-right"></i> RECEIVED STOCK </a> </li>
         </ul>
        </li>
        <li> <a href="#"> <i class="icon-shopping-cart"></i> STOCK POSITION <i class="arrow icon-angle-left"></i></a>
          <ul class="sub-menu">
            <li class="actual"> <a href="stockraw"> <i class="icon-angle-right"></i> RAW MATERIALS </a> </li>
            <li class="actual"> <a href="stockconcentrate"> <i class="icon-angle-right"></i> CONCENTRATES </a> </li>
            <li class="actual"> <a href="stockfinished"> <i class="icon-angle-right"></i>COMPLETE FEED</a> </li>
          </ul>
        </li >
        <li class="actual"> <a href="customersdirect"> <i class="icon-group"></i>CUSTOMERS </a>
<!--          <ul class="sub-menu">
            <li> <a href="customersdirect"> <i class="icon-angle-right"></i> DIRECT FARMERS </a> </li>
            <li> <a href="customerscash"> <i class="icon-angle-right"></i> CASH OUTLETS </a> </li>
            <li> <a href="customerscredit"> <i class="icon-angle-right"></i> CREDIT OUTLETS </a> </li>
          </ul>-->
        </li>
<!--        <li> <a href="employees"> <i class="icon-table"></i>EMPLOYEES </a>
        </li>-->
<!--        <li> <a href="productioncost"> <i class="icon-table"></i>PRODUCTION COST  </a>
        </li>-->
        <li class="actual">  <a href="expenses"> <i class="icon-money"></i>EXPENSES</a>
        </LI>
        <li> <a href="#"> <i class="icon-bar-chart"></i>REPORTS  <i class="arrow icon-angle-left"></i></a>
         <ul class="sub-menu">
            <li class="actual"> <a href="salessalesarea"> <i class="icon-angle-right"></i> SALES BY SALES AREA </a> </li>
            <li class="actual"> <a href="salesproduct"> <i class="icon-angle-right"></i> SALES BY PRODUCT </a> </li>
            <li class="actual"> <a href="salescustomer"> <i class="icon-angle-right"></i> SALES BY CUSTOMER </a> </li>
<!--            <li> <a href="totalsalesarea"> <i class="icon-angle-right"></i> TOTAL SALES VALUE BY SALES AREA/OUTLET </a> </li>
            <li> <a href="totalcustomer"> <i class="icon-angle-right"></i> TOTAL SALES VALUE BY CUSTOMER </a> </li>-->
            <li class="actual"> <a href="profitcustomer"> <i class="icon-angle-right"></i> PROFIT BY CUSTOMER </a> </li>
            <li class="actual"> <a href="profitsalesarea"> <i class="icon-angle-right"></i> PROFIT BY SALES AREA</a> </li>
            <li class="actual"> <a href="rawmaterialreport"> <i class="icon-angle-right"></i> RAW MATERIAL REPORT</a> </li>
            <li class="actual"> <a href="producedadmin"> <i class="icon-angle-right"></i> PRODUCED STOCK</a> </li>
            <li class="actual"> <a href="salesareaadmin"> <i class="icon-angle-right"></i> SALES AREA STOCK</a> </li>
            <li class="actual"> <a href="creditsalesreport"> <i class="icon-angle-right"></i> CREDIT SALES REPORT</a> </li>
            <li class="actual"> <a href="grossprofit"> <i class="icon-angle-right"></i> GROSS PROFIT REPORT</a> </li>
          </ul>
        </li>
         <li > <a href="#"> <i class="icon-group"></i> EMPLOYEE MANAGEMENT<i class="arrow icon-angle-left"></i> </a> 
          <ul class="sub-menu">
              <li class="actual"> <a href="usermanagement"> <i class="icon-user"></i>ADD EMPLOYEE  </a></li>
            <li class="actual"> <a href="userslist"> <i class="icon-group"></i>VIEW EMPLOYEES  </a>
            </li> 
          </ul>
         </li>
         <li > <a href="#"> <i class="icon-group"></i> MAINTAIN PRICING<i class="arrow icon-angle-left"></i> </a> 
          <ul class="sub-menu">
              <li class="actual"> <a href="pricing"> <i class="icon-user"></i>NEW PRICE  </a></li>
            <li class="actual"> <a href="pricelist"> <i class="icon-group"></i>PRICE LIST </a>
            </li> 
          </ul>
         </li>
         <li class="actual">  <a href="reversal"> <i class="icon-lock"></i>REVERSAL</a>
        </LI>
         <li class="actual">  <a href="changepassword"> <i class="icon-lock"></i>CHANGE PASSWORD</a>
        </LI>
      </ul>
<script src="js/jquery.js"></script> 
<script type="text/javascript">
    $(document).ready(function(){
        
        $('.actual').each(function(){
            $(this).removeClass('current');
        });
        $('li.actual a').each(function(){
            var url = window.location.href.toString().split("//");
            var page = url[1].toString().split('/');
            if( page.indexOf($(this).attr('href'),0) !== -1 ){
                $(this).parent().addClass('current');
                if($(this).parent().parent().attr('class') === 'sub-menu'){
                    $(this).parent().parent().addClass('opened');
                }
            }
        });
    });
</script>