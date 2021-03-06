<?php
	$reglages_BDD = $bdd->query('	SELECT FM7_Voitures.Id, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année, COUNT(FM7_Tours.Id) AS Runs, FM7_Reglages.Id AS Reglage_Id
									FROM FM7_Tours, FM7_Voitures, FM7_Reglages, FM7_Circuits, FM7_Divisions
									WHERE FM7_Tours.Reglage = FM7_Reglages.Id
									AND FM7_Tours.Circuit = FM7_Circuits.Id
									AND FM7_Voitures.Id = FM7_Reglages.Voiture
									AND FM7_Voitures.Division = FM7_Divisions.Id
									AND FM7_Reglages.Version = (SELECT MAX(FM7_Reglages.Version)
									                            FROM FM7_Reglages
									                            WHERE FM7_Reglages.Voiture = FM7_Voitures.Id)
									GROUP BY FM7_Voitures.Id');
	$nombre_reglages = $reglages_BDD->rowCount();
	if((isset($_GET['division'])) and ($_GET['division'] <> 0)) {
		$voitures_BDD = $bdd->query('	SELECT FM7_Voitures.Id, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année
										FROM FM7_Voitures, FM7_Divisions
										WHERE FM7_Voitures.Division = FM7_Divisions.Id
										AND FM7_Divisions.Id = ' . $_GET['division']);
	}
	else {
		$voitures_BDD = $bdd->query('	SELECT FM7_Voitures.Id, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année
										FROM FM7_Voitures');
	}
	$nombre_voitures = $voitures_BDD->rowCount();
	if((isset($_GET['circuit'])) and ($_GET['circuit'] <> 0)) {
		$tours_BDD = $bdd->query('	SELECT FM7_Divisions.Nom, FM7_Circuits.Circuit, FM7_Circuits.Portion, FM7_Circuits.Condition, MIN(DATEDIFF(NOW(),FM7_Tours.Date)) AS Jours, CEILING(10/FM7_Circuits.Taille) AS Nb_Tours
									FROM FM7_Tours, FM7_Voitures, FM7_Reglages, FM7_Circuits, FM7_Divisions
									WHERE FM7_Tours.Reglage = FM7_Reglages.Id
									AND FM7_Tours.Circuit = FM7_Circuits.Id
									AND FM7_Voitures.Id = FM7_Reglages.Voiture
									AND FM7_Voitures.Division = FM7_Divisions.Id
									AND FM7_Circuits.Id = ' . $_GET['circuit'] . '
									GROUP BY FM7_Divisions.Nom, FM7_Circuits.Id');
	}
	else {
				$tours_BDD = $bdd->query('	SELECT FM7_Divisions.Nom, FM7_Circuits.Circuit, FM7_Circuits.Portion, FM7_Circuits.Condition, MIN(DATEDIFF(NOW(),FM7_Tours.Date)) AS Jours, CEILING(10/FM7_Circuits.Taille) AS Nb_Tours
									FROM FM7_Tours, FM7_Voitures, FM7_Reglages, FM7_Circuits, FM7_Divisions
									WHERE FM7_Tours.Reglage = FM7_Reglages.Id
									AND FM7_Tours.Circuit = FM7_Circuits.Id
									AND FM7_Voitures.Id = FM7_Reglages.Voiture
									AND FM7_Voitures.Division = FM7_Divisions.Id
									GROUP BY FM7_Divisions.Nom, FM7_Circuits.Id');
	}
	$nombre_tours = $tours_BDD->rowCount();
?>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center_up">
	
		<div class="cadre_forza">
			<div class="titre_sonde">
				<div class="lefttitre"></div>
				<div class="espace_titre">Setups à faire</div>
			</div>
			<div class="valeur_sonde">
				<table border="1">
					<tr>
						<th>Marque</th>
						<th>Modele</th>
						<th>Annee</th>
						<th>Run</th>
						<th>Action</th>
					</tr>
<?php
	if($nombre_reglages != 0) {
		while($infos_reglages = $reglages_BDD->fetch()) {
			if($infos_reglages['Runs']>=5) {
						
?>
					<tr>
						<td><?php echo $infos_reglages['Marque']; ?></td>
						<td><?php echo $infos_reglages['Modèle']; ?></td>
						<td><?php echo $infos_reglages['Année']; ?></td>
						<td><?php echo $infos_reglages['Runs']; ?></td>
						<td><a href="/Odin/odin.php?module=forza&vue=nouveau_reglage&id=<?php echo $infos_reglages['Reglage_Id']; ?>" class="black">Nouveau réglage</a></td>
					</tr>
<?php
			}
		}
	}
	$reglages_BDD->closeCursor();
?>
				</table>
			</div>
		</div>
		<div class="left1pct"></div>
	
		<div class="cadre_forza">
			<div class="titre_sonde">
				<div class="lefttitre"></div>
				<div class="espace_titre">Runs par voitures</div>
			</div>
			<div class="valeur_sonde">
				<div class="line">
					<form action="odin.php" method="get">
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
						<input type="hidden" name="module" value="forza">
						<input type="hidden" name="vue" value="dashboard">
<?php
						if((isset($_GET['circuit'])) and ($_GET['circuit'] <> 0)) {
							echo '<input type="hidden" name="circuit" value="' . $_GET['circuit'] . '">';
						}
?>
						<input type="submit" value="Filtrer">
					</form>
				</div>
				<table border="1">
					<tr>
						<th>Marque</th>
						<th>Modele</th>
						<th>Annee</th>
						<th>Run</th>
					</tr>
<?php
	if($nombre_voitures != 0) {
		while($infos_voitures = $voitures_BDD->fetch()) {
			$runs_BDD = $bdd->query('	SELECT COUNT(FM7_Tours.Id) as Runs
										FROM FM7_Tours, FM7_Voitures, FM7_Reglages
										WHERE FM7_Tours.Reglage = FM7_Reglages.Id
										AND FM7_Voitures.Id = FM7_Reglages.Voiture
										AND FM7_Voitures.Id = ' . $infos_voitures['Id']);
			$nombre_runs = $runs_BDD->rowCount();
?>
					<tr>
						<td><?php echo $infos_voitures['Marque']; ?></td>
						<td><?php echo $infos_voitures['Modèle']; ?></td>
						<td><?php echo $infos_voitures['Année']; ?></td>
						<td>
<?php
	if($nombre_runs == 0) {
		echo 0;
	} 
	else {
		$infos_run = $runs_BDD->fetch();
		echo $infos_run['Runs']; 	
	}
?>
						</td>
					</tr>
<?php
		
			$runs_BDD->closeCursor();	
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
				<div class="espace_titre">Classements à rafraichir</div>
			</div>
			<div class="valeur_sonde">
				<div class="line">
					<form action="odin.php" method="get">
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
						<input type="hidden" name="module" value="forza">
						<input type="hidden" name="vue" value="dashboard">
<?php						
						if((isset($_GET['division'])) and ($_GET['division'] <> 0)) {
							echo '<input type="hidden" name="division" value="' . $_GET['division'] . '">';
						}
?>
						<input type="submit" value="Filtrer">
					</form>
				</div>
				<table border="1">
					<tr>
						<th>Division</th>
						<th>Circuit</th>
						<th>Portion</th>
						<th>Condition</th>
						<th>Tours</th>
					</tr>
<?php
	if($nombre_tours != 0) {
		while($infos_tours = $tours_BDD->fetch()) {
			if($infos_tours['Jours'] >= 30) {
?>
					<tr>
						<td><?php echo $infos_tours['Nom']; ?></td>
						<td><?php echo $infos_tours['Circuit']; ?></td>
						<td><?php echo $infos_tours['Portion']; ?></td>
						<td><?php echo $infos_tours['Condition']; ?></td>
						<td><?php echo $infos_tours['Nb_Tours']; ?></td>
					</tr>
<?php
			}
		}
	}
	$tours_BDD->closeCursor();
	if(isset($_GET['circuit'])) {
		$tours_BDD = $bdd->query('	SELECT FM7_Divisions.Nom, FM7_Circuits.Circuit, FM7_Circuits.Portion, FM7_Circuits.Condition, COUNT(FM7_Tours.Id) AS Classement, CEILING(10/FM7_Circuits.Taille) AS Nb_Tours
									FROM FM7_Tours, FM7_Reglages, FM7_Circuits, FM7_Voitures, FM7_Divisions 
									WHERE FM7_Tours.Europe <> 0 
									AND FM7_Tours.Reglage = FM7_Reglages.Id 
									AND FM7_Circuits.Id = FM7_Tours.Circuit 
									AND FM7_Divisions.Id = FM7_Voitures.Division 
									AND FM7_Reglages.Voiture = FM7_Voitures.Id 
									AND FM7_Circuits.Id = ' . $_GET['circuit'] . '
									GROUP BY FM7_Divisions.Id, FM7_Circuits.Id ORDER BY `Classement`');
	}
	else {
		$tours_BDD = $bdd->query('	SELECT FM7_Divisions.Nom, FM7_Circuits.Circuit, FM7_Circuits.Portion, FM7_Circuits.Condition, COUNT(FM7_Tours.Id) AS Classement, CEILING(10/FM7_Circuits.Taille) AS Nb_Tours
									FROM FM7_Tours, FM7_Reglages, FM7_Circuits, FM7_Voitures, FM7_Divisions 
									WHERE FM7_Tours.Europe <> 0 
									AND FM7_Tours.Reglage = FM7_Reglages.Id 
									AND FM7_Circuits.Id = FM7_Tours.Circuit 
									AND FM7_Divisions.Id = FM7_Voitures.Division 
									AND FM7_Reglages.Voiture = FM7_Voitures.Id 
									GROUP BY FM7_Divisions.Id, FM7_Circuits.Id ORDER BY `Classement`');
	}
	$nombre_tours = $tours_BDD->rowCount();
	if($nombre_tours != 0) {
		while($infos_tours = $tours_BDD->fetch()) {
			if($infos_tours['Classement']>1) {
?>
					<tr>
						<td><?php echo $infos_tours['Nom']; ?></td>
						<td><?php echo $infos_tours['Circuit']; ?></td>
						<td><?php echo $infos_tours['Portion']; ?></td>
						<td><?php echo $infos_tours['Condition']; ?></td>
						<td><?php echo $infos_tours['Nb_Tours']; ?></td>
					</tr>
<?php
			}
		}
	}
	if(isset($_GET['circuit'])) {
		$tours_BDD = $bdd->query('	SELECT FM7_Divisions.Nom, FM7_Circuits.Circuit, FM7_Circuits.Portion, FM7_Circuits.Condition, SUM(FM7_Tours.Europe) AS Classement, CEILING(10/FM7_Circuits.Taille) AS Nb_Tours
									FROM FM7_Tours, FM7_Reglages, FM7_Circuits, FM7_Voitures, FM7_Divisions 
									WHERE FM7_Tours.Reglage = FM7_Reglages.Id 
									AND FM7_Circuits.Id = FM7_Tours.Circuit 
									AND FM7_Divisions.Id = FM7_Voitures.Division 
									AND FM7_Reglages.Voiture = FM7_Voitures.Id 
									AND FM7_Circuits.Id = ' . $_GET['circuit'] . '
									GROUP BY FM7_Divisions.Id, FM7_Circuits.Id ORDER BY `Classement`');
	}
	else {
		$tours_BDD = $bdd->query('	SELECT FM7_Divisions.Nom, FM7_Circuits.Circuit, FM7_Circuits.Portion, FM7_Circuits.Condition, SUM(FM7_Tours.Europe) AS Classement, CEILING(10/FM7_Circuits.Taille) AS Nb_Tours
									FROM FM7_Tours, FM7_Reglages, FM7_Circuits, FM7_Voitures, FM7_Divisions 
									WHERE FM7_Tours.Reglage = FM7_Reglages.Id 
									AND FM7_Circuits.Id = FM7_Tours.Circuit 
									AND FM7_Divisions.Id = FM7_Voitures.Division 
									AND FM7_Reglages.Voiture = FM7_Voitures.Id 
									GROUP BY FM7_Divisions.Id, FM7_Circuits.Id ORDER BY `Classement`');
	}
	$nombre_tours = $tours_BDD->rowCount();
	if($nombre_tours != 0) {
		while($infos_tours = $tours_BDD->fetch()) {
			if($infos_tours['Classement'] == 0) {
?>
					<tr>
						<td><?php echo $infos_tours['Nom']; ?></td>
						<td><?php echo $infos_tours['Circuit']; ?></td>
						<td><?php echo $infos_tours['Portion']; ?></td>
						<td><?php echo $infos_tours['Condition']; ?></td>
						<td><?php echo $infos_tours['Nb_Tours']; ?></td>
					</tr>
<?php
			}
		}
	}
?>
				</table>
			</div>
		</div>

</div>