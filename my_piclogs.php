<?php
error_reporting(0);
session_start();

include'database/db.php';
//Clear the time stamp session and user file extension
$_SESSION['random_key']= "";
$_SESSION['user_file_ext']= "";
$_SESSION['thumbnail'] = "";

if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin.php';
}

$uname = $_SESSION['uname'];
$uid = $_SESSION['uid'];

$page_title = 'My Piclogs';
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
<!------------------------------------------------ delete piclog confirmation box start ------------------------------------------------------------>
<div id="mask" style="display:none">&nbsp;</div>
<div id="popup" style="display:none; height:130px; width:350px;">
    <div style="background:url(images/icons/title.gif) repeat-x; height:35px;">
        <a href="javascript:;" class="close" style="float:right; margin-right:20px; margin-top:-3px;">&nbsp;</a>
    </div>
    <div align="center" style="padding-left:10px;">
		<table width="100%"><tr>
			<td width="25%" align="center"><img src="images/icons/important.png" alt="Important" align="left" /></td>
			<td valign="middle" style="padding-left:10px;">Are you sure you want to delete your Piclog?<br /><br />
			<input type="button" id="popup_ok" value="Yes" /> 
			<input type="button" id="popup_cancel" value="No" /></td>
		</tr></table>
    </div>
</div>
<!----------------------------------------------- delete piclog confirmation box end --------------------------------------------------------------->
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
                                <div class="profile_links"><a href="my_profile">My Profile</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/piclogs/" style="color:#f7e410">My Piclogs</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/activities">My Activities</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/favorites">Favorites (<span id="get_favorites">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/following">Following (<span id="get_followings">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/followers">Followers (<span id="get_followers">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="#invite-box" id="invite_friends">Invite Friends</a></div>
                                <div class="profile_links">&nbsp;</div>
                            </div>
                        </div>
                        </td>
                        <td valign="top" align="left" style="position:relative;">
						<div id="div_mask" style="position:absolute; top:45px; right:15px; z-index:99; width:20px; height:480px; background:#fff;">&nbsp;</div>
                        <input type="hidden" name="piclog_id" id="piclog_id" value="" />
                        <div id="recent_pic" style="position:relative;">
                        <?php 
						$piclogs = mysql_query("SELECT thumb, title, write_up, piclog_url, category_id, upid FROM upload_piclog WHERE uid = '$uid' ORDER BY timestamp DESC");
						$count = mysql_num_rows($piclogs);?>
                            <h2 align="left">My Piclogs (<?php echo $count;?>)</h2>
                            <div align="center" style="position:absolute; top:10px; right:22px;">
                            	<a href="upload_pic" id="upload_pic_mp" <?php if($count == 0){?>title="Start Piclogging"<?php }else{?> title="Create New"<?php }?>>&nbsp;</a>
                            </div><br />
                            <div id="mcs4_container" style="height:460px !important;">
                                <div class="customScrollBox">
                                    <div class="container">
                                        <div class="content">
                                            <?php if($count == 0){
											$picloogs = mysql_query("SELECT thumb, title, write_up, piclog_url, upid FROM upload_piclog WHERE uid = '0' ORDER BY uid DESC");
											$contt = mysql_fetch_array($picloogs);?>
                                            <a href="piclog/<?php echo $contt['piclog_url'];?>" style="text-decoration:none; position:relative;">
                                			<img src="images/sample_stamp.png" alt="Sample Piclog" title="Sample Piclog" id="sample_piclog" />
											<table width="420" height="160" border="0" cellspacing="0" cellpadding="0" class="piclog-table" >
											  <tr>
												<th valign="middle" align="left" class="gradientbg pic_title">
                                                <a href="piclog/<?php echo $contt['piclog_url'];?>" style="text-decoration:none; color:#666">
												<?php $vtitle = stripslashes($contt['title']);
												if(strlen($vtitle) > 41) {
													$vtitle = substr($vtitle, 0, 41) . "...";
												}
												echo $vtitle;?></a>
												<div class="clear">&nbsp;</div>
												</th>
											  </tr>
											  <tr>
												<td><table width="420" border="0" cellspacing="0" cellpadding="0" class="helvetica_table">
												  <tr>
													<td width="170" height="130" valign="top" style="padding-top:7px;" >
													<div class="thumb" style="width:170px; height:130px;">
														<img src="<?php echo $contt['thumb'];?>" alt="Piclog picture" style="width:170px; height:130px; border:1px solid #ccc;" />
													</div></td>
													<td width="5">&nbsp;</td>
													<td width="245" align="left" valign="top" class="incontent">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
													  <tr>
														<td valign="top" style="height:120px; color:#585454;">
                                                        <a href="piclog/<?php echo $contt['piclog_url'];?>" style="text-decoration:none; color:#585454;">
														<div class="rec_text helvetica pic_title">
														<?php $vwrite_up = stripslashes(strip_tags($contt['write_up']));
														if(strlen($vwrite_up) > 170) {
															$vwrite_up = substr($vwrite_up, 0, 170) . "...";
														}
														echo $vwrite_up;?></div></a></td>
													  </tr>
													  <tr>
														<td><div style="background:url(images/starts/inactive_rating.png) no-repeat center; width:55px; height:9px;" align="left">
                                                        <?php for($k=1; $k<=4; $k++){
															echo '<img src="images/starts/star_active.png" alt="star active" style="margin-left:1px; margin-right:1px; float:left" />';
														}?>
														</div></td>
													  </tr>
													</table></td>
												  </tr>
												</table></td>
											  </tr>
											</table></a>
											<div class="clear" style="height:15px;">&nbsp;</div>
                                            <div align="center">
                                            	<img src="images/characters/my_piclogs.png" height="55%" alt="my piclog" /><br /><br /><br />
                                            </div>
                                            <?php }else{
                                                while($cont = mysql_fetch_array($piclogs)){?>
                                            		<a href="piclog/<?php echo $cont['piclog_url'];?>" style="text-decoration:none;" onmouseover="$('#delete<?php echo $cont['upid'];?>').stop().show();" onmouseout="$('#delete<?php echo $cont['upid'];?>').stop().hide();">
                                            <table width="420" height="160" border="0" cellspacing="0" cellpadding="0" class="piclog-table" style=" position:relative;">
											  <tr>
												<th valign="middle" align="left" class="gradientbg">
                                                <a href="piclog/<?php echo $cont['piclog_url'];?>" style="text-decoration:none; color:#666" onmouseover="$('#delete<?php echo $cont['upid'];?>').stop().show();" onmouseout="$('#delete<?php echo $cont['upid'];?>').stop().hide();">
												<?php $vtitle = stripslashes($cont['title']);
												if(strlen($vtitle) > 41) {
													$vtitle = substr($vtitle, 0, 41) . "...";
												}
												echo $vtitle;?></a>
                                                    <div class="clear">&nbsp;</div>
													<a href="javascript:;" class="delete" id="delete<?php echo $cont['upid'];?>" onClick="del('<?php echo $cont['upid'];?>')" title="Delete" style="display:none;">&nbsp;</a>
												</th>
                                            </tr>
											<tr>
												<td><table width="420" border="0" cellspacing="0" cellpadding="0" class="helvetica_table">
                                                  <tr>
                                                    <td width="170" height="130" valign="top" style="padding-top:7px;" >
                                                    <a href="piclog/<?php echo $cont['piclog_url'];?>" onMouseOver="$('#delete<?php echo $cont['upid'];?>').stop().show();" onMouseOut="$('#delete<?php echo $cont['upid'];?>').stop().hide();">
                                                    <div class="thumb" style="width:170px; height:130px;">
                                                    	<img src="<?php echo $cont['thumb'];?>" alt="Piclog picture" style="width:170px; height:130px;
                                                    border:1px solid #ccc;" />
                                                    </div></a></td>
                                                    <td width="5">&nbsp;</td>
                                                    <td width="245" align="left" valign="top" class="incontent">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td valign="top" style="height:120px; color:#585454;">
                                                        <a href="piclog/<?php echo $cont['piclog_url'];?>" style="text-decoration:none; color:#999" onMouseOver="$('#delete<?php echo $cont['upid'];?>').stop().show();" onMouseOut="$('#delete<?php echo $cont['upid'];?>').stop().hide();">
                                                        <div class="rec_text helvetica">
                                                        <?php $vwrite_up = stripslashes(strip_tags($cont['write_up']));
                                                        if(strlen($vwrite_up) > 210){
                                                                $vwrite_up = substr($vwrite_up, 0, 210) . "...";
                                                        }
                                                        echo $vwrite_up;?></div></a></td>
                                                      </tr>
                                                      <tr>
                                                        <td><div style="background:url(images/starts/inactive_rating.png) no-repeat center; width:55px; height:9px; float:left; margin-top:4px;" align="left">
                                                        <?php $rat = mysql_query("SELECT top FROM ratings WHERE upid = '".$cont['upid']."' ORDER BY timestamp DESC");
                                                        $rate = mysql_fetch_row($rat);
                                                        for($i=1; $i<=$rate[0]; $i++){
                                                            echo '<img src="images/starts/star_active.png" alt="star active" style="margin-left:1px; margin-right:1px; float:left" />';
                                                        }?></div>
														<?php $catea = mysql_query("SELECT * FROM category WHERE cat_id = ".$cont['category_id']."");
														$cata = mysql_fetch_array($catea);?>
														<div align="right" style="color:#666; font-size:12px; float:right; width:100px;"><?php echo $cata['category'];?></div></td>
                                                      </tr>
                                                	</table></td>
                                                  </tr>
                                                </table></td>
											  </tr>
											</table></a>
                                            <div class="clear">&nbsp;</div>
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
