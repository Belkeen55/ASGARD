<!/usr/bin/php>
<?php
	exec('mysqldump --user=utilisateur --password=mot_de_passe --databases base_de_deonnees > asgard.sql');
	exec('cp asgard.sql /media/docs/mysql/');
?>