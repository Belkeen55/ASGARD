<meta charset="utf-8" />
<?php
	$ua = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipad/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua) ) {
		//echo "<LINK rel="stylesheet" type="text/css" href="smartphones.css">";
		echo '<link rel="stylesheet" href="/css/mobile.css" />';
	}
	else {
		echo '<link rel="stylesheet" href="/css/newstyle.css" />';
	}
?>
<title>ASGARD</title>