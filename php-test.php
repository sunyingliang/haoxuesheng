<?
$iterations = 12;
if(isset($_SERVER['PHP_SELF'])) $PHP_SELF = $_SERVER['PHP_SELF'];
$starttime = explode(' ', microtime());
$string1 = 'abcdefghij';

for($i = 1; $i <= 20000; $i++)
{
$x=$i * 5;
$x=$x + $x;
$x=$x/10;
$string3 = $string1 . strrev($string1);
$string2 = substr($string1, 9, 1) . substr($string1, 0, 9);
$string1 = $string2;
}

$endtime = explode(' ', microtime());
$total_time = $endtime[0] + $endtime[1] - ($starttime[1] + $starttime[0]);
$total_time = round($total_time * 1000);

###################################################

if(isset($_GET['test'])) $test = $_GET['test'];
$test = (int)$test;
if(empty($test)) $test=0;

if(isset($_GET['ttimes']))
{
	$ttimes = $_GET['ttimes'];
	if($test>0 AND empty($ttimes)) { echo 'error'; die; }
	$itimes = explode('_', $ttimes);
	if(count($itimes)<$test)  { echo 'error 2'; die; }
}

$itimes[$test] = number_format($total_time,0);
$test_results = '';
$ttimes2 = '';
$TimesSum=0;

for($i = 0; $i <= $test; $i++)
{
	$itimes[$i] = (int)$itimes[$i];
	$TimesSum += $itimes[$i];
	$j=$i+1;
	$test_results .=  'Test #' . $j . ' completed in ' . $itimes[$i] . ' ms.<br>';
	$ttimes2 .= $itimes[$i];
	if($i < $test) $ttimes2 .= '_';
}

$test2 = $test+1;
$tquery = 'test=' . $test2 . '&ttimes=' . $ttimes2;
$tquery2 = $tquery . '&stop=1;';
$AverageAll = round($TimesSum/$test2);
$iterations2 = $iterations-1;
sort($itimes);
$lowest = $itimes[0];
$highest = $itimes[$test];
if(isset($_GET['stop'])) $stop = $_GET['stop'];
if(isset($stop)) $test = $iterations;

?>
<html><head>
<?
if($test<$iterations2) echo '<META HTTP-EQUIV="REFRESH" CONTENT="5; URL=' . $PHP_SELF . '?' . $tquery . '">';
?>
<title>Free PHP Benchmark Performance Script from Free-Webhosts.com</title>
<META name="ROBOTS" content="NOINDEX,NOFOLLOW">
<meta content="text/html; charset=windows-1252" http-equiv=content-type>
<meta http-equiv="Content-Style-Type" content="text/css">
</head>

<body>
<h1>Free PHP Benchmark Performance Script</h1>
<p><b><font face=Arial color="#999999" size=4>
<?

echo $test_results;
echo "<br>Lowest time: $lowest ms , Highest time : $highest ms<br>\n";
echo "Average of all $j times: <font size=\"+2\">$AverageAll ms</font><br>\n";
if($test2>2)
{
	$j-=2;
	$AverageMid = round(($TimesSum-$lowest-$highest)/$j);
	echo "Average of middle $j times: <font size=\"+2\">$AverageMid ms</font><br>\n";
}
echo '<br><a href="' . $PHP_SELF . '">Begin again</a>';
if($test<$iterations2) echo ' | <a href="' . $PHP_SELF . '?' . $tquery2 . '">Stop</a> | <font color=red>Doing ' . $iterations . ' iterations. Refreshing in 5 seconds...</font><br>';

?><br><br>
Copyright &copy; 2012 , <a href="http://www.bluespot.in/" target="_top"><b>BlueSpot Technologies</a><br></font></b>
</BODY></HTML>
