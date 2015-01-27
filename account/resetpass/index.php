<?php
	/*error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors',1);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
	
	include('../../includes/web_header.php');
?>
</head>
<body>
<?php
	include('../../includes/web_headerarea.php');
	require ('../../w/includes/mysql_connect.php');
	require ('../../w/utils/mailer/class.phpmailer.php');
	
	$isValidURL = false;
	if(isset($_GET['rp'])){
		$get_rp = $_GET['rp'];
		$getArray = explode('-', $get_rp);
		$get_encrypt_username = $getArray[0];
		$get_userid = $getArray[1];
		$get_dbType = $getArray[2][0];
		$st_time = substr($getArray[2], 1);
		$end_time = $st_time + (2 * 60 * 60); //(7 * 24 * 60 * 60); day,hour,minute,second
		$cur_time = strtotime(now);
		if($st_time < $cur_time && $end_time > $cur_time) {
			$isValidURL = true;
		} else {
			$SendEmail = 5; // no longer valid
			$isValidURL = false;
		}
		/*echo $isValidURL."</br>";
		echo $get_encrypt_username."</br>";
		echo $get_userid."</br>";
		echo $get_dbType."</br>";
		echo $st_time."</br>";
		echo $end_time."</br>";
		//echo time()."</br>";
		echo $cur_time."</br>";*/
	} else {
	
	}
	
	$SendEmail = 5;
	//$UserTypeID = 2;
	
	$db_username = "";
	$db_encrypt_username = "";
	$db_userid = "";
	$db_fullname = "";
	$newpass = "";
	$confirmpass = "";
	
	if (isset($_POST['Submit'])) {
		//$UserTypeID = $_POST['UserTypeID'];
		$get_encrypt_username = $_POST['username'];
		$get_userid = $_POST['userid'];
		$get_dbType = $_POST['dbtype'];
		$newpass = $_POST['newpass'];
		$confirmpass = $_POST['confirmpass'];
		
		if ($newpass != "" || $confirmpass != ""){
			if($newpass == $confirmpass){
				if($get_dbType==1){
					$Query = "SELECT UserID, Email, FullName, 4 as UserTypeID FROM acePublicDB.TBL_Users WHERE UserID=$get_userid";
				} else {
					$Query = "SELECT 
									tb1.UserID, 
									IF(tb2.Email !='' , tb2.email, tb3.email), 
									CONCAT(tb1.FirstName, ' ', tb1.LastName) as FullName, 
									tb1.UserTypeID  
								FROM 
									acedb.TBL_Users tb1 LEFT JOIN acedb.TBL_StudentsProfile tb2 ON (tb2.UserID=tb1.UserID)
									LEFT JOIN acedb.TBL_FacultyProfile tb3 ON (tb3.UserID=tb1.UserID)
								WHERE
									tb1.UserID=$get_userid
								";									
				}
				$Result = mysql_query($Query);
				
				if (mysql_affected_rows() > 0) {
					$mail = new PHPMailer;
					$Row = mysql_fetch_array($Result);
					$db_userid = $Row[0];
					$db_username = $Row[1];
					$db_fullname = $Row[2];
					$db_usertypeid = $Row[3];
					$db_encrypt_username = substr(hash("sha256", $db_userid . $db_username . "passwordreset"), 0, 62);
					if($get_encrypt_username == $db_encrypt_username){
						if($get_dbType==1){
							$Query = "UPDATE acePublicDB.TBL_Users SET Password=PASSWORD('".$newpass."') WHERE UserID=$get_userid";
						} else {
							$Query = "UPDATE acedb.TBL_Users SET Password='".$newpass."' WHERE UserID=$get_userid";
						}
						$Result = mysql_query($Query);
						if($Result){
							$mail->From = 'support@acelearn.com';
							$mail->FromName = 'ACE-Learning Support';
							$mail->AddAddress($db_username, $db_fullname); 	
							
							
							$subject = "ACE-Learning Systems Account password changed";
							$message = "
								Dear $db_fullname,
								<br/><br/>
								The password for your ACE-Learning Systems Account - ".$db_username." - was recently changed.<br/>
								If you made this change, you don't need to do anything more.
								<br/><br/>
								If you didn't change your password, your account might have been hijacked. To get back into your account, you'll need to reset your password.
								<br/><br/>
								Sincerely,<br/>
								ACE-Learning Support";
							$mail->Subject = $subject;
							$mail->Body = "
								$message
							";
							$mail->IsHTML(true);
							$mail->Send();
							$SendEmail = 1;	// email sent successfully
							
						} else {
							$SendEmail = 0;	// Fail to send the email
						}
					} else {
						$SendEmail = 0;	// Fail to send the email
					}
				} else {
					$SendEmail = 0;	// Fail to send the email
				}
            } else {
				$SendEmail = 2;
			}
		} else {
			$SendEmail = 3;    // No Input for the Email
		}        		
	}
?>
<div id="content" class="clear">
	<div class="wrapper">
    	<div class="header_contenct_space">
            &nbsp;
        </div>
        <div id="products_content" class="box remove_bg">
            <div class="title_page">
                <h1 style="color:#dd4b39;">Reset Your Password</h1>
            </div>
            
			<div id="product_tabs" class="clear products_no_tabs">
				<div id="forgotpassword" class="contents_area">
					<?php if($isValidURL) { ?>
						<p>
							<b>Please create a new password for your account.</b>
							<br/>
							Create a password that's hard to guess and doesn't use personal information.<br/>
						</p>
						<br/>
						<br/>
						<form name="rpform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
							<div class="fields_cnt">
								<label for="newpass" id="label_newpass" class="fields_label" style="width:180px;">New password</label>
								<input type="password" name="newpass" id="newpass"  size="15" style="width:300px" value="<?php echo $_POST['newpass'];?>" class="FieldInput" onFocus="window.status='Enter your Email Address'; this.select()" onBlur="window.status=window.defaultStatus"/>
							</div> 
							<div class="fields_cnt" >
								<label for="confirmpass" id="label_confirmpass" class="fields_label" style="width:180px;">Confirm new password</label>
								<input type="password" name="confirmpass" id="confirmpass"  size="15" style="width:300px" value="<?php echo $_POST['confirmpass'];?>" class="FieldInput" onFocus="window.status='Enter your Email Address'; this.select()" onBlur="window.status=window.defaultStatus"/>
							</div> 
							<div class="fields_cnt" style="padding-left:180px;">
								<input type="submit" name="Submit" value="Reset Password" class="ui-corner-all fields_btn_color fields_btn"/> 
							</div>
							<input type="hidden" name="username" value="<?php echo $get_encrypt_username; ?>">
							<input type="hidden" name="userid" value="<?php echo $get_userid; ?>">
							<input type="hidden" name="dbtype" value="<?php echo $get_dbType; ?>">
						</form>
					<?php } else { ?>
						<?php if ($SendEmail == 0){ ?>
							<p>Failed to reset the password. Please try again.</p>
							<br/><br/>
							<div class="fields_cnt"">
								<input type="button" value="Back" onclick="window.history.back()" class="ui-corner-all fields_btn_color fields_btn"/> 
							</div>
						<?php } elseif ($SendEmail == 2) { ?>
							<p>Passwords do not match. Please try again.</p>
							<br/><br/>
							<div class="fields_cnt"">
								<input type="button" value="Back" onclick="window.history.back()" class="ui-corner-all fields_btn_color fields_btn"/> 
							</div>
						<?php } elseif ($SendEmail == 3) { ?>
							<p>Please enter your new password.</p><br/><br/>
							<div class="fields_cnt"">
								<input type="button" value="Back" onclick="window.history.back()" class="ui-corner-all fields_btn_color fields_btn"/> 
							</div>
						<?php } elseif($SendEmail == 1) { ?>
							<p><b>Success!</b></p><br/>
							<p>You have reset your password.</p><br/><br/>
							<p><a style="text-decoration:none; !important" href='http://www.ace-learning.com/'>Click here to login</a>.</p><br/>
						<?php } elseif($SendEmail == 5) { ?>
							<p><b>The URL you tried to use is either incorrect or no longer valid.</b></p><br/>
							<p>If you want to try again, please <a style="text-decoration:none; !important" href='http://www.ace-learning.com/forgotpassword.php'>start the reovery process from the beginning</a>.</p><br/>
						<?php } ?>
					<?php } ?>
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
