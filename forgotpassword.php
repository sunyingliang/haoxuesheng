<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
	include('utils/web_header.php');
?>
<!--<link rel="stylesheet" type="text/css" href="stylesheet/login-css.css">
<link rel="stylesheet" type="text/css" href="stylesheet/products-css.css">-->
</head>
<body>
<?php
	include('utils/web_headerarea.php');
	require ($LMSPath.'config/mysql_connect.php');
	require ($LMSPath.'utils/mailer/class.phpmailer.php');
	
	$ErrorMessage = array();
	$SendEmail = 10;
	$email = ""; 
        if(isset($_GET['user'])){
	$salesrep = $_GET['user'];
        }
	function forgotPassword($UserInput , $Salesrep){
		global $SendEmail;
		global $email;
		global $ErrorMessage;
		
		$UserInput = htmlentities(trim($UserInput));
		$UserInputType = VerifyMailAddress($UserInput);
		
		if($UserInput==""){
			$ErrorMessage[1] = 'Please provide your email.';
			$SendEmail = 3;
			return;
		}
                // For Salesrep  
                //var_dump($Salesrep);
		if(isset($UserInputType) && $Salesrep != "")
		{
                    $Query = "SELECT
                                Email,
                                FirstName,
                                SalesRepID,
                                AccountStatus
                              FROM
                                acePublicDB.TBL_SalesRepresentative
                              WHERE
								Email='$UserInput'";			
                    $Result = mysql_query($Query);
                    if(mysql_affected_rows()>0) 
					{
                        $Row = mysql_fetch_row($Result);
                        $email = $Row[0];
                        $firstname = $Row[1];
                        $userid = $Row[2];
                        $accountStatus = $Row[3];
                        //echo "http://www.ace-learning.com/resetpass?user=salesrep&rp=".getPasswordResetCode($userid, $email)."-".$userid."-".$dbType.time();
                        sendResetEmailSalesrep($email, $firstname, getPasswordResetCode($userid, $email), $userid, $dbType);
                        $SendEmail = 1;
                    } 
                    else {
                        $SendEmail = 2;
                    }                    
       }
                // End
        else
		{		
            if($UserInputType) 
			{
				/*check  publicdb if given email format*/
				$Query = "SELECT  
							Email, 
							FullName,
							UserID,
							AccountStatus
						FROM 
							acePublicDB.TBL_Users 
						WHERE 
							Email='$UserInput'";
				
				$dbType = 1;
				$Result = mysql_query($Query);
				
				if(mysql_affected_rows()==0) {
					$Query = "SELECT
								SP.Email as StudentEmail,
								FP.Email as FacultyEmail,
								CONCAT(UP.Username,' ',UP.LastName), 
								UP.UserID,
								UP.AccountStatusID
							FROM
									acedb.TBL_Users UP 
								LEFT JOIN
									acedb.TBL_StudentsProfile SP ON (SP.UserID=UP.UserID)
								LEFT JOIN
									acedb.TBL_FacultyProfile FP ON (FP.UserID=UP.UserID)
							WHERE
								(SP.Email='$UserInput' or FP.Email='$UserInput') and UP.Dummy = 0
							ORDER BY
								UP.AccountStatusID";
					
					$dbType = 2;
					$Result = mysql_query($Query);
				}
			} else 
			{
			/*check acedb if no email format*/
				$Query = "SELECT
							SP.Email as StudentEmail,
							FP.Email as FacultyEmail,
							CONCAT(UP.Username,' ',UP.LastName), 
							UP.UserID,
							UP.AccountStatusID
						FROM
								acedb.TBL_Users UP 
							LEFT JOIN
								acedb.TBL_StudentsProfile SP ON (SP.UserID=UP.UserID)
							LEFT JOIN
								acedb.TBL_FacultyProfile FP ON (FP.UserID=UP.UserID)
						WHERE
							(SP.Email='$UserInput' or FP.Email='$UserInput') and UP.Dummy = 0
						ORDER BY
								UP.AccountStatusID";
				
				$dbType = 2;
				$Result = mysql_query($Query);
			}
                
			//$stmt->store_result();
			//echo $Query;
			
			if(mysql_affected_rows()>0) 
			{
				if(mysql_affected_rows()>1)
				{
					$SendEmail = 6;
					return;
				}
				if($dbType == 1) {
					$Row = mysql_fetch_array($Result);
					$email = $Row[0];
					$fullname = $Row[1];
					$userid = $Row[2];
					$accountStatus = $Row[3];
					if($email=="") {
						$SendEmail = 4;
					} elseif ($accountStatus==2) {
						$SendEmail = 5;
					} else {
											//echo "http://www.ace-learning.com/resetpass?&rp=".getPasswordResetCode($userid, $email)."-".$userid."-".$dbType.time();
						sendResetEmail($email, $fullname, getPasswordResetCode($userid, $email), $userid, $dbType);
						$SendEmail = 1;
					}
				} else {
					$Row = mysql_fetch_array($Result);
					$spemail = $Row[0];
					$fpemail = $Row[1];
					$fullname = $Row[2];
					$userid = $Row[3];
					$accountStatus = $Row[4];
					if($spemail=="" && $fpemail=="") {
						$SendEmail = 4;
					} elseif ($accountStatus=="S") {
						$SendEmail = 5;
					} else {
						$email = ($spemail!="")?$spemail:$fpemail;
											//echo "http://www.ace-learning.com/resetpass?rp=".getPasswordResetCode($userid, $email)."-".$userid."-".$dbType.time();
						sendResetEmail($email, $fullname, getPasswordResetCode($userid, $email), $userid, $dbType);
						$SendEmail = 1;
					}
				}
			} 
			else 
			{
				/*check acedb for Parent*/		
				$Query = "SELECT
							SP.ParentsEmail as ParentEmail,
							SP.ParentsName, 
							SP.UserID,
							UP.AccountStatusID
						FROM
								acedb.TBL_StudentsProfile SP
							LEFT JOIN
								acedb.TBL_Users UP ON (SP.UserID=UP.UserID)
						WHERE
							SP.ParentEmail='$UserInput'";
				//echo $Query;
				$dbType = 3;
				$Result = mysql_query($Query);
				
				if(mysql_affected_rows()>0) {
					$Row = mysql_fetch_array($Result);
					$email = $Row[0];
					$fullname = $Row[1];
					$userid = $Row[2];
					$accountStatus = $Row[3];
					if($email=="") {
						$SendEmail = 4;
					} elseif ($accountStatus=="S") {
						$SendEmail = 5;
					} else {                                        
						sendResetEmail($email, $fullname, getPasswordResetCode($userid, $email), $userid, $dbType);
						$SendEmail = 1;
					}
				} else {
					$SendEmail = 2;
				}
			}
        }
	}

	function getPasswordResetCode($userid, $email){
		return substr(hash("sha256", $userid . $email . "passwordreset"), 0, 62);
	}

	function VerifyMailAddress($address){
		$Syntax='#^[w.-]+@[w.-]+.[a-zA-Z]{2,5}$#';
		if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $address)){
			return true;
		} else {
			return false;
		}
	}

	function sendResetEmail($to, $fullName, $activationCode, $userID, $dbSwitch){
		/**
			need to study pretty url
		*/
		//global $SendEmail;
		$mail = new PHPMailer;
		
		$mail->From = 'no-reply@ace-learning.com';
		$mail->FromName = 'ACE-Learning Support';
		$mail->AddAddress($to, $fullName); 	
		$subject = "ACE-Learning: Reset Password";
		$message = "
			Dear $fullName <br/><br/>
			Please click the following link to reset your password:<br/>
			<strong><a href=\"http://www.ace-learning.com/resetpass.php?rp=".$activationCode."-".$userID."-".$dbSwitch.time()."\">http://www.ace-learning.com/resetpass.php?rp=".$activationCode."-".$userID."-".$dbSwitch.time()."</a></strong>
			<br/><br/>
			If you still encounter problems, please contact us at support@acelearn.com
			<br/><br/>
			Regards<br/>
			ACE-Learning Support<br/>
			Tel: (65) 6848 9320<br/>
			Fax: (65) 6848 9321<br/>
			Email: support@acelearn.com";
		$mail->Subject = $subject;
		$mail->Body = "
			$message
		";
		$mail->IsHTML(true);
		$mail->Send();
	}
        function sendResetEmailSalesrep($to, $fullName, $activationCode, $userID, $dbSwitch){
		/**
			need to study pretty url
		*/
		//global $SendEmail;
		$mail = new PHPMailer;
		
		$mail->From = 'no-reply@ace-learning.com';
		$mail->FromName = 'ACE-Learning Support';
		$mail->AddAddress($to, $fullName); 	
		$subject = "ACE-Learning: Reset Password";
		$message = "
			Dear $fullName <br/><br/>
			Please click the following link to reset your password:<br/>
			<strong><a href=\"http://www.ace-learning.com/resetpass.php?user=salesrep&rp=".$activationCode."-".$userID."-".$dbSwitch.time()."\">http://www.ace-learning.com/resetpass.php?user=salesrep&rp=".$activationCode."-".$userID."-".$dbSwitch.time()."</a></strong>
			<br/><br/>
			If you still encounter problems, please contact us at support@acelearn.com
			<br/><br/>
			Regards<br/>
			ACE-Learning Support<br/>
			Tel: (65) 6848 9320<br/>
			Fax: (65) 6848 9321<br/>
			Email: support@acelearn.com";
		$mail->Subject = $subject;
		$mail->Body = "
			$message
		";
		$mail->IsHTML(true);
		$mail->Send();
	}

?>
<div id="content" class="clear">
	<div class="wrapper">
    	<div class="header_contenct_space">
            &nbsp;
        </div>
        <div id="products_content" class="box remove_bg">
            <div class="title_page">
                <h1>Forgot Password</h1>
            </div>
            
			<div id="product_tabs" class="box remove_bg">
				<div id="forgotpassword" class="contents_area">
					<?php
					if(isset($_POST['Submit'])){
                                                if(isset($_POST['Email'])){
						$UserInput = $_POST['Email'];
                                                if($_POST['user'] != ""){
                                                $Salesrep  = $_POST['user'];
                                                }
                                                else{
                                                $Salesrep  = "";  // For Salesrep
                                                }
                                                }
                                                //var_dump($Salesrep);
						forgotPassword($UserInput,$Salesrep);
					}
				   	if(!isset($_POST['Submit']) || $SendEmail == 3) {
					?>
						<br />
                   		<p>
                            Please enter your email address.
						</p>
						<p>
                            Instructions on resetting your password will be sent to your email address.
                        </p>
                        <br />
                        <form name="fpform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
							<div class="contactusrow">
								<div class="contactfieldlabel" style="padding-top:3px;">
									<label for="Email" id="label_Email" class="fields_label" style="width:100px;">Email</label>
								</div>
								<div class="contactfieldinput">
									<input type="text" style="width:313px;" class="<?php if(isset($ErrorMessage[1])){echo "border_red contactform_input";}?>" name="Email" id="Email" value="<?php echo $_POST['Email'];?>"/><?php if(isset($ErrorMessage[1])) echo "<span style='vertical-align: middle;'>".$ErrorMessage[1]."</span>";?>
								</div>
							</div>
							<div class="contactusrow">
								<div class="contactfieldlabel" style="padding-left:100px; padding-top:3px;">
									<input type="submit" name="Submit" value="Retrieve" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
                                                                        <input type="hidden" name="user" value="<?php echo $salesrep; ?>">
								</div>
							</div>
                        </form> 
					<?php } else { 
						//$UserInput = $_POST['Email'];
						//forgotPassword($UserInput);
					?>
                   		<?php if ($SendEmail == 0){ ?>
							<br />
							<p>Failed to reset the password. Please try again.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Try Again" onclick="location.href='forgotpassword.php'" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
						<?php } elseif($SendEmail == 1) { ?>
							<br />
							<p>An email has been sent to <b><?php echo $email; ?></b>.</p>
							<p>Please follow the instruction in the email to reset your password.<p/><br/>
							<p>If you did not receive the password reset email, please check your spam/junk folder or contact us at support@acelearn.com.</p>
							<br/>
							<div class="contactusrow">
								<div>
                                                                        <? // For salesrep
                                                                        if($Salesrep != "") {?>
									<p><a style="text-decoration:none !important;" href="http://www.ace-learning.com/salesrep/login.php">Click here to login</a>.</p>
                                                                        <? } //End
                                                                            else { ?>
                                                                            <p><a style="text-decoration:none !important;" href="http://www.ace-learning.com/">Click here to login</a>.</p>
                                                                        <? } ?>
								</div>
							</div>
                        <?php } elseif ($SendEmail == 2) { ?>
							<br />
							<p>Sorry, we could not find the email you specified.</p>
							<p>Please check the email you entered.</p>
							<br/>
							</p>If you believe that you receive this in error, feel free to contact us at support@acelearn.com.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Try Again" onclick="location.href='forgotpassword.php'" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
                        <?php } elseif ($SendEmail == 3) { ?>
							<br />
                            <p>Please enter your email.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Try Again" onclick="location.href='forgotpassword.php'" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
                        <?php } elseif ($SendEmail == 4) { ?>
							<br />
                            <p>Sorry, there is no email address associated with your account.</p>
							<p>Please contact us at support@acelearn.com with your email for further assistance.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Try Again" onclick="location.href='forgotpassword.php'" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
                        <?php } elseif ($SendEmail == 5) { ?>
							</br>
                            <p>Sorry! Your account has been suspended.</p>
							<p>Please contact us at support@acelearn.com with your email for further assistance.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Try Again" onclick="location.href='forgotpassword.php'" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
								</div>
							</div>
						<?php } elseif ($SendEmail == 6) { ?>
							</br>
                            <p>Sorry! Your email address is registered to multiple accounts.</p>
							<p>Please contact ACE learning support further assistance.</p>
							<br/>
							<div class="contactusrow">
								<div class="contactfieldlabel">
									<input type="button" value="Try Again" onclick="location.href='forgotpassword.php'" style="width:100px;" class="form_submit_button ui-corner-all button_color"/> 
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


