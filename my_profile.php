<?php
error_reporting(0);
session_start();

include'database/db.php';

if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin.php';
}

$page_title = 'My Profile';
include_once 'get/header.php';
?>
<link rel="stylesheet" type="text/css" href="css/profile_styles.css" />
<script type="text/javascript" src="js/jquery_ravikanth_script.js"></script>

<style type="text/css">
.text_box {
	display:none;
}
#age {
	color:#F30;
	font-size:12px;
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
                                	<a href="profile_pic/" style="text-decoration:none; color:#FFF;">
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
                                <div class="profile_links"><a href="my_profile" style="color:#f7e410">My Profile</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/piclogs/">My Piclogs</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/activities">My Activities</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/favorites">Favorites (<span id="get_favorites">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/following">Following (<span id="get_followings">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="<?php echo $_SESSION['uname']; ?>/followers">Followers (<span id="get_followers">&nbsp;</span>)</a></div>
                                <div class="profile_links"><a href="#invite-box" id="invite_friends">Invite Friends</a></div>
                                <div class="profile_links">&nbsp;</div>
                            </div>
                        </div>
                        </td>
                        <td valign="top" align="left">
                        <iframe src="my_profile_iframe.php" height="510" width="430" frameborder="0" allowtransparency="true" scrolling="no" style="padding-left:20px;"></iframe>
                        </td>
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
