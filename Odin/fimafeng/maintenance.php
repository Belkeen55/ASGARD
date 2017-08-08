<?php
	//----------------------------------------------------------------------------------
	//			Recuperation des informations de l'equipement dispo en BDD
	//----------------------------------------------------------------------------------
	$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
									Pieces.Nom AS Location, Typ_Equip.Id AS Type, Typ_Equip.Nom AS Equipement, Equipements.Clonage
									FROM Equipements, Pieces, Typ_Equip
									WHERE Equipements.Id_Pieces = Pieces.Id
									AND Equipements.Id_Typ_Equip = Typ_Equip.Id');
	$nombre_equipements = $equipements_BDD->rowCount();
?>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<div class="performances">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left">Mise à jour à faire</div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<?php
							if($nombre_equipements != 0) {
								while($infos_equipement = $equipements_BDD->fetch()) {
									$connec = ping($infos_equipement['Ip']);
							//----------------------------------------------------------------------------------
							//					Script d'ouverture de popup pour edit des equipements
							//----------------------------------------------------------------------------------
									if($connec == 1) {				// Et qu'il est pingable
									//----------------------------------------------------------------------------------
									//				Recuperation des informations live de la machine
									//----------------------------------------------------------------------------------
										$temperature = -1;
										$html = file_get_html('http://' . $infos_equipement['Ip'] . '/script/systeme.php');
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
										if($update != 'Le système est à jour') {
						?>
						<div class="line"><?php echo $infos_equipement['Nom'] . ' : ' . $update; ?></div>
						<?php
										}
									}
								}
								$equipements_BDD->closeCursor();
							}
						?>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="performances">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left">Surcharge CPU</div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<?php
							$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
															Pieces.Nom AS Location, Typ_Equip.Id AS Type, Typ_Equip.Nom AS Equipement, Equipements.Clonage
															FROM Equipements, Pieces, Typ_Equip
															WHERE Equipements.Id_Pieces = Pieces.Id
															AND Equipements.Id_Typ_Equip = Typ_Equip.Id');
							$nombre_equipements = $equipements_BDD->rowCount();
								$heurodatage = date('Y-m-d H:i:s');
								$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d')-1, date('Y')));
							if($nombre_equipements != 0) {
								while($infos_equipement = $equipements_BDD->fetch()) {
									$performances_BDD = $bdd->query(	'SELECT COUNT(Id) AS Erreur
																		FROM Performances
																		WHERE Id_Equipements = ' . $infos_equipement['Id'] . '
																		AND Cpu > 65
																		AND Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'');
									$infos_performance = $performances_BDD->fetch();
									$Worktime = round(($infos_performance['Erreur']/1440)*100,0);
						?>
						<div class="line"><?php echo $infos_equipement['Nom'] . ' : ' . $Worktime . '%'; ?></div>
						<?php
								}
								$performances_BDD->closeCursor();
							}
							$equipements_BDD->closeCursor();
						?>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="performances">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left">Surcharge RAM</div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<?php
							$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
															Pieces.Nom AS Location, Typ_Equip.Id AS Type, Typ_Equip.Nom AS Equipement, Equipements.Clonage
															FROM Equipements, Pieces, Typ_Equip
															WHERE Equipements.Id_Pieces = Pieces.Id
															AND Equipements.Id_Typ_Equip = Typ_Equip.Id');
							$nombre_equipements = $equipements_BDD->rowCount();
								$heurodatage = date('Y-m-d H:i:s');
								$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d')-1, date('Y')));
							if($nombre_equipements != 0) {
								while($infos_equipement = $equipements_BDD->fetch()) {
									$performances_BDD = $bdd->query(	'SELECT COUNT(Id) AS Erreur
																		FROM Performances
																		WHERE Id_Equipements = ' . $infos_equipement['Id'] . '
																		AND Ram > 75
																		AND Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'');
									$infos_performance = $performances_BDD->fetch();
									$Worktime = round(($infos_performance['Erreur']/1440)*100,0);
						?>
						<div class="line"><?php echo $infos_equipement['Nom'] . ' : ' . $Worktime . '%'; ?></div>
						<?php
								}
								$performances_BDD->closeCursor();
							}
							$equipements_BDD->closeCursor();
						?>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
	</div>
</div>