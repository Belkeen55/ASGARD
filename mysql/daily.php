<!/usr/bin/php>
<?php
	// ---------- Verification des MAJ possible sur la machine ----------
	exec('sudo /usr/bin/apt update > /var/www/html/update.txt');
	
	// ---------- Sauvegarde de la base de données ----------
	exec('mysql -u belkeen -pshiva77680 -e "use ASGARD"');
	exec('mysql -u belkeen -pshiva77680 -e "DELETE FROM Performances WHERE MINUTE(Heurodatage) <> 0 AND YEAR(Heurodatage) <= YEAR(NOW()) AND MONTH(Heurodatage) <= MONTH(NOW())-1 AND DAY(Heurodatage) <= DAY(NOW())"');
	exec('mysql -u belkeen -pshiva77680 -e "DELETE FROM Mesures WHERE MINUTE(Heurodatage) <> 0 AND YEAR(Heurodatage) <= YEAR(NOW()) AND MONTH(Heurodatage) <= MONTH(NOW())-1 AND DAY(Heurodatage) <= DAY(NOW())"');
	exec('sudo mount -a');
	exec('mysqldump --user=root --password=shiva77680 --databases ASGARD > asgard.sql');
	exec('cp asgard.sql /media/docs/mysql/');
	$fichier="/home/belkeen/asgard.sql"; 
	$text=fopen($fichier,'r') or die("Fichier manquant"); 
	$contenu=file_get_contents($fichier); 
	$contenuMod=str_replace('ASGARD', 'ASGARDTEST', $contenu); 
	fclose($text); 
	$text2=fopen($fichier,'w+') or die("Fichier manquant"); 
	fwrite($text2,$contenuMod); 
	fclose($text2); 
	exec('mysql -u belkeen -pshiva77680 -e "DROP DATABASE ASGARDTEST"');
	exec('mysql -u belkeen -pshiva77680 -e "create database ASGARDTEST"');
	exec('mysql -u belkeen -pshiva77680 -e "use ASGARDTEST"');
	exec('mysql -u belkeen -pshiva77680 -e "source /home/belkeen/asgard.sql"');
?>