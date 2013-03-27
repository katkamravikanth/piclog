<?php
error_reporting(0);
session_start();

include'database/db.php';

$auth = $_GET['auth'];
$fuser = $_GET['fuser'];
$user = $_GET['user'];

//logged in user
$get = mysql_query("SELECT users.username, users.uid, users.email, users.full_name FROM users INNER JOIN activation ON activation.uid = users.uid WHERE users.username = '".$fuser."' AND activation.status = 'Active'");

$count = mysql_num_rows($get);
$rec = mysql_fetch_array($get);

$mrec = mysql_fetch_array(mysql_query("SELECT users.username, users.uid, users.email, users.full_name FROM users INNER JOIN activation ON activation.uid = users.uid WHERE users.username = '".$user."' AND activation.status = 'Active'"));

if($count != 0){
  
	if($auth == 'yes'){
		mysql_query("UPDATE followers SET authorized = '$auth' WHERE uid = '".$mrec['uid']."' AND fuid = '".$rec['uid']."' AND authorized = 'no'");
		
		$sta = mysql_query("SELECT status FROM about WHERE uid = '".$mrec['uid']."'");
		$stat = mysql_fetch_row($sta);
		$_SESSION['status'] = $stat[0];
		
		$propic = mysql_query("SELECT picture FROM profile_pic WHERE uid = '".$mrec['uid']."'");
		$prof = mysql_fetch_row($propic);
		$_SESSION['pro_pic'] = $prof[0];
		
		$_SESSION['uid'] = $rec['uid'];
		$_SESSION['myid'] = $rec['uid'];
		$_SESSION['uname'] = $rec['username'];
		$_SESSION['fname'] = $rec['full_name'];
		$_SESSION['uemail'] = $rec['email'];
		
		$recus = mysql_fetch_array(mysql_query("SELECT users.username, users.uid, users.email, users.full_name FROM users INNER JOIN activation ON activation.uid = users.uid WHERE users.username = '".$fuser."' AND activation.status = 'Active'"));
		
		//following user authorization success mail
		$to = $recus['email'];
		
		$subject = "Voila! You are now following ".$mrec['full_name'];
		
		echo $message = '<html><body><table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="21"><img src="http://piclog.in/images/emailer/box_top_left_corner.png" width="21" height="46" /></td>
						<td background="http://piclog.in/images/emailer/box_top_bg.png"><div style="float:left; width:20%; color:#FFF; font-family:Verdana, Geneva, sans-serif; font-size:12px; padding-top:10px; ">Hi '.$recus['full_name'].',</div>
						  <div style="width:80%; float:right;padding:0 -50px 0 0; margin:0;" align="right"> <img src="http://piclog.in/images/emailer/logo.png" width="83" height="32" /></div></td>
						<td width="21"><img src="http://piclog.in/images/emailer/box_top_rite_corner.png" width="21" height="46" /></td>
					  </tr>
					  <tr>
						<td background="http://piclog.in/images/emailer/box_left.png"><img src="http://piclog.in/images/emailer/box_left.png" width="21" height="46" /></td>
						<td><div>
							<p>Voila! '.$mrec['full_name'].' has accepted your request to follow. Check out your Notifications and PicRoom Tabs for more information on '.$mrec['full_name'].'\'s Piclogs and activities.</p>
							<p>Thanks,<br />
							  Team &ndash; Piclog</p>
						  </div></td>
						<td background="http://piclog.in/images/emailer/box_rite.png"><img src="http://piclog.in/images/emailer/box_rite.png" width="21" height="46" /></td>
					  </tr>
					  <tr>
						<td><img src="http://piclog.in/images/emailer/box_bottom_left_corner.png" width="21" height="46" /></td>
						<td background="http://piclog.in/images/emailer/box_bottom_bg.png"><img src="http://piclog.in/images/emailer/box_bottom_bg.png" width="5" height="46" /></td>
						<td><img src="http://piclog.in/images/emailer/box_bottom_rite_corner.png" width="21" height="46" /></td>
					  </tr>
					</table></body></html>';
		
		$headers = "From: Piclog Admin <admin@piclog.in>\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		//mail($to, $subject, $message, $headers);
		
		header("Location: /".$mrec['username']."/");
	}else{
		mysql_query("DELETE FROM followers WHERE uid = '".$mrec['uid']."' AND fuid = '".$rec['uid']."' AND authorized = 'no'");
		
		$sta = mysql_query("SELECT status FROM about WHERE uid = '".$mrec['uid']."'");
		$stat = mysql_fetch_row($sta);
		$_SESSION['status'] = $stat[0];
		
		$propic = mysql_query("SELECT picture FROM profile_pic WHERE uid = '".$mrec['uid']."'");
		$prof = mysql_fetch_row($propic);
		$_SESSION['pro_pic'] = $prof[0];
		
		$_SESSION['uid'] = $mrec['uid'];
		$_SESSION['myid'] = $mrec['uid'];
		$_SESSION['uname'] = $mrec['username'];
		$_SESSION['fname'] = $mrec['full_name'];
		$_SESSION['uemail'] = $mrec['email'];
	
		header("Location: /".$mrec['username']."/");
	}
}else{
	header("Location: /login/");
}
?>
