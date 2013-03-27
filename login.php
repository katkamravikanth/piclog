<?php
error_reporting(0);
# start a new PHP session
session_start();
include'database/db.php';

if(!$_SESSION['uname'] || !$_SESSION['myid']){
  include_once 'autologin1.php';
}else{
	header("Location: /".$_SESSION['uname']);
}

	// we need to know it
	$CURRENT_URL = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	
	// change the following paths if necessary 
	$config   = dirname(__FILE__) . '/hybridauth/config.php';
	require_once( "hybridauth/Hybrid/Auth.php" );

	try{
		$hybridauth = new Hybrid_Auth( $config );
	}
	catch( Exception $e ){
		echo "Ooophs, we got an error: " . $e->getMessage();
	}

	$provider = ""; 
	
	// handle logout request
	if(isset($_GET["logout"])){
		$provider = $_GET["logout"];

		$adapter = $hybridauth->getAdapter($provider);

		$adapter->logout();
		session_destroy();
		$cookie_name = 'siteAuth';
		if(isSet($cookie_name)){
			// Check if the cookie exists
			if(isSet($_COOKIE[$cookie_name])){
				setcookie ($cookie_name, '', time()-1);
			}
		}
		header( "Location: login"  );
		
		die();
	}

	// if the user select a provider and authenticate with it 
	// then the widget will return this provider name in "connected_with" argument 
	elseif(isset($_GET["connected_with"]) && $hybridauth->isConnectedWith($_GET["connected_with"])){
		$provider = $_GET["connected_with"];
		
		$adapter = $hybridauth->getAdapter( $provider );
		
		$user_data = $adapter->getUserProfile();

		$check = mysql_query("SELECT username, uid, email, full_name FROM users WHERE email = '".$user_data->email."'");
		$usid = mysql_fetch_array($check);
		$count = mysql_num_rows($check);
		
		if($count == 0){
			$uname = strtolower(str_replace(" ","_",str_replace("'","",$user_data->displayName)));
			$_SESSION['uname'] = $uname;
			$_SESSION['pic_fb'] = $user_data->photoURL;
			if( $user_data->email ){
				$_SESSION['uemail'] = $user_data->email; 
			}else{
				$_SESSION['uemail'] = ''; 
			}
			$_SESSION['logout'] = $adapter->id;
			
			function randomPrefix($length){ 
				$random= "";
				srand((double)microtime()*1000000);
				$data = "AbcDE123IJKLMN67QRSTUVWXYZ"; 
				$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz"; 
				$data .= "0FGH45OP89";
				for($i = 0; $i < $length; $i++){ 
					$random .= substr($data, (rand()%(strlen($data))), 1); 
				}
				return $random; 
			}
			$pass = randomPrefix(10);
			$_SESSION['fname'] = $name = addslashes($user_data->displayName);
			$passi = md5($pass);
			$loc = explode(", ", $user_data->currentLocation);
			$city = $loc[0];
			$country = $loc[1];
			
			$phone_code = mysql_query("SELECT * FROM country_codes WHERE country = '$country'");
			$pcode = mysql_fetch_row($phone_code);
			$code = $pcode[3];
			if($country != ''){
				$iso_code = mysql_query("SELECT con_id FROM country_codes WHERE country = '$country'");
				$iso = mysql_fetch_row($iso_code);
				$country = $iso[2];
			}else{
				$country = 94;
			}
			
			$dob = $user_data->birthDay.'/'.$user_data->birthMonth.'/'.$user_data->birthYear;
			$gender = ucwords($user_data->gender);
			mysql_query("INSERT users VALUES ('', '$name', '$dob', '$gender', '$code', '".$user_data->phone."', '".$user_data->email."', '$uname', '$passi')");
			
			$id = mysql_insert_id();
			$_SESSION['uid'] = $id;
			$_SESSION['myid'] = $id;
			//mysql_query("INSERT profile_pic VALUES ('','$id','".$user_data->photoURL."')");
			mysql_query("INSERT location VALUES ('','$id','','$city','','$country')");
			mysql_query("INSERT activation VALUES ('','$id','','','Agree','Active')");
			mysql_query("INSERT settings_profile VALUES ('', '$id', 'hide', 'hide', 'hide', 'hide', 'no')");
			mysql_query("INSERT settings_notifications VALUES ('', '$id', 'send', 'send', 'send', 'send', 'send', 'send')");
			
			$subject = "Default Username and Password for your Piclog Account";
			
			$message = "<html><body>Hello $name, <br /><br />
			Thank you for Signing up using your Facebook account details. We’ve however, created a default Username and Password for your Piclog account. Please find the same below:
			<br /><br />
			
			Username: $uname <br />
			Password: $pass <br /><br />
			
			Henceforth, you can either “Login from Facebook,” using your Facebook account details or you can “Login,” using your default Piclog account details.<br />
			Please note that you can always change your default Piclog account details from the “Settings” tab on your profile.<br />
			
			For any further assistance, feel free to send in an email to us on help@piclog.in<br /><br />
			
			Thanks, <br />
			Team – Piclog <br /><br /></html></body>";
			$headers = "From: Piclog Admin <admin@piclog.in>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			mail($user_data->email, $subject ,$message, $headers);
			header("Location: profile/fb");
		}else{
			$propic = mysql_query("SELECT picture FROM profile_pic WHERE uid = '".$usid['uid']."'");
			$prof = mysql_fetch_row($propic);
			
			$sta = mysql_query("SELECT status FROM about WHERE uid = '".$usid['uid']."'");
			$stat = mysql_fetch_row($sta);
			
			$_SESSION['status'] = $stat[0];
			$_SESSION['pro_pic'] = $prof[0];
			$_SESSION['uid'] = $usid['uid'];
			$_SESSION['myid'] = $usid['uid'];
			$_SESSION['uname'] = $usid['username'];
			$_SESSION['fname'] = $usid['full_name'];
			$_SESSION['uemail'] = $user_data->email;
			//$_SESSION['pic_fb'] = $user_data->photoURL;
			$_SESSION['logout'] = $adapter->id;

			// include authenticated user view
			header("Location: /".$_SESSION['uname']."/");
		}
		
		die();
	} // if user connected to the selected provider 

	// if not, include unauthenticated user view
	include "unauthenticated_user.php";
