<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php   print_r($vars['title']);?></title>
<?php 
     foreach($vars['files'] as $file){
		 echo $file;
	}

?>
</head>
<body>
<div id="container">

	<div id="hd">
    	<div id="logo" class="hd-logo">
        </div>
          <div class="dropdown">
	<a class="account" >
	<span>My Account</span>
	</a>
	<div class="submenu" style="display: none; ">

	  <ul class="root">
<li >
	      <a href="#Dashboard" >Dashboard</a>
	    </li>

	    
	    <li >
	      <a href="#Profile" >Profile</a>
	    </li>
	   <li >

	      <a href="#settings">Settings</a>
	    </li>
	   

	    <li>
	      <a href="#feedback">Send Feedback</a>
	    </li>



	    <li>
	      <a href="logout">Logout</a>
	    </li>
	  </ul>
	</div>
	</div>
	
	</div>
    
<div id="content">
    	
        
      
    
    </div>
	<div id="ft">
        <span>	
        	Copyright © 2012 Zeko.me, doo. All rights reserved. 
        </span>
    </div>
    
</div>
</body>
</html>



