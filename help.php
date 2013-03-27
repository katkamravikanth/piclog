<?php
error_reporting(0);
session_start();
//Clear the time stamp session and user file extension
$_SESSION['random_key']= "";
$_SESSION['user_file_ext']= "";

include'database/db.php';

if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin2.php';
}

$page_title = 'Help';
include_once 'get/header.php';
?>
<link rel="stylesheet" type="text/css" href="css/enter_styles.css" />
<script type="text/javascript" src="js/jquery_ravikanth_script.js"></script>

<style type="text/css">
p, li {
	font-family:Tahoma, Geneva, sans-serif !important;
	font-size:15px !important;
}
header #header #right #piclogs {
	top:10px !important;
}
#get_top_piclogs .more1 {
	 padding-bottom:10px !important;
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
                	<table style="margin-top:-10px;"><tr><td class="title">Top Rated Piclogs</td><td style="height:45px;" valign="top">
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
    	<div id="content" align="justify">
            <h2 style="padding-top:10px;">FREQUENTLY ASKED QUESTIONS (FAQs)</h2>
            <p>&nbsp;</p>
            
            <h4>1 &nbsp; &nbsp; How do I sign up?<br /></h4>
            <p>You can directly click on the "Sign Up" button on the home page and create your Piclog account. Alternatively, you can also "Log In with Facebook" using your Facebook Account details.</p>
            <p>&nbsp;</p>
            
            <h4>2 &nbsp; &nbsp; Can I access Piclog using my Facebook account login details?<br /></h4>
            <p>Yes, you can. If you do not have an FB account, you can "Sign Up" and create your new Piclog Account.</p>
            <p>&nbsp;</p>
            
            <h4>3 &nbsp; &nbsp; Is it secure to use my Facebook login details on Piclog?<br /></h4>
            <p>Yes, it's completely secure. If you do "Log In" with your Facebook (FB) Account details, you can be rest assured that Piclog will not have access to your FB Password or any other sensitive information connected to your FB account. On your approval, we will only ask for your Name, Date of Birth, City and Email ID from Facebook.</p>
            <p>&nbsp;</p>
            
            <h4>4 &nbsp; &nbsp; How can I Follow or Un-follow other Picloggers?<br /></h4>
            <p>Search for your friends using the Search box and go to their profile. Click on the "Follow Me" Icon, placed on their Profile. Voila! You can now start following your friend. Click on the same icon to Un-follow.</p>
            <p>&nbsp;</p>
            
            <h4>5 &nbsp; &nbsp; Where are the Privacy & Email Notification Settings for my account and how can I manage them?<br /></h4>
            <p>To go to your Privacy Settings, click on the "Settings" icon placed on the top-right of the screen. This will open a page where you can change the Privacy Settings for your account. This option contains a group of control settings for your Piclog Account – authorization to follow you, information that you would want to share or hide on your Profile, etc. We will keep enhancing the controls you will have on your profile to make sure you have a great Picloggin’ experience. Alternatively, you can get information of any new "Setting" options from the PicTable tab at the bottom of the page.</p>
            <p>&nbsp;</p>
            
            <h4>6 &nbsp; &nbsp; Can I select specific audience for a Piclog that I wish to share?<br /></h4>
            <p>Yes. While creating a New Piclog, you can always select specific audience by choosing from the drop-down options under the sub-head "Publish". You can share your Piclog with "All" (any Piclogger across the website can view your Piclog), with "Followers only" (only Picloggers who are following you will be able to view your Piclog) or "Self" (only you will be able to view your Piclog; this will not show up anywhere on the website)</p>
            <p>&nbsp;</p>
            
            <h4>7 &nbsp; &nbsp; How do I add or edit any of my profile information?<br /></h4>
            <p>You can click on the "My Profile" option below the Display picture. This will open your profile information page and by clicking on the "Edit" icon, placed on the top-right of the page, you can add or edit your profile information. Once the information is updated, click on the "Save" icon.</p>
            <p>&nbsp;</p>
            
            <h4>8 &nbsp; &nbsp; What's a Username?<br /></h4>
            <p>A Username is different from your Display Name. It is used to "Sign In" into the website only. Usernames are unique and will help us identify you.</p>
            <p>&nbsp;</p>
            
            <h4>9 &nbsp; &nbsp; How do I change my Username?<br /></h4>
            <p>Clicking on the "Settings" icon, on the top-right of the screen, will open a page where you can find Account Settings and the Username. You can replace your existing Username with a new one and confirm your password to save the same. Please note that Usernames are unique. Hence, if a Username given by you already exists, you will be prompted to try another option. Also note that a Username once changed, may or may not be available in the future.</p>
            <p>&nbsp;</p>
            
            <h4>10 &nbsp; &nbsp; How can I invite a friend to Piclog?<br /></h4>
            <p>Click on the Invite Friends Tab, placed on the left side of the screen, and you'll have 3 options for the same: Invite friends from Facebook, Invite all your contacts from Gmail or enter an individual Email ID to send an invite.</p>
            <p>&nbsp;</p>
            
            <h4>11 &nbsp; &nbsp; Can I authorize people before they can start following me?<br /></h4>
            <p>Yes. This option is open by default. Anyone on the website can follow you by default. However, if you wish to give an authorization before someone can follow you, you can click on the “Settings” icon and select the “Privacy” tab on the left. This will show up various privacy options including authorization of followers. Once you check the Authorize box, only people you authorize will be able to follow you.</p>
            <p>&nbsp;</p>
            
            <h4>12 &nbsp; &nbsp; Is it necessary to upload an image and then add a write up?<br /></h4>
            <p>Yes, it is essential to upload an image and then add a write up. Piclog is a combination of Pictures and Words; it's the essence of the website. Hence, every Piclog should comprise an image and a write up.</p>
            <p>&nbsp;</p>
            
            <h4>13 &nbsp; &nbsp; How do I add a Piclog?<br /></h4>
            <p>After you "Sign In", click on the "Create New" icon. This will take you to a new page where you can choose &amp; upload an image from your computer, create a custom thumbnail; if required, select a Piclog category, add image courtesy, include headline, write your blog in the write up box, select publishing option and submit. Your Piclog will then be added to your "My Piclogs" tab and will reflect in the PicWorld section, where all the recent Piclogs (only the ones that are “Published to all”) across the website show up.</p>
            <p>&nbsp;</p>
            
            <h4>14 &nbsp; &nbsp; Can I share Piclogs across other Networking Websites?<br /></h4>
            <p>Yes. At the moment you can share Piclogs across Facebook and Twitter only. But soon we’ll have the options to share the Piclogs on various other Networking websites as well.</p>
            <p>&nbsp;</p>
            
            <h4>15 &nbsp; &nbsp; Is there any specific size for the image to be uploaded?<br /></h4>
            <p>Yes. The maximum size of an image you can upload is 10 MB. But we are working on increasing this size.</p>
            <p>&nbsp;</p>
            
            <p>Didn't get what you're looking for? Please do send in your queries to help@piclog.in. Our team will be more than happy to help you.</p>
            <p>&nbsp;</p>
   		</div>
    </div>
	<footer>
    	<div id="foot">
        	<a href="tat/">Take a Tour</a> &nbsp; | &nbsp; <a href="pictable/">PicTable</a> &nbsp; | &nbsp; <a href="about/">About Us</a> &nbsp; | &nbsp; <!--<a href="press/">Press</a> &nbsp; | &nbsp; --><a href="terms/">T&amp;C</a> &nbsp; | &nbsp; <a href="privacy/">Privacy Policy</a> &nbsp; | &nbsp; <a href="help/" style="color:#FFF">Help</a>
		</div>
	</footer>
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
