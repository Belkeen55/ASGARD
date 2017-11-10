<?php
	$commentaires_BDD = $bdd->query('	SELECT FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année, ROUND(AVG(FM7_Commentaires.Boite)) AS R_Boite, ROUND(AVG(FM7_Commentaires.Differentiel)) AS R_Diff, ROUND(AVG(FM7_Commentaires.Frein)) AS R_Frein, ROUND(AVG(FM7_Commentaires.Virage)) AS R_Virage, ROUND(AVG(FM7_Commentaires.Puissance)) AS R_Puissance
										FROM FM7_Voitures, FM7_Reglages, FM7_Commentaires
										WHERE FM7_Voitures.Id = FM7_Reglages.Voiture
										AND FM7_Reglages.Id = FM7_Commentaires.Reglage
										AND FM7_Commentaires.Reglage = ' . $_GET['id']);
	$nombre_commentaires = $commentaires_BDD->rowCount();
?>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center_up">
	
		<div class="cadre_forza_big">
			<div class="titre_sonde">
				Setups à faire
			</div>
			<div class="valeur_sonde">
				<table border="1">
					<tr>
						<th>Marque</th>
						<th>Modele</th>
						<th>Annee</th>
						<th>Boite</th>
						<th>Diff</th>
						<th>Frein</th>
						<th>Virage</th>
						<th>Puissance</th>
					</tr>
<?php
	if($nombre_commentaires != 0) {
		while($infos_commentaire = $commentaires_BDD->fetch()) {
			switch ($infos_commentaire['R_Boite']) {
				case -1:
					$boite = 'Raccourcir';
					break;
				case 0:
					$boite = 'Correcte';
					break;
				case 1:
					$boite = 'Allonger';
					break;
			}
			switch ($infos_commentaire['R_Diff']) {
				case -1:
					$diff = 'Desserrer';
					break;
				case 0:
					$diff = 'Correct';
					break;
				case 1:
					$diff = 'Serrer';
					break;
			}
			switch ($infos_commentaire['R_Frein']) {
				case -1:
					$frein = 'Trop';
					break;
				case 0:
					$frein = 'Correct';
					break;
				case 1:
					$frein = 'Manque';
					break;
			}
			switch ($infos_commentaire['R_Virage']) {
				case -1:
					$virage = 'Sur-vire';
					break;
				case 0:
					$virage = 'Correct';
					break;
				case 1:
					$virage = 'Sous-vire';
					break;
			}
			switch ($infos_commentaire['R_Puissance']) {
				case -1:
					$puissance = 'Trop';
					break;
				case 0:
					$puissance = 'Correct';
					break;
				case 1:
					$puissance = 'Manque';
					break;
			}
			
?>
					<tr>
						<td><?php echo $infos_commentaire['Marque']; ?></td>
						<td><?php echo $infos_commentaire['Modèle']; ?></td>
						<td><?php echo $infos_commentaire['Année']; ?></td>
						<td><?php echo $boite ?></td>
						<td><?php echo $diff; ?></td>
						<td><?php echo $frein; ?></td>
						<td><?php echo $virage; ?></td>
						<td><?php echo $puissance; ?></td>
					</tr>
<?php
		}
	}
	$commentaires_BDD->closeCursor();
?>
				</table>
			</div>
		</div>
		
</div>