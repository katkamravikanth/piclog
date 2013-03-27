<?php
error_reporting(0);
session_start();

include'database/db.php';

if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin.php';
}
$uid = $_SESSION['myid'];
$picfoll = mysql_query("SELECT * FROM followers WHERE uid = '$uid' AND authorized = 'yes' ORDER BY timestamp DESC");
$count = mysql_num_rows($picfoll);

$page_title = 'Followers';
include_once 'get/header.php';
?>
<link rel="stylesheet" type="text/css" href="css/profile_styles.css" />
<link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="js/jquery_ravikanth_script.js"></script>
<script type="text/javascript" src="js/jquery_ravikanth_scroll.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>

<style type="text/css">
html, body {
	overflow-y:auto !important;
}
</style>

<body>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({ 
	appId:'273615529401579', cookie:true, 
	status:true, xfbml:true 
});
function FacebookInviteFriends(){
	FB.ui({ method: 'apprequests', 
	message: 'My diaolog...'});
}
</script>
<div id="mask1" style="display:none">&nbsp;</div>
<div id="popup1" style="display:none; width:350px;">
	<div style="background:url(images/icons/title.gif) repeat-x; height:35px;">
		<a href="javascript:;" class="close" style="float:right; margin-right:20px; margin-top:-3px;">&nbsp;</a>
	</div>
	<div align="center" id="error">&nbsp;</div>
</div>
<div id="layout">
	<?php include 'get/links.php';?>
    <div id="header1">&nbsp;</div>
    <header>
    	<div id="header">
            <div class="logo">
            	<a href="http://www.piclog.in"><img id="piclog" src="images/logo1.png" alt="piclog" style="position:relative; z-index:111;" /></a>
            </div>
            <div id="right">
                <div id="piclogs">
                	<table><tr><td class="title">Top Rated Piclogs</td><td style="height:45px;" valign="top">
                    <select name="category" id="category" style="width:140px;">
                    	<option value="">All Categories</option>
						<?php $cate = mysql_query("SELECT * FROM category ORDER BY category ASC");
						while($cat = mysql_fetch_row($cate)){
                        if($cat[1] != 'Others'){?>
						<option value="<?php echo $cat[2];?>" <?php if($cat[2] == $cat_id){?>selected="selected"<?php }?>><?php echo $cat[1];?></option>
						<?php }}
						$categ = mysql_query("SELECT * FROM category WHERE category = 'Others' ORDER BY category ASC");
						$catego = mysql_fetch_row($categ);?>
                        <option value="<?php echo $catego[2];?>" <?php if($catego[2] == $cat_id){?>selected="selected"<?php }?>><?php echo $catego[1];?></option>
                    </select></td></tr></table>
                    <div id="get_top_piclogs">&nbsp;</div>
                </div>
            </div>
		</div>
    </header>
    <div id="container" align="center">
    	<div id="content" align="left">
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div id="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="150" valign="top" align="left" class="color" style="padding:10px;">
                        <div id="profile" align="center" style="width:155px !important;">
                            <div id="pic" align="center" onMouseOver="$('#updatepic').show();" onMouseOut="$('#updatepic').hide();">
                                <?php if(isset($_SESSION['pro_pic'])){?>
                                <img src="<?php echo $_SESSION['pro_pic'];?>" alt="Profile picture" id="pic_picture" />
                                <div id="updatepic" onMouseOver="$(this).show();">
                                	<a href="profile_pic" style="text-decoration:none; color:#FFF;">
                                	<img src="images/icons/pencil.png" id="updatep" alt="Update" title="Update" width="12" /> Change image</a>
                                </div>
                                <?php }else{?>
                                <img src="images/profile_no_pic.jpg" alt="Profile picture" />
                                <div id="updatepic" onMouseOver="$(this).show();">
                                	<a href="profile_pic" style="text-decoration:none; color:#FFF;">
                                	<img src="images/icons/pencil.png" id="updatep" alt="Update" title="Update" width="12" /> Upload image</a>
                                </div>
                                <?php }?>
                            </div>
                            <div id="display_name">
								<?php echo $_SESSION['fname'];?>
                            </div>
                            <div class="color" style="max-width:155px; height:10px;">&nbsp;</div>
                            <div id="info" style="min-height:260px;">
                                <iframe src="status_iframe.php" height="54" width="150" align="middle" allowtransparency="true" frameborder="0" scrolling="no"></iframe>
                                <div class="profile_links"><a href="my_profile/">My Profile</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/piclogs/">My Piclogs</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/activities/">My Activities</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/favorites/">Favorites (<span id="get_favorites">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/following/">Following (<span id="get_followings">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/followers/" style="color:#f7e410">Followers (<span id="get_followers">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="#invite-box" id="invite_friends">Invite Friends</a></div>
                                <div class="profile_links">&nbsp;</div>
                            </div>
                        </div>
                        </td>
                        <td valign="top" align="left" style="position:relative;">
						<div id="div_mask" style="position:absolute; top:45px; right:15px; z-index:99; width:20px; height:480px; background:#fff;">&nbsp;</div>
                        <input type="hidden" name="piclog_id" id="piclog_id" value="" />
                        <div id="recent_pic" style="height:480px; width:400px !important;">
                            <h2 align="left">Followers (<?php echo $count;?>)</h2><br />
                            <div id="mcs4_container">
                                <div class="customScrollBox">
                                    <div class="container">
                                        <div class="content">
                                            <?php 
                                            if($count == 0){?>
                                            <div align="center">
                                            	<img src="images/characters/my_followers.png" alt="You have '0' followers" />
                                            </div>
                                            <?php }else{
												
                                                while($cont = mysql_fetch_array($picfoll)){
													$follow = mysql_query("
													SELECT * FROM users INNER JOIN location ON location.uid = '".$cont[2]."' 
													WHERE users.uid = '".$cont[2]."'");
													$follo = mysql_fetch_array($follow);?>
                                            <div id="list" style="width:300px; height:50px;">
                                            <a href="/<?php echo $follo['username'];?>/" style="text-decoration:none;">
                                            <table width="300" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="50" align="center" valign="middle">
												<?php $pictur = mysql_query("SELECT picture FROM profile_pic WHERE uid = '$cont[2]'");
												$picture = mysql_fetch_array($pictur);
												 if($picture['picture'] != ''){?>
                                                <img src="<?php echo $picture['picture'];?>" alt="<?php echo $follo['full_name'];?>" width="40" height="40" />
                                                <?php }else{?><img src="images/icons/profile1.png" alt="<?php echo $follo['full_name'];?>" /><?php }?></td>
                                                <td width="5">&nbsp;</td>
                                                <td align="left" valign="top">
                                                <div class="text1" style="font-size:13px;" align="left">
                                                <a href="/<?php echo $follo['username'];?>/" style="text-decoration:none;">
                                                <span style="color:#333; text-transform:capitalize">
												<?php $vtitle = stripslashes($follo['full_name']);
                                                if(strlen($vtitle) > 35){
	                                                $vtitle = substr($vtitle, 0, 35) . "...";
                                                }
                                                echo '<strong>'.$vtitle.'</strong>';?></span><br />
                                                <span style="color:#333">
                                                <?php echo $follo['city'];
												$contry = mysql_query("SELECT * FROM country_codes WHERE con_id = '".$follo['country']."'");
                                        		$isso = mysql_fetch_array($contry);
												if($follo['city'] != '' && $follo['city'] != ' ' && $isso['country'] != ''){echo ', ';}
												echo stripslashes($isso['country']);?></span></a>
                                                </div>
                                                </td>
                                              </tr>
                                            </table></a></div>
                                            <?php }}?>
                                        </div>
                                    </div>
                                    <div class="dragger_container">
                                        <div class="dragger"></div>
                                    </div>
                                </div>
                            </div>
                        </div></td>
                      </tr>
                    </table>
                </div></td>
                
                <td align="right" valign="top" bgcolor="#FFFFFF" width="340">
                <?php include 'get/page_right.php';?>
                </td>
              </tr>
            </table>
		</div>
    </div>
	<?php include 'get/footer.php';?>
</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31359110-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
<?php include 'get/invite_pic.php';?>
