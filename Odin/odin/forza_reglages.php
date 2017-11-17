<?php
	if(isset($_GET['action'])) {
		$reglages_BDD = $bdd->query('SELECT Voiture, MAX(Version) AS MVersion
									FROM FM7_Reglages
									WHERE Voiture = ' . $_GET['voiture'] . '
									GROUP BY Voiture');
		$infos_reglage = $reglages_BDD->fetch();
		$reglages_BDD->closeCursor();
		$nouvelle_version = $infos_reglage['MVersion']+1;
		$bdd->exec('INSERT INTO FM7_Reglages(Id, Voiture, Version) 
					VALUES(NULL, ' . $_GET['voiture'] . ', ' . $nouvelle_version . ')');
	}
	$voitures_BDD = $bdd->query('	SELECT FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année, FM7_Reglages.Version
									FROM FM7_Voitures, FM7_Reglages
									WHERE FM7_Voitures.Id = FM7_Reglages.Voiture');
	$nombre_voitures = $voitures_BDD->rowCount();
?>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
	
		<div class="cadre_forza">
			<div class="titre_sonde">
				<div class="lefttitre"></div>
				<div class="espace_titre">Réglages</div>
			</div>
			<div class="valeur_sonde">
				<table border="1">
					<tr>
						<th>Marque</th>
						<th>Modele</th>
						<th>Annee</th>
						<th>Version</th>
					</tr>
<?php
	if($nombre_voitures != 0) {
		while($infos_voitures = $voitures_BDD->fetch()) {
?>
					<tr>
						<td><?php echo $infos_voitures['Marque']; ?></td>
						<td><?php echo $infos_voitures['Modèle']; ?></td>
						<td><?php echo $infos_voitures['Année']; ?></td>
						<td><?php echo $infos_voitures['Version']; ?></td>
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
				<div class="espace_titre">Ajouter un réglage</div>
			</div>
			<div class="valeur_sonde">
				<form action="odin.php" method="get">
					<select name="voiture">
<?php
	$voitures_BDD = $bdd->query('	SELECT Id, Marque, Modèle, Année
									FROM FM7_Voitures
									ORDER BY Marque, Modèle, Année');
	while ($infos_voiture = $voitures_BDD->fetch()) {
		echo '<option value="' . $infos_voiture['Id'] . '">' . $infos_voiture['Marque'] . ' ' . $infos_voiture['Modèle'] . ' (' . $infos_voiture['Année'] . ')</option>';
	}
	$voitures_BDD->closeCursor();				
?>
					</select>
					<input type="hidden" name="module" value="forza">
					<input type="hidden" name="vue" value="reglages">
					<input type="hidden" name="action" value="ajout">
					<input type="submit" value="Ajouter">
				</form>
			</div>
		</div>
		
	</div>
</div>