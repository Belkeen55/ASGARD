<script type="text/javascript">
<!--
	function open_joueur(id)
	{
		width = 570;
		height = 300;
		if(window.innerWidth)
		{
			var left = (window.innerWidth-width)/2;
			var top = (window.innerHeight-height)/2;
		}
		else
		{
			var left = (document.body.clientWidth-width)/2;
			var top = (document.body.clientHeight-height)/2;
		}
			window.open('popup.php?action=edit&type=joueur&id='+id,'Modifier joueur','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
	}
	
	function open_formation(id)
	{
		width = 250;
		height = 355;
		if(window.innerWidth)
		{
			var left = (window.innerWidth-width)/2;
			var top = (window.innerHeight-height)/2;
		}
		else
		{
			var left = (document.body.clientWidth-width)/2;
			var top = (document.body.clientHeight-height)/2;
		}
			window.open('popup.php?action=edit&type=formation&nom='+id,'Modifier joueur','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
	}
	
	function create_infos()
	{
		width = 570;
		height = 300;
		if(window.innerWidth)
		{
			var left = (window.innerWidth-width)/2;
			var top = (window.innerHeight-height)/2;
		}
		else
		{
			var left = (document.body.clientWidth-width)/2;
			var top = (document.body.clientHeight-height)/2;
		}
			window.open('popup.php?action=edit&type=joueur&create=TRUE','Modifier joueur','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
	}
-->
</script>
<?php
	function position($tableau, $poste, $nb) {
		if($tableau[$poste] == 1) {
			if($nb != 0) {
				echo ', ' . $poste;
			}
			else {
				echo $poste;
				++$nb;
			}
		}
		return $nb;
	}
	
	function utile($variable) {
		if(isset($variable)) {
			return $variable;
		}
		else {
			return 0;
		}
	}
?>
<div class="line">
	<div class="display_center">
		<div class="inline">
			<div class="joueurs">
				<div class="titre">
					<div class="lefttitre"></div>
					<div class="inline-45-Left">Liste des joueurs</div>
					<div class="inline-45-Right"><a href="#null" onclick="javascript:create_infos();" class="black">Ajouter</a></div>
				</div>
				<div class="cadre_left">
					<div class="colonne">
						<table border="1">
							<tr>
								<td>
									Joueur
								</td>
								<td>
									Note
								</td>
								<td>
									Positions
								</td>
								<td>
									Repos
								</td>
								<td>
									Action
								</td>
							</tr>
							<?php
								$joueurs_BDD = $bdd->query('SELECT *
															FROM Joueurs
															ORDER BY Nom');
								while($infos_joueur = $joueurs_BDD->fetch()) {
								?>
							<tr>
								<td align="center">
									<?php echo $infos_joueur['Nom']; ?>
								</td>
								<td align="center">
									<?php echo $infos_joueur['Note']; ?>
								</td>
								<td align="center">
									<?php 
										$nb = position($infos_joueur, 'G', 0);
										$nb = position($infos_joueur, 'DD', $nb);
										$nb = position($infos_joueur, 'DA', $nb);
										$nb = position($infos_joueur, 'DG', $nb);
										$nb = position($infos_joueur, 'MD', $nb);
										$nb = position($infos_joueur, 'MA', $nb);
										$nb = position($infos_joueur, 'MG', $nb);
										$nb = position($infos_joueur, 'MDD', $nb);
										$nb = position($infos_joueur, 'MDA', $nb);
										$nb = position($infos_joueur, 'MDG', $nb);
										$nb = position($infos_joueur, 'MOD', $nb);
										$nb = position($infos_joueur, 'MOA', $nb);
										$nb = position($infos_joueur, 'MOG', $nb);
										$nb = position($infos_joueur, 'AD', $nb);
										$nb = position($infos_joueur, 'AA', $nb);
										$nb = position($infos_joueur, 'AG', $nb);
									?>
								</td>
								<td align="center">
									<?php 
										if($infos_joueur['Indisponible']) {
											echo 'Oui'; 
										}
										else {
											echo 'Non';
										}
									?>
								</td>
								<td>
									<a href="#null" onclick="javascript:open_joueur(<?php echo $infos_joueur['Id']; ?>);" class="black">Modifier</a>
								</td>
							</tr>
							<?php
								}
								$joueurs_BDD->closeCursor();
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="left1pct"></div>
		<div class="inline">
			<form action="odin.php" method="get">
			<input type="hidden" name="calcul" value="TRUE">
			<input type="hidden" name="module" value="smworld">
			<div class="formations">
				<div class="titre">
					<div class="lefttitre"></div>
					<input type="submit" value="Calculer les formations">
				</div>
				<div class="cadre_left">
					<div class="colonne">
						<?php
							if(isset($_GET['calcul'])) {
								$bdd->exec('UPDATE Formations SET Joueur = 0');
								// ---- Extraction de toutes les formations
								$liste_formations = $bdd->query('	SELECT Nom 
																	FROM Formations 
																	GROUP BY Nom');
								// ---- Pour chaque formation
								while($nom_formation = $liste_formations->fetch()) {
									// ---- Extraction de tous les postes qui composent la formation
									$liste_postes = $bdd->query('	SELECT Id, Poste 
																	FROM Formations 
																	WHERE Nom = \'' . $nom_formation['Nom'] . '\'');
									// ---- Pour chaque poste de la formation
									while($nom_poste = $liste_postes->fetch()) {
										// ---- Recherche du meilleur joueur
										$liste_joueurs = $bdd->query('	SELECT Id, Nom, Note 
																		FROM Joueurs
																		WHERE `' . $nom_poste['Poste'] . '` = 1
																		AND Selection = 0
																		AND Indisponible = 0
																		ORDER BY Note DESC
																		LIMIT 1');
										if($liste_joueurs) {
											$nom_joueur = $liste_joueurs->fetch();
											$bdd->exec('UPDATE Joueurs SET Selection = 1 WHERE Id = ' . $nom_joueur['Id']);
											$bdd->exec('UPDATE Formations SET Joueur = ' . $nom_joueur['Id'] . ' WHERE Id = ' . $nom_poste['Id']);
											$liste_joueurs->closeCursor();
										}
									}
									$bdd->exec('UPDATE Joueurs SET Selection = 0');
									$liste_postes->closeCursor();
								}
								$liste_formations->closeCursor();
								$liste_compositions = $bdd->query('	SELECT Formations.Nom, AVG(Joueurs.Note) AS Moyenne
																	FROM Joueurs, Formations
																	WHERE Formations.Joueur = Joueurs.Id
																	GROUP BY Formations.Nom
																	ORDER BY Moyenne DESC');
							
						?>
						<table border="1">
							<tr>
								<td>
									Formation
								</td>
								<td>
									Moyenne
								</td>
								<td>
									Action
								</td>
							</tr>
							<?php
								while($infos_composition = $liste_compositions->fetch()) {
									$effectif_compositions = $bdd->query('  SELECT Nom, COUNT(Joueur) AS Effectif
																			FROM Formations 
																			WHERE Joueur <> 0
																			AND Nom = \'' . $infos_composition['Nom'] . '\'');
									$nb_composition = $effectif_compositions->fetch();
									$effectif_compositions->closeCursor();
									if($nb_composition['Effectif'] == 11) {
							?>
							<tr>
								<td>
									<?php echo $infos_composition['Nom']; ?>
								</td>
								<td>
									<?php echo $infos_composition['Moyenne']; ?>
								</td>
								<td>
									<a href="#null" onclick="javascript:open_formation(<?php echo '\'' . $infos_composition['Nom'] . '\''; ?>);" class="black">Voir</a>
								</td>
							</tr>
							<?php
									}
								}
								$liste_compositions->closeCursor();
							?>
						</table>
						<?php
							}
							else {
								echo 'A calculer';
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>