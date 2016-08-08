<div class="inline">
	<form action="odin.php" method="get">
		<div class="colonne">
			<div class="line">
				<div class="inline-90px">Filtres</div>
			</div>
			<div class="liner"></div>
			<div class="line">
				<div class="inline-90px">Modules</div>
				<div class="inline-90px">
					<select name="devmodule">
						<option value="0">Module</option>
						<?php
							$modules_BDD = $bdd->query('SELECT Id, Nom
														FROM Modules');
							while ($infos_module = $modules_BDD->fetch()) {
								if((isset($_GET['action'])) AND ($_GET['action'] == 'filter') AND ($infos_module['Id'] == $_GET['devmodule']) ) {
									echo '<option value="' . $infos_module['Id'] . '" selected>' . $infos_module['Nom'] . '</option>';
								}
								else {
									echo '<option value="' . $infos_module['Id'] . '">' . $infos_module['Nom'] . '</option>';
								}
							}
							$modules_BDD->closeCursor();
						?>
					</select>
				</div>
			</div>
			<div class="line">
				<div class="inline-90px">Type</div>
				<div class="inline-90px">
					<select name="type">
						<option value="0">Type</option>
						<?php
							$devs_BDD = $bdd->query('	SELECT Id, Nom
														FROM Devs');
							while ($infos_dev = $devs_BDD->fetch()) {
								if((isset($_GET['action'])) AND ($_GET['action'] == 'filter') AND ($infos_dev['Id'] == $_GET['type']) ) {
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
			</div>
			<div class="line">
				<div class="inline-90px">Besoin</div>
				<div class="inline-90px">
					<input type="checkbox" name="besoin" value="1" 
						<?php
							if((isset($_GET['action'])) AND ($_GET['action'] == 'filter')) {
								if(isset($_GET['besoin'])) {
									echo 'checked';
								}
							}
							else {
								echo 'checked';
							}
						?>>
				</div>
			</div>
			<div class="line">
				<div class="inline-90px">Analyse</div>
				<div class="inline-90px">
					<input type="checkbox" name="analyse" value="2" 
					<?php
						if((isset($_GET['action'])) AND ($_GET['action'] == 'filter')) {
							if(isset($_GET['analyse'])) {
								echo 'checked';
							}
						}
						else {
							echo 'checked';
						}
					?>>
				</div>
			</div>
			<div class="line">
				<div class="inline-90px">Conception</div>
				<div class="inline-90px">
					<input type="checkbox" name="conception" value="3" 
						<?php
							if((isset($_GET['action'])) AND ($_GET['action'] == 'filter')) {
								if(isset($_GET['conception'])) {
									echo 'checked';
								}
							}
							else {
								echo 'checked';
							}
						?>>
				</div>
			</div>
			<div class="line">
				<div class="inline-90px">Codage</div>
				<div class="inline-90px">
					<input type="checkbox" name="codage" value="4" 
						<?php
							if((isset($_GET['action'])) AND ($_GET['action'] == 'filter')) {
								if(isset($_GET['codage'])) {
									echo 'checked';
								}
							}
							else {
								echo 'checked';
							}
						?>>
				</div>	
			</div>
			<div class="line">
				<div class="inline-90px">Tests</div>
				<div class="inline-90px">
					<input type="checkbox" name="tests" value="5" 
						<?php
							if((isset($_GET['action'])) AND ($_GET['action'] == 'filter')) {
								if(isset($_GET['tests'])) {
									echo 'checked';
								}
							}
							else {
								echo 'checked';
							}
						?>>
				</div>
			</div>
			<div class="line">
				<div class="inline-90px">Deploye</div>
				<div class="inline-90px">
					<input type="checkbox" name="deploye" value="6" 
						<?php
							if((isset($_GET['action'])) AND ($_GET['action'] == 'filter')) {
								if(isset($_GET['deploye'])) {
									echo 'checked';
								}
							}
							else {
								echo 'checked';
							}
						?>>
				</div>
			</div>
			<div class="liner"></div>
			<div class="line">
				<input type="hidden" name="action" value="filter" />
				<input type="hidden" name="module" value="tickets" />
				<input type="submit" value="Filtrer" />
			</div>
		</div>
	</form>
</div>
<div class="left1pct"></div>
<div class="inline">
<?php
	if(isset($_GET['action'])) {
		if($_GET['action'] == 'update') {
			if(($_GET['etape'] == 6) OR ($_GET['etape'] == 7)) {
				$bdd->exec('UPDATE Taches
							SET Titre = \'' . str_replace('\'', '\'\'', $_GET['titre']) . '\', 
							Commentaires = \'' . str_replace('\'', '\'\'', $_GET['commentaire']) . '\', 
							Id_Devs = ' . $_GET['type'] . ', 
							Id_Modules = ' . $_GET['devmodule'] . ',
							Id_Etapes = ' . $_GET['etape'] . ', 
							Deploiement = NOW() 
							WHERE Id = ' . $_GET['id']);
			}
			else {
				$bdd->exec('UPDATE Taches
							SET Titre = \'' . str_replace('\'', '\'\'', $_GET['titre']) . '\', 
							Commentaires = \'' . str_replace('\'', '\'\'', $_GET['commentaire']) . '\', 
							Id_Devs = ' . $_GET['type'] . ', 
							Id_Modules = ' . $_GET['devmodule'] . ',
							Id_Etapes = ' . $_GET['etape'] . ' 
							WHERE Id = ' . $_GET['id']);
			}
		}
		if($_GET['action'] == 'delete') {
			$bdd->exec('DELETE FROM Taches WHERE Id = ' . $_GET['id']);
		}
		if($_GET['action'] == 'filter') {
			if($_GET['devmodule'] <> 0) {
				$module = ' AND Modules.Id = ' . $_GET['devmodule'];
			}
			else {
				$module = '';
			}
			if($_GET['type'] <> 0) {
				$type = ' AND Devs.Id = ' . $_GET['type'];
			}
			else {
				$type = '';
			}
			
			$i = False;
			
			if(isset($_GET['besoin'])) {
				$besoin = 'Etapes.Id = ' . $_GET['besoin'] . ' ';
				$i = True;
			}
			else {
				$besoin = '';
			}
			
			if(isset($_GET['analyse'])) {
				if($i) {
					$besoin = $besoin . 'OR ';
					$i = False;
				}
				$analyse = 'Etapes.Id = ' . $_GET['analyse'] . ' ';
				$i = True;
			}
			else {
				$analyse = '';
			}
			if(isset($_GET['conception'])) {
				if($i){
					$analyse = $analyse . 'OR ';
					$i = False;
				}
				$conception = 'Etapes.Id = ' . $_GET['conception'] . ' ';
				$i = True;
			}
			else {
				$conception = '';
			}
			
			if(isset($_GET['codage'])) {
				if($i){
					$conception = $conception . 'OR ';
					$i = False;
				}
				$codage = 'Etapes.Id = ' . $_GET['codage'] . ' ';
				$i = True;
			}
			else {
				$codage = '';
			}
			
			if(isset($_GET['tests'])) {
				if($i){
					$codage = $codage . 'OR ';
					$i = False;
				}
				$tests = 'Etapes.Id = ' . $_GET['tests'] . ' ';
				$i = True;
			}
			else {
				$tests = '';
			}
			
			if(isset($_GET['deploye'])) {
				if($i){
					$tests = $tests . 'OR ';
					$i = False;
				}
				$deploye = 'Etapes.Id = ' . $_GET['deploye'] . ' ';
				$i = True;
			}
			else {
				$deploye = '';
			}
			
			$tickets_BDD = $bdd->query('SELECT Taches.Id, Taches.Heurodatage, Taches.Titre, Modules.Nom AS Module, Devs.Nom AS Type, Etapes.Nom AS Etape, Taches.Deploiement
										FROM Taches, Modules, Devs, Etapes
										WHERE Taches.Id_Devs = Devs.Id
										AND Taches.Id_Etapes = Etapes.Id
										AND Taches.Id_Modules = Modules.Id' . $module . $type .
										' AND(' . $besoin . $analyse . $conception . $codage . $tests . $deploye .
										')');
		}
		else {
			$tickets_BDD = $bdd->query('SELECT Taches.Id, Taches.Heurodatage, Taches.Titre, Modules.Nom AS Module, Devs.Nom AS Type, Etapes.Nom AS Etape, Taches.Deploiement
								FROM Taches, Modules, Devs, Etapes
								WHERE Taches.Id_Devs = Devs.Id
								AND Taches.Id_Etapes = Etapes.Id
								AND Taches.Id_Modules = Modules.Id');
		}
	}
	else {
		$tickets_BDD = $bdd->query('SELECT Taches.Id, Taches.Heurodatage, Taches.Titre, Modules.Nom AS Module, Devs.Nom AS Type, Etapes.Nom AS Etape, Taches.Deploiement
									FROM Taches, Modules, Devs, Etapes
									WHERE Taches.Id_Devs = Devs.Id
									AND Taches.Id_Etapes = Etapes.Id
									AND Taches.Id_Modules = Modules.Id');
	}
	while($infos_ticket = $tickets_BDD->fetch()) {
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
	<div class="line">
		<div class="inline"><div class="<?php echo $type; ?>"><?php echo $infos_ticket['Type'][0]; ?></div></div>
		<div class="lefttitre"></div>
		<a href="/Odin/odin.php?module=tickets&id=<?php echo $infos_ticket['Id']; ?>" class="<?php echo $etat; ?>">
			<div class="inline-90px"><?php echo $infos_ticket['Module']; ?>-<?php echo $infos_ticket['Id']; ?></div>
			<div class="lefttitre"></div>
			<div class="inline-350px"><?php echo $infos_ticket['Titre']; ?></div>
			<div class="lefttitre"></div>
			<div class="inline"><?php echo $infos_ticket['Etape']; ?></div>
		</a>
		<div class="greyline"></div>
	</div>
<?php
	}
	$tickets_BDD->closeCursor();
?>
</div>