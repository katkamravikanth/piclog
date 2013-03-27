<?php
error_reporting(0);
session_start();

$_SESSION['uid'] = '';
$_SESSION['myid'] = '';
$_SESSION['uname'] = '';
$_SESSION['fname'] = '';
$_SESSION['uemail'] = '';
$_SESSION['pic_fb'] = '';
$_SESSION['logout'] = '';

session_destroy();
$cookie_name = 'siteAuth';
if(isSet($cookie_name)){
  // Check if the cookie exists
	if(isSet($_COOKIE[$cookie_name])){
		setcookie ($cookie_name, '', time()-1);
	}
}
header("Location: /login/");
?>
