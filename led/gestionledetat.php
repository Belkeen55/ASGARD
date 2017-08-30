<?php
	exec('/var/www/html/led/etat.py', $rep_cmd_etat);
	echo $rep_cmd_etat;
?>