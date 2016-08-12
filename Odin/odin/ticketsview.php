<?php
	$tickets_BDD = $bdd->query('SELECT Taches.Id, Taches.Heurodatage, Taches.Titre, Modules.Nom AS Module, Devs.Nom AS Type, Etapes.Nom AS Etape, Taches.Deploiement, Taches.Commentaires, Taches.Id_Modules, Taches.Id_Devs, Taches.Id_Etapes
								FROM Taches, Modules, Devs, Etapes
								WHERE Taches.Id_Devs = Devs.Id
								AND Taches.Id_Etapes = Etapes.Id
								AND Taches.Id_Modules = Modules.Id
								AND Taches.Id = ' . $_GET['id']);
	$infos_ticket = $tickets_BDD->fetch();
	if($infos_ticket['Type'][0] == 'B') {
		$type = 'bug';
	}
	else {
		$type = 'feature';
	}
	if($infos_ticket['Type'][0] == 'B') {
		$type = 'bug';
	}
	else {
		$type = 'feature';
	}
	if($infos_ticket['Deploiement'] == NULL) {
		$etat = 'black';
	}
	else {
		$etat = 'fini';
	}
?>
<form action="odin.php" method="get">
	<div class="line">
		<div class="colonne">
			<div class="line">
				<div class="inline">
					<select name="devmodule">
						<?php
							$modules_BDD = $bdd->query('SELECT Id, Nom
														FROM Modules');
							while ($infos_module = $modules_BDD->fetch()) {
								if($infos_module['Id'] == $infos_ticket['Id_Modules']) {
									echo '<option value="' . $infos_module['Id'] . '" selected>' . $infos_module['Nom'] . '</option>';
								}
								else {
									echo '<option value="' . $infos_module['Id'] . '">' . $infos_module['Nom'] . '</option>';
								}
							}
							$modules_BDD->closeCursor();
						?>
					</select>
					-<?php echo $infos_ticket['Id']; ?>
				</div>
				<div class="lefttitre"></div>
				<div class="inline">
					<input type="text" name="titre" size="50" value="<?php echo $infos_ticket['Titre']; ?>" />
				</div>
			</div>
			<div class="liner"></div>
			<div class="liner"></div>
			<div class="line">
				<div class="inline">
					<textarea name="commentaire" rows="10" cols="70"><?php echo $infos_ticket['Commentaires']; ?></textarea>
				</div>
			</div>
		</div>
		<div class="lefttitre"></div>
		<div class="colonne">
			<div class="colonne">
				<div class="line">Type</div>
				<div class="liner"></div>
				<div class="line">Etape</div>
			</div>
			<div class="lefttitre"></div>
			<div class="colonne">
				<div class="line">
					<select name="type">
						<?php
							$devs_BDD = $bdd->query('	SELECT Id, Nom
														FROM Devs');
							while ($infos_dev = $devs_BDD->fetch()) {
								if($infos_dev['Id'] == $infos_ticket['Id_Devs']) {
									echo '<option value="' . $infos_dev['Id'] . '" selected>' . $infos_dev['Nom'] . '</option>';
								}
								else {
									echo '<option value="' . $infos_dev['Id'] . '">' . $infos_dev['Nom'] . '</option>';
								}
							}
							$devs_BDD->closeCursor();
						?>
					</select>
				</div>
				<div class="liner"></div>
				<div class="line">
					<select name="etape">
						<?php
							$etapes_BDD = $bdd->query('SELECT Id, Nom
														FROM Etapes');
							while ($infos_etape = $etapes_BDD->fetch()) {
								if($infos_etape['Id'] == $infos_ticket['Id_Etapes']) {
									echo '<option value="' . $infos_etape['Id'] . '" selected>' . $infos_etape['Nom'] . '</option>';
								}
								else {
									echo '<option value="' . $infos_etape['Id'] . '">' . $infos_etape['Nom'] . '</option>';
								}
							}
							$etapes_BDD->closeCursor();
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="liner"></div>
	<div class="line">
		<div class="colonne">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="module" value="tickets" />
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
			<input type="submit" value="Update" />
</form>
		</div>
		<div class="colonne">
			<form action="odin.php" method="get">
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
				<input type="hidden" name="module" value="tickets" />
				<input type="submit" value="Delete" />
			</form>
		</div>
		<div class="colonne">
			<form action="odin.php" method="get">
				<input type="hidden" name="module" value="tickets" />
				<input type="submit" value="Retour" />
			</form>
		</div>
	</div>
