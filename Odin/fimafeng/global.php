<div class="line">
	<div class="display_center">
		<?php
			$equipements_BDD = $bdd->query('SELECT 	Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
											Pieces.Nom AS Location, Type_Equip.Id AS Type, Type_Equip.Image
											FROM Equipements, Pieces, Type_Equip
											WHERE Equipements.Id_Pieces = Pieces.Id
											AND Equipements.Id_Type_Equip = Type_Equip.Id
											AND Type_Equip.Id = 1');
			
			$Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>0, "DashR"=>255, "DashG"=>255, "DashB"=>255);
			$progressOptions = array("Width"=>165, "Height"=>15, "R"=>134, "G"=>209, "B"=>27, "Surrounding"=>20, "BoxBorderR"=>0, "BoxBorderG"=>0, "BoxBorderB"=>0, "BoxBackR"=>255, "BoxBackG"=>255, "BoxBackB"=>255, "RFade"=>255, "GFade"=>0, "BFade"=>0, "ShowLabel"=>TRUE, "LabelPos"=>LABEL_POS_LEFT);
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
					$myPicture = new pImage(250,16);
 					$myPicture->drawFilledRectangle(0,0,250,16,$Settings);
 					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>15));
 					$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
 					$myPicture->drawProgress(50,0,$cpu,$progressOptions);
 					$myPicture->render('progresscpu' . $infos_equipement['Id'] . '.png');
					
					$myPicture = new pImage(250,16);
 					$myPicture->drawFilledRectangle(0,0,250,16,$Settings);
 					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>15));
 					$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
 					$myPicture->drawProgress(50,0, $temperature,$progressOptions);
 					$myPicture->render('progresstemp' . $infos_equipement['Id'] . '.png');
					
					$myPicture = new pImage(250,16);
 					$myPicture->drawFilledRectangle(0,0,250,16,$Settings);
 					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>15));
 					$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
 					$myPicture->drawProgress(50,0, $ram,$progressOptions);
 					$myPicture->render('progressram' . $infos_equipement['Id'] . '.png');
					
					$myPicture = new pImage(250,16);
 					$myPicture->drawFilledRectangle(0,0,250,16,$Settings);
 					$myPicture->setFontProperties(array("FontName"=>"../lib/Pchart/fonts/Forgotte.ttf", "FontSize"=>15));
 					$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20));
 					$myPicture->drawProgress(50,0, $disque,$progressOptions);
 					$myPicture->render('progressrom' . $infos_equipement['Id'] . '.png');
				}
		?>
		<div class="inline-W350px">
			<a href="/Odin/fimafeng.php?module=<?php echo strtolower($infos_equipement['Id']); ?>" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					<?php echo $infos_equipement['Nom']; 
						if($connec == 'on') {
					?> 
					<img src="/img/log_OK.png" height=10></img>
				</div>
			</a>
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">IP : <?php echo $infos_equipement['Ip']; ?></div>
						<div class="line"><div class="inline-W17pct-left">Temp : </div><div class="inline-W80pct-right"><img src="progresstemp<?php echo $infos_equipement['Id']; ?>.png" /></div></div>
						<div class="line"><div class="inline-W17pct-left">CPU : </div><div class="inline-W80pct-right"><img src="progresscpu<?php echo $infos_equipement['Id']; ?>.png" /></div></div>
						<div class="line"><div class="inline-W17pct-left">RAM : </div><div class="inline-W80pct-right"><img src="progressram<?php echo $infos_equipement['Id']; ?>.png" /></div></div>
						<div class="line"><div class="inline-W17pct-left">ROM : </div><div class="inline-W80pct-right"><img src="progressrom<?php echo $infos_equipement['Id']; ?>.png" /></div></div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
						}
						else {
		?>
			<img src="/img/log_KO.png" height=10></img>
				</div>
			</a>
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Equipement non connecté</div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
						}
			}
			$equipements_BDD->closeCursor();
		?>
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<?php
			$equipements_BDD = $bdd->query('SELECT 	Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
											Pieces.Nom AS Location, Type_Equip.Id AS Type, Type_Equip.Image
											FROM Equipements, Pieces, Type_Equip
											WHERE Equipements.Id_Pieces = Pieces.Id
											AND Equipements.Id_Type_Equip = Type_Equip.Id
											AND Type_Equip.Id = 2');
			while($infos_equipement = $equipements_BDD->fetch()) {
				$connec = ping($infos_equipement['Ip']);
				if($connec == 'on') {
					$infos_sonde = donnees_sonde_live($infos_equipement['Ip']);
				}
		?>
		<div class="inline-W350px">
			<a href="/Odin/fimafeng.php?module=<?php echo strtolower($infos_equipement['Id']); ?>" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					<?php echo $infos_equipement['Nom']; 
						if($connec == 'on') {
					?> 
					<img src="/img/log_OK.png" height=10></img>
				</div>
			</a>
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">IP : <?php echo $infos_equipement['Ip']; ?></div>
						<div class="line">Temp : <?php echo (int)$infos_sonde['temperature']; ?>°C</div>
						<div class="line">Hum : <?php echo (int)$infos_sonde['humidite']; ?>%</div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
						}
						else {
		?>
			<img src="/img/log_KO.png" height=10></img>
				</div>
			</a>
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Equipement non connecté</div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
						}
			}
			$equipements_BDD->closeCursor();
		?>
	</div>
</div>
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
											AND Codes.Id_Equipements = Equipements.Id
											AND ((Codes.Id > 0 AND Codes.Id < 100) OR (Codes.Id > 300 AND Codes.Id < 400) OR (Codes.Id > 500 AND Codes.Id < 600))
											ORDER BY Logs.Heurodatage DESC');
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