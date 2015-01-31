<?php
	function GetUserIP() {

		if (isset($_SERVER)) {

			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
				return $_SERVER["HTTP_X_FORWARDED_FOR"];
			
			if (isset($_SERVER["HTTP_CLIENT_IP"]))
				return $_SERVER["HTTP_CLIENT_IP"];

			return $_SERVER["REMOTE_ADDR"];
		}

		if (getenv('HTTP_X_FORWARDED_FOR'))
			return getenv('HTTP_X_FORWARDED_FOR');

		if (getenv('HTTP_CLIENT_IP'))
			return getenv('HTTP_CLIENT_IP');

		return getenv('REMOTE_ADDR');
	}
	
	require ('includes/mysql_connect.php');
	
	$reDirectPath = "";
	
	if (substr ($_SERVER['HTTP_HOST'], -5) == "16080"){
		$reDirectPath = "http://" . $_SERVER['HTTP_HOST'] . "/". $SystemFolder ."";
	}else{
		$reDirectPath = "http://" . $_SERVER['HTTP_HOST'] . $VirtualPort . "/". $SystemFolder ."";
	}
	

	$ref = strtolower($_SERVER['HTTP_REFERER']);
	$sPt = strpos($ref, "//")+2;
	$cFac = array("/","?","!","@","#","$","%","^","&","*");
	$eNumA = array();
	foreach ($cFac as $cFaci){
		$tAt = strpos($ref, $cFaci , $sPt);
		if ($tAt!==false){
			$eNumA[] = $tAt;
		}
	}
	$ePt = strlen($ref);
	foreach ($eNumA as $eNumI){
		if($eNumI < $ePt){
			$ePt = $eNumI;
		}
	}
	$doma = substr($ref, $sPt, $ePt-$sPt);
	
	$IP_list[] = "203.116.232.92";  // mgs 1
	$IP_list[] = "10.172.140.128"; // mgs 2
	$IP_list[] = "123.100.251.87"; // Hillgrove Sec Sch (old)
	$IP_list[] = "203.81.58.220"; // Hillgrove Sec Sch (new)
	
	$IP_list[] = "116.12.212.165"; // arafath
	$IP_list[] = "202.172.233.115"; // Bishan Park Sec Sch - https://bpsnet.bishanparksec.moe.edu.sg
	$IP_list[] = "202.172.225.216"; // Singapore Sports School - http://elearn.sportsschool.edu.sg/
	
	$ipFrom = gethostbyname($doma);

	$DefaultUsername = trim($_POST['uID']);
	$DefaultPassword = isset($_POST['uID2']) ? trim($_POST['uID2']) : trim($_POST['uID']);
	/*
	echo "ipFrom : $ipFrom<br/>";
	echo "DefaultUsername : $DefaultUsername<br/>";
	echo "DefaultPassword : $DefaultPassword.<br/>";
	
	if (in_array($ipFrom, $IP_list)){ 
		echo "in";
	}
	*/
	
	if (in_array($ipFrom, $IP_list)){ 
		
		if (!empty($_POST['uID'])) {
			$DefaultUsername = trim($_POST['uID']);
			$DefaultPassword = isset($_POST['uID2']) ? trim($_POST['uID2']) : trim($_POST['uID']);
			$Query = "SELECT * FROM TBL_Users WHERE DefaultUsername='$DefaultUsername' AND DefaultPassword='$DefaultPassword'";
			$Result = mysql_query ($Query);

			if (mysql_affected_rows() == 1) {
				
				$Row = mysql_fetch_array ($Result);
				session_name('acelearn');
				session_cache_limiter('private, must-revalidate');
				session_start();
				$_SESSION = array();
				session_unset();
				session_destroy();
				$cookie_timeout = 60 * 12000; // in seconds (2 hours | 120 minutes)
				$garbage_timeout = $cookie_timeout + 60000; // in seconds
				ini_set('session.gc_maxlifetime', $garbage_timeout);
				
				session_name('acelearn');
				//$createdSessionID =  $Row['UserID'] . sha1(time());
				$createdSessionID =  $Row['UserID'] . md5(time());
				session_id ($createdSessionID);
				session_cache_limiter('private, must-revalidate');
				session_start();
				$_SESSION = array();
				
				$cookie_timeout = 60 * 12000; // in seconds (2 hours | 120 minutes)
				$garbage_timeout = $cookie_timeout + 60000; // in seconds
				ini_set('session.gc_maxlifetime', $garbage_timeout);
				
				$extraQ = "?sd=" . $createdSessionID;		
				$extraA = "&sd=" . $createdSessionID;
				
		
				// Declare session variables for all users
				$_SESSION['createdSessionID'] = $createdSessionID;
				$_SESSION['SessionUserID'] = $Row['UserID'];
				$_SESSION['SessionUsername'] = $Row['Username'];
				$_SESSION['SessionName'] = $Row['FirstName']." ".$Row['LastName'];
				$_SESSION['SessionUserTypeID'] = $Row['UserTypeID'];

				if ($Row['AccountStatusID']!='A') {

					// Redirect user to disabled page if account is not active
						  
					header ("Location:" . $reDirectPath . "/status.php?AS=1$extraA");
					mysql_close();
					exit();
						  
					header ("Location:" . $reDirectPath . "/Suspended.php$extraQ");
					mysql_close();
					exit();

				}
				
				// Declare additional variables
				
				$SessionSyllabiIDArr = "";
				$SessionCourseIDArr = "";
				
				switch ($Row['UserTypeID']) {

					// Guest
					case '1':

					// Retrieve SyllabiIDs
					$Query = "SELECT SyllabusID FROM TBL_GuestSyllabus WHERE UserID=".$_SESSION['SessionUserID']." ORDER BY SyllabusID";
					$Result = mysql_query($Query);

					if (mysql_affected_rows() > 0) {

						while ($Row = mysql_fetch_array($Result, MYSQL_NUM)) {

							if ($Row[0] != ""){
								$_SESSION['SessionSyllabiID'][] = $Row[0];
								$SessionSyllabiIDArr .= $Row[0] .',';
							}
						}

					}

					break;

					// Student
					case '2':

					// Retrive SchoolID and ClassID
					$Query = "SELECT SchoolID, ClassID, AskTeacherID, IndexID, Email FROM TBL_StudentsProfile WHERE UserID=".$_SESSION['SessionUserID']."";
					$Result = mysql_query($Query);

					if (mysql_affected_rows() > 0) {

						$Row = mysql_fetch_array($Result, MYSQL_NUM);

						$_SESSION['SessionSchoolID'] = $Row[0];
						$_SESSION['SessionClassID'] = $Row[1];
						$_SESSION['SessionAskTeacherID'] = $Row[2];
						$_SESSION['SessionIndexID'] = $Row[3];
						$_SESSION['SessionEmail'] = $Row[4];

						// Retrieve StreamID, EducationID and YearID
						$Query = "SELECT StreamID, EducationID, YearID FROM QRY_".$_SESSION['SessionSchoolID']."_Classes WHERE ClassID='".$_SESSION['SessionClassID']."'";
						$Result = mysql_query($Query);

						if (mysql_affected_rows() > 0) {

							$Row = mysql_fetch_array($Result, MYSQL_NUM);

							$_SESSION['SessionStreamID'] = $Row[0];
							$_SESSION['SessionEducationID'] = $Row[1];
							$_SESSION['SessionYearID'] = $Row[2];

						}
									
						
					}

					// Retrieve SyllabiIDs
					$Query = "SELECT SyllabusID FROM TBL_StudentsSyllabus WHERE UserID=".$_SESSION['SessionUserID']." ORDER BY SyllabusID";
					$Result = mysql_query($Query);

					if (mysql_affected_rows() > 0) {

						while ($Row = mysql_fetch_array($Result, MYSQL_NUM)) {
							
							if ($Row[0] != ""){
								$_SESSION['SessionSyllabiID'][] = $Row[0];
								$SessionSyllabiIDArr .= $Row[0] .',';
							}

						}

					}

					break;

					// Faculty
					case '3':

					// Retrive SchoolID
					$Query = "SELECT SchoolID, AskTeacherID, Email FROM TBL_FacultyProfile WHERE UserID=".$_SESSION['SessionUserID']."";
					$Result = mysql_query($Query);

					if (mysql_affected_rows() > 0) {

						$Row = mysql_fetch_array($Result, MYSQL_NUM);

						$_SESSION['SessionSchoolID'] = $Row[0];
						$_SESSION['SessionAskTeacherID'] = $Row[1];
						$_SESSION['SessionEmail'] = $Row[2];
									
						if ($_SESSION['SessionUserID']==4502){
									
							// Declare the Student's TimeZone according to the School's TZ setting
							$QueryS = "SELECT TBL_TZ.Timezone FROM TBL_SchoolsProfile TBL_SP, TBL_Timezones TBL_TZ WHERE TBL_TZ.TZID=TBL_SP.TZID AND TBL_SP.SchoolID='$Row[0]'";
							$ResultS = mysql_query($QueryS);
									
							if (mysql_affected_rows() > 0) {
										
								$RowS = mysql_fetch_array($ResultS, MYSQL_NUM);	
								//	date_default_timezone_set($RowS[0]);	
										
							}
							
						}
						
					}
							   
					// Retrieve Faculty's CourseIDs
					$Query = "SELECT TBL_MSY.CourseID FROM TBL_FacultySyllabus TBL_FSY, TBL_ModuleSyllabus TBL_MSY WHERE TBL_FSY.UserID=".$_SESSION['SessionUserID']." AND TBL_MSY.SyllabusID=TBL_FSY.SyllabusID GROUP BY TBL_MSY.CourseID";
					$Result = mysql_query($Query);
					
					if (mysql_affected_rows() > 0) {
						while ($Row = mysql_fetch_array($Result, MYSQL_NUM)) {
							if ($Row[0] != ""){
								$_SESSION['SessionCourseID'][] = $Row[0];
								$SessionCourseIDArr .= $Row[0] .',';
							}
						}
					}

					break;

					// MOE Personnel
					case '4':
					break;

					// ACE Admin
					case '5':
					break;

				}
				
				$SessionSyllabiIDArr = substr($SessionSyllabiIDArr, 0, -1);
				$SessionCourseIDArr = substr($SessionCourseIDArr, 0, -1);
				
				// check for online users
				$QueryL = "SELECT * FROM TBL_LogUsersCurrent WHERE UserID=".$_SESSION['SessionUserID']."";
				$ResultL = mysql_query($QueryL);
				
				if (mysql_affected_rows() > 0) {
					$QueryI = "UPDATE TBL_LogUsersCurrent 
								SET 
									LATime=Now(), SessionID='".session_id()."',
									createdSessionID='".$_SESSION['createdSessionID']."',			
									SessionUserID='".$_SESSION['SessionUserID']."',
									SessionUsername='".$_SESSION['SessionUsername']."',
									SessionName='".$_SESSION['SessionName']."',
									SessionUserTypeID='".$_SESSION['SessionUserTypeID']."',
									SessionSchoolID='".$_SESSION['SessionSchoolID']."',
									SessionClassID='".$_SESSION['SessionClassID']."',
									SessionAskTeacherID='".$_SESSION['SessionAskTeacherID']."',
									SessionIndexID='".$_SESSION['SessionIndexID']."',
									SessionEmail='".$_SESSION['SessionEmail']."',
									SessionStreamID='".$_SESSION['SessionStreamID']."',
									SessionEducationID='".$_SESSION['SessionEducationID']."',
									SessionYearID='".$_SESSION['SessionYearID']."',
									SessionSyllabiID='".$SessionSyllabiIDArr."',
									SessionCourseID='".$SessionCourseIDArr."',
									IPAddress='".GetUserIP()."'
								WHERE UserID=".$_SESSION['SessionUserID']."";	
					$ResultI = mysql_query($QueryI);
				}else{

					$QueryI = "INSERT INTO TBL_LogUsersCurrent 
								(UserID, SessionID, LATime, 
								createdSessionID, SessionUserID, SessionUsername,SessionName,SessionUserTypeID,
								SessionSchoolID,SessionClassID,SessionAskTeacherID,SessionIndexID,SessionEmail,
								SessionStreamID,SessionEducationID,SessionYearID,
								SessionSyllabiID,SessionCourseID,IPAddress) VALUES 
								('".$_SESSION['SessionUserID']."', '".session_id()."', Now(),
								'".$_SESSION['createdSessionID']."','".$_SESSION['SessionUserID']."','".$_SESSION['SessionUsername']."','".$_SESSION['SessionName']."','".$_SESSION['SessionUserTypeID']."',
								'".$_SESSION['SessionSchoolID']."','".$_SESSION['SessionClassID']."','".$_SESSION['SessionAskTeacherID']."','".$_SESSION['SessionIndexID']."','".$_SESSION['SessionEmail']."',
								'".$_SESSION['SessionStreamID']."','".$_SESSION['SessionEducationID']."','".$_SESSION['SessionYearID']."',
								'".$SessionSyllabiIDArr."','".$SessionCourseIDArr."','".GetUserIP()."'
								)";
					$ResultI = mysql_query($QueryI);
				}	
				
				
				if ($_SESSION['SessionUserTypeID']==2 || $_SESSION['SessionUserTypeID']==3){  // Log for Teachers and Students
					
					$TableName = "";
					$TableName = 'QRY_'.$_SESSION['SessionSchoolID'].'_LogUsers';
					
					// restrict for only single login
					// detect StatusID=1: if yes --> StatusID=0, create new row
					// mysql_conntect.php: update loguser if userid, sessionID and statusID=1 else log them out
					
					// Add in a new row
					$Query = "INSERT INTO $TableName (UserID, SessionID, ClientInfo, IPAddress, Referrer, Login, StatusID) VALUES (".$_SESSION['SessionUserID']." , '".session_id()."', '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['HTTP_PC_REMOTE_ADDR']."','".$_SERVER['HTTP_REFERER']."',Now(), 1)";
					$Result = mysql_query($Query);
					
					
					if ($_SESSION['SessionSchoolID']=="SG"){
						header ("Location:" . $reDirectPath . "/home/index.php$extraQ");
					}else{
						if ($_SESSION['SessionUserTypeID']==2){
								
							if (isset($_POST['r'])) {
										
								$rPage = $_POST['r'];
								$rCourse = $_POST['rC'];
										
								if ($rPage == "m"){
									header ("Location:" . $reDirectPath . "/mailbox/Inbox.php$extraQ");	
								}elseif ($rPage == "hq"){   // Homework -> Quiz
									header ("Location:" . $reDirectPath . "/homework/Quizzes.php?CourseID=$rCourse$extraA");	
								}elseif ($rPage == "hj"){   // Homework -> Journal
									header ("Location:" . $reDirectPath . "/homework/JHList.php?CourseID=$rCourse$extraA");	
								}elseif ($rPage == "hw"){   // Homework -> Worksheet
									header ("Location:" . $reDirectPath . "/homework/WorksheetsHW.php?CourseID=$rCourse$extraA");	
								}elseif ($rPage == "hp"){   // Homework -> PMP
									header ("Location:" . $reDirectPath . "/homework/PMP.php?CourseID=$rCourse$extraA");	
								}else{
									header ("Location:" . $reDirectPath . "/subjects/index.php$extraQ");
								}
										
							}else{
								header ("Location:" . $reDirectPath . "/subjects/index.php$extraQ");
							}
									
						}elseif ($_SESSION['SessionUserTypeID']==3){
									
							if (isset($_POST['r'])) {
										
								$rPage = $_POST['r'];
								$rCourse = $_POST['rC'];
										
								if ($rPage == "m"){
									header ("Location:" . $reDirectPath . "/mailbox/Inbox.php$extraQ");	
								}else{
									header ("Location:" . $reDirectPath . "/subjects/index.php$extraQ");
								}
										
							}else{
								header ("Location:" . $reDirectPath . "/subjects/index.php$extraQ");
							}
									
						}else{
							header ("Location:" . $reDirectPath . "/subjects/index.php$extraQ");
						}
					}
							
					mysql_close();
					exit();
					
				}else{ // Log for Other Users
					
					$Query = "INSERT INTO TBL_LogUsers (UserID, SessionID, ClientInfo, IPAddress, Referrer, LogIn, StatusID) VALUES (".$_SESSION['SessionUserID'].", '".session_id()."', '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['HTTP_PC_REMOTE_ADDR']."', '".$_SERVER['HTTP_REFERER']."', Now(), 1)";	                
					$Result = mysql_query($Query);

					// Redirect user to homepage once authentication is complete	                 	
					if ($_SESSION['SessionUserID']==3){
						header ("Location:" . $reDirectPath . "/forum/IntNatForumTopic.php?FSID=aa5eb561705bb1be67f4013980ad1131&ForumID=1$extraA");
					}else{
						header ("Location:" . $reDirectPath . "/home/index.php$extraQ");
					}
					
					mysql_close();
					exit();
					
				}
			}else {
				header ("Location:" . $reDirectPath . "/index.html");
				mysql_close();
				
				exit();
				$Str.= "<div>Username:$Username</div>";
				$Str.= "<div>Password:$Password</div>";
			}
		}else {
			header ("Location:" . $reDirectPath . "/index.html");
			mysql_close();
			echo "<div>$ipFrom==$IP</div>";
			echo "<div>doma:$doma</div>";
			exit();
		}
	}else {
		
		header ("Location:" . $reDirectPath . "/index.html");
		mysql_close();		
	
		exit();
	}
	
?>