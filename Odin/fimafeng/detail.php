<?php
	//----------------------------------------------------------------------------------
	//			Recuperation des informations de l'equipement dispo en BDD
	//----------------------------------------------------------------------------------
	$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
									Pieces.Nom AS Location, Typ_Equip.Id AS Type, Typ_Equip.Nom AS Equipement, Equipements.Clonage
									FROM Equipements, Pieces, Typ_Equip
									WHERE Equipements.Id_Pieces = Pieces.Id
									AND Equipements.Id_Typ_Equip = Typ_Equip.Id
									AND Equipements.Id = ' . $_GET['id']);
	$infos_equipement = $equipements_BDD->fetch();
//----------------------------------------------------------------------------------
//					Script d'ouverture de popup pour edit des equipements
//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------
	//				Recuperation des informations live de la machine
	//----------------------------------------------------------------------------------
	$temperature = -1;
	$html = file_get_html('http://' . $infos_equipement['Ip'] . '/temppi.php');
	foreach($html->find('input[name=temperature]') as $element) 
	$temperature=$element->value;
	$disque = -1;
	foreach($html->find('input[name=disque]') as $element) 
	$disque=$element->value;
	$cpu = -1;
	foreach($html->find('input[name=cpu]') as $element) 
	$cpu=$element->value;
	$ram = -1;
	foreach($html->find('input[name=ram]') as $element) 
	$ram=$element->value;
	$uptime = -1;
	foreach($html->find('input[name=uptime]') as $element) 
	$uptime=$element->value;
	$update = -1;
	foreach($html->find('input[name=update]') as $element) 
	$update=$element->value;
	
	//----------------------------------------------------------------------------------
	//		Recuperation des données BDD de performances 10 dernieres minutes
	//----------------------------------------------------------------------------------
	$heurodatage = date('Y-m-d H:i:s');
	$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H'), date('i')-10, date('s'), date('m'), date('d'), date('Y')));
	$performances_BDD = $bdd->query('SELECT Heurodatage, Cpu, Ram, Id_Equipements
							FROM Performances 
							WHERE Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'
							AND Id_Equipements = ' . $infos_equipement['Id']);
	$i = 0;
	$nb_lignes = $performances_BDD->rowCount();
	if($nb_lignes != 0) {
		while($i < $nb_lignes) {
			$infos_performance = $performances_BDD->fetch();
			$abscisse[$i] = $i;
			$ram_10min[$i] = $infos_performance['Ram'];
			$cpu_10min[$i] = $infos_performance['Cpu'];
			$i++;
		}
		$performances_BDD->closeCursor();
	
		//----------------------------------------------------------------------------------
		//						Tracé du graphique des performances CPU
		//----------------------------------------------------------------------------------
		$MyData = new pData();   // Creation de l'objet data
		$MyData->addPoints($cpu_10min,"Charge");	// Données 
		$MyData->setAxisName(0,"Charge"); 
		$MyData->addPoints($abscisse,"Labels"); 	// Abscisses
		$MyData->setSerieDescription("Labels","Hour"); 
		$MyData->setAbscissa("Labels"); 
		$myPicture = new pImage(500,200,$MyData); 	// Création de l'objet image
		$myPicture->Antialias = FALSE; 				// Desactivation de antialiasing
		$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf","FontSize"=>11));	// Police du titre
		$myPicture->drawText(57,20,"Charge CPU",array("FontSize"=>12,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));		// Titre du graphique
		$myPicture->drawText(470,20,$cpu . '%',array("FontSize"=>12,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));			// Valeur actuelle
		$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/pf_arma_five.ttf","FontSize"=>6));	// Police par defaut
		$myPicture->setGraphArea(30,20,490,180);	// Implentation et taille du graphique
		//	Mise en place de l'echelle
		$AxisBoundaries = array(0=>array("Min"=>0,"Max"=>100));
		$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_MANUAL, "ManualScale"=>$AxisBoundaries); 
		$myPicture->drawScale($scaleSettings); 
		$myPicture->Antialias = TRUE; // Réactivation de l'antialiasing
		$Threshold = ""; 	// Initialisation du tableau de zone d'alerte
		$Threshold[] = array("Min"=>0,"Max"=>33,"R"=>207,"G"=>240,"B"=>20,"Alpha"=>70); 	// Zone d'alerte 1
		$Threshold[] = array("Min"=>33,"Max"=>66,"R"=>240,"G"=>232,"B"=>20,"Alpha"=>70); 	// Zone d'alerte 2
		$Threshold[] = array("Min"=>66,"Max"=>100,"R"=>240,"G"=>191,"B"=>20,"Alpha"=>70); 	// Zone d'alerte 3
		$myPicture->drawAreaChart(array("Threshold"=>$Threshold)); 	// Creation du graphique avec la zone d'alerte
		// Tracé des lignes des zones d'alerte
		$myPicture->drawThreshold(33,array("WriteCaption"=>TRUE,"Caption"=>"Warn Zone","Alpha"=>70,"Ticks"=>2,"R"=>0,"G"=>0,"B"=>255)); 
		$myPicture->drawThreshold(66,array("WriteCaption"=>TRUE,"Caption"=>"Error Zone","Alpha"=>70,"Ticks"=>2,"R"=>0,"G"=>0,"B"=>255)); 
		$myPicture->render('cpu' . $infos_equipement['Id'] . '.png'); // Creation de l'image du graphique
		
		//----------------------------------------------------------------------------------
		//						Tracé du graphique des performances RAM
		//----------------------------------------------------------------------------------
		$MyData = new pData();   // Creation de l'objet data
		$MyData->addPoints($ram_10min,"Charge"); 	// Données
		$MyData->setAxisName(0,"Charge"); 
		$MyData->addPoints($abscisse,"Labels"); 	// Abscisses
		$MyData->setSerieDescription("Labels","Hour"); 
		$MyData->setAbscissa("Labels"); 
		$myPicture = new pImage(500,200,$MyData); 	// Création de l'objet image
		$myPicture->Antialias = FALSE; 	// Desactivation de antialiasing 
		$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf","FontSize"=>11)); 	// Police du titre
		$myPicture->drawText(57,20,"RAM Utilisée",array("FontSize"=>12,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));		// Titre du graphique
		$myPicture->drawText(470,20,$ram . '%',array("FontSize"=>12,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));		// Valeur actuelle
		$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/pf_arma_five.ttf","FontSize"=>6)); 	// Police par defaut
		$myPicture->setGraphArea(30,20,490,180); 	// Implentation et taille du graphique
		//	Mise en place de l'echelle
		$AxisBoundaries = array(0=>array("Min"=>0,"Max"=>100));
		$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_MANUAL, "ManualScale"=>$AxisBoundaries); 
		$myPicture->drawScale($scaleSettings); 
		$myPicture->Antialias = TRUE; 	// Réactivation de l'antialiasing
		$Threshold = ""; 	// Initialisation du tableau de zone d'alerte
		$Threshold[] = array("Min"=>0,"Max"=>50,"R"=>207,"G"=>240,"B"=>20,"Alpha"=>70); 		// Zone d'alerte 1
		$Threshold[] = array("Min"=>50,"Max"=>75,"R"=>240,"G"=>232,"B"=>20,"Alpha"=>70); 		// Zone d'alerte 2
		$Threshold[] = array("Min"=>75,"Max"=>100,"R"=>240,"G"=>191,"B"=>20,"Alpha"=>70); 		// Zone d'alerte 3
		$myPicture->drawAreaChart(array("Threshold"=>$Threshold)); 		// Creation du graphique avec la zone d'alerte
		// Tracé des lignes des zones d'alerte
		$myPicture->drawThreshold(50,array("WriteCaption"=>TRUE,"Caption"=>"Warn Zone","Alpha"=>70,"Ticks"=>2,"R"=>0,"G"=>0,"B"=>255)); 
		$myPicture->drawThreshold(75,array("WriteCaption"=>TRUE,"Caption"=>"Error Zone","Alpha"=>70,"Ticks"=>2,"R"=>0,"G"=>0,"B"=>255));  
		$myPicture->render('ram' . $infos_equipement['Id'] . '.png');		// Creation de l'image du graphique
?>
<div class="line">
	<div class="display_center">
		<div class="performances">
			<img src="cpu<?php echo $infos_equipement['Id']; ?>.png"></img>
		</div>
		<div class="left1pct"></div>
		<div class="performances">
			<img src="ram<?php echo $infos_equipement['Id']; ?>.png"></img>
		</div>
	</div>
</div>
<?php
	}
	else {
?>
<div class="line">
	<div class="display_center">
		<div class="performances">
			Aucun historique disponible
		</div>
	</div>	
</div>
<?php
	}
	//----------------------------------------------------------------------------------
	//						Tracé du graphique d'occupation de disque
	//----------------------------------------------------------------------------------
	$MyData = new pData();	// Creation de l'objet data
	$MyData->addPoints(array(100-$disque,$disque),"ScoreA");	// Données
	$MyData->setSerieDescription("ScoreA","Application A"); 
	$MyData->addPoints(array("Free","Use"),"Labels");	// Abscisses
	$MyData->setAbscissa("Labels");
	$myPicture = new pImage(250,150,$MyData);	// Création de l'objet image
	//$myPicture->drawRectangle(0,0,249,259,array("R"=>0,"G"=>0,"B"=>0)); 
	$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));	// Police par defaut
	$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>50)); 
	$PieChart = new pPie($myPicture,$MyData);	// Creation objet circulaire
	$PieChart->draw2DRing(140,75,array("WriteValues"=>TRUE,"ValueR"=>0,"ValueG"=>0,"ValueB"=>0,"Border"=>TRUE));	// Implentation et taille du graphique
	// Gestion de la légende
	$myPicture->setShadow(FALSE); 
	$PieChart->drawPieLegend(5,5,array("Alpha"=>20)); 
	$myPicture->render('disk' . $infos_equipement['Id'] . '.png');	// Creation de l'image du graphique
?>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<div class="performances">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left"><?php echo $infos_equipement['Nom']; ?></div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Type : <?php echo $infos_equipement['Equipement']; ?></div>
						<div class="line">IP : <?php echo $infos_equipement['Ip']; ?></div>
						<div class="line">Uptime : <?php echo $uptime; ?></div>
						<div class="line">Temperature Proc : <?php echo $temperature; ?>°C</div>
						<div class="line">Update : <?php echo $update; ?></div>
						<div class="line">P. Clonage : <?php echo $infos_equipement['Clonage']; ?></div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<div class="inline-W200px">
			<div class="titre">
				<div class="lefttitre"></div>
				Disque dur
			</div>
			<div class="cadre_left">
				<img src="disk<?php echo $infos_equipement['Id']; ?>.png"></img>
			</div>
		</div>
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<a href="/Odin/fimafeng.php?module=global" class="black">Retour</a>
	</div>
</div>