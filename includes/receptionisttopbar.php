<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="top-navbar header b-b"> <a data-original-title="Toggle navigation" class="toggle-side-nav pull-left" href="#"><i class="icon-reorder"></i> </a>
       <div class="brand pull-left" style="width:600px"> <H2><img src="img/naiklogo.gif" width="50px" height="50px"/>&nbsp;&nbsp;NAIK INVENTORY&nbsp;&nbsp;<span style="font-size:22px">(IT ADMINISTRATOR)</span></H2></div>
   <ul class="nav navbar-nav navbar-right  hidden-xs">
      <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-warning-sign"></i> <span class="badge"><?= $request_count ?></span> </a>
        
          
      </li> 
     
<!--      <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-envelope"></i> <span class="badge">3</span> </a>
        <ul class="dropdown-menu extended notification">
          <li class="title">
            <p>You have 3 new sales</p>
          </li>
          <li> <a href="#"> <span class="label label-success"><i class="icon-plus"></i></span> <span class="message"> 40 bags sold from Jos Sales Area.</span> <span class="time">1 mins</span> </a> </li>
          <li> <a href="#"> <span class="label label-danger"><i class="icon-warning-sign"></i></span> <span class="message">40 bags sold from Abuja Sales Area.</span> <span class="time">5 mins</span> </a> </li>
          <li> <a href="#"> <span class="label label-danger"><i class="icon-warning-sign"></i></span> <span class="message">40 bags sold from Abuja Sales Area.</span> <span class="time">5 mins</span> </a> </li>
          <li class="footer"> <a href="#">View all sales</a> </li>
        </ul>
      </li>--> 
      <li class="dropdown user  hidden-xs"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-male"></i> <span class="username"><?php echo $_SESSION['user']['fullname']?></span> <i class="icon-caret-down small"></i> </a>
        <ul class="dropdown-menu">
          <li><a href="receptionistprofile"><i class="icon-user"></i> My Profile</a></li>
          <li class="divider"></li>
          <li><a href="logout"><i class="icon-key"></i> Log Out</a></li>
        </ul>
      </li>
    </ul>
    
  </div>

