<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<ul id="nav">
        <li class="current actual"> <a href="salesmanagerhome"> <i class="icon-dashboard"></i> DASHBOARD </a> </li>
        
<!--        <li class="actual"> <a href="creditreturns"> <i class="icon-table"></i>CASH PICKUP </a>
        </li>-->
        <li class="actual"> <a href="stockpositionmanager"> <i class="icon-table"></i>STOCK POSITION </a>
        </li>
<!--        <li class="actual"> <a href="customersmanager"> <i class="icon-table"></i>CUSTOMERS </a>
        </li>-->
        <li class=""> <a href="#"> <i class="icon-dashboard"></i> SALES<i class="arrow icon-angle-left"></i> </a> 
          <ul class="sub-menu">
            <li class="actual"> <a href="cashsales"> <i class="icon-angle-right"></i> CASH SALES</a> </li>
            <li class="actual"> <a href="creditsales"> <i class="icon-angle-right"></i> CREDIT SALES</a> </li>
         </ul>
        </li>
        <li class=""> <a href="#"> <i class="icon-dashboard"></i> REPORTS<i class="arrow icon-angle-left"></i> </a> 
          <ul class="sub-menu">
            <li class="actual"> <a href="salespercustomer"> <i class="icon-angle-right"></i> SALES PER CUSTOMER</a> </li>
         </ul>
        </li>
        
</UL>
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