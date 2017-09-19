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
				if(ping($sonde['Ip'])) {
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
	
	$pieces_BDD = $bdd->query('SELECT DISTINCT Id_Pieces
								FROM Mesures');
	while($infos_piece = $pieces_BDD->fetch()) {
		$infos_sonde = donnees_piece_live($bdd, $infos_piece['Id_Pieces']);
		$mesures_BDD = last_24($bdd, $infos_piece['Id_Pieces']);
		$nb_lignes = $mesures_BDD->rowCount();
		$i = 0;
		while($i < $nb_lignes) {
			$infos_mesure = $mesures_BDD->fetch();
			$date = date_create($infos_mesure['Heurodatage']);
			$abscisse[$i] = date_format($date, 'H');
			$temperatures[$i] = $infos_mesure['Tempint'];
			$temperatureideale[$i] = $infos_sonde['Tideal'];
			$humidites[$i] = $infos_mesure['Humidite'];
			$humiditeideale[$i] = $infos_sonde['Hideal'];
			$i++;
		}
		
		
		/* Create and populate the pData object */ 
		$MyData = new pData();   
		$MyData->addPoints($temperatures,"Temperature"); 
		$MyData->addPoints($temperatureideale,"Ideale");  
		$MyData->setAxisName(0,"Temperatures"); 
		$MyData->addPoints($abscisse,"Labels"); 
		$MyData->setSerieDescription("Labels","Hours"); 
		$MyData->setAbscissa("Labels"); 

		/* Create the pChart object */ 
		$myPicture = new pImage(700,230,$MyData); 

		/* Turn of Antialiasing */ 
		$myPicture->Antialias = FALSE; 

		/* Add a border to the picture */ 
		$myPicture->drawRectangle(0,0,699,229,array("R"=>255,"G"=>255,"B"=>255));  
		  
		/* Write the chart title */  
		$myPicture->setFontProperties(array("FontName"=>"/var/www/html/lib/Pchart/fonts/Forgotte.ttf","FontSize"=>11)); 
		$myPicture->drawText(100,45,"Temperature moyenne",array("FontSize"=>15,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

		/* Set the default font */ 
		$myPicture->setFontProperties(array("FontName"=>"/var/www/html/lib/Pchart/fonts/Forgotte.ttf","FontSize"=>6)); 

		/* Define the chart area */ 
		$myPicture->setGraphArea(60,40,650,200); 

		/* Draw the scale */ 
		$AxisBoundaries = array(0=>array("Min"=>10,"Max"=>30));
		$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_MANUAL, "ManualScale"=>$AxisBoundaries); 
		$myPicture->drawScale($scaleSettings); 

		/* Turn on Antialiasing */ 
		$myPicture->Antialias = TRUE; 

		/* Draw the line chart */ 
		$myPicture->drawLineChart(); 

		/* Write the chart legend */ 
		$myPicture->drawLegend(540,35,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

		/* Render the picture (choose the best way) */ 
		$myPicture->render('/var/www/html/Odin/temperaturegraph' . $infos_piece['Id_Pieces'] . '.png');
		
		/* Create and populate the pData object */ 
		$MyData = new pData();   
		$MyData->addPoints($humidites,"Humidité"); 
		$MyData->addPoints($humiditeideale,"Ideale");  
		$MyData->setAxisName(0,"Humidite"); 
		$MyData->addPoints($abscisse,"Labels"); 
		$MyData->setSerieDescription("Labels","Hours"); 
		$MyData->setAbscissa("Labels"); 

		/* Create the pChart object */ 
		$myPicture = new pImage(700,230,$MyData); 

		/* Turn of Antialiasing */ 
		$myPicture->Antialias = FALSE; 

		/* Add a border to the picture */ 
		$myPicture->drawRectangle(0,0,699,229,array("R"=>255,"G"=>255,"B"=>255)); 
		  
		/* Write the chart title */  
		$myPicture->setFontProperties(array("FontName"=>"/var/www/html/lib/Pchart/fonts/Forgotte.ttf","FontSize"=>11)); 
		$myPicture->drawText(100,45,"Humidité moyenne",array("FontSize"=>15,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

		/* Set the default font */ 
		$myPicture->setFontProperties(array("FontName"=>"/var/www/html/lib/Pchart/fonts/pf_arma_five.ttf","FontSize"=>6)); 

		/* Define the chart area */ 
		$myPicture->setGraphArea(60,40,650,200); 

		/* Draw the scale */ 
		$AxisBoundaries = array(0=>array("Min"=>10,"Max"=>70));
		$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_MANUAL, "ManualScale"=>$AxisBoundaries); 
		$myPicture->drawScale($scaleSettings); 

		/* Turn on Antialiasing */ 
		$myPicture->Antialias = TRUE; 

		/* Draw the line chart */ 
		$myPicture->drawLineChart(); 

		/* Write the chart legend */ 
		$myPicture->drawLegend(540,35,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

		/* Render the picture (choose the best way) */ 
		$myPicture->render('/var/www/html/Odin/humiditygraph' . $infos_piece['Id_Pieces'] . '.png');
		$mesures_BDD->closeCursor(); 
	}
?>
