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
	</div>
    
<div id="content">
    	<div id="lt_login">
       		<div id="login_img_f"class="login_img">
            </div>
    	</div>
        
      <div id="rg_login">
      
        	<div id="login">
            
            <div id="lg_body">
            
            <div id="login_text">
            	<span> <?php echo T_("Login");?></span>
            </div>
      <table width="100%"  border="0" cellpadding="3" align="center"  >
        <tr>
          <td align="right" valign="middle"   width="30%" >
		  <?php echo T_("Username:");?>
		  </td>
          <td><input name="username" type="text" id="username" size="25" />
           <span class="regex_text"> <?php echo T_("Required field!");?></span>
          </td>
        </tr>
        <tr>
          <td align="right" valign="baseline">
		   <?php echo T_("Password:");?>
		  </td>
          <td><input type="password" name="password" id="password" size="25" />
           <span class="regex_text"><?php echo T_("Type betvean 4 and 15 char and one is number!");?></span>
          </td>
        </tr>
        <tr>
          <td rowspan="2">&nbsp;</td>
          <td align="center"><input type="button" name="login_btn" id="submitButton" value=" <?php echo T_("Login");?>"  class="buttonNormal"/></td>
        </tr>
        <tr>
          <td><a href="#"> <?php echo T_("Forget password?");?></a></td>
        </tr>
      </table>
  
    
         <div id='error' class="ui-state-error ui-corner-all" >
			<div style="padding: 0 .7em;" class="ui-state-error ui-corner-all">
				<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
				<strong>Alert:</strong><span id="error_text"></span></p>
			</div>
            
         </div>
       </div>
       <div id="lg_pin">
            <div id="login_text">
            	<span><?php echo T_("Login");?> OTP</span>
            </div>
          <form action="" method="post">
      <table width="100%"  border="0" cellpadding="3" align="center"  >
        <tr>
          <td align="right" valign="middle" width="30%">
		  <?php echo T_("Our key:");?>
		  </td>
          <td> <input type="text" name="key" id="key" size="20"  style="clear:left" readonly="readonly"/></td>
        </tr>
        <tr>
          <td align="right" valign="middle" >
		   <?php echo T_("Your key:");?></td>
          <td>
          <div>
           <input type="text" name="passwordotp" id="passwordotp" size="20"  style="clear:left"/>
           <span class="regex_text"> <?php echo T_("This input just accept four numbers!");?></span>
          </div>
          </td>
        </tr>
        <tr>
          <td rowspan="2">&nbsp;</td>
          <td align="center"><input type="button" name="login_otp" id="submitButton" value="<?php echo T_("Login");?>"  class="buttonNormal"/></td>
        </tr>
        <tr>
          <td><a href="#"><?php echo T_("Have problem with otp?");?></a></td>
        </tr>
      </table>
    </form>
         <div id='error_otp' class="ui-state-error ui-corner-all" >
			<div style="padding: 0 .7em;" class="ui-state-error ui-corner-all">
				<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
				<strong>Alert:</strong><span id="error_text"></span></p>
	</div>     
    </div>
            </div>
        </div>
    
    </div>
    
	<div id="ft">
        <span>	
        	Copyright © 2012 Zeko.me, doo. All rights reserved. 
        </span>
    </div>
    
</div>
</body>
</html>
