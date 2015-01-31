<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include('includes/web_header.php');
?>
<script type="text/javascript" src="<?php echo $LMSPath;?>jsexternal/products-js.js"></script>
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
        <div id="products_content" class="box">
        	 <div class="title_page">
                    <h1>Resources</h1>
            </div>
            <div id="product_tabs" class="clear">
                   <ul id="product_nav">
                        <li>
                            <a href="#tab-1">Lessons</a>
                        </li>
						 <li>
                            <a href="#tab-2">Interactive Activities</a>
                        </li>
                        <li>
                            <a href="#tab-3">Assessment</a>
                        </li>
                       
                        
                   </ul>
                   <div id="tab-1" class="contents_area">
                   		<?php
							include('lessons.php');
						?>
                   </div>
			   <div id="tab-2" class="contents_area">
                       <?php
							include('interactiveactivities.php');
						?>
                   </div>
                   <div id="tab-3" class="contents_area">
                       <?php
							include('assesments.php');
						?>
                   </div>
			   
                   
                   
    	</div>
        </div><!--product contents-->
    </div><!--rwapper-->
    <?php
		include('includes/web_footer.php');
	?>
</div>
</body>
</html>
