<div class="line">
	<div class="display_center">
		<?php
			$pieces_BDD = $bdd->query('	SELECT Pieces.Id
										FROM Pieces
										WHERE Pieces.Nom = \'' . ucfirst($module) . '\'');
			$infos_piece = $pieces_BDD->fetch();
			$infos_sonde = donnees_piece_live($bdd, $infos_piece['Id']);
			//$infos = ['Tetat', 'temperature', 'Tideal', 'Hetat', 'humidite', 'Hideal', 'Retat', 'radiateur', 'reglage']
			$pieces_BDD->closeCursor();
		?>
		<div class="meteo">
			<div class="titre">
				<div class="lefttitre"></div>
				Temperature
			</div>
			<div class="cadre_center">
				<div class="liner"></div>
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
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<div class="meteo">
			<div class="titre">
				<div class="lefttitre"></div>
				Humidité
			</div>
			<div class="cadre_center">
				<div class="liner"></div>
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
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<div class="meteo">
			<div class="titre">
				<div class="lefttitre"></div>
				Radiateur
			</div>
			<div class="cadre_center">
				<div class="liner"></div>
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
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<div>
			<?php    
				/* Create and populate the pData object */ 
				$MyData = new pData();   
				$MyData->addPoints(array(-4,VOID,VOID,12,8,3),"Probe 1"); 
				$MyData->addPoints(array(18,18,18,18,18,18),"Ideal");  
				$MyData->setAxisName(0,"Temperatures"); 
				$MyData->addPoints(array("Jan","Feb","Mar","Apr","May","Jun"),"Labels"); 
				$MyData->setSerieDescription("Labels","Months"); 
				$MyData->setAbscissa("Labels"); 

				/* Create the pChart object */ 
				$myPicture = new pImage(700,230,$MyData); 

				/* Turn of Antialiasing */ 
				$myPicture->Antialias = FALSE; 

				/* Add a border to the picture */ 
				$myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0)); 
				  
				/* Write the chart title */  
				$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf","FontSize"=>11)); 
				$myPicture->drawText(150,35,"Temperature moyenne",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

				/* Set the default font */ 
				$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/pf_arma_five.ttf","FontSize"=>6)); 

				/* Define the chart area */ 
				$myPicture->setGraphArea(60,40,650,200); 

				/* Draw the scale */ 
				$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
				$myPicture->drawScale($scaleSettings); 

				/* Turn on Antialiasing */ 
				$myPicture->Antialias = TRUE; 

				/* Draw the line chart */ 
				$myPicture->drawLineChart(); 

				/* Write the chart legend */ 
				$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

				/* Render the picture (choose the best way) */ 
				$myPicture->render("temperaturegraph.png");
			?>
			<img src="temperaturegraph.png" class="graphique" />
		</div>
	</div>
	<div class="display_center">
		<div>
			<?php    
				/* Create and populate the pData object */ 
				$MyData = new pData();   
				$MyData->addPoints(array(-4,VOID,VOID,12,8,3),"Probe 1"); 
				$MyData->addPoints(array(18,18,18,18,18,18),"Ideal");  
				$MyData->setAxisName(0,"Temperatures"); 
				$MyData->addPoints(array("Jan","Feb","Mar","Apr","May","Jun"),"Labels"); 
				$MyData->setSerieDescription("Labels","Months"); 
				$MyData->setAbscissa("Labels"); 

				/* Create the pChart object */ 
				$myPicture = new pImage(700,230,$MyData); 

				/* Turn of Antialiasing */ 
				$myPicture->Antialias = FALSE; 

				/* Add a border to the picture */ 
				$myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0)); 
				  
				/* Write the chart title */  
				$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf","FontSize"=>11)); 
				$myPicture->drawText(150,35,"Temperature moyenne",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

				/* Set the default font */ 
				$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/pf_arma_five.ttf","FontSize"=>6)); 

				/* Define the chart area */ 
				$myPicture->setGraphArea(60,40,650,200); 

				/* Draw the scale */ 
				$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
				$myPicture->drawScale($scaleSettings); 

				/* Turn on Antialiasing */ 
				$myPicture->Antialias = TRUE; 

				/* Draw the line chart */ 
				$myPicture->drawLineChart(); 

				/* Write the chart legend */ 
				$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

				/* Render the picture (choose the best way) */ 
				$myPicture->render("humiditygraph.png");
			?>
			<img src="humiditygraph.png" class="graphique" />
		</div>
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="log">
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
											AND Codes.Id_Equipements = Equipements.Id
											AND ((Codes.Id > 100 AND Codes.Id < 300) OR (Codes.Id > 400 AND Codes.Id < 500))
											ORDER BY Logs.Heurodatage');
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