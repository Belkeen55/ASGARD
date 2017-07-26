<!/usr/bin/php>
<?php
	exec('mysqldump --user=root --password=shiva77680 --databases ASGARD > asgard.sql');
	exec('cp asgard.sql /media/docs/mysql/');
?>