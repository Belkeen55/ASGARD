<?php
	if(isset($_GET['action'])) {
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
	$voitures_BDD = $bdd->query('	SELECT FM7_Voitures.Id, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année
									FROM FM7_Voitures');
	$nombre_voitures = $voitures_BDD->rowCount();
?>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
	
		<div class="cadre_forza">
			<div class="titre_sonde">
				Voitures
			</div>
			<div class="valeur_sonde">
				<table border="1">
					<tr>
						<th>Marque</th>
						<th>Modele</th>
						<th>Annee</th>
					</tr>
<?php
	if($nombre_voitures != 0) {
		while($infos_voitures = $voitures_BDD->fetch()) {
?>
					<tr>
						<td><?php echo $infos_voitures['Marque']; ?></td>
						<td><?php echo $infos_voitures['Modèle']; ?></td>
						<td><?php echo $infos_voitures['Année']; ?></td>
					</tr>
<?php
		}
	}
	$voitures_BDD->closeCursor();
?>
				</table>
			</div>
		</div>
		
		<div class="cadre_forza">
			<div class="titre_sonde">
				Ajouter une voiture
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