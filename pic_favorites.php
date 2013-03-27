<?php
error_reporting(0);
session_start();
include'database/db.php';

if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin2.php';
}
if($_GET['piclogger'] == '' || $_SESSION['uname'] == $_GET['piclogger']){
	include 'my_favorites.php';
}else{
$geid = mysql_query("SELECT uid, username FROM users");
$gcont = mysql_num_rows($geid);
while ($gid = mysql_fetch_row($geid)){
	if(md5($gid[0]) == $_GET['piclogger']){
		$_SESSION['getuid'] = $uid = $gid[0];
		header("Location: /".$gid[1]."/favorites/");
		break;
	}
}
$username = $_GET['piclogger'];
$user = mysql_query("SELECT * FROM users INNER JOIN location  ON location.uid = users.uid WHERE users.username = '".$username."'");
$users = mysql_fetch_array($user);
$num = mysql_num_rows($user);

$_SESSION['getuid'] = $uid = $users['uid'];

$status = mysql_query("SELECT status FROM about WHERE uid = '".$uid."'");
$stat = mysql_fetch_array($status);

$propic = mysql_query("SELECT picture FROM profile_pic WHERE uid = '".$uid."'");
$prof = mysql_fetch_array($propic);

$usid = $_SESSION['myid'];

$followings = mysql_query("SELECT * FROM followers WHERE uid = '".$uid."' AND fuid = '".$usid."' AND authorized = 'yes'");
$follow = mysql_num_rows($followings);

$folowings = mysql_query("SELECT authorized FROM followers WHERE uid = '".$uid."' AND fuid = '".$usid."'");
$folow = mysql_fetch_array($folowings);

$set = mysql_query("SELECT * FROM settings_profile WHERE uid = '".$uid."'");
$sett = mysql_fetch_array($set);

//sessions
$_SESSION['pic_picture'] = $prof['picture'];
$_SESSION['pic_full_name'] = stripslashes($users['full_name']);
$_SESSION['pic_status'] = stripslashes($stat['status']);

$piclogs = mysql_query("SELECT * FROM favorites f INNER JOIN upload_piclog u ON u.upid = f.upid WHERE f.uid = '".$uid."' 
						AND u.publish = 'Publish to All' ORDER BY f.timestamp DESC");
$count = mysql_num_rows($piclogs);

$page_title = $_SESSION['pic_full_name'];
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

<?php if(!isset($_SESSION['uname'])){?>
<style type="text/css">
html, body {
	overflow-y:auto !important;
}
#recent_piclogs {
	min-height:540px !important;
}
</style>
<?php }else{?>
<style type="text/css">
html, body {
	overflow-y:auto !important;
}
</style>
<?php }?>

<body>
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
                            <div id="pic" align="center">
                                <?php if($_SESSION['pic_picture'] != ''){?>
                                <img src="<?php echo $_SESSION['pic_picture'];?>" alt="Profile picture" id="pic_picture" />
                                <?php }else{?>
                                <img src="images/profile_no_pic.jpg" width="100%" alt="Profile picture" />
                                <?php }?>
                            </div>
                            <div id="display_name">
								<?php echo $_SESSION['pic_full_name'];?>
                            </div>
                            <div class="color" style="max-width:155px; height:10px;">&nbsp;</div>
                            <div id="info">
                                <div class="status"><?php if($_SESSION['pic_status'] == ''){ echo 'Status not updated';}else{ echo $_SESSION['pic_status'];}?></div>
                                <div class="profile_links">
                                <a href="/<?php echo $_GET['piclogger'];?>/">Profile</a></div>
                                <div class="profile_links"><a href="<?php echo $_GET['piclogger'];?>/piclogs/">Piclogs</a></div>
                                <div class="profile_links"><a href="<?php echo $_GET['piclogger'];?>/favorites/" style="color:#f7e410">
                                	Favorites (<span id="get_us_favorites">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="<?php echo $_GET['piclogger'];?>/following/">
                                	Following (<span id="get_us_followings">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="<?php echo $_GET['piclogger'];?>/followers/">
                                	Followers (<span id="get_us_followers">&nbsp;</span>)</a></div>
                                <div class="profile_links">&nbsp;</div>
                            </div>
                        </div>
                        </td>
                        <td valign="top" align="left" style="position:relative;">
						<div id="div_mask" style="position:absolute; top:45px; right:15px; z-index:99; width:20px; height:480px; background:#fff;">&nbsp;</div>
                        <input type="hidden" name="piclog_id" id="piclog_id" value="<?php echo $uid;?>" />
                        <div id="recent_pic" style="height:480px; width:400px !important;">
                            <h2 align="left">Favorites (<?php echo $count;?>)</h2><br />
                            <div id="mcs4_container">
                                <div class="customScrollBox">
                                    <div class="container">
                                        <div class="content">
                                            <?php 
                                            if($count == 0){?>
                                            <div align="center">
                                            	<img src="images/characters/favorites.png" alt="'0' favourites" />
                                            </div>
                                            <?php }else{
												
                                                while($cont = mysql_fetch_array($piclogs)){
													$favor = mysql_query("SELECT DISTINCT * FROM upload_piclog u INNER JOIN 
													users us ON us.uid = u.uid WHERE u.upid = '".$cont['upid']."' AND u.publish = 'Publish to All' 
													ORDER BY u.timestamp DESC");
													$fcont = mysql_num_rows($favor);
													if($fcont != 0){
													$fav = mysql_fetch_array($favor);?>
                                                    <div id="list" style="width:350px; height:55px;">
                                                    <a href="piclog/<?php echo $fav['piclog_url'];?>/" style="text-decoration:none;">
                                                    <table width="350" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="70" align="left">
                                                        <?php if($fav['thumb'] != ''){?>
                                                        <img src="<?php echo $fav['thumb'];?>" alt="Piclog picture" width="50" align="left" style="border:1px solid #ccc;" />
                                                        <?php }else{?>
                                                        <img src="images/pic_img.png" alt="Piclog picture" align="left" />
                                                        <?php }?></td>
                                                        <td align="left">
                                                        <div class="text1" style="font-size:13px;" align="left">
                                                        <a href="piclog/<?php echo $fav['piclog_url'];?>/" style="text-decoration:none;">
                                                        <span class="uname" style="color:#333;">
                                                        <?php $vtitle = stripslashes($fav['title']);
                                                        if(strlen($vtitle) > 35){
                                                                $vtitle = substr($vtitle, 0, 35) . "...";
                                                        }
                                                        echo '<strong>'.$vtitle.'</strong>';?></span><br />
                                                        <span style="color:#666">
                                                        <?php $vwrite_up = stripslashes(strip_tags($fav['write_up']));
                                                        if(strlen($vwrite_up) > 40) {
                                                                $vwrite_up = substr($vwrite_up, 0, 40) . "...";
                                                        }
                                                        echo $vwrite_up;?></span><br>
                                                        <a href="<?php if($_SESSION['myid'] != $fav['uid']){?>
                                                        /<?php echo $fav['username'];
														}else{?>my_profile<?php }?>/" class="username">
														<?php $vfullname = stripslashes($fav['full_name']);
                                                        if(strlen($vfullname) > 40) {
                                                                $vfullname = substr($vfullname, 0, 40) . "...";
                                                        }
                                                        echo $vfullname.'</a>';
														$rate = mysql_query("SELECT top FROM ratings WHERE upid = '".$fav['upid']."' ORDER BY timestamp DESC");
														$rated = mysql_fetch_array($rate);?>
                                                        <div style="background:url(images/starts/inactive_rating.png) no-repeat center; width:55px; height:9px;" align="left">
                                                        <?php for($i=1; $i<=$rated['top']; $i++){
                                                            echo '<img src="images/starts/star_active.png" alt="star active" style="margin-left:1px; margin-right:1px; float:left" />';
                                                        }?></div>
                                                        </div></td>
                                                      </tr>
                                                    </table>
                                                    </a></div>
												<?php }}
											}?>
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
<?php }?>
