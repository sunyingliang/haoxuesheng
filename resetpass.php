<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
	include('utils/web_header.php');
?>
<script language="javaScript" src="<?=$LMSPath;?>profile/js/keypress_validation.js"></script>
</head>
<body>
<?php
	include('utils/web_headerarea.php');
	require ($LMSPath.'config/mysql_connect.php');
	require ($LMSPath.'utils/mailer/class.phpmailer.php');
	
	$ErrorMessage = array();
	$isValidURL = false;
	$SendEmail = 5;
	
	if(isset($_GET['rp'])){
		$get_rp = $_GET['rp'];
                $salesrep = $_GET['user']; // For Salesrep
                //var_dump($salesrep);
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
                $isValidURL = true;
	} else {
	
	}
	//$test = substr(hash("sha256", "609" . "k.zaruk@gmail.com" . "passwordreset"), 0, 62);
	//echo $test;
	//echo $cur_time;
	
	$db_username = "";
	$db_useremail = "";
	$db_encrypt_username = "";
	$db_userid = "";
	$db_fullname = "";
	$newpass = "";
	$confirmpass = "";
	
	if (isset($_POST['Submit'])) {
		//$UserTypeID = $_POST['UserTypeID'];
                $salesrep = $_POST['user']; // For salesrep
                //var_dump($salesrep);
		$get_encrypt_username = $_POST['username'];
		$get_userid = $_POST['userid'];
		$get_dbType = $_POST['dbtype'];
		$newpass = $_POST['newpass'];
		$confirmpass = $_POST['confirmpass'];
		if(trim($newpass)=="" && trim($confirmpass)==""){
			$ErrorMessage[1] = 'Please provide your new password.';
			$ErrorMessage[2] = 'Please provide your confirm password.';
			$isValidURL = true;
			$SendEmail = 3;   // No Input
		} elseif (trim($newpass)==""){
			$ErrorMessage[1] = 'Please provide your new password.';
			if(strlen($confirmpass)<6){
				$ErrorMessage[2] = 'Password is less than 6 characters in length.';
			}
			$isValidURL = true;
			$SendEmail = 3;   // No Input
		} elseif (trim($confirmpass)==""){
			if(strlen($newpass)<6){
				$ErrorMessage[1] = 'Password is less than 6 characters in length.';
			}
			$ErrorMessage[2] = 'Please provide your confirm password.';
			$isValidURL = true;
			$SendEmail = 3;   // No Input
		} elseif (strlen($newpass)<6 || strlen($confirmpass)<6){
			if(strlen($newpass)<6){
				$ErrorMessage[1] = 'Password is less than 6 characters in length.';
			}
			if(strlen($confirmpass)<6){
				$ErrorMessage[2] = 'Password is less than 6 characters in length.';
			}
			$isValidURL = true;
			$SendEmail = 3;   // No Input
		} else {
			//if ($newpass != "" || $confirmpass != ""){
				if($newpass == $confirmpass){
					$isValidURL = false;
					if($get_dbType==1){
                                                // For Salesrep
                                                if($salesrep != ""){
                                                $Query = "SELECT 
										SalesRepID, 
										Email, 
										FirstName
									FROM 
										acePublicDB.TBL_SalesRepresentative
									WHERE 
										SalesRepID=$get_userid";
                                                }
                                                // End
                                                else{
						$Query = "SELECT 
										UserID, 
										Email, 
										FullName, 
										Email, 
										4 as UserTypeID 
									FROM 
										acePublicDB.TBL_Users 
									WHERE 
										UserID=$get_userid";
                                                }
					} elseif($get_dbType==3){
						$Query = "SELECT 
										UserID, 
										ParentsEmail, 
										ParentsName, 
										ParentUsername, 
										6 as UserTypeID 
									FROM 
										acedb.TBL_StudentsProfile 
									WHERE 
										UserID=$get_userid";
					} else {
						$Query = "SELECT 
										tb1.UserID, 
										IF(tb2.Email !='' , tb2.email, tb3.email), 
										CONCAT(tb1.FirstName, ' ', tb1.LastName) as FullName, 
										tb1.Username,
										tb1.UserTypeID  
									FROM 
										acedb.TBL_Users tb1 
										LEFT JOIN acedb.TBL_StudentsProfile tb2 ON (tb2.UserID=tb1.UserID)
										LEFT JOIN acedb.TBL_FacultyProfile tb3 ON (tb3.UserID=tb1.UserID)
									WHERE
										tb1.UserID=$get_userid
									";									
					}
					$Result = mysql_query($Query);
					//echo $Query;
					if (mysql_affected_rows() > 0) {
						$Row = mysql_fetch_array($Result);
						$db_userid = $Row[0];
						$db_useremail = $Row[1];
						$db_fullname = $Row[2];
						$db_username = $Row[3];
						$db_usertypeid = $Row[4];
						$db_encrypt_username = substr(hash("sha256", $db_userid . $db_useremail . "passwordreset"), 0, 62);
						
						$a = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','!','@','#','$','%','^','&','*','(',')');
						shuffle($a);
						$salt = substr(implode($a), 0, 5);
						$whmcspass = md5($salt . $newpass) . ":" . $salt;
		
						if($get_encrypt_username == $db_encrypt_username){
							if($get_dbType==1){
                                                            // For salesrep
                                                            if($salesrep != ""){
                                                                $Query = "UPDATE acePublicDB.TBL_SalesRepresentative SET Password='".$newpass."' WHERE SalesRepID=$get_userid";
                                                            }// End
                                                            else{
								$Query = "UPDATE acePublicDB.TBL_Users SET Password=PASSWORD('".$newpass."') WHERE UserID=$get_userid";
								$Query2 = "UPDATE aceBillingDB.tblclients SET password='$whmcspass' WHERE email='".$db_useremail."'";
                                                            }
							} elseif($get_dbType==3){
								$Query = "UPDATE acedb.TBL_StudentsProfile SET ParentPassword='".$newpass."' WHERE UserID=$get_userid";
							} else {
								$Query = "UPDATE acedb.TBL_Users SET Password='".$newpass."' WHERE UserID=$get_userid";
							}
                                                        //var_dump($Query);
							$Result = mysql_query($Query);
							if($Result){
								mysql_query($Query2);
								/*$mail = new PHPMailer;
								$mail->From = 'support@acelearn.com';
								$mail->FromName = 'ACE-Learning Support';
								$mail->AddAddress($db_useremail, $db_fullname); 	
								
								
								$subject = "ACE-Learning Systems Account password changed";
								$message = "
									Dear $db_fullname
									<br/><br/>
									The password for your ACE-Learning Systems Account - ".$db_username." - was recently changed.<br/>
									If you made this change, you don't need to do anything more.
									<br/><br/>
									If you didn't change your password, your account might have been hijacked. To get back into your account, you'll need to reset your password.
									<br/><br/>
									Regards<br/>
									ACE-Learning Support<br/>
									Tel:(65)6848 9320<br/>
									Fax:(65)6848 9321<br/>
									Email:support@acelearn.com";
								$mail->Subject = $subject;
								$mail->Body = "
									$message
								";
								$mail->IsHTML(true);
								$mail->Send();*/
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
					//$SendEmail = 2;
					$ErrorMessage[2] = 'Passwords do not match.';
					$isValidURL = true;
					$SendEmail = 3;   // No Input
				}
			/*} else {
				$SendEmail = 3;    // No Input
			}*/     
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
                <h1>Reset Your Password</h1>
            </div>
            
			<div id="product_tabs" class="box remove_bg">
				<div id="forgotpassword" class="contents_area" style="padding-right:0px; width:850px">
					<?php if($isValidURL) { ?>
						<br/>
						<p>Please create a new password for your account.</p>
						<p>Create a password that's hard to guess and doesn't use personal information.</p>
						<br/>
						<form name="rpform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
							<div class="contactusrow">
								<div class="contactfieldlabel" style="padding-top:3px;">
									<label for="newpass" id="label_newpass" class="fields_label" style="width:160px;">New password<!--span class="caption_message">*</span--></label>
								</div>
								<div class="contactfieldinput" style="padding-left:60px;">
									<input type="password" name="newpass" id="newpass" onkeypress='return validPasswdChar(event)' style="width:313px;" maxlength="15" value="<?php echo $_POST['newpass'];?>" class="<?php if(isset($ErrorMessage[1])){echo "border_red contactform_input";}?>"/><?php if(isset($ErrorMessage[1])) echo "<span style='vertical-align: middle;'>".$ErrorMessage[1]."</span>";?>
								</div> 
								<div class="clear products_no_tabs" style="padding-bottom:1px; padding-top:5px; padding-left:162px;">
									<span style="color:#333333; font-size:8pt;">
										* Only Letters (a-z, A-Z), Numerals (0-9) are allowed<br/>
										* 6 - 15 characters in length
									</span>
								</div>
							</div>
							<div class="contactusrow">
								<div class="contactfieldlabel" style="padding-top:3px;">
									<label for="confirmpass" id="label_confirmpass" class="fields_label" style="width:160px;">Confirm password<!--span class="caption_message">*</span--></label>
								</div>
								<div class="contactfieldinput" style="padding-left:60px;">
									<input type="password" name="confirmpass" id="confirmpass" onkeypress='return validPasswdChar(event)' style="width:313px" maxlength="15" value="<?php echo $_POST['confirmpass'];?>" class="<?php if(isset($ErrorMessage[2])){echo "border_red contactform_input";}?>"/><?php if(isset($ErrorMessage[2])) echo "<span style='vertical-align: middle;'>".$ErrorMessage[2]."</span>";?>
								</div> 
							</div>
							<div class="contactusrow">
								<div class="contactfieldlabel" style="padding-left:202px; padding-top:3px;">
									<input type="submit" name="Submit" value="Reset Password" style="width:140px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
							<!--div class="contactusrow">
								<p class="caption_message"> * required fields </p>
							</div-->
							<input type="hidden" name="username" value="<?php echo $get_encrypt_username; ?>">
							<input type="hidden" name="userid" value="<?php echo $get_userid; ?>">
							<input type="hidden" name="dbtype" value="<?php echo $get_dbType; ?>">
                                                        <input type="hidden" name="user" value="<?php echo $salesrep; ?>"> <!-- For Salesrep -->
						</form>
					<?php } else { ?>
						<?php if ($SendEmail == 0){ ?>
							<br/>
							<p>Failed to reset the password. Please try again.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Try Again" onclick="window.history.back()" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
						<?php } elseif ($SendEmail == 2) { ?>
							<br/>
							<p>Passwords do not match. Please try again.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Try Again" onclick="window.history.back()" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
						<?php } elseif ($SendEmail == 3) { ?>
							<br/>
							<p>Please enter your new password.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Back" onclick="window.history.back()" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
						<?php } elseif($SendEmail == 1) { ?>
							<br/>
							<p>You have reset your password.</p>
							<br/>
							<div class="contactusrow">                                                                
								<div>
                                                                    <? // For Salesrep
                                                                    if($salesrep != ""){?>
                                                                        <p><a style="text-decoration:none !important;" href='http://www.ace-learning.com/salesrep/login'>Click here to login</a>.</p>
                                                                    <?}else{?>
									<p><a style="text-decoration:none !important;" href='http://www.ace-learning.com/'>Click here to login</a>.</p>
                                                                    <? } // End?>    
								</div>
							</div>
						<?php } elseif($SendEmail == 5) { ?>
							<br/>
							<p>The URL you tried to use is either incorrect or no longer valid.</p>
							<div class="contactusrow">
								<div>
									<p>If you want to try again, please <a style="text-decoration:none !important;" href='http://www.ace-learning.com/forgotpassword.php'>start the recovery process from the beginning</a>.</p>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
        </div>
    </div>
    <?php
		include('utils/web_footer.php');
	?>
</div>
</body>
</html>
