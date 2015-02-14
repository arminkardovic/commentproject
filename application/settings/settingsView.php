<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
          <li><a href="/armin/demo/settings/" class="selected" ><?php echo T_("Profile"); ?></a></li>
          <li><a href="/armin/demo/settings/otp" ><?php echo T_("One time password"); ?></a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Help</a></li>
          <li><a href="#">Info</a></li>
        </ul>
      </div>
    </div>
    <div id="right_side">
      <div class="panel">
        <p><?php echo T_("Profile settings"); ?></p>
        <div class="normal_panel">
          <div id="accordion">
            <h3><a href="#"><?php echo T_("Your real name"); ?></a></h3>
            <div>
          
              <table border="0" cellpadding="3" >
                <tr>
                  <td><?php echo T_("Your real name"); ?></td>
                  <td><div class="normal_text">
                      <input type="text" name="textfield1" id="textfield"  size="30" class="disabled" title="Username" value="<?php
                      	echo $vars['defined']['name'];
					  ?>"/>
                      <span class="regex_text"> <?php echo T_("Enter your first and last name!");?></span>
                    </div></td>
                 
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="center"><input name="btn1" type="button" value="<?php echo T_("Save changes"); ?>" id="submitButton" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
             
            </div>
            <h3><a href="#"><?php echo T_("Email"); ?></a></h3>
            <div>
              <table border="0" cellpadding="3" >
                <tr>
                  <td><?php echo T_("Email"); ?></td>
                  <td><div class="normal_text">
                      <input type="text" name="textfield2" id="textfield"  class="disabled" size="30"  title="Email" value="<?php
                      	echo $vars['defined']['email'];
					  ?>"
                      />
                     <span class="regex_text"> <?php echo T_("Enter correct email adress!");?></span>
                    </div></td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="center"><input name="btn2" type="button" value="<?php echo T_("Save changes"); ?>" id="submitButton"/></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div>
            <h3><a href="#"><?php echo T_("Password"); ?></a></h3>
            <div>
              <table border="0" cellpadding="3" >
                <tr>
                  <td><?php echo T_("Old password"); ?></td>
                  <td><div class="normal_text">
                      <input type="text" name="textfield3" id="textfield"  size="30"  title="Email"/>
                      
                    </div></td>
                  <td></td>
                </tr>
                <tr>
                  <td><?php echo T_("New password"); ?></td>
                  <td ><div class="normal_text">
                      <input type="text" name="textfield4" id="textfield"  size="30"  title="Email"/>
                      
                    </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><?php echo T_("Repeat new password"); ?></td>
                  <td><div class="normal_text">
                      <input type="text" name="textfield5" id="textfield"  size="30" title="Email"/>
                       <span class="regex_text"> <?php echo T_("Password must have betvean 4 and 15 char one number and char ");?></span>
                    </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td></td>
                  <td align="center"><input name="btn3" type="button" value="<?php echo T_("Save changes"); ?>" id="submitButton"/></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div>
            <h3><a href="#"><?php echo T_("Language"); ?></a></h3>
            <div>
              <table border="0" cellpadding="3" >
                <tr>
                  <td><?php echo T_("Change language"); ?></td>
                  <td>
                  <select name="">
                        <?php 
						
						 foreach($vars['langs'] as $lang){
							 echo " <option>". $lang ."</option>";
	                     }
						?>
                      </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td></td>
                  <td align="center"><input name="btn4" type="button" value="<?php echo T_("Save changes"); ?>" id="submitButton"/></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- accordion end--> 
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
