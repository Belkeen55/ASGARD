<div class="line">
	<div class="display_center">
		<?php
			$equipements_BDD = $bdd->query('SELECT 	Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
											Pieces.Nom AS Location, Type_Equip.Id AS Type, Type_Equip.Image
											FROM Equipements, Pieces, Type_Equip
											WHERE Equipements.Id_Pieces = Pieces.Id
											AND Equipements.Id_Type_Equip = Type_Equip.Id
											AND Type_Equip.Id = 1');
			while($infos_equipement = $equipements_BDD->fetch()) {
				$connec = ping($infos_equipement['Ip']);
				if($connec == 'on') {
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
					
					/* Create the pChart object */
 					$myPicture = new pImage(100,30);

 					/* Draw the background */
 					$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
 					$myPicture->drawFilledRectangle(0,0,100,30,$Settings);

 					/* Overlay with a gradient */
 					$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
 					$myPicture->drawGradientArea(0,0,100,230,DIRECTION_VERTICAL,$Settings);
 					$myPicture->drawGradientArea(0,0,100,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

 					/* Add a border to the picture */
 					$myPicture->drawRectangle(0,0,99,29,array("R"=>0, "G"=>0, "B"=>0));
 
 					/* Write the picture title */ 
 					//$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Silkscreen.ttf", "FontSize"=>6));
 					//$myPicture->drawText(10,13, "drawProgress() - Simple progress bars",array("R"=>255, "G"=>255, "B"=>255)); 
 					
 					 /* Set the font & shadow options */ 
 					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>10));
 					$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
 					
 					/* Draw a progress bar */ 
 					$progressOptions = array("Width"=>100, "R"=>209, "G"=>198, "B"=>27, "Surrounding"=>20, "BoxBorderR"=>0, "BoxBorderG"=>0, "BoxBorderB"=>0, "BoxBackR"=>255, "BoxBackG"=>255, "BoxBackB"=>255, "ShowLabel"=>TRUE, "LabelPos"=>LABEL_POS_LEFT);
 					$myPicture->drawProgress(0,0,$cpu,$progressOptions);
 					
 					$myPicture->render("progresscpu.png"); 
				}
				else
				{
					$temperature = 'NA';
					$disque = 'NA';
					$cpu = 'NA';
					$ram = 'NA';
				}
		?>
		<div class="sonde">
			<a href="/Odin/fimafeng.php?module=<?php echo strtolower($infos_equipement['Id']); ?>" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					<?php echo $infos_equipement['Nom']; ?>
				</div>
			</a>
			<div class="cadre_left">
				
				<div class="liner"></div>
				<div class="lefttitre"></div>
				<div class="colonne">
					<div class="line">Etat : <?php echo $connec; ?></div>
					<div class="line">Temperature : <?php echo $temperature; ?>C</div>	
					<div class="line">CPU : <?php echo $cpu; ?>% <img src="progresscpu.png" /></div>
					<div class="line">RAM : <?php echo $ram; ?>Mo</div>
					<div class="line">ROM : <?php echo $disque; ?>Go</div>
				</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
				
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
			}
			$equipements_BDD->closeCursor();
		?>
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
											AND ((Codes.Id > 0 AND Codes.Id < 100) OR (Codes.Id > 300 AND Codes.Id < 400))
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