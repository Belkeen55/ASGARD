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
								echo '<option value="' . $infos_module['Id'] . '">' . $infos_module['Nom'] . '</option>';
							}
							$modules_BDD->closeCursor();
						?>
					</select>
				</div>
				<div class="lefttitre"></div>
				<div class="inline">
					<input type="text" name="titre" size="50" value="Titre du ticket" />
				</div>
			</div>
			<div class="liner"></div>
			<div class="liner"></div>
			<div class="line">
				<div class="inline">
					<textarea name="commentaire" rows="10" cols="70">Ajouter un commentaire</textarea>
				</div>
			</div>
		</div>
		<div class="lefttitre"></div>
		<div class="colonne">
			<div class="colonne">
				<div class="line">Type</div>
			</div>
			<div class="lefttitre"></div>
			<div class="colonne">
				<div class="line">
					<select name="type">
						<?php
							$devs_BDD = $bdd->query('	SELECT Id, Nom
														FROM Devs');
							while ($infos_dev = $devs_BDD->fetch()) {
								echo '<option value="' . $infos_dev['Id'] . '">' . $infos_dev['Nom'] . '</option>';
							}
							$devs_BDD->closeCursor();
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="liner"></div>
	<div class="line">
		<div class="colonne">
			<input type="hidden" name="action" value="addok" />
			<input type="hidden" name="module" value="tickets" />
			<input type="submit" value="Creer" />
</form>
		</div>
		<div class="colonne">
			<form action="odin.php" method="get">
				<input type="hidden" name="module" value="tickets" />
				<input type="submit" value="Retour" />
			</form>
		</div>
	</div>
