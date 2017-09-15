<!/usr/bin/php>
<?php
	// ---------- Import des librairies necessaires au script ----------
	include('/var/www/html/lib/simple_html_dom.php');
	include('/var/www/html/lib/BDD.php');
	include('/var/www/html/lib/network.php');
	
	// ---------- Verification des MAJ possibles sur l'element ----------
	exec('sudo /usr/bin/apt update > /var/www/html/update.txt');
	
	// ---------- Import des informations de MAJ de tous les éléments ----------
	$equipements_BDD = $bdd->query('SELECT Id, Nom, Ip 
									FROM Equipements');
	$i = 0;
	while($infos_equipement = $equipements_BDD->fetch()) {
		if(ping($infos_equipement['Ip'])) {
			$html = file_get_html('http://' . $infos_equipement['Ip'] . '/script/systeme.php');
			foreach($html->find('input[name=update]') as $element) 
			$update=$element->value;
			$MAJ_BDD = $bdd->query('SELECT MAJ.Id
									FROM MAJ
									WHERE MAJ.Id = ' . $infos_equipement['Id']);
			$nombre_MAJ = $MAJ_BDD->rowCount();
			if($nombre_MAJ == 0) {
				$bdd->exec('INSERT INTO MAJ(Id, Etat) 
							VALUES(' . $infos_equipement['Id'] . ', \'' . $update . '\')');	
			}
			else {
				$bdd->exec('UPDATE MAJ
							SET Etat = \'' . $update . '\' 
							WHERE Id = ' . $infos_equipement['Id']);
			}
			$MAJ_BDD->closeCursor();
			if(strpos($update, 'Le syst') != FALSE) {
				if($i == 0) {
					$liste = $infos_equipement['Nom'];
					$i = 1;
				}
				else {
					$liste = $liste . ', ' . $infos_equipement['Nom'];
					$i = $i + 1;
				}
			}
		}
	}
	if($i != 0) {
		exec('echo "' . 'MAJ en attente : ' . $liste . '" | /var/www/html/lib/./telegramsend.sh');
	}
	$equipements_BDD->closeCursor();
	
	// ---------- Verification des performances des éléments ----------
	$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom
									FROM Equipements');
	$nombre_equipements = $equipements_BDD->rowCount();
	$heurodatage = date('Y-m-d H:i:s');
	$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d')-1, date('Y')));
	if($nombre_equipements != 0) {
		while($infos_equipement = $equipements_BDD->fetch()) {
			$performances_BDD = $bdd->query('	SELECT COUNT(Id) AS Erreur
												FROM Performances
												WHERE Id_Equipements = ' . $infos_equipement['Id'] . '
												AND Cpu > 65
												AND Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'');
			$infos_performance = $performances_BDD->fetch();
			$Worktime = round(($infos_performance['Erreur']/1440)*100,0);
			$CPU_BDD = $bdd->query('SELECT CPU_Warning.Id
									FROM CPU_Warning
									WHERE CPU_Warning.Id = ' . $infos_equipement['Id']);
			$nombre_CPU = $CPU_BDD->rowCount();
			if($nombre_CPU == 0) {
				$bdd->exec('INSERT INTO CPU_Warning(Id, Etat) 
							VALUES(' . $infos_equipement['Id'] . ', \'' . $Worktime . '\')');	
			}
			else {
				$bdd->exec('UPDATE CPU_Warning
							SET Etat = \'' . $Worktime . '\' 
							WHERE Id = ' . $infos_equipement['Id']);
			}
			$CPU_BDD->closeCursor();
		}
		$performances_BDD->closeCursor();
	}
	$equipements_BDD->closeCursor();
	
	$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom
									FROM Equipements');
	$nombre_equipements = $equipements_BDD->rowCount();
	$heurodatage = date('Y-m-d H:i:s');
	$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d')-1, date('Y')));
	if($nombre_equipements != 0) {
		while($infos_equipement = $equipements_BDD->fetch()) {
			$performances_BDD = $bdd->query('	SELECT COUNT(Id) AS Erreur
												FROM Performances
												WHERE Id_Equipements = ' . $infos_equipement['Id'] . '
												AND Ram > 75
												AND Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'');
			$infos_performance = $performances_BDD->fetch();
			$Worktime = round(($infos_performance['Erreur']/1440)*100,0);
			$CPU_BDD = $bdd->query('SELECT Ram_Warning.Id
									FROM Ram_Warning
									WHERE Ram_Warning.Id = ' . $infos_equipement['Id']);
			$nombre_CPU = $CPU_BDD->rowCount();
			if($nombre_CPU == 0) {
				$bdd->exec('INSERT INTO Ram_Warning(Id, Etat) 
							VALUES(' . $infos_equipement['Id'] . ', \'' . $Worktime . '\')');	
			}
			else {
				$bdd->exec('UPDATE Ram_Warning
							SET Etat = \'' . $Worktime . '\' 
							WHERE Id = ' . $infos_equipement['Id']);
			}
			$CPU_BDD->closeCursor();
		}
		$performances_BDD->closeCursor();
	}
	$equipements_BDD->closeCursor();
	
	$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom
									FROM Equipements');
	$nombre_equipements = $equipements_BDD->rowCount();
	$heurodatage = date('Y-m-d H:i:s');
	$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d')-1, date('Y')));
	if($nombre_equipements != 0) {
		while($infos_equipement = $equipements_BDD->fetch()) {
			$performances_BDD = $bdd->query('	SELECT COUNT(Id) AS Erreur
												FROM Performances
												WHERE Id_Equipements = ' . $infos_equipement['Id'] . '
												AND Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'');
			$infos_performance = $performances_BDD->fetch();
			$Worktime = round(($infos_performance['Erreur']/1440)*100,0);
			$CPU_BDD = $bdd->query('SELECT Uptime_Warning.Id
									FROM Uptime_Warning
									WHERE Uptime_Warning.Id = ' . $infos_equipement['Id']);
			$nombre_CPU = $CPU_BDD->rowCount();
			if($nombre_CPU == 0) {
				$bdd->exec('INSERT INTO Uptime_Warning(Id, Etat) 
							VALUES(' . $infos_equipement['Id'] . ', \'' . $Worktime . '\')');	
			}
			else {
				$bdd->exec('UPDATE Uptime_Warning
							SET Etat = \'' . $Worktime . '\' 
							WHERE Id = ' . $infos_equipement['Id']);
			}
			$CPU_BDD->closeCursor();
		}
		$performances_BDD->closeCursor();
	}
	$equipements_BDD->closeCursor();
?>