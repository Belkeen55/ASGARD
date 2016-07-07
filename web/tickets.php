<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include("../modules/BDD.php");
	
	// ---- Gestion du POST
	if(isset($_POST['action'])) {
		if($_POST['action'] == 'add') {
			$bdd->exec('INSERT INTO Taches(Heurodatage, Titre, Commentaires, Id_Devs, Id_Etapes, Id_Modules) 
						VALUES(NOW(), \'' . str_replace('\'', '\'\'', $_POST['titre']) . '\', \'' . str_replace('\'', '\'\'', $_POST['commentaire']) . '\', ' . $_POST['type'] . ', 1, ' . $_POST['module'] . ')');
		}
		if($_POST['action'] == 'update') {
			if(($_POST['etape'] == 6) OR ($_POST['etape'] == 7)) {
				$bdd->exec('UPDATE Taches
							SET Titre = \'' . str_replace('\'', '\'\'', $_POST['titre']) . '\', 
							Commentaires = \'' . str_replace('\'', '\'\'', $_POST['commentaire']) . '\', 
							Id_Devs = ' . $_POST['type'] . ', 
							Id_Modules = ' . $_POST['module'] . ',
							Id_Etapes = ' . $_POST['etape'] . ', 
							Deploiement = NOW() 
							WHERE Id = ' . $_POST['id']);
			}
			else {
				$bdd->exec('UPDATE Taches
							SET Titre = \'' . str_replace('\'', '\'\'', $_POST['titre']) . '\', 
							Commentaires = \'' . str_replace('\'', '\'\'', $_POST['commentaire']) . '\', 
							Id_Devs = ' . $_POST['type'] . ', 
							Id_Modules = ' . $_POST['module'] . ',
							Id_Etapes = ' . $_POST['etape'] . ' 
							WHERE Id = ' . $_POST['id']);
			}
		}
		if($_POST['action'] == 'filter') {
			if($_POST['module'] <> 0) {
				$module = ' AND Modules.Id = ' . $_POST['module'];
			}
			else {
				$module = '';
			}
			if($_POST['type'] <> 0) {
				$type = ' AND Devs.Id = ' . $_POST['type'];
			}
			else {
				$type = '';
			}
			
			$i = False;
			
			if(isset($_POST['besoin'])) {
				$besoin = 'Etapes.Id = ' . $_POST['besoin'] . ' ';
				$i = True;
			}
			else {
				$besoin = '';
			}
			
			if(isset($_POST['analyse'])) {
				if($i) {
					$besoin = $besoin . 'OR ';
					$i = False;
				}
				$analyse = 'Etapes.Id = ' . $_POST['analyse'] . ' ';
				$i = True;
			}
			else {
				$analyse = '';
			}
			if(isset($_POST['conception'])) {
				if($i){
					$analyse = $analyse . 'OR ';
					$i = False;
				}
				$conception = 'Etapes.Id = ' . $_POST['conception'] . ' ';
				$i = True;
			}
			else {
				$conception = '';
			}
			
			if(isset($_POST['codage'])) {
				if($i){
					$conception = $conception . 'OR ';
					$i = False;
				}
				$codage = 'Etapes.Id = ' . $_POST['codage'] . ' ';
				$i = True;
			}
			else {
				$codage = '';
			}
			
			if(isset($_POST['tests'])) {
				if($i){
					$codage = $codage . 'OR ';
					$i = False;
				}
				$tests = 'Etapes.Id = ' . $_POST['tests'] . ' ';
				$i = True;
			}
			else {
				$tests = '';
			}
			
			if(isset($_POST['deploye'])) {
				if($i){
					$tests = $tests . 'OR ';
					$i = False;
				}
				$deploye = 'Etapes.Id = ' . $_POST['deploye'] . ' ';
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
	}
	else {
		$tickets_BDD = $bdd->query('SELECT Taches.Id, Taches.Heurodatage, Taches.Titre, Modules.Nom AS Module, Devs.Nom AS Type, Etapes.Nom AS Etape, Taches.Deploiement
									FROM Taches, Modules, Devs, Etapes
									WHERE Taches.Id_Devs = Devs.Id
									AND Taches.Id_Etapes = Etapes.Id
									AND Taches.Id_Modules = Modules.Id');
	}
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD</title>
    </head>
    <body>
		<!-- Tableau de page -->
		<table class="page">
			<tr align="center">
				<td>
				
				</td>
				<td>
					<img src="/img/banniere.png" height="200">
				</td>
			</tr>
			<?php
				if ($_SESSION['login'])	{
					// ---- Si l'utilisateur est loggé
			?>
			<tr>
				<!-- Chargement du menu de navigation -->
				<td class='taillemenu' valign="top" rowspan="3">
					<?php include('menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table>
						<tr>
							<td>
								Gestion des tickets
							</td>
						</tr>
						<tr>
							<td align="center">
								<form action="tickets/add.php" method="post">
									<input type="submit" value="Ajout ticket" />
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center">
					<img src="/img/vide.png" height="10">
					<table>
						<tr>
							<td colspan="9" align="center">
								Filtrer les tickets
							</td>
						</tr>
						<tr>
							<td>
								Modules
							</td>
							<td>
								Type
							</td>
							<td>
								Besoin
							</td>
							<td>
								Analyse
							</td>
							<td>
								Conception
							</td>
							<td>
								Codage
							</td>
							<td>
								Tests
							</td>
							<td>
								Deploye
							</td>
						</tr>
						<tr>
							<form action="tickets.php" method="post">
							<td>
								<select name="module">
									<option value="0">Module</option>
									<?php
										$modules_BDD = $bdd->query('SELECT Id, Nom
																	FROM Modules');
										while ($infos_module = $modules_BDD->fetch()) {
											if((isset($_POST['action'])) AND ($_POST['action'] == 'filter') AND ($infos_module['Id'] == $_POST['module']) ) {
												echo '<option value="' . $infos_module['Id'] . '" selected>' . $infos_module['Nom'] . '</option>';
											}
											else {
												echo '<option value="' . $infos_module['Id'] . '">' . $infos_module['Nom'] . '</option>';
											}
										}
										$modules_BDD->closeCursor();
									?>
								</select>
							</td>
							<td>
								<select name="type">
									<option value="0">Type</option>
									<?php
										$devs_BDD = $bdd->query('	SELECT Id, Nom
																	FROM Devs');
										while ($infos_dev = $devs_BDD->fetch()) {
											if((isset($_POST['action'])) AND ($_POST['action'] == 'filter') AND ($infos_dev['Id'] == $_POST['type']) ) {
												echo '<option value="' . $infos_dev['Id'] . '" selected>' . $infos_dev['Nom'] . '</option>';
											}
											else {
												echo '<option value="' . $infos_dev['Id'] . '">' . $infos_dev['Nom'] . '</option>';
											}
										}
										$devs_BDD->closeCursor();
									?>
								</select>
							</td>
							<td align="center">
								<input type="checkbox" name="besoin" value="1" 
								<?php
									if((isset($_POST['action'])) AND ($_POST['action'] == 'filter')) {
										if(isset($_POST['besoin'])) {
											echo 'checked';
										}
									}
									else {
										echo 'checked';
									}
								?>>
							</td>
							<td align="center">
								<input type="checkbox" name="analyse" value="2" 
								<?php
									if((isset($_POST['action'])) AND ($_POST['action'] == 'filter')) {
										if(isset($_POST['analyse'])) {
											echo 'checked';
										}
									}
									else {
										echo 'checked';
									}
								?>>
							</td>
							<td align="center">
								<input type="checkbox" name="conception" value="3" 
								<?php
									if((isset($_POST['action'])) AND ($_POST['action'] == 'filter')) {
										if(isset($_POST['conception'])) {
											echo 'checked';
										}
									}
									else {
										echo 'checked';
									}
								?>>
							</td>
							<td align="center">
								<input type="checkbox" name="codage" value="4" 
								<?php
									if((isset($_POST['action'])) AND ($_POST['action'] == 'filter')) {
										if(isset($_POST['codage'])) {
											echo 'checked';
										}
									}
									else {
										echo 'checked';
									}
								?>>
							</td>
							<td align="center">
								<input type="checkbox" name="tests" value="5" 
								<?php
									if((isset($_POST['action'])) AND ($_POST['action'] == 'filter')) {
										if(isset($_POST['tests'])) {
											echo 'checked';
										}
									}
									else {
										echo 'checked';
									}
								?>>
							</td>
							<td align="center">
								<input type="checkbox" name="deploye" value="6" 
								<?php
									if((isset($_POST['action'])) AND ($_POST['action'] == 'filter')) {
										if(isset($_POST['deploye'])) {
											echo 'checked';
										}
									}
									else {
										echo 'checked';
									}
								?>>
							</td>
							<td align="center">
								<input type="hidden" name="action" value="filter" />
								<input type="submit" value="Filtrer" />
							</td>
							</form>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center">
					<img src="/img/vide.png" height="10">
					<table border="1">
						<tr>
							<td colspan="8">
								Liste des tickets
							</td>
						</tr>
						<tr>
							<td>
								Id
							</td>
							<td>
								Creation
							</td>
							<td>
								Titre
							</td>
							<td>
								Module
							</td>
							<td>
								Type
							</td>
							<td>
								Etat
							</td>
							<td>
								Deploiement
							</td>
							<td>
								Action
							</td>
						</tr>
						<?php
							while($infos_ticket = $tickets_BDD->fetch()) {
							?>
						<tr>
							<td align="center">
								<?php echo $infos_ticket['Id']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Heurodatage']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Titre']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Module']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Type']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Etape']; ?>
							</td>
							<td align="center">
								<?php 
									if($infos_ticket['Deploiement'] == NULL) {
										echo 'NA';
									}
									else
									{
										echo $infos_ticket['Deploiement']; 
									}
								?>
							</td>
							<td>
								<form action="tickets/view.php" method="post">
									<input type="hidden" name="id" value="<?php echo $infos_ticket['Id']; ?>" />
									<input type="submit" value="Ouvrir" />
								</form>
							</td>
						</tr>
						<?php
							}
							$tickets_BDD->closeCursor();
						?>
					</table>
					<?php
						}
						else
						{
							echo "<script type='text/javascript'>document.location.replace('../../index.php');</script>";
						}
					?>
				</td>
			</tr>
		</table>

    </body>
</html>