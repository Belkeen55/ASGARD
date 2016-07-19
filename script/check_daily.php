<!/usr/bin/php>
<?php
	// ---- Chargement des librairies
	include('/var/www/html/lib/simple_html_dom.php');
	
	// ---- Chargement des modules
	include('/var/www/html/modules/BDD.php');
	
	$equipements_BDD = $bdd->query('SELECT Id, Ip 
									FROM Equipements
									WHERE Id_Type_Equip = 1');
	while($infos_equipement = $equipements_BDD->fetch()) {
		$html = file_get_html('http://' . $infos_equipement['Ip'] . '/daily.php');
		foreach($html->find('input[name=update]') as $element) 
		$update=$element->value;
		if($update == 'All packages are up to date.') {
			add_log($bdd, 500 + $infos_equipement['Id'], 600 + $infos_equipement['Id']);
		}
		else {
			add_log($bdd, 600 + $infos_equipement['Id'], 500 + $infos_equipement['Id']);
		}
	}
	$equipements_BDD->closeCursor();
?>
