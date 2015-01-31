<?php
/*
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	
	$ref = strtolower($_SERVER['HTTP_REFERER']);
	$sPt = strpos($ref, "//")+2;
	$cFac = array("/","?","!","@","#","$","%","^","&","*");
	$eNumA = array();
	foreach ($cFac as $cFaci)
	{
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
	*/
	
	//$ipFrom = gethostbyname($doma);
	$ipFrom=$_SERVER['REMOTE_ADDR'];
	
	$nric = $_GET['uID'];
	$token = $_GET['token'];
	$pID = $_GET['pID'];
	
	// ************** Add Partners' IDs **************
	$partneridArray=array('mconline','asknlearn','acpcomputer','learnaholic','arafath','elchemi');
	
	//no direct path to sys/msyql_connect..
	//www.ace-learning.com.sg/redirect.php?pID=mconline&uID=S1234567A&token=a3bee3cfbdf5ef4e320c8f1eb1346acd5000702b
	if(in_array($pID, $partneridArray))
	{
		header('Location: '.$uri.'/sys/redirect_mc_sys.php?uID='.$nric.'&ipRef='.$ipFrom.'&pID='.$pID.'&token='.$token."&ref=".$ref);
	}else
	{
		header('Location: '.$uri.'/sys/redirect_mc_sys.php?PIDE=1');
	}
	//echo $_GET['test']."====".$_GET['uID'];;
	/*if(!isset($_GET['test']))
	{
		header('Location: '.$uri.'/peter/sys/redirect_mc.php?uID='.$nric.'&ipRef='.$ipFrom);
	}else
	{
		header('Location: '.$uri.'/peter/sys/redirect_mc.php?uID='.$nric.'&ipRef='.$ipFrom.'&test=1');
	}*/
	exit;
?>
