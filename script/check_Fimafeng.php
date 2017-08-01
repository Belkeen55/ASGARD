<!/usr/bin/php>
<?php
	// ---- Chargement des modules
	include('/var/www/html/lib/simple_html_dom.php');
	include('/var/www/html/lib/BDD.php');
	
	
	// ---- On teste la présence d'equipements qui n'ont pas eu de clonage
	$equipements_BDD = $bdd->query('SELECT Id 
									FROM Equipements 
									WHERE (DATEDIFF(NOW(), Clonage) > 0
									OR Clonage IS NULL)
									AND Id_Type_Equip = 1');
	$nb_equipements = $equipements_BDD->rowCount();
	if($nb_equipements > 0) {
		// ---- On insert l'information dans la table warning
		while($infos_equipement = $equipements_BDD->fetch()) {
			logs($bdd, $infos_equipement['Id']);
		}
	}
	$equipements_BDD->closeCursor();
	
	// ---- On test le contenu de ligne update du dashboard de chaque raspberry
	$equipements_BDD = $bdd->query('SELECT Id, Ip 
									FROM Equipements
									WHERE Id_Type_Equip = 1');
	while($infos_equipement = $equipements_BDD->fetch()) {
		$html = file_get_html('http://' . $infos_equipement['Ip'] . '/script/systeme.php');
		foreach($html->find('input[name=update]') as $element) 
		$update=$element->value;
		if($update == 'Le système est à jour') {
			logs($bdd, 500 + $infos_equipement['Id']);
		}
		else {
			logs($bdd, 600 + $infos_equipement['Id']);
		}
	}
	$equipements_BDD->closeCursor();
?>
