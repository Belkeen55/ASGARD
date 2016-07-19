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
					<div class="line">CPU : <?php echo $cpu; ?>%</div>
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