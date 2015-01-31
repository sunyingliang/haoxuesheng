<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include('includes/web_header.php');
?>
<script>
	if(window.location.host=='www.ace-learning.com.sg' || window.location.host=='ace-learning.com.sg' || window.location.host=='ace-learning.com')
	{
		window.location = "http://www.ace-learning.com/privacy.php";
	}
</script>

</head>
<body>

<?php
 include('includes/web_headerarea.php');
?>
<div id="content" class="clear">
<?php
 include('includes/privacypolicy_details.php');

 include('includes/web_footer.php');
?>
</div>
</body>
</html>
