<div class="line">
	<div class="display_center">
		<?php
			$equipements_BDD = $bdd->query('SELECT 	Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
											Pieces.Nom AS Location, Typ_Equip.Id AS Type, Typ_Equip.Image
											FROM Equipements, Pieces, Typ_Equip
											WHERE Equipements.Id_Pieces = Pieces.Id
											AND Equipements.Id_Typ_Equip = Typ_Equip.Id');
			
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
			<a href="/Odin/fimafeng.php?module=detail&id=<?php echo $infos_equipement['Id']; ?>" class="black">
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