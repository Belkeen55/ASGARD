<!/usr/bin/php>
<?php
	// ---- Chargement des librairies
	include('/var/www/html/lib/simple_html_dom.php');
	
	// ---- Chargement des modules
	include('/var/www/html/lib/BDD.php');
	include('/var/www/html/lib/meteo.php');
	include('/var/www/html/lib/network.php');
	include("/var/www/html/lib/Pchart/class/pDraw.class.php"); 
	include("/var/www/html/lib/Pchart/class/pImage.class.php"); 
	include("/var/www/html/lib/Pchart/class/pData.class.php");  
	include("/var/www/html/lib/Pchart/class/pPie.class.php"); 
	
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
	
	// ---------- Creation des graphiques des performances des 60 dernières minutes ----------
	$heurodatage = date('Y-m-d H:i:s');
	if(date('H') == 0) {
		$heurodatage24H = date('Y-m-d H:i:s', mktime(23, date('i'), date('s'), date('m'), date('d')-1, date('Y')));
	}
	else {
		$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H')-1, date('i'), date('s'), date('m'), date('d'), date('Y')));
	}
	$equipements_BDD = $bdd->query('SELECT Equipements.Id
									FROM Equipements');
	$Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>0, "DashR"=>255, "DashG"=>255, "DashB"=>255);
	$progressOptions = array("Width"=>165, "Height"=>15, "R"=>134, "G"=>209, "B"=>27, "Surrounding"=>20, "BoxBorderR"=>0, "BoxBorderG"=>0, "BoxBorderB"=>0, "BoxBackR"=>255, "BoxBackG"=>255, "BoxBackB"=>255, "RFade"=>255, "GFade"=>0, "BFade"=>0, "ShowLabel"=>TRUE, "LabelPos"=>LABEL_POS_LEFT);
	while($infos_equipement = $equipements_BDD->fetch()) {
		$performances_BDD = $bdd->query('	SELECT ROUND(AVG(Temperature)) AS Temp, ROUND(AVG(Cpu)) AS Proc, ROUND(AVG(Ram)) AS Vive, ROUND(AVG(Disque)) AS Rom
											FROM Performances 
											WHERE Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'
											AND Id_Equipements = ' . $infos_equipement['Id']);
		$nombre_performances = $performances_BDD->rowCount();
		if($nombre_performances != 0) {
			$infos_performance = $performances_BDD->fetch();
			$myPicture = new pImage(250,16);
	 		$myPicture->drawFilledRectangle(0,0,250,16,$Settings);
	 		$myPicture->setFontProperties(array("FontName"=>"/var/www/html/lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>15));
	 		$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
	 		$myPicture->drawProgress(50,0,$infos_performance['Proc'],$progressOptions);
	 		$myPicture->render('/var/www/html/Odin/progresscpu' . $infos_equipement['Id'] . '.png');
			
			$myPicture = new pImage(250,16);
	 		$myPicture->drawFilledRectangle(0,0,250,16,$Settings);
	 		$myPicture->setFontProperties(array("FontName"=>"/var/www/html/lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>15));
	 		$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
	 		$myPicture->drawProgress(50,0,$infos_performance['Temp'],$progressOptions);
	 		$myPicture->render('/var/www/html/Odin/progresstemp' . $infos_equipement['Id'] . '.png');
			
			$myPicture = new pImage(250,16);
	 		$myPicture->drawFilledRectangle(0,0,250,16,$Settings);
	 		$myPicture->setFontProperties(array("FontName"=>"/var/www/html/lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>15));
	 		$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
	 		$myPicture->drawProgress(50,0,$infos_performance['Vive'],$progressOptions);
	 		$myPicture->render('/var/www/html/Odin/progressram' . $infos_equipement['Id'] . '.png');
			
			$myPicture = new pImage(250,16);
	 		$myPicture->drawFilledRectangle(0,0,250,16,$Settings);
	 		$myPicture->setFontProperties(array("FontName"=>"/var/www/html/lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>15));
	 		$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
	 		$myPicture->drawProgress(50,0,$infos_performance['Rom'],$progressOptions);
	 		$myPicture->render('/var/www/html/Odin/progressrom' . $infos_equipement['Id'] . '.png');
		}
	}
	$equipements_BDD->closeCursor();
?>
