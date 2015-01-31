<?php
$dbhost = '192.168.1.53';
$dbuser = 'root';
$dbpass = 'ace';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');

if($conn) echo("Connected!"); else echo("Failed");

//$dbname = 'petstore';
//mysql_select_db($dbname);
?>


<form action="testtables.php" method="post" target="_self">
	<input name="database" type="submit" value="Create Databases" />
    <br />
	<br />
    <table width="100%" border="0">
  <tr>
    <td>Database:</td>
    <td><input name="databasename" type="text" value="test1" /></td>
  </tr>
  <tr>
    <td>No. of Tables:</td>
    <td><input name="nooftables" type="text" value="50" /></td>
  </tr>
</table>
  
	<input name="tables" type="submit" value="Create Tables" />
    
</form>


<?php

if(isset($_POST['tables']))
{
	
	$dname = $_POST['databasename'];
	$dnumber = $_POST['nooftables'];
	echo("Creating Tables on $dname!<br/>");
	mysql_select_db($dname);
	for($i=1;$i<=$dnumber;$i++)
	{
		
		mysql_query("CREATE TABLE `table$i` (  `sample` TINYINT(1) UNSIGNED NULL ) COLLATE='latin1_swedish_ci' ENGINE=ndbcluster ROW_FORMAT=DEFAULT;");
		echo(mysql_error() . " - " . mysql_errno());
		echo("Table created: table$i <br/>");
//		sleep(.5);
	}
}

if(isset($_POST['database']))
{
	echo("Creating Databases!<br/>");
	for($i=1;$i<=10;$i++)
	{
		mysql_query("CREATE DATABASE `test$i`");
		echo("Created test$i");
	}
	
}




?>