<?php
	$pieces_BDD = $bdd->query('	SELECT Pieces.Id, Pieces.Nom
										FROM Pieces
										WHERE Pieces.Nom = \'' . ucfirst($module) . '\'');
	$infos_piece = $pieces_BDD->fetch();
	$pieces_BDD->closeCursor();
	if(isset($_GET['action']))
	{
		if($_GET['action'] == 'update_radiateur') {
			$bdd->exec('UPDATE Radiateurs SET Radiateur =' . $_GET['radiateur'] . ' WHERE Id_Pieces = ' . $infos_piece['Id']);
		}
	}
	
	$infos_sonde = donnees_piece_live($bdd, $infos_piece['Id']);
	
	//$infos = ['Tetat', 'temperature', 'Tideal', 'Hetat', 'humidite', 'Hideal', 'Retat', 'radiateur', 'reglage']
	
	$equipements_BDD = $bdd->query('SELECT Equipements.Id
									FROM Pieces, Equipements
									WHERE Pieces.Id = ' . $infos_piece['Id'] . '
									AND Equipements.Id_Type_Equip = 2
									AND Equipements.Id_Pieces = Pieces.Id');
	$infos_equipement = $equipements_BDD->fetch();
	$equipements_BDD->closeCursor();
	$infos_radiateur = etat_radiateur_BDD($bdd, $infos_piece['Id']);
	if($infos_sonde['temperature'] <> -1) {
	
?>
	<div class="line">
		<div class="display_center">
			<div class="inline-H146px">
				<div class="titre">
					<div class="lefttitre"></div>
					Temperature
				</div>
				<div class="cadre_center">
					<div class="liner"></div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Actuel</div>
						<div class="liner"></div>
						<div class="line"><img src="/img/black/temperature<?php echo $infos_sonde['Tetat']; ?>.png" height="40"></img></div>
						<div class="liner"></div>
						<div class="line"><?php echo $infos_sonde['temperature']; ?>&deg;C</div>
					</div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Ideal</div>
						<div class="liner"></div>
						<div class="line"><img src="/img/black/temperatureok.png" height="40"></img></div>
						<div class="liner"></div>
						<div class="line"><?php echo (int)$infos_sonde['Tideal']; ?>&deg;C</div>
					</div>
					<div class="lefttitre"></div>
					<div class="liner"></div>
				</div>
			</div>
			<div class="left1pct"></div>
			<div class="inline-H146px">
				<div class="titre">
					<div class="lefttitre"></div>
					Humidité
				</div>
				<div class="cadre_center">
					<div class="liner"></div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Actuel</div>
						<div class="liner"></div>
						<div class="line"><img src="/img/black/humidity<?php echo $infos_sonde['Hetat']; ?>.png" height="40"></img></div>
						<div class="liner"></div>
						<div class="line"><?php echo $infos_sonde['humidite']; ?>%</div>
					</div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Ideal</div>
						<div class="liner"></div>
						<div class="line"><img src="/img/black/humidityok.png" height="40"></img></div>
						<div class="liner"></div>
						<div class="line"><?php echo (int)$infos_sonde['Hideal']; ?>%</div>
					</div>
					<div class="lefttitre"></div>
					<div class="liner"></div>
				</div>
			</div>
			<div class="left1pct"></div>
			<div class="inline-H146px">
				<div class="titre">
					<div class="lefttitre"></div>
					Radiateur
				</div>
				<div class="cadre_center">
					<div class="liner"></div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Actuel</div>
						<div class="liner"></div>
						<div class="line"><img src="/img/black/heater<?php echo $infos_sonde['Retat']; ?>.png" height="40"></img></div>
						<div class="liner"></div>
						<div class="line"><?php echo (int)$infos_sonde['radiateur']; ?></div>
					</div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Ideal</div>
						<div class="liner"></div>
						<div class="line"><img src="/img/black/heaterok.png" height="40"></img></div>
						<div class="liner"></div>
						<div class="line"><?php echo (int)$infos_sonde['reglage']; ?></div>
					</div>
					<div class="lefttitre"></div>
					<div class="liner"></div>
				</div>
			</div>
			<div class="left1pct"></div>
			<div class="inline-H146px">
				<div class="titre">
					<div class="lefttitre"></div>
					Reglage radiateur
				</div>
				<div class="cadre_center">
					<div class="liner"></div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<form action="sol.php" method="get">
							<div class="line">
								<input type="range" name="radiateur" value="<?php echo $infos_radiateur; ?>" max="5" min="0" step="1" oninput="document.getElementById('AfficheRange').textContent=value" />
							</div>
							<div class="line">
								<span id="AfficheRange"><?php echo (int)$infos_radiateur; ?></span>
							</div>
							<div class="liner"></div>
							<div class="line">
								<input type="submit" value="Enregistrer" />
							</div>	
							<input type="hidden" name="module" value="<?php echo $module; ?>" />
							<input type="hidden" name="action" value="update_radiateur" />
						</form>
					</div>
					<div class="lefttitre"></div>
					<div class="liner"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="liner"></div>
	<div class="liner"></div>
	<div class="liner"></div>
	<div class="line">
		<div class="display_center">
			<div>
				<?php
					$mesures_BDD = last_24($bdd, $infos_piece['Id']);
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
					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf","FontSize"=>11)); 
					$myPicture->drawText(100,45,"Temperature moyenne",array("FontSize"=>15,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

					/* Set the default font */ 
					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/pf_arma_five.ttf","FontSize"=>6)); 

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
					$myPicture->render("temperaturegraph.png");
				?>
				<img src="temperaturegraph.png" class="graphique" />
			</div>
		</div>
		<div class="liner"></div>
		<div class="display_center">
			<div>
				<?php    
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
					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf","FontSize"=>11)); 
					$myPicture->drawText(100,45,"Humidité moyenne",array("FontSize"=>15,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

					/* Set the default font */ 
					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/pf_arma_five.ttf","FontSize"=>6)); 

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
					$myPicture->render("humiditygraph.png");
					$mesures_BDD->closeCursor(); 
				?>
				<img src="humiditygraph.png" class="graphique" />
			</div>
		</div>
	</div>
<?php
	}
	else {
?>
		<div class="inline-W200px">
			<a href="/Odin/sol.php?module=<?php echo strtolower($infos_piece['Nom']); ?>" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					<?php echo $infos_piece['Nom']; ?>
				</div>
			</a>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="colonne">
					<div class="line">Equipement déconnecté</div>
					<div class="liner"></div>
				</div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
<?php
	}
?>
<div class="liner"></div>
<div class="line">
	<div class="full-screen">
		<a href="/Odin/fimafeng.php?module=sol" class="black">
			<div class="titre">
				<div class="lefttitre"></div>
				Logs
			</div>
		</a>
		<div class="cadre_left">
			<div class="liner"></div>
			<?php
				$logs_BDD = $bdd->query('	SELECT Logs.Heurodatage, Codes.Commentaire, Codes.Warning, Equipements.Nom 
											FROM Logs, Equipements, Codes
											WHERE Logs.Id_Codes = Codes.Id
											AND Equipements.Id = ' . $infos_equipement['Id'] . '
											AND Codes.Id_Equipements = Equipements.Id
											AND ((Codes.Id > 100 AND Codes.Id < 300) OR (Codes.Id > 400 AND Codes.Id < 500))
											ORDER BY Logs.Heurodatage DESC
											LIMIT 10');
				while($infos_log = $logs_BDD->fetch()) {
					if($infos_log['Warning']) {
						$warning = 'KO';
					}
					else {
						$warning = 'OK';
					}
			?>
					<div class="line">
						<img src="/img/log_<?php echo $warning; ?>.png" height=10></img>
						<?php echo $infos_log['Heurodatage']; ?> : <?php echo $infos_log['Nom']; ?> >> <?php echo $infos_log['Commentaire']; ?>
					</div>
			<?php
				}
				$logs_BDD->closeCursor();
			?>
			<div class="liner"></div>
		</div>
	</div>
</div>