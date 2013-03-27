<?php
error_reporting(0);
session_start();
include'database/db.php';
if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin2.php';
}
//Clear the time stamp session and user file extension
$_SESSION['random_key']= "";
$_SESSION['user_file_ext']= "";

$page_title = 'About';
include_once 'get/header.php';
?>
<link rel="stylesheet" type="text/css" href="css/enter_styles.css" />
<script type="text/javascript" src="js/jquery_ravikanth_script.js"></script>

<style type="text/css">
html, body {
	overflow-y:auto;
}
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
           	<h2 style="padding-top:10px;">About</h2>
			<p>&nbsp;</p>
            
			<p><strong>HI! WE'RE PICLOG:</strong><br /></p>
			<p>Welcome to Piclog; the world's first Creative Networking website that thrives on two significant facets of imagination - Photography & Blogging. This is where pictures speak… more; fuel your pictures with the magic of words or lace some great thoughts around visually inspiring images, the stage is yours!</p>
			<p>&nbsp;</p>
			
            <p><strong>Click, Blog and Connect with a whole new world of Picloggers.</strong></p>
			<p>&nbsp;</p>
			
            <p><strong>CLICK: </strong><br /></p>
			<p>You may be an amateur or a pro behind the lens; but that's not important. What matters is the still you capture.</p>
			<p>&nbsp;</p>
            
			<p><strong>BLOG:</strong><br /></p>
			<p>You may be a writer or a poet; but how you weave the magic of words around a visual inspiration makes the difference.</p>
			<p>&nbsp;</p>
            
			<p><strong>CONNECT:</strong><br /></p>
			<p>What's more? We give your creative expression the freedom to connect; connect with the world out there!</p>
			<p>&nbsp;</p>
            
			<p><strong>KNOW MORE:</strong><br /></p>
			<p>So, no one's ever asked what's your take on a subject? Or what's your perception like? Okay. But did you ever voice out what matters to you? What you like, what you don't, what's cool, what's not? Perhaps, you did… but not the Piclog way!</p>
			<p>&nbsp;</p>
            
			<p>Piclog is a unique platform that attempts to raise the bar of traditional blogs; it allows you to innovate, share and evolve. With categories so diverse, you get to write, visualize and express anything under the Sun. Preserve your favourite work, share your thoughts with fellow Picloggers or just connect; the platform is right here.</p>
			<p>&nbsp;</p>
            
			<p><strong>Time to lace your thoughts with the power of creative communication; time to Piclog!!</strong></p>
			<p>&nbsp;</p>
   		</div>
    </div>
	<footer>
    	<div id="foot">
        	<a href="tat/">Take a Tour</a> &nbsp; | &nbsp; <a href="pictable/">PicTable</a> &nbsp; | &nbsp; <a href="about/" style="color:#FFF">About Us</a> &nbsp; | &nbsp; <!--<a href="press/">Press</a> &nbsp; | &nbsp; --><a href="terms/">T&amp;C</a> &nbsp; | &nbsp; <a href="privacy/">Privacy Policy</a> &nbsp; | &nbsp; <a href="help/">Help</a>
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
