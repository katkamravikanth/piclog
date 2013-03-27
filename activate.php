<?php
error_reporting(0);
session_start();
include'database/db.php';
if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin1.php';
}else{
	header("Location: ".$_SESSION['uname']);
}
if(isset($_GET['code']) && $_GET['code'] != ''){
	$code = $_GET['code'];
	$activate = mysql_query("SELECT uid FROM activation WHERE activation_code = '$code'");
	$count = mysql_num_rows($activate);
	if($count != 0){
		$login = mysql_fetch_row($activate);
		
		mysql_query("UPDATE activation SET status = 'Active' WHERE activation_code = '$code'");
		
		$get = mysql_query("SELECT users.username, users.uid, users.email, users.full_name FROM users INNER JOIN activation ON activation.uid = users.uid WHERE users.uid = '".$login[0]."'");

		$count = mysql_num_rows($get);
		$rec = mysql_fetch_array($get);
		
		$sta = mysql_query("SELECT status FROM about WHERE uid = '".$rec['uid']."'");
		$stat = mysql_fetch_row($sta);
		$_SESSION['status'] = $stat[0];
		
		$propic = mysql_query("SELECT picture FROM profile_pic WHERE uid = '".$rec['uid']."'");
		$prof = mysql_fetch_row($propic);
		$_SESSION['pro_pic'] = $prof[0];
		
		$_SESSION['uid'] = $rec['uid'];
		$_SESSION['myid'] = $rec['uid'];
		$_SESSION['uname'] = $rec['username'];
		$_SESSION['fname'] = $rec['full_name'];
		$_SESSION['uemail'] = $rec['email'];
		header("Location: profile/active");
	}
}

$page_title = 'Activate your Piclog account';
include_once 'get/header.php';
?>
<link rel="stylesheet" type="text/css" href="css/enter_styles.css" />
<script type="text/javascript" src="js/jquery_ravikanth_activate.js"></script>

<style type="text/css">
html, body {
	overflow-y:auto !important;
}
header #header #right #piclogs {
	top:10px !important;
}
</style>

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
                <td><div id="left" style="min-height:340px;">
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>Your activation link has expired.</p>
                    <p>&nbsp;</p>
                    <p>To re-activate your Piclog account, please enter your Username <br>
                    <p>&nbsp;</p>
                    <div id="error" style="display:none">&nbsp;</div>
                    <input type="text" name="username" id="username" />
                    <input type="button" name="resend" id="resend" value="  Send  " /></p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
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
