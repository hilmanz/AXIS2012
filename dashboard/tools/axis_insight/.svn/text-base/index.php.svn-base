<?php
session_start();
unset($_SESSION["post"]);
unset($_SESSION["feed"]);
session_destroy();
$metrics = array("page_fans","page_feeds","page_posts","page_summary","page_posts_impressions"
    ,"page_stories","page_views_unique","page_views","page_impressions_unique"
    ,"page_fans_gender_age","page_fans_country","page_fans_city"
    ,"page_posts_impressions_unique","page_impressions_organic_unique","page_impressions_viral_unique"
    ,"page_impressions_paid_unique");

?>
<!DOCTYPE html>
<html>
    <head>
	<title>BOT List</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
	<h1>LIST BOT</h1>
	<hr>
	<ol>
	    <?php
		foreach($metrics as $metric){
	    ?>
		<li><a href="<?=$metric?>.php" target="_blank"><?=$metric?>.php</a></li>
	    <?php
		}
	    ?>
	</ol>	
    </body>
</html>
