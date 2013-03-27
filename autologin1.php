<?php
error_reporting(0);

$cookie_name = 'siteAuth';

if(isSet($cookie_name)){
  $cookie_name = 'siteAuth';
	// Check if the cookie exists
	if(isSet($_COOKIE[$cookie_name])){
		parse_str($_COOKIE[$cookie_name]);
		
		$username = $usr;
		$password = $hash;
		
		$get = mysql_query("SELECT username, password, uid, email, full_name FROM users WHERE username = '$username' AND password = '$password'");
		$count = mysql_num_rows($get);
		$rec = mysql_fetch_row($get);
		// Make a verification
		if($count != 0){
			// Register the session
			$sta = mysql_query("SELECT status FROM about WHERE uid = '".$rec[2]."'");
			$stat = mysql_fetch_row($sta);
			$_SESSION['status'] = $stat[0];
			
			$propic = mysql_query("SELECT picture FROM profile_pic WHERE uid = '".$rec[2]."'");
			$prof = mysql_fetch_row($propic);
			$_SESSION['pro_pic'] = $prof[0];
			
			$_SESSION['uid'] = $rec[2];
			$_SESSION['myid'] = $rec[2];
			$_SESSION['uname'] = $rec[0];
			$_SESSION['fname'] = $rec[4];
			$_SESSION['uemail'] = $rec[3];
			header("Location:profile.php");
		}
	}
}
?>
