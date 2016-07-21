<!/usr/bin/php>
<?php
	// ---- Chargement des librairies
	include('/var/www/html/lib/simple_html_dom.php');
	include('/var/www/html/lib/BDD.php');
	
	// ---- On teste la présence de mesure de moins d'une heure
	$equipements_BDD = $bdd->query('SELECT Id, Ip 
									FROM Equipements 
									WHERE Id_Type_Equip = 1');
	while($infos_equipement = $equipements_BDD->fetch()) {
		$html = file_get_html('http://' . $infos_equipement['Ip'] . '/temppi.php');
		foreach($html->find('input[name=cpu]') as $element) 
		$cpu=$element->value;
		foreach($html->find('input[name=ram]') as $element) 
		$ram=$element->value;
		$bdd->exec('INSERT INTO Performances(Heurodatage, Cpu, Ram, Id_Equipements) 
					VALUES(NOW(), ' . $cpu . ', '. $ram . ', '. $infos_equipement['Id'] . ')');
	}
	$equipements_BDD->closeCursor();
?>
