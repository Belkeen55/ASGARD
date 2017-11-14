<?php
	$commentaires_BDD = $bdd->query('	SELECT FM7_Voitures.Id, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année, ROUND(AVG(FM7_Commentaires.Boite)) AS R_Boite, ROUND(AVG(FM7_Commentaires.Differentiel)) AS R_Diff, ROUND(AVG(FM7_Commentaires.Frein)) AS R_Frein, ROUND(AVG(FM7_Commentaires.Virage)) AS R_Virage, ROUND(AVG(FM7_Commentaires.Puissance)) AS R_Puissance
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
						$voiture = $infos_commentaire['Id'];
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
			<form action="odin.php" method="get">
				<input type="hidden" name="module" value="forza">
				<input type="hidden" name="vue" value="reglages">
				<input type="hidden" name="voiture" value="<?php echo $voiture; ?>">
				<input type="hidden" name="action" value="ajout">
				<div class="line"><input type="submit" value="Nouveau réglage"></div>
			</form>
		</div>
	</div>
	<div class="cadre_forza_big">
		<div class="titre_sonde">
			Réglage de base
		</div>
		<div class="valeur_sonde">
			<form action="odin.php" method="get">
				<div class="line">
					Classe
					<select name="classe">
						<option value="">Choisir une classe</option>
						<option value="E">Classe E</option>
						<option value="D">Classe D</option>
						<option value="C">Classe C</option>
						<option value="B">Classe B</option>
						<option value="A">Classe A</option>
						<option value="S">Classe S</option>
						<option value="R">Classe R</option>
						<option value="P">Classe P</option>
						<option value="X">Classe X</option>
					</select>
				</div>
				<div class="line">
					Poid : <input type="text" name="poid" size="25">
				</div>
				<div class="line">
					Repartition : <input type="text" name="repartition" size="25">
				</div>
				<input type="hidden" name="module" value="forza">
				<input type="hidden" name="vue" value="nouveau_reglage">
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<input type="hidden" name="action" value="guider">
				<input type="submit" value="Calculer">
			</form>
			
<?php
			if(isset($_GET['action'])) {
				switch ($_GET['classe']) {
					case 'E':
						$carrossage_avant = -0.4;
						$carrossage_arriere = -0.2;
						$pincement_avant = 0;
						$pincement_arriere = 0;
						$chasse = 7;
						break;
					case 'D':
						$carrossage_avant = -0.6;
						$carrossage_arriere = -0.2;
						$pincement_avant = 0;
						$pincement_arriere = 0;
						$chasse = 7;
						break;
					case 'C':
						$carrossage_avant = -1.2;
						$carrossage_arriere = -0.5;
						$pincement_avant = 0;
						$pincement_arriere = 0;
						$chasse = 7;
						break;
					case 'B':
						$carrossage_avant = -1.8;
						$carrossage_arriere = -0.9;
						$pincement_avant = 0;
						$pincement_arriere = -0.1;
						$chasse = 6.5;
						break;
					case 'A':
						$carrossage_avant = -2.3;
						$carrossage_arriere = -1.2;
						$pincement_avant = 0;
						$pincement_arriere = -0.1;
						$chasse = 6;
						break;
					case 'S':
						$carrossage_avant = -2.6;
						$carrossage_arriere = -1.5;
						$pincement_avant = 0;
						$pincement_arriere = -0.1;
						$chasse = 6;
						break;
					case 'R':
						$carrossage_avant = -2.9;
						$carrossage_arriere = -1.8;
						$pincement_avant = 0;
						$pincement_arriere = -0.1;
						$chasse = 5.6;
						break;
					case 'P':
						$carrossage_avant = -3.2;
						$carrossage_arriere = -2.1;
						$pincement_avant = 0;
						$pincement_arriere = -0.2;
						$chasse = 5.3;
						break;
					case 'X':
						$carrossage_avant = -3.5;
						$carrossage_arriere = -2.5;
						$pincement_avant = 0;
						$pincement_arriere = -0.3;
						$chasse = 5;
						break;
				}
				$barre_avant = 40*($_GET['repartition']/100)*(1*1.1);
				$barre_arriere = 40*(1-$_GET['repartition']/100)*(1*1.1);
				$ressorts_avant = $_GET['poid']*($_GET['repartition']/100)*0.1973*1.1;
				$ressorts_arriere = $_GET['poid']*(1-($_GET['repartition']/100))*0.1973*1.1;
				$retour_detente_avant = (($ressorts_avant/100)+1)*3.4;
				$retour_detente_arriere = (($ressorts_arriere/100)+1)*3.4;
				$retour_amorti_avant = $retour_detente_avant*0.65;
				$retour_amorti_arriere = $retour_detente_arriere*0.65;
?>
			<div class="liner"></div>
			<div class="liner"></div>
			<div class="line">Carrossage : </div>
			<div class="line">Avant : <?php echo $carrossage_avant; ?> Arriere : <?php echo $carrossage_arriere; ?></div>
			<div class="liner"></div>
			<div class="line">Pincement : </div>
			<div class="line">Avant : <?php echo $pincement_avant; ?> Arriere : <?php echo $pincement_arriere; ?></div>
			<div class="liner"></div>
			<div class="line">Chasse : <?php echo $chasse; ?></div>
			<div class="liner"></div>
			<div class="liner"></div>
			<div class="line">Barres anti-roulis : </div>
			<div class="line">Avant : <?php echo round($barre_avant,1); ?> Arriere : <?php echo round($barre_arriere,1); ?></div>
			<div class="liner"></div>
			<div class="liner"></div>
			<div class="line">Ressorts : </div>
			<div class="line">Avant : <?php echo round($ressorts_avant,1); ?> Arriere : <?php echo round($ressorts_arriere,1); ?></div>
			<div class="liner"></div>
			<div class="liner"></div>
			<div class="line">Retour détente : </div>
			<div class="line">Avant : <?php echo round($retour_detente_avant,1); ?> Arriere : <?php echo round($retour_detente_arriere,1); ?></div>
			<div class="liner"></div>
			<div class="line">Retour amorti : </div>
			<div class="line">Avant : <?php echo round($retour_amorti_avant,1); ?> Arriere : <?php echo round($retour_amorti_arriere,1); ?></div>
			<div class="liner"></div>
			<div class="liner"></div>
			<div class="line">Rappel réglage fixe 4x4 : 29% 0% 59% 18% 69%</div>
<?php
			}
?>
		</div>
	</div>
</div>