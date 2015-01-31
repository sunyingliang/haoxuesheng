<?php
	session_name('acelearn');
	session_start();
	
	$email = "";
	
	$get_pid = $_GET['pid'];
	$email = $_SESSION['SessionEmail'];
	$userTypeID = $_SESSION['SessionUserTypeID'];
	//echo "UserTypeID=".$userTypeID."<br/>";
	//echo "email=".$email."<br/>";
	if($email && $userTypeID==4){
		//$goto = "aceredirect.php".$extraQ; //just changes this to the target link . example: cart.php?a=add&pid=7
		//$goto = "http://billing.ace-learning.com/cart.php?a=add&pid=".$get_pid;
		//$goto = "cart.php?a=add&pid=".$get_pid;
		$goto = "clientarea.php?action=products";
		
		$whmcsurl = "http://billing.ace-learning.com/dologin.php";
		$autoauthkey = "AceLearningBilling2013";

		$timestamp = time(); # Get current timestamp
		//$email = $Username; # Clients Email Address to Login
		$hash = sha1($email.$timestamp.$autoauthkey); # Generate Hash

		// Generate AutoAuth URL & Redirect
		//$url = urlencode($whmcsurl."?email=".$email."&timestamp=".$timestamp."&hash=".$hash."&goto=".$goto);
		$url = $whmcsurl."?email=".$email."&timestamp=".$timestamp."&hash=".$hash."&goto=".$goto;
	} else {
		$url = "http://billing.ace-learning.com/cart.php?a=add&pid=".$get_pid;
	}
	echo $url;
?>