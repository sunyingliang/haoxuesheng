<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?2Og6RHWy5u6ZnILzZuhauJEJMpD6Pf8f';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->
<?php
include('includes/web_header.php');
require_once('includes/recaptchalib.php');
$publickey = "6Le1ONoSAAAAAEaJbbXW_xM5G7LFYBkMGnhoZEEr"; // you got this from the signup page

$privatekey = "6Le1ONoSAAAAAMmvTRjI-f2Va47wYaNneEZ3rQws "; // you got this from the signup page

//the response from reCAPTCHA
$resp = NULL;
// the error code from reCAPTCHA, if any
$error = NULL;

if(isset($_POST['send']))
{
	$nameinput = $_POST['nameinput'];
	$senderemail = $_POST['senderemail'];
	$subjectinput = "ACE-LEARNING CONTACT US FORM";
	$message = $_POST['messagebody'];
	$ErrorMessage = array();
	$errorswitch = true;
	if (empty($nameinput)) 
	{
		$errorswitch = false;
		$ErrorMessage[1] = 'Please provide your name.';
	}
	if (!preg_match('/^([A-Z0-9\.\-_]+)@([A-Z0-9\.\-_]+)?([\.]{1})([A-Z]{2,6})$/i', $senderemail) || empty($senderemail)) 
	{
		$errorswitch = false;
		if(empty($senderemail))
		{
			$ErrorMessage[4] = 'Please provide your email address.';
		}else
		{
			$ErrorMessage[2] = 'The email address entered is invalid.';
		}
	}
	if (empty($message)) 
	{
		$errorswitch = false;
		$ErrorMessage[3] = 'Please enter your message.';
	}
	if($errorswitch)
	{
		//Charles Tee <charles@acelearn.com>, 
		//$Headers = "From: ACE-Learning Support <support@acelearn.com>\r\nContent-type: text/html; charset=us-ascii";
		$Headers = "From: $nameinput <".$senderemail.">\r\nContent-type: text/html; charset=us-ascii";
		$To = "Charles Tee <charles@acelearn.com>, ACE-Learning Support <support@acelearn.com>";
		$Subject = $subjectinput; 
/*		
		$Body = "A new message from: <br /><br>";
		$Body .= "<span style='width:70px; display:inline-block; font-weight:bold;'>Name: </span>$nameinput<br>";
		$Body .= "<span style='width:70px; display:inline-block; font-weight:bold;'>Email:</span>$senderemail<br>";
		$Body .= "<br /><br><span  style='width:70px; display:inline-block; font-weight:bold;'>Message: </span><br /><br />$message\n\n\n\n";
*/
		$Body = "";
		/*$Body .= "Name: $nameinput\n";
		$Body .= "Email: $senderemail\n\n";*/
		$Body .= "$message";
	}
if(isset($_POST["recaptcha_response_field"]))
{
		$resp = recaptcha_check_answer ($privatekey,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);
		if ($resp->is_valid) {
		} else {
				// set the error code so that we can display it
				$ErrorMessage[5] = "Please enter the correct captcha code.";
				$errorswitch = false;
		}
}
	if(empty($_POST["recaptcha_response_field"]))
	{
		$errorswitch = false;
		$ErrorMessage[5] = 'Please enter the correct captcha code.';
	}
}
?>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
</head>
<body>
<?php
 include('includes/web_headerarea.php');
?>
<div id="content" class="clear">
	<div class="wrapper">
    	<div class="header_contenct_space">
            &nbsp;
        </div>
        <div id="products_content" class="box remove_bg">
             	<div class="title_page">
                    <h1>Sales and Support</h1>
            	</div>
            
              <div id="product_tabs" class="clear products_no_tabs">
                       <div id="ourvision" class="contents_area">
                           <span class="consultant_achievements">
                              Should you require any enquiries, you can contact us at:
                           </span>
                           <br />
                            <br />
                           <p>
                                <ul class="ace_list">
                                    <li><span>Tel:</span>(65) 6848 9320 (Monday - Friday: 9am - 6pm)</li>
                                    <li><span>Fax:</span>(65) 6848 9321</li>
                                    <li><span>Email:</span>support@acelearn.com</li>
                                    <li><span>&nbsp;</span>sales@acelearn.com</li>
                                </ul>
                            
                           </p>
                       </div>
                       <div id="salesandsupportimg">
                            <img src="images/website/Web_salesandsupport.png" alt="salesandsupport"/>
                       </div>
              </div>
               
                	
						<?php
                        if(isset($_POST['send']) && $errorswitch)
                        {
							
							if(mail($To, $Subject, $Body, $Headers))
							{
                        ?>
                        	<div class="title_page">
                        	    <span class="consultant_achievements" style="color:#0000FF !important">
                                	Your message has been sent.<br />
									Thank you for contacting us!
                           		</span>
                            </div>
                     	<?php
							}else
							{
								
						?>
                        		<div class="title_page">
                                    <span class="consultant_achievements" style="color:#FF0000 !important">
                                        Unable to send message. Please try again later.
                                    </span>
                                </div>
                        <?php
								
							}
                     	}else
						{
					  	?>
                            <div class="title_page">
                                <h1>Contact us form</h1>
                            </div>
                            <div id="contactform" class="clear products_no_tabs">
                                <p class="caption_message">
                                    * required fields
                                </p><br />
                                <form action="salesandsupport.php" method="post" enctype="multipart/form-data" name="contactform">
                                    <div id="sendernamesection" class="contactusrow">
                                    	<div class="contactfieldlabel">Name<span class="caption_message">*</span></div>
                                        <div id="sendername"  class="contactfieldinput">
                                        	<input class="<?php if(isset($ErrorMessage[1])){echo "border_red contactform_input";}?>" name="nameinput" type="text" maxlength="200" value="<?php echo $nameinput;?>"/><?php if(isset($ErrorMessage[1])) echo "<span>".$ErrorMessage[1]."</span>"?>
                                    	</div>
                                    </div>
                                    <div id="subjectsection" class="contactusrow">
                                    	<div class="contactfieldlabel">Email<span class="caption_message">*</span></div>
	                                    <div id="senderemail"  class="contactfieldinput">
                                        	<input name="senderemail" type="text" maxlength="250" class="<?php if(isset($ErrorMessage[2]) || isset($ErrorMessage[4])){echo "border_red contactform_input";}?>"  value="<?php echo $senderemail;?>"/><?php if(isset($ErrorMessage[2])){ echo "<span>".$ErrorMessage[2]."</span>";} else if(isset($ErrorMessage[4])){echo "<span>".$ErrorMessage[4]."</span>";} ?> 
                                    	</div>
                                    </div>
                                    <div id="messagesection" class="contactusrow">
                                    	<div class="contactfieldlabel">Message<span class="caption_message">*</span></div>
                                        <div id="message" class="contactfieldinput">
                                        	<textarea name="messagebody" cols="5" rows="5" class="<?php if(isset($ErrorMessage[3])){echo "border_red contactform_input";}?>"><?php echo $message;?></textarea><?php  if(isset($ErrorMessage[3])) echo "<span>".$ErrorMessage[3]."</span>"?>
                                        </div>
                                    </div>
                                    <div id="captcha" class="contactusrow">
                                    	<div class="contactfieldlabel">&nbsp;</div>
                                        <div id="captchabox">
											<?php echo recaptcha_get_html($publickey, $error);?><?php if(isset($ErrorMessage[5])) echo "<span class='captcha_error'>".$ErrorMessage[5]."</span>"?>
                                        </div>
                                    </div>
                                    <div id="messagesection" class="contactusrow">
                                    	<div class="contactfieldlabel">&nbsp;</div>
                                        <div id="sendmessage" class="contactfieldinput"> 
                                    		<input name="send" type="submit" value="Send" id="send" class="form_submit_button ui-corner-all button_color"/>
                                    	</div>
                                    </div>
                                </form>
                            </div>
                    <?php
						}
					?>
        </div>
    </div>
    <?php
		include('includes/web_footer.php');
	?>
</div>
</body>
</html>
