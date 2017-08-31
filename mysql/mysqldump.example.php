<!/usr/bin/php>
<?php
	exec('mysqldump --user=utilisateur --password=mot_de_passe --databases base_de_deonnees > asgard.sql');
	exec('cp asgard.sql /media/docs/mysql/');
	$fichier="/chemin/asgard.sql"; 
	$text=fopen($fichier,'r') or die("Fichier manquant"); 
	$contenu=file_get_contents($fichier); 
	$contenuMod=str_replace('BDD_Source', 'BDD_Cible', $contenu); 
	fclose($text); 
	$text2=fopen($fichier,'w+') or die("Fichier manquant"); 
	fwrite($text2,$contenuMod); 
	fclose($text2); 
	exec('mysql -u user -pmotdepasse -e "DROP DATABASE BDD_cible"');
	exec('mysql -u user -pmotdepasse -e "create database BDD_cible"');
	exec('mysql -u user -pmotdepasse -e "use BDD_cible"');
	exec('mysql -u user -pmotdepasse -e "source /chemin/asgard.sql"');
?>