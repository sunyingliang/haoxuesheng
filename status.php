<?php
include('includes/global_functions.php');
ClearAceSessions();
?>
<HTML>

<HEAD>

<LINK rel="shortcut icon" href="images/ACE-Learning.ico">
<TITLE>ACE-Learning :: The Best Online Math E-Learning Singapore</TITLE>
<META http-equiv=Cache-Control content=no-cache>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<META http-equiv=expires content=0>
<META http-equiv=Pragma content=no-cache>
<META content="ACE-Learning" name=Description>
<META name="keywords" content="E-learning, Maths,Mathematics,Secondary,Distance Learning,Learning, Singapore, Tutor, MOE, Practice, Online, Assessment, Practice, Lessons, Interactive,Activity,Animation,Computer,anti-Spyware,anti-virus,Best,Elementary,Additional,Video Lessons,Musics,Movies,Interactive Activity Games,Assessment Questions,Survey Resources Links,Web-site SMS Handphone,Email,Parent,Student,Teacher,/">
<script>
	if(parent.document.getElementById("canvas_frame"))
	{
		parent.document.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/sys/status.php?<?php echo $_SERVER["QUERY_STRING"];?>';
	}
	function breakout_of_frame()
	{
	  if (top.location != location) {
		top.location.href = document.location.href ;
	  }
	}
	/**
		redirect to new login page
	*/
	var currentlink = window.location.href;
	var newlink = currentlink.replace("status.php","index.php");
	window.location = newlink;
</script>
<link href="stylesheets/stylesheetWeb.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="jsexternal/jsexternal.js"></script>

</HEAD>

<BODY leftMargin=0 topMargin=0 scroll=auto marginheight="0" marginwidth="0" onload="document.loginform.Username.focus(); breakout_of_frame();">

	<TABLE cellSpacing=3 cellPadding=3 width=792 align="center"  background="images/web/bg-sidesG.jpg" >
	    <tr><td>	
	    
	        <TABLE cellSpacing=0 cellPadding=0 width=100% height=60 align=center border=0>
		<TR><TD>
      			<TABLE cellSpacing=0 cellPadding=0 width=100% border=0 >
        			<TR width=100%>
        			  <TD width="2%"></TD>	
        			  <TD width="38%" align="left">	
			        	<img src="images/ACE6.jpg" border=0>
			          </TD>
			          <td width="57%" align="right" >
			            <table>
			              <tr>
			                <td align="right">
			                  <p><a href="#" onmousedown="addBookmark('ACE-Learning - The Best Online Math E-Learning Singapore','http://ace-learning.com.sg')" title="Bookmark ACE-Learning for Future Visits!">Bookmark</a></p>
			                </td>
			              </tr>
			              <tr>
			                <td>
			                  <p class="Menu"><a href="index.html"><b>Home</b></a> <font color="#999999">&nbsp;|&nbsp;</font> <a href="AboutACE.html"><b>Programme & Features</b></a> <font color="#999999">&nbsp;|&nbsp;</font> <a href="SalesSupport.html"><b>Sales & Support</b></a> <font color="#999999">&nbsp;|&nbsp;</font> <a href="ACETeam.html"><b>Our Team</b></a></a></p>
			                </td>
			              </tr>
			            </table>
			            
			          </td>
			          
			           <TD width="3%"></TD>	
			        </TR>
                 	</TABLE>
                 	
    		</TD></TR>
    		</TABLE>
    		
    		<TABLE cellSpacing=0 cellPadding=0 width=100% align="center">
    		<TR width=100%>
    		    <TD width="3%"></TD>	
        	    <TD width="97%" align="left"><p>When it comes to fun in learning mathematics, ACE-Learning plays a leading role!</p></TD>
                </TR>
    		</TABLE>
		
		<TABLE cellSpacing=10 cellPadding=10 width=100% align=center border=0>
      		  <TR>
          	    <TD width=572 align=top valign=top>
      			
<?php	                                       			
	$Str = "";
	
	$rPage = "";
	
	if (isset($_GET['r'])){
		
		$rPage = $_GET['r'];
		$rCourse = $_GET['rC'];
		$Str .= "<TABLE cellSpacing=5 cellPadding=5 width=100% align=center bgColor=#FFFFFF class=\"TableBorder\">";
		
		$Str .= "  <tr><td>";
		$Str .= "    <p><b>Redirect ...</b></p>"; 
		$Str .= "  </td></tr>";
		
		$Str .= "  <tr><td>";
		$Str .= "    <p>";
		$Str .= "      After logging into the system, you will be redirected to<br>";
		
		if ($rPage == "m"){
			$Str .= "Mailbox >> Inbox";
		}elseif ($rPage == "hq"){   // Homework -> Quiz
			$Str .= "Homework >> Quiz";
		}elseif ($rPage == "hj"){   // Homework -> Journal
			$Str .= "Homework >> Journal";	
		}elseif ($rPage == "hw"){   // Homework -> Worksheet
			$Str .= "Homework >> Worksheet";
		}elseif ($rPage == "hp"){   // Homework -> PMP
			$Str .= "Homework >> PMP";	
		}elseif ($rPage == "hl"){   // Homework -> Links
			$Str .= "Homework >> Teacher's Resources & Links";	
		}elseif ($rPage == "hr"){   // Homework -> Resources
			$Str .= "Homework >> Teacher's Resources & Links";	
		}elseif ($rPage == "ha"){   // Annotations
			$Str .= "Subjects >> Syllabus >> Contents";	
		}elseif ($rPage == "hg"){   // Game Centre
			$Str .= "Game Centre";	
		}elseif ($rPage == "he"){   // Homework -> Exploratory Activity
			$Str .= "Homework >> Exploratory Activity";	
		}
		$Str .= "    </p>"; 
		$Str .= "  </td></tr>";
		
		$Str .= "</table>";
		
	}
	
	//if ( isset($_GET['EU']) || isset($_GET['EP']) || isset($_GET['IU']) || isset($_GET['IP']) || isset($_GET['AS']) || isset($_GET['LR']) || isset($_GET['LO']) || isset($_GET['NLI']) || isset($_GET['UN']) || isset($_GET['ISF']) ){
	if ( isset($_GET['EU']) || isset($_GET['EP']) || isset($_GET['IU']) || isset($_GET['IP']) || isset($_GET['AS']) || isset($_GET['LR']) || isset($_GET['LO']) || isset($_GET['NLI']) || isset($_GET['UN']) || isset($_GET['ISF']) || isset($_GET['PIDE']) || isset($_GET['IPE']) || isset($_GET['TE']) || isset($_GET['URLE'])  || isset($_GET['IUR']) || isset($_GET['CL'])){	
		$Str .= "<TABLE cellSpacing=5 cellPadding=5 width=100% align=center bgColor=#FFFFFF class=\"TableBorder\">";
		
		
		if (isset($_GET['EU'])){     	// Enter Username
			
			$Str .= "  <tr><td>";
		//	$Str .= "    <p class=\"Title\">Please enter your Username.</p>"; 
			$Str .= "    <p><b>Please enter your Username.</b></p>"; 
			$Str .= "  </td></tr>";
			
			
		}elseif(isset($_GET['EP'])){	// Enter Password
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>Please enter your Password.</b></p>"; 
			$Str .= "  </td></tr>";
			
			
		}elseif(isset($_GET['IU'])){	// Invalid Username
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have entered an invalid username.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please try again.</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
//			$Str .= "    <p><a href=\"fp.php\"><font color=\"#0000FF\">Click here if you have entered your email address in the system to retrieve the username and password.</font></a></p>"; 
			$Str .= "    <p><a href=\"fp.php\"><font color=\"#0000FF\">Click here to retrieve the username and password.</font></a></p>";
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>or</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Email your SCHOOL, CLASS, NAME and NRIC to <u>support@acelearn.com</u>. We will email you the username and password and you may need to check the Spam/Junk folder.
</p>"; 
			$Str .= "  </td></tr>";
			
		}elseif(isset($_GET['IP'])){	// Invalid Password
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have entered an Invalid Password.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please try again.</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
//			$Str .= "    <p><a href=\"fp.php\"><font color=\"#0000FF\">Click here if you have entered your email address in the system to retrieve the username and password.</font></a></p>"; 
			$Str .= "    <p><a href=\"fp.php\"><font color=\"#0000FF\">Click here to retrieve the username and password.</font></a></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>or</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Email your SCHOOL, CLASS, NAME and NRIC to <u>support@acelearn.com</u> to retrieve the username and password.</p>"; 
			$Str .= "  </td></tr>";
			
		}elseif(isset($_GET['AS'])){	// Account Suspended
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>Your account has been suspended.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please contact ACE-Learning to restore your account.</p>"; 
			$Str .= "  </td></tr>";
			
		}elseif(isset($_GET['LR'])){	// Logout Reminder
		//	include ('includes/session.php');
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have forgotten to logout in the last login.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please remember to logout the next time.</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p class=\"ForgotP\"> <a href=\"home/index.php\">Click here to continue ...</a></p>"; 
			$Str .= "  </td></tr>";
			
		}elseif(isset($_GET['LO'])){	// Logout
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have logged out successfully.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Thank you for logging on to ACE-Learning.<BR>We are glad to be of service to you. Good bye!</p>"; 
			$Str .= "  </td></tr>";
			
		}elseif(isset($_GET['NLI'])){	// NotLogIn
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You are not logged in (Unable to create session cookies).<br>Please login again.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>If you continue to see this message after 2nd login, please make sure your browser is session cookies enabled.</p>";
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p class=\"ForgotP\"><a href=\"javascript:openWindow('enableSC.html','Cookies',450,600)\">Click here to view the instructions.</a></p>"; 
			$Str .= "  </td></tr>";
			
		}elseif(isset($_GET['UN'])){	// Unauthorized 
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have attempted to access a restricted page without having the sufficient permissions.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please contact ACE-Learning to check your permission.</p>"; 
			$Str .= "  </td></tr>";	
			
		}elseif(isset($_GET['ISF'])){	// Unauthorized 
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have attempted to access a syllabus in which you are not registered for.<br><br>Future attempts on access unregistered syllabus will result in the suspension of your ACE account.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please contact ACE-Learning to check your account.</p>"; 
			$Str .= "  </td></tr>";
		}else if(isset($_GET['PIDE']))
		{	// PArtner ID not recognize
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have attempted to access a restricted page without having the sufficient permissions. Invalid Parnter ID supplied.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please contact ACE-Learning to check your account.</p>"; 
			$Str .= "  </td></tr>";
		}else if(isset($_GET['IPE']))
		{	// IP Address not recognize
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have attempted to access a restricted page without having the sufficient permissions. Unable to recognize IP Address.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please contact ACE-Learning to check your account.</p>"; 
			$Str .= "  </td></tr>";
		}
		else if(isset($_GET['TE']))
		{	// Token not recognize
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have attempted to access a restricted page without having the sufficient permissions. Invalid Token ID supplied.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please contact ACE-Learning to check your account.</p>"; 
			$Str .= "  </td></tr>";
		}
		else if(isset($_GET['URLE']))
		{	// IP Address not recognize
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have attempted to access a restricted page without having the sufficient permissions. Invalid URL Strings supplied.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please contact ACE-Learning to check your account.</p>"; 
			$Str .= "  </td></tr>";
		}else if(isset($_GET['IUR'])){	// Invalid Username
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have attempted to access a restricted page without having the sufficient permissions. Invalid user.</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Please try again.</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
//			$Str .= "    <p><a href=\"fp.php\"><font color=\"#0000FF\">Click here if you have entered your email address in the system to retrieve the username and password.</font></a></p>"; 
//			$Str .= "    <p><a href=\"fp.php\"><font color=\"#0000FF\">Click here to retrieve the username and password.</font></a></p>";
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>or</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>Email your SCHOOL, CLASS, NAME and NRIC to <u>support@acelearn.com</u>. We will email you the username and password and you may need to check the Spam/Junk folder.
</p>"; 
			$Str .= "  </td></tr>";
			
		}else if(isset($_GET['CL'])){	// Concurrent
			
			$Str .= "  <tr><td>";
			$Str .= "    <p><b>You have been logged out because of the following reasons:</b></p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>1. You've forgotten to logout after your last access.</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>2. Your account has been accessed from another browser/computer</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
			$Str .= "    <p>If you suspect that someone else is using your account, please login again and change your username/password immediately.</p>"; 
			$Str .= "  </td></tr>";
			$Str .= "  <tr><td>";
//			$Str .= "    <p><a href=\"fp.php\"><font color=\"#0000FF\">Click here if you have entered your email address in the system to retrieve the username and password.</font></a></p>"; 
//			$Str .= "    <p><a href=\"fp.php\"><font color=\"#0000FF\">Click here to retrieve the username and password.</font></a></p>";
			$Str .= "  </td></tr>";
			
		}
		
		
		$Str .= "</table>";
		
	}
	$Str .= "<br>";
        echo $Str;

?>      	
<?
/*		
      		       <TABLE cellSpacing=0 cellPadding=0 width=500 height=20 align=center bgColor=#ffffff border=0>
      			<tr><td align="left">
      			  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="500" height="200" id="WebFlash" align="middle">
			  <param name="allowScriptAccess" value="sameDomain" />
			  <param name="movie" value="images/web/WebFlash.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#000000" /><embed src="images/web/WebFlash.swf" quality="high" bgcolor="#000000" width="500" height="200" name="WebFlash" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			  </object>
      			</td></tr>
      			<tr>
      			  <td>
      			  <p>Samples:&nbsp; <a href="javascript:openWindow('SamplesAL.html','AnimatedLessons',450,600)">Animated Lessons</a> <font color="#999999">&nbsp;|&nbsp;</font> <a href="javascript:openWindow('SamplesIA.html','InteractiveActivity',450,600)">Interactive Activities</a> <font color="#999999">&nbsp;|&nbsp;</font> <a href="javascript:openWindow('SamplesAQ.html','AssessmentQuestions',780,600)">Assessment Questions</a></p>
      			  </td>
      			</tr>
      			</table>
      			
			<br>
      			<TABLE cellSpacing=5 cellPadding=5 width=100% align=center bgColor=#ffffff class="TableBorder">
      			<tr><td>
      			
      			<p>
      			<font color="#FF0000"><b>Learning Mathematics is FUN and rewarding with ACE-Learning</b></font>
      			<br><br>
      			It's no wonder that ACE-Learning is the <u>leading Mathematics E-Learning System</u>  in Singapore.
      			<br><br>
      			Over <u>45 secondary schools</u> are accessing our comprehensive online-learning resources and classroom teaching resources and are benefitting from it.
	        	<br><br>
	        	Why not join in the fun and bring our resources right up to your doorstep, anytime and anywhere.
	        	<br><br>
	        	It's easy. Call us at 6773 1081 for a demo*. Seeing is believing!
	        	<br><br>
	        	*Currently limited to school-based subscription.
	        	</p>
	        	
	        	<p><br><font color="#FF0000"><b>Year 2007 Achievements</b></font><br><br>
	        	
	        	    - Top math e-learning vendor in Singapore with 46 Secondary Schools subscribed<br><br>
	        	    - Catholic High School (Secondary)<br>&nbsp;&nbsp;Adoption of ACE-Learning System to replace the math textbook<br><br>
	        	   
	        	</p>
	        	
	        	<p><br><font color="#FF0000"><b>Acknowledgement</b></font><br><br>
	        	    We appreciate the contributions and collaboration with the Math department of all the schools especially the following:<br><br>
	        	    - <font color="#0000FF">Catholic High School (Secondary)</font><br>&nbsp;&nbsp;Customise content according to their Sec 1 and 2 Elementary Math syllabus<br><br>
	        	    - <font color="#0000FF">Chung Cheng High School (Main)</font><br>&nbsp;&nbsp;Customise content according to their Sec 3 Elementary & Additional Math syllabus<br><br>
	        	    - <font color="#0000FF">Bedok North Secondary School</font><br>&nbsp;&nbsp;Customise animated lessons for their 2006 O-Level Perlim Papers<br><br>
	        	    All the customised content is shared in the system. (<a href="SalesSupport.html">Call us for a free demo now!</a>)<br><br>
	        	</p>
	        	
	        	
	        	
	        	
	        	</td></tr>
			</table>

*/
?>		
		    </TD>
		    <TD width=200 align="top" valign="top">
		    	
      		           
      		           
	        	   <!--<form name="loginform" action="index.php" method="post">-->
	        	   <form name="loginform" action="index_noshell.php" method="post">
		            <table border="0" width="100%" height="90" cellspacing="1" cellpadding="1" background="images/web/loginBG.jpg">
		              <tr>
		                <td width="41%" align="right"><p class="ForgotP"><b>Username:</b></p></td>
		                <td width="59%" align="left"><p><input type="text" name="Username" size="15" style="width:100px" value="<?php	                                       			 echo($_GET['U']) ?>" class="FieldInput" onFocus="window.status='Enter your Username'; this.select()" onBlur="window.status=window.defaultStatus"/></p></td>
		              </tr>
		              <tr>
		                <td width="41%" align="right"><p class="ForgotP"><b>Password:</b></p></td>
		                <td width="59%" align="left"><p><input type="password" name="Password" size="15" style="width:100px" value="" class="FieldInput" onFocus="window.status='Enter your Password'; this.select()" onBlur="window.status=window.defaultStatus"/></p></td>
		              </tr>
		              <tr>
		                <td width="41%" align="right"><p class="ForgotP"><a href="fp.php">Forgot Password?</a></p></td>
		                <td width="59%" align="left">
		                <?php	                                       			
		                $Str = "";
		                $Str .= "<p><input type=\"submit\" name=\"Submit\" value=\"Login\" class=\"FieldButton\" style=\"width:75px\" /></p></td>";
		                if (isset($_GET['r'])){
		                	$Str .= "<input type=\"hidden\" name=\"r\" value=\"$rPage\" />\n";
		                	$Str .= "<input type=\"hidden\" name=\"rC\" value=\"$rCourse\" />\n";
		                	if($rPage == "ha")
							{
								$Str .= "<input type=\"hidden\" name=\"SyllabusType\" value=\"".$_GET['SyllabusType']."\" />\n";
								$Str .= "<input type=\"hidden\" name=\"CTopicID\" value=\"".$_GET['CTopicID']."\" />\n";
							}
		                }
		               // <p><input type="submit" name="Submit" value="Login" class="FieldButton" style="width:75px" /></p></td>
		                echo $Str;
		                ?>
		              </tr>
		            </table>
		          </form>
				
		             <table border="0" width="200" height="125" cellspacing="3" cellpadding="3" align="center" background="images/web/contact_info.jpg">
				<td><td></td></tr>
		   	    </table>       
			
			
			
			
			
			
	          </TD>
	          
	          
	          
          	  </TR>
      		</TABLE>
		
		<TABLE cellSpacing=0 cellPadding=0 width=740 height=1 align="center" bgcolor="#CCCCCC">
		<tr><td></td></tr> 
		</TABLE>
		
		<TABLE cellSpacing=3 cellPadding=3 width=100% align="center">
    		<TR><TD align="center"><p class="Small">&#169; 2011 ACE-Learning Systems Pte Ltd &nbsp;<a href="#">All rights reserved</a></p></TR>
    		</TABLE>
    		
            </td></tr>
	</TABLE>
	<TABLE cellSpacing=3 cellPadding=3 width=792 height=13 align="center"  background="images/web/bg-bottomG.jpg" >
    	  <tr><td align="center">
    	  </td></tr>
    	</TABLE>
</BODY>
</HTML>
