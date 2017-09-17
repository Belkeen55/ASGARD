<!/usr/bin/php>
<?php
	// ---------- Verification des MAJ possible sur la machine ----------
	exec('sudo /usr/bin/apt update > /var/www/html/update.txt');
?>