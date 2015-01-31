<?php
	/*if(!isset($_GET['test']))
	{
	header("Location:  http://" . $_SERVER['HTTP_HOST'] . "/siteupdate.php");
	exit();
	}*/
	if($_SERVER['QUERY_STRING']=="")
	{
		if(isset($_COOKIE['aceLearningSiteAuth']))
		{
			header("Location:  http://" . $_SERVER['HTTP_HOST'] . "/w/index_login.php");
			exit();
		}
		session_name('acelearn');
		session_start();
		if(isset($_SESSION['SessionUserID']) and $_SESSION['SessionUserID']!="" and !isset($_SESSION['AccountLoginType']))
		{
			header ("Location:  http://" . $_SERVER['HTTP_HOST'] . "/dashboard");
			exit();
			
		}
		else
		{
			session_unset();
			setcookie('acelearn', '', time()-9999999999, '/');
			setcookie('acecookie', '', time()-9999999999,'/');/*expire cookie*/
		}
	}else
	{
		//remove any session. user has been kickout of the system
		//setcookie('acecookie', '', time()-9999999999,'/');/*expire cookie*/
		//setcookie('acelearn', '', time()-9999999999,'/');/*expire cookie*/
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php
		include('includes/web_header.php');
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8; Cache-Control: no-cache" />
	<link rel="stylesheet" type="text/css" href="<?php echo $LMSPath;?>stylesheets/slider/default.css?r=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $LMSPath;?>stylesheets/slider/slider.css?r=<?php echo time(); ?>">
	<script type="text/javascript" src="js/jquery.colorbox.js?r=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="<?php echo $LMSPath;?>jsexternal/login-js.js?r=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="<?php echo $LMSPath;?>jsexternal/slider/slider.js?r=<?php echo time(); ?>"></script>
	<script>
		if (top.location != self.location){
			top.location.replace(self.location);
		}
	</script>
</head>
<body itemscope itemtype="http://schema.org/WebPage">
	<?php
	 include('includes/web_headerarea.php');
	?>
	<div id="content" class="clear">
		<div class="wrapper">
			
			<?php
			/*if(strpos($_SERVER["REQUEST_URI"],'?'))*/
			if( isset($_GET['LR']) || isset($_GET['LO']) || isset($_GET['NLI']) || isset($_GET['UN']) || isset($_GET['ISF']) || isset($_GET['PIDE']) || isset($_GET['IPE']) || isset($_GET['TE']) || isset($_GET['URLE'])  || isset($_GET['IUR']) || isset($_GET['CL']))
			{
			?>
				<div id="page_message">
					<div style="margin:0 auto; position:relative; width: 80%; text-align:center;">
						<span id="loginerrormsg" class="ui-corner-all">
							<p class="error_msg">
								<?php
								if(isset($_GET['LR'])){	// Logout Reminder
									echo "   <b>You have forgotten to logout in the last login.</b><br />"; 
									echo "    Please remember to logout the next time.<br /><br />"; 
									echo "   <a href=\"home/index.php\">Click here to continue ...</a>"; 
								} elseif(isset($_GET['LO'])){  // Logout
									echo "    You have logged out successfully. Thank you for logging on to ACE-Learning.<br />We are glad to be of service to you. Good bye!"; 
								} elseif(isset($_GET['NLI'])){  // NotLogIn, session expired
									echo "    You are not logged in (Unable to create session cookies). Please try again.<br />If you continue to see this message after the second login, please make sure your<br />browser is session cookies enabled. Click <a href=\"http://www.wikihow.com/Enable-Cookies-in-Your-Internet-Web-Browser\" style='text-decoration:underline' target='_blank'>here</a> to view the instructions."; 
								} elseif(isset($_GET['UN'])){  // Unauthorized 
									echo "You have attempted to access a restricted page without permission.<br />Please contact ACE-Learning Support.";	
								} elseif(isset($_GET['ISF'])){  // Unauthorized 
									echo "You have attempted to access a syllabus in which you are not registered for.<br />Please contact ACE-Learning Support."; 
								} else if(isset($_GET['PIDE'])){  // PArtner ID not recognize
								   echo "You are unable to be redirected into our system.<br /> Reason:&nbsp;&nbsp;Invalid Parnter ID supplied"; 
								} else if(isset($_GET['IPE'])){  // IP Address not recognize
									echo  "You are unable to be redirected into our system.<br />Reason:&nbsp;&nbsp;Invalid IP Address"; 
								} else if(isset($_GET['TE'])){  // Token not recognize
									 echo  "You are unable to be redirected into our system.<br />Reason:&nbsp;&nbsp;Invalid Token ID supplied"; 
								} else if(isset($_GET['IUR'])){  // Invalid Username
									echo "You are unable to be redirected into our system.<br />Reason:&nbsp;&nbsp;Unauthorised access"; 		
								} else if(isset($_GET['CL'])){  // Concurrent
								?>
								You have been logged out because of the following reasons:
								<br />
								<ul class="ace_list error_msg">
									<li>1. Your session has timed out.</li>
									<li>2. Your account has been accessed from another browser/computer.</li>
									<li style="padding-left:20px">If you suspect that someone else is using your account, please login again</li>
									<li style="padding-left:20px">and change your username/password immediately.</li>
									<li>3. If the problem persist, please clear your browser's cache and try again.</li>
									<li style="padding-left:20px"><a target='_blank' href="http://www.wikihow.com/Clear-Your-Browser%27s-Cache">How to clear your browser's cache?</a></li>
								</ul>
								<?php
								} else {
									echo "<div style='height:45px'>&nbsp;</div>";
								}
								?>
							</p>
						</span>
					</div>
				</div>
			<?php
			} else {
			?>	
				<?php
				if (isset($_GET['r'])){
					echo '<div id="page_message">';
					$rPage = $_GET['r'];
					$rCourse = $_GET['rC'];
					$Str = "";
					if ($rPage == "m"){
						$Str = "Mailbox >> Inbox";
					} elseif ($rPage == "hq"){  // Homework -> Quiz
						$Str = "Homework >> Quizzes";
					} elseif ($rPage == "hj"){  // Homework -> Journal
						$Str = "Homework >> Journals";	
					} elseif ($rPage == "hw"){  // Homework -> Worksheet
						$Str = "Homework >> Worksheets";
					} elseif ($rPage == "hp"){  // Homework -> PMP
						$Str = "Homework >> PMP";	
					} elseif ($rPage == "hl"){  // Homework -> Links
						$Str = "Homework >> Teachers' Links & Resources";	
					} elseif ($rPage == "hr"){  // Homework -> Resources
						$Str = "Homework >> Teachers' Links & Resources";	
					} elseif ($rPage == "ha"){  // Annotations
						$Str = "Subjects >> Syllabus >> Contents";	
					} elseif ($rPage == "hg"){  // Game Centre
						$Str = "Game Centre";	
					} elseif ($rPage == "he"){  // Homework -> Exploratory Activity
						$Str = "Homework >> Exploratory Activity";	
					}
				?>
					<div style="margin:0 auto; position:relative; width: 80%; text-align:center;">
						<span id="loginerrormsg" class="ui-corner-all">
							<p  class="error_msg">After logging into the system, you will be redirected to <?php echo $Str;?></p>
						</span>
					</div>
				<?php
				} else {
					echo '<div style="height:20px;" id="page_message">';
					//echo '<div id="page_message">';
				}
				?>
				</div>
			<?php
			}
			?>
			<div id="content_left" class="theme-default">
			   <div itemprop="breadcrumb" id="rotating_img" class="nivoSlider">
					<a href="overview.php" itemprop="url"><img src="images/website/Web_scene_01.jpg" alt="Overview"/></a>
					<a href="products.php" itemprop="url"><img src="images/website/Web_scene_02.jpg" alt="Products"/></a>
					<a href="eschool.php" itemprop="url"><img src="images/website/Web_scene_03.jpg" alt="E-Learning in School"/></a>
					<a href="mobileapps.php" itemprop="url"><img src="images/website/Web_scene_04.jpg" alt="Mobile Apps"/></a>
				</div>
				<div itemscope itemtype="http://schema.org/Product" id="price_area" class="clear" style="margin-top:13px;">
					<ul class="ul-h12">
						<li class="dl12 ui-corner-all" dest="products">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td class="td1"><span itemprop="name">Grade 7 - 12 Mathematics</span></td>
								</tr>
								<tr>
									<td class="td2"><img src="img/web/aboutus_overview.png" width="56" height="56" /></td>
								</tr>
								<tr>
									<td class="td3">
										<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
											<span itemprop="price">$9.99</span>/month
										</div>
									</td>
								</tr>
							</table>
						</li>
						<li class="dl12 ui-corner-all" dest="ea">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td class="td1"><span itemprop="name">Exploratory Activities</span></td>
								</tr>
								<tr>
									<td class="td2"><img src="img/web/product_elah_ea.png" width="56" height="56" /></td>
								</tr>
								<tr>
									<td class="td3">
										<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
											<span itemprop="price">$9.99</span>/month
										</div>
									</td>
								</tr>
							</table>
						</li>
						<li class="dl12 ui-corner-all" style="width:136px;" dest="pmp">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td class="td1"><span itemprop="name">Progressive Mastery Programme</span></td>
								</tr>
								<tr>
									<td class="td2"><img src="img/web/product_elah_pmp.png" width="56" height="56" /></td>
								</tr>
								<tr>
									<td class="td3">
										<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
											<span itemprop="price">$9.99</span>/month
										</div>
									</td>
								</tr>
							</table>
						</li>
						<li class="dl12 ui-corner-all" dest="itools">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td class="td1"><span itemprop="name">Interactive<br />Tools</span></td>
								</tr>
								<tr>
									<td class="td2"><img src="img/web/product_elah_it.png" width="56" height="56" /></td>
								</tr>
								<tr>
									<td class="td3">
										<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
											<span itemprop="price">$9.99</span>/month
										</div>
									</td>
								</tr>
							</table>
						</li>
						<li style="margin-right:0px;" class="dl12 ui-corner-all" dest="merk">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td class="td1"><span itemprop="name">Math Exam Revision Kit</span></td>
								</tr>
								<tr>
									<td class="td2"><img src="img/web/product_elah_merk.png" width="56" height="56" /></td>
								</tr>
								<tr>
									<td class="td3">
										<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
											<span itemprop="price">$9.99</span>/month
										</div>
									</td>
								</tr>
							</table>
						</li>
					</ul>
				</div>
			</div>
			<div id="content_right">
				<?php
				$boxspacing ="";
				$boxspacingEP ="";
				$errormessage ="";
				$boxspacingEU ="";
				if(isset($_GET['EU'])){
					$errormessage =  "Please enter your username.";
					$boxspacing="box_spacing_error_EU";
					$boxspacingEU="border_red";
				} elseif(isset($_GET['EP'])) {
					$errormessage =  "Please enter your password.";
					$boxspacing="box_spacing_error_EU";
					$boxspacingEP="border_red";
				} elseif(isset($_GET['IU'])) {
					$errormessage =  "You have entered an invalid username.<br />Please try again.";
					$boxspacing="box-spacing_error";
					$boxspacingEU="border_red";
				} elseif(isset($_GET['IP'])) {
					$errormessage =  "You have entered an invalid password.<br />Please try again.";
					$boxspacing="box-spacing_error";
					$boxspacingEP="border_red";
				} elseif(isset($_GET['AS'])) {
					$errormessage =  "Your account has been suspended.<br />Please contact ACE-Learning Support.";	
					$boxspacing="box-spacing_error";
				} else {
					$errorborder = "";
				}
				?>
				<div id="login_area" class="clear ui-corner-all box box-background">
					<form name="login_form" id="login_form" action="http://<?php echo $_SERVER['HTTP_HOST'];?>/w/index_login.php" method="POST">
						<div class="login_box clear">
							<input name="Username" id="Username" type="text" class="textfieldinput_rounded ui-corner-all username <?php echo $boxspacingEU; ?>" autocomplete="on" tabindex="1" value="<?php if(isset($_GET['U'])){echo $_GET['U']; }?>"/>
							<label for="Username"  id="label_user">Username</label>
						</div>
						<div class="login_box">
							<div id="password_box">
								<input name="Password" id="Password" type="password" class="textfieldinput_rounded ui-corner-all password  <?php echo $boxspacingEP; ?>" tabindex="2"  autocomplete="on" />
								<label for="Password" id="label_pass">Password</label>
							</div>
							<input name="login_submit" type="submit" value="Login" id="login_btn_box" class="ui-corner-all button_color" tabindex="3" />
						</div>
						<?php
						if(isset($_GET['EU']) || isset($_GET['EP']) || isset($_GET['IU']) || isset($_GET['IP']) || isset($_GET['AS'])){
							$login_error = "login_error_show";
						} else {
							$login_error="login_error_hide";
							$boxspacing="box-spacing_noerror";
						}
						?>
						<div class="login_box <?php echo $login_error; ?>">
							<p>
								<?php
								echo $errormessage;
								?>
							</p>
						</div>
						<div id="login_options_box" class="login_box">
							<input type="checkbox" name="remember_me" id="remember_me" value="1">
							<span class="remember">Remember me</span>
							<span class="seperator">&nbsp;</span>
							<span class="forgotpass"><a href="forgotpassword.php" >Forgot password?</a></span>
							<span class="forgotpass" style='clear:both;float:right'><a href="download/Getting_Started_Kit.pdf" target="_blank">Getting Started Kit</a></span>
						</div>
						<?php
						if (isset($_GET['r'])){
							echo "<input type=\"hidden\" name=\"r\" value=\"$rPage\" />\n";
							echo "<input type=\"hidden\" name=\"rC\" value=\"$rCourse\" />\n";
							if($rPage == "ha"){
								echo "<input type=\"hidden\" name=\"SyllabusType\" value=\"".$_GET['SyllabusType']."\" />\n";
								echo "<input type=\"hidden\" name=\"CTopicID\" value=\"".$_GET['CTopicID']."\" />\n";
							}
						}
						?>
						<input type="hidden" name="year" value="2015" />
					</form>
				</div>
				<div id="support" class="clear ui-corner-all widget_header_social <?php echo $boxspacing; ?>">
					<div class="widget_header">
						ACE-Learning Support
					</div>
					<ul>
						<li>
							&nbsp;<img src="images/website/Web_call_3.png" alt="call" />&nbsp;&nbsp;&nbsp;(65) 6848 9320
						</li>
						<li>
							<img src="images/website/Web_fax_3.png" alt="fax" />&nbsp;&nbsp;&nbsp;(65) 6848 9321
						</li>
						<li>
							<img src="images/website/Web_mail_3.png" alt="mail" style="margin-left:-5px;"/>&nbsp;&nbsp;&nbsp;support@acelearn.com
						</li>
					</ul>
				</div>
				<div id="socials" class="ui-corner-all widget_header_social <?php echo $boxspacing; ?>">
					<div class="widget_header">
						Connect with us
					</div>
					<ul class="widget_icons">
						<li style="width:45% !important; text-align:center; padding-left:3%">
							<a href="http://www.facebook.com/acelearningsystem" target="_blank">
								<img src="img/web/home_fb_logo.png" alt="facebook" />
								<p>Facebook</p>
							</a>
						</li>
						<li style="width:45% !important; float:right; padding-right:3%">
							<a href="http://www.twitter.com/acelearningsys/" target="_blank">
								<img src="img/web/home_tweet_logo.png" alt="twiiter"/>
								<p>Twitter</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<?php
		include('includes/web_footer.php');
		?>
	</div>
</body>
</html>
