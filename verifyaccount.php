<?php
/**
	url variables
	code = md5 encrypted whmcsid/userid and "ace-learning.com.2013".
	email = email
*/

/*include_once('/w/includes/mysql_secret.php');*/
include_once('includes/class.verifyaccount.php');
$code = $_GET['code'];
$email = $_GET['email'];
$DBC = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD);
echo 'db connection: '.var_dump($DBC).' hello '. DB_HOST . '  error: '.mysql_error();;
$verify = new VerifyAccount($code, $email);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include('includes/web_header.php');
if($verify->marker){
?>
<meta http-equiv="refresh" content="2; url=index.php">
<!--<link rel="stylesheet" type="text/css" href="stylesheet/login-css.css">
<link rel="stylesheet" type="text/css" href="stylesheet/products-css.css">-->
</head>
<body>
<?php
}
 include('includes/web_headerarea.php');
?>
<div id="content" class="clear">
	<div class="wrapper">
		<div id="page_message">
                		<div style="margin:0 auto; position:relative; width: 80%; text-align:center; margin-bottom:300px">
							<?php
								if(!$verify->marker)
								{
									var_dump($verify->debugArray);
							?>
							<span id="loginerrormsg" class="ui-corner-all">
								<p class="error_msg">
									<?php echo $verify->pageErrorMessage;?>
								</p>
							</span>
							<?php
								}
								else
								{
							?>
									<img src="/w/images/misc/loadingAjax.gif" alt="salesandsupport"/>
									<br/>
									Updating...If the page does not redirect please click <a href='http://www.ace-learning.com/index.php'>here</a>.
							<?php
								}
							?>
                        </div>
                  </div>
	</div>
</div>
<?php
	include('includes/web_footer.php');
?>
</div>
</body>
</html>
