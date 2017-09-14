<?php
	$pieces_BDD = $bdd->query('	SELECT Pieces.Id, Pieces.Nom
										FROM Pieces
										WHERE Pieces.Nom = \'' . ucfirst($module) . '\'');
	$infos_piece = $pieces_BDD->fetch();
	$pieces_BDD->closeCursor();
	
	$infos_sonde = donnees_piece_live($bdd, $infos_piece['Id']);
	
	//$infos = ['Tetat', 'temperature', 'Tideal', 'Hetat', 'humidite', 'Hideal', 'Retat', 'radiateur', 'reglage']
	
	$equipements_BDD = $bdd->query('SELECT Equipements.Id
									FROM Pieces, Equipements
									WHERE Pieces.Id = ' . $infos_piece['Id'] . '
									AND Equipements.Id_Typ_Equip = 2
									AND Equipements.Id_Pieces = Pieces.Id');
	$infos_equipement = $equipements_BDD->fetch();
	$equipements_BDD->closeCursor();
	if($infos_sonde['temperature'] <> -1) {
	
?>
	<div class="line">
		<div class="display_center">
			<div class="cadre_meteo">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					Temperature
				</div>
				<div class="cadre_center">
					<div class="liner"></div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<div class="valeur_sonde">Actuel</div>
						<div class="liner"></div>
						<div class="line"><img src="/img/black/temperature<?php echo $infos_sonde['Tetat']; ?>.png" class="image_sonde"></img></div>
						<div class="liner"></div>
						<div class="valeur_sonde"><?php echo $infos_sonde['temperature']; ?>&deg;C</div>
					</div>
					<div class="lefttitre"></div>
					<div class="liner"></div>
				</div>
			</div>
			<div class="left1pct"></div>
			<div class="cadre_meteo">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					Humidité
				</div>
				<div class="cadre_center">
					<div class="liner"></div>
					<div class="lefttitre"></div>
					<div class="colonne">
						<div class="valeur_sonde">Actuel</div>
						<div class="liner"></div>
						<div class="line"><img src="/img/black/humidity<?php echo $infos_sonde['Hetat']; ?>.png" class="image_sonde"></img></div>
						<div class="liner"></div>
						<div class="valeur_sonde"><?php echo $infos_sonde['humidite']; ?>%</div>
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
				<img src="temperaturegraph<?php echo $infos_piece['Id']; ?>.png" class="graphique" />
			</div>
		</div>
		<div class="liner"></div>
		<div class="display_center">
			<div>
				<img src="humiditygraph<?php echo $infos_piece['Id']; ?>.png" class="graphique" />
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