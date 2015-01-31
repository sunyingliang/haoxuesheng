<?php
/*
WHMCS AutoAuth Demo Script
Docs: http://docs.whmcs.com/AutoAuth
*/
/*
# Define WHMCS URL & AutoAuth Key
$whmcsurl = "http://billing.ace-learning.com/dologin.php";
$autoauthkey = "aceXYZ123";

$timestamp = time(); # Get current timestamp
$email = "k.zaruk@gmail.com"; # Clients Email Address to Login
$goto = "clientarea.php?action=products";
//$goto = "";

$hash = sha1($email.$timestamp.$autoauthkey); # Generate Hash

# Generate AutoAuth URL & Redirect
$url = $whmcsurl."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
header("Location: $url");
exit;
*/
?>

<?php
//
// A very simple PHP example that sends a HTTP POST to a remote site
//

/*$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://billing.ace-learning.com/dologin.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "postvar1=value1&postvar2=value2&postvar3=value3");

// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
// http_build_query(array('postvar1' => 'value1')));

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);*/

# Define WHMCS URL & AutoAuth Key
$whmcsurl = "http://billing.ace-learning.com/dologin.php";
$autoauthkey = "aceXYZ123";

$timestamp = time(); # Get current timestamp
$email = "k.zaruk@gmail.com"; # Clients Email Address to Login
//$goto = "clientarea.php?action=products";
$goto = "clientarea.php?action=products";
$hash = sha1($email.$timestamp.$autoauthkey); # Generate Hash

$qry_str = "?email=$email&timestamp=$timestamp&hash=$hash&goto=$goto";
$ch = curl_init();

// Set query data here with the URL
curl_setopt($ch, CURLOPT_URL, $whmcsurl . $qry_str); 

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '3');
$content = trim(curl_exec($ch));
curl_close($ch)

// further processing ....
if ($server_output == "OK") { echo "yes"; } else { echo "no"; }
;
?>