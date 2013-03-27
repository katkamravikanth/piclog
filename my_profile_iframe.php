<?php
error_reporting(0);
session_start();

include'database/db.php';

if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin.php';
}
$uname = $_SESSION['uname'];
$uid = $_SESSION['uid'];

$user = mysql_query("SELECT users.full_name, users.dob, users.gender, users.phone, users.email, location.address, location.city, location.state, location.country, users.uid, users.phone_code FROM users INNER JOIN location WHERE users.uid = '$uid' AND location.uid = '$uid'");
$users = mysql_fetch_array($user);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/profile_styles.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="js/jquery_ravikanth_scroll.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/jquery_ravikanth_profile.js"></script>
<!--[if lt IE 9]>
  <script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
<style type="text/css">
.text_box {
	display: none;
}
#age {
	color: #F30;
	font-size: 12px;
}
#recent_piclogs {
	width: 430px !important;
	height:100%;
}
td, th {
	font-size:14px;
}
</style>
<div id="recent_pic" style="width:420px !important; position:relative;">
	<div id="div_mask" style="position:absolute; top:50px; right:-10px; z-index:99; width:20px; height:460px; background:#fff;">&nbsp;</div>
	<h2 align="left" style="text-transform:capitalize"><?php echo stripslashes($users['full_name']);
	$social = mysql_fetch_array(mysql_query("SELECT * FROM profile_social WHERE uid = '".$users['uid']."'"));
	if($social["fb"] != ''){
		echo '<a href="http://www.facebook.com/'.$social["fb"].'" class="fb text" target="_blank"></a>';
	}if($social["tw"] != ''){
		echo '<a href="http://twitter.com/'.$social["tw"].'" class="tw text" target="_blank"></a>';
	}if($social["gp"] != ''){
		echo '<a href="http://plus.google.com/'.$social["gp"].'" class="gp text" target="_blank"></a>';
	}?></h2>
	<div align="right" style="text-align:right; position:absolute; top:5px; right:2px; z-index:9 !important;"><br />
        <span class="text" id="text" style="float:right">
			<a href="javascript:;" style="text-decoration:none" class="edit" id="edit_profile" title="Update Profile">&nbsp;</a>
        </span>
        <span class="text_save" id="text" style="float:right; display:none;">
        	<div style="height:30px; width:34px; background:#fff; opacity:0.4; display:none; float:right; padding-top:5px; position:absolute; right:-2px; top:13px; z-index:9; cursor:default;" id="save_icon">&nbsp;</div>
			<a href="javascript:;" style="text-decoration:none;" id="save_profile" title="Save">&nbsp;</a>
		</span>
	</div>
  <input type="hidden" name="userid" id="userid" value="<?php echo $users['uid'];?>" />
  <div class="text" style="text-align:justify; font-size:14px !important; line-height:20px; width:100%; height:460px;">
	<div id="mcs5_container" style="width:420px; height:460px !important;">
		<div class="customScrollBox">
			<div class="container">
				<div class="content">
					<div id="left">
                        <span style="text-transform:capitalize">
                        <?php if($users['city'] != ''){ echo stripslashes($users['city']).', ';}
                            //if($users['state'] != ''){echo stripslashes($users['state']).', ';}
                            if($users['country'] != '' && $users['country'] != 0){
                                $isso = mysql_fetch_array(mysql_query("SELECT country FROM country_codes WHERE con_id = '".$users['country']."'"));
                                echo stripslashes($isso['country']);
                            }?>
                        </span><br />
                        <?php if($users['phone'] != ''){
                                $codee = mysql_fetch_array(mysql_query("SELECT phone_code FROM country_codes WHERE con_id = '".$users['phone_code']."'"));
                                echo $codee['phone_code'].' '.stripslashes($users['phone']).'<br />';//phone
                            }
                            echo stripslashes($users['email']).'<br />';//email
                            if($users['gender'] != ''){echo stripslashes($users['gender']).', ';}//gender
                            if($users['dob'] != ''){
								$dob = explode("/", $users['dob']);
								echo intval($dob[0]).'/'.intval($dob[1]).'/'.intval($dob[2]).'<br />';}//dob
                            if($users['address'] != ''){echo '<span style="text-align:left;text-transform:capitalize">'.stripslashes($users['address']).'</span><br />';}
                            
                            $bio = mysql_fetch_array(mysql_query("SELECT about FROM about WHERE uid = '".$users['uid']."'"));
                            if($bio['about'] != ''){
                                echo '<br /><strong style="font-size:16px !important;">BIO</strong><br />';
                                echo "<span class='answer'>".stripslashes($bio['about']).'</span><br />';
                            }
                            $question = mysql_fetch_array(mysql_query("SELECT * FROM about_questions WHERE uid = '".$users['uid']."'"));
                           
							if($question['igod'] != '' || $question['ifkungfu'] != '' || $question['substitute'] != '' || $question['innovation'] != '' || $question['tarzan'] != ''){
                                echo '<br /><strong style="font-size:18px !important;">Take 5!!</strong><br /><br />';
                            }
                            if($question['igod'] != ''){
                                echo "<strong>If I was God... </strong><span class='answer'>";
                                echo stripslashes($question['igod']).'</span><br /><br />';
                            }if($question['ifkungfu'] != ''){
                                echo "<strong>Expression to me is... </strong><span class='answer'>";
                                echo stripslashes($question['ifkungfu']).'</span><br /><br />';
                            }if($question['substitute'] != ''){
                                echo "<strong>My substitute for water is... </strong><span class='answer'>";
                                echo stripslashes($question['substitute']).'</span><br /><br />';
                            }if($question['innovation'] != ''){
                                echo "<strong>World's best innovation is... </strong><span class='answer'>";
                                echo stripslashes($question['innovation']).'</span><br /><br />';
                            }if($question['tarzan'] != ''){
                                echo "<strong>Which movie or book describes you best? </strong><span class='answer'>";
                                echo stripslashes($question['tarzan']).'</span><br />';
                            }
							 if($bio['about'] == '' || $question['igod'] == '' || $question['ifkungfu'] == '' || $question['substitute'] == '' || $question['innovation'] == '' || $question['tarzan'] == ''){?>
                                <div id="incomplete" align="center">
                                	<img src="images/characters/my_profile.png" alt="Complete Your Profile to let the world" /><br /><br /><br />
                                	<!--<span class="fullsize">COMPLETE</span>
                                    <span class="fullsize1">YOUR PROFILE</span>
                                    <!--<div class="let" align="right">to let the world...</div>-><br /><br />
                                    <div align="left" style="position:relative">
                                    <img src="images/searching.png" alt="Complete Your Profile to let the world" title="Complete Your Profile to let the world" />
                                    <span class="know">To let the world know you better</span></div>-->
                                </div>
							<?php }?>
					</div>
				</div>
			</div>
			<div class="dragger_container">
				<div class="dragger"></div>
			</div>
		</div>
	</div>
  </div>
  <!-- edit section start -->
	<div id="mcs4_container" style="width:420px; height:460px !important; visibility:hidden; position:absolute; top:50px;">
		<div class="customScrollBox">
			<div class="container">
				<div class="content">
					<div id="left">
                    <div id="error" style="display:none; font-size:12px;">&nbsp;</div>
                    <img src='images/loader/portfolio_load.gif' id='loadingmessage' style='display:none' />
                      <table width="420" border="0" cellspacing="0" cellpadding="0" style="text-align:justify; line-height:30px;" class="edit_profile">
                        <tr>
                          <td width="100">Display Name *</td>
                          <td width="30">:</td>
                          <td><div id="error_fname" style="display:none; font-size:12px;">&nbsp;</div>
                            <input type="text" name="fname" id="fname" maxlength="20" value="<?php echo $users['full_name'];?>" /></td>
                        </tr>
                        <tr>
                          <td>Gender *</td>
                          <td>:</td>
                          <td><div id="error_gender" style="display:none; font-size:12px;">&nbsp;</div>
                          <select name="gender" id="gender">
                          	  <option value="">Select</option>
                              <option <?php if($users['gender'] == 'Male'){echo 'selected="selected"';}?>>Male</option>
                              <option <?php if($users['gender'] == 'Female'){echo 'selected="selected"';}?>>Female</option>
                            </select></td>
                        </tr>
                        <tr>
                          <td>DOB *</td>
                          <td>:</td>
                          <td><div id="error_dob" style="display:none; font-size:12px;">&nbsp;</div>
                            <?php $dob = explode("/", $users['dob']);?>
                            <select name="day" id="day">
                              <option value="">Day</option>
                              <!--<option selected="selected"><?php echo $dob[0];?></option>-->
                              <?php for($i=1; $i<=31; $i++){
								  echo "<option";
								  if($i == intval($dob[0])){echo ' selected="selected"';}
								  echo ">$i</option>";}?>
                            </select>
                            <select name="month" id="month">
                              <option value="">Month</option>
                              <!--<option selected="selected"><?php echo date("M", mktime(0, 0, 0, $dob[1], 10));?></option>-->
                              <?php for($j=1; $j<=12; $j++){
								  echo "<option";
								  if($j == intval($dob[1])){echo ' selected="selected"';}
								  echo " value='$j'>".date("M", mktime(0, 0, 0, $j, 10))."</option>";}?>
                            </select>
                            <select name="year" id="year" onChange="showAge()">
                              <option value="">Year</option>
                              <!--<option selected="selected"><?php echo $dob[2];?></option>-->
                              <?php $year = date("Y")-52; $cyear = date("Y")-13;
                                for($k=$year; $k<=$cyear; $k++){
									echo "<option";
								  if($k == $dob[2]){echo ' selected="selected"';}
								  echo ">$k</option>";}?>
                            </select>
                            <br />
                            <span id="age"></span></td>
                        </tr>
                        <tr>
                          <td>Address</td>
                          <td>:</td>
                          <td><input type="text" name="address" id="address" maxlength="150" value="<?php echo stripslashes($users['address']);?>" /></td>
                        </tr>
                        <tr>
                          <td>City *</td>
                          <td>:</td>
                          <td><div id="error_city" style="display:none; font-size:12px;">&nbsp;</div>
                            <input type="text" name="city" id="city" maxlength="20" value="<?php echo stripslashes($users['city']);?>"  /></td>
                        </tr><!--
                        <tr>
                          <td>State</td>
                          <td>:</td>
                          <td><input type="text" name="state" id="state" value="<?php echo stripslashes($users['state']);?>"  /></td>
                        </tr>->
                        <tr>
                          <td>Country *</td>
                          <td>:</td>
                          <td><div id="error_country" style="display:none; font-size:12px;">&nbsp;</div>
								<?php $contry = mysql_query("SELECT country FROM country_codes WHERE con_id = '".$users['country']."'");
                                $isso = mysql_fetch_array($contry);?>
                            <input type="text" name="country" id="country" readonly="readonly" value="<?php echo stripslashes($isso['country']);?>"  />
							<!--<select name="country" id="country" style="width:200px;">
                              <option value="">Select Country</option>
                              <?php $country = mysql_query("SELECT * FROM country_codes ORDER BY country ASC");
                                while($iso = mysql_fetch_array($country)){?>
                              <option value="<?php echo $iso['con_id'];?>"<?php if($iso['con_id'] == $users['country']){echo 'selected';}?>>
                               <?php echo $iso['country'].'</option>';}?>
                            </select>-></td>
                        </tr>-->
                        <tr>
                          <td>Mobile</td>
                          <td>:</td>
                          <td><div id="error_phone" style="display:none; font-size:12px;"></div>
                            <input type="text" name="phone" id="phone" value="<?php echo stripslashes($users['phone']);?>" style="width:200px !important;"  /></td>
                        </tr>
                        <tr>
                          <td>Email ID *</td>
                          <td>:</td>
                          <td><div id="error_email" style="display:none; font-size:12px;"></div>
                            <input type="text" name="email" id="email" value="<?php echo stripslashes($users['email']);?>" style="text-transform:lowercase;" /></td>
                        </tr>
                        <tr>
                          <td colspan="3">
                          <div class="control-group">
                          <label class="control-label" for="fb">Facebook Profile</label>
                          <div class="controls">
                            <div class="input-prepend">
                      		  <span class="add-on"><img src="images/sm/f.png" alt="http://www.facebook.com" title="http://www.facebook.com" /></span>
                              <input type="text" id="facebook" name="facebook" value="katkamravikanth" placeholder="Facebook Profile username" style="border-color: #ccc !important; border-radius:0; height:30px; margin-top:-0px; width: 270px;" />
                            </div>
                          </div>
                        </div>
                        <div class="control-group">
                          <label class="control-label" for="tw">Twitter Profile</label>
                          <div class="controls">
                            <div class="input-prepend">
                          	  <span class="add-on"><img src="images/sm/t.png" alt="http://www.twitter.com" title="http://www.twitter.com" /></span>
                              <input type="text" id="tw" name="tw" value="katkamravikanth" placeholder="Twitter Profile username" style="border-color: #ccc !important; border-radius:0; height:30px; margin-top:-0px; width: 270px;" />
                            </div>
                          </div>
                        </div>
                      	<div class="control-group">
                          <label class="control-label" for="gp">Google+ Profile</label>
                          <div class="controls">
                            <div class="input-prepend">
                      		  <span class="add-on"><img src="images/sm/g.png" alt="http://plus.google.com/" title="http://plus.google.com/" /></span>
                              <input type="text" id="gp" name="gp" value="107504027584834385708" placeholder="Google+ Profile username" style="border-color: #ccc !important; border-radius:0; height:30px; margin-top:-0px; width: 270px;" />
                            </div>
                          </div>
                        </div>
                      	<div class="control-group">
                          <label class="control-label" for="gp">Blogger</label>
                          <div class="controls">
                            <div class="input-prepend">
                      		  <input type="text" id="bg" name="bg" value="" placeholder="Blogger URL" style="border-color: #ccc !important; border-radius:0; height:30px; margin-top:-0px; width: 270px;" />
                              <span class="add-on">blogspot.com</span>
                            </div>
                          </div>
                        </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3"><strong style="font-size:18px;">BIO</strong></td>
                        </tr>
                        <tr>
                          <td colspan="3"><textarea name="bio" id="bio" onkeypress="return imposeMaxLength(this, 400);" placeholder="Describe yourself; your attitude, likes, dislikes, etc."><?php echo stripslashes($bio['about']); ?></textarea><br />
							<font size="1">(Maximum characters: 400)</font></td>
                        </tr>
                        <tr>
                          <td colspan="3"><strong style="font-size:18px;">Take 5!!</strong></td>
                        </tr>
                        <tr>
                          <td colspan="3">If I was God...</td>
                        </tr>
                        <tr>
                          <td colspan="3"><textarea name="igod" id="igod" onkeypress="return imposeMaxLength(this, 200);"><?php echo stripslashes($question['igod']);?></textarea><br />
							<font size="1">(Maximum characters: 200)</font></td>
                        </tr>
                        <tr>
                          <td colspan="3">Expression to me is...</td>
                        </tr>
                        <tr>
                          <td colspan="3"><textarea name="ifkungfu" id="ifkungfu" onkeypress="return imposeMaxLength(this, 200);"><?php echo stripslashes($question['ifkungfu']);?></textarea><br />
							<font size="1">(Maximum characters: 200)</font></td>
                        </tr>
                        <tr>
                          <td colspan="3">My substitute for water is...</td>
                        </tr>
                        <tr>
                          <td colspan="3"><textarea name="substitute" id="substitute" onkeypress="return imposeMaxLength(this, 200);"><?php echo stripslashes($question['substitute']);?></textarea><br />
                          	<font size="1">(Maximum characters: 200)</font></td>
                        </tr>
                        <tr>
                          <td colspan="3">World's best innovation is...</td>
                        </tr>
                        <tr>
                          <td colspan="3"><textarea name="innovation" id="innovation" onkeypress="return imposeMaxLength(this, 200);"><?php echo stripslashes($question['innovation']);?></textarea><br />
                          	<font size="1">(Maximum characters: 200)</font></td>
                        </tr>
                        <tr>
                          <td colspan="3">Which movie or book describes you best?</td>
                        </tr>
                        <tr>
                          <td colspan="3"><textarea name="tarzan" id="tarzan" onkeypress="return imposeMaxLength(this, 200);"><?php echo stripslashes($question['tarzan']);?></textarea><br />
							<font size="1">(Maximum characters: 200)</font></td>
                        </tr>
                      </table><br />
					</div>
				</div>
			</div>
			<div class="dragger_container">
				<div class="dragger"></div>
			</div>
		</div>
	</div>
	<!-- edit section end -->
</div>
