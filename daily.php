<!/usr/bin/php>
<?php
	include('lib/BDD.php');
	
	exec('sudo /usr/bin/apt update > /var/www/html/update.txt');
	suppr_log($bdd);
?>