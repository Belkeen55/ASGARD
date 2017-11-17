<?php
	if(isset($_GET['action'])) {
		if($_GET['action'] == 'ajout') {
			$bdd->exec('INSERT INTO FM7_Voitures(Id, Marque, Modèle, Année, Division) 
						VALUES(NULL, \'' . $_GET['marque'] . '\', \'' . $_GET['modele'] . '\', ' . $_GET['annee'] . ', ' . $_GET['division'] . ')');
			$voitures_BDD = $bdd->query('SELECT Id
										FROM FM7_Voitures
										WHERE Marque = \'' . $_GET['marque'] . '\'
										AND Modèle = \'' . $_GET['modele'] . '\'
										AND Année = ' . $_GET['annee']);
			$infos_voitures = $voitures_BDD->fetch();
			$voitures_BDD->closeCursor();
			$bdd->exec('INSERT INTO FM7_Reglages(Id, Voiture, Version) 
						VALUES(NULL, ' . $infos_voitures['Id'] . ', 1)');
		}
		if($_GET['action'] == 'edition') {
			$bdd->exec('UPDATE FM7_Voitures SET Division = ' . $_GET['division'] . ' WHERE FM7_Voitures.Id = ' . $_GET['voiture']);
		}
		if($_GET['action'] == 'supprimer') {
			$reglages_BDD = $bdd->query('	SELECT Id
											FROM FM7_Reglages
											WHERE Voiture = ' . $_GET['voiture'] );
			$nombre_reglages = $reglages_BDD->rowCount();
			if($nombre_reglages <> 0) {
				while ($infos_reglage = $reglages_BDD->fetch()) {
					$bdd->exec('DELETE FROM FM7_Tours WHERE FM7_Tours.Reglage = ' . $infos_reglage['Id'] );
					$bdd->exec('DELETE FROM FM7_Commentaires WHERE FM7_Commentaires.Reglage = ' . $infos_reglage['Id'] );
				}
			}
			$bdd->exec('DELETE FROM FM7_Reglages WHERE FM7_Reglages.Voiture = ' . $_GET['voiture']);
			$bdd->exec('DELETE FROM FM7_Voitures WHERE FM7_Voitures.Id = ' . $_GET['voiture']);
		}
	}
	$voitures_BDD = $bdd->query('	SELECT FM7_Voitures.Id, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année, FM7_Voitures.Division
									FROM FM7_Voitures');
	$nombre_voitures = $voitures_BDD->rowCount();
?>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
	
		<div class="cadre_forza_big">
			<div class="titre_sonde">
				<div class="lefttitre"></div>
				<div class="espace_titre">Voitures</div>
			</div>
			<div class="valeur_sonde">
				<table border="1">
					<tr>
						<th>Marque</th>
						<th>Modele</th>
						<th>Annee</th>
						<th>Division</th>
						<th>Editer</th>
						<th>Supprimer</th>
					</tr>
<?php
	if($nombre_voitures != 0) {
		while($infos_voitures = $voitures_BDD->fetch()) {
?>
					<tr>
						<td><?php echo $infos_voitures['Marque']; ?></td>
						<td><?php echo $infos_voitures['Modèle']; ?></td>
						<td><?php echo $infos_voitures['Année']; ?></td>
						<form action="odin.php" method="get">
							<td>
								<input type="hidden" name="module" value="forza">
								<input type="hidden" name="vue" value="voitures">
								<input type="hidden" name="action" value="edition">
								<input type="hidden" name="voiture" value="<?php echo $infos_voitures['Id'] ?>">
								<select name="division">
<?php
									$divisions_BDD = $bdd->query('	SELECT Id, Nom
																	FROM FM7_Divisions
																	ORDER BY Nom');
									while ($infos_division = $divisions_BDD->fetch()) {
										if($infos_division['Id'] == $infos_voitures['Division']) {
											echo '<option value="' . $infos_division['Id'] . '" selected>' . $infos_division['Nom'] . '</option>';
										}
										else {
											echo '<option value="' . $infos_division['Id'] . '">' . $infos_division['Nom'] . '</option>';
										}
									}
									$divisions_BDD->closeCursor();				
?>
								</select>
							</td>
							<td>
								<input type="submit" value="Editer">
							</td>
							<td>
								<form action="odin.php" method="get">
									<input type="hidden" name="module" value="forza">
									<input type="hidden" name="vue" value="voitures">
									<input type="hidden" name="action" value="supprimer">
									<input type="hidden" name="voiture" value="<?php echo $infos_voitures['Id'] ?>">
									<input type="submit" value="Supprimer">
								</form>
							</td>
						</form>
						
					</tr>
<?php
		}
	}
	$voitures_BDD->closeCursor();
?>
				</table>
			</div>
		</div>
		<div class="left1pct"></div>
		
		<div class="cadre_forza">
			<div class="titre_sonde">
				<div class="lefttitre"></div>
				<div class="espace_titre">Ajouter une voiture</div>
			</div>
			<div class="valeur_sonde">
				<form action="odin.php" method="get">
					<div class="line">Marque : <input type="text" name="marque" size="25"></div>
					<div class="line">Modèle : <input type="text" name="modele" size="25"></div>
					<div class="line">Année : <input type="text" name="annee" size="25"></div>
					<div class="line"><select name="division">
<?php
	$divisions_BDD = $bdd->query('	SELECT Id, Nom
									FROM FM7_Divisions
									ORDER BY Nom');
	while ($infos_division = $divisions_BDD->fetch()) {
		echo '<option value="' . $infos_division['Id'] . '">' . $infos_division['Nom'] . '</option>';
	}
	$divisions_BDD->closeCursor();				
?>
					</select></div>
					<input type="hidden" name="module" value="forza">
					<input type="hidden" name="vue" value="voitures">
					<input type="hidden" name="action" value="ajout">
					<div class="line"><input type="submit" value="Ajouter"></div>
				</form>
			</div>
		</div>
		
	</div>
</div>