<!/usr/bin/php>
<?php
	// ---- Chargement des librairies
	include('/var/www/html/lib/simple_html_dom.php');
	
	// ---- Chargement des modules
	include('/var/www/html/lib/BDD.php');
	include('/var/www/html/lib/meteo.php');
	include('/var/www/html/lib/network.php');
	
	// ---- On teste la présence de mesure de moins d'une heure
	$meteo = meteo_act_live();
	echo $meteo['temperature'];
	$sondes_BDD = $bdd->query('	SELECT Id, Id_Pieces, Ip 
								FROM Equipements
								WHERE DHT22 = 1');
	while($sonde = $sondes_BDD->fetch()) {
		$mesures_BDD = $bdd->query('SELECT YEAR(Heurodatage), MONTH(Heurodatage), DAY(Heurodatage), HOUR(Heurodatage), Id_PIeces
									FROM Mesures 
									WHERE Id_Pieces = ' . $sonde['Id_Pieces'] . ' 
									AND YEAR(NOW()) = YEAR(Heurodatage)
									AND MONTH(NOW()) = MONTH(Heurodatage)
									AND DAY(NOW()) = DAY(Heurodatage)
									AND HOUR(NOW()) = HOUR(Heurodatage)');
		echo 'SELECT YEAR(Heurodatage), MONTH(Heurodatage), DAY(Heurodatage), HOUR(Heurodatage), Id_PIeces
									FROM Mesures 
									WHERE Id_Pieces = ' . $sonde['Id_Pieces'] . ' 
									AND YEAR(NOW()) = YEAR(Heurodatage)
									AND MONTH(NOW()) = MONTH(Heurodatage)
									AND DAY(NOW()) = DAY(Heurodatage)
									AND HOUR(NOW()) = HOUR(Heurodatage)';
		$nb_mesures = $mesures_BDD->rowCount();
		echo 'Piece ' . $sonde['Id_Pieces'] . ' Nb Resultat ' . $nb_mesures;
		if($nb_mesures<1) {
		// ---- Recuperation de la méteo
			echo 'essai ajout';
			if(isset($meteo['temperature'])) {
				// ---- Recuperation des données de chacune des sondes
				if(ping($sonde['Ip']) == 1) {
					$donnees_sonde = donnees_sonde_live($sonde['Ip']);
					if(($donnees_sonde['temperature'] > 0) AND ($donnees_sonde['humidite'] > 0)) {
						$bdd->exec('INSERT INTO Mesures(Heurodatage, Tempint, Tempext, Humidite, Id_Pieces) 
									VALUES(NOW(), ' . $donnees_sonde['temperature'] . ', '. $meteo['temperature'] .  ', '. $donnees_sonde['humidite'] . ', ' . $sonde['Id_Pieces'] . ')');
						echo 'INSERT INTO Mesures(Heurodatage, Tempint, Tempext, Radiateur, Humidite, Id_Pieces) 
									VALUES(NOW(), ' . $donnees_sonde['temperature'] . ', '. $meteo['temperature'] . ', '. $donnees_sonde['humidite'] . ', ' . $sonde['Id_Pieces'] . ')';
						echo '<br />';
					}
				}
			}
		}
		// ---- Recuperation des prévisions méteo	
	}
	$sondes_BDD->closeCursor();
	// ---- Envoi des données de la méteo actuelle
	$bdd->exec('DELETE FROM Meteo WHERE Id = 1');
	$bdd->exec('INSERT INTO Meteo(Id, Heurodatage, Code, Temperature, Humidite) 
				VALUES(1, NOW(), \'' . $meteo['code'] . '\', '. $meteo['temperature'] . ', ' . $meteo['humidite'] . ')');
	$mesures_BDD->closeCursor();
	add_previsions_BDD($bdd);
?>
