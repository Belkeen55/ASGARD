<?php
	if($_GET['action'] == 'view') {
		if(isset($_GET['add'])) {
			$bdd->exec('INSERT INTO Liste_Courses(Id, Id_Produit, Quantite, Fait) 
						VALUES(NULL, ' . $_GET['add'] . ',1, 0)');
		}
		if(isset($_GET['truncate'])) {
			$bdd->exec('TRUNCATE Liste_Courses');
		}
		$liste_BDD = $bdd->query('	SELECT Rayons.Nom AS Rayon, Produits.Nom, Liste_Courses.Quantite, Liste_Courses.Fait
											FROM Produits, Rayons, Liste_Courses
											WHERE Produits.Id_Rayon = Rayons.Id
											AND Liste_Courses.Id_Produit = Produits.Id
											ORDER BY Rayons.Nom, Produits.Nom');
?>
		<div class="line">
			<div class="display_center">
				<div class="inline">
					<div class="joueurs">
						<div class="titre_sonde">
							<div class="lefttitre"></div>
							<div class="espace_titre">Liste des courses</div>
							<a href="/Odin/odin.php?module=liste_courses&action=view&truncate=true"><img src="/img/purge.png" class="image_action"></img></a>
							<a href="/Odin/odin.php?module=liste_courses&action=add"><img src="/img/add.png" class="image_action"></img></a>
						</div>
						<div class="cadre_left">
							<div class="colonne">
								<ul>
									<?php
										$rayon_precedent = '';
										$i = 0;
										while ($infos_liste = $liste_BDD->fetch()) {
											if(($infos_liste['Rayon'] != $rayon_precedent)) {
												if($i != 0) {
													echo '</ul></li>';
												}
												echo '<li>' . $infos_liste['Rayon'] . '<ul>';
												$i = 1;
												$rayon_precedent = $infos_liste['Rayon'];
											}
											echo '<li>' . $infos_liste['Nom'] . '</li>';
										}
										echo '</ul></li>'
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	if($_GET['action'] == 'add') {
		if(isset($_GET['new'])) {
			$bdd->exec('INSERT INTO Produits(Id, Nom, Id_Rayon) 
						VALUES(NULL, \'' . $_GET['nom'] . '\', ' . $_GET['rayon'] . ')');
		}
?>
		<div class="line">
			<div class="display_center">
				<div class="inline">
					<div class="joueurs">
						<div class="titre_sonde">
							<div class="lefttitre"></div>
							<div class="espace_titre">Ajouter à la liste</div>
							<a href="/Odin/odin.php?module=liste_courses&action=create&item=produit" class="black">Créer</a>
						</div>
						<div class="cadre_left">
							<div class="colonne">
								<ul>
									<?php
										$rayons_BDD = $bdd->query('	SELECT *
																	FROM Rayons
																	ORDER BY Nom');
										while ($infos_rayon = $rayons_BDD->fetch()) {
											echo '<li>' . $infos_rayon['Nom'];
											$produits_BDD = $bdd->query('	SELECT *
																			FROM Produits
																			WHERE Id_Rayon = ' . $infos_rayon['Id'] . '
																			ORDER BY Nom');
											echo '<ul>';
											while ($infos_produit = $produits_BDD->fetch()) {
												echo '<a href="/Odin/odin.php?module=liste_courses&action=view&add=' . $infos_produit['Id'] . '" class="black"><li>' . $infos_produit['Nom'] . '</li></a>';
											}
											$produits_BDD->closeCursor();
											echo '</ul></li>';
										}
										$rayons_BDD->closeCursor();
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	if($_GET['action'] == 'create') {
		if($_GET['item'] == 'produit') {
			if(isset($_GET['new'])) {
				$bdd->exec('INSERT INTO Rayons(Id, Nom) 
							VALUES(NULL, \'' . $_GET['nom'] . '\')');
			}
?>
			<div class="line">
				<div class="display_center">
					<div class="inline">
						<div class="joueurs">
							<div class="titre_sonde">
								<div class="lefttitre"></div>
								<div class="espace_titre">Créer un produit</div>
							</div>
							<div class="cadre_left">
								<div class="lefttitre"></div>
								<div class="colonne">
									<div class="line">
										<div class="colonne">
											<div class="liner"></div>
												<form action="odin.php" method="get">
													<select name="rayon">
														<?php
															$rayons_BDD = $bdd->query('	SELECT *
																						FROM Rayons
																						ORDER BY Nom');
															while ($infos_rayon = $rayons_BDD->fetch()) {
																echo '<option value="' . $infos_rayon['Id'] . '">' . $infos_rayon['Nom'] . '</option>';
															}
															$rayons_BDD->closeCursor();
														?>
													</select>
											</div>
											<div class="colonne">
												<a href="/Odin/odin.php?module=liste_courses&action=create&item=rayon" class="black">Ajouter un rayon</a>
											</div>
										</div>
										<div class="liner"></div>
										<div class="line">
											Nom du Produit : <input type="text" name="nom">
										</div>
										<div class="liner"></div>
										<div class="line">
											<div class="inline">
													<input type="hidden" name="module" value="liste_courses">
													<input type="hidden" name="action" value="add">
													<input type="hidden" name="item" value="produit">
													<input type="hidden" name="new" value="true">
													<input type="submit" value="Ajouter">
												</form>
											</div>
											<div class="inline">
												<form action="odin.php" method="get">
													<input type="hidden" name="module" value="liste_courses">
													<input type="hidden" name="action" value="add">
													<input type="submit" value="Annuler">
												</form>
											</div>
										</div>
										<div class="liner"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
		}
		if($_GET['item'] == 'rayon') {
?>
			<div class="line">
				<div class="display_center">
					<div class="inline">
						<div class="joueurs">
							<div class="titre_sonde">
								<div class="lefttitre"></div>
								<div class="espace_titre">Créer un rayon</div>
							</div>
							<div class="cadre_left">
								<div class="lefttitre"></div>
								<div class="colonne">
									<div class="line">
										<div class="colonne">
											<div class="liner"></div>
											<form action="odin.php" method="get">
										<div class="line">
											Nom du rayon : <input type="text" name="nom">
										</div>
										<div class="liner"></div>
										<div class="line">
											<div class="inline">
													<input type="hidden" name="module" value="liste_courses">
													<input type="hidden" name="action" value="create">
													<input type="hidden" name="item" value="produit">
													<input type="hidden" name="new" value="true">
													<input type="submit" value="Ajouter">
												</form>
											</div>
											<div class="inline">
												<form action="odin.php" method="get">
													<input type="hidden" name="module" value="liste_courses">
													<input type="hidden" name="action" value="create">
													<input type="hidden" name="item" value="produit">
													<input type="submit" value="Annuler">
												</form>
											</div>
										</div>
										<div class="liner"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
		}
	}
?>