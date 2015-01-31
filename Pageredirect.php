<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$uID = $_GET['uID'];
$ipRef = $_GET['ipRef'];
$pID = $_GET['pID'];
$token = $_GET['token'];
$ref = $_GET['ref'];
//var_dump($_GET);
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
	$uri = 'https://';
} else {
	$uri = 'http://';
}
//$uri .= $_SERVER['HTTP_HOST'];
//$uri .= $_SERVER['HTTP_HOST'];
$uri .= "http://www.ace-learning.com";
$URL = $uri.'/w/redirect_mc_sys.php?uID='.$uID.'&ipRef='.$ipRef.'&pID='.$pID.'&token='.$token."&ref=".$ref;
//header('Location: '.$uri.'/sys/redirect_mc_sys.php?uID='.$nric.'&ipRef='.$ipFrom.'&pID='.$pID.'&token='.$token."&ref=".$ref);
//echo $URL;
?>
<meta HTTP-EQUIV="REFRESH" content="2; url=<?php echo $URL;?>">
<title>Redirecting to Ace-Learning Website</title>
<style type="text/css">
body {
	margin:50px 0px; padding:0px;
	text-align:center;
	}
	
#Content {
	width:500px;
	margin:200px auto;
	text-align:center;
	padding:15px;
	
	}
p {
     COLOR: #000000;
     FONT-FAMILY: verdana ;
     FONT-SIZE: 15pt;
}
</style>
</head>

<body>
<div id="Content">
	<p>
   	<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sys/images/misc/loadingAjax.gif" width="31" height="31" alt="loader" style="vertical-align:middle"/>&nbsp;&nbsp;&nbsp;Redirecting to ACE-Learning website...
	</p>
	<p style="FONT-SIZE: 10pt;">Click <a href="<?php echo $URL;?>">here</a> if your browser does not automatically redirect you</p>
</div>
<?php
	//sleep(2);
	//header('Location: '.$uri.'/sys/redirect_mc_sys.php?uID='.$nric.'&ipRef='.$ipFrom.'&pID='.$pID.'&token='.$token."&ref=".$ref);
?>
</body>
</html>