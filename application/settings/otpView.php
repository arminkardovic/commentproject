<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php   print_r($vars['title']);?>
</title>
<?php 
     foreach($vars['files'] as $file){
		 echo $file;
	}

?>
</head>
<body>
<div id="container">
<div id="hd">
  <div id="logo" class="hd-logo"> </div>
  <div class="dropdown"> <a class="account" > <span> <?php echo T_("My Account"); ?></span> </a>
    <div class="submenu" style="display: none; ">
      <ul class="root">
        <li > <a href="#Dashboard" >Dashboard</a> </li>
        <li > <a href="/armin/demo/profil" >Profile</a> </li>
        <li > <a href="/armin/demo/settings"><?php echo T_("Settings"); ?></a> </li>
        <li> <a href="/armin/demo/profil">Send Feedback</a> </li>
        <li> <a href="/armin/demo/logout"><?php echo T_("Logout"); ?></a> </li>
      </ul>
    </div>
  </div>
</div>
<div id="content">
<div id="left_side">
  <div class="menu_side" id="menu1"> <img src="/armin/demo/lib/css/images/arrow.png" width="22" height="22" id="arrow"/>
    <ul>
      <li><a href="/armin/demo/settings/" ><?php echo T_("Profile"); ?></a></li>
      <li><a href="/armin/demo/settings/otp" class="selected" ><?php echo T_("One time password"); ?></a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Help</a></li>
      <li><a href="#">Info</a></li>
    </ul>
  </div>
</div>
<div id="right_side">
<div class="panel">
<p><?php echo T_("One time password settings"); ?></p>
<div class="normal_panel">
<div id="accordion">
  <h3><a href="#"><?php echo T_("Info"); ?></a></h3>
  <div>
    <table border="0" cellpadding="3" class="minimal-style" width="100%">
      <thead>
        <tr>
          <th scope="col"><?php echo T_("Today Date"); ?></th>
          <th scope="col"><?php echo T_("Expire date"); ?></th>
          <th scope="col"><?php echo T_("Left code"); ?></th>
        </tr>
      </thead>
      <tr>
        <td ><?php echo date("Y-m-d"); ?></td>
        <td><?php echo $vars['expire_date'] ;?></td>
        <td><?php echo $vars['number_key'] ;?></td>
      </tr>
      <?php echo $vars['row'] ;?>
    </table>
  </div>
  <h3><a href="#"><?php echo T_("Generate new OTP"); ?></a></h3>
  <div>
    <table border="0" cellpadding="3">
      <tr>
        <td align="right" ><?php echo T_("Our key:");?></td>
        <td><div class="normal_text">
            <input type="text" name="textfield6" id="key"   readonly="" title="Username" style="width:180px;" value="<?php echo $vars['key'];?>"/>
          </div></td>
        <td></td>
      </tr>
      <tr>
        <td  align="right" ><?php echo T_("Your key:");?></td>
        <td><div class="normal_text">
            <input type="text" name="textfield7" id="textfield"  title="Code" style="width:180px;"/>
            <span class="regex_text"> <?php echo T_("This input just accept four numbers!");?></span>

          </div></td>
        <td></td>
      </tr>
      <tr>
        <td ></td>
        <td align="center"><input name="btn6" type="button" value="<?php echo T_("Generate Code"); ?>" id="submitButton"/></td>
        <td></td>
      </tr>
      <?php echo $vars['row'] ;?>
    </table>
  </div>
</div>
<!-- accordion end-->
<div id="code_div">
<table border="0" cellpadding="3" id="tb1" width="100%" class="minimal-style" style="margin-top:15px;">
<thead>
  <tr>
    <th scope="col"><?php echo T_("RN"); ?></th>
    <th scope="col"><?php echo T_("Key"); ?></th>
    <th scope="col"><?php echo T_("Code"); ?></th>
    

    <th scope="col"><?php echo T_("Key"); ?></th>
    <th scope="col"><?php echo T_("Code"); ?></th>
    

    <th scope="col"><?php echo T_("Key"); ?></th>
    <th scope="col"><?php echo T_("Code"); ?></th>
    

    <th scope="col"><?php echo T_("Key"); ?></th>
    <th scope="col"><?php echo T_("Code"); ?></th>
    

    <th scope="col"><?php echo T_("Key"); ?></th>
    <th scope="col"><?php echo T_("Code"); ?></th>
  </tr>
</thead>
<tbody>

</tbody>
</table>
<input name="print" type="button" value="<?php echo T_("Print"); ?>" id="submitButton"/>
<div id="valid">


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
           <input type="text" name="pass_active" id="passwordotp" size="21"  style="clear:left"/>
           <span class="regex_text"> <?php echo T_("This input just accept four numbers!");?></span>
          </div>
          </td>
        </tr>
        <tr>
          <td rowspan="2">&nbsp;</td>
          <td align="center"><input type="button" name="act_otp" id="submitButton" value="<?php echo T_("Activate");?>"  class="buttonNormal"/></td>
        </tr>
        <tr>
          <td> <span class="regex_text"> <?php echo T_("You must validate code to take efect!");?></span></td>
        </tr>
      </table>

</div>
</div>
</div>
<!-- margin div end-->

</div>
</div>
</div>
<div id="dialog" title="<?php echo T_("Alert message"); ?>">
  <p> <?php echo T_("You made some changes in this page if you want to save click on button to save changes"); ?> </p>
</div>
<div id="ft"> <span> Copyright © 2012 Zeko.me, doo. All rights reserved. </span> </div>
</div>
</body>
</html>
