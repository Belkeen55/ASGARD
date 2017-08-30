<?php
	exec('sudo /usr/bin/python /var/www/html/led/etat.py', $rep_cmd_etat);
	var_dump($rep_cmd_etat);
?>