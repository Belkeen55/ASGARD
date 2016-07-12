<!/usr/bin/php>
<?php
	// ---- Chargement des modules
	include('/var/www/html/modules/BDD.php');
	
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
			add_log($bdd, $infos_equipement['Id'], $infos_equipement['Id'] + 300);
		}
	}
	$equipements_BDD->closeCursor();
?>
