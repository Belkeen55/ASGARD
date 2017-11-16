<?php
	$classements_BDD = $bdd->query('	SELECT ROUND(AVG(Europe)) AS Classement
										FROM FM7_Tours
										WHERE Europe <> 0');
	$divisions_BDD = $bdd->query('	SELECT FM7_Divisions.Nom, ROUND(AVG(FM7_Tours.Europe)) AS Classement
									FROM FM7_Voitures, FM7_Divisions, FM7_Tours, FM7_Reglages
									WHERE FM7_Voitures.Division = FM7_Divisions.Id
									AND FM7_Reglages.Voiture = FM7_Voitures.Id
									AND FM7_Tours.Reglage = FM7_Reglages.Id
									AND FM7_Tours.Europe <> 0
									GROUP BY FM7_Divisions.Nom
									ORDER BY Classement DESC');
	$circuits_BDD = $bdd->query('	SELECT FM7_Circuits.Circuit, FM7_Circuits.Portion, FM7_Circuits.Condition, ROUND(AVG(FM7_Tours.Europe)) AS Classement
									FROM FM7_Tours, FM7_Circuits
									WHERE FM7_Tours.Circuit = FM7_Circuits.Id
									AND FM7_Tours.Europe <> 0
									GROUP BY FM7_Circuits.Id
									ORDER BY Classement DESC');
?>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center_up">
	
		<div class="cadre_forza">
			<div class="titre_sonde">
				Classement général
			</div>
			<div class="valeur_sonde">
				<table border="1">
					<tr>
						<th>Classement Europe</th>
					</tr>
<?php
					while($infos_classement = $classements_BDD->fetch()) {
?>
						<tr>
							<td><?php echo $infos_classement['Classement']; ?></td>
						</tr>
<?php
					}
					$classements_BDD->closeCursor();
?>
				</table>
			</div>
		</div>
	
	
		<div class="cadre_forza">
			<div class="titre_sonde">
				Classement par divisions
			</div>
			<div class="valeur_sonde">
				<table border="1">
					<tr>
						<th>Divisions</th>
						<th>Classement</th>
					</tr>
<?php
					while($infos_division = $divisions_BDD->fetch()) {
?>
						<tr>
							<td><?php echo $infos_division['Nom']; ?></td>
							<td><?php echo $infos_division['Classement']; ?></td>
						</tr>
<?php
		
					}
					$divisions_BDD->closeCursor();
?>
				</table>
			</div>
		</div>
		
			<div class="cadre_forza">
			<div class="titre_sonde">
				Classements par circuits
			</div>
			<div class="valeur_sonde">
				<table border="1">
					<tr>
						<th>Circuit</th>
						<th>Portion</th>
						<th>Condition</th>
						<th>Classement</th>
					</tr>
<?php
					while($infos_circuit = $circuits_BDD->fetch()) {
?>
						<tr>
							<td><?php echo $infos_circuit['Circuit']; ?></td>
							<td><?php echo $infos_circuit['Portion']; ?></td>
							<td><?php echo $infos_circuit['Condition']; ?></td>
							<td><?php echo $infos_circuit['Classement']; ?></td>
						</tr>
<?php
					}
?>

				</table>
			</div>
		</div>

</div>