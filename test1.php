<?php


     // Include SESSION.PHP
     // include ('../includes/session.php');
	// Calling MySQL connection
   // require ('../includes/mysql_connect.php');

	/*$QueryTest = "SELECT
					*
						FROM
							TBL_Users TBL_U
								WHERE
									TBL_U.UserID='".$_SESSION['SessionUserID']."'";
	$Result = mysql_query($QueryTest);

	if(mysql_affected_rows()>0)
	{
		$TempArray = array();
		while($Row = mysql_fetch_array($Result, MYSQL_ASSOC))
		{
			$TempArray[] = $Row;
		}
	}*/


	$mysql_password = 'ace';
	if (defined('DB_USER')==false) {DEFINE ('DB_USER', 'root');}
	if (defined('DB_PASSWORD')==false) {DEFINE ('DB_PASSWORD', 'ace123');}
	if (defined('DB_HOST')==false) {DEFINE ('DB_HOST', '192.168.1.81');} 
	// if (defined('DB_NAME')==false) {DEFINE ('DB_NAME', 'icinga');}
	if (defined('DB_NAME')==false) {DEFINE ('DB_NAME', 'test');}
 
	/*
	also need to update the db password in the following scripts
	/sys/flashservices/services/EUA.php
	/sys/flashservices/services/Game.php	for Single Player Game
	/sys/flashservices/services/AceGame/DBConnect.php	for Single Player Game

	*/

/*
     // for notebook server
     DEFINE ('DB_USER', 'pma');
     DEFINE ('DB_PASSWORD', 'pmapass');
     DEFINE ('DB_HOST', 'localhost');
     DEFINE ('DB_NAME', 'test');
*/

     // Open connection to database successful
     if ($DBC = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD)) {

          if (!mysql_select_db (DB_NAME)) {

               echo(mysql_errno());
               echo '<p>Error: Unable to select database!</p>';
               exit("<br />hellow ".mysql_errno().": ".mysql_error());

          }

     // Open connection to database unsuccessful
     } else {

          set_error_handler (mysql_errno(), 'Could not connect to the database: ' . mysql_error());
          echo '<p>Error: Unable to connect to database!</p>';
          exit("<br />Hi ".mysql_errno().": ".mysql_error());

     }
	 echo "test: ".$DBC;
	echo "connecting: ".$DBC;
	echo "<pre>";
?>
