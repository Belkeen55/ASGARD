<?php
	$requete = '	SELECT FM7_Tours.Id, FM7_Tours.Date, FM7_Divisions.Nom, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année, FM7_Reglages.Version, FM7_Circuits.Circuit, FM7_Circuits.Portion, FM7_Circuits.Condition, FM7_Tours.Secondes, FM7_Tours.Millis, FM7_Tours.Europe, FM7_Tours.Amis
					FROM FM7_Voitures, FM7_Reglages, FM7_Tours, FM7_Divisions, FM7_Circuits
					WHERE FM7_Voitures.Id = FM7_Reglages.Voiture
					AND FM7_Tours.Reglage = FM7_Reglages.Id
					AND FM7_Circuits.Id = FM7_Tours.Circuit
					AND FM7_Divisions.Id = FM7_Voitures.Division';
	if(isset($_GET['action'])) {
		if($_GET['action'] == 'ajout') {
		$secondes = ($_GET['minute']*60) + $_GET['seconde'];
		$bdd->exec('INSERT INTO FM7_Tours(Id, Date, Reglage, Circuit, Secondes, Millis, Europe, Amis) 
					VALUES(NULL, \'' . $_GET['date'] . '\', ' . $_GET['reglage'] . ', ' . $_GET['circuit'] . ', ' . $secondes . ', ' . $_GET['millis'] . ', ' . $_GET['europe'] . ', ' . $_GET['amis'] . ')');
		$bdd->exec('INSERT INTO FM7_Commentaires(Id, Reglage, Boite, Differentiel, Frein, Virage, Puissance) 
					VALUES(NULL, ' . $_GET['reglage'] . ', ' . $_GET['boite'] . ', ' . $_GET['diff'] . ', ' . $_GET['frein'] . ', ' . $_GET['virage'] . ', ' . $_GET['puissance'] . ')');
		$requete = $requete . ' AND FM7_Circuits.Id = ' . $_GET['circuit'];
		$divisions_BDD = $bdd->query('	SELECT FM7_Divisions.Id
										FROM FM7_Voitures, FM7_Reglages, FM7_Divisions
										WHERE FM7_Voitures.Id = FM7_Reglages.Voiture
										AND FM7_Divisions.Id = FM7_Voitures.Division
										AND FM7_Reglages.Id = '. $_GET['reglage']);
		$infos_division = $divisions_BDD->fetch();
		$requete = $requete . ' AND FM7_Divisions.Id = ' . $infos_division['Id'];
		$divisions_BDD->closeCursor();
		}
		if($_GET['action'] == 'supprimer') {
			$bdd->exec('UPDATE `FM7_Tours` SET `Europe` = \'0\' WHERE `FM7_Tours`.`Id` = ' . $_GET['id']);
			$bdd->exec('UPDATE `FM7_Tours` SET `Amis` = \'0\' WHERE `FM7_Tours`.`Id` = ' . $_GET['id']);
		}
		if($_GET['action'] == 'editer') {
			$bdd->exec('UPDATE `FM7_Tours` SET `Europe` = \'' . $_GET['europe'] . '\' WHERE `FM7_Tours`.`Id` = ' . $_GET['id']);
			$bdd->exec('UPDATE `FM7_Tours` SET `Amis` = \'' . $_GET['amis'] . '\' WHERE `FM7_Tours`.`Id` = ' . $_GET['id']);
		}
		if($_GET['action'] == 'filtrer' or $_GET['action'] == 'supprimer' or $_GET['action'] == 'editer') {
			if(isset($_GET['division'])) {
				if($_GET['division'] <> 0) {
					$requete = $requete . ' AND FM7_Divisions.Id = ' . $_GET['division'];
				}
			}
			if(isset($_GET['circuit'])) {
				if($_GET['circuit'] <> 0) {
					$requete = $requete . ' AND FM7_Circuits.Id = ' . $_GET['circuit'];
				}
			}
		}
	}
	$tours_BDD = $bdd->query($requete);
	$nombre_tours = $tours_BDD->rowCount();
?>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
	
		<div class="cadre_forza_big">
			<div class="titre_sonde">
				<div class="lefttitre"></div>
				<div class="espace_titre">Runs</div>
				<a href="/Odin/odin.php?module=forza&vue=ajout_tour" class="black">Ajouter</a>
			</div>
			<div class="valeur_sonde">
				<form action="odin.php" method="get">
					<div class="line">
						<select name="division">
							<option value="0">Toutes les divisions</option>
<?php
							$divisions_BDD = $bdd->query('	SELECT Id, Nom
															FROM FM7_Divisions
															ORDER BY Nom');
							while ($infos_division = $divisions_BDD->fetch()) {
								if((isset($_GET['division'])) and ($infos_division['Id'] == $_GET['division'])) {
									echo '<option value="' . $infos_division['Id'] . '" selected>' . $infos_division['Nom'] . '</option>';
								}
								else {
									echo '<option value="' . $infos_division['Id'] . '">' . $infos_division['Nom'] . '</option>';
								}
							}
							$divisions_BDD->closeCursor();				
?>
						</select>
					</div>
					<div class="line">
						<select name="circuit">
							<option value="0">Tous les circuits</option>
<?php
							$circuits_BDD = $bdd->query('	SELECT Id, Circuit, Portion, `Condition`
															FROM FM7_Circuits 
															ORDER BY Circuit, Portion, `Condition`');
							while ($infos_circuit = $circuits_BDD->fetch()) {
								if((isset($_GET['circuit'])) and ($infos_circuit['Id'] == $_GET['circuit'])) {
									echo '<option value="' . $infos_circuit['Id'] . '" selected>' . $infos_circuit['Circuit'] . ' ' . $infos_circuit['Portion'] . ' ' . $infos_circuit['Condition'] . '</option>';
								}
								else {
									echo '<option value="' . $infos_circuit['Id'] . '">' . $infos_circuit['Circuit'] . ' ' . $infos_circuit['Portion'] . ' ' . $infos_circuit['Condition'] . '</option>';
								}
							}
							$circuits_BDD->closeCursor();				
?>
						</select>
					</div>
					<input type="hidden" name="module" value="forza">
					<input type="hidden" name="vue" value="tours">
					<input type="hidden" name="action" value="filtrer">
					<div class="line"><input type="submit" value="Filtrer"></div>
				</form>
				<table border="1">
					<tr>
						<th>Date</th>
						<th>Division</th>
						<th>Voiture</th>
						<th>Circuit</th>
						<th>Temps</th>
						<th>Europe</th>
						<th>Amis</th>
						<th>Action</th>
					</tr>
<?php
	if($nombre_tours != 0) {
		while($infos_tour = $tours_BDD->fetch()) {
			$minute = floor($infos_tour['Secondes']/60);
			$seconde = $infos_tour['Secondes']-($minute*60);
			if($seconde < 10) {
				$dizaine = '0';
			}
			else {
				$dizaine = '';
			}
			if($infos_tour['Millis']<100) {
				$millis = '0' . $infos_tour['Millis'];
			}
			if($infos_tour['Millis']<10) {
				$millis = '00' . $infos_tour['Millis'];
			}
			if($infos_tour['Millis']>=100) {
				$millis = $infos_tour['Millis'];
			}
			$temps = $minute . ':' . $dizaine . $seconde . '.' . $millis;
?>
					<tr>
						<td><?php echo $infos_tour['Date']; ?></td>
						<td><?php echo $infos_tour['Nom']; ?></td>
						<td><?php echo $infos_tour['Marque'] . ' ' . $infos_tour['Modèle'] . ' (' . $infos_tour['Année'] . ')'; ?></td>
						<td><?php echo $infos_tour['Circuit'] . ' ' . $infos_tour['Portion'] . ' ' . $infos_tour['Condition']; ?></td>
						<td><?php echo $temps; ?></td>
						<form action="odin.php" method="get">
						<td><input type="text" name="europe" size="2" value="<?php echo $infos_tour['Europe']; ?>"></td>
						<td><input type="text" name="amis" size="2" value="<?php echo $infos_tour['Amis']; ?>"></td>
						<td>
								<input type="hidden" name="module" value="forza">
								<input type="hidden" name="vue" value="tours">
								<input type="hidden" name="action" value="editer">
								<input type="hidden" name="id" value="<?php echo $infos_tour['Id']; ?>">
<?php
								if(isset($_GET['action'])) {
									if($_GET['action'] == 'filtrer') {
										if(isset($_GET['division'])) {
											if($_GET['division'] <> 0) {
												echo '<input type="hidden" name="division" value="' . $_GET['division'] . '">';
											}
										}
										if(isset($_GET['circuit'])) {
											if($_GET['circuit'] <> 0) {
												echo '<input type="hidden" name="circuit" value="' . $_GET['circuit'] . '">';
											}
										}
									}
								}
?>
								<input type="submit" value="Editer">
							</form>
							<form action="odin.php" method="get">
								<input type="hidden" name="module" value="forza">
								<input type="hidden" name="vue" value="tours">
								<input type="hidden" name="action" value="supprimer">
								<input type="hidden" name="id" value="<?php echo $infos_tour['Id']; ?>">
<?php
								if(isset($_GET['action'])) {
									if($_GET['action'] == 'filtrer') {
										if(isset($_GET['division'])) {
											if($_GET['division'] <> 0) {
												echo '<input type="hidden" name="division" value="' . $_GET['division'] . '">';
											}
										}
										if(isset($_GET['circuit'])) {
											if($_GET['circuit'] <> 0) {
												echo '<input type="hidden" name="circuit" value="' . $_GET['circuit'] . '">';
											}
										}
									}
								}
?>
								<input type="submit" value="Effacer">
							</form>
						</td>
					</tr>
<?php
		}
	}
	$tours_BDD->closeCursor();
?>
				</table>
			</div>
		</div>
		
	</div>
</div>