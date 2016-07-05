<!/usr/bin/php>
<?php
	// ---- Chargement des librairies
	include('/var/www/html/lib/simple_html_dom.php');
	
	// ---- Chargement des modules
	include('/var/www/html/modules/BDD.php');
	include('/var/www/html/modules/meteo.php');
	
	// ---- On teste la présence de mesure de moins d'une heure
	$mesures_BDD = $bdd->query('	SELECT Id 
									FROM Mesures 
									WHERE YEAR(Heurodatage) = YEAR(NOW())
									AND MONTH(Heurodatage) = MONTH(NOW())
									AND DAY(Heurodatage) = DAY(NOW())
									AND HOUR(Heurodatage) = HOUR(NOW())');
	$nb_mesures = $mesures_BDD->rowCount();
	if($nb_mesures<2) {
		// ---- Recuperation de la méteo
		$meteo = meteo_act_live();
		
		if(isset($meteo['temperature'])) {
			// ---- Recuperation des données de chacune des sondes
			$sondes_BDD = $bdd->query('	SELECT Id_Pieces, Ip 
										FROM Equipements
										WHERE Id_Type_Equip = 2');
			while($sonde = $sondes_BDD->fetch()) {
				$donnees_sonde = donnees_sonde_live($sonde['Ip']);
				if(($donnees_sonde['temperature'] > 0) AND ($donnees_sonde['humidite'] > 0)) {
					$radiateur_BDD = $bdd->query('	SELECT Radiateur 
													FROM Radiateurs 
													WHERE Id_Pieces = ' . $sonde['Id_Pieces']);
					$donnees_radiateur = $radiateur_BDD->fetch();
					$radiateur = $donnees_radiateur['Radiateur'];
					$radiateur_BDD->closeCursor();
					$bdd->exec('INSERT INTO Mesures(Heurodatage, Tempint, Tempext, Radiateur, Humidite, Id_Pieces) 
								VALUES(NOW(), ' . $donnees_sonde['temperature'] . ', '. $meteo['temperature'] . ', ' . $radiateur . ', '. $donnees_sonde['humidite'] . ', ' . $sonde['Id_Pieces'] . ')');
				}
				else {
					add_log($bdd, 6);
				}
			}
			$sondes_BDD->closeCursor();
			// ---- Envoi des données de la méteo actuelle
			$bdd->exec('DELETE FROM Meteo WHERE Id = 1');
			$bdd->exec('INSERT INTO Meteo(Id, Heurodatage, Code, Temperature, Humidite) 
						VALUES(1, NOW(), \'' . $meteo['code'] . '\', '. $meteo['temperature'] . ', ' . $meteo['humidite'] . ')');
			add_log($bdd, 1);
		}
		// ---- Recuperation des prévisions méteo
		add_previsions_BDD($bdd);
	}
	$mesures_BDD->closeCursor();
?>
