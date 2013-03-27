<?php
error_reporting(0);
session_start();
include'database/db.php';

if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin1.php';
}else{
	header("Location: /".$_SESSION['uname']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Piclog</title>
<link rel="shortcut icon" href="images/fevicon.png" />
<script type="text/javascript">
var _gaq = _gaq || [];
var base = location.href;
var url = location.href.substring(base.length, location.href.length);
if(!location.hash) location.href = '#/' + url;
</script>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<link rel="stylesheet" type="text/css" href="css/en.css" />
<noscript><link rel="stylesheet" type="text/css" href="css/noscript.css" /></noscript>
<script type="text/javascript" src="js/html5shiv.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery_ravikanth_js.js"></script>
<link href="css/jquery.reject.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.reject.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
<style>
#opacity {
	width:100%;
	margin:0 auto;
	height:250px;
	position:absolute;
	top:248px;
	z-index:999;
}
</style>
</head>

<body>
<div id="layout" style="padding-top:40px; height:600px !important; position:relative;">
    <div id="header1">&nbsp;</div>
	<header>
    	<div id="header">
            <div class="logo">
            	<a href="http://www.piclog.in"><img id="piclog" src="images/logo1.png" alt="piclog" style="position:relative; z-index:111;" /></a>
            </div>
		</div>
    </header>
	<div id="opacity" align="center">
		<div style="background-color:#fff; width:100%; height:220px; position:relative; z-index:999;">&nbsp;</div>
		<div style="background-color:#fff; width:64%; height:63px; position:absolute; right:0px; z-index:999;">&nbsp;</div>
	</div>
	<div class="bg_black" style="z-index: 2; overflow-y:visible !important">
		<div class="glare">
			<div id="loading" style="display:none">
				<div class="none">
					<img src="images/home/arrow.png" alt="arrow" />
				</div>
				<img id="ball" src="images/home/ball.png" alt="ball" style="display:none" />
				<div id="logo"></div>
			</div>
			<div id="home">
				<div id="home_nav_1">
					<div id="home_nav_2">
						<div id="home_nav_3">
							<div id="home_text">
								<img id="speaker" src="images/home/speaker.png" alt="speaker" />
								<img id="a" src="images/home/a.png" alt="a" />
								<img id="picture" src="images/home/picture.png" alt="pictures" />
								<img id="speaks" src="images/home/speaks.png" alt="speaks" />
								<img id="a1" src="images/home/a.png" alt="a" />
								<img id="thousend" src="images/home/thousand_words.png" alt="thousend words" />
								<img id="more" src="images/home/lets_add_a_few_more.png" alt="let's add a few more" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="footer" align="center">
    	<div id="foot">
        	<div style="padding-left:10px; height:50px;"><img src="images/home/click.png" alt="click" /></div>
            <div style="padding-left:110px; height:50px;"><img src="images/home/blog.png" alt="blog" /></div>
            <div style="padding-left:170px; padding-top:7px;">
            <div align="center" style="background:#fff; width:300px; float:left"><img src="images/home/connect.png" alt="connect" /></div>
            <div align="right" style="float:right"><a href="login" id="enter" style="position:absolute; top:65px;">&nbsp;</a></div>
            </div>
            <div style="position:absolute; bottom:-42px; left:0; width:100%; height:42px; z-index:-1; background-color:#000000;">&nbsp;</div>
		</div>
	</div>
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
